<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conduce;
use App\Models\ConduceProducto;
use App\Models\Almacen;
use App\Models\Entidad;
use App\Models\Factura;
use App\Models\User;
use App\Models\Producto;
use App\Models\AlmacenProducto;
use App\Http\Controllers\AlmacenProductoController;
use Carbon\Carbon;
use PDF;

class ConduceController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:Listar conduces')->only('index', 'getDetalles');
        $this->middleware('can:Nuevo conduce')->only('create', 'store');
        $this->middleware('can:Editar conduce')->only('edit', 'update');
        $this->middleware('can:Eliminar conduce')->only('destroy');
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
        $conduces = Conduce::orderBy('fecha_modelo', 'desc')->get();
        $usuarios = User::all();
        $facturas = Factura::orderBy('nro_factura', 'desc')->get();
        $entidades = Entidad::orderBy('nombre', 'desc')->get();

        return view(
            'admin.conduces.index',
            compact('conduces', 'usuarios', 'facturas', 'entidades')
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

        $facturas = Factura::select('id', 'nro_factura')
            ->get()
            ->pluck('nro_factura', 'nro_factura');

        $productos = Producto::select('id', 'nombre')
            ->get()
            ->pluck('nombre', 'id');

        $almacenes = Almacen::select('id', 'nombre')
            ->get()
            ->pluck('nombre', 'id');

        return view(
            'admin.conduces.create',
            compact('entidades', 'almacenes', 'facturas', 'productos')
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
        //Guardar nuevo conduce
        $request->validate([
            'entidad_id',
            'user_id',
            'nro_conduce',
            'nro_factura',
            'fecha_modelo',
            'fecha_recepcion_transportador',
            'fecha_entrega',
            'fecha_recepcion',
            'persona_entrega',
            'persona_recepcion',
            'persona_actualiza',
            'persona_contabiliza',
            'transportador',
            'lugar_entrega',
            'comprador',
        ]);

        $conduce = Conduce::create($request->all());
        $conduce_id = Conduce::latest()->first()->id;
        $productos = $request->productos;

        foreach ($productos as $producto) {
            //Agregar productos y cantidades a Recepcion Productos

            $RPid = ConduceProducto::create([
                'conduce_id' => $conduce_id,
                'producto_id' => $producto['id'],
                'cantidad' => $producto['cantidad'],
            ]);
        }
        return response()->json($conduce_id);
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
    public function edit(Conduce $conduce)
    {
        $entidades = Entidad::select('id', 'nombre')
            ->get()
            ->pluck('nombre', 'id');

        $facturas = Factura::select('id', 'nro_factura')
            ->get()
            ->pluck('nro_factura', 'nro_factura');

        $productos = Producto::select('id', 'nombre')
            ->get()
            ->pluck('nombre', 'id');

        $almacenes = Almacen::select('id', 'nombre')
            ->get()
            ->pluck('nombre', 'id');

        return view(
            'admin.conduces.edit',
            compact(
                'entidades',
                'almacenes',
                'facturas',
                'productos',
                'conduce'
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
    public function update(Request $request, Conduce $conduce)
    {
        $request->validate([
            'entidad_id',
            'user_id',
            'nro_conduce',
            'nro_factura',
            'fecha_modelo',
            'fecha_recepcion_transportador',
            'fecha_entrega',
            'fecha_recepcion',
            'persona_entrega',
            'persona_recepcion',
            'persona_actualiza',
            'persona_contabiliza',
            'transportador',
            'lugar_entrega',
            'comprador',
        ]);

        $conduce->update($request->all());

        return redirect()
            ->route('conduces.index')
            ->with(
                'info',
                'Conduce ' .
                    $conduce->nro_conduce .
                    ' actualizado correctamente'
            );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Conduce $conduce)
    {
        $conduceProductos = ConduceProducto::where(
            'conduce_id',
            '=',
            $conduce->id
        )->delete();
        $conduce->delete();

        return redirect()
            ->route('conduces.index')
            ->with(
                'info',
                'Conduce ' . $conduce->nro_conduce . ' eliminado correctamente'
            );
    }

    public function getDetalles($id)
    {
        $detalles = Conduce::where('conduces.id', '=', $id)
            ->join('entidades as ent', 'ent.id', '=', 'conduces.entidad_id')
            ->join('users as u', 'u.id', '=', 'conduces.user_id')
            ->select(
                'conduces.id as id',
                'conduces.fecha_modelo as fecha_modelo',
                'conduces.nro_conduce as nro_conduce',
                'conduces.nro_factura as nro_factura',
                'conduces.comprador as comprador',
                'conduces.lugar_entrega as lugar_entrega',
                'conduces.transportador as transportador',
                'conduces.fecha_recepcion_transportador as fecha_recepcion_transportador',
                'conduces.persona_entrega as persona_entrega',
                'conduces.fecha_entrega as fecha_entrega',
                'conduces.persona_recepcion as persona_recepcion',
                'conduces.fecha_recepcion as fecha_recepcion',
                'conduces.persona_actualiza as persona_actualiza',
                'conduces.persona_contabiliza as persona_contabiliza',
                'ent.nombre as entidad',
                'u.name as usuario'
            )
            ->get();

        $productos = Conduce::where('conduces.id', '=', $id)
            ->join(
                'conduce_productos as vp',
                'vp.conduce_id',
                '=',
                'conduces.id'
            )
            ->join('productos as p', 'p.id', '=', 'vp.producto_id')
            ->select(
                'p.nombre as nombre',
                'p.codigo as codigo',
                'p.descripcion as descripcion',
                'vp.cantidad as cantidad'
            )
            ->get();

        return response()->json([
            'detalles' => $detalles,
            'productos' => $productos,
        ]);
    }

    public function imprimir($id)
    {
        $detalles = Conduce::where('conduces.id', '=', $id)
            ->join('entidades as ent', 'ent.id', '=', 'conduces.entidad_id')
            ->join('users as u', 'u.id', '=', 'conduces.user_id')
            ->select(
                'conduces.id as id',
                'conduces.fecha_modelo as fecha_modelo',
                'conduces.nro_conduce as nro_conduce',
                'conduces.nro_factura as nro_factura',
                'conduces.comprador as comprador',
                'conduces.lugar_entrega as lugar_entrega',
                'conduces.transportador as transportador',
                'conduces.fecha_recepcion_transportador as fecha_recepcion_transportador',
                'conduces.persona_entrega as persona_entrega',
                'conduces.fecha_entrega as fecha_entrega',
                'conduces.persona_recepcion as persona_recepcion',
                'conduces.fecha_recepcion as fecha_recepcion',
                'conduces.persona_actualiza as persona_actualiza',
                'conduces.persona_contabiliza as persona_contabiliza',
                'ent.nombre as entidad',
                'u.name as usuario'
            )
            ->get();

        $productos = Conduce::where('conduces.id', '=', $id)
            ->join(
                'conduce_productos as vp',
                'vp.conduce_id',
                '=',
                'conduces.id'
            )
            ->join('productos as p', 'p.id', '=', 'vp.producto_id')
            ->select(
                'p.nombre as nombre',
                'p.codigo as codigo',
                'p.descripcion as descripcion',
                'vp.cantidad as cantidad'
            )
            ->get();

        return view('admin.conduces.print', compact('detalles', 'productos'));
    }

    public function exportarPDF($id)
    {
        $DocumentoPDF = Conduce::where('id', '=', $id)
            ->select('nro_conduce', 'fecha_modelo')
            ->first();

        $detalles = Conduce::where('conduces.id', '=', $id)
            ->join('entidades as ent', 'ent.id', '=', 'conduces.entidad_id')
            ->join('users as u', 'u.id', '=', 'conduces.user_id')
            ->select(
                'conduces.id as id',
                'conduces.fecha_modelo as fecha_modelo',
                'conduces.nro_conduce as nro_conduce',
                'conduces.nro_factura as nro_factura',
                'conduces.comprador as comprador',
                'conduces.lugar_entrega as lugar_entrega',
                'conduces.transportador as transportador',
                'conduces.fecha_recepcion_transportador as fecha_recepcion_transportador',
                'conduces.persona_entrega as persona_entrega',
                'conduces.fecha_entrega as fecha_entrega',
                'conduces.persona_recepcion as persona_recepcion',
                'conduces.fecha_recepcion as fecha_recepcion',
                'conduces.persona_actualiza as persona_actualiza',
                'conduces.persona_contabiliza as persona_contabiliza',
                'ent.nombre as entidad',
                'u.name as usuario'
            )
            ->get();

        $productos = Conduce::where('conduces.id', '=', $id)
            ->join(
                'conduce_productos as vp',
                'vp.conduce_id',
                '=',
                'conduces.id'
            )
            ->join('productos as p', 'p.id', '=', 'vp.producto_id')
            ->select(
                'p.nombre as nombre',
                'p.codigo as codigo',
                'p.descripcion as descripcion',
                'vp.cantidad as cantidad'
            )
            ->get();

        $pdf = PDF::loadView(
            'admin.conduces.print',
            compact('productos', 'detalles')
        )->setOptions([
            'defaultFont' => 'sans-serif',
            'Letter' => 'landscape',
        ]);

        return $pdf->download(
            'Conduce_' .
                Carbon::parse($DocumentoPDF->fecha_modelo)->format('Y-m-d') .
                '_' .
                $DocumentoPDF->nro_conduce .
                '.pdf'
        );
    }
}
