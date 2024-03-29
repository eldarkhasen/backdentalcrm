<?php

namespace App\Models\Settings;

use App\Models\CashFlow\CashFlowOperation;
use App\Models\Core\Organization;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{

    use SoftDeletes;

    protected $guarded = [];

    public function services()
    {
        return $this->belongsToMany(Service::class, 'employees_has_services');
    }

    public function positions()
    {
        return $this->belongsToMany(Position::class, 'employees_has_positions');
    }

    public function account()
    {
        return $this->belongsTo(User::class, 'account_id');
    }

    public function hasAccount()
    {
        $account = $this->account()->count();

        if ($account >= 1) {
            return true;
        } else {
            return false;
        }
    }

    public function organization()
    {
        return $this->belongsTo(
            Organization::class, 'organization_id', 'id'
        );
    }

    public function cashFlowOperation(){
        return $this->hasMany(CashFlowOperation::class,'user_created_id');
    }

}
