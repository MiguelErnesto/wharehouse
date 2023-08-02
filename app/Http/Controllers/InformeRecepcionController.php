<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InformeRecepcion;
use App\Models\RecepcionProducto;
use App\Models\Almacen;
use App\Models\Producto;
use App\Models\AlmacenProducto;
use App\Http\Controllers\AlmacenProductoController;

class InformeRecepcionController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin.informes_recepcion.index')->only('index');
        $this->middleware('can:admin.informes_recepcion.create')->only(
            'create',
            'store'
        );
        $this->middleware('can:admin.informes_recepcion.edit')->only(
            'edit',
            'update'
        );
        $this->middleware('can:admin.informes_recepcion.destroy')->only(
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
        $query = InformeRecepcion::orderBy('created_at', 'desc')
            ->join('users as u', 'u.id', '=', 'informes_recepcion.user_id')
            ->join(
                'almacenes as alm',
                'alm.id',
                '=',
                'informes_recepcion.almacen_id'
            )
            ->select(
                '*',
                'informes_recepcion.id as rpId',
                'u.name as userName',
                'alm.nombre as almNombre'
            );

        $informes_recepcion = $query->get();

        return view(
            'admin.informes_recepcion.index',
            compact('informes_recepcion')
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
            'admin.informes_recepcion.create',
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

        $informe_recepcion = InformeRecepcion::create($request->all());
        $informe_recepcion_id = InformeRecepcion::latest()->first()->id;
        $almacen_id = $request->almacen_id;
        $cantidad = $request->cantidad;
        $productos = $request->productos;

        foreach ($productos as $producto) {
            //Agregar productos y cantidades a Recepcion Productos

            $RPid = RecepcionProducto::create([
                'informe_recepcion_id' => $informe_recepcion_id,
                'producto_id' => $producto['id'],
                'cantidad' => $producto['cantidad'],
            ]);

            //Guardar o actualizar productos en el almacen seleccionado
            $found = AlmacenProducto::where('producto_id', '=', $producto['id'])
                ->where('almacen_id', '=', $almacen_id)
                ->first();

            if ($found) {
                $almProdId = $found->update([
                    'cantidad' =>
                        intval($found->cantidad) +
                        intval($producto['cantidad']),
                ]);
            } else {
                $requestProductoAlmacen = new Request([
                    'recepcion_producto_id' => $informe_recepcion_id,
                    'almacen_id' => $almacen_id,
                    'producto_id' => $producto['id'],
                    'cantidad' => $producto['cantidad'],
                ]);
                $almProd = new AlmacenProducto();
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
        $InformeRecepcion = InformeRecepcion::where(
            'informes_recepcion.id',
            '=',
            $id
        )
            ->join(
                'almacenes as alm',
                'alm.id',
                '=',
                'informes_recepcion.almacen_id'
            )
            ->join('users as u', 'u.id', '=', 'informes_recepcion.user_id')
            ->select(
                'informes_recepcion.id as id',
                'informes_recepcion.fecha as fecha',
                'informes_recepcion.nro_informe as nro_informe',
                'alm.nombre as almacen',
                'u.name as usuario'
            )
            ->get();

        $productos = InformeRecepcion::select(
            'p.nombre as nombre',
            'p.codigo as codigo',
            'p.descripcion as descripcion',
            'rp.cantidad as cantidad'
        )
            ->join(
                'recepcion_productos as rp',
                'rp.informe_recepcion_id',
                '=',
                'informes_recepcion.id'
            )
            ->join('productos as p', 'p.id', '=', 'rp.producto_id')
            ->where('informes_recepcion.id', '=', $id)
            ->get();

        return response()->json([
            'informeDetalles' => $InformeRecepcion,
            'informeProductos' => $productos,
        ]);
    }
}
