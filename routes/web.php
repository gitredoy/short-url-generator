<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserUrlController;
use App\Http\Controllers\Frontend\FrontendController;

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


//Cache,Config,View and Route Clear
Route::get('/all-clear', function () {
    Artisan::call('cache:clear');
    echo "Cache cleared<br>";
    Artisan::call('view:clear');
    echo "View cleared<br>";
    Artisan::call('config:cache');
    echo "Config cleared<br>";
    Artisan::call('route:clear');
    echo "Route cleared<br>";
    echo "<a href='/'>Back</a>";
});

Route::get('/', function () {
    //return view('welcome');
    return view('frontend.main');
});

Route::controller(FrontendController::class)->group(function (){
    //Route::get('redirect','index')->name('user.view');
    Route::get('front','index')->name('frontend.view');
});


Route::controller(UserUrlController::class)->group(function (){
    //Route::get('redirect','index')->name('user.view');
    Route::get('/{short_url}','redirectWebsiteByLink')->name('user.url');
    Route::post('/url-store','store')->name('user.url.store');
    Route::post('/url-store/{id}','update')->name('user.url.update');

    Route::post('/click-count','clickCountByLink')->name('user.url.clickCountByLink');

});

