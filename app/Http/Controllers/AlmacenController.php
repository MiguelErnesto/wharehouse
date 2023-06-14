<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Almacen;

class AlmacenController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin.almacens.index')->only('index');
        $this->middleware('can:admin.almacens.create')->only('create', 'store');
        $this->middleware('can:admin.almacens.edit')->only('edit', 'update');
        $this->middleware('can:admin.almacens.destroy')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $almacenes = Almacen::all();
        return view('admin.almacens.index', compact('almacenes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.almacens.create');
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
            ->route('almacens.index')
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
        return view('admin.almacens.edit', compact('almacen'));
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
            ->route('almacens.index')
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
            ->route('almacens.index')
            ->with(
                'info',
                'Almacén ' . $almacen->nombre . ' eliminado correctamente'
            );
    }
}
