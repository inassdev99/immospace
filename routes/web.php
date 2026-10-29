<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientAuthController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\VisitRequestController;
use App\Models\Property;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Site public
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/properties-data', function () {
    return Property::query()
        ->where('status', 'Disponible')
        ->orderBy('id')
        ->get([
            'id',
            'title',
            'city',
            'district',
            'type',
            'transaction',
            'price',
            'area',
            'bedrooms',
            'image',
        ]);
});

Route::get('/biens/{property}', function (Property $property) {
    abort_unless($property->status === 'Disponible', 404);

    return view('property', [
        'property' => $property,
    ]);
})->name('properties.show');

Route::get('/biens/{property}/visite', [
    VisitRequestController::class,
    'create',
])->name('visits.create');

Route::post('/biens/{property}/visite', [
    VisitRequestController::class,
    'store',
])->middleware('throttle:5,1')->name('visits.store');

/*
|--------------------------------------------------------------------------
| Comptes clients
|--------------------------------------------------------------------------
*/

Route::get('/inscription', [
    ClientAuthController::class,
    'registerForm',
])->name('client.register');

Route::post('/inscription', [
    ClientAuthController::class,
    'register',
])->middleware('throttle:5,1')->name('client.register.store');

Route::get('/connexion', [
    ClientAuthController::class,
    'loginForm',
])->name('client.login');

Route::post('/connexion', [
    ClientAuthController::class,
    'login',
])->middleware('throttle:5,1')->name('client.login.store');

Route::get('/mon-compte', [
    ClientAuthController::class,
    'account',
])->name('client.account');

Route::post('/deconnexion', [
    ClientAuthController::class,
    'logout',
])->middleware('auth')->name('client.logout');

/*
|--------------------------------------------------------------------------
| Favoris
|--------------------------------------------------------------------------
*/

Route::get('/client-state', [
    FavoriteController::class,
    'state',
])->name('favorites.state');

Route::middleware(['auth', 'throttle:60,1'])->group(function () {
    Route::put('/favoris/{property}', [
        FavoriteController::class,
        'store',
    ])->name('favorites.store');

    Route::delete('/favoris/{property}', [
        FavoriteController::class,
        'destroy',
    ])->name('favorites.destroy');
});

/*
|--------------------------------------------------------------------------
| Administration
|--------------------------------------------------------------------------
*/

Route::get('/admin/login', [
    AdminController::class,
    'loginForm',
])->name('login');

Route::post('/admin/login', [
    AdminController::class,
    'login',
])->middleware('throttle:5,1')->name('admin.login');

Route::middleware('auth')
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])
            ->name('dashboard');

        Route::get('/properties/create', [
            AdminController::class,
            'create',
        ])->name('properties.create');

        Route::post('/properties', [
            AdminController::class,
            'store',
        ])->name('properties.store');

        Route::get('/properties/{property}/edit', [
            AdminController::class,
            'edit',
        ])->name('properties.edit');

        Route::put('/properties/{property}', [
            AdminController::class,
            'update',
        ])->name('properties.update');

        Route::delete('/properties/{property}', [
            AdminController::class,
            'destroy',
        ])->name('properties.destroy');

        Route::get('/visites', [
            VisitRequestController::class,
            'index',
        ])->name('visits.index');

        Route::patch('/visites/{visit}', [
            VisitRequestController::class,
            'update',
        ])->name('visits.update');

        Route::post('/logout', [
            AdminController::class,
            'logout',
        ])->name('logout');
    });