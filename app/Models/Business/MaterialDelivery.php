<?php

namespace App\Models\Business;

use Illuminate\Database\Eloquent\Model;

class MaterialDelivery extends Model
{
    protected $fillable = [
        'material_rest_id',
        'invoice_number',
        'quantity',
        'comments',
        'delivery_date',
        'committed'
    ];

    public function materialRest()
    {
        return $this->belongsTo(MaterialRest::class)
            ->with('material');
    }
}
