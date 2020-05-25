<?php
/**
 * Created by PhpStorm.
 * User: air
 * Date: 25.05.2020
 * Time: 13:07
 */

namespace App\Services\v1\SubscriptionLogic;


use Illuminate\Http\Request;

interface SubscriptionService
{
    public function storeSubscription(Request $request);
    public function updateSubscription($id, Request $request);
}