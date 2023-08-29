<input name="user_id" id="user_id" type="hidden" value="{{ Auth::user()->id }}" />

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
            {!! Form::label('almacen_id', 'Almacén:', [
                'class' => 'pl-1',
            ]) !!}
            {!! Form::select('almacen_id', $almacenes, null, [
                'class' => 'form-control',
                'placeholder' => 'Seleccione el almacén al cual desesa ingresar los productos...',
            ]) !!}
            @error('almacen_id')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>


<div id='divProductos' class="row">
    <div class="col-8">
        <div class="form-group">
            {!! Form::label('producto', 'Productos de la recepción:', [
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

<br />

<div class="table-responsive pl-4">
    <table id="listaProductos" class="table table-striped w-75">
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
