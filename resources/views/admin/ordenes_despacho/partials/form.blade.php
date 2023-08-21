<input id="user_id" type="hidden" value="{{ Auth::user()->id }}" />

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
            {!! Form::label('nro_orden', 'No. Orden:', [
                'class' => 'pl-1',
            ]) !!}
            {!! Form::text('nro_orden', null, [
                'class' => 'form-control',
                'placeholder' => 'Nro. Orden de despacho',
            ]) !!}
            @error('nro_orden')
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
    <div class="col-5">
        <div class="form-group">
            {!! Form::label('producto', 'Producto:', [
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
            {!! Form::label('cantidad_ordenada', 'Cant. Ordenada:', [
                'class' => 'pl-1',
            ]) !!}
            {!! Form::number('cantidad_ordenada', '1', ['min' => '1', 'class' => 'text-right form-control']) !!}
            @error('cantidad_ordenada')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-2">
        <div class="form-group">
            {!! Form::label('cantidad_despachada', 'Cant. Despachada:', [
                'class' => 'pl-1',
            ]) !!}
            {!! Form::number('cantidad_despachada', '1', ['min' => '1', 'class' => 'text-right form-control']) !!}
            @error('cantidad_despachada')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-2">
        <div class="form-group">
            {!! Form::label('cantidad_entregada', 'Cant. Entregada:', [
                'class' => 'pl-1',
            ]) !!}
            {!! Form::number('cantidad_entregada', '1', ['min' => '1', 'class' => 'text-right form-control']) !!}
            @error('cantidad_entregada')
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
