<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Slices\User\UseCase\IGetAllUserUseCase;
use App\Slices\User\UseCase\IStoreUserUseCase;
use App\Slices\User\UseCase\StoreUserRequest;
use Exception;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct(
        private IGetAllUserUseCase $getAllUserUseCase,
        private IStoreUserUseCase $storeUserUseCase
    ) {
    }

    public function index()
    {
        try {
            $response = $this->getAllUserUseCase->execute();
            return view('admin.users.index', [
                'title' => 'Users',
                'users' => $response
            ]);
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function create()
    {
        return view('admin.users.create', [
            'title' => 'Create User'
        ]);
    }

    public function store(Request $request)
    {
        try {
            $this->storeUserUseCase->execute(new StoreUserRequest(
                $request->input('role'),
                $request->input('name'),
                $request->input('email'),
                $request->input('password'),
                $request->input('telephone')
            ));
            return redirect('/admin/users');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    // public function show($id)
    // {
    //     $user = User::find($id);
    //     if(!$user) {
    //         return back()->with('error', 'User with id '. $id . ' not found');
    //     }

    //     $user->role = self::$user_roles[$user->role];

    //     return view('admin.users.show', [
    //         'title' => 'User\'s Details',
    //         'user' => $user
    //     ]);
    // }

    // public function show_publications($id)
    // {
    //     $user = User::find($id);
    //     if(!$user) {
    //         return back()->with('error', 'User with id '. $id . ' not found');
    //     }

    //     $publications = $user->publications;
    //     if($user->role === 'a') {
    //         $publications = $user->reviewed_publications;
    //     }

    //     return view('admin.users.show_publications', [
    //         'title' => 'User\'s Publications',
    //         'user' => $user,
    //         'publications' => $publications
    //     ]);
    // }

    // public function show_datasets($id)
    // {
    //     $user = User::find($id);
    //     if(!$user) {
    //         return back()->with('error', 'User with id '. $id . ' not found');
    //     }

    //     $datasets = $user->datasets;
    //     if($user->role === 'a') {
    //         $datasets = $user->reviewed_datasets;
    //     }

    //     return view('admin.users.show_datasets', [
    //         'title' => 'User\'s Datasets',
    //         'user' => $user,
    //         'datasets' => $datasets
    //     ]);
    // }

    // public function edit($id)
    // {
    //     $user = User::find($id);
    //     if(!$user) {
    //         return back()->with('error', 'User with id '. $id . ' not found');
    //     }

    //     return view('admin.users.update', [
    //         'title' => 'Update User',
    //         'user' => $user
    //     ]);
    // }

    // public function update(Request $request, $id)
    // {
    //     $user = User::find($id);
    //     if(!$user) {
    //         return back()->with('error', 'user with id '. $id . ' not found');
    //     }

    //     $validation_rules = [
    //         'name' => 'required',
    //         'email' => ['required', 'email:rfc,dns'],
    //         'password' => [],
    //         'telephone' => 'required|numeric',
    //     ];

    //     // if email is different, then check if it is unique
    //     if ($request->input('email') !== $user->email) {
    //         $validation_rules['email'] = ['required', 'email:rfc,dns', 'unique:users'];
    //     }

    //     // if request has password, then validate
    //     if ($request->input('password')) {
    //         $validation_rules['password'] = ['min:6'];
    //     }

    //     $validated = $request->validate($validation_rules);

    //     // if request has password, then hash, else delete password element
    //     if ($validated['password']) {
    //         $validated['password'] = Hash::make($validated['password']);
    //     } else {
    //         unset($validated['password']);
    //     }

    //     if(!User::where('id', $id)->update($validated)) {
    //         return back()->with('error', 'Unable to update user "' . $validated['name'] . '"');
    //     }
    //     return redirect('/admin/users');
    // }

    // public function destroy($id)
    // {
    //     $user = User::find($id);
    //     if(!$user) {
    //         return back()->with('error', 'User with id '. $id . ' not found');
    //     }

    //     User::destroy($id);

    //     return redirect('/admin/users');
    // }

    // public function get_by_email(Request $request) {
    //     if($request->keyword === '') {
    //         return response()->json([], 200);
    //     }

    //     $users = User::where('role', '!=', 'a')->where('email', 'LIKE', '%' . $request->keyword . '%')->get();

    //     return response()->json([
    //         'users' => $users
    //     ], 200);
    // }
}
