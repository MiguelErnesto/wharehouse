<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EntidadController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\AlmacenController;
use App\Http\Controllers\AlmacenProductoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\InformeRecepcionController;
use App\Http\Controllers\OrdenDespachoController;
use App\Http\Controllers\ValeController;

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

//Entidades
Route::resource('entidades', EntidadController::class, [
    'parameters' => [
        'entidades' => 'entidad',
    ],
]);

//Clientes
Route::resource('clientes', ClienteController::class, [
    'parameters' => [
        'clientes' => 'cliente',
    ],
]);

//Almacenes
Route::resource('almacenes', AlmacenController::class, [
    'parameters' => [
        'almacenes' => 'almacen',
    ],
]);

//Productos
Route::resource('productos', ProductoController::class, [
    'parameters' => [
        'productos' => 'producto',
    ],
]);

//Productos del Almacen
Route::resource('almacenes_productos', AlmacenProductoController::class, [
    'parameters' => [
        'almacenes_productos' => 'almacen_productos',
    ],
]);
Route::get('almacenes_productos/getProductosAlmacen/{id}', [
    AlmacenProductoController::class,
    'getProductosAlmacen',
])->name('getProductosAlmacen');
Route::get('almacenes_productos/imprimir/{id}', [
    AlmacenProductoController::class,
    'imprimir',
]);

//Informes de Recepcion
Route::resource('informes_recepcion', InformeRecepcionController::class, [
    'parameters' => [
        'informes_recepcion' => 'informe_recepcion',
    ],
]);
Route::get('informes_recepcion/getDetallesRecepcion/{id}', [
    InformeRecepcionController::class,
    'getDetallesRecepcion',
])->name('getDetallesRecepcion');
Route::get('informes_recepcion/imprimir/{id}', [
    InformeRecepcionController::class,
    'imprimir',
]);

//Órdenes de Despacho
Route::resource('ordenes_despacho', OrdenDespachoController::class, [
    'parameters' => [
        'ordenes_despacho' => 'orden_despacho',
    ],
]);
Route::get('ordenes_despacho/getDetallesDespacho/{id}', [
    OrdenDespachoController::class,
    'getDetallesDespacho',
])->name('getDetallesRecepcion');
Route::get('ordenes_despacho/imprimir/{id}', [
    OrdenDespachoController::class,
    'imprimir',
]);

//Vales
Route::resource('vales', ValeController::class, [
    'parameters' => [
        'vales' => 'vale',
    ],
]);
Route::get('vales/getDetallesVale/{id}', [
    ValeController::class,
    'getDetallesVale',
])->name('getDetallesVale');
Route::get('vales/imprimir/{id}', [ValeController::class, 'imprimir']);

/* //esto puede ser despacho_productos o eliminarlo por completo
//Recepcion de Productos
Route::resource('recepcion_productos', RecepcionProductoController::class, [
    'parameters' => [
        'recepcion_productos' => 'recepcion_producto',
    ],
]);

//Salida de productos
Route::resource('salida_productos', SalidaProductoController::class, [
    'parameters' => [
        'salida_productos' => 'salida_producto',
    ],
]);
 */
//Route::get('/', [PostController::class, 'index'])->name('posts.index');
//Route::resource('posts', PostController::class);
/* Route::get('category/{category}', [PostController::class, 'category'])->name(
    'posts.category'
); */
//Route::get('tag/{tag}', [PostController::class, 'tag'])->name('posts.tag');
