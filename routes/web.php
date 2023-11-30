<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
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

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        $users = User::all();
        return view('dashboard',compact('users'));

    })->name('dashboard');
});

/* Route::get('/category',function(){
    return view('admin.category.category');
})->name('AllCat'); */

//Category Routes
Route::get('/all/category',[CategoryController::class,'index'])->name('AllCat');


Route::get('/categories', [CategoryController::class, 'index'])->name('AllCat');


Route::post('/categories', [CategoryController::class, 'AddCategory'])->name('AllCat');
Route::get('/categories/edit/{id}', [CategoryController::class, 'edit'])->name('editCategory');
Route::put('/categories/update/{id}', [CategoryController::class, 'update'])->name('updateCategory');
Route::delete('/categories/delete/{id}', [CategoryController::class, 'destroy'])->name('deleteCategory');