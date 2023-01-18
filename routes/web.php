<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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


Route::get('/', App\Http\Livewire\SuppliumLogin::class)->name('/');
Route::get('/dashboard', App\Http\Livewire\SuppliumDashboard::class)->name('dashboard')->middleware('checkrole');

Route::get('/bag', App\Http\Livewire\SuppliumBag::class)->name('bag')->middleware('checkrole');

Route::get('/items', App\Http\Livewire\SuppliumItems::class)->name('items')->middleware('checkrole');
Route::get('/list', App\Http\Livewire\SuppliumBrowseItems::class)->name('list')->middleware('checkrole');

Route::get('/requests', App\Http\Livewire\SuppliumRequests::class)->name('requests')->middleware('checkrole');
Route::get('/myrequests', App\Http\Livewire\SuppliumBrowseRequests::class)->name('myrequests')->middleware('checkrole');

Route::get('/users', App\Http\Livewire\SuppliumUsers::class)->name('users')->middleware('checkrole');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');