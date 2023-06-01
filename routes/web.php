<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EdulevelController;
use App\Http\Controllers\ProgramController;

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
    return view('welcome', ['title' => 'CodeIn']);
});

Route::get('edulevels', [EdulevelController::class, 'data'])->name('edulevels.index');;
Route::get('edulevels/add', [EdulevelController::class, 'add']);
Route::post('edulevels', [EdulevelController::class, 'addProcess']);
Route::get('edulevels/edit/{id}', [EdulevelController::class, 'edit']);
Route::patch('edulevels/{id}', [EdulevelController::class, 'editProcess']);
Route::delete('edulevels/{id}', [EdulevelController::class, 'delete']);

Route::get('programs/trash', [ProgramController::class, 'trash']);
Route::get('programs/restore/{id?}', [ProgramController::class, 'restore']);
Route::get('programs/delete/{id?}', [ProgramController::class, 'delete']);
Route::resource('programs', ProgramController::class);

Route::get('/login', 'App\Http\Controllers\LoginKaryawanController@showLoginForm')->name('login');
Route::post('/login', 'App\Http\Controllers\LoginKaryawanController@login')->name('login.post');
Route::post('/logout', 'App\Http\Controllers\LoginKaryawanController@logout')->name('logout');

/** Admin Route **/
Route::get("/panel/register", "App\Http\Controllers\Auth\RegisterController@create")->name("register");
Route::post("/panel/register", "App\Http\Controllers\Auth\RegisterController@store")->name("register");

/** Karyawan Route **/
Route::get("/karyawan/register", "App\Http\Controllers\Auth\RegisterKaryawanController@create")->name("register");
Route::post("/karyawan/register", "App\Http\Controllers\Auth\RegisterKaryawanController@store")->name("register");

/** Admin Middleware **/
Route::group(["middleware" => ["auth", "level.check:admin"]], function (){
    Route::get("/home", function () {
        return view("home");
    });
});

/** Karyawan Middleware **/
Route::group(["middleware" => ["auth", "level.check:karyawan"]], function (){
    Route::get("/home", function () {
        return view("home");
    });
});

Route::group(["middleware" => ["auth"]], function () {
    Route::get("/home", function () {
        return view("home");
    });
});
