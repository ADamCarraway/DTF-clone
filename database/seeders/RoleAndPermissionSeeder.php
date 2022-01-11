<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    public function run()
    {
        Role::query()->insert([
            ['name' => 'admin', 'guard_name' => 'api'],
        ]);

        /** @var User $user */
        $user = User::query()->firstOrCreate([
            'name'  => 'Admin',
            'email' => 'admin@mail.com',

        ], [
            'email_verified_at' => now(),
            'password'          => bcrypt('password'),
        ]);

        $user->assignRole(['admin']);
    }
}
