@extends('adminlte::page')

@section('title', config('app.name'))

@section('content_header')
    <h1>Nuevo Producto</h1>
@stop

@section('content')
    @if (session('info'))
        <div class="alert alert-success" role="alert">
            <strong>{{ session('info') }}</strong>
        </div>
    @endif

    <div class="card" style='width:95%;'>
        <div class="card-body">
            {!! Form::open(['id' => 'form', 'route' => 'productos.store']) !!}
            @include('admin.productos.partials.form')

            <div class='text-right'>
                <a class="btn btn-danger" href="{{ route('productos.index') }}"><i
                        class="fa fa-btn fa-ban pr-2"></i>Cancelar</a>
                {{ Form::button('<i class="fa fa-btn fa-save pr-2"></i> Crear', ['type' => 'submit', 'class' => 'btn btn-primary']) }}
            </div>
            {!! Form::close() !!}
        </div>
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
    <script async type="module" src="{{ mix('/js/compiled/productos.js') }}"></script>
@stop
