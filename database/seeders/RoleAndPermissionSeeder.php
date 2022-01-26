<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    public function run()
    {
        $superAdmin = Role::query()->create(['name' => 'super admin', 'guard_name' => 'api']);
        $admin = Role::query()->create(['name' => 'admin', 'guard_name' => 'api']);
        $reader = Role::query()->create(['name' => 'reader', 'guard_name' => 'api']);

        foreach (config('permission.permissions') as $name) {
            Permission::create(['guard_name' => 'api', 'name' => $name]);
        }

        $admin->givePermissionTo(Permission::all()->pluck('name')->toArray());
        $superAdmin->givePermissionTo(Permission::all()->pluck('name')->toArray());
        $reader->givePermissionTo(
            Permission::query()
                ->where('name', 'like', '%view%')
                ->pluck('name')
                ->toArray()
        );

        /** @var User $user */
        $user = User::query()->firstOrCreate([
            'name'  => 'Admin',
            'email' => 'admin@mail.com',

        ], [
            'email_verified_at' => now(),
            'password'          => bcrypt('password'),
        ]);

        $user->assignRole([$superAdmin->name]);
    }
}
