<?php

namespace App\Models\Business;

use App\Models\Patients\Patient;
use App\Models\Settings\Service;
use Illuminate\Database\Eloquent\Model;

class AppointmentHasService extends Model
{
    protected $fillable = [
        'appointment_id',
        'service_id',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class, 'appointment_id', 'id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }
}
