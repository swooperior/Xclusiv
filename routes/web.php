<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ErrorController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\FansController;

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
Route::get('/', function () {
    if(Auth::user()){
        return redirect(route('dashboard'));
    }
    return view('index');
});
Auth::routes();

Route::prefix('dashboard')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('dashboard');
    /*Settings Routes*/
    Route::prefix('settings')->group(function () {
        //ToDo;
        Route::get('/', [SettingsController::class, 'all'])->name('settings.all');
        Route::any('/profile', [SettingsController::class, 'profile'])->name('settings.profile');
        Route::any('/account', [SettingsController::class, 'account'])->name('settings.account');
        Route::any('/privacy', [SettingsController::class, 'privacy'])->name('settings.privacy');
    });
    /*End of settings Routes*/
});

Route::prefix('profile')->group(function() {
    Route::get('/', [ProfileController::class, 'index'])->name('profile');
    Route::get('/{username}', [ProfileController::class, 'index'])->name('user.profile');
});

/* Post Routes */
Route::prefix('post')->group(function() {
    Route::get('/new',[PostsController::class, 'new'])->name('new');
    Route::post('/new',[PostsController::class, 'upload'])->name('upload');
    Route::get('/{id}',[PostsController::class, 'single'])->name('single-post');
});
/* End of post routes */

/* Posts Routes */
Route::prefix('posts')->group(function() {
    Route::get('/',[PostsController::class, 'all'])->name('posts.all');
    Route::get('/{user}',[PostsController::class, 'byuser'])->name('posts.user');
});
/* End of post routes */

/* Fans Routes */
Route::prefix('fans')->group(function() {
    Route::get('/',[FansController::class, 'main'])->name('fans.main');
    //Route::get('/{user}',[FansController::class, 'byuser'])->name('posts.user');
});
/* End of fans routes */

/* Error Routes */
Route::prefix('error')->group(function (){
   Route::get('/restricted', [ErrorController::class, 'restricted'])->name('error.restricted');
});

//ToDo;
//Settings routes
//Whitelist user route
//Payment Routes
//Upload Routes
//Report Routes
