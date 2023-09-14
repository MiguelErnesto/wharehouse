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
            'name' => 'Ver panel',
            'description' => 'Ver panel',
        ])->syncRoles([$role1, $role2, $role3, $role4, $role5]);

        //Perfil de usuario
        Permission::create([
            'name' => 'Editar perfil',
            'description' => 'Editar perfil',
        ])->syncRoles([$role1, $role2, $role3, $role4, $role5]);

        //Administración de usuarios
        Permission::create([
            'name' => 'Listar usuarios',
            'description' => 'Listar usuarios',
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'Crear usuario',
            'description' => 'Crear usuarios',
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'Editar usuario',
            'description' => 'Editar usuario',
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'Eliminar usuario',
            'description' => 'Eliminar usuario',
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'Asignar roles',
            'description' => 'Asignar roles a usuarios',
        ])->syncRoles([$role1]);

        //Administración de roles
        Permission::create([
            'name' => 'Listar roles',
            'description' => 'Listar roles',
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'Editar roles',
            'description' => 'Editar',
        ])->syncRoles([$role1]);

        // Permisos para Entidades
        Permission::create([
            'name' => 'Listar entidades',
            'description' => 'Listar entidades',
        ])->syncRoles([$role1, $role2, $role3, $role4, $role5]);
        Permission::create([
            'name' => 'Crear entidad',
            'description' => 'Crear entidad',
        ])->syncRoles([$role1, $role5]);
        Permission::create([
            'name' => 'Editar entidad',
            'description' => 'Editar entidad',
        ])->syncRoles([$role1, $role2, $role3, $role4, $role5]);
        Permission::create([
            'name' => 'Eliminar entidad',
            'description' => 'Eliminar entidad',
        ])->syncRoles([$role1, $role2, $role3, $role4, $role5]);

        // Permisos para Clientes
        Permission::create([
            'name' => 'Listar clientes',
            'description' => 'Listar clientes',
        ])->syncRoles([$role1, $role2, $role3, $role4, $role5]);
        Permission::create([
            'name' => 'Crear cliente',
            'description' => 'Crear cliente',
        ])->syncRoles([$role1, $role5]);
        Permission::create([
            'name' => 'Editar cliente',
            'description' => 'Editar cliente',
        ])->syncRoles([$role1, $role2, $role3, $role4, $role5]);
        Permission::create([
            'name' => 'Eliminar cliente',
            'description' => 'Eliminar cliente',
        ])->syncRoles([$role1, $role2, $role3, $role4, $role5]);

        // Permisos para Almacenes
        Permission::create([
            'name' => 'Listar almacenes',
            'description' => 'Listar almacenes',
        ])->syncRoles([$role1, $role2, $role3, $role4, $role5]);
        Permission::create([
            'name' => 'Crear almacen',
            'description' => 'Crear almacén',
        ])->syncRoles([$role1, $role3, $role5]);
        Permission::create([
            'name' => 'Editar almacen',
            'description' => 'Editar almacen',
        ])->syncRoles([$role1, $role2, $role3, $role4, $role5]);
        Permission::create([
            'name' => 'Eliminar almacen',
            'description' => 'Eliminar almacén',
        ])->syncRoles([$role1, $role2, $role3, $role4, $role5]);

        // Permisos para Productos
        Permission::create([
            'name' => 'Listar productos',
            'description' => 'Listar productos',
        ])->syncRoles([$role1, $role2, $role3, $role4, $role5]);
        Permission::create([
            'name' => 'Crear producto',
            'description' => 'Crear producto',
        ])->syncRoles([$role1, $role2, $role3, $role4, $role5]);
        Permission::create([
            'name' => 'Editar producto',
            'description' => 'Editar producto',
        ])->syncRoles([$role1, $role2, $role3, $role4, $role5]);
        Permission::create([
            'name' => 'Eliminar producto',
            'description' => 'Eliminar producto',
        ])->syncRoles([$role1, $role2, $role3, $role4, $role5]);

        // Permisos para los Productos de los almacenes
        Permission::create([
            'name' => 'Listar productos almacen',
            'description' => 'Listar productos del almacén',
        ])->syncRoles([$role1, $role2, $role3, $role4, $role5]);
        Permission::create([
            'name' => 'Ingresar producto almacen',
            'description' => 'Ingresar producto a un almacén',
        ])->syncRoles([$role1, $role2, $role3, $role4, $role5]);
        Permission::create([
            'name' => 'Editar productos almacen',
            'description' => 'Editar productos del almacén',
        ])->syncRoles([$role1, $role2, $role3, $role4, $role5]);
        Permission::create([
            'name' => 'Eliminar productos almacen',
            'description' => 'Eliminar productos de un almacén',
        ])->syncRoles([$role1, $role2, $role3, $role4, $role5]);

        // Permisos para Informes de Recepcion
        Permission::create([
            'name' => 'Listar informes recepcion',
            'description' => 'Listar informes de recepción',
        ])->syncRoles([$role1, $role2, $role3]);
        Permission::create([
            'name' => 'Crear informe recepcion',
            'description' => 'Crear informe de recepción',
        ])->syncRoles([$role1, $role2, $role3]);
        Permission::create([
            'name' => 'Editar informe recepcion',
            'description' => 'Editar informe de recepción',
        ])->syncRoles([$role1, $role2, $role3]);
        Permission::create([
            'name' => 'Eliminar informe recepcion',
            'description' => 'Eliminar informe de recepción',
        ])->syncRoles([$role1, $role2, $role3]);

        // Permisos para el Despacho de Productos
        Permission::create([
            'name' => 'Listar ordenes despacho',
            'description' => 'Listar ordenes de despachos',
        ])->syncRoles([$role1, $role2, $role5]);
        Permission::create([
            'name' => 'Crear orden despacho',
            'description' => 'Crear orden de despacho',
        ])->syncRoles([$role1, $role2, $role5]);
        Permission::create([
            'name' => 'Editar orden despacho',
            'description' => 'Editar orden de despacho',
        ])->syncRoles([$role1, $role2, $role5]);
        Permission::create([
            'name' => 'Eliminar orden despacho',
            'description' => 'Eliminar orden de despacho',
        ])->syncRoles([$role1, $role2, $role5]);

        // Permisos para Vales
        Permission::create([
            'name' => 'Listar vales',
            'description' => 'Listar vales',
        ])->syncRoles([$role1, $role2, $role4]);
        Permission::create([
            'name' => 'Crear vale',
            'description' => 'Crear nuevo vale',
        ])->syncRoles([$role1, $role2, $role4]);
        Permission::create([
            'name' => 'Editar vale',
            'description' => 'Editar vale',
        ])->syncRoles([$role1, $role2, $role4]);
        Permission::create([
            'name' => 'Eliminar vale',
            'description' => 'Eliminar vale',
        ])->syncRoles([$role1, $role2, $role4]);

        // Permisos para Transferencias
        Permission::create([
            'name' => 'Listar transferencias',
            'description' => 'Listar transferencias',
        ])->syncRoles([$role1, $role2, $role3]);
        Permission::create([
            'name' => 'Crear transferencia',
            'description' => 'Crear transferencia',
        ])->syncRoles([$role1, $role2, $role3]);
        Permission::create([
            'name' => 'Editar transferencia',
            'description' => 'Editar transferencia',
        ])->syncRoles([$role1, $role2, $role3]);
        Permission::create([
            'name' => 'Eliminar transferencia',
            'description' => 'Eliminar transferencia',
        ])->syncRoles([$role1, $role2, $role3]);

        // Permisos para Conduces
        Permission::create([
            'name' => 'Listar conduces',
            'description' => 'Listar conduces',
        ])->syncRoles([$role1, $role2, $role3]);
        Permission::create([
            'name' => 'Crear nuevo conduce',
            'description' => 'Crear nuevo conduce',
        ])->syncRoles([$role1, $role2, $role3]);
        Permission::create([
            'name' => 'Editar conduce',
            'description' => 'Editar conduce',
        ])->syncRoles([$role1, $role2, $role3]);
        Permission::create([
            'name' => 'Eliminar conduce',
            'description' => 'Eliminar conduce',
        ])->syncRoles([$role1, $role2, $role3]);

        // Permisos para Facturas
        Permission::create([
            'name' => 'Listar facturas',
            'description' => 'Listar facturas',
        ])->syncRoles([$role1, $role2, $role4]);
        Permission::create([
            'name' => 'Crear factura',
            'description' => 'Crear factura',
        ])->syncRoles([$role1, $role2, $role4]);
        Permission::create([
            'name' => 'Editar factura',
            'description' => 'Editar factura',
        ])->syncRoles([$role1, $role2, $role4]);
        Permission::create([
            'name' => 'Eliminar factura',
            'description' => 'Eliminar factura',
        ])->syncRoles([$role1, $role2, $role4]);

        Permission::create([
            'name' => 'Imprimir',
            'description' => 'Imprimir documentos',
        ])->syncRoles([$role1, $role2, $role4]);

        Permission::create([
            'name' => 'Exportar PDF',
            'description' => 'Exportar documentos en PDF',
        ])->syncRoles([$role1, $role2, $role3]);

        //Enable foreign key checks for current db driver
        //SET foreign_key_checks = 1 //MYSQL
        DB::statement('PRAGMA foreign_keys = OFF;');
    }
}
