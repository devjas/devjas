<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\DashboardPagesController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\SingerController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\TourArchivesController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserMessageController;
use App\Http\Controllers\Auth\AdminAuthController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

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

// FRONT-END
Route::get('/', [PagesController::class, 'getIndex'])->name('homepage');
Route::get('/tour-list', [PagesController::class, 'getTours'])->name('tour-list');
Route::get('/tour-details/{tour_id}', [PagesController::class, 'getTourDetails'])->name('tour-details');
Route::get('/about', [PagesController::class, 'getAbout']);
Route::get('/user-register', [PagesController::class, 'getUserRegister'])->name('user-register');
Route::get('/user-sign-in', [PagesController::class, 'getUserSignIn'])->name('user-sign-in');

Route::get('/test-page', [PagesController::class, 'testPage'])->name('test-page');
Route::post('/get-string', [PagesController::class, 'getString'])->name('get-string');


// BACK-END
Route::group(['middleware'=> ['auth', 'verified']], function() {
	Route::get('dashboard', [DashboardPagesController::class, 'getDashboard'])->name('dashboard');
	Route::delete('/remove-singer-from-tours/{singer_id}', [DashboardPagesController::class, 'remove_singer_from_all_tours'])->name('remove.tour.singer');
	Route::resource('tours', TourController::class);
	Route::resource('singers', SingerController::class);
	Route::resource('archives', TourArchivesController::class);
	Route::put('restore/{archive}', [TourArchivesController::class, 'restore_archived_tour'])->name('restore.archived');
	Route::resource('/status', StatusController::class);
});


// If the account is blocked by the administrator
Route::get('/account-blocked', [UserMessageController::class, 'blockedUserMessage'])->name('account-blocked');

Route::get('/email/verify', function() {
	return view('concert-back.pages.email-verify');
})->middleware('auth')->name('verification.notice');

// ADMIN PAGES
Route::group(['prefix'=>'admin','middleware'=>['guest:admin']], function() {
	Route::get('admin-login', [AdminAuthController::class, 'getLogin'])->name('admin-login');
	Route::post('admin-login', [AdminAuthController::class, 'postLogin'])->name('post-login');
});

Route::group(['prefix'=>'admin','middleware'=>['auth:admin']], function() {
	Route::get('admin-dashboard', [AdminController::class, 'adminDashboard'])->name('admin-dashboard');
	Route::post('logout-admin', [AdminAuthController::class, 'logoutAdmin'])->name('logout-admin');
	Route::get('approved-tours', [AdminController::class, 'approvedTours'])->name('approved-tours');
	Route::get('not-approved-tours', [AdminController::class, 'notApprovedTours'])->name('not-approved-tours');
	Route::get('blocked-tours', [AdminController::class, 'blockedTours'])->name('blocked-tours');
	Route::get('deleted-tours/{user_email?}', [AdminController::class, 'deletedTours'])->name('deleted-tours');
	
	Route::get('admin-tour-details/{tour_id}', [AdminController::class, 'adminTourDetails'])->name('admin-tour-details');
	Route::put('admin-approval/{tour_id}', [AdminController::class, 'tourApproval'])->name('admin-approval');
	Route::put('admin-blocking/{tour_id}', [AdminController::class, 'tourBlocking'])->name('admin-blocking');
	Route::get('verified-users', [AdminController::class, 'verifiedUsers'])->name('verified-users');
	Route::get('not-verified-users', [AdminController::class, 'notVerifiedUsers'])->name('not-verified-users');
	Route::get('blocked-users', [AdminController::class, 'blockedUsers'])->name('blocked-users');
	Route::get('user-details/{user_id}', [AdminController::class, 'userDetails'])->name('user-details');
	Route::put('is-user-active/{user_id}', [AdminController::class, 'userActivation'])->name('is-user-active');
	Route::put('manual-email-verification/{user_id}', [AdminController::class, 'manualEmailVerification'])->name('manual-email-verification');
});


// EMAIL VERIFICATION AFTER REGISTRATION
Route::get('/email/verify/{id}/{hash}', function(EmailVerificationRequest $request){
	
	$request->fulfill();
	return redirect('/dashboard');

})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {

    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');

})->middleware(['auth', 'throttle:6,1'])->name('verification.resend');


// AUTHENTICATES USER
Auth::routes();
