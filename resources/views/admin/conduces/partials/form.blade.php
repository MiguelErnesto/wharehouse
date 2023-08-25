<input id="user_id" type="hidden" value="{{ Auth::user()->id }}" />

<div class="row">
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
            {!! Form::label('nro_conduce', 'No. Conduce:', [
                'class' => 'pl-1',
            ]) !!}
            {!! Form::text('nro_conduce', null, [
                'class' => 'form-control',
                'placeholder' => 'No. conduce',
            ]) !!}
            @error('nro_conduce')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-3">
        <div class="form-group">
            {!! Form::label('nro_factura', 'Nro. Factura:', [
                'class' => 'pl-1',
            ]) !!}
            {!! Form::select('nro_factura', $facturas, null, [
                'class' => 'form-control',
                'placeholder' => 'Seleccione la entidad...',
            ]) !!}
            @error('nro_factura')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-3">
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
</div>

<br />

<div class="row">
    <div class="col-3">
        {!! Form::label('comprador', 'Comprador:', [
            'class' => 'pl-1 pt-2',
        ]) !!}
    </div>

    <div class="col-9">
        <div class="form-group">
            {!! Form::text('comprador', null, [
                'class' => 'form-control',
                'placeholder' => 'Comprador',
            ]) !!}
            @error('comprador')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

</div>

<div class="row">
    <div class="col-3">
        {!! Form::label('lugar_entrega', 'Lugar de entrega:', [
            'class' => 'pl-1 pt-2',
        ]) !!}
    </div>

    <div class="col-9">
        <div class="form-group">
            {!! Form::text('lugar_entrega', null, [
                'class' => 'form-control',
                'placeholder' => 'Lugar de entrega',
            ]) !!}
            @error('lugar_entrega')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>


<br />

<div class="row">
    <div class="col-2">
        {!! Form::label('transportador', 'Transportador:', [
            'class' => 'pl-1 pt-2',
        ]) !!}
    </div>

    <div class="col-6">
        <div class="form-group">
            {!! Form::text('transportador', null, [
                'class' => 'form-control',
                'placeholder' => 'Datos del transportador',
            ]) !!}
            @error('transportador')
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
        {!! Form::label('persona_recepcion', 'Recibe:', [
            'class' => 'pl-1 pt-2',
        ]) !!}
    </div>

    <div class="col-6">
        <div class="form-group">
            {!! Form::text('persona_recepcion', null, [
                'class' => 'form-control',
                'placeholder' => 'Persona que recibe',
            ]) !!}
            @error('persona_recepcion')
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

<br />

<div class="row">
    <div class="col-3">
        {!! Form::label('persona_actualiza', 'Persona que actualiza:', [
            'class' => 'pl-1 pt-3',
        ]) !!}
    </div>

    <div class="col-9">
        <div class="form-group">
            {!! Form::text('persona_actualiza', null, [
                'class' => 'form-control',
                'placeholder' => 'Persona que actualiza',
            ]) !!}
            @error('persona_actualiza')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-3">
        {!! Form::label('persona_contabiliza', 'Persona que contabiliza:', [
            'class' => 'pl-1 pt-3',
        ]) !!}
    </div>

    <div class="col-9">
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
<hr />

<div class="row">
    <div class="col-5">
        <div class="form-group">
            {!! Form::label('producto', 'Productos del vale:', [
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
