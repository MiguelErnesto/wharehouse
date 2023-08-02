<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AlmacenProducto;
use App\Models\Producto;
use App\Models\Almacen;

class AlmacenProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a `new`ly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'recepcion_producto_id' => 'required',
            'almacen_id' => 'required',
            'producto_id' => 'required',
            'cantidad' => 'required',
        ]);
        $almacen_producto = AlmacenProducto::create($request->all());

        return $almacen_producto->id;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getProductosAlmacen($id)
    {
        try {
            $almacen_productos = AlmacenProducto::where('almacen_id', '=', $id)
                ->select(
                    'p.id as pId',
                    'p.codigo as pCodigo',
                    'p.nombre as pNombre',
                    'p.descripcion as pDescripcion',
                    'almacenes_productos.id as apId',
                    'almacenes_productos.almacen_id as apAlmId',
                    'almacenes_productos.producto_id as apProdId',
                    'almacenes_productos.cantidad as apCantidad'
                )
                ->join(
                    'productos as p',
                    'p.id',
                    '=',
                    'almacenes_productos.producto_id'
                )
                ->get();

            return response()->json($almacen_productos);
        } catch (Exception $e) {
            return response($e->getMessage(), $e->getCode());
        }
    }

    public function imprimir($id)
    {
        $productos = AlmacenProducto::where('almacen_id', '=', $id)
            ->select(
                'p.codigo as pCodigo',
                'p.nombre as pNombre',
                'p.descripcion as pDescripcion',
                'almacenes_productos.cantidad as apCantidad'
            )
            ->join(
                'productos as p',
                'p.id',
                '=',
                'almacenes_productos.producto_id'
            )
            ->get();

        $almacen = Almacen::find($id);

        return view('admin.almacenes.print', compact('productos', 'almacen'));
    }
}
