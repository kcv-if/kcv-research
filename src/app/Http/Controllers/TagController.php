<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::all();
        return view('admin.tags.index', [
            'title' => 'Tags',
            'tags' => $tags
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tags.create', [
            'title' => 'Create Tag'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:tags'
        ]);
        if(!Tag::create($validated)) {
            return back()->with('error', 'Unable to create tag "' . $validated['name'] . '"');
        }
        return redirect('/admin/tags');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tag = Tag::find($id);
        if(!$tag) {
            return back()->with('error', 'Tag with id '. $id . ' not found');
        }

        return view('admin.tags.show', [
            'title' => 'Tags',
            'tag' => $tag
        ]);
    }

    public function show_publications($id)
    {
        $tag = Tag::find($id);
        if(!$tag) {
            return back()->with('error', 'Tag with id '. $id . ' not found');
        }

        return view('admin.tags.show_publications', [
            'title' => 'Tags',
            'tag' => $tag
        ]);
    }

    public function show_datasets($id)
    {
        $tag = Tag::find($id);
        if(!$tag) {
            return back()->with('error', 'Tag with id '. $id . ' not found');
        }

        return view('admin.tags.show_datasets', [
            'title' => 'Tags',
            'tag' => $tag
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tag = Tag::find($id);
        if(!$tag) {
            return back()->with('error', 'Tag with id '. $id . ' not found');
        }

        return view('admin.tags.update', [
            'title' => 'Update Tag',
            'tag' => $tag
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tag = Tag::find($id);
        if(!$tag) {
            return back()->with('error', 'Tag with id '. $id . ' not found');
        }

        $validated = $request->validate([
            'name' => 'required|unique:tags'
        ]);
        if(!Tag::where('id', $id)->update($validated)) {
            return back()->with('error', 'Unable to update tag "' . $validated['name'] . '"');
        }
        return redirect('/admin/tags');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tag = Tag::find($id);
        if(!$tag) {
            return back()->with('error', 'Tag with id '. $id . ' not found');
        }

        Tag::destroy($id);

        return redirect('/admin/tags');
    }

    public function get_by_name(Request $request) {
        if($request->keyword === '') {
            return response()->json([], 200);
        }

        $tags = Tag::where('name', 'LIKE', '%' . $request->keyword . '%')->get();

        return response()->json([
            'tags' => $tags
        ], 200);
    }
}
