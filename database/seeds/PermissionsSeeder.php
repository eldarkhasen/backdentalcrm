<?php

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'employees', 'alias'=>'Сотрудники']);
        Permission::create(['name' => 'finance','alias'=>'Финансы']);
        Permission::create(['name' => 'schedule','alias'=>'График']);
        Permission::create(['name' => 'patients','alias'=>'Пациенты']);
        Permission::create(['name' => 'services','alias'=>'Услуги']);
        Permission::create(['name' => 'materials','alias'=>'Материалы']);
        Permission::create(['name' => 'protocols','alias'=>'Шаблоны протоколов']);
    }
}
