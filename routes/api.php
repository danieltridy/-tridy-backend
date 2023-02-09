<?php
use App\Http\Controllers\CreationController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/ShowCreations', [CreationController::class,'index']);
Route::post('/UbicationMe', [CreationController::class,'UbicationMe']);
Route::post('/Register', [AuthController::class,'register']);
Route::post('/Login', [AuthController::class,'login']);
Route::post('/RegisterCreation', [CreationController::class,'store']);
Route::post('/Likes', [CreationController::class,'update']);
Route::post('/Looks', [CreationController::class,'Looks']);
Route::post('/Creador', [CreationController::class,'show']);
Route::post('/DeleteCreation', [CreationController::class,'destroy']);
Route::post('/Logout', [AuthController::class,'logout']);
Route::post('/updateTridy', [CreationController::class,'updateTridy']);
Route::post('/MeCreations', [CreationController::class,'MeCreations']);
Route::post('/Views', [CreationController::class,'CreationsView']);



/* Route::resource('creations', CreationController::class); */

Route::group(['middleware'=>['auth:sanctum']], function () {
   


});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
