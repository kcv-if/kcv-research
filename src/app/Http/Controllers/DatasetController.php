<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dataset;
use App\Models\User;
use App\Models\Tag;
use App\Rules\ValidAuthor;
use Illuminate\Validation\Rule;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DatasetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datasets = Dataset::all();
        
        return view('admin.datasets.index',[
            'title' => 'Datasets',
            'datasets' => $datasets
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.datasets.create', [
            'title' => 'Create Dataset'
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
        // create slug based on dataset's title
        $request['slug'] = SlugService::createSlug(Dataset::class, 'slug', $request->name);

        // validation rules
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'download_link' => 'required',
            'status' => ['required', Rule::in(['p', 'a', 'r'])],
            'slug' => 'required|unique:datasets',
            'tags' => 'required',
            'users' => ['required', new ValidAuthor],
        ]);

        // copy validated data to dataset_data
        $dataset_data = $validated;

        // delete element with key 'tags' and 'users' in dataset_data
        unset($dataset_data['tags']);
        unset($dataset_data['users']);

        // create dataset
        $dataset = Dataset::create($dataset_data);
        if(!$dataset) {
            return back()->with('error', 'Unable to create dataset "' . $validated['name'] . '"');
        }

        // insert new authors
        $new_emails = array_unique(explode(' ', $validated['users']));
        foreach($new_emails as $new_email) {
            $user_id = User::where('email', $new_email)->first()->id;
            DB::table('user_datasets')->insert([
                'dataset_id' => $dataset->id,
                'user_id' => $user_id
            ]);
        }

        // insert new tags
        $new_tags = array_unique(explode(' ', $validated['tags']));
        foreach($new_tags as $new_tag) {
            $tag = Tag::where('name', $new_tag)->first();
            // create tag if tag does not exist
            if(!$tag) {
                $tag = Tag::create(['name' => $new_tag]);
            }
            DB::table('dataset_tags')->insert([
                'dataset_id' => $dataset->id,
                'tag_id' => $tag->id
            ]);
        }

        return redirect('/admin/datasets');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // check if dataset exists
        $dataset = Dataset::find($id);
        if(!$dataset) {
            return back()->with('error', 'Dataset with id '. $id . ' not found');
        }

        return view('admin.datasets.show', [
            'title' => 'Dataset "' . $dataset->name . '"',
            'dataset' => $dataset
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
        // check if dataset exists
        $dataset = Dataset::find($id);
        if(!$dataset) {
            return back()->with('error', 'Dataset with id '. $id . ' not found');
        }

        // join all tags
        $tags = [];
        foreach($dataset->tags as $tag) {
            $tags[] = $tag->name;
        }

        // join all authors
        $authors = [];
        foreach($dataset->authors as $author) {
            $authors[] = $author->email;
        }

        // TODO: make status passing more elegant
        $status = [];
        $status[$dataset->status] = true;
        return view('admin.datasets.update', [
            'title' => 'Update Dataset',
            'dataset' => $dataset,
            'status' => $status,
            'tags' => join(" ", $tags),
            'users' => join(" ", $authors)
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
        // check if dataset exists
        $dataset = Dataset::find($id);
        if(!$dataset) {
            return back()->with('error', 'Dataset with id '. $id . ' not found');
        }

        // create slug based on dataset's title
        $request['slug'] = SlugService::createSlug(Dataset::class, 'slug', $request->name);

        // validation rules
        $validation_rules = [
            'name' => 'required',
            'description' => 'required',
            'download_link' => 'required',
            'status' => ['required', Rule::in(['p', 'a', 'r'])],
            'slug' => 'required',
            'tags' => 'required',
            'users' => ['required', new ValidAuthor],
        ];

        // if slug is different, then check if it is unique
        if ($request['slug'] !== $dataset->slug) {
            $validation_rules['slug'] = ['required', 'unique:datasets'];
        }

        // validate
        $validated = $request->validate($validation_rules);

        // copy validated data to dataset_data
        $dataset_data = $validated;

        // delete element with key 'tags' and 'users' in dataset_data
        unset($dataset_data['tags']);
        unset($dataset_data['users']);

        // update dataset
        if(!Dataset::where('id', $id)->update($dataset_data)) {
            return back()->with('error', 'Unable to update dataset "' . $validated['name'] . '"');
        }

        // delete previous authors
        DB::table('user_datasets')
            ->where('dataset_id', $dataset->id)
            ->where('is_review', false)
            ->delete();

        // insert new authors
        $new_emails = array_unique(explode(' ', $validated['users']));
        foreach($new_emails as $new_email) {
            $user_id = User::where('email', $new_email)->first()->id;
            DB::table('user_datasets')->insert([
                'dataset_id' => $dataset->id,
                'user_id' => $user_id
            ]);
        }

        // delete previous tags
        DB::table('dataset_tags')
            ->where('dataset_id', $dataset->id)
            ->delete();

        // insert new tags
        $new_tags = array_unique(explode(' ', $validated['tags']));
        foreach($new_tags as $new_tag) {
            $tag = Tag::where('name', $new_tag)->first();
            // create tag if tag does not exist
            if(!$tag) {
                $tag = Tag::create(['name' => $new_tag]);
            }
            DB::table('dataset_tags')->insert([
                'dataset_id' => $dataset->id,
                'tag_id' => $tag->id
            ]);
        }

        return redirect('/admin/datasets');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dataset = Dataset::find($id);
        if(!$dataset) {
            return back()->with('error', 'Dataset with id '. $id . ' not found');
        }

        // delete dataset
        Dataset::destroy($id);

        return redirect('/admin/datasets');
    }

    /**
     * Show the form for creating a new review.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_review($id)
    {
        return view('admin.datasets.create_review', [
            'title' => 'Create Review',
            'dataset_id' => $id
        ]);
    }

    /**
     * Store a newly created review in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_review(Request $request, $id) {
        // validate
        $validated = $request->validate([
            'status' => ['required', Rule::in(['p', 'a', 'r'])],
            'review' => 'required'
        ]);

        // get current admin id
        $user_id = Auth::id();

        // check if admin has reviewed dataset
        if(DB::table('user_datasets')
            ->where('user_id', $user_id)
            ->where('is_review', true)
            ->first()
        ) {
            return back()->with('error', 'Already reviewed dataset with id ' . $id);
        }

        // update dataset status
        if(!Dataset::where('id', $id)->update(['status' => $validated['status']])) {
            return back()->with('error', 'Unable to update dataset with id ' . $id);
        }

        // insert new review
        DB::table('user_datasets')->insert([
            'dataset_id' => $id,
            'user_id' => $user_id,
            'is_review' => true,
            'review_comment' => $validated['review'],
            'reviewed_at' => Carbon::now()
        ]);

        return redirect('/admin/datasets');
    }
}
