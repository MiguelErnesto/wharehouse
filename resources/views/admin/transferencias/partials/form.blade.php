<input id="user_id" type="hidden" value="{{ Auth::user()->id }}" />

<div class="row">
    <div class="col-3">
        <div class="form-group">
            {!! Form::label('nro_transferencia', 'No. Transferencia:', [
                'class' => 'pl-1',
            ]) !!}
            {!! Form::text('nro_transferencia', null, [
                'class' => 'form-control',
                'placeholder' => 'No. Transferencia',
            ]) !!}
            @error('nro_transferencia')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-3">
        <div class="form-group">
            {!! Form::label('fecha_modelo', 'Fecha del modelo:', [
                'class' => 'pl-1',
            ]) !!}
            {!! Form::date('fecha_modelo', now(), [
                'class' => 'form-control',
                'placeholder' => 'Fecha',
            ]) !!}
            @error('fecha_modelo')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-3">
        <div class="form-group">
            {!! Form::label('fecha_traslado', 'Fecha del traslado:', [
                'class' => 'pl-1',
            ]) !!}
            {!! Form::date('fecha_traslado', now(), [
                'class' => 'form-control',
                'placeholder' => 'Fecha',
            ]) !!}
            @error('fecha_traslado')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-3">
        <div class="form-group">
            {!! Form::label('fecha_recepcion', 'Fecha de la recepción:', [
                'class' => 'pl-1',
            ]) !!}
            {!! Form::date('fecha_recepcion', now(), [
                'class' => 'form-control',
                'placeholder' => 'Fecha',
            ]) !!}
            @error('fecha_recepcion')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

</div>

<div class="row">
    <div class="col-4">
        <div class="form-group">
            {!! Form::label('entidad', 'Entidad:', [
                'class' => 'pl-1',
            ]) !!}
            {!! Form::select('entidad', $entidades, null, [
                'class' => 'form-control',
                'placeholder' => 'Seleccione la entidad...',
            ]) !!}
            @error('entidad')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-4">
        <div class="form-group">
            {!! Form::label('almacen_origen', 'Almacén origen:', [
                'class' => 'pl-1',
            ]) !!}
            {!! Form::select('almacen_origen', $almacenes, null, [
                'class' => 'form-control',
                'placeholder' => 'Seleccione el almacén origen...',
            ]) !!}
            @error('almacen_origen')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-4">
        <div class="form-group">
            {!! Form::label('almacen_destino', 'Almacén destino:', [
                'class' => 'pl-1',
            ]) !!}
            {!! Form::select('almacen_destino', $almacenes, null, [
                'class' => 'form-control',
                'placeholder' => 'Seleccione el almacén destino...',
            ]) !!}
            @error('almacen_destino')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

</div>

<br />

{!! Form::label('', 'En el origen:', [
    'class' => 'pl-1',
]) !!}

<br />

<div class="row">
    <div class="col-2 pl-5">
        {!! Form::label('persona_actualiza_origen', 'Actualiza:', [
            'class' => 'pl-1 pt-2',
        ]) !!}
    </div>

    <div class="col-9">
        <div class="form-group">
            {!! Form::text('persona_actualiza_origen', null, [
                'class' => 'form-control',
                'placeholder' => 'Persona que actualiza',
            ]) !!}
            @error('persona_actualiza_origen')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

</div>

<div class="row">
    <div class="col-2 pl-5">
        {!! Form::label('persona_contabiliza_origen', 'Contabiliza:', [
            'class' => 'pl-1 pt-2',
        ]) !!}
    </div>

    <div class="col-9">
        <div class="form-group">
            {!! Form::text('persona_contabiliza_origen', null, [
                'class' => 'form-control',
                'placeholder' => 'Persona que contabiliza',
            ]) !!}
            @error('persona_contabiliza_origen')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>


<br />


{!! Form::label('', 'En el destino:', [
    'class' => 'pl-1',
]) !!}

<br />

