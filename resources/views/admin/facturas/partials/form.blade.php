<input id="user_id" type="hidden" value="{{ Auth::user()->id }}" />

<div class="row">
    <div class="col-2">
        <div class="form-group">
            {!! Form::label('fecha_modelo', 'Fecha modelo:', [
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

    <div class="col-2">
        <div class="form-group">
            {!! Form::label('nro_factura', 'No. Factura:', [
                'class' => 'pl-1',
            ]) !!}
            {!! Form::text('nro_factura', null, [
                'class' => 'form-control',
                'placeholder' => 'No. Factura',
            ]) !!}
            @error('nro_factura')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

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

    <div class="col-2">
        <div class="form-group">
            {!! Form::label('moneda_pago', 'Moneda pago:', [
                'class' => 'pl-1',
            ]) !!}
            {!! Form::text('moneda_pago', null, [
                'class' => 'form-control',
                'placeholder' => 'Moneda del pago',
            ]) !!}
            @error('moneda_pago')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-2">
        <div class="form-group">
            {!! Form::label('porciento', 'Porciento:', [
                'class' => 'pl-1',
            ]) !!}
            {!! Form::text('porciento', null, [
                'class' => 'form-control',
                'placeholder' => 'Porciento',
            ]) !!}
            @error('porciento')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-2 pt-2">
        <div class="form-group">
            {!! Form::label('datos_registro', 'Datos registro:', [
                'class' => 'pl-1',
            ]) !!}
        </div>
    </div>

    <div class="col-10">
        <div class="form-group">
            {!! Form::text('datos_registro', null, [
                'class' => 'form-control',
                'placeholder' =>
                    'Nombre, dirección, código REEUP, número de cuenta, sucursal bancaria, NIT, número de inscripción...',
            ]) !!}
            @error('datos_registro')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-2 pt-2">
        <div class="form-group">
            {!! Form::label('operaciones', 'Operaciones:', [
                'class' => 'pl-1',
            ]) !!}
        </div>
    </div>

    <div class="col-10">
        <div class="form-group">
            {!! Form::text('operaciones', null, [
                'class' => 'form-control',
                'placeholder' => 'Especificar concepto de las operaciones por la que se remite...',
            ]) !!}
            @error('operaciones')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<br />



<div class="row">
    <div class="col-2">
        {!! Form::label('transportista', 'Transportista:', [
            'class' => 'pl-1 pt-2',
        ]) !!}
    </div>

    <div class="col-10">
        <div class="form-group">
            {!! Form::text('transportista', null, [
                'class' => 'form-control',
                'placeholder' => 'Datos del transportista',
            ]) !!}
            @error('transportista')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-2">
        {!! Form::label('persona_transportador', 'Transportador:', [
            'class' => 'pl-1 pt-2',
        ]) !!}
    </div>

    <div class="col-6">
        <div class="form-group">
            {!! Form::text('persona_transportador', null, [
                'class' => 'form-control',
                'placeholder' => 'Datos del transportador',
            ]) !!}
            @error('persona_transportador')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-2">
        {!! Form::label('fecha_recepcion_transportador', 'Fecha recibe:', [
            'class' => 'pl-1 pt-2',
        ]) !!}
    </div>

    <div class="col-2">
        <div class="form-group">
            {!! Form::date('fecha_recepcion_transportador', now(), [
                'class' => 'form-control',
                'placeholder' => 'Fecha',
            ]) !!}
            @error('fecha_recepcion_transportador')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-2">
        {!! Form::label('persona_entrega', 'Entrega:', [
            'class' => 'pl-1 pt-2',
        ]) !!}
    </div>

    <div class="col-6">
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

    <div class="col-2">
        {!! Form::label('fecha_entrega', 'Fecha entrega:', [
            'class' => 'pl-1 pt-2',
        ]) !!}
    </div>

    <div class="col-2">
        <div class="form-group">
            {!! Form::date('fecha_entrega', now(), [
                'class' => 'form-control',
                'placeholder' => 'Fecha',
            ]) !!}
            @error('fecha_entrega')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-2">
        {!! Form::label('persona_recibe', 'Recibe:', [
            'class' => 'pl-1 pt-2',
        ]) !!}
    </div>

    <div class="col-6">
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

    <div class="col-2">
        {!! Form::label('fecha_recepcion', 'Fecha recibe:', [
            'class' => 'pl-1 pt-2',
        ]) !!}
    </div>

    <div class="col-2">
        <div class="form-group">
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
    <div class="col-2">
        {!! Form::label('persona_contabiliza', 'Contabiliza:', [
            'class' => 'pl-1 pt-2',
        ]) !!}
    </div>

    <div class="col-10">
        <div class="form-group">
            {!! Form::text('persona_contabiliza', null, [
                'class' => 'form-control',
                'placeholder' => 'Persona que contabiliza',
            ]) !!}
            @error('persona_contabiliza')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<br />

<div class="row">
    <div class="col-2">
        {!! Form::label('importe_total', 'Importe total:', [
            'class' => 'pl-1 pt-2',
        ]) !!}
    </div>

    <div class="col-3">
        <div class="form-group">
            {!! Form::text('importe_total', null, [
                'class' => 'form-control',
                'placeholder' => 'Importe total',
            ]) !!}
            @error('importe_total')
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
            {!! Form::label('cantidad', 'Cantidad:', [
                'class' => 'pl-1',
            ]) !!}
            {!! Form::number('cantidad', '1', ['min' => '1', 'class' => 'text-right form-control']) !!}
            @error('cantidad')
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
