@extends('layouts.admin')

@section('title', 'Akun')

@push('styles')
<style>
    .bg-primary-soft { background: rgba(13,110,253,.15); }
    .bg-success-soft { background: rgba(25,135,84,.15); }
    .bg-dark-soft    { background: rgba(33, 37, 41, 0.15); }
    .table tbody tr:hover { background: #fafbff }
</style>
@endpush

@section('content')
<div class="content-wrapper">

    {{-- Header halaman --}}
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h2 class="fw-semibold mb-1">Manajemen Akun</h2>
            <p class="text-muted mb-0" style="max-width:420px">
                Kelola data akun pengguna dan admin dari sistem aplikasi PD.Brantas.
            </p>
        </div>

        {{-- Tombol tambah akun baru --}}
        <a href="{{ route('admin.akun.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus me-1"></i> Tambah Akun
        </a>
    </div>

    {{-- Jumlah akun --}}
    <div class="row g-3 mb-4">
        <div class="col-12 col-md-4">
            <div class="card card-stat shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <span class="icon rounded bg-primary-soft d-inline-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-users text-primary"></i>
                        </span>
                        <h4 class="fw-bold mb-0">{{ $totalUser }}</h4>
                    </div>
                    <small class="text-muted">Total Akun</small>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card card-stat shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <span class="icon rounded bg-success-soft d-inline-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-user-shield text-success"></i>
                        </span>
                        <h4 class="fw-bold mb-0">{{ $totalAdmin }}</h4>
                    </div>
                    <small class="text-muted">Total Admin</small>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card card-stat shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <span class="icon rounded bg-dark-soft d-inline-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-user text-dark"></i>
                        </span>
                        <h4 class="fw-bold mb-0">{{ $totalUserNonAdmin }}</h4>
                    </div>
                    <small class="text-muted">Total Pengguna</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Form pencarian akun --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body pb-1">
            <form class="row gx-3 gy-2 align-items-center mb-3" action="{{ route('admin.akun.index') }}" method="get">
                <div class="col-auto flex-grow-1">
                    <input class="form-control" type="search" name="katakunci" value="{{ Request::get('katakunci') }}" placeholder="Cari nama atau email">
                </div>
                <div class="col-auto">
                    <button class="btn btn-secondary" type="submit">Cari</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabel data akun --}}
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Alamat</th>
                        <th>Role</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $index => $user)
                    <tr>
                        <td>{{ $users->firstItem() + $index }}</td>

                        {{-- Foto profil --}}
                        <td>
                            @if($user->profile_picture && file_exists(public_path('storage/' . $user->profile_picture)))
                                <img src="{{ asset('storage/' . $user->profile_picture) }}"
                                    alt="Foto"
                                    style="width: 48px; height: 48px; object-fit: cover; border-radius: 50%;">
                            @else
                                <div style="width: 48px; height: 48px; background-color: #ccc; border-radius: 50%;"></div>
                            @endif
                        </td>

                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->address ?? '-' }}</td>
                        <td>{{ $user->role }}</td>
                        <td class="text-center">
                            <a href="{{ route('admin.akun.edit', $user->id) }}" class="btn btn-sm btn-warning text-white me-1">Edit</a>
                            <form action="{{ route('admin.akun.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">Data tidak ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Navigasi --}}
        <div class="d-flex justify-content-between align-items-center mt-3">
            <small class="text-muted">
                Menampilkan {{ $users->firstItem() }} - {{ $users->lastItem() }} dari {{ $users->total() }} entri
            </small>
            {{ $users->links() }}
        </div>
    </div>

</div>
@endsection
