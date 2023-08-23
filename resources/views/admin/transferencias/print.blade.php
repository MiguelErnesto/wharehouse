@extends('layouts.print')
@section('content')
    <table cellpadding="0" cellspacing="0">
        <tr class="top">
            <td colspan="6">
                <table>
                    <tr>
                        <td colspan="4">
                            <strong>DETALLES DEL VALE</strong>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <strong>No. Vale:</strong> {{ $detalles[0]->nro_vale }}<br />
                            <strong>Tipo de vale:</strong>
                            {{ $detalles[0]->tipo_vale == 'E' ? 'Entrega' : 'Devolución' }}<br /><br />

                            <strong>Entidad:</strong> {{ $detalles[0]->entidad }}<br />
                            <strong>Almacén:</strong> {{ $detalles[0]->almacen }}<br />
                            <strong>Persona emisor:</strong> {{ $detalles[0]->persona_emisor }}<br />
                            <strong>Persona receptor:</strong> {{ $detalles[0]->persona_receptor }}<br /><br />

                            <strong>Fecha:</strong>
                            {{ $detalles[0]->updated_at > $detalles[0]->created_at ? $detalles[0]->updated_at : $detalles[0]->created_at }}<br />
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
