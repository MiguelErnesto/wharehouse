@extends('adminlte::page')

@section('title', config('app.name'))

@section('content_header')
    <span class="text-uppercase page-subtitle">Listado de <h1 class='pl-3'>facturas</h1></span>
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
        @can('admin.facturas.create')
            <div class="card-header">
                <a href="{{ route('facturas.create') }}" class="btn btn-info" title="Crear Nuevo"><i
                        class="fas fa-solid fa-file pr-3"></i>Nuevo</a>
            </div>
        @endcan
        <div class="card-body">
            <table class="table table-striped">
                <thead class="thead-inverse">
                    <tr>
                        <th>Fecha</th>
                        <th>No.</th>
                        <th>Entidad</th>
                        <th class='text-right'>Importe</th>
                        <th></th>
                        <th colspan="3" class='text-center'></th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($facturas) == 0)
                        <tr>
                            <td colspan='9' class='text-center'><i>No hay elementos para mostrar...</i></td>
                        </tr>
                    @else
                        @foreach ($facturas as $factura)
                            <tr>
                                <td>{{ $factura->fecha_modelo }}</td>
                                <td>{{ $factura->nro_factura }}</td>
                                @foreach ($entidades as $entidad)
                                    @if ($entidad->id == $factura->entidad_id)
                                        <td>{{ $entidad->nombre }}</td>
                                    @endif
                                @endforeach
                                <td class="text-right">$ {{ $factura->importe_total }}</td>

                                <td></td>

                                @can('Listar facturas')
                                    <td style="padding-right: 0rem;padding-left: 0.125rem;" width='8px' class="text-right">
                                        <a class="btn btn-info btn-sm btnVerDetalles" data-bs-toggle="modal"
                                            data-bs-target="#myModal" data-id="{{ $factura->id }}" title="Ver detalles">
                                            <i class="fas fa-info fa-fw"></i>
                                        </a>
                                    </td>
                                @endcan

                                @can('Imprimir documento', 'Exportar documento')
                                    <td style="padding-right: 0rem;padding-left: 0.125rem;" width='8px' class="text-right">
                                        <a class="btn btn-primary btn-sm btnPrint" data-id="{{ $factura->id }}"
                                            title="Imprimir">
                                            <i class="fas fa-print fa-fw"></i>
                                        </a>
                                    </td>
                                @endcan

                                @can('Editar factura')
                                    <td style="padding-right: 0rem;padding-left: 0.125rem;" width='8px' class="text-right">
                                        <a class="btn btn-success btn-sm" href="{{ route('facturas.edit', $factura) }}"
                                            title="Editar">
                                            <i class="fas fa-solid fa-pen"></i></a>
                                    </td>
                                @endcan

                                @can('Eliminar factura')
                                    <td style="padding-right: 0.75rem;padding-left: 0.125rem;" width='8px'
                                        class="text-right">
                                        <form id='formIndex_{{ $factura->id }}'
                                            action="{{ route('facturas.destroy', $factura) }}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" data-id={{ $factura->id }}
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
    @include('admin.facturas.modals.verDetalles')

@stop

@section('js')
    {{-- <script type="module" src="{{ asset('warehouse') }}/almacenes.js?{{ env('JS_VERSION') }}"></script> --}}
    <script async type="module" src="{{ mix('/js/compiled/facturas.js') }}"></script>

@stop
