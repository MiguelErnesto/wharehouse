<div>
    <div class="card">
        <div class="card-header">
            @can('Crear usuario')
                <a href="{{ route('admin.users.create') }}" class="btn btn-info" title="Crear Nuevo"><i
                        class="fas fa-solid fa-file pr-3"></i>Nuevo</a>
            @endcan
            {{-- <input class="form-control col ml-4" type="text" placeholder="Users search" wire:model="search"> --}}

        </div>
        @if ($users->count())
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nombre de usuario</th>
                            <th>Correo electrónico</th>
                            <th class="text-center">Roles</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td class="text-right pr-4" style="width: 25%;">
                                    @foreach ($user->roles as $role)
                                        <span class="badge badge-info p-1 pl-2 pr-2">{{ $role['name'] }} </span>
                                    @endforeach
                                </td>

                                @can('Asignar roles')
                                    <td width="8px"
                                        style="padding-right: 0rem;padding-left: 0.125rem;vertical-align: middle;">
                                        <a class="btn btn-primary btn-sm"
                                            href="{{ route('admin.users.asignarRoles', $user) }}" title="Asignar roles">
                                            <i class="fas fa-users-cog fa-pen"></i></a>
                                    </td>
                                @endcan

                                @can('Editar usuario')
                                    <td width="8px"
                                        style="padding-right: 0rem;padding-left: 0.125rem;vertical-align: middle;">
                                        <a class="btn btn-success btn-sm" href="{{ route('admin.users.edit', $user) }}"
                                            title="Editar usuario">
                                            <i class="fas fa-solid fa-pen"></i></a>
                                    </td>
                                @endcan

                                @can('Eliminar usuario')
                                    <td width="8px"
                                        style="padding-right: 0.75rem;padding-left: 0.125rem;vertical-align: middle;">
                                        {{-- <form action="{{ route('admin.users.edit', $user) }}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                                                <i class="fas fa-solid fa-trash fa-lg"></i></button>
                                        </form> --}}
                                        <form id='formIndex_{{ $user->id }}'
                                            action="{{ route('admin.users.destroy', $user) }}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" data-id={{ $user->id }}
                                                class="btn btn-danger btn-sm btnDelete" title='Eliminar'>
                                                <i class="fas fa-solid fa-trash"></i></button>
                                        </form>
                                    </td>
                                @endcan
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $users->links() }}
            </div>
        @else
            <div class="card-body">
                <strong>There are no posts with the name: {{ $search }}.</strong>
            </div>
        @endif
    </div>
</div>
