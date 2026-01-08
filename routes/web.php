<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| IMPORT CONTROLLERS
|--------------------------------------------------------------------------
*/

// Public & User Controllers
use App\Http\Controllers\{
    PageController,
    KostController,
    ContactController,
    RegisterController,
    UserAuthController,
    GoogleController,
    UserProfileController,
    ReviewUserController,
    ReviewController,
    OwnerProfileController,
    PesananController,
    UserDashboardController,
    ProfileController
};

// Admin Controllers
use App\Http\Controllers\Admin\{
    AuthController as AdminAuthController,
    DashboardController,
    KostController as AdminKostController,
    UserController,
    OwnerController,
    PagesController as AdminPagesController,
    ReportController,
    ReviewController as AdminReviewController,
    ActivityController,
    MessageController
};

use App\Models\Report;

/*
|--------------------------------------------------------------------------
| 1. PUBLIC ROUTES (Halaman Depan)
|--------------------------------------------------------------------------
*/
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/sdank', [PageController::class, 'sdank'])->name('sdank');
Route::get('/panduan', [PageController::class, 'panduan'])->name('panduan');
Route::get('/kontak', [PageController::class, 'kontak'])->name('kontak');
Route::post('/kontak/kirim', [ContactController::class, 'store'])->name('kontak.store');

// Daftar & Detail Kost
Route::get('/kost', [KostController::class, 'publicList'])->name('kost.public');
Route::get('/kost/detail/{id}', [KostController::class, 'publicShow'])->name('kost.detail');


