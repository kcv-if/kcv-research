@extends('admin.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Publications</h1>
    </div>

    {{-- Create --}}
    <a href="{{ url('/admin/publications/create') }}" class="btn badge bg-success"><i class="bi bi-plus-circle"></i> Create</a>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Status</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($publications as $publication)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $publication->name }}</td>
                    <td>
                        @if ($publication->status === 'p')
                            <span class="badge rounded-pill bg-warning">
                                Pending
                            </span>
                        @elseif($publication->status === 'a')
                            <span class="badge rounded-pill bg-success">
                                Accepted
                            </span>
                        @elseif($publication->status === 'r')
                            <span class="badge rounded-pill bg-danger">
                                Rejected
                            </span>
                        @endif
                    </td>
                    <td>
                        {{-- Show --}}
                        <a href="/admin/publications/{{ $publication->uuid }}" class="badge bg-info"><i
                                class="bi bi-eye"></i></a>

                        {{-- Update --}}
                        <a href="/admin/publications/{{ $publication->uuid }}/edit" class="badge bg-warning"><i
                                class="bi bi-pencil-square"></i></a>

                        {{-- Delete --}}
                        <form method="post" class="d-inline" action="/admin/publications/{{ $publication->uuid }}">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn badge bg-danger"><i class="bi bi-x-circle"></i></button>
                        </form>

                        {{-- Review --}}
                        <a href="/admin/publications/{{ $publication->uuid }}/review" class="badge bg-primary"><i
                                class="bi bi-hand-thumbs-up"></i></a>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
