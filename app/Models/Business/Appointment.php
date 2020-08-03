<?php

namespace App\Models\Business;

use App\Models\Patients\Patient;
use App\Models\Settings\Employee;
use App\Models\Settings\Service;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'title',
        'starts_at',
        'ends_at',
        'price',
        'status',
        'color',
        'employee_id',
        'patient_id',
        'treatment_course_id',
        'is_first_visit',
    ];

    protected $attributes = [
      'status' => 'pending',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'id');
    }

    public function treatmentCourse()
    {
        return $this->belongsTo(TreatmentCourse::class, 'treatment_course_id', 'id');
    }

    public function services(){
        return $this->belongsToMany(Service::class,'appointment_id','id');
    }
}
