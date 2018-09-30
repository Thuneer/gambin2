<?php

use Illuminate\Database\Seeder;

class MessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Faker\Factory::create();

        $thread1 = App\Thread::create([
            'user_id_1' => 26,
            'user_id_2' => 7,
        ]);

        $thread2 = App\Thread::create([
            'user_id_1' => 26,
            'user_id_2' => 2,
        ]);

        $thread3 = App\Thread::create([
            'user_id_1' => 26,
            'user_id_2' => 6,
        ]);

        $message1 = App\Message::create([
            'text' => $faker->text($maxNbChars = 150),
            'user_id' => 7,
            'thread_id' => 1
        ]);
        $message1 = App\Message::create([
            'text' => $faker->text($maxNbChars = 150),
            'user_id' => 7,
            'thread_id' => 1
        ]);
        $message1 = App\Message::create([
            'text' => $faker->text($maxNbChars = 150),
            'user_id' => 26,
            'thread_id' => 1
        ]);
        $message1 = App\Message::create([
            'text' => $faker->text($maxNbChars = 150),
            'user_id' => 7,
            'thread_id' => 1
        ]);


        $message1 = App\Message::create([
            'text' => $faker->text($maxNbChars = 150),
            'user_id' => 2,
            'thread_id' => 2
        ]);
        $message1 = App\Message::create([
            'text' => $faker->text($maxNbChars = 150),
            'user_id' => 26,
            'thread_id' => 2
        ]);
        $message1 = App\Message::create([
            'text' => $faker->text($maxNbChars = 150),
            'user_id' => 2,
            'thread_id' => 2
        ]);

    }
}
