@extends('layouts.print')
@section('content')
    <table cellpadding="0" cellspacing="0">
        <tr class="top">
            <td colspan="6">
                <table>
                    <tr>
                        <td colspan="4" style="text-align: center">
                            <strong>DETALLES DE LA FACTURA</strong>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <strong>No. Factura:</strong> {{ $detalles[0]->nro_factura }}<br />
                            <strong>Entidad:</strong> {{ $detalles[0]->entidad }}<br />
                            <strong>Fecha del modelo:</strong> {{ $detalles[0]->fecha_modelo }}<br />

                            <br />

                            <strong>Datos del Registro:</strong> {{ $detalles[0]->datos_registro }}<br />
                            <strong>Operaciones:</strong> {{ $detalles[0]->operaciones }}<br />
                            <strong>Moneda del pago:</strong> {{ $detalles[0]->moneda_pago }}<br />
                            <strong>Porciento:</strong> {{ $detalles[0]->porciento }}<br />

                            <br />

                            <strong>Trasnportista:</strong> {{ $detalles[0]->transportista }}<br />
                            <strong>Transportador:</strong> {{ $detalles[0]->persona_transportador }}<br />
                            <strong>Fecha que recepciona:</strong> {{ $detalles[0]->fecha_recepcion_transportador }}<br />

                            <br />

                            <strong>Entrega:</strong> {{ $detalles[0]->persona_entrega }}<br />
                            <strong>Fecha de entrega:</strong> {{ $detalles[0]->fecha_entrega }}<br />

                            <br />

                            <strong>Recibe:</strong> {{ $detalles[0]->persona_recibe }}<br />
                            <strong>Fecha en que recibe:</strong> {{ $detalles[0]->fecha_recepcion }}<br />

                            <br />
                            <strong>Contabiliza:</strong> {{ $detalles[0]->persona_contabiliza }}<br />
                            <strong>Creado/Actualizado:</strong> {{ $detalles[0]->usuario }}<br />
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: left" colspan="2">
                            <strong>Importe total:</strong> ${{ $detalles[0]->importe_total }}
                            <br />
                        </td>
                        <td></td>
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
            <td style="text-align: right; width: 15%;">{{ __('Cantidad') }}</td>
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
