<?php

namespace App\Models\Core;

use App\Models\Management\Subscription;
use App\Models\Settings\Employee;
use App\Models\Support\City;
use Faker\Provider\DateTime;
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
        'deleted',
        'email',
    ];

    public function employees(){
        return $this->hasMany(Employee::class);
    }
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }

    public function subscriptions(){
        return $this->hasMany(Subscription::class,'organization_id','id')
            ->with('subscriptionType')
            ->orderBy('created_at');
    }

//    public function getCurrentSubscription(){
//        return $this->subscriptions()->orderBy('created_at','desc')->first()->get();
//    }

    public function currentSubscription(){
        return $this->hasOne(Subscription::class,'organization_id','id')
            ->latest();
    }

    public function getCurrentSubscription(){
        return $this->relationLoaded('subscriptions')
            ? $this->subscriptions->last()
            : $this->subscriptions()->latest()->get();
    }

    public function scopeSearch($query, $search_key) {
        return $query->where('name', 'LIKE', '%'.$search_key.'%')
            ->orWhere('address', 'LIKE', '%'.$search_key.'%')
            ->orWhere('phone', 'LIKE', '%'.$search_key.'%');
    }

    public function makeDeleted() {
        return $this->update([
           'deleted' => 1,
        ]);
    }
}
