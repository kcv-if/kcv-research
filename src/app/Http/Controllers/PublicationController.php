<?php

namespace App\Http\Controllers;

use App\Slices\Publication\UseCase\IDeletePublicationUseCase;
use App\Slices\Publication\UseCase\IGetAllPublicationUseCase;
use App\Slices\Publication\UseCase\IGetByUuidPublicationUseCase;
use App\Slices\Publication\UseCase\IStorePublicationUseCase;
use App\Slices\Publication\UseCase\IUpdatePublicationUseCase;
use App\Slices\Publication\UseCase\StorePublicationRequest;
use App\Slices\Publication\UseCase\UpdatePublicationRequest;
use Exception;
use Illuminate\Http\Request;

class PublicationController extends Controller
{
    public function __construct(
        private IGetAllPublicationUseCase $getAllPublicationUseCase,
        private IStorePublicationUseCase $storePublicationUseCase,
        private IGetByUuidPublicationUseCase $getByUuidPublicationUseCase,
        private IDeletePublicationUseCase $deletePublicationUseCase,
        private IUpdatePublicationUseCase $updatePublicationUseCase
    ) {
    }

    public function index()
    {
        try {
            $response = $this->getAllPublicationUseCase->execute();
            return view('admin.publications.index', [
                'title' => 'Publications',
                'publications' => $response
            ]);
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function create()
    {
        return view('admin.publications.create', [
            'title' => 'Create Publication'
        ]);
    }

    public function store(Request $request)
    {
        // TODO: this is just a short term solution, please make this more proper
        $tags = [];
        if (trim($request->input('tags')) !== "") {
            $tags = array_unique(explode(' ', $request->input('tags')));
        }
        $authors = [];
        if (trim($request->input('authors')) !== "") {
            $authors = array_unique(explode(' ', $request->input('authors')));
        }

        try {
            $this->storePublicationUseCase->execute(new StorePublicationRequest(
                $request->input('name'),
                $request->input('excerpt'),
                $request->input('abstract'),
                $request->input('downloadLink'),
                $request->input('status'),
                $tags,
                $authors
            ));
            return redirect('/admin/publications');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function show($uuid)
    {
        try {
            $response = $this->getByUuidPublicationUseCase->execute($uuid);
            return view('admin.publications.show', [
                'title' => "Publication's Details",
                'publication' => $response
            ]);
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function edit($uuid)
    {
        try {
            $response = $this->getByUuidPublicationUseCase->execute($uuid);

            // TODO: make this more proper
            $status = [];
            $status[$response->status] = true;

            $authorUuids = [];
            foreach ($response->authors as $a) {
                $authorUuids[] = $a->uuid;
            }

            $tagUuids = [];
            foreach ($response->tags as $t) {
                $tagUuids[] = $t->uuid;
            }

            return view('admin.publications.update', [
                'title' => 'Update Publication',
                'publication' => $response,
                'status' => $status,
                'authors' => join(" ", $authorUuids),
                'tags' => join(" ", $tagUuids)
            ]);
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, $uuid)
    {
        // TODO: this is just a short term solution, please make this more proper
        $tags = [];
        if (trim($request->input('tags')) !== "") {
            $tags = array_unique(explode(' ', $request->input('tags')));
        }
        $authors = [];
        if (trim($request->input('authors')) !== "") {
            $authors = array_unique(explode(' ', $request->input('authors')));
        }

        try {
            $this->updatePublicationUseCase->execute(new UpdatePublicationRequest(
                $uuid,
                $request->input('name'),
                $request->input('excerpt'),
                $request->input('abstract'),
                $request->input('downloadLink'),
                $request->input('status'),
                $tags,
                $authors
            ));
            return redirect('/admin/publications');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy($uuid)
    {
        try {
            $this->deletePublicationUseCase->execute($uuid);
            return redirect('/admin/publications');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    // public function create_review($id)
    // {
    //     return view('admin.publications.create_review', [
    //         'title' => 'Create Review',
    //         'publication_id' => $id
    //     ]);
    // }

    // public function store_review(Request $request, $id) {
    //     // validate
    //     $validated = $request->validate([
    //         'status' => ['required', Rule::in(['p', 'a', 'r'])],
    //         'review' => 'required'
    //     ]);

    //     // get current admin id
    //     $user_id = Auth::id();

    //     // check if admin has reviewed publication
    //     if(DB::table('user_publications')
    //         ->where('user_id', $user_id)
    //         ->where('is_review', true)
    //         ->first()
    //     ) {
    //         return back()->with('error', 'Already reviewed publication with id ' . $id);
    //     }

    //     // update publication status
    //     if(!Publication::where('id', $id)->update(['status' => $validated['status']])) {
    //         return back()->with('error', 'Unable to update publication with id ' . $id);
    //     }

    //     // insert new review
    //     DB::table('user_publications')->insert([
    //         'publication_id' => $id,
    //         'user_id' => $user_id,
    //         'is_review' => true,
    //         'review_comment' => $validated['review'],
    //         'reviewed_at' => Carbon::now()
    //     ]);

    //     return redirect('/admin/publications');
    // }
}
