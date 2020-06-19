<?php

namespace App\Models\CashFlow;

use App\Models\Business\Appointment;
use Illuminate\Database\Eloquent\Model;

class CashFlowOperation extends Model
{
    public function type(){
        return $this->belongsTo(
            CashFlowOperationType::class,
            'type_id');
    }

    public function sourceCashBox(){
        return $this->belongsTo(
            CashBox::class,
            'from_cash_box_id');
    }

    public function destinationCashBox(){
        return $this->belongsTo(
            CashBox::class,
            'to_cash_box_id');
    }

    public function appointment(){
        return $this->belongsTo(
            Appointment::class,
            'appointment_id');
    }
}
