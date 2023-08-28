@extends('adminlte::page')

@section('title', config('app.name'))

@section('content_header')
    <span class="text-uppercase page-subtitle">Listado de <h1 class='pl-3'>Vales</h1></span>
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
        @can('admin.vales.create')
            <div class="card-header">
                <a href="{{ route('vales.create') }}" class="btn btn-info" title="Crear Nuevo"><i
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
                    @if (count($vales) == 0)
                        <tr>
                            <td colspan='7' class='text-center'><i>No hay elementos para mostrar...</i></td>
                        </tr>
                    @else
                        @foreach ($vales as $vale)
                            <tr>
                                <td>{{ $vale->updated_at > $vale->created_at ? $vale->updated_at : $vale->created_at }}</td>

                                <td>{{ $vale->nro_vale }}</td>
                                <td>{{ $vale->tipo_vale == 'E' ? 'Entrega' : 'Salida' }}</td>
                                @foreach ($entidades as $entidad)
                                    @if ($entidad->id == $vale->entidad_id)
                                        <td>{{ $entidad->nombre }}</td>
                                    @endif
                                @endforeach
                                @foreach ($almacenes as $almacen)
                                    @if ($almacen->id == $vale->almacen_id)
                                        <td>{{ $almacen->nombre }}</td>
                                    @endif
                                @endforeach

                                @can('Listar vales')
                                    <td style="padding-right: 0rem;padding-left: 0.125rem;" width='8px' class="text-right">
                                        <a class="btn btn-info btn-sm btnVerDetalles" data-bs-toggle="modal"
                                            data-bs-target="#myModal" data-id="{{ $vale->id }}" title="Ver detalles">
                                            <i class="fas fa-info fa-fw"></i>
                                        </a>
                                    @endcan
                                </td>

                                @can('imprimir')
                                    <td style="padding-right: 0rem;padding-left: 0.125rem;" width='8px' class="text-right">
                                        <a class="btn btn-primary btn-sm btnPrint" data-id="{{ $vale->id }}"
                                            title="Imprimir">
                                            <i class="fas fa-print fa-fw"></i>
                                        </a>
                                    </td>
                                @endcan

                                @can('Editar vale')
                                    <td style="padding-right: 0rem;padding-left: 0.125rem;" width='8px' class="text-right">
                                        <a class="btn btn-success btn-sm" href="{{ route('vales.edit', $vale) }}"
                                            title="Editar">
                                            <i class="fas fa-solid fa-pen"></i></a>
                                    </td>
                                @endcan

                                @can('Eliminar vale')
                                    <td style="padding-right: 0.75rem;padding-left: 0.125rem;" width='8px'
                                        class="text-right">
                                        <form id='formIndex_{{ $vale->id }}' action="{{ route('vales.destroy', $vale) }}"
                                            method="POST">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" data-id={{ $vale->id }}
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
    @include('admin.vales.modals.verDetalles')

@stop

@section('js')
    {{-- <script type="module" src="{{ asset('warehouse') }}/almacenes.js?{{ env('JS_VERSION') }}"></script> --}}
    <script async type="module" src="{{ mix('/js/compiled/vales.js') }}"></script>

@stop
