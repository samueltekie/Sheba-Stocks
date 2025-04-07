<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\StocksController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\KycController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmailVerificationController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminStockController;
use App\Http\Controllers\AdminTransactionController;
use App\Http\Controllers\DashboardController;

Route::get('/kyc/step3', [KycController::class, 'showStep3'])->name('kyc.step3');

// Route to handle the final submission of KYC (selfie upload)
Route::post('/kyc/submit-final', [KycController::class, 'submitFinal'])->name('kyc.submitFinal');

Route::get('/transactions/{userId}', [AdminTransactionController::class, 'show'])->name('transactions.show');

Route::delete('/remove-item/{id}', [ProductController::class, 'remove'])->name('remove.item');

//Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/admin/stocksss', [AdminStockController::class, 'index'])->name('admin.stocks.index');
    Route::post('/admin/stocksss', [AdminStockController::class, 'store'])->name('admin.stocks.store');
    Route::delete('/admin/stocksss/{symbol}', [AdminStockController::class, 'destroy'])->name('admin.stocks.destroy');
//});


///////////////
/*Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('stocks', [AdminStockController::class, 'index'])->name('admin.stocks.index');
    Route::get('stocks/create', [AdminStockController::class, 'create'])->name('admin.stocks.create');
    Route::post('stocks', [AdminStockController::class, 'store'])->name('admin.stocks.store');
    Route::get('stocks/{id}/edit', [AdminStockController::class, 'edit'])->name('admin.stocks.edit');
    Route::put('stocks/{id}', [AdminStockController::class, 'update'])->name('admin.stocks.update');
    Route::delete('stocks/{id}', [AdminStockController::class, 'destroy'])->name('admin.stocks.destroy');*/
//});
///////////
//Route::resource('stocks', AdminStockController::class);
//Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
  //  Route::resource('stocks', AdminStockController::class);
//});
////
// User routes
Route::get('/stocks', [StockController::class, 'showStockList'])->name('stocks.list');

// Admin routes

///
//Route::middleware(['auth', 'admin'])->group(function () {
   
    // Other admin routes...
    
    
    //Route::get('/stocks', [AdminStockController::class, 'index'])->name('admin.stocks.index');

//});

// routes/web.php



//////admin routes

/////
Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
Route::get('/admin/transactionss', [AdminTransactionController::class, 'index'])->name('admin.transactions.index');
Route::get('/transactionss/{id}', [AdminTransactionController::class, 'show'])->name('admin.transactions.show');
/////
Route::get('/stocks', [StockController::class, 'index'])->name('admin.stocks.index');
/////
// Admin routes for stock management
//Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
  //  Route::get('/stocks', [AdminStockController::class, 'index'])->name('admin.stocks.index');
    // Add other related stock routes here if needed
//});

//Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    // Admin Transaction Management routes
    
    
//});

//////

Route::get('/admin/userss', [AdminController::class, 'usersIndex'])->name('admin.users.index');
//Route::get('/admin/userss/{id}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
Route::get('/admin/userss/{id}', [AdminUserController::class, 'show'])->name('admin.users.show');
Route::delete('/admin/userss/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
////////
Route::post('/users/{id}/approve-kyc', [AdminUserController::class, 'approveKyc'])->name('admin.users.approveKyc');
Route::post('/users/{id}/reject-kyc', [AdminUserController::class, 'rejectKyc'])->name('admin.users.rejectKyc');
///////////////////
// User routes protected by 'auth' middleware only
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// User routes, protected by 'auth' middleware only
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Add other user-specific routes here
});

// Authentication routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Root route
Route::get('/', function () {
    return view('welcome');
});

//////


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/stockss/list', [StockController::class, 'showStockList'])->name('stocks.list');
});

/////
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Add other routes that require email verification here
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::post('/otp/resend', [OtpController::class, 'resendOtp'])->name('otp.resend');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);


///////
Route::get('/otp/verify', [OtpController::class, 'showVerificationForm'])->name('otp.verify');
Route::post('/otp/verify', [OtpController::class, 'verify'])->name('otp.verify.submit');


Route::get('/otp/verify', [OtpController::class, 'showVerificationForm'])->name('otp.verify');
Route::post('/otp/verify', [OtpController::class, 'verify'])->name('otp.verify.submit');

// Route group for authenticated users
Route::middleware(['auth'])->group(function () {
    Route::get('/email/verify', function () {
        return view('auth.verify-email'); // Your email verification view
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
        ->middleware(['signed'])
        ->name('verification.verify');

    Route::post('/email/verification-notification', [EmailVerificationController::class, 'resend'])
        ->middleware(['throttle:6,1'])
        ->name('verification.send');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    });
});


