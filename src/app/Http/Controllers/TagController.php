<?php

namespace App\Http\Controllers;

use App\Slices\Tag\Domain\IGetByUuidTagQuery;
use App\Slices\Tag\UseCase\IDeleteTagUseCase;
use App\Slices\Tag\UseCase\IGetAllTagUseCase;
use App\Slices\Tag\UseCase\IGetByUuidTagUseCase;
use App\Slices\Tag\UseCase\IStoreTagUseCase;
use App\Slices\Tag\UseCase\StoreTagRequest;
use Exception;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function __construct(
        private IGetAllTagUseCase $getAllTagUseCase,
        private IStoreTagUseCase $storeTagUseCase,
        private IGetByUuidTagUseCase $getByUuidTagUseCase,
        private IDeleteTagUseCase $deleteTagUseCase,
    ) {
    }

    public function index()
    {
        try {
            $response = $this->getAllTagUseCase->execute();
            return view('admin.tags.index', [
                'title' => 'Tags',
                'tags' => $response
            ]);
        } catch (Exception $e) {
            // TODO: add exception handling
        }
    }

    public function create()
    {
        return view('admin.tags.create', [
            'title' => 'Create Tag'
        ]);
    }

    public function store(Request $request)
    {
        // $validated = $request->validate([
        //     'name' => 'required|unique:tags'
        // ]);

        try {
            $this->storeTagUseCase->execute(new StoreTagRequest($request->name));
            return redirect('/admin/tags');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function show($uuid)
    {
        try {
            $response = $this->getByUuidTagUseCase->execute($uuid);
            return view('admin.tags.show', [
                'title' => 'Tag',
                'tag' => $response
            ]);
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

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


    public function destroy($uuid)
    {
        try {
            $this->deleteTagUseCase->execute($uuid);
            return redirect('/admin/tags');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

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
