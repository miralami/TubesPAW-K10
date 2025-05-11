@extends('layouts.admin')

@section('title', 'Edit Akun')

@section('content')
<div class="container my-4">
    <h2>Edit Akun</h2>

    <form action="{{ route('admin.akun.update', $user->id) }}" method="POST" class="mt-4" style="max-width: 600px;">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nama:</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Telepon:</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
        </div>

        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        <a href="{{ route('admin.akun.index') }}" class="btn btn-secondary ms-2">Batal</a>
    </form>
</div>
@endsection
