<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\Admin\PollController as AdminPollController;
use App\Http\Controllers\PollController;
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

Route::get('/poll/{poll}', [PollController::class, 'show']);
Route::get('/poll/{poll}/results', [PollController::class, 'results']);

Route::post('/poll/{poll}/vote', [VoteController::class, 'vote']);

Route::get('/admin/signup/{key}', [AdminAuthController::class, 'show']);
Route::post('/admin/signup/{key}', [AdminAuthController::class, 'store']);

Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->role->slug === 'super_admin' || $user->role->slug === 'admin') {
        return redirect('/admin/polls');
    }
    return redirect('/');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin,super_admin'])->prefix('admin')->group(function () {
    Route::get('/polls', [AdminPollController::class, 'index']);
    Route::get('/polls/create', [AdminPollController::class, 'create']);
    Route::post('/polls', [AdminPollController::class, 'store']);
});

require __DIR__.'/auth.php';
