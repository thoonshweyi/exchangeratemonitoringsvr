<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CurrenciesController;
use App\Http\Controllers\DashboardsController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('auth.login');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get("/dashboards",[DashboardsController::class,'index'])->name("dashboards.index");

    Route::resource('users', UsersController::class);

    Route::resource('roles', RolesController::class);

    Route::resource("currencies",CurrenciesController::class);
    Route::delete("/currenciesbulkdeletes",[CurrenciesController::class,"bulkdeletes"])->name("currencies.bulkdeletes");

});

require __DIR__.'/auth.php';
