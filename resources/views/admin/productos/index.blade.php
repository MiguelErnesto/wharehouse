@extends('adminlte::page')

@section('title', config('app.name'))

@section('content_header')
    <span class="text-uppercase page-subtitle">Listado de <h1 class='pl-3'>Productos</h1></span>
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
        @can('Crear producto')
            <div class="card-header">
                <a href="{{ route('productos.create') }}" class="btn btn-info" title="Crear Nuevo"><i
                        class="fas fa-solid fa-file pr-3"></i>Nuevo</a>
            </div>
        @endcan
        <div class="card-body">
            <table class="table table-striped">
                <thead class="thead-inverse">
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th colspan="2" class='text-center'></th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($productos) == 0)
                        <tr>
                            <td colspan='4' class='text-center'><i>No hay elementos para mostrar...</i></td>
                        </tr>
                    @else
                        @foreach ($productos as $producto)
                            <tr>
                                <td>{{ $producto->codigo }}</td>
                                <td>{{ $producto->nombre }}</td>
                                <td>{{ $producto->descripcion }}</td>

                                @can('Editar producto')
                                    <td style="padding-left: 0rem;padding-right: 0rem;" width='8px' class="text-right">
                                        <a class="btn btn-success btn-sm" href="{{ route('productos.edit', $producto) }}"
                                            title="Editar">
                                            <i class="fas fa-solid fa-pen"></i></a>
                                    </td>
                                @endcan

                                @can('Eliminar producto')
                                    <td style="padding-left: 0.125rem;padding-right: 0.75rem;" width='8px'
                                        class="text-right">
                                        <form id='formIndex_{{ $producto->id }}'
                                            action="{{ route('productos.destroy', $producto) }}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" data-id={{ $producto->id }}
                                                class="btn btn-danger btn-sm btnDelete" title='Eliminar'>
                                                <i class="fas fa-solid fa-trash fa-lg"></i></button>
                                        </form>
                                    </td>
                                @endcan

                            </tr>
                        @endforeach
                    @endif


                </tbody>
            </table>
        </div>
    </div>

@stop

@section('js')
    {{-- <script type="module" src="{{ asset('warehouse') }}/almacenes.js?{{ env('JS_VERSION') }}"></script> --}}
    <script async type="module" src="{{ mix('/js/compiled/productos.js') }}"></script>

@stop
