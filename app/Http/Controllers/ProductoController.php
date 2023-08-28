<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class ProductoController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:Listar productos')->only('index');
        $this->middleware('can:Crear producto')->only('create', 'store');
        $this->middleware('can:Editar producto')->only('edit', 'update');
        $this->middleware('can:Eliminar producto')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productos = Producto::all();
        return view('admin.productos.index', compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.productos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required',
            'nombre' => 'required',
            'descripcion' => 'required',
            'unidad_medida' => 'required',
            'precio' => 'required',
        ]);

        $producto = Producto::create($request->all());
        return redirect()
            ->route('productos.index')
            ->with(
                'info',
                'Producto ' . $producto->nombre . ' creado correctamente'
            );
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
    public function edit(Producto $producto)
    {
        return view('admin.productos.edit', compact('producto'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'codigo' => 'required',
            'nombre' => 'required',
            'descripcion' => 'required',
            'unidad_medida' => 'required',
            'precio' => 'required',
        ]);

        $producto->update($request->all());

        return redirect()
            ->route('productos.index')
            ->with(
                'info',
                'Producto ' . $producto->nombre . ' actualizado correctamente'
            );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Producto $producto)
    {
        $producto->delete();

        return redirect()
            ->route('productos.index')
            ->with(
                'info',
                'Producto ' . $producto->nombre . ' eliminado correctamente'
            );
    }
}
