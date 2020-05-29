<?php

namespace App\Models\Management;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubscriptionType extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'name',
        'price',
        'expiration_days',
        'employees_count',
        'deleted'
    ];

    public function makeDeleted() {
        return $this->update([
            'deleted' => 1,
        ]);
    }
}
