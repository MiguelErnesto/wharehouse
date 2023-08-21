<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrdenDespacho;
use App\Models\DespachoProducto;
use App\Models\Almacen;
use App\Models\User;
use App\Models\Producto;
use App\Models\AlmacenProducto;
use App\Http\Controllers\AlmacenProductoController;

class OrdenDespachoController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin.ordenes_despacho.index')->only('index');
        $this->middleware('can:admin.ordenes_despacho.create')->only(
            'create',
            'store'
        );
        $this->middleware('can:admin.ordenes_despacho.edit')->only(
            'edit',
            'update'
        );
        $this->middleware('can:admin.ordenes_despacho.destroy')->only(
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
        $ordenes_despacho = OrdenDespacho::orderBy('updated_at', 'desc')->get();
        $usuarios = User::all();
        $almacenes = Almacen::orderBy('nombre', 'desc')->get();

        return view(
            'admin.ordenes_despacho.index',
            compact('ordenes_despacho', 'usuarios', 'almacenes')
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
            'admin.ordenes_despacho.create',
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
        //Guardar nueva Orden de Despacho
        $request->validate([
            'almacen_id' => 'required',
            'entidad_id' => 'required',
            'cliente_id' => 'required',
            'user_id' => 'required',
            'transferencia_id' => 'required',
            'vale_id' => 'required',
            'fecha' => 'required',
            'nro_orden' => 'required',
            'lugar_entrega' => 'required',
            'fecha_entrega' => 'required',
        ]);

        $ordenes_despacho = OrdenDespacho::create($request->all());
        $ordenes_despacho_id = OrdenDespacho::latest()->first()->id;
        $almacen_id = $request->almacen_id;
        $cantidad = $request->cantidad;
        $productos = $request->productos;

        foreach ($productos as $producto) {
            //Agregar productos y cantidades a Recepcion Productos

            $RPid = DespachoProducto::create([
                'orden_despacho_id' => $ordenes_despacho_id,
                'producto_id' => $producto['id'],
                'cantidad_ordenada' => $producto['cantidad_ordenada'],
                'cantidad_despachada' => $producto['cantidad_despachada'],
                'cantidad_entregada' => $producto['cantidad_entregada'],
            ]);

            //Guardar o actualizar productos en el almacen seleccionado
            $found = AlmacenProducto::where('producto_id', '=', $producto['id'])
                ->where('almacen_id', '=', $almacen_id)
                ->first();

            if ($found) {
                $almProdId = $found->update([
                    'cantidad' =>
                        intval($found->cantidad) -
                        intval($producto['cantidad']),
                ]);
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
    public function edit(OrdenDespacho $orden_despacho)
    {
        $almacenes = Almacen::select('id', 'nombre')
            ->orderBy('nombre', 'asc')
            ->get()
            ->pluck('nombre', 'id');

        $productos = Producto::select('id', 'nombre')
            ->orderBy('nombre', 'asc')
            ->get()
            ->pluck('nombre', 'id');

        return view(
            'admin.ordenes_despacho.edit',
            compact('orden_despacho', 'almacenes', 'productos')
        );
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
    public function destroy(OrdenDespacho $orden_despacho)
    {
        $OrdenesDespacho = DespachoProducto::where(
            'orden_despacho_id',
            '=',
            $orden_despacho->id
        )->delete();

        $orden_despacho->delete();

        return redirect()
            ->route('ordenes_despacho.index')
            ->with(
                'info',
                'Despacho ' .
                    $orden_despacho->nro_informe .
                    ' eliminado correctamente'
            );
    }
}
