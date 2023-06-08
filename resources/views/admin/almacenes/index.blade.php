@extends('adminlte::page')

@section('title', config('app.name'))

@section('content_header')
    <h1>Almacenes</h1>
@stop

@section('content')
    @if (session('info'))
        <div class="alert alert-success" role="alert">
            <strong>{{ session('info') }}</strong>
        </div>
    @endif

    <div class="card">
        @can('admin.almacenes.create')
            <div class="card-header">
                <a href="{{ route('almacenes.create') }}" class="btn btn-secondary">Create new Category</a>
            </div>
        @endcan
        <div class="card-body">
            <table class="table table-striped">
                <thead class="thead-inverse">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th colspan="2"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($almacenes as $almacen)
                        <tr>
                            <td scope="row">{{ $almacen->id }}</td>
                            <td>{{ $almacen->nombre }}</td>
                            <td width="10px">
                                @can('admin.almacenes.edit')
                                    <a class="btn btn-primary btn-sm" href="{{ route('almacenes.edit', $almacen) }}">Edit</a>
                                @endcan
                            </td>
                            <td width="10px">
                                @can('admin.almacenes.destroy')
                                    <form action="{{ route('almacenes.destroy', $almacen) }}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@stop
