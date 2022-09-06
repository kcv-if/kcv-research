@extends('admin.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Tags</h1>
    </div>

    {{-- Create --}}
    <a href="{{ url('/admin/tags/create') }}" class="btn badge bg-success"><i class="bi bi-plus-circle"></i> Create</a>

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
                        {{-- Show --}}
                        <a href="/admin/tags/{{ $tag->uuid }}" class="badge bg-info"><i class="bi bi-eye"></i></a>

                        {{-- Update --}}
                        <a href="/admin/tags/{{ $tag->uuid }}/edit" class="badge bg-warning"><i
                                class="bi bi-pencil-square"></i></a>

                        {{-- Delete --}}
                        <form method="post" class="d-inline" action="/admin/tags/{{ $tag->uuid }}">
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
