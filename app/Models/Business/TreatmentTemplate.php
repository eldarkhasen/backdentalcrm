<?php

namespace App\Models\Business;

use Illuminate\Database\Eloquent\Model;

class TreatmentTemplate extends Model
{
    protected $table = "treatment_templates";

    protected $fillable = [
        'name', 'code',
    ];

    public function types(){
        return $this->belongsToMany(TreatmentType::class, 'template_options', 'template_id', 'type_id')->distinct();
    }

}
