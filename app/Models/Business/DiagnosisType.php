<?php

namespace App\Models\Business;

use App\Models\Core\Organization;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiagnosisType extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'diagnosis_id',
        'organization_id',
    ];

    public function diagnosis()
    {
        return $this->belongsTo(Diagnosis::class, 'diagnosis_id', 'id');
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }
}
