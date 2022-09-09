<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Slices\User\UseCase\IDeleteUserUseCase;
use App\Slices\User\UseCase\IGetAllUserUseCase;
use App\Slices\User\UseCase\IGetByUuidUserUseCase;
use App\Slices\User\UseCase\IStoreUserUseCase;
use App\Slices\User\UseCase\IUpdateUserUseCase;
use App\Slices\User\UseCase\StoreUserRequest;
use App\Slices\User\UseCase\UpdateUserRequest;
use Exception;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct(
        private IGetAllUserUseCase $getAllUserUseCase,
        private IStoreUserUseCase $storeUserUseCase,
        private IGetByUuidUserUseCase $getByUuidUserUseCase,
        private IUpdateUserUseCase $updateUserUseCase,
        private IDeleteUserUseCase $deleteUserUseCase
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

    public function show($uuid)
    {
        try {
            $response = $this->getByUuidUserUseCase->execute($uuid);
            return view('admin.users.show', [
                'title' => 'User\'s Details',
                'user' => $response
            ]);
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function edit($uuid)
    {
        try {
            $response = $this->getByUuidUserUseCase->execute($uuid);
            return view('admin.users.update', [
                'title' => 'Update User',
                'user' => $response
            ]);
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, $uuid)
    {
        try {
            $this->updateUserUseCase->execute(new UpdateUserRequest(
                $uuid,
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

    public function destroy($uuid)
    {
        try {
            $this->deleteUserUseCase->execute($uuid);
            return redirect('/admin/users');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

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
