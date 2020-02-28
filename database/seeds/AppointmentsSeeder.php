<?php

use Illuminate\Database\Seeder;

class AppointmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\User::class, 1)->create()->each(function ($user) {
            $user->addedbooks()->save(factory(\App\Book::class)->make())->each(function ($book) {
                $book->author()->attach([1, 2]);
                $book->categories()->attach([1, 2]);
            });
        });
    }
}
