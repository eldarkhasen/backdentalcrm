<?php

namespace App\Models\CashFlow;

use Illuminate\Database\Eloquent\Model;

class CashBox extends Model
{
    protected $fillable = [
        'name',
        'balance'
    ];
}