/*
|--------------------------------------------------------------------------
| 2. AUTHENTICATION (USER & OWNER)
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
    ->where('role', 'user|pemilik')
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
| 4. GLOBAL AUTH ROUTES (VERIFIKASI EMAIL)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    
    // 1. Proses Verifikasi Link Email
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        $route = $request->user()->role === 'pemilik' ? 'pemilik.profile' : 'user.profile';
        return redirect()->route($route)->with('status', 'Email berhasil diverifikasi!');
    })->middleware('signed')->name('verification.verify');

    // 2. Kirim Ulang Link Verifikasi
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('status', 'Link verifikasi telah dikirim ulang!');
    })->middleware('throttle:6,1')->name('verification.send');
    
});


/*
|--------------------------------------------------------------------------
| 5. AUTHENTICATED USER (KHUSUS PENCARI KOST)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:user'])->group(function () {

    // Dashboard User
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

    // Profile Management
    Route::prefix('user')->group(function () {
        Route::get('/profile', [UserProfileController::class, 'index'])->name('user.profile');
        Route::get('/profile/edit', [UserProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile/update', [UserProfileController::class, 'update'])->name('profile.update');
    });

    // Security Settings
    Route::get('/user/security/password', [ProfileController::class, 'editPassword'])->name('password.edit');
    Route::put('/user/security/password', [ProfileController::class, 'updatePassword'])->name('password.update');

    // Review & Pesanan
    Route::post('/kost/{kostId}/review', [ReviewUserController::class, 'store'])->name('review.store');
    Route::delete('/review/{id}', [ReviewUserController::class, 'destroy'])->name('review.destroy');
    Route::post('/pesanan/{kost}', [PesananController::class, 'store'])->name('pesanan.store');
    // Halaman Utama Ulasan
    Route::get('/ulasan', [PageController::class, 'reviews'])->name('reviews.index');

    // Endpoint Khusus untuk Polling (Cek Ulasan Baru)
    Route::get('/ulasan/check-new', [PageController::class, 'checkNewReviews'])->name('reviews.check');
    });


/*
|--------------------------------------------------------------------------
| 6. PEMILIK KOST AREA (KHUSUS OWNER)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:pemilik'])->prefix('pemilik')->name('pemilik.')->group(function () {

    // Profil & Keamanan
    Route::get('/profil', [OwnerProfileController::class, 'index'])->name('profile'); 
    Route::get('/profil/edit', [OwnerProfileController::class, 'edit'])->name('profile.edit'); 
    Route::put('/profil/update', [OwnerProfileController::class, 'update'])->name('profile.update');

    Route::get('/profil/keamanan', [OwnerProfileController::class, 'editPassword'])->name('password.edit');
    Route::put('/profil/keamanan', [OwnerProfileController::class, 'updatePassword'])->name('password.update');

    // Manajemen Kost
    Route::post('/kost/{id}/delete-photo', [KostController::class, 'deletePhoto'])->name('kost.deletePhoto');
    Route::resource('kost', KostController::class);
});


/*
|--------------------------------------------------------------------------
| 7. ADMIN PANEL
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
        Route::post('/kost/reset-recommendation', [App\Http\Controllers\Admin\KostController::class, 'resetRecommendation'])->name('kost.reset_recommendation');
        Route::post('/kost/ads/{id}', 'updateAds')->name('kost.update_ads'); 
        Route::post('/kost/reset-recommendation', 'resetRecommendation')->name('kost.reset_recommendation');
    });

    // Users & Owners Management
    Route::resource('users', UserController::class)->names('users');
    Route::resource('owners', OwnerController::class)->names('owners');

    Route::controller(OwnerController::class)->group(function () {
        Route::post('/owners/{id}/notes', 'updateNotes')->name('owners.notes');
        Route::patch('/owners/{id}/status', 'toggleStatus')->name('owners.status');
    });

    // Reviews Management
    Route::get('/reviews/export', [AdminReviewController::class, 'exportPdf'])->name('reviews.export');
    Route::patch('/reviews/{id}/toggle', [AdminReviewController::class, 'toggleVisibility'])->name('reviews.toggle');
    Route::resource('reviews', AdminReviewController::class)->only(['index', 'destroy'])->names('reviews');
    
    // Pages Management
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

}); // <--- PENUTUP GRUP ADMIN (INI YANG SEBELUMNYA SALAH POSISI)


/*
|--------------------------------------------------------------------------
| 8. ROUTE DIAGNOSA (Cek Online User)
|--------------------------------------------------------------------------
| Route ini DI LUAR grup admin agar User biasa bisa akses untuk testing.
*/
Route::get('/cek-online', function () {
    // Paksa gunakan guard 'web' untuk melihat data User Biasa/Pemilik
    $user = Illuminate\Support\Facades\Auth::guard('web')->user();
    
    echo "<h1>Hasil Diagnosa Sistem</h1>";
    echo "<p><em>Silakan login sebagai User/Pemilik di tab ini, lalu refresh halaman ini.</em></p><hr>";
    
    // 1. Cek Login
    if (!$user) {
        return "<h3 style='color:red'>❌ Status: BELUM LOGIN (Sebagai User).</h3>
                <p>Silakan login dulu melalui <a href='/login'>Halaman Login</a>.</p>";
    }
    echo "<h3 style='color:green'>✅ Status: LOGIN BERHASIL</h3>";
    echo "<ul>
            <li>Nama: <strong>" . $user->name . "</strong></li>
            <li>Role: <strong>" . $user->role . "</strong></li>
            <li>ID: <strong>" . $user->id . "</strong></li>
          </ul>";

    // 2. Cek Cache Driver
    $cacheDriver = config('cache.default');
    echo "<p>Cache Driver: <strong>" . $cacheDriver . "</strong> " . 
         ($cacheDriver == 'file' || $cacheDriver == 'database' || $cacheDriver == 'redis' ? "✅ (Oke)" : "❌ (Harus file/database)") . "</p>";

    // 3. Tes Update Cache
    $key = 'user-is-online-' . $user->id;
    // Cek apakah middleware sudah membuat cache?
    if (Illuminate\Support\Facades\Cache::has($key)) {
        echo "<h3 style='color:green'>✅ Cache Online Terdeteksi!</h3>";
    } else {
        echo "<h3 style='color:orange'>⚠️ Cache Belum Ada.</h3>";
        echo "<p>Mencoba membuat cache manual sekarang...</p>";
        Illuminate\Support\Facades\Cache::put($key, true, now()->addMinutes(5));
        echo "<p>Cache dibuat manual. Refresh halaman dashboard admin untuk cek.</p>";
    }

    // 4. Cek Database Last Seen
    echo "<p>Database Last Seen: <strong>" . ($user->last_seen ? $user->last_seen->format('d M Y H:i:s') : 'NULL (Belum tercatat)') . "</strong></p>";
    
    echo "<hr><p><strong>Cara Testing Final:</strong><br>
          1. Biarkan halaman ini terbuka (artinya User sedang aktif).<br>
          2. Buka Dashboard Admin di <strong>Browser Lain / Incognito</strong>.<br>
          3. Lihat apakah angka User Online bertambah.</p>";
});