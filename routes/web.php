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
use App\Http\Controllers\TransferenciaController;
use App\Http\Controllers\ConduceController;
use App\Http\Controllers\FacturaController;

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

//Route::post('logout', HomeController::class, 'logout')->name('logout');

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
/* Route::resource('almacenes_productos', AlmacenProductoController::class, [
    'parameters' => [
        'almacenes_productos' => 'almacen_productos',
    ],
]); */
Route::get('almacenes_productos/getProductosAlmacen/{id}', [
    AlmacenProductoController::class,
    'getProductosAlmacen',
])->name('getProductosAlmacen');
Route::get('almacenes_productos/imprimir/{id}', [
    AlmacenProductoController::class,
    'imprimir',
]);
Route::get('almacenes_productos/exportarPDF/{id}', [
    AlmacenProductoController::class,
    'exportarPDF',
]);

//Informes de Recepcion
Route::resource('informes_recepcion', InformeRecepcionController::class, [
    'parameters' => [
        'informes_recepcion' => 'informe_recepcion',
    ],
]);
Route::get('informes_recepcion/getDetalles/{id}', [
    InformeRecepcionController::class,
    'getDetalles',
])->name('getDetalles');
Route::get('informes_recepcion/update/{id}', [
    InformeRecepcionController::class,
    'update',
]);
Route::get('informes_recepcion/imprimir/{id}', [
    InformeRecepcionController::class,
    'imprimir',
]);
Route::get('informes_recepcion/exportarPDF/{id}', [
    InformeRecepcionController::class,
    'exportarPDF',
]);

//Órdenes de Despacho
Route::resource('ordenes_despacho', OrdenDespachoController::class, [
    'parameters' => [
        'ordenes_despacho' => 'orden_despacho',
    ],
]);
Route::get('ordenes_despacho/getDetalles/{id}', [
    OrdenDespachoController::class,
    'getDetalles',
])->name('getDetalles');
Route::get('ordenes_despacho/imprimir/{id}', [
    OrdenDespachoController::class,
    'imprimir',
]);
Route::get('ordenes_despacho/exportarPDF/{id}', [
    OrdenDespachoController::class,
    'exportarPDF',
]);

//Vales
Route::resource('vales', ValeController::class, [
    'parameters' => [
        'vales' => 'vale',
    ],
]);
Route::get('vales/getDetalles/{id}', [ValeController::class, 'getDetalles']);
Route::get('vales/imprimir/{id}', [ValeController::class, 'imprimir']);
Route::get('vales/exportarPDF/{id}', [ValeController::class, 'exportarPDF']);

//Transferencias
Route::resource('transferencias', TransferenciaController::class, [
    'parameters' => [
        'transferencias' => 'transferencia',
    ],
]);
Route::get('transferencias/getDetalles/{id}', [
    TransferenciaController::class,
    'getDetalles',
]);
Route::get('transferencias/imprimir/{id}', [
    TransferenciaController::class,
    'imprimir',
]);
Route::get('transferencias/exportarPDF/{id}', [
    TransferenciaController::class,
    'exportarPDF',
]);

//Conduces
Route::resource('conduces', ConduceController::class, [
    'parameters' => [
        'conduces' => 'conduce',
    ],
]);
Route::get('conduces/getDetalles/{id}', [
    ConduceController::class,
    'getDetalles',
]);
Route::get('conduces/imprimir/{id}', [ConduceController::class, 'imprimir']);
Route::get('conduces/exportarPDF/{id}', [
    ConduceController::class,
    'exportarPDF',
]);

//Facturas
Route::resource('facturas', FacturaController::class, [
    'parameters' => [
        'facturas' => 'factura',
    ],
]);
Route::get('facturas/getDetalles/{id}', [
    FacturaController::class,
    'getDetalles',
]);
Route::get('facturas/imprimir/{id}', [FacturaController::class, 'imprimir']);
Route::get('facturas/exportarPDF/{id}', [
    FacturaController::class,
    'exportarPDF',
]);

//Route::get('/logout', [Auth::logout()]);
