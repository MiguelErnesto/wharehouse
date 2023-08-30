@extends('adminlte::page')

@section('title', config('app.name'))

@section('content_header')
    <h1>Asignar roles</h1>
@stop

@section('content')
    @if (session('info'))
        <div class="alert alert-success">
            <strong>{{ session('info') }}</strong>
        </div>
    @endif
    <div class="card">
        <div class="card-body">
            {{-- <p class="h5">Nombre: </p> --}}
            <p class="form-control" style="background-color:rgb(235, 228, 228);">{{ $user->name }}</p>
            <h2 class="h5">Roles</h2>
            {!! Form::model($user, ['route' => ['admin.users.updateRoles', $user], 'method' => 'PUT']) !!}
            @foreach ($roles as $role)
                <div>
                    <label class='pl-5'>
                        {!! Form::checkbox('roles[]', $role->id, null, ['class' => 'mr-1']) !!}
                        {{ $role->name }}
                    </label>
                </div>
            @endforeach
            <div class='text-right'>
                <a class="btn btn-danger" href="{{ route('admin.users.index') }}"><i
                        class="fa fa-btn fa-ban pr-2"></i>Cancelar</a>
                {{ Form::button('<i class="fa fa-btn fa-save pr-2"></i> Guardar', ['type' => 'submit', 'class' => 'btn btn-primary']) }}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        console.log('Hi!');
    </script>
    <script async type="module" src="{{ mix('/js/compiled/usuarios.js') }}"></script>
@stop
