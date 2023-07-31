<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RecepcionProducto;
use App\Models\Almacen;
use App\Models\Producto;
use App\Models\AlmacenProducto;
use App\Http\Controllers\AlmacenProductoController;

class RecepcionProductoController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin.recepcion_productos.index')->only('index');
        $this->middleware('can:admin.recepcion_productos.create')->only(
            'create',
            'store'
        );
        $this->middleware('can:admin.recepcion_productos.edit')->only(
            'edit',
            'update'
        );
        $this->middleware('can:admin.recepcion_productos.destroy')->only(
            'destroy'
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = RecepcionProducto::orderBy('created_at', 'desc')
            ->join('users as u', 'u.id', '=', 'recepcion_productos.user_id')
            ->join(
                'almacenes as alm',
                'alm.id',
                '=',
                'recepcion_productos.almacen_id'
            )
            ->select(
                '*',
                'recepcion_productos.id as rpId',
                'u.name as userName',
                'alm.nombre as almNombre'
            );

        $recepcion_productos = $query->get();

        return view(
            'admin.recepcion_productos.index',
            compact('recepcion_productos')
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $almacenes = Almacen::select('id', 'nombre')
            ->get()
            ->pluck('nombre', 'id');

        $productos = Producto::select('id', 'nombre')
            ->get()
            ->pluck('nombre', 'id');
        return view(
            'admin.recepcion_productos.create',
            compact('almacenes', 'productos')
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Crear nueva Recepcion Producto
        $request->validate([
            'user_id' => 'required',
            'fecha' => 'required',
            'nro_informe' => 'required',
            'almacen_id' => 'required',
        ]);

        $recepcion_producto = RecepcionProducto::create($request->all());

        //Guardar productos en el almacen seleccionado
        $recepcion_producto_id = RecepcionProducto::latest()->first()->id;
        $almacen_id = $request->almacen_id;
        $cantidad = $request->cantidad;
        $productos = $request->productos;

        foreach ($productos as $producto) {
            $found = AlmacenProducto::where('producto_id', '=', $producto['id'])
                ->where('almacen_id', '=', $request->almacen_id)
                ->first();

            if ($found) {
                $almProdId = $found->update([
                    'cantidad' =>
                        intval($found->cantidad) +
                        intval($producto['cantidad']),
                ]);
            } else {
                $requestProductoAlmacen = new Request([
                    'recepcion_producto_id' => $recepcion_producto_id,
                    'almacen_id' => $almacen_id,
                    'producto_id' => $producto['id'],
                    'cantidad' => $producto['cantidad'],
                ]);
                $almProd = new AlmacenProductoController();
                $almProdId = $almProd->store($requestProductoAlmacen);
            }
        }
        return response()->json($almProdId);
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

    public function getDetallesRecepcion($id)
    {
        $InformeRecepcion = RecepcionProducto::where(
            'recepcion_productos.id',
            '=',
            $id
        )
            ->join(
                'almacenes as alm',
                'alm.id',
                '=',
                'recepcion_productos.almacen_id'
            )
            ->join('users as u', 'u.id', '=', 'recepcion_productos.user_id')
            ->select(
                'recepcion_productos.id as id',
                'recepcion_productos.fecha as fecha',
                'recepcion_productos.nro_informe as nro_informe',
                'alm.nombre as almacen',
                'u.name as usuario'
            )
            ->get();

        $productos = RecepcionProducto::select(
            'p.nombre as nombre',
            'p.codigo as codigo',
            'p.descripcion as descripcion',
            'ap.cantidad as cantidad'
        )
            ->join(
                'almacenes_productos as ap',
                'ap.recepcion_producto_id',
                '=',
                'recepcion_productos.id'
            )
            ->join('productos as p', 'p.id', '=', 'ap.producto_id')
            ->where('recepcion_productos.id', '=', $id)
            ->get();

        return response()->json([
            'informeDetalles' => $InformeRecepcion,
            'informeProductos' => $productos,
        ]);
    }
}
