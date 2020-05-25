<?php

namespace App\Models\Core;

use App\Models\Management\Subscription;
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

    public function subscriptions(){
        return $this->hasMany(Subscription::class,'organization_id','id')->orderBy('created_at');
    }

//    public function getCurrentSubscription(){
//        return $this->subscriptions()->orderBy('created_at','desc')->first()->get();
//    }

    public function getCurrentSubscription(){
        return $this->relationLoaded('subscriptions')
            ? $this->subscriptions->last()
            : $this->subscriptions()->latest()->get();
    }

}
