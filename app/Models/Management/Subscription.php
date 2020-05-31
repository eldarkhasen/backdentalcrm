<?php

namespace App\Models\Management;

use App\Models\Core\Organization;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'actual_price',
        'start_date',
        'end_date',
        'subscription_type_id',
        'organization_id',
    ];

    public function subscriptionType()
    {
        return $this->belongsTo(SubscriptionType::class, 'subscription_type_id', 'id')
            ->withTrashed();
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }
}
