<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControllerUser;
use App\Http\Controllers\ControllerDados;


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

Route::get('/', [ControllerUser::class, 'index'])->name('login.index');
Route::post('/users', [ControllerUser::class, 'store'])->name('users.store');
Route::post('/login', [ControllerUser::class, 'login'])->name('login');
Route::post('/dados', [ControllerDados::class, 'store'])->name('dados.store');
Route::post('/dados/{id}/alterar-peso', [ControllerDados::class, 'alterarpeso'])->name('dados.alterarPeso');

Route::middleware('auth')->group(function () {
    Route::get('/home', [ControllerDados::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [ControllerUser::class, 'logout'])->name('logout');
    Route::get('/users/{email}', [ControllerUser::class, 'getUserByEmail'])->name('users.getByEmail');
});
