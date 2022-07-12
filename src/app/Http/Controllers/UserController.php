<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public static $user_roles = ['a' => 'Admin', 'u' => 'User'];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', [
            'title' => 'Users',
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create', [
            'title' => 'Create User'
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
            'role' => ['required', Rule::in(['u', 'a'])],
            'name' => 'required',
            'email' => 'required|email:rfc,dns|unique:users',
            'password' => 'required|min:6',
            'telephone' => 'required|numeric',
        ]);
        if(!User::create($validated)) {
            return back()->with('error', 'Unable to create user "' . $validated['name'] . '"');
        }
        return redirect('/admin/users');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        if(!$user) {
            return back()->with('error', 'User with id '. $id . ' not found');
        }

        $user->role = self::$user_roles[$user->role];

        return view('admin.users.show', [
            'title' => 'User\'s Details',
            'user' => $user
        ]);
    }

    public function show_publications($id)
    {
        $user = User::find($id);
        if(!$user) {
            return back()->with('error', 'User with id '. $id . ' not found');
        }

        $publications = $user->publications;
        if($user->role === 'a') {
            $publications = $user->reviewed_publications;
        }

        return view('admin.users.show_publications', [
            'title' => 'User\'s Publications',
            'user' => $user,
            'publications' => $publications
        ]);
    }

    public function show_datasets($id)
    {
        $user = User::find($id);
        if(!$user) {
            return back()->with('error', 'User with id '. $id . ' not found');
        }

        $datasets = $user->datasets;
        if($user->role === 'a') {
            $datasets = $user->reviewed_datasets;
        }

        return view('admin.users.show_datasets', [
            'title' => 'User\'s Datasets',
            'user' => $user,
            'datasets' => $datasets
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
