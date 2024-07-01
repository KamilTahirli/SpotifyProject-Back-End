<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Front\MusicController as FrontMusicController;
use App\Http\Controllers\Front\ArtistController as FrontArtistController;
use App\Http\Controllers\Front\CategoryController as FrontCategoryController;
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


Route::group(['prefix' => 'v1'], function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::post('/login', [LoginController::class, 'login']);
        Route::post('/register', [RegisterController::class, 'register']);
    });
    Route::group(['prefix' => 'musics'], function () {
        Route::get('/get-music-data', [FrontMusicController::class, 'getMusicData']);
        Route::get('/get-trend-musics', [FrontMusicController::class, 'getTrendMusics']);
        Route::get('/search-music', [FrontMusicController::class, 'searchMusic']);
        Route::get('/details', [FrontMusicController::class, 'getMusicDetail']);
        Route::get('/similar', [FrontMusicController::class, 'getSimilarMusics']);
        Route::get('/download/{musicName}', [FrontMusicController::class, 'getMusicDownload']);
        Route::post('/save-music', [FrontMusicController::class, 'saveMusicToDb']);
        Route::post('/convert', [FrontMusicController::class, 'getConvertedMp3Url']);
    });
    Route::group(['prefix' => 'artists'], function () {
        Route::get('/limited', [FrontArtistController::class, 'getLimitedArtists']);
        Route::get('/all', [FrontArtistController::class, 'getAllArtists']);
        Route::get('/details', [FrontArtistController::class, 'getArtistDetails']);
    });
    Route::group(['prefix' => 'categories'], function () {
        Route::get('/limited', [FrontCategoryController::class, 'getLimitedCategories']);
        Route::get('/all', [FrontCategoryController::class, 'getAllCategories']);
        Route::get('/details', [FrontCategoryController::class, 'getCategoryDetails']);
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
        Route::post('/logout', [LogoutController::class, 'logout']);

        Route::middleware('admin')->group(function () {
            Route::group(['prefix' => 'admin'], function () {
                Route::group(['prefix' => 'categories'], function () {
                    Route::get('/{category_id}', [CategoryController::class, 'ready']);
                    Route::post('/', [CategoryController::class, 'create']);
                    Route::put('/{category}', [CategoryController::class, 'update']);
                    Route::delete('/{category}', [CategoryController::class, 'destroy']);
                    Route::patch('/change-status/{category}', [CategoryController::class, 'changeStatus']);
                });
            });
        });
    });
});