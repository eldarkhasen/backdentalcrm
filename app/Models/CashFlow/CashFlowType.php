<?php

namespace App\Models\CashFlow;

use Illuminate\Database\Eloquent\Model;
const INCOME = 1;
const EXPANSE = 2;
class CashFlowType extends Model
{
    protected $fillable = [
        'name',
        'description'
    ];

    public function operationTypes()
    {
        return $this->hasMany(
          CashFlowOperationType::class,
          'cash_flow_type_id'
        );
    }
}
