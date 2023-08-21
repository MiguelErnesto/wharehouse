@extends('layouts.print')
@section('content')
    <table cellpadding="0" cellspacing="0">
        <tr class="top">
            <td colspan="6">
                <table>
                    <tr>
                        <td colspan="4">
                            <strong>INFORME DE RECEPCIÓN</strong>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <strong>No. de Informe:</strong> {{ $informe[0]->nro_informe }}<br />
                            <strong>Almacén:</strong> {{ $informe[0]->almacen }}<br />
                            <strong>Fecha:</strong> {{ $informe[0]->fecha }}<br />
                            <strong>Creado/Actualizado:</strong> {{ $informe[0]->usuario }}<br />
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
                <td style="text-align: left">{{ $producto->codigo }}</td>
                <td style="text-align: left">{{ $producto->nombre }}</td>
                <td style="text-align: left">{{ $producto->descripcion }}</td>
                <td style="text-align: right">{{ $producto->cantidad }}</td>
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
