<?php
/**
 * Created by PhpStorm.
 * User: air
 * Date: 25.05.2020
 * Time: 13:08
 */

namespace App\Services\v1\SubscriptionLogic;


use Illuminate\Http\Request;

interface SubscriptionTypeService
{
    public function getSubscriptionTypes();
    public function storeSubscriptionType(Request $request);
    public function updateSubscriptionType($id,Request $request);
    public function deleteSubscriptionType($id);
    public function restoreSubscriptinType($id);
}
