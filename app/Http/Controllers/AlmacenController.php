<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Almacen;

class AlmacenController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:Listar almacenes')->only('index');
        $this->middleware('can:Crear almacen')->only('create', 'store');
        $this->middleware('can:Editar almacen')->only('edit', 'update');
        $this->middleware('can:Eliminar almacen')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $almacenes = Almacen::all();
        return view('admin.almacenes.index', compact('almacenes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.almacenes.create');
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
            'nombre' => 'required',
            'direccion' => 'required',
        ]);

        $almacen = Almacen::create($request->all());
        return redirect()
            ->route('almacenes.index')
            ->with(
                'info',
                'Almacén ' . $almacen->nombre . ' creado correctamente'
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
    public function edit(Almacen $almacen)
    {
        return view('admin.almacenes.edit', compact('almacen'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Almacen $almacen)
    {
        $request->validate([
            'nombre' => 'required',
            'direccion' => 'required',
        ]);

        $almacen->update($request->all());

        return redirect()
            ->route('almacenes.index')
            ->with(
                'info',
                'Almacén ' . $almacen->nombre . ' actualizado correctamente'
            );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Almacen $almacen)
    {
        $almacen->delete();

        return redirect()
            ->route('almacenes.index')
            ->with(
                'info',
                'Almacén ' . $almacen->nombre . ' eliminado correctamente'
            );
    }
}
