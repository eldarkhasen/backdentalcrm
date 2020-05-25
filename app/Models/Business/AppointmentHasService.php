<?php

namespace App\Models\Business;

use App\Models\Patients\Patient;
use App\Models\Settings\Service;
use Illuminate\Database\Eloquent\Model;

class AppointmentHasService extends Model
{
    protected $fillable = [
        'patient_id',
        'service_id',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }
}
