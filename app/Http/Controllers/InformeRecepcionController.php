<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InformeRecepcion;
use App\Models\RecepcionProducto;
use App\Models\Almacen;
use App\Models\User;
use App\Models\Producto;
use App\Models\AlmacenProducto;
use App\Http\Controllers\AlmacenProductoController;
use PDF;

class InformeRecepcionController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:Listar informes recepcion')->only('index');
        $this->middleware('can:Crear informe recepcion')->only(
            'create',
            'store'
        );
        $this->middleware('can:Editar informe recepcion')->only(
            'edit',
            'update'
        );
        $this->middleware('can:Eliminar informe recepcion')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $informes_recepcion = InformeRecepcion::orderBy(
            'updated_at',
            'desc'
        )->get();
        $usuarios = User::all();
        $almacenes = Almacen::orderBy('nombre', 'desc')->get();

        return view(
            'admin.informes_recepcion.index',
            compact('informes_recepcion', 'usuarios', 'almacenes')
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
        //Guardar nuevo Informe de Recepcion
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
                $almProdId = AlmacenProducto::create([
                    'recepcion_producto_id' => $informe_recepcion_id,
                    'almacen_id' => $almacen_id,
                    'producto_id' => $producto['id'],
                    'cantidad' => $producto['cantidad'],
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
    public function edit(InformeRecepcion $informe_recepcion)
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
            'admin.informes_recepcion.edit',
            compact('informe_recepcion', 'almacenes', 'productos')
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
    public function destroy(InformeRecepcion $informe_recepcion)
    {
        $RecepcionProductos = RecepcionProducto::where(
            'informe_recepcion_id',
            '=',
            $informe_recepcion->id
        )->delete();

        $informe_recepcion->delete();

        return redirect()
            ->route('informes_recepcion.index')
            ->with(
                'info',
                'Informe ' .
                    $informe_recepcion->nro_informe .
                    ' eliminado correctamente'
            );
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

    public function imprimir($id)
    {
        $informe = InformeRecepcion::where('informes_recepcion.id', '=', $id)
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

        return view(
            'admin.informes_recepcion.print',
            compact('productos', 'informe')
        );
    }

    public function exportar($id)
    {
        $informe = InformeRecepcion::where('informes_recepcion.id', '=', $id)
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

        $data = [
            'title' =>
                'How To Create PDF File Using DomPDF In Laravel 9 - Techsolutionstuff',
            'date' => date('d/m/Y'),
            'informe' => $informe,
            'productos' => $productos,
        ];

        $pdf = PDF::loadView('admin.informes_recepcion.print', $data);
        //return $pdf->download('users_pdf_example.pdf');
        return $pdf->stream('result.pdf');

        return view(
            'admin.informes_recepcion.print',
            compact('productos', 'informe')
        );
    }
}
