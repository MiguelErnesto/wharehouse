<div class="row">
    <div class="col-4">
        <div class="form-group">
            {!! Form::label('name', 'Nombre de usuario:') !!}
            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nombre del usuario']) !!}
            @error('name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-8">
        <div class="form-group">
            {!! Form::label('email', 'Correo electrónico:') !!}
            {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Correo electrónico']) !!}
            @error('email')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<br />

<div class="row">
    <div class="col-4">
        <div class="form-group">
            {!! Form::label('password', 'Contraseña:') !!}
            {!! Form::password('password', null, ['class' => 'form-control', 'placeholder' => 'Contraseña']) !!}
            @error('password')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-4">
        <div class="form-group">
            {!! Form::label('confirmar_password', 'Confirmar contraseña:') !!}
            {!! Form::password('confirmar_password', null, [
                'class' => 'form-control',
                'placeholder' => 'Confirmar contraseña',
            ]) !!}
            @error('confirmar_password')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<br />

<div class="col-12">
    <div class="form-group">
        {!! Form::label('lblpwd', 'NOTA: Dejar contraseñas en blanco si no se deseea cambiar', ['id' => 'lbPWD']) !!}
    </div>
</div>
