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
//        DB::beginTransaction();
        CashFlowType::insert([
            ['id' => 1, 'name' => 'Доход', 'description' => ''],
            ['id' => 2,'name' => 'Расход', 'description' => ''],
            ['id' => 3,'name' => 'Перевод', 'description' => 'Переводы между счетами']
        ]);

//            $incomes->operationTypes()->createMany([
//                ['name' => 'Начисление в депозит'],
//                ['name' => 'Оказание услуг'],
//                ['name' => 'Погашение долга'],
//                ['name' => 'Прочие доходы'],
//            ]);
        CashFlowOperationType::insert([
            ['id'=>1,'name' => 'Начисление в депозит', 'cash_flow_type_id'=>1],
            ['id'=>2,'name' => 'Оказание услуг','cash_flow_type_id'=>1],
            ['id'=>3,'name' => 'Погашение долга','cash_flow_type_id'=>1],
            ['id'=>4,'name' => 'Прочие доходы','cash_flow_type_id'=>1]
            ]
        );
        CashFlowOperationType::insert(
            [
            ['id'=>5,'name' => 'Снятие с депозита','cash_flow_type_id'=>2],
            ['id'=>6,'name' => 'Закупка товаров','cash_flow_type_id'=>2],
            ['id'=>7,'name' => 'Зарплата персонала','cash_flow_type_id'=>2],
            ['id'=>8,'name' => 'Возврат средств','cash_flow_type_id'=>2],
            ['id'=>9,'name' => 'Прочие расходы','cash_flow_type_id'=>2],
            ['id'=>10,'name' => 'Снятие','cash_flow_type_id'=>2],
                ]
        );

        CashFlowOperationType::insert([
            ['id'=>11,'name' => 'Перевод между кассами','cash_flow_type_id'=>3]
            ]
        );
//        try {
//
//
////            DB::commit();
//        } catch (\Exception $e) {
////            DB::rollBack();
//        }
    }
}
