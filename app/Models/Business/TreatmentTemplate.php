<?php

namespace App\Models\Business;

use Illuminate\Database\Eloquent\Model;

class TreatmentTemplate extends Model
{
    protected $table = "treatment_templates";

    protected $fillable = [
        'name', 'code',
    ];

}
