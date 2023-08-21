@extends('adminlte::page')

@section('title', config('app.name'))

@section('content_header')
    <span class="text-uppercase page-subtitle">Listado de Productos<h1 class='pl-5'>
            {{ $almacen->nombre }}</h1></span>
    <br />
@stop

@section('content')
    @if (session('info'))
        <div class="alert alert-success" role="alert" style='width:95%;'>
            <strong>{{ session('info') }}</strong>
        </div>
        <br />
    @endif

    <div class="card" style='width:95%;'>
        <div class="card-body">
            <table class="table table-striped">
                <thead class="thead-inverse">
                    <tr>
                        <th class="text-left pl-5">Producto</th>
                        <th>Código</th>
                        <th>Descripción</th>
                        <th class="text-right pr-5">Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($almacen_productos) == 0)
                        <tr>
                            <td></td>
                            <td class='text-center'><i>No hay elementos para mostrar...</i></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @else
                        @foreach ($almacen_productos as $almacen_producto)
                            <tr>
                                <td class="text-left pl-5">{{ $almacen_producto->pNombre }}</td>
                                <td>{{ $almacen_producto->pCodigo }}</td>
                                <td>{{ $almacen_producto->pDescripcion }}</td>
                                <td class="text-right pr-5">{{ $almacen_producto->apCantidad }}</td>
                            </tr>
                        @endforeach
                    @endif

                </tbody>
            </table>
        </div>
    </div>

@stop

@section('js')
    {{-- <script type="module" src="{{ asset('wharehouse') }}/almacenes.js?{{ env('JS_VERSION') }}"></script> --}}
    <script async type="module" src="{{ mix('/js/compiled/almacenes.js') }}"></script>

@stop
