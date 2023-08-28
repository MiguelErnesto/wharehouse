@extends('adminlte::page')

@section('title', config('app.name'))

@section('content_header')
    <span class="text-uppercase page-subtitle">Listado de <h1 class='pl-3'>Entidades</h1></span>
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
        @can('Crear entidad')
            <div class="card-header">
                <a href="{{ route('entidades.create') }}" class="btn btn-info" title="Crear Nuevo"><i
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
                        <th colspan="3" class='text-center'></th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($entidades) == 0)
                        <tr>
                            <td colspan='5' class='text-center'><i>No hay elementos para mostrar...</i></td>
                        </tr>
                    @else
                        @foreach ($entidades as $entidad)
                            <tr>
                                <td>{{ $entidad->codigo }}</td>
                                <td>{{ $entidad->nombre }}</td>
                                <td>{{ $entidad->descripcion }}</td>

                                @can('Editar entidad')
                                    <td style="padding-right: 0rem;padding-left: 0rem;" width='8px' class="text-right">
                                        <a class="btn btn-success btn-sm" href="{{ route('entidades.edit', $entidad) }}"
                                            title="Editar">
                                            <i class="fas fa-solid fa-pen"></i></a>
                                    </td>
                                @endcan

                                @can('Eliminar entidad')
                                    <td style="padding-right: 0.75rem;padding-left: 0.125rem;" width='8px'
                                        class="text-right">
                                        <form id='formIndex_{{ $entidad->id }}'
                                            action="{{ route('entidades.destroy', $entidad) }}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" data-id={{ $entidad->id }}
                                                class="btn btn-danger btn-sm btnDelete" title='Eliminar'>
                                                <i class="fas fa-solid fa-trash"></i></button>
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
    <script async type="module" src="{{ mix('/js/compiled/entidades.js') }}"></script>
@stop
