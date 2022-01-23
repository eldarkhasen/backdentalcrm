<?php

namespace App\Models\Patients;

use App\Models\Core\OrganizationPatient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    public function organizations()
    {
        return $this->belongsToMany(OrganizationPatient::class, "organization_patients");
    }

}
