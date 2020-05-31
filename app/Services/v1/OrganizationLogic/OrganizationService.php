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
    public function getAllPaginatedOrganizations($perPage);

    public function getAllOrganizationsArray();

    public function searchPaginatedOrganizations($searchKey, $perPage);

    public function searchOrganizationsArray($search_key);

    public function getAllOrganizations($withRelations = [], $withTrashed = false);

    public function getOrganizationById($org_id);

    public function getCurrentSubscriptionType($org_id);

    public function storeOrganization(Request $request);

    public function updateOrganization($org_id, Request $request);

    public function getCurrentSubscriptionOfOrganization($org_id);

    public function deleteOrganization($org_id);

    public function addSubscription($org_id, Request $request);

    public function addEmployee($org_id, Request $request);

    public function restoreOrganization($id);
}
