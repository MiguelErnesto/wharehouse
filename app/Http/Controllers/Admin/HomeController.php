<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Entidad;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\InformeRecepcion;
use App\Models\OrdenDespacho;
use App\Models\Transferencia;
use App\Models\Conduce;
use App\Models\Factura;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $entidades = Entidad::all()->count();
        $clientes = Cliente::all()->count();
        $productos = Producto::all()->count();
        $informes_recepcion = InformeRecepcion::all()->count();
        $ordenes_despacho = OrdenDespacho::all()->count();
        $transferencias = Transferencia::all()->count();
        $conduces = Conduce::all()->count();
        $facturas = Factura::all()->count();
        $usuarios = User::all()->count();

        return view(
            'admin.index',
            compact(
                'entidades',
                'clientes',
                'productos',
                'informes_recepcion',
                'ordenes_despacho',
                'transferencias',
                'conduces',
                'facturas',
                'usuarios'
            )
        );
    }
}
