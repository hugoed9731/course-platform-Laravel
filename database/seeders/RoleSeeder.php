<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $role = Role::create(['name' => 'Admin']);

    //   recuperamos la relacion con permissions
    // dentro de attach le pasamos el id de todos los permisos que queremos que tenga ese rol
     $role->permissions()->attach([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]);

     $role = Role::create(['name' => 'Instructor']);

    //  vamos a relacionar este rol con los permisos con un metodo de laravel permisos
    // aqui le pasamos los nombre que le hemos dado a los permisos
    $role->syncPermissions(['Crear cursos', 'Leer cursos', 'Actualizar cursos', 'Eliminar cursos']);
    }
}
