<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Faker\Factory::create();

        App\Role::create(['name' => 'standard']);
        App\Role::create(['name' => 'editor']);
        App\Role::create(['name' => 'administrator']);
        App\Role::create(['name' => 'owner']);

        for($i = 0; $i < 100; $i++) {
            App\User::create([
                'username' => $faker->userName,
                'email' => $faker->email,
                'password' => bcrypt('password'),
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'role_id' => rand(1,4)
            ]);
        }

        App\User::create([
            'username' => $faker->userName,
            'email' => 'oyvlei@gmail.com',
            'password' => bcrypt('heihei11'),
            'first_name' => $faker->firstNameMale,
            'last_name' => $faker->lastName,
            'role_id' => 3
        ]);

    }
}
