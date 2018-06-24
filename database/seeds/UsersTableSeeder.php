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

        for ($i = 0; $i < 100; $i++) {
            $user = App\User::create([
                'username' => $faker->userName,
                'email' => $faker->email,
                'password' => bcrypt('password'),
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
            ]);
            $random = rand(1, 5);

            if ($random == 1)
                $user->assignRole('standard user');
            else if ($random == 2)
                $user->assignRole('editor');
            else if ($random == 3)
                $user->assignRole('administrator');
            else if ($random == 4)
                $user->assignRole('super admin');
            else
                $user->assignRole('owner');
        }

        $user = App\User::create([
            'username' => $faker->userName,
            'email' => 'oyvlei@gmail.com',
            'password' => bcrypt('heihei11'),
            'first_name' => 'Øyvind',
            'last_name' => $faker->lastName,
        ]);

        $user->assignRole('owner');

        $user1 = App\User::create([
            'username' => $faker->userName,
            'email' => 'oyvlei2@gmail.com',
            'password' => bcrypt('heihei11'),
            'first_name' => 'Øyvind',
            'last_name' => $faker->lastName,
        ]);

        $user1->assignRole('editor');

        App\Category::create(['name' => 'News',]);
        App\Category::create(['name' => 'Gaming']);
        App\Category::create(['name' => 'Lifestyle']);
        App\Category::create(['name' => 'Technology']);
        App\Category::create(['name' => 'Pets']);
        App\Category::create(['name' => 'Garden']);

        App\Tag::create(['name' => 'Php']);
        App\Tag::create(['name' => 'Laravel']);
        App\Tag::create(['name' => 'Java']);
        App\Tag::create(['name' => 'Wordpress']);
        App\Tag::create(['name' => 'Tomato']);
        App\Tag::create(['name' => 'Infinite']);
        App\Tag::create(['name' => 'Javascript']);
        App\Tag::create(['name' => 'Omni']);

    }
}
