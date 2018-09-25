<?php

use Illuminate\Database\Seeder;

class ArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $ingress = 'Creating often decelerate a he make when he the or there own the origin war, one the worries been guest completely arm, his that out the throughout. Few his the and taken though break passion and several for service, arrange need ago haven\'t with I view cognitive extent, were abandon.';

        for ($i = 0; $i < 10; $i++) {
            $article = App\Post::create([
                'title' => $faker->text($maxNbChars = 40),
                'ingress' => $faker->text($maxNbChars = 150),
                'slug' => $faker->text($maxNbChars = 40),
                'status' => 'draft',
                'user_id' => 1,
            ]);
            $article->images()->attach($i + 1);
        }

    }
}
