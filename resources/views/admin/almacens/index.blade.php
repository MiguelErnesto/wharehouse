@extends('adminlte::page')

@section('title', config('app.name'))

@section('content_header')
    <span class="text-uppercase page-subtitle">Listado de <h1 class='pl-3'>Almacenes</h1></span>
@stop

@section('content')
    @if (session('info'))
        <div class="alert alert-success" role="alert">
            <strong>{{ session('info') }}</strong>
        </div>
    @endif

    <div class="card">
        @can('admin.almacens.create')
            <div class="card-header">
                <a href="{{ route('almacens.create') }}" class="btn btn-info" title="Crear Nuevo"><i
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
                    @foreach ($almacenes as $almacen)
                        <tr>
                            <td>{{ $almacen->nombre }}</td>
                            <td>{{ $almacen->direccion }}</td>
                            <td width='10px' class="text-right">
                                @can('admin.almacens.edit')
                                    <a class="btn btn-primary btn-sm" href="{{ route('almacens.edit', $almacen) }}"
                                        title="Editar">
                                        <i class="fas fa-solid fa-pen"></i></a>
                                @endcan
                            </td>
                            <td width='10px' class="text-right">
                                @can('admin.almacens.destroy')
                                    <form action="{{ route('almacens.destroy', $almacen) }}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                                            <i class="fas fa-solid fa-trash fa-lg"></i></button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@stop
