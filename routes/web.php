<?php

use Illuminate\Support\Facades\Route;

// PUBLIC CONTROLLERS
use App\Http\Controllers\KostController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\ReviewUserController;

// ADMIN CONTROLLERS
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KostController as KostAdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\OwnerController;
use App\Http\Controllers\Admin\PagesController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\ActivityController;


/*
|--------------------------------------------------------------------------
| PUBLIC KOST
|--------------------------------------------------------------------------
*/
Route::get('/kost', [KostController::class, 'publicList'])->name('kost.public');
Route::get('/kost/detail/{id}', [KostController::class, 'publicShow'])->name('kost.detail');

Route::post('/kost/{id}/review', [ReviewUserController::class, 'store'])->name('review.store');
Route::put('/review/{id}', [ReviewUserController::class, 'update'])->name('review.update');
Route::delete('/review/{id}', [ReviewUserController::class, 'destroy'])->name('review.delete');

/*
|--------------------------------------------------------------------------
| PEMILIK KOST
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:pemilik'])
    ->prefix('pemilik')->name('pemilik.')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('dashboard.pemilik');
        })->name('dashboard');

        Route::post('/kost/{id}/delete-photo', [KostController::class, 'deletePhoto'])
            ->name('kost.deletePhoto');

        Route::resource('kost', KostController::class)
            ->names('kost');
    });

/*
|--------------------------------------------------------------------------
| PUBLIC PAGES
|--------------------------------------------------------------------------
*/
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/sdank', [PageController::class, 'sdank'])->name('sdank');
Route::get('/panduan', [PageController::class, 'panduan'])->name('panduan');
Route::get('/kontak', [PageController::class, 'kontak'])->name('kontak');

/*
|--------------------------------------------------------------------------
| USER DASHBOARD
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', fn () => view('dashboard.user'))->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| USER REGISTER & LOGIN
|--------------------------------------------------------------------------
*/
Route::get('/register/user', [RegisterController::class, 'showUserForm'])->name('register.user');
Route::post('/register/user', [RegisterController::class, 'registerUser'])->name('register.user.submit');

Route::get('/register/owner', [RegisterController::class, 'showOwnerForm'])->name('register.owner');
Route::post('/register/owner', [RegisterController::class, 'registerOwner'])->name('register.owner.submit');

Route::get('/login', [UserAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UserAuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [UserAuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| ADMIN LOGIN
|--------------------------------------------------------------------------
*/
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');

/*
|--------------------------------------------------------------------------
| ADMIN AREA
|--------------------------------------------------------------------------
*/
Route::middleware('admin')
    ->prefix('admin')->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Extra actions Kost (Approve / Reject)
        Route::patch('/kost/{kost}/approve', [KostAdminController::class, 'approve'])->name('kost.approve');
        Route::patch('/kost/{kost}/reject', [KostAdminController::class, 'reject'])->name('kost.reject');

        // Fitur "Panding")
        Route::put('/admin/kost/{id}/reset', [AdminKostController::class, 'resetStatus'])->name('admin.kost.reset');

        // Route untuk menghapus kost
        Route::delete('/admin/kost/{id}/delete', [AdminKostController::class, 'destroy'])->name('admin.kost.destroy');

        // CRUD Kost Admin (AUTO -> admin.kost.*)
        Route::resource('kost', KostAdminController::class)->names('kost');

        // Admin Users
        Route::resource('users', UserController::class)->names('users');

        // Admin Owners
        Route::resource('owners', OwnerController::class)->names('owners');

        // Static Pages
        Route::get('/pages/terms', [PagesController::class, 'terms'])->name('pages.terms');
        Route::get('/pages/contact', [PagesController::class, 'contact'])->name('pages.contact');
        Route::get('/pages/guide', [PagesController::class, 'guide'])->name('pages.guide');

        // Reviews, Reports, Activity
        Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/activity', [ActivityController::class, 'index'])->name('activity.index');

        // Admin Logout
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    });
