@extends('admin.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">Update Tag "{{ $tag->name }}"</h1>
</div>

<a href="{{ url('/admin/tags') }}" class="btn btn-link ml-0"><i class="bi bi-arrow-left"></i> Back</a>

<form action="/admin/tags/{{ $tag->id }}" method="post">
  @method('put')
  @csrf
  <div class="mb-3">
    <label for="name" class="form-label">Name</label>
    <input type="text" class="form-control" id="name" name="name" value="{{ $tag->name }}">
  </div>
  <button type="submit" class="btn btn-primary">Update</button>
</form>

@endsection