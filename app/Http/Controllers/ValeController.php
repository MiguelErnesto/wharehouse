<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vale;
use App\Models\ValeProducto;
use App\Models\Almacen;
use App\Models\Entidad;
use App\Models\User;
use App\Models\Producto;
use App\Models\AlmacenProducto;
use App\Http\Controllers\AlmacenProductoController;
use Carbon\Carbon;
use PDF;

class ValeController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:Listar vales')->only('index', 'getDetalles');
        $this->middleware('can:Crear vale')->only('create', 'store');
        $this->middleware('can:Editar vale')->only('edit', 'update');
        $this->middleware('can:Eliminar vale')->only('destroy');
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
        $vales = Vale::orderBy('updated_at', 'desc')->get();
        $usuarios = User::all();
        $almacenes = Almacen::orderBy('nombre', 'desc')->get();
        $entidades = Entidad::orderBy('nombre', 'desc')->get();

        return view(
            'admin.vales.index',
            compact('vales', 'usuarios', 'almacenes', 'entidades')
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
            'admin.vales.create',
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
        //Guardar nuevo vale
        $request->validate([
            'entidad_id' => 'required',
            'almacen_id' => 'required',
            'user_id' => 'required',
            'tipo_vale' => 'required',
            'nro_vale' => 'required',
            'importe_total' => 'required',
            'persona_emisor' => 'required',
            'persona_receptor' => 'required',
        ]);

        $vale = Vale::create($request->all());
        $vale_id = Vale::latest()->first()->id;
        $cantidad = $request->cantidad;
        $productos = $request->productos;

        foreach ($productos as $producto) {
            //Agregar productos y cantidades a Recepcion Productos

            $RPid = ValeProducto::create([
                'vale_id' => $vale_id,
                'producto_id' => $producto['id'],
                'cantidad' => $producto['cantidad'],
            ]);
        }
        return response()->json($vale_id);
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
    public function update(Request $request, Vale $vale)
    {
        $request->validate([
            'entidad_id' => 'required',
            'almacen_id' => 'required',
            'user_id' => 'required',
            'tipo_vale' => 'required',
            'nro_vale' => 'required',
            'importe_total' => 'required',
            'persona_emisor' => 'required',
            'persona_receptor' => 'required',
        ]);

        $vale->update($request->all());

        return redirect()
            ->route('vales.index')
            ->with(
                'info',
                'Vale ' . $vale->nro_vale . ' actualizado correctamente'
            );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vale $vale)
    {
        $valeProductos = ValeProducto::where(
            'vale_id',
            '=',
            $vale->id
        )->delete();
        $vale->delete();
        return redirect()
            ->route('vales.index')
            ->with(
                'info',
                'Vale ' . $vale->nro_vale . ' eliminado correctamente'
            );
    }

    public function getDetalles($id)
    {
        $detalles = Vale::where('vales.id', '=', $id)
            ->join('entidades as ent', 'ent.id', '=', 'vales.entidad_id')
            ->join('almacenes as alm', 'alm.id', '=', 'vales.almacen_id')
            ->join('users as u', 'u.id', '=', 'vales.user_id')
            ->select(
                'vales.id as id',
                'vales.created_at as created_at',
                'vales.updated_at as updated_at',
                'vales.nro_vale as nro_vale',
                'vales.tipo_vale as tipo_vale',
                'vales.importe_total as importe_total',
                'vales.persona_emisor as persona_emisor',
                'vales.persona_receptor as persona_receptor',
                'ent.nombre as entidad',
                'alm.nombre as almacen',
                'u.name as usuario'
            )
            ->get();

        $productos = Vale::where('vales.id', '=', $id)
            ->join('vale_productos as vp', 'vp.vale_id', '=', 'vales.id')
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
        $detalles = Vale::where('vales.id', '=', $id)
            ->join('entidades as ent', 'ent.id', '=', 'vales.entidad_id')
            ->join('almacenes as alm', 'alm.id', '=', 'vales.almacen_id')
            ->join('users as u', 'u.id', '=', 'vales.user_id')
            ->select(
                'vales.id as id',
                'vales.created_at as created_at',
                'vales.updated_at as updated_at',
                'vales.nro_vale as nro_vale',
                'vales.tipo_vale as tipo_vale',
                'vales.importe_total as importe_total',
                'vales.persona_emisor as persona_emisor',
                'vales.persona_receptor as persona_receptor',
                'ent.nombre as entidad',
                'alm.nombre as almacen',
                'u.name as usuario'
            )
            ->get();

        $productos = Vale::where('vales.id', '=', $id)
            ->join('vale_productos as vp', 'vp.vale_id', '=', 'vales.id')
            ->join('productos as p', 'p.id', '=', 'vp.producto_id')
            ->select(
                'p.nombre as nombre',
                'p.codigo as codigo',
                'p.descripcion as descripcion',
                'vp.cantidad as cantidad'
            )
            ->get();

        return view('admin.vales.print', compact('detalles', 'productos'));
    }

    public function exportarPDF($id)
    {
        $DocumentoPDF = Vale::where('id', '=', $id)
            ->select('nro_vale', 'fecha_modelo')
            ->first();

        $detalles = Vale::where('vales.id', '=', $id)
            ->join('entidades as ent', 'ent.id', '=', 'vales.entidad_id')
            ->join('almacenes as alm', 'alm.id', '=', 'vales.almacen_id')
            ->join('users as u', 'u.id', '=', 'vales.user_id')
            ->select(
                'vales.id as id',
                'vales.created_at as created_at',
                'vales.updated_at as updated_at',
                'vales.nro_vale as nro_vale',
                'vales.tipo_vale as tipo_vale',
                'vales.importe_total as importe_total',
                'vales.persona_emisor as persona_emisor',
                'vales.persona_receptor as persona_receptor',
                'ent.nombre as entidad',
                'alm.nombre as almacen',
                'u.name as usuario'
            )
            ->get();

        $productos = Vale::where('vales.id', '=', $id)
            ->join('vale_productos as vp', 'vp.vale_id', '=', 'vales.id')
            ->join('productos as p', 'p.id', '=', 'vp.producto_id')
            ->select(
                'p.nombre as nombre',
                'p.codigo as codigo',
                'p.descripcion as descripcion',
                'vp.cantidad as cantidad'
            )
            ->get();

        $pdf = PDF::loadView(
            'admin.vales.print',
            compact('productos', 'detalles')
        )->setOptions([
            'defaultFont' => 'sans-serif',
            'Letter' => 'landscape',
        ]);

        return $pdf->download(
            'Vale_' .
                Carbon::parse($DocumentoPDF->fecha_modelo)->format('Y-m-d') .
                '_' .
                $DocumentoPDF->nro_vale .
                '.pdf'
        );
    }
}
