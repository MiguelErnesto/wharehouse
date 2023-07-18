<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RecepcionProducto;

class RecepcionProductoController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin.recepcion_productos.index')->only('index');
        $this->middleware('can:admin.recepcion_productos.create')->only(
            'create',
            'store'
        );
        $this->middleware('can:admin.recepcion_productos.edit')->only(
            'edit',
            'update'
        );
        $this->middleware('can:admin.recepcion_productos.destroy')->only(
            'destroy'
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recepcion_productos = RecepcionProducto::all();
        return view(
            'admin.recepcion_productos.index',
            compact('recepcion_productos')
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function destroy($id)
    {
        //
    }
}
