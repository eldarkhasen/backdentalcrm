<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $guarded = [];
    public function employees(){
        return $this->belongsToMany(Employee::class,'employees_has_positions');
    }
}
