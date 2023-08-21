<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entidad;

class EntidadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $entidades = Entidad::all();
        return view('admin.entidades.index', compact('entidades'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.entidades.create');
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
        ]);

        $entidad = Entidad::create($request->all());
        return redirect()
            ->route('entidades.index')
            ->with(
                'info',
                'Entidad ' . $entidad->nombre . ' creada correctamente'
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
    public function edit(Entidad $entidad)
    {
        return view('admin.entidades.edit', compact('entidad'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Entidad $entidad)
    {
        $request->validate([
            'codigo' => 'required',
            'nombre' => 'required',
            'descripcion' => 'required',
        ]);

        $entidad->update($request->all());

        return redirect()
            ->route('entidades.index')
            ->with(
                'info',
                'Entidad ' . $entidad->nombre . ' actualizada correctamente'
            );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Entidad $entidad)
    {
        $entidad->delete();

        return redirect()
            ->route('entidades.index')
            ->with(
                'info',
                'Entidad ' . $entidad->nombre . ' eliminado correctamente'
            );
    }
}
