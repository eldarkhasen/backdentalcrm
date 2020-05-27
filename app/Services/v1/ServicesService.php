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
    public function getAllServices($org_id, $perPage);
    public function getAllServicesByCategory($org_id,$category_id,$perPage);
    public function getServiceCategories($org_id);
    public function searchServices($org_id,$search_key,$perPage);
    public function searchByCategories($org_id,$category_id,$search_key,$perPage);
    public function getServiceById($id);
    public function deleteCategory($id);
}