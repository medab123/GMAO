<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Machin;
use App\Models\NiveauIntervontion;
use App\Models\TypeIntervontion;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'demande-list',
            'demande-create',
            'demande-edit',
            'demande-delete',
            'resource-list',
            'resource-create',
            'resource-edit',
            'resource-delete'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
        $admin = User::create([
            'name' => 'Hardik Savani',
            'email' => 'admin@admin.com',
            'password' => bcrypt('12345678')
        ]);

        $role = Role::create(['name' => 'admin']);
        $permissions = Permission::pluck('id', 'id')->all();
        $role->syncPermissions($permissions);
        $admin->assignRole([$role->id]);

        $responsable = User::create([
            'name' => 'Mustapha touil',
            'email' => 'mustapha.touil@elephant-vert.com',
            'password' => bcrypt('12345678')
        ]);

        $role = Role::create(['name' => 'responsable']);
        $permissions = Permission::pluck('id', 'id')->all();
        $role->syncPermissions($permissions);
        $responsable->assignRole([$role->id]);

        $technicien = User::create([
            'name' => 'mohammed elabidi',
            'email' => 'mohammed.el-abidi@elephant-vert.com',
            'password' => bcrypt('12345678')
        ]);

        $role = Role::create(['name' => 'technicien']);
        $permissions = Permission::pluck('id', 'id')->all();
        $role->syncPermissions($permissions);
        $technicien->assignRole([$role->id]);


        $user = User::create([
            'name' => 'hajar aliti',
            'email' => 'hajar.aliti@elephant-vert.com',
            'password' => bcrypt('12345678')
        ]);

        $role = Role::create(['name' => 'user']);
        $permissions = Permission::pluck('id', 'id')->all();
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);




        $machine = Machin::create([
            'name' => 'ETIA',
            'description' => 'TESSTS DQ',
        ]);
        $typeIntervontion = TypeIntervontion::create([
            'name' => 'prevontive',
        ]);
        $typeIntervontion = TypeIntervontion::create([
            'name' => 'corrective',
        ]);
        NiveauIntervontion::create([
            "name" => "Automaticien",
            "description" => "Automatisme",
        ]);
        NiveauIntervontion::create([
            "name" => "Electriciti",
            "description" => "Electriciti",
        ]);
        NiveauIntervontion::create([
            "name" => "Fregoriste",
            "description" => "Fregoriste",
        ]);
    }
}
