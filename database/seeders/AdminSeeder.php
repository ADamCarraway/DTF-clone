<?php

namespace Database\Seeders;

use App\Listeners\AddSubsToUser;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        /** @var User $admin */
        $admin = User::query()->create([
            'name'              => 'Admin',
            'email'             => 'admin@mail.com',
            'email_verified_at' => now(),
            'password'          => bcrypt('password'),
        ]);

        $categories = Category::query()->whereIn('slug', AddSubsToUser::SUBS)->get();

        $admin->followMany($categories);
    }
}
