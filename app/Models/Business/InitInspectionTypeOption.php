<?php

namespace App\Models\Business;

use Illuminate\Database\Eloquent\Model;

class InitInspectionTypeOption extends Model
{
    protected  $guarded = [];
    protected  $table = "init_inspection_type_options";


    public function initialInspections(){
        return $this->hasMany(InitialInspection::class, 'inspection_option_id');
    }

}
