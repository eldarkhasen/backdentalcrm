<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    protected $table = "service_categories";
    protected $guarded = [];
    public function services(){
        return $this->hasMany(Service::class);
    }
}
