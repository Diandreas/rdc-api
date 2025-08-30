<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer les rôles
        $adminRole = Role::create(['name' => 'admin']);
        $editorRole = Role::create(['name' => 'editor']);

        // Créer les permissions
        $permissions = [
            'view speeches',
            'create speeches',
            'edit speeches',
            'delete speeches',
            'publish speeches',
            'view news',
            'create news',
            'edit news',
            'delete news',
            'publish news',
            'view quotes',
            'create quotes',
            'edit quotes',
            'delete quotes',
            'publish quotes',
            'view contact messages',
            'reply contact messages',
            'delete contact messages',
            'manage categories',
            'manage tags',
            'manage social links',
            'manage users'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Assigner toutes les permissions au rôle admin
        $adminRole->givePermissionTo(Permission::all());

        // Assigner quelques permissions au rôle editor
        $editorRole->givePermissionTo([
            'view speeches', 'create speeches', 'edit speeches',
            'view news', 'create news', 'edit news',
            'view quotes', 'create quotes', 'edit quotes',
            'view contact messages'
        ]);

        // Créer l'utilisateur admin
        $admin = User::create([
            'name' => 'Administrateur',
            'email' => 'admin@presidence-rca.cf',
            'password' => Hash::make('Admin123!'),
            'email_verified_at' => now(),
        ]);

        $admin->assignRole('admin');

        // Créer un utilisateur éditeur
        $editor = User::create([
            'name' => 'Éditeur',
            'email' => 'editor@presidence-rca.cf',
            'password' => Hash::make('Editor123!'),
            'email_verified_at' => now(),
        ]);

        $editor->assignRole('editor');
    }
}
