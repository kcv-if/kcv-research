@extends('admin.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Create New Dataset</h1>
    </div>

    <a href="{{ url('/admin/datasets') }}" class="btn btn-link ml-0"><i class="bi bi-arrow-left"></i> Back</a>

    <form action="/admin/datasets" method="post" class="mb-3">
        @csrf
        {{-- Name --}}
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Name" required
                value="{{ old('name') }}">
        </div>

        {{-- Description --}}
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" placeholder="Description" id="description" name="description" required>{{ old('description') }}</textarea>
        </div>

        {{-- Download Link --}}
        <div class="mb-3">
            <label for="downloadLink" class="form-label">Download Link</label>
            <input type="url" class="form-control" id="downloadLink" name="downloadLink" placeholder="Download Link"
                required value="{{ old('downloadLink') }}">
        </div>

        {{-- Status --}}
        <div class="mb-3">
            <label class="form-label">Status</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="status" id="accepted" value="a">
                <label class="form-check-label" for="accepted">
                    Accepted
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="status" id="pending" value="p">
                <label class="form-check-label" for="pending">
                    Pending
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="status" id="rejected" value="r">
                <label class="form-check-label" for="rejected">
                    Rejected
                </label>
            </div>
        </div>

        {{-- Authors --}}
        <div class="mb-3">
            <label for="search" class="form-label">Authors</label>
            <input type="text" class="form-control" id="authors" name="authors" placeholder="Search Authors"
                value="{{ old('authors') }}">
            <ul class="list-group" id='user-list'></ul>
        </div>

        {{-- Tags --}}
        <div class="mb-3">
            <label for="search" class="form-label">Tags</label>
            <input type="text" class="form-control" id="tags" name="tags" placeholder="Search Tags"
                value="{{ old('tags') }}">
            <ul class="list-group" id='tag-list'></ul>
        </div>

        {{-- Submit --}}
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
@endsection
