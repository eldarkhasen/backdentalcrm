<?php

namespace App\Models\Business;

use App\Models\Core\Organization;
use Illuminate\Database\Eloquent\Model;

class MaterialRest extends Model
{
    protected $fillable = [
        'material_id',
        'organization_id',
        'count'
    ];

    public $timestamps = false;

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function usages()
    {
        return $this->hasMany(MaterialUsage::class);
    }

    public function deliveries()
    {
        return $this->hasMany(MaterialDelivery::class);
    }
}
