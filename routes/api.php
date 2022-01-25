
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PrimaryAccController;
use App\Http\Controllers\LocationAccController;
use App\Http\Controllers\PaymentTypeController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InvoiceController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


Route::group([
    'middleware' => 'api',
], function ($router) {
   // Route::post('logout', [\App\Http\Controllers\Api\V1\AuthController::class, 'logout'])->name('logout'); 
});

Route::get('invoices/{locationId}', [InvoiceController::class,'getInvoicesByLocation']);


Route::post('login', [UserController::class,'authenticate']);
Route::post('register', [PrimaryAccController::class,'save']);
Route::get('verifyEmail/{code}', [PrimaryAccController::class,'verifyEmail']);

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::post('logout', [UserController::class,'logout']);
    Route::get('user', [UserController::class,'getAuthenticatedUser']);
    // Route::get('invoices/{locationId}', [InvoiceController::class,'getInvoicesByLocation']);
    Route::apiResource('contract', ContractController::class);
    Route::apiResource('account', PrimaryAccController::class);
    Route::get('show-user/{uuid}', [PrimaryAccController::class,'showLoggedUser']);
    Route::apiResource('location', LocationAccController::class);
    Route::apiResource('payment', PaymentTypeController::class);
    Route::delete('payment-backup/{payment}', [PaymentTypeController::class,'destroyBackUp']);
    Route::post('paymentDisable', [PaymentTypeController::class,'disablePayment']);
    Route::post('locationDisable', [LocationAccController::class,'disableLocation']);
    Route::put('enable-loc-status/{locationAcc}', [LocationAccController::class,'edit']);

});

// Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
//     ->middleware(['signed', 'throttle:6,1'])
//     ->name('verification.verify');

// // Resend link to verify email
// Route::post('/email/verify/resend', function (Request $request) {
//     $request->user()->sendEmailVerificationNotification();
//     return back()->with('message', 'Verification link sent!');
// })->middleware(['auth:api', 'throttle:6,1'])->name('verification.send');

///////////////////// Verification by Email
// Route::get('/email/verify', function () {
//     return view('auth.verify-email');
// })->middleware('auth')->name('verification.notice');


// Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
//     $request->fulfill();

//     return redirect('/home');
// })->middleware(['auth', 'signed'])->name('verification.verify');

// Route::post('/email/verification-notification', function (Request $request) {
//     $request->user()->sendEmailVerificationNotification();

//     return back()->with('message', 'Verification link sent!');
// })->middleware(['auth', 'throttle:6,1'])->name('verification.send');
////////////////////////////////////////////