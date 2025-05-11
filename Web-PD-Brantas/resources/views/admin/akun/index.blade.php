@extends('layouts.admin')

@section('content')
<div class="my-3 p-3 bg-body rounded shadow-sm">

    <!-- FORM PENCARIAN -->
    <div class="pb-3">
        <form class="d-flex" action="{{ route('admin.akun.index') }}" method="get">
          <input class="form-control me-1" type="search" name="katakunci" value="{{ Request::get('katakunci') }}" placeholder="Cari nama atau email">
          <button class="btn btn-secondary" type="submit">Cari</button>
      </form>
    </div>

    <!-- TABEL DATA USER -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $index => $user)
            <tr>
                <td>{{ $users->firstItem() + $index }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role }}</td>
                <td>
                    <a href="{{ route('admin.akun.edit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('admin.akun.destroy', $user->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="5">Data tidak ditemukan.</td></tr>
            @endforelse
        </tbody>
    </table>

    <!-- PAGINATION -->
    <div class="mt-3">
        {{ $users->links() }}
    </div>

</div>
@endsection