<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminController;

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
    Route::get('/', [ContactController::class, 'contact'])->name('contact.form');
    Route::post('/confirm', [ContactController::class, 'confirm'])->name('contact.confirm');
    Route::post('/send', [ContactController::class, 'send'])->name('contact.send');
    Route::get('/thanks', [ContactController::class, 'thanks'])->name('contact.thanks');

    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');


Route::middleware('auth')->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::delete('/admin/delete/{contact}', [AdminController::class, 'destroy'])->name('admin.destroy');
    Route::get('/export', [AdminController::class, 'export'])->name('admin.export');
});
