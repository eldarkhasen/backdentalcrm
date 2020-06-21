<?php

namespace App\Models\Business;

use App\Models\Settings\Employee;
use Illuminate\Database\Eloquent\Model;

class MaterialUsage extends Model
{
    protected $fillable = [
        'material_rest_id',
        'employee_id',
        'quantity',
        'comments',
        'committed'
    ];

    public function materialRest()
    {
        return $this->belongsTo(MaterialRest::class)
            ->with('material');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
