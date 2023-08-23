@extends('layouts.print')
@section('content')
    <table cellpadding="0" cellspacing="0">
        <tr class="top">
            <td colspan="6">
                <table>
                    <tr>
                        <td colspan="4" style="text-align: center">
                            <strong>DETALLES DE LA TRANSFERENCIA</strong>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <strong>No. Transferencia:</strong> {{ $detalles[0]->nro_transferencia }}<br />
                            <strong>Entidad:</strong> {{ $detalles[0]->entidad }}<br />
                            <strong>Fecha del modelo:</strong> {{ $detalles[0]->fecha_modelo }}<br />

                            <br />

                            @foreach ($almacenes as $almacen)
                                @if ($detalles[0]->almacen_origen_id == $almacen->id)
                                    <strong>Almacén origen:</strong> {{ $almacen->nombre }}<br />
                                @endif
                            @endforeach
                            <strong>Actualiza:</strong> {{ $detalles[0]->persona_actualiza_origen }}<br />
                            <strong>Contabiliza:</strong> {{ $detalles[0]->persona_contabiliza_origen }}<br />

                            <br />

                            @foreach ($almacenes as $almacen)
                                @if ($detalles[0]->almacen_destino_id == $almacen->id)
                                    <strong>Almacén destino:</strong> {{ $almacen->nombre }}<br />
                                @endif
                            @endforeach
                            <strong>Actualiza:</strong> {{ $detalles[0]->persona_actualiza_destino }}<br />
                            <strong>Contabiliza:</strong> {{ $detalles[0]->persona_contabiliza_destino }}<br />

                            <br />

                            <strong>Autoriza:</strong> {{ $detalles[0]->persona_autoriza }}<br />
                            <strong>Entrega:</strong> {{ $detalles[0]->persona_entrega }}<br />
                            <strong>Recibe:</strong> {{ $detalles[0]->persona_recibe }}<br />

                            <br />


                            <strong>Fecha de traslado:</strong>
                            {{ $detalles[0]->fecha_traslado }}<br />
                            <strong>Fecha de recepción:</strong>
                            {{ $detalles[0]->fecha_recepcion }}<br />
                            <strong>Creado/Actualizado:</strong> {{ $detalles[0]->usuario }}<br />
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: left" colspan="2">
                            <strong>Importe total de la entrega:</strong> ${{ $detalles[0]->importe_total_entrega }}
                            <br />
                        </td>
                        <td style="text-align: left" colspan="2">
                            <strong>Importe total recibido:</strong> ${{ $detalles[0]->importe_total_recibido }}
                            <br />
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
            <td style="text-align: right; width: 15%;">{{ __('Cantidad remitida') }}</td>
            <td style="text-align: right; width: 15%;">{{ __('Cantidad recibida') }}</td>
        </tr>
        @foreach ($productos as $producto)
            <tr class="item">
                <td style="text-align: left">{{ $producto->codigo }}</td>
                <td style="text-align: left">{{ $producto->nombre }}</td>
                <td style="text-align: left">{{ $producto->descripcion }}</td>
                <td style="text-align: right">{{ $producto->cantidad_remitida }}</td>
                <td style="text-align: right">{{ $producto->cantidad_recibida }}</td>
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
