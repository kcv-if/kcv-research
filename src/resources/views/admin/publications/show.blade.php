@extends('admin.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">{{ $publication->name }}</h1>
    </div>

    <a href="{{ url('/admin/publications') }}" class="btn btn-link ml-0"><i class="bi bi-arrow-left"></i> Back</a>

    <div class="container">
        <p>ID: {{ $publication->uuid }}</p>
        <p>Excerpt: {{ $publication->excerpt }}</p>
        <p>Abstract: {{ $publication->abstract }}</p>
        <p>Download Link: {{ $publication->downloadLink }}</p>
        <p>Status:
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
        </p>

        <p>Created at: {{ $publication->createdAt }}</p>
        <p>Updated at: {{ $publication->updatedAt }}</p>

        {{-- Update --}}
        <a href="/admin/publications/{{ $publication->uuid }}/edit" class="badge bg-warning"><i
                class="bi bi-pencil-square"></i></a>

        {{-- Delete --}}
        <form method="post" class="d-inline" action="/admin/publications/{{ $publication->uuid }}">
            @csrf
            @method('delete')
            <button type="submit" class="btn badge bg-danger"><i class="bi bi-x-circle"></i></button>
        </form>
    </div>

    {{-- Authors --}}
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Author</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($publication->authors as $author)
                <tr>
                    <td>{{ $author->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Tags --}}
    {{-- <table class="table">
        <thead>
            <tr>
                <th scope="col">Tag</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($publication->tags as $tag)
                <tr>
                    <td>{{ $tag->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table> --}}

    {{-- Reviewers --}}
    {{-- <table class="table">
        <thead>
            <tr>
                <th scope="col">Reviewer</th>
                <th scope="col">Comment</th>
                <th scope="col">Reviewed At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($publication->reviewers as $reviewer)
                <tr>
                    <td>{{ $reviewer->name }}</td>
                    <td>{{ $reviewer->pivot->review_comment }}</td>
                    <td>{{ $reviewer->pivot->reviewed_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table> --}}
@endsection