<div class="row">
    <div class="col-2 pl-5">
        {!! Form::label('persona_actualiza_destino', 'Actualiza:', [
            'class' => 'pl-1 pt-2',
        ]) !!}
    </div>

    <div class="col-9">
        <div class="form-group">
            {!! Form::text('persona_actualiza_destino', null, [
                'class' => 'form-control',
                'placeholder' => 'Persona que actualiza',
            ]) !!}
            @error('persona_actualiza_destino')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-2 pl-5">
        {!! Form::label('persona_contabiliza_destino', 'Contabiliza:', [
            'class' => 'pl-1 pt-2',
        ]) !!}
    </div>

    <div class="col-9">
        <div class="form-group">
            {!! Form::text('persona_contabiliza_destino', null, [
                'class' => 'form-control',
                'placeholder' => 'Persona que contabiliza',
            ]) !!}
            @error('persona_contabiliza_destino')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<br />

<div class="row">
    <div class="col-3">
        {!! Form::label('persona_autoriza', 'Persona que autoriza:', [
            'class' => 'pl-1 pt-3',
        ]) !!}
    </div>

    <div class="col-9">
        <div class="form-group">
            {!! Form::text('persona_autoriza', null, [
                'class' => 'form-control',
                'placeholder' => 'Persona que autoriza',
            ]) !!}
            @error('persona_autoriza')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-3">
        {!! Form::label('persona_entrega', 'Persona que entrega:', [
            'class' => 'pl-1 pt-3',
        ]) !!}
    </div>

    <div class="col-9">
        <div class="form-group">
            {!! Form::text('persona_entrega', null, [
                'class' => 'form-control',
                'placeholder' => 'Persona que entrega',
            ]) !!}
            @error('persona_entrega')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-3">
        {!! Form::label('persona_recibe', 'Persona que recibe:', [
            'class' => 'pl-1 pt-3',
        ]) !!}
    </div>

    <div class="col-9">
        <div class="form-group">
            {!! Form::text('persona_recibe', null, [
                'class' => 'form-control',
                'placeholder' => 'Persona que recibe',
            ]) !!}
            @error('persona_recibe')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<br />

<div class="row">
    <div class="col-5">
        <div class="form-group pl-5 pr-5">
            {!! Form::label('importe_total_entrega', 'Importe total de la entrega:', [
                'class' => 'pl-1',
            ]) !!}
            {!! Form::text('importe_total_entrega', null, [
                'class' => 'form-control',
                'placeholder' => 'Importe total de la entrega',
            ]) !!}
            @error('importe_total_entrega')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-5">
        <div class="form-group pl-5">
            {!! Form::label('importe_total_recibido', 'Importe total recibido:', [
                'class' => 'pl-1',
            ]) !!}
            {!! Form::text('importe_total_recibido', null, [
                'class' => 'form-control',
                'placeholder' => 'Importe total recibido',
            ]) !!}
            @error('importe_total_recibido')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

</div>

<br />
<hr />

<div id='divProductos' class="row">
    <div class="col-5">
        <div class="form-group">
            {!! Form::label('producto', 'Productos de la transferencia:', [
                'class' => 'pl-1',
            ]) !!}
            {!! Form::select('producto', $productos, null, [
                'class' => 'form-control',
                'placeholder' => 'Seleccione producto...',
            ]) !!}
            @error('producto')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-3">
        <div class="form-group pl-5">
            {!! Form::label('cantidad_recibida', 'Cantidad recibida:', [
                'class' => 'pl-1',
            ]) !!}
            {!! Form::number('cantidad_recibida', '1', ['min' => '1', 'class' => 'text-right form-control']) !!}
            @error('cantidad_recibida')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-3">
        <div class="form-group pl-5">
            {!! Form::label('cantidad_remitida', 'Cantidad remitida:', [
                'class' => 'pl-1',
            ]) !!}
            {!! Form::number('cantidad_remitida', '1', ['min' => '1', 'class' => 'text-right form-control']) !!}
            @error('cantidad_remitida')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-1">
        <div class="form-group">
            {!! Form::label('label', 'Agregar', ['class' => 'text-white']) !!}
            {{ Form::button('+', ['class' => 'btn btn-info', 'id' => 'add']) }}
        </div>
    </div>
</div>

<br />

<div class="table-responsive pl-4">
    <table id="listaProductos" class="table table-striped w-85">
        <thead>
            <tr class="paginationLinks">
            <tr>
        </thead>
        <thead>

        </thead>
        <tbody>
        </tbody>
        <tfoot>
            <tr class="paginationLinks">
            </tr>
        </tfoot>
    </table>
</div>
