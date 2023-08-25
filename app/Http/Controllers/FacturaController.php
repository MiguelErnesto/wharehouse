<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Factura;
use App\Models\FacturaProducto;
use App\Models\Almacen;
use App\Models\Entidad;
use App\Models\User;
use App\Models\Producto;
use App\Models\AlmacenProducto;
use App\Http\Controllers\AlmacenProductoController;

class FacturaController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin.facturas.index')->only('index');
        $this->middleware('can:admin.facturas.create')->only('create', 'store');
        $this->middleware('can:admin.facturas.edit')->only('edit', 'update');
        $this->middleware('can:admin.facturas.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $facturas = Factura::orderBy('fecha_modelo', 'desc')->get();
        $usuarios = User::all();
        $almacenes = Almacen::orderBy('nombre', 'desc')->get();
        $entidades = Entidad::orderBy('nombre', 'desc')->get();

        return view(
            'admin.facturas.index',
            compact('facturas', 'usuarios', 'almacenes', 'entidades')
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $entidades = Entidad::select('id', 'nombre')
            ->get()
            ->pluck('nombre', 'id');

        $almacenes = Almacen::select('id', 'nombre')
            ->get()
            ->pluck('nombre', 'id');

        $productos = Producto::select('id', 'nombre')
            ->get()
            ->pluck('nombre', 'id');

        return view(
            'admin.facturas.create',
            compact('entidades', 'almacenes', 'productos')
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
        //Guardar nueva Factura
        $request->validate([
            'user_id',
            'entidad_id',
            'nro_factura',
            'fecha_modelo',
            'fecha_entrega',
            'fecha_recepcion',
            'fecha_recepcion_transportador',
            'importe_total',
            'porciento',
            'datos_registro',
            'operaciones',
            'moneda_pago',
            'persona_contabiliza',
            'persona_entrega',
            'persona_recibe',
            'transportista',
            'persona_transportador',
        ]);

        $factura = Factura::create($request->all());
        $factura_id = Factura::latest()->first()->id;
        $productos = $request->productos;

        foreach ($productos as $producto) {
            //Agregar productos y cantidades a FacturaProductos

            $RPid = FacturaProducto::create([
                'factura_id' => $factura_id,
                'producto_id' => $producto['id'],
                'cantidad' => $producto['cantidad'],
            ]);
        }
        return response()->json($factura_id);
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
    public function destroy(Factura $factura)
    {
        $facturaProductos = FacturaProducto::where(
            'factura_id',
            '=',
            $factura->id
        )->delete();
        $factura->delete();
        return redirect()
            ->route('facturas.index')
            ->with(
                'info',
                'Factura ' . $factura->nro_factura . ' eliminada correctamente'
            );
    }

    public function getDetalles($id)
    {
        $detalles = Factura::where('facturas.id', '=', $id)
            ->join('entidades as ent', 'ent.id', '=', 'facturas.entidad_id')
            ->join('users as u', 'u.id', '=', 'facturas.user_id')
            ->select(
                'facturas.id as id',
                'facturas.fecha_modelo as fecha_modelo',
                'facturas.nro_factura as nro_factura',
                'facturas.datos_registro as datos_registro',
                'facturas.operaciones as operaciones',
                'facturas.moneda_pago as moneda_pago',
                'facturas.porciento as porciento',
                'facturas.transportista as transportista',
                'facturas.persona_transportador as persona_transportador',
                'facturas.fecha_recepcion_transportador as fecha_recepcion_transportador',
                'facturas.persona_entrega as persona_entrega',
                'facturas.fecha_entrega as fecha_entrega',
                'facturas.persona_recibe as persona_recibe',
                'facturas.fecha_recepcion as fecha_recepcion',
                'facturas.persona_contabiliza as persona_contabiliza',
                'facturas.importe_total as importe_total',
                'ent.nombre as entidad',
                'u.name as usuario'
            )
            ->get();

        $productos = Factura::where('facturas.id', '=', $id)
            ->join(
                'factura_productos as fp',
                'fp.factura_id',
                '=',
                'facturas.id'
            )
            ->join('productos as p', 'p.id', '=', 'fp.producto_id')
            ->select(
                'p.nombre as nombre',
                'p.codigo as codigo',
                'p.descripcion as descripcion',
                'fp.cantidad as cantidad'
            )
            ->get();

        return response()->json([
            'detalles' => $detalles,
            'productos' => $productos,
        ]);
    }

    public function imprimir($id)
    {
        $detalles = Factura::where('facturas.id', '=', $id)
            ->join('entidades as ent', 'ent.id', '=', 'facturas.entidad_id')
            ->join('users as u', 'u.id', '=', 'facturas.user_id')
            ->select(
                'facturas.id as id',
                'facturas.fecha_modelo as fecha_modelo',
                'facturas.nro_factura as nro_factura',
                'facturas.datos_registro as datos_registro',
                'facturas.operaciones as operaciones',
                'facturas.moneda_pago as moneda_pago',
                'facturas.porciento as porciento',
                'facturas.transportista as transportista',
                'facturas.persona_transportador as persona_transportador',
                'facturas.fecha_recepcion_transportador as fecha_recepcion_transportador',
                'facturas.persona_entrega as persona_entrega',
                'facturas.fecha_entrega as fecha_entrega',
                'facturas.persona_recibe as persona_recibe',
                'facturas.fecha_recepcion as fecha_recepcion',
                'facturas.persona_contabiliza as persona_contabiliza',
                'facturas.importe_total as importe_total',
                'ent.nombre as entidad',
                'u.name as usuario'
            )
            ->get();

        $productos = Factura::where('facturas.id', '=', $id)
            ->join(
                'factura_productos as fp',
                'fp.factura_id',
                '=',
                'facturas.id'
            )
            ->join('productos as p', 'p.id', '=', 'fp.producto_id')
            ->select(
                'p.nombre as nombre',
                'p.codigo as codigo',
                'p.descripcion as descripcion',
                'fp.cantidad as cantidad'
            )
            ->get();

        return view('admin.facturas.print', compact('detalles', 'productos'));
    }
}
