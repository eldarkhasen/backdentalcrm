<?php

namespace App\Models\Business;

use Illuminate\Database\Eloquent\Model;

class TreatmentType extends Model
{
    protected $table = "treatment_types";

    protected $fillable = [
        'name',
    ];

    public function template(){
        return $this->belongsToMany(TreatmentTemplate::class, 'template_options', 'type_id', 'template_id')->distinct();
    }
}
