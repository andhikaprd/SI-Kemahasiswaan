@extends('layouts.app')

@section('title', 'Edit Account')

@section('content')
<div class="container">
    <h2 class="mb-3">Edit Account</h2>

    <form action="{{ route('account.update', $account->id_akun) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" class="form-control" value="{{ old('username', $account->username) }}" required>
            @error('username') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $account->email) }}" required>
            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password (Kosongkan jika tidak diganti)</label>
            <input type="password" name="password" class="form-control">
            @error('password') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('account.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
