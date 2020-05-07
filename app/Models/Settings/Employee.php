<?php

namespace App\Models\Settings;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $guarded = [];

    public function services(){
        return $this->belongsToMany(Service::class,'employees_has_services');
    }

    public function positions(){
        return $this->belongsToMany(Position::class,'employees_has_positions');
    }

    public function account(){
        return $this->belongsTo(User::class,'account_id');
    }

    public function hasAccount(){
        $account = $this->account()->count();

        if($account>=1){
            return true;
        }else{
            return false;
        }
    }

}
