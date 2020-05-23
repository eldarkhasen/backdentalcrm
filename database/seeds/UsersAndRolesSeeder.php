<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

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

        User::create([
            'id' => 1,
            'email' => 'admin@mail.ru',
            'password' => bcrypt('password'),
            'role_id' => \App\Models\Role::ADMIN_ID
        ]);
    }
}
