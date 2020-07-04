<?php

namespace App\Models\Core;

use App\Models\Business\MaterialRest;
use App\Models\CashFlow\CashBox;
use App\Models\CashFlow\CashFlowOperationType;
use App\Models\Management\Subscription;
use App\Models\Patients\Patient;
use App\Models\Settings\Employee;
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
        'email',
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'organization_id', 'id')
            ->with('subscriptionType')
            ->orderBy('created_at');
    }

    public function currentSubscription()
    {
        return $this->hasOne(Subscription::class, 'organization_id', 'id')
            ->with('subscriptionType')
            ->latest();
    }

    public function getCurrentSubscription()
    {
        return $this->relationLoaded('subscriptions')
            ? $this->subscriptions->last()
            : $this->subscriptions()->latest()->get();
    }

    public function scopeSearch($query, $search_key)
    {
        return $query->where('name', 'LIKE', '%' . $search_key . '%')
            ->orWhere('address', 'LIKE', '%' . $search_key . '%')
            ->orWhere('phone', 'LIKE', '%' . $search_key . '%');
    }

    public function patients()
    {
        return $this->belongsToMany(Patient::class, 'organization_patients');
    }

    public function cashBoxes()
    {
        return $this->hasMany(CashBox::class);
    }

    public function cashFlowOperationTypes(){
        return $this->hasMany(CashFlowOperationType::class);
    }

    public function materialRests()
    {
        return $this->hasMany(MaterialRest::class)
            ->with('material');
    }
}
