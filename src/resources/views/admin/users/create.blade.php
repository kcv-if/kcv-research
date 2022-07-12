@extends('admin.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">Create New User</h1>
</div>

<a href="{{ url('/admin/users') }}" class="btn btn-link ml-0"><i class="bi bi-arrow-left"></i> Back</a>

<form action="/admin/users" method="post">
  @csrf
  {{-- Role --}}
  <div class="mb-3">
    <label for="role" class="form-label">Role</label>
    <select class="form-select" aria-label="Role" id="role" name="role">
      <option value="u" selected>User</option>
      <option value="a">Admin</option>
    </select>
  </div>
  
  {{-- Name --}}
  <div class="mb-3">
    <label for="name" class="form-label">Name</label>
    <input type="text" class="form-control" id="name" name="name" placeholder="Name" required value="{{ old('name') }}">
  </div>

  {{-- Email --}}
  <div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" class="form-control" id="email" name="email" placeholder="Email" required value="{{ old('email') }}">
  </div>

  {{-- Password --}}
  <div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
  </div>

  {{-- Telephone --}}
  <div class="mb-3">
    <label for="telephone" class="form-label">Telephone</label>
    <input type="text" class="form-control" id="telephone" name="telephone" placeholder="Telephone" required value="{{ old('telephone') }}">
  </div>

  {{-- Submit --}}
  <button type="submit" class="btn btn-primary">Create</button>
</form>

@endsection