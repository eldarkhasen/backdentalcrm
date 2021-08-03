<?php

namespace App\Models\Business;

use Illuminate\Database\Eloquent\Model;

class TreatmentData extends Model
{
    protected $table = "treatment_data";

    protected $fillable = [
        'treatment_id', 'template_id', 'type_id',
        'option_id', 'value',
    ];

    public function treatment(){
        return $this->belongsTo(Treatment::class, 'treatment_id');
    }

    public function template(){
        return $this->belongsTo(TreatmentType::class, 'template_id');
    }

    public function type(){
        return $this->belongsTo(TreatmentType::class, 'type_id');
    }

    public function option(){
        return $this->belongsTo(TreatmentOption::class, 'option_id');
    }
}
