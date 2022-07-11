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
</div>

@endsection