<?php

namespace App\Models\Business;

use App\Models\Core\Organization;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Diagnosis extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'organization_id',
    ];


    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }

    public function types(){
        return $this->hasMany(DiagnosisType::class, 'diagnosis_id');
    }
}
