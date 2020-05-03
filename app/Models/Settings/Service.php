<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $guarded = [];
    public function category(){
        return $this->belongsTo(ServiceCategory::class,'category_id');
    }
}
