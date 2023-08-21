<input id="user_id" type="hidden" value="{{ Auth::user()->id }}" />

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
</div>

<div class="row">

    <div class="col-3">
        <div class="form-group">
            {!! Form::label('nro_orden', 'No. Orden:', [
                'class' => 'pl-1',
            ]) !!}
            {!! Form::text('nro_orden', null, [
                'class' => 'form-control',
                'placeholder' => 'Nro. Orden',
            ]) !!}
            @error('nro_orden')
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

    <div class="col-3">
        <div class="form-group">
            {!! Form::label('almacen', 'Almacén:', [
                'class' => 'pl-1',
            ]) !!}
            {!! Form::select('almacen', $almacenes, null, [
                'class' => 'form-control',
                'placeholder' => 'Seleccione el almacén...',
            ]) !!}
            @error('almacen')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-3">
        <div class="form-group">
            {!! Form::label('clientes', 'Cliente:', [
                'class' => 'pl-1',
            ]) !!}
            {!! Form::select('clientes', $clientes, null, [
                'class' => 'form-control',
                'placeholder' => 'Seleccione el cliente...',
            ]) !!}
            @error('clientes')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<br />


<div class="row">
    <div class="col-4">
        <div class="form-group">
            {!! Form::label('lugar_entrega', 'Lugar de entrega:', [
                'class' => 'pl-1',
            ]) !!}
            {!! Form::text('lugar_entrega', null, [
                'class' => 'form-control',
                'placeholder' => 'Lugar de entrega',
            ]) !!}
            @error('lugar_entrega')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-2">
        <div class="form-group">
            {!! Form::label('fecha_entrega', 'Fecha de entrega:', [
                'class' => 'pl-1',
            ]) !!}
            {!! Form::date('fecha_entrega', now(), [
                'class' => 'form-control',
                'placeholder' => 'Fecha de entrega',
            ]) !!}
            @error('fecha_entrega')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-2 ml-5">
        <div class="form-group">
            {!! Form::label('tipo_vale', 'Tipo de Salida:', [
                'class' => 'pl-1',
            ]) !!}
            {!! Form::select('tipo_vale', ['V' => 'Vale', 'T' => 'Transferencia'], null, [
                'class' => 'form-control',
                'placeholder' => 'Seleccionar...',
            ]) !!}
            @error('tipo_vale')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div id='divVales' class="col-3">
        <div class="form-group">
            {!! Form::label('vale', 'Nro. Vale:', [
                'class' => 'pl-1',
            ]) !!}
            {!! Form::select('vale', $vales, null, [
                'class' => 'form-control',
                'placeholder' => 'Seleccionar...',
            ]) !!}
            @error('vale')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div id='divTrasnferencia' class="col-3">
        <div class="form-group">
            {!! Form::label('transferencia', 'Nro. Transferencia:', [
                'class' => 'pl-1',
            ]) !!}
            {!! Form::select('transferencia', $vales, null, [
                'class' => 'form-control',
                'placeholder' => 'Seleccionar...',
            ]) !!}
            @error('transferencia')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<br />

<div class="row">

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
