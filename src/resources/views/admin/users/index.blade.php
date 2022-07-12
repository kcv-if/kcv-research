@extends('admin.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">Users</h1>
</div>

{{-- Create --}}
<a href="{{ url('/admin/users/create') }}" class="btn badge bg-success"><i class="bi bi-plus-circle"></i> Create</a>

<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($users as $user)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $user->name }}</td>
        <td>
          {{-- Show --}}
          <a href="/admin/users/{{ $user->id }}" class="badge bg-info"><i class="bi bi-eye"></i></a>

          {{-- Update --}}
          <a href="/admin/users/{{ $user->id }}/edit" class="badge bg-warning"><i class="bi bi-pencil-square"></i></a>
        
          {{-- Delete --}}
          <form method="post" class="d-inline" action="/admin/users/{{ $user->id }}">
            @csrf
            @method('delete')
            <button type="submit" class="btn badge bg-danger"><i class="bi bi-x-circle"></i></button>
          </form>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>
@endsection