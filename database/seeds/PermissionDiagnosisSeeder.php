<?php


use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionDiagnosisSeeder extends Seeder
{
    public function run()
    {
        Permission::create(['name' => 'diagnosis', 'alias'=>'Диагнозы']);
    }
}
