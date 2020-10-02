<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = factory(User::class, 200)->create();

        $user->each(function (User $user){
           $categories = \App\Category::all()->random(10)->pluck('id');
           $users = User::all()->random(10)->pluck('id');

           $user->categories()->attach($categories);
           $user->users()->attach($users);
        });
    }
}
