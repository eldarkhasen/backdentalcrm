<?php

namespace App\Models\CashFlow;

use App\Models\Business\Appointment;
use App\Models\Settings\Employee;
use Illuminate\Database\Eloquent\Model;

class CashFlowOperation extends Model
{
    protected $fillable = [
        'from_cash_box_id',
        'to_cash_box_id',
        'type_id',
        'appointment_id',
        'amount',
        'comments',
        'committed',
        'user_created_id',
        'cash_flow_date'
    ];

    public function type(){
        return $this->belongsTo(
            CashFlowOperationType::class,
            'type_id');
    }

    public function fromCashBox(){
        return $this->belongsTo(
            CashBox::class,
            'from_cash_box_id');
    }

    public function toCashBox(){
        return $this->belongsTo(
            CashBox::class,
            'to_cash_box_id');
    }

    public function appointment(){
        return $this->belongsTo(
            Appointment::class,
            'appointment_id'
        )->with([
            'patient', 'employee'
        ]);
    }

    public function employee(){
        return $this->belongsTo(
            Employee::class,
            'user_created_id');
    }
}
