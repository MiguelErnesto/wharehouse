<div class="form-group">
    {!! Form::label('nombre', 'Nombre:') !!}
    {!! Form::text('nombre', null, ['class' => 'form-control', 'placeholder' => 'Nombre del almacén']) !!}
    @error('nombre')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>

<div class="form-group">
    {!! Form::label('direccion', 'Dirección:') !!}
    {!! Form::text('direccion', null, ['class' => 'form-control', 'placeholder' => 'Dirección del almacén']) !!}
    @error('direccion')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>
