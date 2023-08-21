<div class="row">
    <div class="col-3">
        <div class="form-group">
            {!! Form::label('codigo', 'Código:') !!}
            {!! Form::text('codigo', null, ['class' => 'form-control', 'placeholder' => 'Código del producto']) !!}
            @error('codigo')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-5">
        <div class="form-group">
            {!! Form::label('nombre', 'Nombre:') !!}
            {!! Form::text('nombre', null, ['class' => 'form-control', 'placeholder' => 'Nombre del producto']) !!}
            @error('nombre')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-2">
        <div class="form-group">
            {!! Form::label('unidad_medida', 'U/M:') !!}
            {!! Form::text('unidad_medida', null, ['class' => 'form-control', 'placeholder' => 'Unidad de medida']) !!}
            @error('unidad_medida')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-2">
        <div class="form-group">
            {!! Form::label('precio', 'Precio:') !!}
            {!! Form::text('precio', null, ['class' => 'form-control', 'placeholder' => 'Precio del producto']) !!}
            @error('precio')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>


<div class="form-group">
    {!! Form::label('descripcion', 'Descripción:') !!}
    {!! Form::text('descripcion', null, ['class' => 'form-control', 'placeholder' => 'Descripción del producto']) !!}
    @error('descripcion')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>
