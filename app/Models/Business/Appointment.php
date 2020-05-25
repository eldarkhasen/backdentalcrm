<?php

namespace App\Models\Business;

use App\Models\Patients\Patient;
use App\Models\Settings\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'title',
        'start_date',
        'end_date',
        'price',
        'status',
        'color',
        'employee_id',
        'patient_id',
        'treatment_course_id',
        'is_first_visit',
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

}
