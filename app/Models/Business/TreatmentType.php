<?php

namespace App\Models\Business;

use Illuminate\Database\Eloquent\Model;

class TreatmentType extends Model
{
    protected $table = "treatment_types";

    protected $fillable = [
        'name',
    ];

    public function templates(){
        return $this->belongsToMany(TreatmentTemplate::class, 'template_options', 'type_id', 'template_id');
    }

//    public function template(){
//        return $this->templates()->first();
//    }

    public function options(){
        return $this->belongsToMany(TreatmentOption::class, 'template_options', 'type_id', 'option_id');
    }
}
