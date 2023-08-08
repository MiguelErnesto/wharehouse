<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Disable foreign key checks for current db driver
        //SET foreign_key_checks = 0   //MYSQL
        DB::statement('PRAGMA foreign_keys = ON;');
        DB::table('roles')->truncate();
        DB::table('permissions')->truncate();

        $role1 = Role::create(['name' => 'SuperAdmin']);
        $role2 = Role::create(['name' => 'Administrador']);
        $role3 = Role::create(['name' => 'Almacenero']);
        $role4 = Role::create(['name' => 'Contador']);
        $role5 = Role::create(['name' => 'Director']);

        //Ver Dashboard
        Permission::create([
            'name' => 'admin.home',
            'description' => 'Ver panel de administración',
        ])->syncRoles([$role1, $role2, $role3, $role4, $role5]);

        //Administración de usuarios
        Permission::create([
            'name' => 'admin.users.index',
            'description' => 'Listar usuarios',
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.users.edit',
            'description' => 'Asignar roles a usuarios',
        ])->syncRoles([$role1]);

        // Permisos para Almacenes
        Permission::create([
            'name' => 'admin.almacenes.index',
            'description' => 'Listar almacenes',
        ])->syncRoles([$role1, $role2, $role3, $role4, $role5]);
        Permission::create([
            'name' => 'admin.almacenes.create',
            'description' => 'Crear nuevo almacén',
        ])->syncRoles([$role1, $role2, $role3, $role4, $role5]);
        Permission::create([
            'name' => 'admin.almacenes.edit',
            'description' => 'Editar almacén',
        ])->syncRoles([$role1, $role2, $role3, $role4, $role5]);
        Permission::create([
            'name' => 'admin.almacenes.destroy',
            'description' => 'Eliminar almacén',
        ])->syncRoles([$role1, $role2, $role3, $role4, $role5]);

        // Permisos para Productos
        Permission::create([
            'name' => 'admin.productos.index',
            'description' => 'Listar productos',
        ])->syncRoles([$role1, $role2, $role3, $role4, $role5]);
        Permission::create([
            'name' => 'admin.productos.create',
            'description' => 'Crear nuevo producto',
        ])->syncRoles([$role1, $role2, $role3, $role4, $role5]);
        Permission::create([
            'name' => 'admin.productos.edit',
            'description' => 'Editar producto',
        ])->syncRoles([$role1, $role2, $role3, $role4, $role5]);
        Permission::create([
            'name' => 'admin.productos.destroy',
            'description' => 'Eliminar producto',
        ])->syncRoles([$role1, $role2, $role3, $role4, $role5]);

        // Permisos para los Productos de los almacenes
        Permission::create([
            'name' => 'admin.almacenes_productos.index',
            'description' => 'Listar productos de un almacén',
        ])->syncRoles([$role1, $role2, $role3, $role4, $role5]);
        Permission::create([
            'name' => 'admin.almacenes_productos.create',
            'description' => 'Ingresar nuevo producto a un almacén',
        ])->syncRoles([$role1, $role2, $role3, $role4, $role5]);
        Permission::create([
            'name' => 'admin.almacenes_productos.edit',
            'description' => 'Editar productos de un almacén',
        ])->syncRoles([$role1, $role2, $role3, $role4, $role5]);
        Permission::create([
            'name' => 'admin.almacenes_productos.destroy',
            'description' => 'Eliminar productos de un almacén',
        ])->syncRoles([$role1, $role2, $role3, $role4, $role5]);

        // Permisos para la Recepción de Productos
        Permission::create([
            'name' => 'admin.informes_recepcion.index',
            'description' => 'Listar informe de recepción',
        ])->syncRoles([$role1, $role2, $role3, $role4, $role5]);
        Permission::create([
            'name' => 'admin.informes_recepcion.create',
            'description' => 'Crear nuevo informe de recepción',
        ])->syncRoles([$role1, $role2, $role3, $role4, $role5]);
        Permission::create([
            'name' => 'admin.informes_recepcion.edit',
            'description' => 'Editar informe de recepción',
        ])->syncRoles([$role1, $role2, $role3, $role4, $role5]);
        Permission::create([
            'name' => 'admin.informes_recepcion.destroy',
            'description' => 'Eliminar informe de recepción',
        ])->syncRoles([$role1, $role2, $role3, $role4, $role5]);

        // Permisos para el Despacho de Productos
        Permission::create([
            'name' => 'admin.ordenes_despacho.index',
            'description' => 'Listar orden de despacho',
        ])->syncRoles([$role1, $role2, $role3, $role4, $role5]);
        Permission::create([
            'name' => 'admin.ordenes_despacho.create',
            'description' => 'Crear nueva orden de despacho',
        ])->syncRoles([$role1, $role2, $role3, $role4, $role5]);
        Permission::create([
            'name' => 'admin.ordenes_despacho.edit',
            'description' => 'Editar orden de despacho',
        ])->syncRoles([$role1, $role2, $role3, $role4, $role5]);
        Permission::create([
            'name' => 'admin.ordenes_despacho.destroy',
            'description' => 'Eliminar orden de despacho',
        ])->syncRoles([$role1, $role2, $role3, $role4, $role5]);

        //Enable foreign key checks for current db driver
        //SET foreign_key_checks = 1 //MYSQL
        DB::statement('PRAGMA foreign_keys = OFF;');
    }
}
