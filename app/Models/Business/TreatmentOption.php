<?php

namespace App\Models\Business;

use Illuminate\Database\Eloquent\Model;

class TreatmentOption extends Model
{
    protected $table = "treatment_options";

    protected $fillable = [
        'value', 'is_custom'
    ];

    public function treatmentData(){
        return $this->hasOne(TreatmentData::class, 'option_id');
    }
}
