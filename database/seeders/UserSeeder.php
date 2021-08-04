<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $user = User::create([
            'name'=> 'Hugo Eduardo',
            'email' => 'hugoed@gmail.com',
            'password' => bcrypt('12345678'), // bcrypt - password encrypted
        ]);
        // assignRole es una propiedad de laravelPermisos que no pide el id si no el nombre del rol
        $user->assignRole('Admin'); //asignamos el rol

        User::factory(99)->create(); // here we indicated how many test records we want
    }
}
