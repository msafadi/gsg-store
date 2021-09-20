<?php

use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\ConfigsController;
use App\Http\Controllers\Admin\NotificationsController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\ProfilesController;
use App\Http\Controllers\Admin\SendEmailsController;
use App\Http\Controllers\Admin\UserProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\RatingsController;
use App\Http\Middleware\CheckUserType;
use App\Models\Order;
use App\Models\User;
use App\Notifications\OrderCreatedNotification;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth:web,admin'])->name('dashboard');

// login (login)
/*require __DIR__ . '/auth.php';

// admin/login (admin.login) -> Admin\AuthenicatedSessionController
Route::prefix('admin')
    ->namespace('Admin')
    ->as('admin.')
    ->group(function() {

        require __DIR__ . '/auth.php';
});*/

Route::namespace('Admin')
    //->domain('admin.localhost')
    ->prefix('admin')
    ->middleware(['auth:admin,web', 'auth.type:admin,super-admin'])
    ->group(function () {

        Route::get('settings', [ConfigsController::class, 'create'])->name('settings');
        Route::post('settings', [ConfigsController::class, 'store']);

        Route::get('profile', [UserProfileController::class, 'index'])->name('profile');

        Route::get('notifications', [NotificationsController::class, 'index'])->name('notifications');
        Route::get('notifications/{id}', [NotificationsController::class, 'show'])->name('notifications.read');

        Route::group([
            'prefix' => '/categories',
            'as' => 'categories.'
        ], function() {
            Route::get('/', 'CategoriesController@index')
                ->name('index')
                ->middleware(['can:categories.view-any']);
            Route::get('/create', [CategoriesController::class, 'create'])
                ->name('create')
                ->middleware(['can:categories.create']);
            Route::post('/', [CategoriesController::class, 'store'])
                ->name('store');
            Route::get('/{category}', [CategoriesController::class, 'show'])
                ->name('show');
            Route::get('/{id}/edit', [CategoriesController::class, 'edit'])
                ->name('edit');
            Route::put('/{id}', [CategoriesController::class, 'update'])
                ->name('update');
            Route::delete('/{id}', [CategoriesController::class, 'destroy'])
                ->name('destroy');
        });


        Route::get('/products/trash', [ProductsController::class, 'trash'])
            ->name('products.trash');
        Route::put('/products/trash/{product?}', [ProductsController::class, 'restore'])
            ->name('products.restore')
            ->middleware(['can:restore,product']);
        Route::delete('/products/trash/{id?}', [ProductsController::class, 'forceDelete'])
            ->name('products.force-delete');

        Route::get('get-user', [HomeController::class, 'getUser']);
        Route::resource('/products', 'ProductsController')
            ->middleware(['password.confirm']);

        Route::resource('/roles', 'RolesController');

        Route::resource('/countries', 'CountriesController');

        Route::get('profiles/{profile}', [ProfilesController::class, 'show']);
    });

Route::get('products', 'ProductsController@index')->name('products');
Route::get('products/{slug}', 'ProductsController@show')->name('product.details');


Route::post('ratings/{type}', [RatingsController::class, 'store'])
    ->where('type', 'profile|product');

Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart', [CartController::class, 'store']);

Route::get('/checkout', [CheckoutController::class, 'create'])->name('checkout');
Route::post('/checkout', [CheckoutController::class, 'store']);

Route::get('/orders', function () {
    return Order::all();
})->name('orders');

Route::get('orders/{order}/payments/create', [PaymentsController::class, 'create'])->name('orders.payments.create');
Route::get('orders/{order}/payments/callback', [PaymentsController::class, 'callback'])->name('orders.payments.return');
Route::get('orders/{order}/payments/cancel', [PaymentsController::class, 'cancel'])->name('orders.payments.cancel');


Route::get('chat', [MessagesController::class, 'index'])->name('chat');
Route::post('chat', [MessagesController::class, 'store']);

Route::get('/test-fcm', function() {
    User::find(2)->notify(new OrderCreatedNotification(new Order));
});

Route::get('send/emails', [SendEmailsController::class, 'send']);

// asset('storage/uploads/image.png')
if (App::environment('production')) {
    Route::get('storage/{file}', function($file) {

        $filepath = storage_path('app/public/' . $file);
        if (!is_file($filepath)) {
            abort(404);
        }

        return response()->file($filepath);

    })->where('file', '.+');
}

