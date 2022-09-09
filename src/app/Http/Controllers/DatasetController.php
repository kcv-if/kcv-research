<?php

namespace App\Http\Controllers;

use App\Slices\Dataset\UseCase\IDeleteDatasetUseCase;
use App\Slices\Dataset\UseCase\IGetAllDatasetUseCase;
use App\Slices\Dataset\UseCase\IGetByUuidDatasetUseCase;
use App\Slices\Dataset\UseCase\IStoreDatasetUseCase;
use App\Slices\Dataset\UseCase\IUpdateDatasetUseCase;
use App\Slices\Dataset\UseCase\StoreDatasetRequest;
use App\Slices\Dataset\UseCase\UpdateDatasetRequest;
use Exception;
use Illuminate\Http\Request;

class DatasetController extends Controller
{
    public function __construct(
        private IGetAllDatasetUseCase $getAllDatasetUseCase,
        private IStoreDatasetUseCase $storeDatasetUseCase,
        private IGetByUuidDatasetUseCase $getByUuidDatasetUseCase,
        private IDeleteDatasetUseCase $deleteDatasetUseCase,
        private IUpdateDatasetUseCase $updateDatasetUseCase
    ) {
    }

    public function index()
    {
        try {
            $response = $this->getAllDatasetUseCase->execute();
            return view('admin.datasets.index', [
                'title' => 'Datasets',
                'datasets' => $response
            ]);
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function create()
    {
        return view('admin.datasets.create', [
            'title' => 'Create Dataset'
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
            $this->storeDatasetUseCase->execute(new StoreDatasetRequest(
                $request->input('name'),
                $request->input('description'),
                $request->input('downloadLink'),
                $request->input('status'),
                $tags,
                $authors
            ));
            return redirect('/admin/datasets');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function show($uuid)
    {
        try {
            $response = $this->getByUuidDatasetUseCase->execute($uuid);
            return view('admin.datasets.show', [
                'title' => "Dataset's Details",
                'dataset' => $response
            ]);
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function edit($uuid)
    {
        try {
            $response = $this->getByUuidDatasetUseCase->execute($uuid);

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

            return view('admin.datasets.update', [
                'title' => 'Update Dataset',
                'dataset' => $response,
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
            $this->updateDatasetUseCase->execute(new UpdateDatasetRequest(
                $uuid,
                $request->input('name'),
                $request->input('description'),
                $request->input('downloadLink'),
                $request->input('status'),
                $tags,
                $authors
            ));
            return redirect('/admin/datasets');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy($uuid)
    {
        try {
            $this->deleteDatasetUseCase->execute($uuid);
            return redirect('/admin/datasets');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    // public function create_review($id)
    // {
    //     return view('admin.datasets.create_review', [
    //         'title' => 'Create Review',
    //         'dataset_id' => $id
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

    //     // check if admin has reviewed dataset
    //     if(DB::table('user_datasets')
    //         ->where('user_id', $user_id)
    //         ->where('is_review', true)
    //         ->first()
    //     ) {
    //         return back()->with('error', 'Already reviewed dataset with id ' . $id);
    //     }

    //     // update dataset status
    //     if(!Dataset::where('id', $id)->update(['status' => $validated['status']])) {
    //         return back()->with('error', 'Unable to update dataset with id ' . $id);
    //     }

    //     // insert new review
    //     DB::table('user_datasets')->insert([
    //         'dataset_id' => $id,
    //         'user_id' => $user_id,
    //         'is_review' => true,
    //         'review_comment' => $validated['review'],
    //         'reviewed_at' => Carbon::now()
    //     ]);

    //     return redirect('/admin/datasets');
    // }
}
