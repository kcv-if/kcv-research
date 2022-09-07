<?php

namespace App\Http\Controllers;

use App\Slices\Publication\UseCase\IGetAllPublicationUseCase;
use Exception;

class PublicationController extends Controller
{
    public function __construct(
        private IGetAllPublicationUseCase $getAllPublicationUseCase
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

    // public function create()
    // {
    //     return view('admin.publications.create', [
    //         'title' => 'Create Publication'
    //     ]);
    // }

    // public function store(Request $request)
    // {
    //     // create slug based on publication's title
    //     $request['slug'] = SlugService::createSlug(Publication::class, 'slug', $request->name);

    //     // validation rules
    //     $validated = $request->validate([
    //         'name' => 'required',
    //         'excerpt' => 'required',
    //         'abstract' => 'required',
    //         'download_link' => 'required',
    //         'status' => ['required', Rule::in(['p', 'a', 'r'])],
    //         'slug' => 'required|unique:publications',
    //         'tags' => 'required',
    //         'users' => ['required', new ValidAuthor],
    //     ]);

    //     // copy validated data to publication_data
    //     $publication_data = $validated;

    //     // delete element with key 'tags' and 'users' in publication_data
    //     unset($publication_data['tags']);
    //     unset($publication_data['users']);

    //     // create publication
    //     $publication = Publication::create($publication_data);
    //     if(!$publication) {
    //         return back()->with('error', 'Unable to create publication "' . $validated['name'] . '"');
    //     }

    //     // insert new authors
    //     $new_emails = array_unique(explode(' ', $validated['users']));
    //     foreach($new_emails as $new_email) {
    //         $user_id = User::where('email', $new_email)->first()->id;
    //         DB::table('user_publications')->insert([
    //             'publication_id' => $publication->id,
    //             'user_id' => $user_id
    //         ]);
    //     }

    //     // insert new tags
    //     $new_tags = array_unique(explode(' ', $validated['tags']));
    //     foreach($new_tags as $new_tag) {
    //         $tag = Tag::where('name', $new_tag)->first();
    //         // create tag if tag does not exist
    //         if(!$tag) {
    //             $tag = Tag::create(['name' => $new_tag]);
    //         }
    //         DB::table('publication_tags')->insert([
    //             'publication_id' => $publication->id,
    //             'tag_id' => $tag->id
    //         ]);
    //     }

    //     return redirect('/admin/publications');
    // }

    // public function show($id)
    // {
    //     // check if publication exists
    //     $publication = Publication::find($id);
    //     if(!$publication) {
    //         return back()->with('error', 'Publication with id '. $id . ' not found');
    //     }

    //     return view('admin.publications.show', [
    //         'title' => 'Publication "' . $publication->name . '"',
    //         'publication' => $publication
    //     ]);
    // }

    // public function edit($id)
    // {
    //     // check if publication exists
    //     $publication = Publication::find($id);
    //     if(!$publication) {
    //         return back()->with('error', 'Publication with id '. $id . ' not found');
    //     }

    //     // join all tags
    //     $tags = [];
    //     foreach($publication->tags as $tag) {
    //         $tags[] = $tag->name;
    //     }

    //     // join all authors
    //     $authors = [];
    //     foreach($publication->authors as $author) {
    //         $authors[] = $author->email;
    //     }

    //     // TODO: make status passing more elegant
    //     $status = [];
    //     $status[$publication->status] = true;
    //     return view('admin.publications.update', [
    //         'title' => 'Update Publication',
    //         'publication' => $publication,
    //         'status' => $status,
    //         'tags' => join(" ", $tags),
    //         'users' => join(" ", $authors)
    //     ]);
    // }

    // public function update(Request $request, $id)
    // {
    //     // check if publication exists
    //     $publication = Publication::find($id);
    //     if(!$publication) {
    //         return back()->with('error', 'Publication with id '. $id . ' not found');
    //     }

    //     // create slug based on publication's title
    //     $request['slug'] = SlugService::createSlug(Publication::class, 'slug', $request->name);

    //     // validation rules
    //     $validation_rules = [
    //         'name' => 'required',
    //         'excerpt' => 'required',
    //         'abstract' => 'required',
    //         'download_link' => 'required',
    //         'status' => ['required', Rule::in(['p', 'a', 'r'])],
    //         'slug' => 'required',
    //         'tags' => 'required',
    //         'users' => ['required', new ValidAuthor],
    //     ];

    //     // if slug is different, then check if it is unique
    //     if ($request['slug'] !== $publication->slug) {
    //         $validation_rules['slug'] = ['required', 'unique:publications'];
    //     }

    //     // validate
    //     $validated = $request->validate($validation_rules);

    //     // copy validated data to publication_data
    //     $publication_data = $validated;

    //     // delete element with key 'tags' and 'users' in publication_data
    //     unset($publication_data['tags']);
    //     unset($publication_data['users']);

    //     // update publication
    //     if(!Publication::where('id', $id)->update($publication_data)) {
    //         return back()->with('error', 'Unable to update publication "' . $validated['name'] . '"');
    //     }

    //     // delete previous authors
    //     DB::table('user_publications')
    //         ->where('publication_id', $publication->id)
    //         ->where('is_review', false)
    //         ->delete();

    //     // insert new authors
    //     $new_emails = array_unique(explode(' ', $validated['users']));
    //     foreach($new_emails as $new_email) {
    //         $user_id = User::where('email', $new_email)->first()->id;
    //         DB::table('user_publications')->insert([
    //             'publication_id' => $publication->id,
    //             'user_id' => $user_id
    //         ]);
    //     }

    //     // delete previous tags
    //     DB::table('publication_tags')
    //         ->where('publication_id', $publication->id)
    //         ->delete();

    //     // insert new tags
    //     $new_tags = array_unique(explode(' ', $validated['tags']));
    //     foreach($new_tags as $new_tag) {
    //         $tag = Tag::where('name', $new_tag)->first();
    //         // create tag if tag does not exist
    //         if(!$tag) {
    //             $tag = Tag::create(['name' => $new_tag]);
    //         }
    //         DB::table('publication_tags')->insert([
    //             'publication_id' => $publication->id,
    //             'tag_id' => $tag->id
    //         ]);
    //     }

    //     return redirect('/admin/publications');
    // }

    // public function destroy($id)
    // {
    //     // check if publication exists
    //     $publication = Publication::find($id);
    //     if(!$publication) {
    //         return back()->with('error', 'Publication with id '. $id . ' not found');
    //     }

    //     // delete publication
    //     Publication::destroy($id);

    //     return redirect('/admin/publications');
    // }

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
