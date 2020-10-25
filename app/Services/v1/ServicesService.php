<?php
/**
 * Created by PhpStorm.
 * User: eldarkhasen
 * Date: 5/1/20
 * Time: 14:36
 */

namespace App\Services\v1;


interface ServicesService
{
    public function getAllServices($currentUser, $perPage);

    public function getAllServicesArray($currentUser, $except_id);

    public function getAllServicesByCategory($currentUser, $category_id, $perPage);

    public function getServiceCategories($currentUser);

    public function searchServices($currentUser, $search_key, $perPage);

    public function searchByCategories($currentUser, $category_id, $search_key, $perPage);

    public function getServiceById($id);

    public function deleteCategory($id);

    public function storeServiceCategory($currentUser, $request);

    public function storeService($currentUser, $request);

    public function updateServiceCategory($currentUser, $request, $id);

    public function updateService($currentUser, $request, $id);
}