<div class="form-group">
    {!! Form::label('name', 'Role de usuario:') !!}
    {!! Form::text('name', null, [
        'class' => 'form-control',
        'placeholder' => 'Enter the role name',
    ]) !!}
    @error('name')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>
<h2 class="h4">Listado de permisos</h2>
@foreach ($permissions as $permission)
    @if (strpos($permission->description, 'Listar') !== false)
        <br />
    @endif
    <div>
        <label class='pl-5'>
            {!! Form::checkbox('permissions[]', $permission->id, null, ['class' => 'mr-1']) !!}
            {{ $permission->description }}
        </label>
    </div>
@endforeach
