<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public const ADMIN_ID = 1;
    public const EMPLOYEE_ID = 2;
    public const OWNER_ID = 3;
    protected $fillable = [
        'name'
    ];
}
