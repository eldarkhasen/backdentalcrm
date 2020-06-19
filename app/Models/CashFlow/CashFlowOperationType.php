<?php

namespace App\Models\CashFlow;

use Illuminate\Database\Eloquent\Model;

class CashFlowOperationType extends Model
{
    protected $fillable = ['name'];

    public $timestamps = false;

    public function cashFlowType()
    {
        return $this->belongsTo(
            CashFlowType::class,
            'cash_flow_type_id');
    }
}
