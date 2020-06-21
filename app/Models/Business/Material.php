<?php

namespace App\Models\Business;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Material extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'price',
        'measure_unit',
        'producer',
        'description'
    ];

    public function materialUsage()
    {
        return $this->hasMany(MaterialUsage::class);
    }

    public function delivery()
    {
        return $this->hasMany(MaterialDelivery::class);
    }
}
