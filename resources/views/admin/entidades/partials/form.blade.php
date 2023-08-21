<div class="row">
    <div class="col-4">
        <div class="form-group">
            {!! Form::label('codigo', 'Código:') !!}
            {!! Form::text('codigo', null, ['class' => 'form-control', 'placeholder' => 'Código de la entidad']) !!}
            @error('codigo')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-8">
        <div class="form-group">
            {!! Form::label('nombre', 'Nombre:') !!}
            {!! Form::text('nombre', null, ['class' => 'form-control', 'placeholder' => 'Nombre de la entidad']) !!}
            @error('nombre')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>


<div class="form-group">
    {!! Form::label('descripcion', 'Descripción:') !!}
    {!! Form::text('descripcion', null, ['class' => 'form-control', 'placeholder' => 'Descripción de la entidad']) !!}
    @error('descripcion')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>
