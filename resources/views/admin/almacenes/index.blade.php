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
                        <th colspan="3" class='text-center'>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($almacenes) == 0)
                        <tr>
                            <td colspan='5' class='text-center'><i>No hay elementos para mostrar...</i></td>
                        </tr>
                    @else
                        @foreach ($almacenes as $almacen)
                            <tr>
                                <td>{{ $almacen->nombre }}</td>
                                <td>{{ $almacen->direccion }}</td>
                                <td style="padding-right: 0.125rem;padding-left: 0.125rem;" width='8px'
                                    class="text-right">

                                    @can('admin.almacenes_productos.index')
                                        <a class="btn btn-primary btn-sm btnVerProdAlm" data-bs-toggle="modal"
                                            data-bs-target="#myModal" data-id={{ $almacen->id }}
                                            data-nombre="{{ $almacen->nombre }}" data-direccion="{{ $almacen->direccion }}"
                                            title="Ver Productos del Almacén">
                                            <i class="fas fa-boxes fa-fw"></i>
                                        </a>
                                    @endcan

                                </td>
                                <td style="padding-right: 0rem;padding-left: 0rem;" width='8px' class="text-right">
                                    @can('admin.almacenes.edit')
                                        <a class="btn btn-success btn-sm" href="{{ route('almacenes.edit', $almacen) }}"
                                            title="Editar almacén">
                                            <i class="fas fa-solid fa-pen"></i></a>
                                    @endcan
                                </td>
                                <td style="padding-right: 0.75rem;padding-left: 0.125rem;" width='8px'
                                    class="text-right">
                                    @can('admin.almacenes.destroy')
                                        <form id='formIndex_{{ $almacen->id }}'
                                            action="{{ route('almacenes.destroy', $almacen) }}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" data-id={{ $almacen->id }}
                                                class="btn btn-danger btn-sm btnDelete" title='Eliminar almacén'>
                                                <i class="fas fa-solid fa-trash"></i></button>
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

    {{-- Modal para ver Productos del Almacen  --}}
    @include('admin.almacenes.modals.verProductosAlmacen')

@stop

@section('js')
    <script async type="module" src="{{ mix('/js/compiled/almacenes.js') }}"></script>
@stop
