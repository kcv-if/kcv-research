@extends('admin.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">Update Publication</h1>
</div>

<a href="{{ url('/admin/publications') }}" class="btn btn-link ml-0"><i class="bi bi-arrow-left"></i> Back</a>

<form action="/admin/publications/{{ $publication->id }}" method="post" class="mb-3">
  @method('put')
  @csrf
  {{-- Name --}}
  <div class="mb-3">
    <label for="name" class="form-label">Name</label>
    <input type="text" class="form-control" id="name" name="name" placeholder="Name" required value="{{ $publication->name }}">
  </div>

  {{-- Excerpt --}}
  <div class="mb-3">
    <label for="excerpt" class="form-label">Excerpt</label>
    <textarea class="form-control" placeholder="Excerpt" id="excerpt" name="excerpt" required>{{ $publication->excerpt }}</textarea>
  </div>

  {{-- Abstract --}}
  <div class="mb-3">
    <label for="abstract" class="form-label">Abstract</label>
    <textarea class="form-control" placeholder="Abstract" id="abstract" name="abstract" required>{{ $publication->abstract }}</textarea>
  </div>

  {{-- Download Link --}}
  <div class="mb-3">
    <label for="download_link" class="form-label">Download Link</label>
    <input type="url" class="form-control" id="download_link" name="download_link" placeholder="Download Link" required value="{{ $publication->download_link }}">
  </div>

  {{-- Status --}}
  <div class="mb-3">
    <label class="form-label">Status</label>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="status" id="accepted" value="a" {{ array_key_exists('a', $status) ? 'checked' : '' }}>
        <label class="form-check-label" for="accepted">
        Accepted
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="status" id="pending" value="p" {{ array_key_exists('p', $status) ? 'checked' : '' }}>
        <label class="form-check-label" for="pending">
        Pending
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="status" id="rejected" value="r" {{ array_key_exists('r', $status) ? 'checked' : '' }}>
        <label class="form-check-label" for="rejected">
        Rejected
        </label>
    </div>
  </div>

  {{-- Tags --}}
  <div class="mb-3">
    <label for="search" class="form-label">Tags</label>
    <input type="text" class="form-control" id="tags" name="tags" placeholder="Search Tags" value="{{ $tags }}">
    <ul class="list-group" id='tag-list'></ul>
  </div>

  {{-- Authors --}}
  <div class="mb-3">
    <label for="search" class="form-label">Authors</label>
    <input type="text" class="form-control" id="users" name="users" placeholder="Search Authors" value="{{ $users }}">
    <ul class="list-group" id='user-list'></ul>
  </div>

  {{-- Submit --}}
  <button type="submit" class="btn btn-primary">Update</button>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

{{-- Reference for live search: https://medium.com/@cahyofajar28/live-search-in-laravel-8-using-ajax-and-mysql-ac4bc9b0a93c --}}
<script>
    let data = {
        tags: null,
        authors: null
    };

    $('#tags').on('keyup', function(){
        search(
            'tags',
            'tags',
            'tag-list',
            '{{ route("tags.search") }}'
        );
    });

    $('#users').on('keyup', function(){
        search(
            'users',
            'users',
            'user-list',
            '{{ route("users.search") }}',
            'email'
        );
    });

    function search(id, input_id, list_id, route, attr='name') {
        const keywords = $(`#${input_id}`).val();

        if(!keywords || keywords[keywords.length - 1] === " ") {
            clear_list(list_id);
            return;
        }

        data[id] = keywords.trim().replace(/\s+/g, ' ');

        if(data[id].length === 0) {
            return;
        }

        data[id] = data[id].split(' ');

        const keyword = data[id][data[id].length - 1];

        console.log(`${id} ${keyword}`);

        $.post(route, {
            _token: $('meta[name="csrf-token"]').attr('content'),
            keyword: keyword
        }, function(data) {
            update_list(data[input_id], id, input_id, list_id, attr);
        });

        return;
    }

    function update_list(items, id, input_id, list_id, attr) {
        let list_items = '';
        for(let i = 0; i < items.length; i++) {
            list_items += `
            <li class="list-group-item" onclick="update_form('`+items[i][attr]+`', '`+id+`', '`+input_id+`', '`+list_id+`')">`+items[i][attr]+`</li>`;
        }
        $(`#${list_id}`).html(list_items)
    }

    function update_form(name, id, input_id, list_id) {
        data[id][data[id].length - 1] = name + ' ';
        $(`#${input_id}`).val(data[id].join(' '));
        clear_list(list_id);
    }

    function clear_list(list_id) {
        $(`#${list_id}`).html("")
    }

</script>

@endsection
