<?php

namespace App\Models\CashFlow;

use App\Models\Core\Organization;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CashBox extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'balance',
        'organization_id',
        'is_main'
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
