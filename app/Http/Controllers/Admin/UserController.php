<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:Listar usuarios')->only('index');
        $this->middleware('can:Crear usuario')->only('create');
        $this->middleware('can:Editar usuario')->only('edit', 'update');
        $this->middleware('can:Eliminar usuario')->only('destroy');
        $this->middleware('can:Asignar roles')->only(
            'asignarRoles',
            'updateRoles'
        );
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        return view('admin.users.index', compact('roles'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = User::create($request->all());
        return redirect()
            ->route('admin.users.index')
            ->with('info', 'Usuario ' . $user->name . ' creado correctamente');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */

    public function asignarRoles(User $user)
    {
        $roles = Role::all();
        return view('admin.users.asignarRoles', compact('user', 'roles'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function updateRoles(Request $request, User $user)
    {
        $user->roles()->sync($request->roles);
        return redirect()
            ->route('admin.users.index', $user)
            ->with(
                'info',
                'Roles del usuario ' .
                    $user->name .
                    ' actualizados correctamente'
            );
    }

    public function update(Request $request, User $user)
    {
        if (!$request->password) {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);
        } else {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
        }

        return redirect()
            ->route('admin.users.index')
            ->with(
                'info',
                'Usuario ' . $user->name . ' actualizado correctamente'
            );
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with(
                'info',
                'Usuario ' . $user->name . ' eliminado correctamente'
            );
    }
}
