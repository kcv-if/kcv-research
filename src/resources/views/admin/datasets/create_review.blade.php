@extends('admin.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">Create New Dataset Review</h1>
</div>

<a href="{{ url('/admin/datasets') }}" class="btn btn-link ml-0"><i class="bi bi-arrow-left"></i> Back</a>

<form action="/admin/datasets/{{ $dataset_id }}/review" method="post" class="mb-3">
  @csrf
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

  {{-- Review --}}
  <div class="mb-3">
    <label for="review" class="form-label">Review</label>
    <textarea class="form-control" placeholder="Review" id="review" name="review" required value="{{ old('review') }}"></textarea>
  </div>

  {{-- Submit --}}
  <button type="submit" class="btn btn-primary">Create</button>
</form>

@endsection
