<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transferencia;
use App\Models\TransferenciaProducto;
use App\Models\Almacen;
use App\Models\Entidad;
use App\Models\User;
use App\Models\Producto;
use App\Models\AlmacenProducto;
use App\Http\Controllers\AlmacenProductoController;

class TransferenciaController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin.transferencias.index')->only('index');
        $this->middleware('can:admin.transferencias.create')->only(
            'create',
            'store'
        );
        $this->middleware('can:admin.transferencias.edit')->only(
            'edit',
            'update'
        );
        $this->middleware('can:admin.transferencias.destroy')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transferencias = Transferencia::orderBy('fecha_modelo', 'desc')->get();
        $usuarios = User::all();
        $almacenes = Almacen::orderBy('nombre', 'desc')->get();
        $entidades = Entidad::orderBy('nombre', 'desc')->get();

        return view(
            'admin.transferencias.index',
            compact('transferencias', 'usuarios', 'almacenes', 'entidades')
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
            'admin.transferencias.create',
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
        //Guardar nueva transferencia
        $request->validate([
            'entidad_id',
            'almacen_origen_id',
            'almacen_destino_id',
            'user_id',
            'nro_transferencia',
            'fecha_modelo',
            'fecha_traslado',
            'fecha_recepcion',
            'persona_autoriza',
            'persona_entrega',
            'persona_recibe',
            'persona_actualiza_origen',
            'persona_actualiza_destino',
            'persona_contabiliza_origen',
            'persona_contabiliza_destino',
            'importe_total_entrega',
            'importe_total_recibido',
        ]);

        $transferencia = Transferencia::create($request->all());
        $transferencia_id = Transferencia::latest()->first()->id;
        $almacen_id = $request->almacen_destino_id;
        //$cantidad_remitida = $request->cantidad_remitida;
        //$cantidad_recibida = $request->cantidad_recibida;
        $productos = $request->productos;

        foreach ($productos as $producto) {
            //Agregar productos y cantidades a Recepcion Productos

            $RPid = TransferenciaProducto::create([
                'transferencia_id' => $transferencia_id,
                'producto_id' => $producto['id'],
                'cantidad_remitida' => $producto['cantidad_remitida'],
                'cantidad_recibida' => $producto['cantidad_recibida'],
            ]);

            //Guardar o actualizar productos en el almacen seleccionado
            $found = AlmacenProducto::where('producto_id', '=', $producto['id'])
                ->where('almacen_id', '=', $almacen_id)
                ->first();

            if ($found) {
                $almProdId = $found->update([
                    'cantidad' =>
                        intval($found->cantidad) +
                        intval($producto['cantidad_recibida']),
                ]);
            } else {
                $almProdId = AlmacenProducto::create([
                    'almacen_id' => $almacen_id,
                    'producto_id' => $producto['id'],
                    'cantidad' => $producto['cantidad_recibida'],
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
    public function destroy(Transferencia $transferencia)
    {
        $transferenciaProductos = TransferenciaProducto::where(
            'transferencia_id',
            '=',
            $transferencia->id
        )->delete();
        $transferencia->delete();
        return redirect()
            ->route('transferencias.index')
            ->with(
                'info',
                'Vale ' .
                    $transferencia->nro_transferencia .
                    ' eliminada correctamente'
            );
    }

    public function getDetalles($id)
    {
        $detalles = Transferencia::where('transferencias.id', '=', $id)
            ->join(
                'entidades as ent',
                'ent.id',
                '=',
                'transferencias.entidad_id'
            )
            ->join('users as u', 'u.id', '=', 'transferencias.user_id')
            ->select(
                'transferencias.id as id',
                'transferencias.fecha_modelo as fecha_modelo',
                'transferencias.nro_transferencia as nro_transferencia',
                'transferencias.almacen_origen_id as almacen_origen_id',
                'transferencias.almacen_destino_id as almacen_destino_id',
                'transferencias.fecha_modelo as fecha_modelo',
                'transferencias.fecha_traslado as fecha_traslado',
                'transferencias.fecha_recepcion as fecha_recepcion',
                'transferencias.persona_autoriza as persona_autoriza',
                'transferencias.persona_entrega as persona_entrega',
                'transferencias.persona_recibe as persona_recibe',
                'transferencias.persona_actualiza_origen as persona_actualiza_origen',
                'transferencias.persona_contabiliza_origen as persona_contabiliza_origen',
                'transferencias.persona_actualiza_destino as persona_actualiza_destino',
                'transferencias.persona_contabiliza_destino as persona_contabiliza_destino',
                'transferencias.importe_total_entrega as importe_total_entrega',
                'transferencias.importe_total_recibido as importe_total_recibido',
                'ent.nombre as entidad',
                'u.name as usuario'
            )
            ->get();

        $productos = Transferencia::where('transferencias.id', '=', $id)
            ->join(
                'transferencia_productos as tp',
                'tp.transferencia_id',
                '=',
                'transferencias.id'
            )
            ->join('productos as p', 'p.id', '=', 'tp.producto_id')
            ->select(
                'p.nombre as nombre',
                'p.codigo as codigo',
                'p.descripcion as descripcion',
                'tp.cantidad_remitida as cantidad_remitida',
                'tp.cantidad_recibida as cantidad_recibida'
            )
            ->get();

        $almacenes = Almacen::orderBy('nombre', 'desc')->get();

        return response()->json([
            'detalles' => $detalles,
            'productos' => $productos,
            'almacenes' => $almacenes,
        ]);
    }

    public function imprimir($id)
    {
        $detalles = Transferencia::where('transferencias.id', '=', $id)
            ->join(
                'entidades as ent',
                'ent.id',
                '=',
                'transferencias.entidad_id'
            )
            ->join('users as u', 'u.id', '=', 'transferencias.user_id')
            ->select(
                'transferencias.id as id',
                'transferencias.fecha_modelo as fecha_modelo',
                'transferencias.nro_transferencia as nro_transferencia',
                'transferencias.almacen_origen_id as almacen_origen_id',
                'transferencias.almacen_destino_id as almacen_destino_id',
                'transferencias.fecha_modelo as fecha_modelo',
                'transferencias.fecha_traslado as fecha_traslado',
                'transferencias.fecha_recepcion as fecha_recepcion',
                'transferencias.persona_autoriza as persona_autoriza',
                'transferencias.persona_entrega as persona_entrega',
                'transferencias.persona_recibe as persona_recibe',
                'transferencias.persona_actualiza_origen as persona_actualiza_origen',
                'transferencias.persona_contabiliza_origen as persona_contabiliza_origen',
                'transferencias.persona_actualiza_destino as persona_actualiza_destino',
                'transferencias.persona_contabiliza_destino as persona_contabiliza_destino',
                'transferencias.importe_total_entrega as importe_total_entrega',
                'transferencias.importe_total_recibido as importe_total_recibido',
                'ent.nombre as entidad',
                'u.name as usuario'
            )
            ->get();

        $productos = Transferencia::where('transferencias.id', '=', $id)
            ->join(
                'transferencia_productos as tp',
                'tp.transferencia_id',
                '=',
                'transferencias.id'
            )
            ->join('productos as p', 'p.id', '=', 'tp.producto_id')
            ->select(
                'p.nombre as nombre',
                'p.codigo as codigo',
                'p.descripcion as descripcion',
                'tp.cantidad_remitida as cantidad_remitida',
                'tp.cantidad_recibida as cantidad_recibida'
            )
            ->get();

        $almacenes = Almacen::orderBy('nombre', 'desc')->get();

        return view(
            'admin.transferencias.print',
            compact('detalles', 'almacenes', 'productos')
        );
    }
}
