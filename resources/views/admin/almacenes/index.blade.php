@extends('adminlte::page')

@section('title', config('app.name'))

@section('content_header')
    <span class="text-uppercase page-subtitle">Listado de <h1 class='pl-3'>Almacenes</h1></span>
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
        @can('admin.almacenes.create')
            <div class="card-header">
                <a href="{{ route('almacenes.create') }}" class="btn btn-info" title="Crear Nuevo"><i
                        class="fas fa-solid fa-file pr-3"></i>Nuevo</a>
            </div>
        @endcan
        <div class="card-body">
            <table class="table table-striped">
                <thead class="thead-inverse">
                    <tr>
                        <th>Nombre</th>
                        <th>Dirección</th>
                        <th colspan="2" class='text-center'>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($almacenes) == 0)
                        <tr>
                            <td></td>
                            <td class='text-center'><i>No hay elementos para mostrar...</i></td>
                            <td></td>
                        </tr>
                    @else
                        @foreach ($almacenes as $almacen)
                            <tr>
                                <td>{{ $almacen->nombre }}</td>
                                <td>{{ $almacen->direccion }}</td>
                                <td width='10px' class="text-right">
                                    @can('admin.almacenes.edit')
                                        <a class="btn btn-success btn-sm" href="{{ route('almacenes.edit', $almacen) }}"
                                            title="Editar">
                                            <i class="fas fa-solid fa-pen"></i></a>
                                    @endcan
                                </td>
                                <td width='10px' class="text-right">
                                    @can('admin.almacenes.destroy')
                                        <form id='formIndex_{{ $almacen->id }}'
                                            action="{{ route('almacenes.destroy', $almacen) }}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" data-id={{ $almacen->id }}
                                                class="btn btn-danger btn-sm btnDelete" title='Eliminar'>
                                                <i class="fas fa-solid fa-trash fa-lg"></i></button>
                                        </form>
                                    @endcan
                                </td>
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
