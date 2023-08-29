<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrdenDespacho;
use App\Models\DespachoProducto;
use App\Models\Entidad;
use App\Models\Cliente;
use App\Models\Almacen;
use App\Models\Vale;
use App\Models\Transferencia;
use App\Models\User;
use App\Models\Producto;
use App\Models\AlmacenProducto;
use App\Http\Controllers\AlmacenProductoController;
use Carbon\Carbon;
use PDF;

class OrdenDespachoController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:Listar ordenes despacho')->only(
            'index',
            'getDetalles'
        );
        $this->middleware('can:Crear orden despacho')->only('create', 'store');
        $this->middleware('can:Editar orden despacho')->only('edit', 'update');
        $this->middleware('can:Eliminar orden despacho')->only('destroy');
        $this->middleware('can:Imprimir')->only('imprimir');
        $this->middleware('can:Exportar PDF')->only('exportarPDF');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ordenes_despacho = OrdenDespacho::orderBy('updated_at', 'desc')->get();
        $entidades = Entidad::orderBy('nombre', 'desc')->get();
        $clientes = Cliente::orderBy('nombre', 'desc')->get();
        $almacenes = Almacen::orderBy('nombre', 'desc')->get();
        $usuarios = User::all();

        return view(
            'admin.ordenes_despacho.index',
            compact('ordenes_despacho', 'usuarios', 'entidades', 'almacenes')
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

        $clientes = Cliente::select('id', 'nombre')
            ->get()
            ->pluck('nombre', 'id');

        $almacenes = Almacen::select('id', 'nombre')
            ->get()
            ->pluck('nombre', 'id');

        $vales = Vale::select('id', 'nro_vale')
            ->get()
            ->pluck('nro_vale', 'id');

        $transferencias = Transferencia::select('id', 'nro_transferencia')
            ->get()
            ->pluck('nro_transferencia', 'id');

        $productos = Producto::select('id', 'nombre')
            ->get()
            ->pluck('nombre', 'id');

        return view(
            'admin.ordenes_despacho.create',
            compact(
                'entidades',
                'clientes',
                'almacenes',
                'transferencias',
                'vales',
                'productos'
            )
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
            'transferencia_id' => 'nullable',
            'vale_id' => 'nullable',
            'fecha' => 'required',
            'nro_orden' => 'required',
            'lugar_entrega' => 'required',
            'fecha_entrega' => 'required',
            'tipo_salida' => 'required',
        ]);

        $ordenes_despacho = OrdenDespacho::create($request->all());
        $ordenes_despacho_id = OrdenDespacho::latest()->first()->id;
        $almacen_id = $request->almacen_id;
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
                        intval($producto['cantidad_despachada']),
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

        $entidades = Entidad::select('id', 'nombre')
            ->orderBy('nombre', 'asc')
            ->get()
            ->pluck('nombre', 'id');

        $clientes = Cliente::select('id', 'nombre')
            ->orderBy('nombre', 'asc')
            ->get()
            ->pluck('nombre', 'id');

        $vales = Vale::select('id', 'nro_vale')
            ->get()
            ->pluck('nro_vale', 'id');

        $transferencias = Transferencia::select('id', 'nro_transferencia')
            ->get()
            ->pluck('nro_transferencia', 'id');

        return view(
            'admin.ordenes_despacho.edit',
            compact(
                'orden_despacho',
                'almacenes',
                'productos',
                'entidades',
                'vales',
                'transferencias',
                'clientes'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrdenDespacho $orden_despacho)
    {
        $request->validate([
            'almacen_id' => 'required',
            'entidad_id' => 'required',
            'cliente_id' => 'required',
            'user_id' => 'required',
            'transferencia_id' => 'nullable',
            'vale_id' => 'nullable',
            'fecha' => 'required',
            'nro_orden' => 'required',
            'lugar_entrega' => 'required',
            'fecha_entrega' => 'required',
            'tipo_salida' => 'required',
        ]);

        $orden_despacho->update($request->all());

        return redirect()
            ->route('ordenes_despacho.index')
            ->with(
                'info',
                'Orden de despacho ' .
                    $orden_despacho->nro_orden .
                    ' actualizada correctamente'
            );
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
                    $orden_despacho->nro_orden .
                    ' eliminado correctamente'
            );
    }

    public function getDetalles($id)
    {
        $detalles = OrdenDespacho::where('ordenes_despacho.id', '=', $id)
            ->join(
                'entidades as ent',
                'ent.id',
                '=',
                'ordenes_despacho.entidad_id'
            )
            ->join(
                'almacenes as alm',
                'alm.id',
                '=',
                'ordenes_despacho.almacen_id'
            )
            ->join(
                'clientes as cli',
                'cli.id',
                '=',
                'ordenes_despacho.cliente_id'
            )
            ->join('users as u', 'u.id', '=', 'ordenes_despacho.user_id')
            ->select(
                'ordenes_despacho.id as id',
                'ordenes_despacho.fecha as fecha',
                'ordenes_despacho.updated_at as updated_at',
                'ordenes_despacho.nro_orden as nro_orden',
                'ordenes_despacho.lugar_entrega as lugar_entrega',
                'ordenes_despacho.fecha_entrega as fecha_entrega',
                'ordenes_despacho.tipo_salida as tipo_salida',
                'ordenes_despacho.vale_id as vale_id',
                'ordenes_despacho.transferencia_id as transferencia_id',
                'ent.nombre as entidad',
                'alm.nombre as almacen',
                'cli.nombre as cliente',
                'u.name as usuario'
            )
            ->get();

        $vales = Vale::select('id', 'nro_vale')
            ->orderBy('nro_vale', 'desc')
            ->get();

        $transferencias = Transferencia::select('id', 'nro_transferencia')
            ->orderBy('nro_transferencia', 'desc')
            ->get();

        $productos = OrdenDespacho::where('ordenes_despacho.id', '=', $id)
            ->join(
                'despacho_productos as vp',
                'vp.orden_despacho_id',
                '=',
                'ordenes_despacho.id'
            )
            ->join('productos as p', 'p.id', '=', 'vp.producto_id')
            ->select(
                'p.nombre as nombre',
                'p.codigo as codigo',
                'p.descripcion as descripcion',
                'vp.cantidad_ordenada as cantidad_ordenada',
                'vp.cantidad_despachada as cantidad_despachada',
                'vp.cantidad_entregada as cantidad_entregada'
            )
            ->get();

        return response()->json([
            'detalles' => $detalles,
            'vales' => $vales,
            'transferencias' => $transferencias,
            'productos' => $productos,
        ]);
    }

    public function imprimir($id)
    {
        $detalles = OrdenDespacho::where('ordenes_despacho.id', '=', $id)
            ->join(
                'entidades as ent',
                'ent.id',
                '=',
                'ordenes_despacho.entidad_id'
            )
            ->join(
                'almacenes as alm',
                'alm.id',
                '=',
                'ordenes_despacho.almacen_id'
            )
            ->join(
                'clientes as cli',
                'cli.id',
                '=',
                'ordenes_despacho.cliente_id'
            )
            ->join('users as u', 'u.id', '=', 'ordenes_despacho.user_id')
            ->select(
                'ordenes_despacho.id as id',
                'ordenes_despacho.fecha as fecha',
                'ordenes_despacho.updated_at as updated_at',
                'ordenes_despacho.nro_orden as nro_orden',
                'ordenes_despacho.lugar_entrega as lugar_entrega',
                'ordenes_despacho.fecha_entrega as fecha_entrega',
                'ordenes_despacho.tipo_salida as tipo_salida',
                'ordenes_despacho.vale_id as vale_id',
                'ordenes_despacho.transferencia_id as transferencia_id',
                'ent.nombre as entidad',
                'alm.nombre as almacen',
                'cli.nombre as cliente',
                'u.name as usuario'
            )
            ->get();

        $vales = Vale::select('id', 'nro_vale')
            ->orderBy('nro_vale', 'desc')
            ->get();

        $transferencias = Transferencia::select('id', 'nro_transferencia')
            ->orderBy('nro_transferencia', 'desc')
            ->get();

        $productos = OrdenDespacho::where('ordenes_despacho.id', '=', $id)
            ->join(
                'despacho_productos as vp',
                'vp.orden_despacho_id',
                '=',
                'ordenes_despacho.id'
            )
            ->join('productos as p', 'p.id', '=', 'vp.producto_id')
            ->select(
                'p.nombre as nombre',
                'p.codigo as codigo',
                'p.descripcion as descripcion',
                'vp.cantidad_ordenada as cantidad_ordenada',
                'vp.cantidad_despachada as cantidad_despachada',
                'vp.cantidad_entregada as cantidad_entregada'
            )
            ->get();

        return view(
            'admin.ordenes_despacho.print',
            compact('detalles', 'productos', 'vales', 'transferencias')
        );
    }

    public function exportarPDF($id)
    {
        $DocumentoPDF = OrdenDespacho::where('id', '=', $id)
            ->select('nro_orden', 'fecha')
            ->first();

        $detalles = OrdenDespacho::where('ordenes_despacho.id', '=', $id)
            ->join(
                'entidades as ent',
                'ent.id',
                '=',
                'ordenes_despacho.entidad_id'
            )
            ->join(
                'almacenes as alm',
                'alm.id',
                '=',
                'ordenes_despacho.almacen_id'
            )
            ->join(
                'clientes as cli',
                'cli.id',
                '=',
                'ordenes_despacho.cliente_id'
            )
            ->join('users as u', 'u.id', '=', 'ordenes_despacho.user_id')
            ->select(
                'ordenes_despacho.id as id',
                'ordenes_despacho.fecha as fecha',
                'ordenes_despacho.updated_at as updated_at',
                'ordenes_despacho.nro_orden as nro_orden',
                'ordenes_despacho.lugar_entrega as lugar_entrega',
                'ordenes_despacho.fecha_entrega as fecha_entrega',
                'ordenes_despacho.tipo_salida as tipo_salida',
                'ordenes_despacho.vale_id as vale_id',
                'ordenes_despacho.transferencia_id as transferencia_id',
                'ent.nombre as entidad',
                'alm.nombre as almacen',
                'cli.nombre as cliente',
                'u.name as usuario'
            )
            ->get();

        $vales = Vale::select('id', 'nro_vale')
            ->orderBy('nro_vale', 'desc')
            ->get();

        $transferencias = Transferencia::select('id', 'nro_transferencia')
            ->orderBy('nro_transferencia', 'desc')
            ->get();

        $productos = OrdenDespacho::where('ordenes_despacho.id', '=', $id)
            ->join(
                'despacho_productos as vp',
                'vp.orden_despacho_id',
                '=',
                'ordenes_despacho.id'
            )
            ->join('productos as p', 'p.id', '=', 'vp.producto_id')
            ->select(
                'p.nombre as nombre',
                'p.codigo as codigo',
                'p.descripcion as descripcion',
                'vp.cantidad_ordenada as cantidad_ordenada',
                'vp.cantidad_despachada as cantidad_despachada',
                'vp.cantidad_entregada as cantidad_entregada'
            )
            ->get();

        $pdf = PDF::loadView(
            'admin.ordenes_despacho.print',
            compact('detalles', 'productos', 'vales', 'transferencias')
        )->setOptions([
            'defaultFont' => 'sans-serif',
            'Letter' => 'landscape',
        ]);

        return $pdf->download(
            'OrdenDespacho_' .
                Carbon::parse($DocumentoPDF->fecha)->format('Y-m-d') .
                '_' .
                $DocumentoPDF->nro_orden .
                '.pdf'
        );
    }
}
