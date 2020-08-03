<?php

namespace App\Models\Settings;

use App\Models\Business\Appointment;
use App\Models\Core\Organization;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $guarded = [];

    public function category(){
        return $this->belongsTo(ServiceCategory::class,'category_id');
    }

    public function employees(){
        return $this->belongsToMany(Employee::class,'employees_has_services');
    }


    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }

    public function appointments(){
        return $this->belongsToMany(Appointment::class,'service_id','id');
    }
}
