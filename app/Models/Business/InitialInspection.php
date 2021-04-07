<?php

namespace App\Models\Business;

use Illuminate\Database\Eloquent\Model;

class InitialInspection extends Model
{
    protected $fillable = [
        'appointment_id',
        'inspection_type_id',
        'inspection_option_id'
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class, 'appointment_id', 'id');
    }

    public function inspectionType(){
        return $this->belongsTo(InitInspectionType::class,'inspection_type_id');
    }
    public function inspectionTypeOption(){
        return $this->belongsTo(InitInspectionTypeOption::class,'inspection_option_id');
    }
}
