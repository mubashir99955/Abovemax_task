<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Models\Company;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    if (auth()->user()->usertype === 'admin') {
        return redirect('admin/dashboard');
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route:: get('admin/dashboard', [HomeController::class,'index'])->middleware(['auth','admin'])->name('admin.dashboard');
Route::resource('companies', CompanyController::class)->middleware(['auth','admin']);
Route::resource('employees', EmployeeController::class)->middleware(['auth','admin']);


// Route::get('/companies', [CompanyController::class, 'index'])->name('companies.index')->middleware(['auth','admin']);
// Route::post('/companies/create', [CompanyController::class, 'create'])->name('companies.create')->middleware(['auth','admin']);

// Route::post('/companies', [CompanyController::class, 'store'])->name('companies.store')->middleware(['auth','admin']);
// Route::put('/companies/{company}', [CompanyController::class, 'update'])->name('companies.update')->middleware(['auth','admin']);
// Route::delete('/companies/{company}', [CompanyController::class, 'destroy'])->name('companies.destroy')->middleware(['auth','admin']);

