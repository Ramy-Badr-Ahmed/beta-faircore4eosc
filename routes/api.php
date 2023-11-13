<?php

use App\Http\Controllers\Beta\ApiController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Laravel\Octane\Facades\Octane;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => '/beta/software-heritage', 'middleware' => 'auth:api' ], function() {

        // ++++++++++++++++++++++++++++++++++++++++++++ Tree-view & On-the-fly-view

    Route::get('/ajaxdb/tabulator', [ ApiController::class, 'apiAjaxTabulator' ])->name('api-ajax-tabulator');

});
