@extends('admin.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Update {{ $user->name }}</h1>
    </div>

    <a href="{{ url('/admin/users') }}" class="btn btn-link ml-0"><i class="bi bi-arrow-left"></i> Back</a>

    <form action="/admin/users/{{ $user->uuid }}" method="post">
        @method('put')
        @csrf
        {{-- Name --}}
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Name" required
                value="{{ $user->name }}">
        </div>

        {{-- Email --}}
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Email" required
                value="{{ $user->email }}">
        </div>

        {{-- Password --}}
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="text" class="form-control" id="password" name="password" placeholder="Password">
        </div>

        {{-- Telephone --}}
        <div class="mb-3">
            <label for="telephone" class="form-label">Telephone</label>
            <input type="text" class="form-control" id="telephone" name="telephone" placeholder="Telephone" required
                value="{{ $user->telephone }}">
        </div>

        {{-- Submit --}}
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
@endsection
