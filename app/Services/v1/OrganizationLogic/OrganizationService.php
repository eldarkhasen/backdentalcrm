<?php
/**
 * Created by PhpStorm.
 * User: air
 * Date: 25.05.2020
 * Time: 13:07
 */

namespace App\Services\v1\OrganizationLogic;


use Illuminate\Http\Request;

interface OrganizationService
{
    public function getAllOrganizations(Request $request);
    public function getOrganizationById($org_id);
    public function getCurrentSubscription($org_id);
    public function storeOrganization(Request $request);
    public function updateOrganization($org_id, Request $request);
}