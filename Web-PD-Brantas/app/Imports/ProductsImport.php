<?php
namespace App\Imports;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductsImport implements ToModel
{
    public function model(array $row)
    {
        return new Product([
            'name'        => $row[0],
            'description' => $row[1],
            'price'       => $row[2],
            'stock'       => $row[3],
            'category'    => $row[4],
            'image'       => 'products/' . $row[5], // nama file gambar
            // 'sold'     => $row[6], // optional, bisa diskip
        ]);
    }

    public function headingRow(): int
    {
        return 1; // baris pertama adalah header
    }
}
