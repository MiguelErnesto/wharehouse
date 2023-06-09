<div>
    <div class="card">
        <div class="card-header">
            <div class="row">
                {{-- <a href="{{ route('admin.posts.create') }}" class="btn btn-secondary col-2">asdasdasd</a> --}}
                <input class="form-control col ml-4" type="text" placeholder="Users search" wire:model="search">
            </div>
        </div>
        @if ($users->count())
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td width="10px">
                                    {{-- <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">Edit</a> --}}
                                    <a class="btn btn-primary btn-sm" href="{{ route('admin.users.edit', $user) }}"
                                        title="Editar">
                                        <i class="fas fa-solid fa-pen"></i></a>
                                </td>
                                <td width="10px">
                                    <form action="{{ route('admin.users.edit', $user) }}" method="POST">
                                        @csrf
                                        @method('delete')
                                        {{-- <button type="submit" class="btn btn-sm btn-danger">Delete</button> --}}
                                        <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                                            <i class="fas fa-solid fa-trash fa-lg"></i></button>
                                    </form>
                                </td>
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
