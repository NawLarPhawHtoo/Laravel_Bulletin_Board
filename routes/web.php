<?php

use App\Http\Controllers\Post\PostController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
Auth::routes(['register' => false]);

Route::get('/', function () {
  return redirect()->route('posts.search');
});

Auth::routes();

Route::get('/posts', [PostController::class, 'index'])->name('posts.search');

Route::group(['middleware' => ['auth']], function () {
  Route::get('/posts', [PostController::class, 'index'])->name('posts.search');
  Route::get('/posts/my-posts', [PostController::class, 'ownpost'])->name('posts.my-posts');
  Route::get('/post/create', [PostController::class, 'create'])->name('posts.create');
  Route::post('/post/create', [PostController::class, 'confirmPostCreate'])->name('posts.confirm-create');
  Route::get('/post/create/confirm', [PostController::class, 'showPostConfirm'])->name('posts.view-create-confirm');
  Route::post('/post/create/confirm', [PostController::class, 'store'])->name('posts.store');
  Route::get('/post/edit/{id}', [PostController::class, 'edit'])->name('posts.edit');
  Route::post('/post/edit/{id}', [PostController::class, 'confirmPostEdit'])->name('posts.confirm-edit');
  Route::get('/post/edit-confirm/{id}', [PostController::class,'showEditConfirm'])->name('posts.view-edit-confirm');
  Route::post('/post/edit-confirm/{id}', [PostController::class, 'update'])->name('posts.update');
  Route::delete('/post/delete/{id}', [PostController::class, 'destroy'])->name('posts.destroy');
  Route::get('/post/upload', [PostController::class, 'upload'])->name('posts.upload');
  Route::post('/post/upload', [PostController::class, 'importExcel'])->name('posts.fileupload');
  Route::get('/posts/download', [PostController::class, 'export'])->name('posts.export');
});

Route::group(['middleware' => ['auth']], function () {
  Route::get('/user/profile', [UserController::class, 'showProfile'])->name('users.profile');
  Route::get('/user/profile/edit', [UserController::class, 'showProfileEdit'])->name('profile.edit');
  Route::post('/user/profile/edit', [UserController::class, 'submitProfileEdit'])->name('profile.edit');
  Route::get('/user/profile/edit/confirm', [UserController::class, 'showProfileEditConfirm'])->name('profile.edit.confirm');
  Route::post('/user/profile/edit/confirm', [UserController::class, 'submitProfileEditConfirm'])->name('profile.edit.confirm'); 

  Route::get('/user/change-password', [UserController::class, 'showChangePassword'])->name('change.password');
  Route::post('/user/change-password', [UserController::class, 'savePassword'])->name('change.password');
});

Route::group(['middleware' => ['admin']], function () {
  Route::get('/users', [UserController::class, 'search'])->name('userlist');
  Route::get('/user/create', [UserController::class, 'showCreateView'])->name('users.create');
  Route::post('/user/create', [UserController::class, 'confirmUserCreate'])->name('users.confirm-create');
  Route::get('/user/create/confirm', [UserController::class, 'showUserConfirm'])->name('users.view-create-confirm');
  Route::post('/user/create/confirm', [UserController::class, 'submitRegistrationConfirmView'])->name('users.store');
  Route::get('/user/edit/{id}', [UserController::class, 'editUser'])->name('users.edit');
  Route::post('/user/edit/{id}', [UserController::class, 'confirmUserEdit'])->name('users.confirm-edit');
  Route::get('/user/edit-confirm/{id}', [UserController::class,'showEditConfirm'])->name('users.view-edit-confirm');
  Route::post('/user/edit-confirm/{id}', [UserController::class, 'update'])->name('users.update');
  Route::delete('/user/delete/{id}', [UserController::class, 'destroy'])->name('users.destroy');
});

