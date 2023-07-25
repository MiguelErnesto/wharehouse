@extends('adminlte::page')

@section('title', config('app.name'))

@section('content_header')
    <br />
@stop

@section('content')
    @if (session('info'))
        <div class="alert alert-success" role="alert">
            <strong>{{ session('info') }}</strong>
        </div>
    @endif

    <div class="card" style='width:95%;'>
        <div class="card-header bg-light text-dark pt-2">
            <h5 class='text-uppercase text-left pt-2'>Nuevo Infome - Recepción de Productos</h5>
        </div>

        <div class="card-body">
            {!! Form::open(['id' => 'form', 'route' => 'recepcion_productos.store']) !!}
            @include('admin.recepcion_productos.partials.form')
            <hr />
            <div class='text-right'>
                <a class="btn btn-danger" href="{{ route('recepcion_productos.index') }}"><i
                        class="fa fa-btn fa-ban pr-2"></i>Cancelar</a>
                {{ Form::button('<i class="fa fa-btn fa-save pr-2"></i> Guardar', ['type' => 'submit', 'class' => 'btn btn-primary']) }}
            </div>
            {!! Form::close() !!}
        </div>

        {{-- <div class="card-footer">
        </div> --}}

    </div>
@stop

@section('js')
    <script src="{{ asset('vendor/jQuery-Plugin-stringToSlug-1.3/jquery.stringToSlug.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("#name").stringToSlug({
                setEvents: 'keyup keydown blur',
                getPut: '#slug',
                space: '-'
            });
        });
    </script>
    <script async type="module" src="{{ mix('/js/compiled/recepcion_productos.js') }}"></script>
@stop
