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
        User::create([
            'name'=> 'Hugo Eduardo Garcia',
            'email' => 'hugoed97@gmail.com',
            'password' => bcrypt('12345678'), // bcrypt - password encrypted
        ]);

        User::factory(99)->create(); // here we indicated how many test records we want
    }
}
