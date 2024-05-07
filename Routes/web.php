<?php

use Illuminate\Support\Facades\Route;
use Modules\Forms\Http\Controllers\Admin;
use Modules\Forms\Http\Controllers\Client;

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

Route::prefix('/admin/forms')->middleware('permission')->group(function () {
    Route::get('/', [Admin\FormsController::class, 'index'])->name('admin.forms.index');
    Route::get('/create', [Admin\FormsController::class, 'create'])->name('admin.forms.create');
    Route::post('/store', [Admin\FormsController::class, 'store'])->name('admin.forms.store');
    Route::get('/{form}/edit', [Admin\FormsController::class, 'edit'])->name('admin.forms.edit');
    Route::post('/{form}/update', [Admin\FormsController::class, 'update'])->name('admin.forms.update');

    Route::post('/fields/store', [Admin\FormsController::class, 'storeField'])->name('admin.forms.fields.store');

});

Route::prefix('forms')->group(function(){
    Route::get('/{form:slug}', [Client\FormsController::class, 'view'])->name('forms.view');
});