@extends('adminlte::page')

@section('title', config('app.name'))

@section('content_header')
    <span class="text-uppercase page-subtitle">Listado de <h1 class='pl-3'>Roles</h1></span>
@stop

@section('content')
    @if (session('info'))
        <div class="alert alert-success" role="alert">
            <strong>{{ session('info') }}</strong>
        </div>
    @endif
    <div class="card">
        <div class="card-header">
            {{-- <a href="{{ route('admin.roles.create') }}" class="btn btn-secondary">Create new Role</a> --}}
            <a href="{{ route('admin.roles.create') }}" class="btn btn-info" title="Crear Nuevo"><i
                    class="fas fa-solid fa-file pr-3"></i>Nuevo</a>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Role</th>
                        <th colspan="2" class="text-center"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $role)
                        <tr>
                            <td>{{ $role->id }}</td>
                            <td>{{ $role->name }}</td>
                            <td width="10px">
                                {{-- <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-sm btn-primary">Edit</a> --}}
                                <a class="btn btn-primary btn-sm" href="{{ route('admin.roles.edit', $role) }}"
                                    title="Editar">
                                    <i class="fas fa-solid fa-pen"></i></a>
                            </td>
                            <td width="10px">
                                <form action="{{ route('admin.roles.destroy', $role) }}" method="POST">
                                    @csrf
                                    @method('delete')
                                    {{-- <button type="submit" class="btn btn-sm btn-danger">Delete</button> --}}
                                    <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                                        <i class="fas fa-solid fa-trash fa-lg"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
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
