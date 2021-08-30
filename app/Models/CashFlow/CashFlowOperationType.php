<?php

namespace App\Models\CashFlow;

use Illuminate\Database\Eloquent\Model;

class CashFlowOperationType extends Model
{
    const CASH_FLOW_TYPE_SERVICE = 2;
    protected $fillable = [
        'name',
        'cash_flow_type_id',
        'organization_id'
    ];

//    public $timestamps = false;

    public function cashFlowType()
    {
        return $this->belongsTo(
            CashFlowType::class,
            'cash_flow_type_id'
        );
    }

    public function cashFlowOperation(){
        return $this->hasMany(CashFlowOperation::class,'type_id');
    }
}
