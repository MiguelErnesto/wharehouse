@extends('layouts.print')
@section('content')
    <table cellpadding="0" cellspacing="0">
        <tr class="top">
            <td colspan="6">
                <table>
                    <tr>
                        <td colspan="4">
                            <strong>LISTADO DE PRODUCTOS</strong>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <strong>Almacén:</strong> {{ $almacen->nombre }}<br />
                            <strong>Dirección:</strong> {{ $almacen->direccion }}<br />
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: right" colspan="4">
                            <strong>Fecha actual:</strong> {{ now() }}
                            <br />
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr class="heading">
            <td style="text-align: left">{{ __('Código') }}</td>
            <td style="text-align: left">{{ __('Producto') }}</td>
            <td style="text-align: left">{{ __('Descripción') }}</td>
            <td style="text-align: right">{{ __('Cantidad') }}</td>
        </tr>
        @foreach ($productos as $producto)
            <tr class="item">
                <td style="text-align: left">{{ $producto->pCodigo }}</td>
                <td style="text-align: left">{{ $producto->pNombre }}</td>
                <td style="text-align: left">{{ $producto->pDescripcion }}</td>
                <td style="text-align: right">{{ $producto->apCantidad }}</td>
            </tr>
        @endforeach
    </table>
@endsection
@section('page-js')
    <script>
        document.addEventListener('DOMContentLoaded', function(event) {
            window.print();
        });
    </script>
@endsection
