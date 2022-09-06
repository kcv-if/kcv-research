<?php

namespace App\Http\Controllers;

use App\Slices\Tag\UseCase\IGetAllTagUseCase;

class TagController extends Controller
{
    public function __construct(private IGetAllTagUseCase $getAllTagUseCase)
    {
    }

    public function index()
    {
        $response = $this->getAllTagUseCase->execute();
        return view('admin.tags.index', [
            'title' => 'Tags',
            'tags' => $response
        ]);
    }

    // public function create()
    // {
    //     return view('admin.tags.create', [
    //         'title' => 'Create Tag'
    //     ]);
    // }


    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'name' => 'required|unique:tags'
    //     ]);
    //     if (!Tag::create($validated)) {
    //         return back()->with('error', 'Unable to create tag "' . $validated['name'] . '"');
    //     }
    //     return redirect('/admin/tags');
    // }


    // public function show($id)
    // {
    //     $tag = Tag::find($id);
    //     if (!$tag) {
    //         return back()->with('error', 'Tag with id ' . $id . ' not found');
    //     }

    //     return view('admin.tags.show', [
    //         'title' => 'Tags',
    //         'tag' => $tag
    //     ]);
    // }

    // public function edit($id)
    // {
    //     $tag = Tag::find($id);
    //     if (!$tag) {
    //         return back()->with('error', 'Tag with id ' . $id . ' not found');
    //     }

    //     return view('admin.tags.update', [
    //         'title' => 'Update Tag',
    //         'tag' => $tag
    //     ]);
    // }


    // public function update(Request $request, $id)
    // {
    //     $tag = Tag::find($id);
    //     if (!$tag) {
    //         return back()->with('error', 'Tag with id ' . $id . ' not found');
    //     }

    //     $validated = $request->validate([
    //         'name' => 'required|unique:tags'
    //     ]);
    //     if (!Tag::where('id', $id)->update($validated)) {
    //         return back()->with('error', 'Unable to update tag "' . $validated['name'] . '"');
    //     }
    //     return redirect('/admin/tags');
    // }


    // public function destroy($id)
    // {
    //     $tag = Tag::find($id);
    //     if (!$tag) {
    //         return back()->with('error', 'Tag with id ' . $id . ' not found');
    //     }

    //     Tag::destroy($id);

    //     return redirect('/admin/tags');
    // }

    // public function get_by_name(Request $request)
    // {
    //     if ($request->keyword === '') {
    //         return response()->json([], 200);
    //     }

    //     $tags = Tag::where('name', 'LIKE', '%' . $request->keyword . '%')->get();

    //     return response()->json([
    //         'tags' => $tags
    //     ], 200);
    // }
}
