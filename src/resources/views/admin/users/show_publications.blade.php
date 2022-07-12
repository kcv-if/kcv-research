@extends('admin.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  @if ($user->role === 'a')
    <h1 class="h2">{{ $user->name }}'s Reviewed Publications</h1>
  @else
    <h1 class="h2">{{ $user->name }}'s Publications</h1>
  @endif
</div>

<a href="/admin/users/{{ $user->id }}" class="btn btn-link ml-0"><i class="bi bi-arrow-left"></i> Back</a>

{{-- Create --}}
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($publications as $publication)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $publication->name }}</td>
      </tr>
    @endforeach
  </tbody>
</table>

@endsection