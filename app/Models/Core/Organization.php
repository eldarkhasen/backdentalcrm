<?php

namespace App\Models\Core;

use App\Models\Support\City;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organization extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'address',
        'phone',
        'city_id',
    ];

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }
}
