<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('landing');
})->name('landing');

Route::get('/login', function () {
    return redirect('/')->with('error', 'Akses ditolak! Anda harus melakukan login terlebih dahulu.');
})->name('login');

Route::get('/operator/lendings/{id}/pdf',
    [LendingController::class,'exportPdf']
)->name('operator.lendings.pdf');

Route::get('/lendings/{id}/pdf', [LendingController::class, 'exportPdf'])
    ->name('operator.lendings.pdf');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin', function () {
        return view('admin');
    })->name('admin')->middleware('role:admin');

    Route::middleware('role:admin')->group(function() {
        Route::resource('admin/categories', \App\Http\Controllers\CategoryController::class)
            ->names('admin.categories')
            ->except(['show', 'destroy']);
    });

    // Rute bersama untuk Admin & Operator
    Route::middleware('role:admin,operator')->group(function() {
        Route::get('admin/items/export', [\App\Http\Controllers\ItemController::class, 'export'])->name('admin.items.export');
        Route::get('admin/items/{item}/lendings', [\App\Http\Controllers\ItemController::class, 'showLendings'])->name('admin.items.lendings');
        Route::resource('admin/items', \App\Http\Controllers\ItemController::class)
            ->names('admin.items')
            ->except(['show', 'destroy']);

        Route::get('admin/users/export', [\App\Http\Controllers\UserController::class, 'export'])->name('admin.users.export');
        Route::patch('admin/users/{user}/reset-password', [\App\Http\Controllers\UserController::class, 'resetPassword'])->name('admin.users.reset-password');
        Route::resource('admin/users', \App\Http\Controllers\UserController::class)
            ->names('admin.users')
            ->except(['show']);
    });

    // Rute mutlak hanya untuk Operator
    Route::middleware('role:operator')->group(function() {
        Route::get('operator/lendings/export', [\App\Http\Controllers\LendingController::class, 'export'])->name('operator.lendings.export');
        Route::patch('operator/lendings/{lending}/return', [\App\Http\Controllers\LendingController::class, 'markReturned'])->name('operator.lendings.return');
        Route::resource('operator/lendings', \App\Http\Controllers\LendingController::class)
            ->names('operator.lendings')
            ->except(['show', 'edit', 'update']);

        Route::get('/operator', function () {
            return view('staff');
        })->name('operator');
    });
});