Route::middleware(['auth'])->group(function () {
    Route::post('/send-otp', [EmailVerificationController::class, 'sendOtp'])->name('email.sendOtp');
    Route::post('/verify-otp', [EmailVerificationController::class, 'verifyOtp'])->name('email.verifyOtp');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
});

Route::get('/kyc/dashboard', [KycController::class, 'showKycDashboard'])->name('kyc.dashboard');
Route::middleware(['auth'])->group(function () {
    Route::get('/kyc/step1', [KycController::class, 'showStep1'])->name('kyc.step1');
    Route::post('/kyc/step1', [KycController::class, 'submitStep1']);
    
    Route::get('/kyc/step2', [KycController::class, 'showStep2'])->name('kyc.step2');
    Route::post('/kyc/step2', [KycController::class, 'submitStep2']);
    
    Route::get('/kyc/step3', [KycController::class, 'showStep3'])->name('kyc.step3');
    Route::post('/kyc/submit', [KycController::class, 'submitFinal'])->name('kyc.submit');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/kyc', [KycController::class, 'index'])->name('kyc.index');
    Route::get('/kyc/create', [KycController::class, 'create'])->name('kyc.create');
    Route::post('/kyc', [KycController::class, 'store'])->name('kyc.store');
    Route::post('/kyc/verify/{id}', [KycController::class, 'verify'])->name('kyc.verify')->middleware('admin');
});
//////////

Route::middleware(['auth'])->group(function () {
    Route::get('/kyc/dashboard', [KycController::class, 'showDashboard'])->name('kyc.dashboard');
    Route::post('/kyc/complete-stage/{stage}', [KycController::class, 'completeStage'])->name('kyc.completeStage');
});
//////

//Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

// web.php
Route::get('/profile/kyc', function () {
    return view('profile.kyc');
})->name('kyc.upload');
// web.php
Route::get('/profile/kyc', function () {
    return view('profile.kyc');
})->name('kyc.form');

// web.php
Route::post('/profile/kyc/upload', 'KycController@upload')->name('kyc.upload');

Route::post('/profile/kyc/upload', 'KycController@upload')->name('kyc.upload');
Route::post('/profile/kyc/upload', 'KycController@upload')->name('kyc.uploadDocument');



// Route to show the KYC upload form
Route::get('/profile/kyc', [KycController::class, 'showUploadForm'])->name('kyc.upload.form');

// Route to handle the upload (POST method)
Route::post('/profile/kyc/upload', [KycController::class, 'storeKycDocument'])->name('kyc.upload');


Route::post('/account/deactivate', [AccountController::class, 'deactivate'])->name('account.deactivate');



// web.php
Route::get('/profile', [UserProfileController::class, 'showProfile'])->name('profile.show');
Route::post('/profile/update', [UserProfileController::class, 'updateProfile'])->name('profile.update');
Route::post('/profile/kyc/upload', [UserProfileController::class, 'uploadKycDocument'])->name('kyc.upload');
// Deactivate/Delete account
Route::delete('/profile/delete', [UserProfileController::class, 'deleteAccount'])->name('profile.delete');
Route::post('/account/delete', [UserProfileController::class, 'deleteAccount'])->name('account.delete');




Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [UserProfileController::class, 'showProfile'])->name('profile.show');
    Route::post('/profile/update', [UserProfileController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/update-password', [UserProfileController::class, 'updatePassword'])->name('profile.update.password');
    Route::post('/profile/upload-kyc', [UserProfileController::class, 'uploadKycDocument'])->name('profile.upload.kyc');
});


// Show the user's wallet
Route::get('/wallet', [WalletController::class, 'show'])->name('wallet.show');

// Deposit funds
Route::post('/wallet/deposit', [WalletController::class, 'deposit'])->name('wallet.deposit');

// Withdraw funds
Route::post('/wallet/withdraw', [WalletController::class, 'withdraw'])->name('wallet.withdraw');

// Route for viewing the wallet


Route::middleware(['auth'])->get('/wallet/{id}', [WalletController::class, 'show'])->name('wallet.show');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/stocks', [StocksController::class, 'index'])->name('stocks.list');

Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);



// Other routes...
Route::get('/stocks/data', [StockController::class, 'fetchStockData']);

Route::get('/stocks/{symbol}', [StockController::class, 'show'])->name('stocks.show');
Route::post('/stocks/buy', [StockController::class, 'buyStock'])->name('stocks.buy');

Route::get('/stocks/list', [AuthenticatedSessionController::class, 'showStocksList'])->name('stocks.list');
Route::get('/stockss/list', [StockController::class, 'showStockList'])->name('stock.list');

Route::get('/stocks', [StockController::class, 'index']);

Route::get('stocks/realtime/{symbol}', [StockController::class,'fetchRealTimeData']);

Route::get('/', function () {
    return view('welcome');
});
