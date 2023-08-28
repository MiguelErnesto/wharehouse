@extends('layouts.print')
@section('content')
    <table cellpadding="0" cellspacing="0">
        <tr class="top">
            <td colspan="6">
                <table>
                    <tr>
                        <td colspan="4" style="text-align: center">
                            <strong>DETALLES DE LA ORDEN DE DESPACHO DE PRODUCTOS</strong>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <strong>No. Orden:</strong> {{ $detalles[0]->nro_orden }}<br />
                            <strong>Fecha del modelo:</strong> {{ $detalles[0]->fecha }}<br />

                            @foreach ($vales as $vale)
                                @if ($detalles[0]->vale_id == $vale->id)
                                    <strong>Salida por vale:</strong>{{ $vale->nro_vale }} <br />
                                @endif
                            @endforeach

                            @foreach ($transferencias as $transferencia)
                                @if ($detalles[0]->transferencia_id == $transferencia->id)
                                    <strong>Salida por transferencia:</strong> {{ $transferencia->nro_transferencia }}
                                    <br />
                                @endif
                            @endforeach

                            <br />
                            <strong>Entidad:</strong> {{ $detalles[0]->entidad }}<br />
                            <strong>Almacén:</strong> {{ $detalles[0]->almacen }}<br />
                            <strong>Cliente:</strong> {{ $detalles[0]->cliente }}<br />

                            <br />

                            <strong>Lugar de entrega:</strong> {{ $detalles[0]->lugar_entrega }}<br />
                            <strong>Fecha de entrega:</strong> {{ $detalles[0]->fecha_entrega }}<br />

                            <br />
                            <strong>Creado/Actualizado:</strong> {{ $detalles[0]->usuario }}<br />

                            <br />

                            <strong>Productos del despacho:</strong> <br />

                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr class="heading">
            <td style="text-align: left;  width: 12%;">{{ __('Código') }}</td>
            <td style="text-align: left; width: 20%;">{{ __('Producto') }}</td>
            <td style="text-align: left;  width: 37%;">{{ __('Descripción') }}</td>
            <td style="text-align: right; width: 12%;">{{ __('Cantidad ordenada') }}</td>
            <td style="text-align: right; width: 12%;">{{ __('Cantidad despachada') }}</td>
            <td style="text-align: right; width: 12%;">{{ __('Cantidad entregada') }}</td>
        </tr>
        @foreach ($productos as $producto)
            <tr class="item">
                <td style="text-align: left">{{ $producto->codigo }}</td>
                <td style="text-align: left">{{ $producto->nombre }}</td>
                <td style="text-align: left">{{ $producto->descripcion }}</td>
                <td style="text-align: right">{{ $producto->cantidad_ordenada }}</td>
                <td style="text-align: right">{{ $producto->cantidad_despachada }}</td>
                <td style="text-align: right">{{ $producto->cantidad_entregada }}</td>
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
