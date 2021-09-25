<?php

namespace App\Models\Business;

use Illuminate\Database\Eloquent\Model;

class TreatmentTeeth extends Model
{
    protected $table = "treatment_teeth";
    protected $fillable = ['treatment_id', 'tooth_number'];

    public function treatment(){
        return $this->belongsTo(Treatment::class,'treatment_id');
    }
}
