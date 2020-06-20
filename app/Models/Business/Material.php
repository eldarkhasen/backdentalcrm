<?php

namespace App\Models\Business;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    public function materialUsage(){
        return $this->hasMany(MaterialUsage::class,'material_id','id');
    }

    public function delivery(){
        return $this->hasMany(MaterialDelivery::class,'material_id','id');
    }
}
