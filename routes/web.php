<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

//Frontend
Route::get('/',[FrontendController::class,'index'])->name('index');
Route::get('/author/login/page',[FrontendController::class,'author_login_page'])->name('author.login.page');
Route::get('/author/register/page',[FrontendController::class,'author_register_page'])->name('author.register.page');





Route::get('/dashboard',[HomeController::class,'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');



require __DIR__.'/auth.php';

//backend

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//profile
Route::post('add/user',[UserController::class,'add_user'])->middleware('auth')->name('add.user');
Route::get('/users',[UserController::class,'users'])->middleware('auth')->name('users');
Route::get('/edit/profile',[UserController::class,'edit_profile'])->middleware('auth')->name('edit.profile');
Route::post('/update/profile',[UserController::class,'update_profile'])->name('update.profile'); 
Route::post('/update/password',[UserController::class,'update_password'])->name('update.password'); 
Route::post('/update/photo',[UserController::class,'update_photo'])->name('update.photo'); 
Route::get('/user/delete/{user_id}',[UserController::class,'user_delete'])->name('user.delete'); 

//Category

Route::get('/category',[CategoryController::class,'category'])->middleware('auth')->name('category');
Route::get('/trash',[CategoryController::class,'trash'])->middleware('auth')->name('trash');
Route::post('/category/store',[CategoryController::class,'category_store'])->name('category.store');
Route::get('/category/edit/{category_id}',[CategoryController::class,'category_edit'])->middleware('auth')->name('category.edit');
Route::post('/category/update/{category_id}',[CategoryController::class,'category_update'])->name('category.update');
Route::get('/category/delete/{category_id}',[CategoryController::class,'category_delete'])->name('category.delete');
Route::get('/category/restore/{category_id}',[CategoryController::class,'category_restore'])->name('category.restore');
Route::get('/category/hard/delete/{category_id}',[CategoryController::class,'category_hard_delete'])->name('category.hard.delete');
Route::post('/category/check_delete',[CategoryController::class,'category_check_delete'])->name('category.check.delete');
Route::post('/category/check/restore',[CategoryController::class,'category_check_restore'])->name('category.check.restore');

//tags
Route::get('/tags',[TagController::class,'tags'])->middleware('auth')->name('tags');
Route::post('/tags/store',[TagController::class,'tags_store'])->name('tags.store');
Route::get('/tags/delete/{tag_id}',[TagController::class,'tags_delete'])->name('tags.delete');


//Authors
Route::post('/author/register/post',[AuthorController::class,'author_register'])->name('author.register');
Route::post('/author/login/post',[AuthorController::class,'author_login'])->name('author.login');
Route::get('/author/logout',[AuthorController::class,'author_logout'])->name('author.logout');
Route::get('/author/dashboard',[AuthorController::class,'author_dashboard'])->middleware('author')->name('author.dashboard');


