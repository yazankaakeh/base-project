<?php

use Illuminate\Support\Facades\Route;
use Modules\Blog\app\Http\Controllers\BlogCategoryController;
use Modules\Blog\app\Http\Controllers\BlogPostController;
use Modules\Blog\app\Http\Controllers\BlogTagController;

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

Route::middleware(['auth:doctor', 'admin-enabled', 'doctorMenu', 'audit'])->prefix('admin')->group(function () {
    Route::resource('admin/blog', BlogPostController::class)->names('blogPosts.posts');
    Route::resource('admin/category', BlogCategoryController::class)->names('blogCategory.category')
        ->only('store', 'index', 'destroy');
    Route::put('admin/category/update', [BlogCategoryController::class, 'update'])->name(
        'blogCategory.category.update',
    );

    Route::resource('admin/tags', BlogTagController::class)->names('blogTags.tags')
        ->only('store', 'index', 'destroy');
    Route::put('admin/tags/update', [BlogTagController::class, 'update'])->name('blogTags.tags.update');
    Route::resource('admin/post-type', BlogPostController::class)->names('blogPostType.postType')
        ->only('store', 'index', 'destroy', 'update');
    /*dd(BlogTag::query()->first()->getTranslation('ar', 'name'),
      BlogCategory::query()->first()->getTranslation('ar', 'name'));*/
});
