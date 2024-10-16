<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::middleware('auth')->group( function()
// {
//     Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
//     Route::get('/permissions/create', [PermissionController::class, 'create'])->name('permissions.create');
//     Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store');
//     Route::get('/permissions/{id}/edit', [PermissionController::class, 'edit'])->name('permissions.edit');
//     Route::post('/permissions/{id}/edit', [PermissionController::class, 'update'])->name('permissions.update');
//     Route::delete('/permissions', [PermissionController::class, 'destroy'])->name('permissions.destroy');

//     Route::resource('roles', RoleController::class);
//     Route::resource('articles', ArticleController::class);
//     Route::resource('users', UserController::class);
// });

Route::group(['prefix' => 'backend', 'middleware' => 'auth'], function () {

    Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index')->middleware('permission:view permissions');
    Route::get('/permissions/create', [PermissionController::class, 'create'])->name('permissions.create')->middleware('permission:create permissions');
    Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store')->middleware('permission:create permissions');
    Route::get('/permissions/{id}/edit', [PermissionController::class, 'edit'])->name('permissions.edit')->middleware('permission:edit permissions');
    Route::post('/permissions/{id}/edit', [PermissionController::class, 'update'])->name('permissions.update')->middleware('permission:edit permissions');
    Route::delete('/permissions', [PermissionController::class, 'destroy'])->name('permissions.destroy')->middleware('permission:delete permissions');

    // Route::resource('permissions', PermissionController::class)->middleware([
    //     'index' => 'permission:view permissions',
    //     'create' => 'permission:create permissions',
    //     'store' => 'permission:create permissions',
    //     'edit' => 'permission:edit permissions',
    //     'update' => 'permission:edit permissions',
    //     'destroy' => 'permission:delete permissions',
    // ]);
    Route::resource('roles', RoleController::class)->middleware([
        'index' => 'permission:view roles',
        'create' => 'permission:create roles',
        'store' => 'permission:create roles',
        'edit' => 'permission:edit roles',
        'update' => 'permission:edit roles',
        'destroy' => 'permission:delete roles',
    ]);
    Route::resource('articles', ArticleController::class)->middleware([
        'index' => 'permission:view articles',
        'create' => 'permission:create articles',
        'store' => 'permission:create articles',
        'edit' => 'permission:edit articles',
        'update' => 'permission:edit articles',
        'destroy' => 'permission:delete articles',
    ]);
    Route::resource('users', UserController::class)->middleware([
        'index' => 'permission:view users',
        // 'create' => 'permission:create users',
        // 'store' => 'permission:create users',
        'edit' => 'permission:edit users',
        'update' => 'permission:edit users',
        // 'destroy' => 'permission:delete users',
    ]);
});
