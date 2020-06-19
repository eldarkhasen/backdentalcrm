<?php

namespace App\Models\Business;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TreatmentCourse extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'is_finished'
    ];

    protected $attributes = [
        'is_finished' => false,
    ];
}
