<?php

namespace App\Models\Business;

use Illuminate\Database\Eloquent\Model;


class InitInspectionType extends Model
{
    protected $guarded = [];


    public function options(){
        return $this->hasMany(InitInspectionTypeOption::class);
    }
}
