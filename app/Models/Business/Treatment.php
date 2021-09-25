<?php

namespace App\Models\Business;

use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    protected $fillable = [
        'appointment_id',
        'diagnosis_id',
        'diagnosis_type_id',
        'tooth_number',
        'patient_problems',
        'xray_data',
        'work_done',
        'recommendations',
        'comments',
        'treatment_plan',
        'objective_data',
        'is_finished',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class, 'appointment_id', 'id');
    }

    public function diagnosis()
    {
        return $this->belongsTo(Diagnosis::class, 'diagnosis_id', 'id');
    }

    public function diagnosisType()
    {
        return $this->belongsTo(DiagnosisType::class, 'diagnosis_type_id', 'id');
    }

    public function treatmentDates(){
        return $this->hasMany(TreatmentData::class, 'treatment_id');
    }

    public function templates(){
        return $this->belongsToMany(TreatmentTemplate::class, TreatmentData::class, 'treatment_id', 'template_id')->distinct();
    }

    public function teeth(){
        return $this->hasMany(TreatmentTeeth::class,'treatment_id');
    }
}
