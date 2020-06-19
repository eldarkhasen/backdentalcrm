<?php

namespace App\Models\Patients;

use App\Models\Core\OrganizationPatient;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $guarded = [];

    public function organizations()
    {
        return $this->belongsToMany(OrganizationPatient::class, "organization_patients");
    }

}
