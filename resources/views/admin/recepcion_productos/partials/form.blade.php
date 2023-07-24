<div class="row">
    <div class="col-3">
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

    <div class="col-3">
        <div class="form-group">
            {!! Form::label('nro_informe', 'No. de Informe:', [
                'class' => 'pl-1',
            ]) !!}
            {!! Form::text('nro_informe', null, [
                'class' => 'form-control',
                'placeholder' => 'Nro. Informe de Recepción',
            ]) !!}
            @error('nro_informe')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-6">
        <div class="form-group">
            {!! Form::label('almacen', 'Almacén:', [
                'class' => 'pl-1',
            ]) !!}
            {!! Form::select('almacen', $almacenes, null, [
                'class' => 'form-control',
                'placeholder' => 'Seleccione el almacén al cual desesa ingresar los productos...',
            ]) !!}
            @error('almacen')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<br />


<div class="row">
    <div class="col-8">
        <div class="form-group">
            {!! Form::label('producto', 'Producto:', [
                'class' => 'pl-1',
            ]) !!}
            {!! Form::select('producto', $productos, null, [
                'class' => 'form-control text-uppercase',
                'placeholder' => 'Seleccione productos...',
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
            {!! Form::number('cantidad', '1', ['min' => '1', 'class' => 'text-center form-control']) !!}
            @error('cantidad')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-1 mr-2">
        <div class="form-group">
            {!! Form::label('label', 'Agregar', ['class' => 'text-white']) !!}
            {{ Form::button('+', ['class' => 'btn btn-info', 'id' => 'add']) }}
        </div>
    </div>
</div>
