<?php

use App\Models\User;
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
        $user = User::all();

        /** @var User $user */
        $user->each(function (User $user){
           $categories = \App\Models\Category::all();
           $users = User::all()->random(10);

           $user->followMany($categories);
           $user->followMany($users);
        });
    }
}
