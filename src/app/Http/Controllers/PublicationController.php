<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publication;
use App\Models\User;
use App\Models\Tag;
use Illuminate\Validation\Rule;
use Cviebrock\EloquentSluggable\Services\SlugService;
use DB;
use Auth;
use Carbon\Carbon;

class PublicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $publications = Publication::all();
        return view('admin.publications.index', [
            'title' => 'Publications',
            'publications' => $publications
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.publications.create', [
            'title' => 'Create Publication'
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
        $request['slug'] = SlugService::createSlug(Publication::class, 'slug', $request->name);

        $validated = $request->validate([
            'name' => 'required',
            'excerpt' => 'required',
            'abstract' => 'required',
            'download_link' => 'required',
            'status' => ['required', Rule::in(['p', 'a', 'r'])],
            'slug' => 'required|unique:publications',
            'tags' => 'required',
            'users' => 'required',
        ]);

        $publication_data = $validated;
        unset($publication_data['tags']);
        unset($publication_data['users']);

        $publication = Publication::create($publication_data);
        if(!$publication) {
            return back()->with('error', 'Unable to create publication "' . $validated['name'] . '"');
        }

        // Authors
        $author_emails = array_unique(explode(' ', $request['users']));
        $user_ids = [];
        foreach($author_emails as $author_email) {
            $user_id = User::where('email', $author_email)->first()->id;
            if(!$user_id) {
                return back()->with('error', 'Unable to create publication "' . $validated['name'] . '"');
            }
            $user_ids[] = $user_id;
        }

        for($i = 0; $i < count($user_ids); $i++) {
            DB::table('user_publications')->insert([
                'publication_id' => $publication->id,
                'user_id' => $user_ids[$i]
            ]);
        }

        // Tags
        /* EXPERIMENTAL */
        $input_tags = array_unique(explode(' ', $request['tags']));
        foreach($input_tags as $input_tag) {
            $tag = Tag::where('name', $input_tag)->first();
            if(!$tag) {
                $tag = Tag::create(['name' => $input_tag]);
            }
            DB::table('publication_tags')->insert([
                'publication_id' => $publication->id,
                'tag_id' => $tag->id
            ]);
        }
        /* EXPERIMENTAL */

        return redirect('/admin/publications');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $publication = Publication::find($id);
        if(!$publication) {
            return back()->with('error', 'Publication with id '. $id . ' not found');
        }

        return view('admin.publications.show', [
            'title' => 'Publication "' . $publication->name . '"',
            'publication' => $publication
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
        $publication = Publication::find($id);
        if(!$publication) {
            return back()->with('error', 'Publication with id '. $id . ' not found');
        }

        $tags = [];
        foreach($publication->tags as $tag) {
            $tags[] = $tag->name;
        }

        $authors = [];
        foreach($publication->authors as $author) {
            $authors[] = $author->email;
        }

        // todo: tidy this
        $status = [];
        $status[$publication->status] = true;
        return view('admin.publications.update', [
            'title' => 'Update Publication',
            'publication' => $publication,
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
        $publication = Publication::find($id);
        if(!$publication) {
            return back()->with('error', 'Publication with id '. $id . ' not found');
        }

        $request['slug'] = SlugService::createSlug(Publication::class, 'slug', $request->name);

        $validation_rules = [
            'name' => 'required',
            'excerpt' => 'required',
            'abstract' => 'required',
            'download_link' => 'required',
            'status' => ['required', Rule::in(['p', 'a', 'r'])],
            'slug' => ['required'],
            'tags' => 'required',
            'users' => 'required',
        ];

        // if title is different, then check if it is unique
        // todo: tidy this
        if ($request['slug'] !== $publication->slug) {
            $validation_rules['slug'] = ['required', 'unique:publications'];
        }

        $validated = $request->validate($validation_rules);

        $publication_data = $validated;
        unset($publication_data['tags']);
        unset($publication_data['users']);

        if(!Publication::where('id', $id)->update($publication_data)) {
            return back()->with('error', 'Unable to update publication "' . $validated['name'] . '"');
        }

        // Authors
        DB::table('user_publications')
            ->where('publication_id', $publication->id)
            ->where('is_review', false)
            ->delete();

        $author_emails = array_unique(explode(' ', $request['users']));
        $user_ids = [];
        foreach($author_emails as $author_email) {
            $user_id = User::where('email', $author_email)->first()->id;
            if(!$user_id) {
                return back()->with('error', 'Unable to create publication "' . $validated['name'] . '"');
            }
            $user_ids[] = $user_id;
        }

        for($i = 0; $i < count($user_ids); $i++) {
            DB::table('user_publications')->insert([
                'publication_id' => $publication->id,
                'user_id' => $user_ids[$i]
            ]);
        }

        // Tags
        DB::table('publication_tags')
            ->where('publication_id', $publication->id)
            ->delete();

        /* EXPERIMENTAL */
        $input_tags = array_unique(explode(' ', $request['tags']));
        foreach($input_tags as $input_tag) {
            $tag = Tag::where('name', $input_tag)->first();
            if(!$tag) {
                $tag = Tag::create(['name' => $input_tag]);
            }
            DB::table('publication_tags')->insert([
                'publication_id' => $publication->id,
                'tag_id' => $tag->id
            ]);
        }
        /* EXPERIMENTAL */

        return redirect('/admin/publications');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $publication = Publication::find($id);
        if(!$publication) {
            return back()->with('error', 'Publication with id '. $id . ' not found');
        }

        publication::destroy($id);

        return redirect('/admin/publications');
    }

    /**
     * Show the form for creating a new review.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_review($id)
    {
        return view('admin.publications.create_review', [
            'title' => 'Create Review',
            'publication_id' => $id
        ]);
    }

    /**
     * Store a newly created review in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_review(Request $request, $id) {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['p', 'a', 'r'])],
            'review' => 'required'
        ]);

        $user_id = Auth::id();

        if(DB::table('user_publications')
            ->where('user_id', $user_id)
            ->where('is_review', true)
            ->first()
        ) {
            return back()->with('error', 'Already reviewed publication with id ' . $id);
        }

        if(!Publication::where('id', $id)->update(['status' => $validated['status']])) {
            return back()->with('error', 'Unable to update publication with id ' . $id);
        }

        DB::table('user_publications')->insert([
            'publication_id' => $id,
            'user_id' => $user_id,
            'is_review' => true,
            'review_comment' => $validated['review'],
            'reviewed_at' => Carbon::now()
        ]);

        return redirect('/admin/publications');
    }
}
