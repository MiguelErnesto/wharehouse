@extends('adminlte::page')

@section('title', config('app.name'))

@section('content_header')
    <h1>Nuevo Almacén</h1>
@stop

@section('content')
    @if (session('info'))
        <div class="alert alert-success" role="alert">
            <strong>{{ session('info') }}</strong>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            {!! Form::open(['route' => 'almacens.store']) !!}
            @include('admin.almacens.partials.form')

            <div class='text-right'>
                <a class="btn btn-danger" href="{{ url()->previous() }}"><i class="fa fa-btn fa-ban pr-2"></i>Cancelar</a>
                {{ Form::button('<i class="fa fa-btn fa-save pr-2"></i> Crear almacén', ['type' => 'submit', 'class' => 'btn btn-primary']) }}
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
@stop
