<?php

use App\Models\CashFlow\CashFlowOperationType;
use App\Models\CashFlow\CashFlowType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CashFlowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();
        try {
            CashFlowType::insert([
                ['name' => 'Доход',   'description' => ''],
                ['name' => 'Расход',  'description' => ''],
                ['name' => 'Перевод', 'description' => 'Переводы между счетами']
            ]);

            $incomes = CashFlowType::where('name', 'Доход')->first();
            $expenses = CashFlowType::where('name', 'Расход')->first();
            $transfers = CashFlowType::where('name', 'Перевод')->first();

            $incomes->operationTypes()->createMany([
                ['name' => 'Начисление в депозит'],
                ['name' => 'Оказание услуг'],
                ['name' => 'Погашение долга'],
                ['name' => 'Прочие доходы'],
            ]);

            $expenses->operationTypes()->createMany([
                ['name' => 'Снятие с депозита'],
                ['name' => 'Закупка товаров'],
                ['name' => 'Зарплата персонала'],
                ['name' => 'Возврат средств'],
                ['name' => 'Прочие расходы'],
                ['name' => 'Снятие'],
            ]);

            $transfers->operationTypes()->createMany([
                [ 'name' => 'Перевод из кассы' ],
                [ 'name' => 'Перевод в кассу']
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }
}
