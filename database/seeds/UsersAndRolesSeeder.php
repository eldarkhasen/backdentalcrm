<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use \App\Models\Permission;

class UsersAndRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'Администратор',
        ]);

        Role::create([
            'name' => 'Сотрудник',
        ]);

        Role::create([
            'name' => 'Владелец',
        ]);

        $adminUser = User::create([
            'id' => 1,
            'email' => 'admin@mail.ru',
            'password' => bcrypt('password'),
            'role_id' => \App\Models\Role::ADMIN_ID
        ]);
        $adminUser->permissions()->attach(Permission::all());
    }
}
