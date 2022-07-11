@extends('admin.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">Tags</h1>
</div>

<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($tags as $tag)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $tag->name }}</td>
        <td>
          
        </td>
      </tr>
    @endforeach
  </tbody>
</table>
@endsection