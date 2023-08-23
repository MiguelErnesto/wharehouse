@extends('adminlte::page')

@section('title', config('app.name'))

@section('content_header')
    <span class="text-uppercase page-subtitle">Listado de <h1 class='pl-3'>Conduces</h1></span>
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
        @can('admin.conduces.create')
            <div class="card-header">
                <a href="{{ route('conduces.create') }}" class="btn btn-info" title="Crear Nuevo"><i
                        class="fas fa-solid fa-file pr-3"></i>Nuevo</a>
            </div>
        @endcan
        <div class="card-body">
            <table class="table table-striped">
                <thead class="thead-inverse">
                    <tr>
                        <th>Fecha</th>
                        <th>No.</th>
                        <th>Tipo</th>
                        <th>Entidad</th>
                        <th>Almacén</th>
                        <th colspan="3" class='text-center'></th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($conduces) == 0)
                        <tr>
                            <td colspan='7' class='text-center'><i>No hay elementos para mostrar...</i></td>
                        </tr>
                    @else
                        @foreach ($conduces as $conduce)
                            <tr>
                                <td>{{ $conduce->updated_at > $conduce->created_at ? $conduce->updated_at : $conduce->created_at }}
                                </td>

                                <td>{{ $conduce->nro_vale }}</td>
                                <td>{{ $conduce->tipo_vale == 'E' ? 'Entrega' : 'Salida' }}</td>
                                @foreach ($entidades as $entidad)
                                    @if ($entidad->id == $conduce->entidad_id)
                                        <td>{{ $entidad->nombre }}</td>
                                    @endif
                                @endforeach
                                @foreach ($almacenes as $almacen)
                                    @if ($almacen->id == $conduce->almacen_id)
                                        <td>{{ $almacen->nombre }}</td>
                                    @endif
                                @endforeach

                                <td style="padding-right: 0rem;padding-left: 0.125rem;" width='8px' class="text-right">
                                    @can('admin.almacenes_productos.index')
                                        <a class="btn btn-info btn-sm btnVerDetalles" data-bs-toggle="modal"
                                            data-bs-target="#myModal" data-id="{{ $conduce->id }}" title="Ver detalles">
                                            <i class="fas fa-info fa-fw"></i>
                                        </a>
                                    @endcan
                                </td>

                                <td style="padding-right: 0rem;padding-left: 0.125rem;" width='8px' class="text-right">
                                    @can('admin.almacenes_productos.index')
                                        <a class="btn btn-primary btn-sm btnPrint" data-id="{{ $conduce->id }}"
                                            title="Imprimir">
                                            <i class="fas fa-print fa-fw"></i>
                                        </a>
                                    @endcan
                                </td>

                                <td style="padding-right: 0rem;padding-left: 0.125rem;" width='8px' class="text-right">
                                    @can('admin.conduces.edit')
                                        <a class="btn btn-success btn-sm" href="{{ route('conduces.edit', $conduce) }}"
                                            title="Editar">
                                            <i class="fas fa-solid fa-pen"></i></a>
                                    @endcan
                                </td>


                                <td style="padding-right: 0.75rem;padding-left: 0.125rem;" width='8px'
                                    class="text-right">
                                    @can('admin.conduces.destroy')
                                        <form id='formIndex_{{ $conduce->id }}'
                                            action="{{ route('conduces.destroy', $conduce) }}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" data-id={{ $conduce->id }}
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

    {{-- Modal para ver Informe de Recepción  --}}
    @include('admin.conduces.modals.verDetalles')

@stop

@section('js')
    {{-- <script type="module" src="{{ asset('wharehouse') }}/almacenes.js?{{ env('JS_VERSION') }}"></script> --}}
    <script async type="module" src="{{ mix('/js/compiled/conduces.js') }}"></script>

@stop
