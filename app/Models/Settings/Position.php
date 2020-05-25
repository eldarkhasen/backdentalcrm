<?php

namespace App\Models\Settings;

use App\Models\Core\Organization;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $guarded = [];

    public function employees(){
        return $this->belongsToMany(Employee::class,'employees_has_positions');
    }


    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }
}
