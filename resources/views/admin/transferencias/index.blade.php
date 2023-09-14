@extends('adminlte::page')

@section('title', config('app.name'))

@section('content_header')
    <span class="text-uppercase page-subtitle">Listado de <h1 class='pl-3'>transferencias</h1></span>
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
        @can('Crear transferencia')
            <div class="card-header">
                <a href="{{ route('transferencias.create') }}" class="btn btn-info" title="Crear Nuevo"><i
                        class="fas fa-solid fa-file pr-3"></i>Nuevo</a>
            </div>
        @endcan
        <div class="card-body">
            <table class="table table-striped">
                <thead class="thead-inverse">
                    <tr>
                        <th>Fecha</th>
                        <th class='text-center'>No.</th>
                        <th class='text-center'>Entidad</th>
                        <th class='text-center'>Origen</th>
                        <th>Destino</th>
                        <th colspan="3" class='text-center'></th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($transferencias) == 0)
                        <tr>
                            <td colspan='7' class='text-center'><i>No hay elementos para mostrar...</i></td>
                        </tr>
                    @else
                        @foreach ($transferencias as $transferencia)
                            <tr>
                                <td>{{ $transferencia->fecha_modelo }}</td>
                                <td>{{ $transferencia->nro_transferencia }}</td>
                                <td>
                                    @foreach ($entidades as $entidad)
                                        @if ($entidad->id == $transferencia->entidad_id)
                                            {{ $entidad->nombre }}
                                        @endif
                                    @endforeach
                                </td>
                                <td class='text-center'>
                                    @foreach ($almacenes as $almacen)
                                        @if ($almacen->id == $transferencia->almacen_origen_id)
                                            {{ $almacen->nombre }}
                                        @endif
                                    @endforeach
                                </td>
                                <td class='text-center'>
                                    @foreach ($almacenes as $almacen)
                                        @if ($almacen->id == $transferencia->almacen_destino_id)
                                            {{ $almacen->nombre }}
                                        @endif
                                    @endforeach
                                </td>

                                @can('Listar transferencias')
                                    <td style="padding-right: 0rem;padding-left: 0.125rem;" width='8px' class="text-right">
                                        <a class="btn btn-info btn-sm btnVerDetalles" data-bs-toggle="modal"
                                            data-bs-target="#myModal" data-id="{{ $transferencia->id }}" title="Ver detalles">
                                            <i class="fas fa-info fa-fw"></i>
                                        </a>
                                    </td>
                                @endcan

                                @can('Imprimir')
                                    <td style="padding-right: 0rem;padding-left: 0.125rem;" width='8px' class="text-right">
                                        <a class="btn btn-primary btn-sm btnPrint" data-id="{{ $transferencia->id }}"
                                            title="Imprimir">
                                            <i class="fas fa-print fa-fw"></i>
                                        </a>
                                    </td>
                                @endcan

                                @can('Exportar PDF')
                                    <td style="padding-right: 0rem;padding-left: 0.125rem;" width='8px' class="text-right">
                                        <a class="btn btn-warning btn-sm btnPDFExport" data-id="{{ $transferencia->id }}"
                                            title="Exportar">
                                            <i style="color: #31343b;" class="fas fa-file-pdf fa-fw"></i>
                                        </a>
                                    </td>
                                @endcan

                                @can('Editar transferencia')
                                    <td style="padding-right: 0rem;padding-left: 0.125rem;" width='8px' class="text-right">
                                        <a class="btn btn-success btn-sm"
                                            href="{{ route('transferencias.edit', $transferencia) }}" title="Editar">
                                            <i class="fas fa-solid fa-pen"></i></a>
                                    </td>
                                @endcan


                                @can('Eliminar transferencia')
                                    <td style="padding-right: 0.75rem;padding-left: 0.125rem;" width='8px'
                                        class="text-right">
                                        <form id='formIndex_{{ $transferencia->id }}'
                                            action="{{ route('transferencias.destroy', $transferencia) }}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" data-id={{ $transferencia->id }}
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
    @include('admin.transferencias.modals.verDetalles')

@stop

@section('js')
    {{-- <script type="module" src="{{ asset('warehouse') }}/almacenes.js?{{ env('JS_VERSION') }}"></script> --}}
    <script async type="module" src="{{ mix('/js/compiled/transferencias.js') }}"></script>

@stop
