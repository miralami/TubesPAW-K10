<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Carbon;

class ProductController extends Controller
{
    // Daftar produk (admin)

public function index(Request $request)
{
    // 1. Query dinamis: search di name/description, filter category
    $query = Product::query();

    if ($request->filled('search')) {
        $q = $request->search;
        $query->where(function($qr) use ($q) {
            $qr->where('name', 'like', "%{$q}%")
               ->orWhere('description', 'like', "%{$q}%");
        });
    }

    if ($request->filled('category')) {
        $query->where('category', $request->category);
    }

    // 2. Pagination (10 per halaman)
    $products = $query
    ->orderByDesc('created_at')
    ->paginate(10)          // ← numeric pagination
    ->appends($request->query());


    // 3. Statistik sederhana (jika masih dipakai)
    $totalProduct = Product::count();
    $newProduct   = Product::where('created_at', '>=', Carbon::now()->subDays(7))->count();
    $lowStock     = Product::where('stock', '<=', 5)->count();
    $outOfStock   = Product::where('stock', 0)->count();

    // 4. List kategori untuk dropdown
    $categories = Product::select('category')
                         ->distinct()
                         ->pluck('category');

    return view('admin.products.index', compact(
        'products',
        'totalProduct', 'newProduct', 'lowStock', 'outOfStock',
        'categories'
    ));
}

    // Simpan produk baru (dengan upload gambar)
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:100',
            'description' => 'nullable|string',
            'price'       => 'required|numeric',
            'stock'       => 'required|integer',
            'category'    => 'required|string|max:50',
            'image'       => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);
        return redirect()->route('admin.products.index')
                         ->with('success', 'Produk berhasil ditambahkan.');
    }

    // Update produk (dengan hapus gambar lama jika ada)
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:100',
            'description' => 'nullable|string',
            'price'       => 'required|numeric',
            'stock'       => 'required|integer',
            'category'    => 'required|string|max:50',
            'image'       => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);
        return redirect()->route('admin.products.index')
                         ->with('success', 'Produk berhasil diperbarui.');
    }

    // Hapus produk beserta gambarnya
    public function destroy(Product $product)
    {
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();
        return redirect()->route('admin.products.index')
                         ->with('success', 'Produk berhasil dihapus.');
    }

    // Tampilkan detail produk (publik) beserta review
    public function show($id)
    {
        $product = Product::findOrFail($id);
        $reviews = $product->reviews;
        return view('products.show', compact('product', 'reviews'));
    }

    // Simpan review baru
    public function storeReview(Request $request, Product $product)
    {
        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $product->reviews()->create([
            'user_id' => Auth::id(),
            'rating'  => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('products.show', $product->id)
                         ->with('success', 'Review berhasil ditambahkan.');
    }

    // Import produk dari file Excel/CSV
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        // Simpan sementara dan dapatkan path
        $path = $request->file('file')->store('imports');
        $filePath = storage_path('app/' . $path);

        // Baca spreadsheet
        $reader = IOFactory::createReaderForFile($filePath);
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($filePath);
        $rows = $spreadsheet->getActiveSheet()->toArray();

        // Jika hanya header, langsung return
        if (count($rows) <= 1) {
            return back()->with('success', 'Tidak ada data untuk diimport.');
        }

        // Normalisasi header
        $rawHeader = $rows[0];
        $header = array_map(fn($h) => strtolower(str_replace(' ', '_', trim($h))), $rawHeader);

        // Pemetaan header ke field DB
        $map = [
            'nama'      => 'name',
            'deskripsi' => 'description',
            'harga'     => 'price',
            'stok'      => 'stock',
            'kategori'  => 'category',
            'gambar'    => 'image',
        ];

        $imported = 0;
        // Proses baris data
        for ($i = 1, $cnt = count($rows); $i < $cnt; $i++) {
            $row = $rows[$i];
            if (!array_filter($row)) continue;

            $rowAssoc = array_combine($header, $row);
            $data = [];
            foreach ($map as $col => $field) {
                if (!isset($rowAssoc[$col])) continue;
                $value = $rowAssoc[$col];
                if ($field === 'price') {
                    $value = preg_replace('/[^\d]/', '', $value);
                    $value = (float) $value;
                }
                if ($field === 'stock') {
                    $value = (int) $value;
                }
                $data[$field] = $value;
            }
            if (empty($data['name']) || !isset($data['price'])) continue;

            Product::updateOrCreate(
                ['name' => $data['name']],
                $data
            );
            $imported++;
        }

        return back()->with('success', "Berhasil mengimpor {$imported} produk.");
    }

    // Export produk ke Excel via PhpSpreadsheet
    public function export()
    {
        $products = Product::select('name', 'price', 'stock', 'category', 'image', 'description')
                           ->get()
                           ->toArray();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $headers = ['Nama', 'Harga', 'Stok', 'Kategori', 'Gambar', 'Deskripsi'];
        $sheet->fromArray($headers, null, 'A1');
        $sheet->fromArray($products, null, 'A2');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'products_' . now()->format('Ymd_His') . '.xlsx';

        return new StreamedResponse(function() use ($writer) {
            $writer->save('php://output');
        }, 200, [
            'Content-Type'        => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Cache-Control'       => 'max-age=0',
        ]);
    }
}
