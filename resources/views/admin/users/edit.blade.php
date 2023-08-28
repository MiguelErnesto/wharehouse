@extends('adminlte::page')

@section('title', config('app.name'))

@section('content_header')
    <h1>Editar Usuario</h1>
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
            <p class="form-control">{{ $user->name }}</p>
            <h2 class="h5">Roles</h2>
            {!! Form::model($user, ['route' => ['admin.users.update', $user], 'method' => 'PUT']) !!}
            @foreach ($roles as $role)
                <div>
                    <label class='pl-5'>
                        {!! Form::checkbox('roles[]', $role->id, null, ['class' => 'mr-1']) !!}
                        {{ $role->name }}
                    </label>
                </div>
            @endforeach
            {!! Form::submit('Guardar', ['class' => 'btn btn-primary mt-2']) !!}
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
@stop
