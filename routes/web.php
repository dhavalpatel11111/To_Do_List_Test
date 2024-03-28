<?php

// use App\Http\Controllers\TodoController;
use App\Http\Controllers\TodolistController;
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

Route::any("/add_todo" , [TodolistController::class , "add"])->middleware("auth");
Route::any("/todo_list" , [TodolistController::class , "todo_list"])->middleware("auth");
Route::any("/delete_todo" , [TodolistController::class , "delete_todo"])->middleware("auth");
Route::any("/edit" , [TodolistController::class , "edit"])->middleware("auth");

// Route::get('/todopage', function () {
//     return view('todo_page');
// })->middleware("auth");

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
