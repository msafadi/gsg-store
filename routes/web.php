<?php

use App\Http\Controllers\ProductsController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

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

// http://localhost:8000/welcome/to/laravel?new=1
// MVC

Route::get('/', function () {
    return view('welcome');
});

Route::get('products/{name}/{category?}', [ProductsController::class, 'show']);
Route::get('products', [ProductsController::class, 'index']);

// Request Methods
Route::get('/welcome.php', [WelcomeController::class, 'welcome']); // Laravel 8
Route::get('/welcome.php', [WelcomeController::class, 'laravel']); // Laravel 8

Route::get('/welcome/to/laravel', 'WelcomeController@welcome'); // GET and HEAD
Route::post('/welcome', 'WelcomeController@welcome'); // POST
// Route::put(); // PUT
// Route::patch(); // PATCH
// Route::delete(); // DELETE
// Route::options(); // OPTIONS

// Other Helper Methods
Route::any('any', 'WelcomeController@welcome');
Route::match(['post', 'put'], 'match', 'WelcomeController@welcome');
Route::view('laravel', 'welcome');
Route::redirect('home', 'new');
// Route::resource();
// Route::apiResource();
// Route::group();