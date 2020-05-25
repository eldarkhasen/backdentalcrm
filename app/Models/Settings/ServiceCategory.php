<?php

namespace App\Models\Settings;

use App\Models\Core\Organization;
use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    protected $table = "service_categories";
    protected $guarded = [];

    public function services()
    {
        return $this->hasMany(Service::class, 'category_id');
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }
}
