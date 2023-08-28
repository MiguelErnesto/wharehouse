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
                        <th>Entidad</th>
                        <th class='text-right'>Factura asociada</th>
                        <th></th>
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
                                <td>{{ $conduce->fecha_modelo }}
                                </td>

                                <td>{{ $conduce->nro_conduce }}</td>
                                @foreach ($entidades as $entidad)
                                    @if ($entidad->id == $conduce->entidad_id)
                                        <td>{{ $entidad->nombre }}</td>
                                    @endif
                                @endforeach
                                <td class="text-right">{{ $conduce->nro_factura }}</td>
                                <td></td>

                                @can('Listar conduces')
                                    <td style="padding-right: 0rem;padding-left: 0.125rem;" width='8px' class="text-right">
                                        <a class="btn btn-info btn-sm btnVerDetalles" data-bs-toggle="modal"
                                            data-bs-target="#myModal" data-id="{{ $conduce->id }}" title="Ver detalles">
                                            <i class="fas fa-info fa-fw"></i>
                                        </a>
                                    </td>
                                @endcan

                                @can('Imprimir')
                                    <td style="padding-right: 0rem;padding-left: 0.125rem;" width='8px' class="text-right">
                                        <a class="btn btn-primary btn-sm btnPrint" data-id="{{ $conduce->id }}"
                                            title="Imprimir">
                                            <i class="fas fa-print fa-fw"></i>
                                        </a>
                                    </td>
                                @endcan

                                @can('Exportar PDF')
                                    <td style="padding-right: 0rem;padding-left: 0.125rem;" width='8px' class="text-right">
                                        <a class="btn btn-warning btn-sm btnPDFExport" data-id="{{ $conduce->id }}"
                                            title="Exportar">
                                            <i style="color: #31343b;" class="fas fa-file-pdf fa-fw"></i>
                                        </a>
                                    </td>
                                @endcan

                                @can('Editar conduce')
                                    <td style="padding-right: 0rem;padding-left: 0.125rem;" width='8px' class="text-right">
                                        <a class="btn btn-success btn-sm" href="{{ route('conduces.edit', $conduce) }}"
                                            title="Editar">
                                            <i class="fas fa-solid fa-pen"></i></a>
                                    </td>
                                @endcan

                                @can('Eliminar conduce')
                                    <td style="padding-right: 0.75rem;padding-left: 0.125rem;" width='8px'
                                        class="text-right">
                                        <form id='formIndex_{{ $conduce->id }}'
                                            action="{{ route('conduces.destroy', $conduce) }}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" data-id={{ $conduce->id }}
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
    @include('admin.conduces.modals.verDetalles')

@stop

@section('js')
    {{-- <script type="module" src="{{ asset('warehouse') }}/almacenes.js?{{ env('JS_VERSION') }}"></script> --}}
    <script async type="module" src="{{ mix('/js/compiled/conduces.js') }}"></script>

@stop
