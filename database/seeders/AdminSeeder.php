<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Orchid\Platform\Models\Role;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $email = env('ADMIN_EMAIL', 'admin@imp-tech.local');
        $password = env('ADMIN_PASSWORD', 'admin1234');

        $permissions = [
            'platform.index' => 1,
            'platform.systems.roles' => 1,
            'platform.systems.users' => 1,
            'platform.content.pages' => 1,
            'platform.content.products' => 1,
            'platform.content.applications' => 1,
            'platform.content.cases' => 1,
            'platform.content.news' => 1,
            'platform.content.menus' => 1,
            'platform.content.settings' => 1,
            'platform.content.leads' => 1,
            'platform.systems.attachment' => 1,
        ];

        $role = Role::firstOrCreate(
            ['slug' => 'admin'],
            ['name' => 'Admin', 'permissions' => $permissions]
        );

        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => 'Administrator',
                'password' => Hash::make($password),
            ]
        );

        if ($user->wasRecentlyCreated || ! $user->hasAccess('platform.content.pages')) {
            $user->forceFill(['permissions' => $permissions])->save();
        }

        $user->replaceRoles([$role->id]);

        $this->command?->info("Admin user: {$email} / {$password}");
    }
}
