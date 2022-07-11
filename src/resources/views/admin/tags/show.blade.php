@extends('admin.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">Tag "{{ $tag->name }}"</h1>
</div>

<a href="{{ url('/admin/tags') }}" class="btn btn-link ml-0"><i class="bi bi-arrow-left"></i> Back</a>

{{-- Create --}}
<div class="container">
  <p>ID: {{ $tag->id }}</p>
  <p>Created at: {{ $tag->created_at }}</p>
  <p>Updated at: {{ $tag->updated_at }}</p>
  <a href="/admin/tags/{{ $tag->id }}/publications">Publications</a>
  <a href="/admin/tags/{{ $tag->id }}/datasets">Datasets</a>

  {{-- Update --}}
  <a href="/admin/tags/{{ $tag->id }}/edit" class="badge bg-warning"><i class="bi bi-pencil-square"></i></a>

  {{-- Delete --}}
  <form method="post" class="d-inline" action="/admin/tags/{{ $tag->id }}">
    @csrf
    @method('delete')
    <button type="submit" class="btn badge bg-danger"><i class="bi bi-x-circle"></i></button>
  </form>
</div>

@endsection