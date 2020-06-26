<?php

namespace App\Models\Business;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaterialDelivery extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'material_rest_id',
        'invoice_number',
        'quantity',
        'comments',
        'delivery_date',
        'committed'
    ];

    protected $dates = [
        'delivery_date',
    ];

    public function materialRest()
    {
        return $this->belongsTo(MaterialRest::class)
            ->with('material');
    }
}
