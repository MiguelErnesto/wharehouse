<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductoController;
use App\Http\Controllers\AlmacenController;
use App\Http\Controllers\AlmacenProductoController;
use App\Http\Controllers\RecepcionProductoController;
use App\Http\Controllers\SalidaProductoController;

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

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::resource('productos', ProductoController::class, [
    'parameters' => [
        'productos' => 'producto',
    ],
]);
Route::resource('almacenes', AlmacenController::class, [
    'parameters' => [
        'almacenes' => 'almacen',
    ],
]);
Route::resource('productos_almacenes', AlmacenProductoController::class, [
    'parameters' => [
        'productos_almacenes' => 'producto_almacen',
    ],
]);
Route::resource('recepcion_productos', RecepcionProductoController::class, [
    'parameters' => [
        'recepcion_productos' => 'recepcion_producto',
    ],
]);
Route::resource('salida_productos', SalidaProductoController::class, [
    'parameters' => [
        'salida_productos' => 'salida_producto',
    ],
]);

//Route::get('/', [PostController::class, 'index'])->name('posts.index');
//Route::resource('posts', PostController::class);
/* Route::get('category/{category}', [PostController::class, 'category'])->name(
    'posts.category'
); */
//Route::get('tag/{tag}', [PostController::class, 'tag'])->name('posts.tag');
