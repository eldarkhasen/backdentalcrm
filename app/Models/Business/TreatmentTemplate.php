<?php

namespace App\Models\Business;

use App\Models\Core\Organization;
use Illuminate\Database\Eloquent\Model;

class TreatmentTemplate extends Model
{
    protected $table = "treatment_templates";

    protected $fillable = [
        'name', 'code', 'organization_id',
    ];

    public function types(){
        return $this->belongsToMany(TreatmentType::class, 'template_options', 'template_id', 'type_id')->distinct();
    }

    public function organization(){
        return $this->belongsTo(Organization::class, 'organization_id');
    }

}
