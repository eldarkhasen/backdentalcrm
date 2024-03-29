<?php

namespace App\Models\Business;

use App\Models\CashFlow\CashFlowOperation;
use App\Models\Patients\Patient;
use App\Models\Settings\Employee;
use App\Models\Settings\Service;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{

    use SoftDeletes;
    public const STATUS_PENDING  ='pending';
    public const STATUS_CLIENT_MISS = 'client_miss';
    public const STATUS_SUCCESS = 'success';
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
        return $this->belongsToMany(Service::class,'appointment_has_services','appointment_id', 'service_id')->withPivot(['amount','service_id','appointment_id', 'actual_price', 'discount']);
    }

    public function servicesOnlyId()
    {
        return $this->services->pluck('id');
    }

    public function initialInspections(){
        return $this->hasMany(InitialInspection::class);
    }

    public function initialInspection(){
        return $this->hasOne(InitialInspection::class);
    }

    public function initialInspectionTypes(){
        return $this->belongsToMany(InitInspectionType::class, 'initial_inspections', 'appointment_id', 'inspection_type_id')->distinct();
    }

    public  function cashFlowOperation(){
        return $this->hasOne(CashFlowOperation::class);
    }

    public function treatments(){
        return $this->hasMany(Treatment::class);
    }
}
