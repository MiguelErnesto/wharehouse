<input name="user_id" id="user_id" type="hidden" value="{{ Auth::user()->id }}" />

<div class="row">
    <div class="col-2">
        <div class="form-group">
            {!! Form::label('fecha', 'Fecha:', [
                'class' => 'pl-1',
            ]) !!}
            {!! Form::date('fecha', now(), [
                'class' => 'form-control',
                'placeholder' => 'Fecha',
            ]) !!}
            @error('fecha')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-2">
        <div class="form-group">
            {!! Form::label('nro_vale', 'No. Vale:', [
                'class' => 'pl-1',
            ]) !!}
            {!! Form::text('nro_vale', null, [
                'class' => 'form-control',
                'placeholder' => 'Nro. vale',
            ]) !!}
            @error('nro_vale')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-4">
        <div class="form-group">
            {!! Form::label('entidad_id', 'Entidad:', [
                'class' => 'pl-1',
            ]) !!}
            {!! Form::select('entidad_id', $entidades, null, [
                'class' => 'form-control',
                'placeholder' => 'Seleccione la entidad...',
            ]) !!}
            @error('entidad_id')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-4">
        <div class="form-group">
            {!! Form::label('almacen_id', 'Almacén:', [
                'class' => 'pl-1',
            ]) !!}
            {!! Form::select('almacen_id', $almacenes, null, [
                'class' => 'form-control',
                'placeholder' => 'Seleccione el almacén...',
            ]) !!}
            @error('almacen_id')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<br />

<div class="row">
    <div class="col-2">
        <div class="form-group">
            {!! Form::label('importe_total', 'Importe total:', [
                'class' => 'pl-1',
            ]) !!}
            {!! Form::text('importe_total', null, [
                'class' => 'form-control',
                'placeholder' => 'Importe total',
            ]) !!}
            @error('importe_total')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-4">
        <div class="form-group">
            {!! Form::label('persona_emisor', 'Emisor:', [
                'class' => 'pl-1',
            ]) !!}
            {!! Form::text('persona_emisor', null, [
                'class' => 'form-control',
                'placeholder' => 'Persona emisor',
            ]) !!}
            @error('persona_emisor')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-4">
        <div class="form-group">
            {!! Form::label('persona_receptor', 'Receptor:', [
                'class' => 'pl-1',
            ]) !!}
            {!! Form::text('persona_receptor', null, [
                'class' => 'form-control',
                'placeholder' => 'Persona receptor',
            ]) !!}
            @error('persona_receptor')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-2">
        <div class="form-group">
            {!! Form::label('tipo_vale', 'Tipo de vale:', [
                'class' => 'pl-1',
            ]) !!}
            {!! Form::select('tipo_vale', ['E' => 'Entrega', 'D' => 'Devolución'], null, [
                'class' => 'form-control',
                'placeholder' => 'Seleccionar...',
            ]) !!}
            @error('tipo_vale')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

</div>

<br />


<div id='divProductos' class="row">
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

    <div class="col-2">
        <div class="form-group">
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
