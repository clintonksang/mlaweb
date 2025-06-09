<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Admin\AuthController;
use App\Http\Controllers\Api\AppController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\LoanController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthorizationController;
use App\Http\Controllers\Api\WithdrawController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\TicketController;
use App\Http\Controllers\Api\ProspectController;

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

Route::controller(AppController::class)->group(function () {
    Route::get('general-setting', 'generalSetting');
    Route::get('get-countries', 'getCountries');
    Route::get('language/{key}', 'getLanguage');
    Route::get('policies', 'policies');
    Route::get('policy-detail/{id}', 'policyDetail');
    Route::get('faq', 'faq');
});

Route::post('admin/create', [AuthController::class, 'createAdmin']);
Route::post('admin/login', [AuthController::class, 'login']);

Route::controller(LoginController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('check-token', 'checkToken');
    Route::post('social-login', 'socialLogin');
});

Route::post('register', [RegisterController::class, 'register']);

Route::controller(ForgotPasswordController::class)->group(function () {
    Route::post('password/email', 'sendResetCodeEmail');
    Route::post('password/verify-code', 'verifyCode');
    Route::post('password/reset', 'reset');
});

Route::middleware('auth:sanctum')->group(function () {

    Route::post('user-data-submit', [UserController::class, 'userDataSubmit']);

    //authorization
    Route::middleware('registration.complete')->controller(AuthorizationController::class)->group(function () {
        Route::get('authorization', 'authorization');
        Route::get('resend-verify/{type}', 'sendVerifyCode');
        Route::post('verify-email', 'emailVerification');
        Route::post('verify-mobile', 'mobileVerification');
        Route::post('verify-g2fa', 'g2faVerification');
    });

    Route::middleware(['check.status'])->group(function () {

        Route::middleware('registration.complete')->group(function () {

            Route::controller(UserController::class)->group(function () {
                Route::get('dashboard', 'dashboard');
                Route::get('user-info', 'userInfo');
                Route::get('users', 'getUsers');
                
                Route::post('profile-setting', 'submitProfile');
                Route::post('change-password', 'submitPassword');

                Route::get('user-info', 'userInfo');
                //KYC
                Route::get('kyc-form', 'kycForm');
                Route::post('kyc-submit', 'kycSubmit');
                Route::get('kyc-data', 'kycData');

                //Report
                Route::any('deposit/history', 'depositHistory');
                Route::get('transactions', 'transactions');
                Route::get('notification/history', 'notificationHistory');
                Route::get('notification/detail/{id}', 'notificationDetail');

                Route::post('add-device-token', 'addDeviceToken');
                Route::get('push-notifications', 'pushNotifications');
                Route::post('push-notifications/read/{id}', 'pushNotificationsRead');

                //2FA
                Route::get('twofactor', 'show2faForm');
                Route::post('twofactor/enable', 'create2fa');
                Route::post('twofactor/disable', 'disable2fa');

                Route::post('delete-account', 'deleteAccount');
            });

            // Withdraw
            Route::controller(WithdrawController::class)->group(function () {
                Route::middleware('kyc')->group(function () {
                    Route::get('withdraw-method', 'withdrawMethod');
                    Route::post('withdraw-request', 'withdrawStore');
                    Route::post('withdraw-request/confirm', 'withdrawSubmit');
                });
                Route::get('withdraw/history', 'withdrawLog');
            });

            // Payment
            Route::controller(PaymentController::class)->group(function () {
                Route::get('deposit/methods', 'methods');
                Route::post('deposit/insert', 'depositInsert');
                Route::post('app/payment/confirm', 'appPaymentConfirm');
            });

            Route::controller(LoanController::class)->group(function () {
                Route::get('loan/plans', 'plans');
                Route::get('loan/my-loans', 'list');
                Route::post('loan/apply/{id}', 'applyLoan');
                Route::post('loan/confirm/{id}', 'loanConfirm');
                Route::get('loan/instalment/logs/{id}', 'installments');
            });

            Route::controller(TicketController::class)->prefix('ticket')->group(function () {
                Route::get('/', 'supportTicket');
                Route::post('create', 'storeSupportTicket');
                Route::get('view/{ticket}', 'viewTicket');
                Route::post('reply/{id}', 'replyTicket');
                Route::post('close/{id}', 'closeTicket');
                Route::get('download/{attachment_id}', 'ticketDownload');
            });

            // Prospects API
            Route::controller(ProspectController::class)->prefix('prospects')->group(function () {
                Route::get('/', 'index');                    // GET /api/prospects
                Route::post('/', 'store');                   // POST /api/prospects
                Route::get('{uuid}', 'show');               // GET /api/prospects/{uuid}
                Route::put('{uuid}', 'update');             // PUT /api/prospects/{uuid}
                Route::delete('{uuid}', 'destroy');         // DELETE /api/prospects/{uuid}
            });

        });
    });

    Route::get('logout', [LoginController::class, 'logout']);
});

// Agent Requests (API)
Route::post('agent-request', [\App\Http\Controllers\Admin\AgentRequestController::class, 'store']);

Route::get('mock-api', function () {
    return response()->json(['message' => 'api initiated']);
});

// Health Check API
Route::get('health', function () {
    return response()->json([
        'status' => 'ok',
        'message' => 'API is running',
        'timestamp' => now()->toIso8601String()
    ]);
});
