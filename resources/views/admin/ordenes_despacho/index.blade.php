@extends('adminlte::page')

@section('title', config('app.name'))

@section('content_header')
    <span class="text-uppercase page-subtitle">Listado de <h1 class='pl-3'>Ordenes de Despacho</h1></span>
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
        @can('admin.ordenes_despacho.create')
            <div class="card-header">
                <a href="{{ route('ordenes_despacho.create') }}" class="btn btn-info" title="Crear Nuevo"><i
                        class="fas fa-solid fa-file pr-3"></i>Nuevo</a>
            </div>
        @endcan
        <div class="card-body">
            <table class="table table-striped">
                <thead class="thead-inverse">
                    <tr>
                        <th>Fecha</th>
                        <th>No. Orden</th>
                        <th>Almacén</th>
                        <th class='text-center'>Tipo de Salida</th>
                        <th colspan="3" class='text-center'></th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($ordenes_despacho) == 0)
                        <tr>
                            <td colspan='5' class='text-center'><i>No hay elementos para mostrar...</i></td>
                        </tr>
                    @else
                        @foreach ($ordenes_despacho as $orden_despacho)
                            <tr>
                                <td>{{ $orden_despacho->fecha }}</td>

                                <td>{{ $orden_despacho->nro_orden }}</td>
                                @foreach ($almacenes as $almacen)
                                    @if ($almacen->id == $orden_despacho->almacen_id)
                                        <td>{{ $almacen->nombre }}</td>
                                    @endif
                                @endforeach
                                <td class='text-center'>{{ $orden_despacho->vale_id ? 'VALE' : 'TRANSFERENCIA' }}</td>

                                @can('Listar ordenes despacho')
                                    <td style="padding-right: 0rem;padding-left: 0.125rem;" width='8px' class="text-right">
                                        <a class="btn btn-info btn-sm btnVerDetalles" data-bs-toggle="modal"
                                            data-bs-target="#myModal" data-id="{{ $orden_despacho->id }}" title="Ver detalles">
                                            <i class="fas fa-info fa-fw"></i>
                                        </a>
                                    </td>
                                @endcan

                                @can('Imprimir documento', 'Exportar documento')
                                    <td style="padding-right: 0rem;padding-left: 0.125rem;" width='8px' class="text-right">
                                        <a class="btn btn-primary btn-sm btnPrint" data-id="{{ $orden_despacho->id }}"
                                            title="Imprimir">
                                            <i class="fas fa-print fa-fw"></i>
                                        </a>
                                    </td>
                                @endcan

                                @can('Editar orden despacho')
                                    <td style="padding-right: 0rem;padding-left: 0.125rem;" width='8px' class="text-right">
                                        <a class="btn btn-success btn-sm"
                                            href="{{ route('ordenes_despacho.edit', $orden_despacho) }}" title="Editar">
                                            <i class="fas fa-solid fa-pen"></i></a>
                                    </td>
                                @endcan

                                @can('Eliminar orden despacho')
                                    <td style="padding-right: 0.75rem;padding-left: 0.125rem;" width='8px'
                                        class="text-right">
                                        <form id='formIndex_{{ $orden_despacho->id }}'
                                            action="{{ route('ordenes_despacho.destroy', $orden_despacho) }}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" data-id={{ $orden_despacho->id }}
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

    {{-- Modal para ver Informe de Recepción  --}}
    @include('admin.ordenes_despacho.modals.verDetalles')

@stop

@section('js')
    {{-- <script type="module" src="{{ asset('warehouse') }}/almacenes.js?{{ env('JS_VERSION') }}"></script> --}}
    <script async type="module" src="{{ mix('/js/compiled/ordenes_despacho.js') }}"></script>

@stop
