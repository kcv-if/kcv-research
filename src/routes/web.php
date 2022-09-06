<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DatasetController;
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
    Route::get('/tags/{uuid}', [TagController::class, 'show']);
    Route::get('/tags/{uuid}/edit', [TagController::class, 'edit']);
    Route::post('/tags', [TagController::class, 'store']);
    Route::put('/tags/{uuid}', [TagController::class, 'update']);
    Route::delete('/tags/{uuid}', [TagController::class, 'destroy']);

    // Tags search by name
    // Route::post('/tags/search', [TagController::class, 'get_by_name'])->name('tags.search');

    // Users
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/create', [UserController::class, 'create']);
    Route::get('/users/{uuid}', [UserController::class, 'show']);
    Route::get('/users/{uuid}/edit', [UserController::class, 'edit']);
    Route::post('/users', [UserController::class, 'store']);
    Route::put('/users/{uuid}', [UserController::class, 'update']);
    Route::delete('/users/{uuid}', [UserController::class, 'destroy']);

    // Users search by name
    // Route::post('/users/search', [UserController::class, 'get_by_email'])->name('users.search');

    // Publications
    // Route::get('/publications', [PublicationController::class, 'index']);
    // Route::get('/publications/create', [PublicationController::class, 'create']);
    // Route::get('/publications/{id}', [PublicationController::class, 'show']);
    // Route::get('/publications/{id}/edit', [PublicationController::class, 'edit']);
    // Route::get('/publications/{id}/review', [PublicationController::class, 'create_review']);
    // Route::post('/publications/{id}/review', [PublicationController::class, 'store_review']);
    // Route::post('/publications', [PublicationController::class, 'store']);
    // Route::put('/publications/{id}', [PublicationController::class, 'update']);
    // Route::delete('/publications/{id}', [PublicationController::class, 'destroy']);

    // Dataset
    // Route::get('/datasets', [DatasetController::class, 'index']);
    // Route::get('/datasets/create', [DatasetController::class, 'create']);
    // Route::get('/datasets/{id}', [DatasetController::class, 'show']);
    // Route::get('/datasets/{id}/edit', [DatasetController::class, 'edit']);
    // Route::get('/datasets/{id}/review', [DatasetController::class, 'create_review']);
    // Route::post('/datasets/{id}/review', [DatasetController::class, 'store_review']);
    // Route::post('/datasets', [DatasetController::class, 'store']);
    // Route::put('/datasets/{id}', [DatasetController::class, 'update']);
    // Route::delete('/datasets/{id}', [DatasetController::class, 'destroy']);
});

Route::redirect('/admin', '/admin/publications');
