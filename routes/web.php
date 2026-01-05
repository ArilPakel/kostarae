<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

/*
|--------------------------------------------------------------------------
| IMPORT CONTROLLERS
|--------------------------------------------------------------------------
*/

// Public & User
use App\Http\Controllers\{
    PageController,
    KostController,
    ContactController,
    RegisterController,
    UserAuthController,
    GoogleController,
    UserProfileController,
    ReviewUserController,
    OwnerProfileController,
    PesananController,
    UserDashboardController,
    ProfileController
};

// Admin
use App\Http\Controllers\Admin\{
    AuthController as AdminAuthController,
    DashboardController,
    KostController as AdminKostController,
    UserController,
    OwnerController,
    PagesController as AdminPagesController,
    ReportController,
    ReviewController,
    ActivityController,
    MessageController
};

use App\Models\Report;

/*
|--------------------------------------------------------------------------
| 1. PUBLIC ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/sdank', [PageController::class, 'sdank'])->name('sdank');
Route::get('/panduan', [PageController::class, 'panduan'])->name('panduan');
Route::get('/kontak', [PageController::class, 'kontak'])->name('kontak');

Route::post('/kontak/kirim', [ContactController::class, 'store'])->name('kontak.store');

Route::get('/kost', [KostController::class, 'publicList'])->name('kost.public');
Route::get('/kost/detail/{id}', [KostController::class, 'publicShow'])->name('kost.detail');



/*
|--------------------------------------------------------------------------
| 2. AUTHENTICATION (USER)
|--------------------------------------------------------------------------
*/
// Login / Logout
Route::get('/login', [UserAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UserAuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [UserAuthController::class, 'logout'])->name('logout');

// Register
Route::get('/register/user', [RegisterController::class, 'showUserForm'])->name('register.user');
Route::post('/register/user', [RegisterController::class, 'registerUser'])->name('register.user.submit');

Route::get('/register/owner', [RegisterController::class, 'showOwnerForm'])->name('register.owner');
Route::post('/register/owner', [RegisterController::class, 'registerOwner'])->name('register.owner.submit');

// Google Auth
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/redirect/{role}', [GoogleController::class, 'redirectToGoogle'])
    ->where('role', 'pencari|pemilik')
    ->name('google.redirect');

Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('google.callback');

/*
|--------------------------------------------------------------------------
| 3. ADMIN AUTH
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
});

/*
|--------------------------------------------------------------------------
| 4. AUTHENTICATED USER (UMUM)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

   // DASHBOARD USER
    Route::get('/dashboard', [UserDashboardController::class, 'index'])
        ->name('dashboard');

    // Profile
    Route::prefix('user')->group(function () {
        Route::get('/profile', [UserProfileController::class, 'index'])->name('user.profile');
        Route::get('/profile/edit', [UserProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile/update', [UserProfileController::class, 'update'])->name('profile.update');
    });

    // Security
    Route::get('/user/security/password', [ProfileController::class, 'editPassword'])->name('password.edit');
    Route::put('/user/security/password', [ProfileController::class, 'updatePassword'])->name('password.update');

    // Email Verification
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();

        return redirect()->route(
            $request->user()->role === 'pemilik' ? 'owner.profile' : 'user.profile'
        )->with('status', 'Email berhasil diverifikasi!');
    })->middleware('signed')->name('verification.verify');

    Route::post('/email/verification-notification', [UserProfileController::class, 'resendVerification'])
        ->middleware('throttle:3,1')
        ->name('verification.send');

    // Review Actions
    Route::post('/kost/{id}/review', [ReviewUserController::class, 'store'])->name('review.store');
    Route::put('/review/{id}', [ReviewUserController::class, 'update'])->name('review.update');
    Route::delete('/review/{id}', [ReviewUserController::class, 'destroy'])->name('review.delete');

    // ===============================
    // PESANAN KOST (USER)
    // ===============================
    Route::post('/pesanan/{kost}', [PesananController::class, 'store'])
        ->name('pesanan.store');

    });

/*
|--------------------------------------------------------------------------
| 5. PEMILIK KOST AREA (OWNER)
|--------------------------------------------------------------------------
*/
// Disini kita pakai trik agar 'owner.profile' jalan, tapi resource tetap 'pemilik.kost.*'
Route::middleware(['auth', 'role:pemilik'])->prefix('pemilik')->group(function () {

    // 1. Group untuk Resource KOST (Pakai nama 'pemilik.')
    // Ini memperbaiki error [pemilik.kost.create]
    Route::name('pemilik.')->group(function () {
        Route::get('/dashboard', [OwnerProfileController::class, 'index'])->name('dashboard');
        
        // Route ini menjadi 'pemilik.profile'
        Route::get('/profil', [OwnerProfileController::class, 'index'])->name('profile');

        Route::post('/kost/{id}/delete-photo', [KostController::class, 'deletePhoto'])->name('kost.deletePhoto');
        Route::resource('kost', KostController::class); 
    });

    // 2. Route Alias untuk Profile (Pakai nama 'owner.profile')
    // Ini memperbaiki error [owner.profile] di Navbar
    Route::get('/profil', [OwnerProfileController::class, 'index'])->name('owner.profile');
});

/*
|--------------------------------------------------------------------------
| 6. ADMIN PANEL
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    // Kost Management
    Route::resource('kost', AdminKostController::class)->names('kost');

    Route::controller(AdminKostController::class)->group(function () {
        Route::patch('/kost/{id}/update-status', 'updateStatus')->name('kost.updateStatus');
        Route::post('/kost/{id}/approve', 'approve')->name('kost.approve');
        Route::post('/kost/{id}/reject', 'reject')->name('kost.reject');
        Route::post('/kost/bulk-action', 'bulkAction')->name('kost.bulk');
        Route::put('/kost/{id}/reset', 'resetStatus')->name('kost.reset');
        Route::put('/kost/{id}/force-reset', 'forceReset')->name('kost.force_reset');
        Route::post('/kost/promotion/{id}', 'promote')->name('kost.promote');
    });

    // Users & Owners
    Route::resource('users', UserController::class)->names('users');
    Route::resource('owners', OwnerController::class)->names('owners');

    Route::controller(OwnerController::class)->group(function () {
        Route::post('/owners/{id}/notes', 'updateNotes')->name('owners.notes');
        Route::patch('/owners/{id}/status', 'toggleStatus')->name('owners.status');
    });

    // Reviews (Export sebelum Resource)
    Route::get('/reviews/export', [ReviewController::class, 'exportPdf'])->name('reviews.export');
    Route::patch('/reviews/{id}/toggle', [ReviewController::class, 'toggleVisibility'])->name('reviews.toggle');
    Route::resource('reviews', ReviewController::class)->only(['index', 'destroy'])->names('reviews');
    
    // Pages
    Route::prefix('pages')->name('pages.')->controller(AdminPagesController::class)->group(function () {
        Route::get('/terms', 'terms')->name('terms');
        Route::get('/contact', 'contact')->name('contact');
        Route::get('/guide', 'guide')->name('guide');
    });

    // Reports & Activity
    Route::get('/reports/export', [ReportController::class, 'exportPdf'])->name('reports.export');
    Route::resource('reports', ReportController::class)->only(['index', 'show'])->names('reports');

    Route::get('/activity', [ActivityController::class, 'index'])->name('activity.index');
    Route::get('/activity/{id}', [ActivityController::class, 'show'])->name('activity.show');

    // Pesan Masuk
    Route::get('/pesan-masuk', function () {
        $reports = Report::latest()->get();
        return view('admin.pesan.index', compact('reports'));
    })->name('pesan.index');

    Route::resource('messages', MessageController::class);

}); // <--- Ini tutup kurung ADMIN yang tadi hilang/unclosed