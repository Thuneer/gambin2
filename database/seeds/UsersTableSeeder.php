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

        for ($i = 0; $i < 25; $i++) {
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

        $root = App\Page::create(['title' => 'Persons', 'permalink' => 'persons', 'permalink_short' => 'persons', 'type' => 0, 'front_page' => 0]);
        $root->children()->create(['title' => 'Matt', 'permalink' => 'persons/matt', 'permalink_short' => 'matt', 'type' => 0, 'front_page' => 0]);
        $root->children()->create(['title' => 'Sam', 'permalink' => 'persons/sam', 'permalink_short' => 'sam', 'type' => 0, 'front_page' => 0]);

        $root1 = App\Page::create(['title' => 'Animals', 'permalink' => 'animals', 'permalink_short' => 'animals', 'type' => 0, 'front_page' => 0]);
        $root1->children()->create(['title' => 'Dog', 'permalink' => 'animals/dog', 'permalink_short' => 'dog', 'type' => 0, 'front_page' => 0]);
        $root1->children()->create(['title' => 'Horse', 'permalink' => 'animals/horse', 'permalink_short' => 'horse', 'type' => 0, 'front_page' => 0]);

        $sara = $root->children()->create(['title' => 'Timmy', 'permalink' => 'persons/timmy', 'permalink_short' => 'timmy', 'type' => 0, 'front_page' => 0]);
        $root->children()->create(['title' => 'Sara', 'permalink' => 'persons/sara', 'permalink_short' => 'sara', 'type' => 0, 'front_page' => 0]);
        $sara->children()->create(['title' => 'Boy', 'permalink' => 'persons/timmy/boy', 'permalink_short' => 'boy', 'type' => 0, 'front_page' => 0]);


    }
}
