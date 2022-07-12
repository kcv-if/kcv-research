<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PublicationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->group(function () {
    Route::get('/publications', function () {
        return view('admin.publications.index', ['title' => 'Publications']);
    });

    Route::get('/datasets', function () {
        return view('admin.datasets.index', ['title' => 'Datasets']);
    });

    // Tags
    Route::get('/tags', [TagController::class, 'index']);
    Route::get('/tags/create', [TagController::class, 'create']);
    Route::get('/tags/{id}', [TagController::class, 'show']);
    Route::get('/tags/{id}/edit', [TagController::class, 'edit']);
    Route::get('/tags/{id}/publications', [TagController::class, 'show_publications']);
    Route::get('/tags/{id}/datasets', [TagController::class, 'show_datasets']);
    Route::post('/tags', [TagController::class, 'store']);
    Route::put('/tags/{id}', [TagController::class, 'update']);
    Route::delete('/tags/{id}', [TagController::class, 'destroy']);

    // Users
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/create', [UserController::class, 'create']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::get('/users/{id}/edit', [UserController::class, 'edit']);
    Route::get('/users/{id}/publications', [UserController::class, 'show_publications']);
    Route::get('/users/{id}/datasets', [UserController::class, 'show_datasets']);
    Route::post('/users', [UserController::class, 'store']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);

    // Publications
    Route::get('/publications', [PublicationController::class, 'index']);
});

Route::redirect('/admin', '/admin/publications');