<?php

namespace App\Models\Support;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = [
        'name',
        'timezone',
        'country_id'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }
}
