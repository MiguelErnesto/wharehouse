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

        $role1 = Role::create(['name' => 'admin']);
        $role2 = Role::create(['name' => 'blogger']);

        Permission::create([
            'name' => 'admin.home',
            'description' => 'See the dashboard',
        ])->syncRoles([$role1, $role2]);

        Permission::create([
            'name' => 'admin.users.index',
            'description' => 'See the list of users',
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.users.edit',
            'description' => 'Assign roles to users',
        ])->syncRoles([$role1]);

        Permission::create([
            'name' => 'admin.categories.index',
            'description' => 'See the list of categories',
        ])->syncRoles([$role1, $role2]);
        Permission::create([
            'name' => 'admin.categories.create',
            'description' => 'Create a new category',
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.categories.edit',
            'description' => 'Edit categories',
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.categories.destroy',
            'description' => 'Delete categories',
        ])->syncRoles([$role1]);

        Permission::create([
            'name' => 'admin.tags.index',
            'description' => 'See the list of tags',
        ])->syncRoles([$role1, $role2]);
        Permission::create([
            'name' => 'admin.tags.create',
            'description' => 'Create a new tag',
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.tags.edit',
            'description' => 'Edit tags',
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.tags.destroy',
            'description' => 'Delete tags',
        ])->syncRoles([$role1]);

        Permission::create([
            'name' => 'admin.posts.index',
            'description' => 'See the list of posts',
        ])->syncRoles([$role1, $role2]);
        Permission::create([
            'name' => 'admin.posts.create',
            'description' => 'Create a new post',
        ])->syncRoles([$role1, $role2]);
        Permission::create([
            'name' => 'admin.posts.edit',
            'description' => 'Edit posts',
        ])->syncRoles([$role1, $role2]);
        Permission::create([
            'name' => 'admin.posts.destroy',
            'description' => 'Delete posts',
        ])->syncRoles([$role1, $role2]);

        // Almacenes Roles
        Permission::create([
            'name' => 'admin.almacenes.index',
            'description' => 'Listar almacenes',
        ])->syncRoles([$role1, $role2]);
        Permission::create([
            'name' => 'admin.almacenes.create',
            'description' => 'Crear nuevo almacén',
        ])->syncRoles([$role1, $role2]);

        Permission::create([
            'name' => 'admin.almacenes.edit',
            'description' => 'Editar almacén',
        ])->syncRoles([$role1, $role2]);

        Permission::create([
            'name' => 'admin.almacenes.destroy',
            'description' => 'Eliminar almacén',
        ])->syncRoles([$role1, $role2]);

        //Enable foreign key checks for current db driver
        //SET foreign_key_checks = 1 //MYSQL
        DB::statement('PRAGMA foreign_keys = OFF;');
    }
}
