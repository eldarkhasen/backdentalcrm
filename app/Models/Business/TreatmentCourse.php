<?php

namespace App\Models\Business;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TreatmentCourse extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'title',
        'is_finished'
    ];
}
