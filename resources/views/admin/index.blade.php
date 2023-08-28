@extends('adminlte::page')

@section('title', config('app.name'))

@section('content_header')
    <h1>Módulos del Sistema</h1>
@stop

@section('content')
    <div class="row">
        {{-- Entidades --}}
        @can('Listar entidades')
            <div class="col-lg-2 col-9">
                <div class="small-box bg-primary">
                    <div class="inner text-center">
                        <i class="fas fa-landmark fa-2x">
                            <strong class='pl-4'>{{ $entidades }}</strong>
                        </i>

                    </div>
                    <a href="{{ route('entidades.index') }}" class="small-box-footer">
                        <div class='input-group'>
                            <div class='text-center ml-3 mt-3 mb-2'> {{ __('Entidades') }}</div>
                            <div><i class="fas fa-arrow-circle-right ml-3 mt-3 mb-3"></i></div>
                        </div>
                    </a>
                </div>
            </div>
        @endcan

        {{-- Clientes --}}
        @can('Listar clientes')
            <div class="col-lg-2 col-9">
                <div class="small-box bg-success">
                    <div class="inner text-center">
                        <i class="fas fa-users fa-2x">
                            <strong class='pl-4'>{{ $clientes }}</strong>
                        </i>
                    </div>
                    <a href="{{ route('clientes.index') }}" class="small-box-footer">
                        <div class='input-group'>
                            <div class='text-center ml-3 mt-3 mb-2'>{{ __('Clientes') }}</div>
                            <div><i class="fas fa-arrow-circle-right ml-4 mt-3 mb-3"></i></div>
                        </div>
                    </a>
                </div>
            </div>
        @endcan

        {{-- Almacenes --}}
        @can('Listar almacenes')
            <div class="col-lg-2 col-9">
                <div class="small-box bg-danger">
                    <div class="inner text-center">
                        <i class="fas fa-warehouse fa-2x">
                            <strong class='pl-4'>{{ $clientes }}</strong>
                        </i>
                    </div>
                    <a href="{{ route('almacenes.index') }}" class="small-box-footer">
                        <div class='input-group'>
                            <div class='text-center ml-3 mt-3 mb-2'>{{ __('Almacenes') }}</div>
                            <div><i class="fas fa-arrow-circle-right ml-3 mt-3 mb-3"></i></div>
                        </div>
                    </a>
                </div>
            </div>
        @endcan

        {{-- Productos --}}
        @can('Listar productos')
            <div class="col-lg-2 col-9">
                <div class="small-box bg-warning">
                    <div class="inner text-center">
                        <i class="fas fa-boxes fa-2x">
                            <strong class='pl-4'>{{ $productos }}</strong>
                        </i>
                    </div>
                    <a href="{{ route('productos.index') }}" class="small-box-footer">
                        <div class='input-group'>
                            <div class='text-center ml-3 mt-3 mb-2'>{{ __('Productos') }}</div>
                            <div><i class="fas fa-arrow-circle-right ml-3 mt-3 mb-3"></i></div>
                        </div>
                    </a>
                </div>
            </div>
        @endcan

        {{-- Informes de Recepción --}}
        @can('Listar informes recepcion')
            <div class="col-lg-2 col-9">
                <div class="small-box bg-black">
                    <div class="inner text-center">
                        <i class="fas fa-list fa-2x">
                            <strong class='pl-4'>{{ $informes_recepcion }}</strong>
                        </i>
                    </div>
                    <a href="{{ route('informes_recepcion.index') }}" class="small-box-footer">
                        <div class='input-group'>
                            <div class='text-center ml-2'>Informes de <br /> Recepción</div>
                            <div><i class="fas fa-arrow-circle-right ml-3 mt-3"></i></div>
                        </div>
                    </a>
                </div>
            </div>
        @endcan
    </div>


    <div class="row">
        {{-- Órdenes de despacho --}}
        @can('Listar ordenes despacho')
            <div class="col-lg-2 col-9">
                <div class="small-box bg-light">
                    <div class="inner text-center">
                        <i class="fas fa-list fa-2x">
                            <strong class='pl-4'>{{ $ordenes_despacho }}</strong>
                        </i>
                    </div>
                    <a href="{{ route('ordenes_despacho.index') }}" class="small-box-footer">
                        <div class='input-group'>
                            <div class='text-center ml-2'>Órdenes de <br /> Despacho</div>
                            <div><i class="fas fa-arrow-circle-right ml-3 mt-3"></i></div>
                        </div>
                    </a>
                </div>
            </div>
        @endcan

        {{-- Vales --}}
        @can('Listar vales')
            <div class="col-lg-2 col-9">
                <div class="small-box bg-warning">
                    <div class="inner text-center">
                        <i class="fas fa-list fa-2x">
                            <strong class='pl-4'>{{ $productos }}</strong>
                        </i>
                    </div>
                    <a href="{{ route('vales.index') }}" class="small-box-footer">
                        <div class='input-group'>
                            <div class='text-center ml-3 mt-3 mb-2'>{{ __('Vales') }}</div>
                            <div><i class="fas fa-arrow-circle-right ml-5 mt-3 mb-3"></i></div>
                        </div>
                    </a>
                </div>
            </div>
        @endcan

        {{-- Transferencias --}}
        @can('Listar transferencias')
            <div class="col-lg-2 col-9">
                <div class="small-box bg-secondary">
                    <div class="inner text-center">
                        <i class="fas fa-list fa-2x">
                            <strong class='pl-4'>{{ $transferencias }}</strong>
                        </i>
                    </div>
                    <a href="{{ route('transferencias.index') }}" class="small-box-footer">
                        <div class='input-group'>
                            <div class='text-center ml-1 mt-3 mb-2'>{{ __('Transferencias') }}</div>
                            <div><i class="fas fa-arrow-circle-right ml-1 mt-3 mb-3"></i></div>
                        </div>
                    </a>
                </div>
            </div>
        @endcan

        {{-- Conduces --}}
        @can('Listar conduces')
            <div class="col-lg-2 col-9">
                <div class="small-box bg-info">
                    <div class="inner text-center">
                        <i class="fas fa-list fa-2x">
                            <strong class='pl-4'>{{ $conduces }}</strong>
                        </i>
                    </div>
                    <a href="{{ route('conduces.index') }}" class="small-box-footer">
                        <div class='input-group'>
                            <div class='text-center ml-4 mt-3 mb-2'>{{ __('Conduces') }}</div>
                            <div><i class="fas fa-arrow-circle-right ml-4 mt-3 mb-3"></i></div>
                        </div>
                    </a>
                </div>
            </div>
        @endcan

        {{-- Facturas --}}
        @can('Listar facturas')
            <div class="col-lg-2 col-9">
                <div class="small-box bg-primary">
                    <div class="inner text-center">
                        <i class="fas fa-list fa-2x">
                            <strong class='pl-4'>{{ $facturas }}</strong>
                        </i>
                    </div>
                    <a href="{{ route('facturas.index') }}" class="small-box-footer">
                        <div class='input-group'>
                            <div class='text-center ml-4 mt-3 mb-2'>{{ __('Facturas') }}</div>
                            <div><i class="fas fa-arrow-circle-right ml-4 mt-3 mb-3"></i></div>
                        </div>
                    </a>
                </div>
            </div>
        @endcan
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
