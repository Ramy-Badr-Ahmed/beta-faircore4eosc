<?php

use App\Http\Controllers\Auth\VerificationController;
use App\Http\Middleware\SetNonce;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\GenerateNonce;
use App\Http\Controllers\Beta\SoftwareHeritageController;
use App\Http\Controllers\Beta\LivewireController;

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
        return response()
            ->view('landing')
            ->header('Landed', Str::random(8));})->name('home');

    Route::get('/imprint', function () {
        return response()->view('pages.general.imprint');})->name('imprint');

    Route::get('/privacy', function () {
        return view('pages.general.privacy');})->name('privacy');



    Auth::routes();


    Route::group(['prefix' => 'email'], function (){

        Route::get('verify', [VerificationController::class, 'show'])
            ->name('verification.notice');

        Route::get('verify/{id}/{hash}', [VerificationController::class, 'serveVerificationLink'])
            ->name('verification.verify');

        Route::post('verification-notification', [VerificationController::class, 'resendVerificationLink'])
            ->name('verification.resend');

    });


    Route::group(['prefix' => 'beta', 'middleware' => ['auth', 'auth.session', 'verified', GenerateNonce::class, SetNonce::class] ], function (){


    // ----------------------------------------SWH: Tree View--------------------------------------------------------------------------------------------

        Route::match(['get','post'], 'archival-view-1', [ SoftwareHeritageController::class, 'archivalRequests'])->name('tree-view');


    // ----------------------------------------SWH: On-The-Fly View  -------------------------------------------------------------------------------------

        Route::match(['get','post'], 'archival-view-2', [ SoftwareHeritageController::class, 'archivalRequests'])->name('on-the-fly-view');


    // ---------------------------------------- SWH: Mass Archive View ------------------------------------------------------------------------------------

        Route::get('archival-view-3', [ LivewireController::class, 'bundle' ])->name('lw-mass-view');


    // ----------------------------------------CodeMeta--------------------------------------------------------------------------------------------------

        Route::get('sw-metadata', [ LivewireController::class, 'metaPanels' ])->name('lw-meta-form');


    // ---------------------------------------- Under Construction View -----------------------------------------------------------------------------------

        Route::get('swh-api', [ SoftwareHeritageController::class, 'underConstruction' ])
            ->withoutMiddleware([GenerateNonce::class, SetNonce::class])
            ->name('uc');


    // ---------------------------------------- Feedback View ----------------------------------------------------------------------------------------------

        Route::match(['get','post'], 'feedback', [ SoftwareHeritageController::class, 'feedbackForm' ])
            ->middleware('password.confirm:,3600 ')
            ->name('feedback');

});


