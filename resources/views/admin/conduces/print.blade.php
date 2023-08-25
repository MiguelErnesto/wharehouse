@extends('layouts.print')
@section('content')
    <table cellpadding="0" cellspacing="0">
        <tr class="top">
            <td colspan="6">
                <table>
                    <tr>
                        <td colspan="4">
                            <strong>DETALLES DEL CONDUCE</strong>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <strong>No. Conduce:</strong> {{ $detalles[0]->nro_conduce }}<br />
                            <strong>Entidad:</strong> {{ $detalles[0]->entidad }}<br />
                            <strong>Fecha:</strong>{{ $detalles[0]->fecha_modelo }}<br />
                            <strong>Factura asociada:</strong> {{ $detalles[0]->nro_factura }}<br />
                            <br />
                            <strong>Comprador:</strong> {{ $detalles[0]->comprador }}<br />
                            <strong>Lugar de entrega:</strong> {{ $detalles[0]->lugar_entrega }}<br />
                            <br />
                            <strong>Transportador:</strong> {{ $detalles[0]->transportador }}<br />
                            <strong>Fecha que recibe:</strong> {{ $detalles[0]->fecha_recepcion_transportador }}<br />
                            <br />
                            <strong>Entrega:</strong> {{ $detalles[0]->persona_entrega }}<br />
                            <strong>Fecha que entrega:</strong> {{ $detalles[0]->fecha_entrega }}<br />
                            <br />
                            <strong>Recibe:</strong> {{ $detalles[0]->persona_recepcion }}<br />
                            <strong>Fecha que recibe:</strong> {{ $detalles[0]->fecha_recepcion }}<br />
                            <br />
                            <strong>Actualiza:</strong> {{ $detalles[0]->persona_actualiza }}<br />
                            <strong>Contabiliza:</strong> {{ $detalles[0]->persona_contabiliza }}<br />
                            <strong>Creado/Actualizado:</strong> {{ $detalles[0]->usuario }}<br />
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
