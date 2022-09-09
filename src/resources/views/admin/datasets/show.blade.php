@extends('admin.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">{{ $dataset->name }}</h1>
    </div>

    <a href="{{ url('/admin/datasets') }}" class="btn btn-link ml-0"><i class="bi bi-arrow-left"></i> Back</a>

    <div class="container">
        <p>ID: {{ $dataset->uuid }}</p>
        <p>Description: {{ $dataset->description }}</p>
        <p>Download Link: {{ $dataset->downloadLink }}</p>
        <p>Status:
            @if ($dataset->status === 'p')
                <span class="badge rounded-pill bg-warning">
                    Pending
                </span>
            @elseif($dataset->status === 'a')
                <span class="badge rounded-pill bg-success">
                    Accepted
                </span>
            @elseif($dataset->status === 'r')
                <span class="badge rounded-pill bg-danger">
                    Rejected
                </span>
            @endif
        </p>

        <p>Created at: {{ $dataset->createdAt }}</p>
        <p>Updated at: {{ $dataset->updatedAt }}</p>

        {{-- Update --}}
        <a href="/admin/datasets/{{ $dataset->uuid }}/edit" class="badge bg-warning"><i class="bi bi-pencil-square"></i></a>

        {{-- Delete --}}
        <form method="post" class="d-inline" action="/admin/datasets/{{ $dataset->uuid }}">
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
            @foreach ($dataset->authors as $author)
                <tr>
                    <td>{{ $author->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Tags --}}
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Tag</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dataset->tags as $tag)
                <tr>
                    <td>{{ $tag->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Reviewers --}}
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Reviewer</th>
                <th scope="col">Comment</th>
                <th scope="col">Reviewed At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dataset->reviews as $review)
                <tr>
                    <td>{{ $review->name }}</td>
                    <td>{{ $review->comment }}</td>
                    <td>{{ $review->createdAt }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
