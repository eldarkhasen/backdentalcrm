<?php

namespace App\Models\Business;

use Illuminate\Database\Eloquent\Model;

class InitialInspection extends Model
{
    protected $fillable = [
        'appointment_id',
        'anamnesis_vitae',
        'anamnesis_morbi',
        'visual_inspection',
        'bite',
        'mucosal_conditions'
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class, 'appointment_id', 'id');
    }
}
