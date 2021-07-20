<?php

namespace App\Models\Business;

use Illuminate\Database\Eloquent\Model;

class TemplateOption extends Model
{
    protected $table = "template_options";

    protected $fillable = [
        'template_id', 'type_id', 'option_id',
    ];

    public function template(){
        return $this->belongsTo(TreatmentTemplate::class, 'template_id');
    }

    public function type(){
        return $this->belongsTo(TreatmentType::class, 'type_id');
    }

    public function option(){
        return $this->belongsTo(TreatmentOption::class, 'option_id');
    }
}
