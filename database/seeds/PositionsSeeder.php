<?php

use App\Models\Settings\Position;
use Illuminate\Database\Seeder;

class PositionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Position::create(['name'=>'Врач-терапевт','description'=>'Просто лечит людей']);
        Position::create(['name'=>'Хирург','description'=>'Умеет делать операции']);
        Position::create(['name'=>'Администратор','description'=>'Следит за порядком в клинике']);

    }
}
