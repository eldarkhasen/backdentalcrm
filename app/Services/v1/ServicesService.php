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
    public function getAllServices();
    public function getAllServicesByCategory($category_id);
    public function getServiceCategories();
    public function searchServices($search_key);
    public function searchByCategories($category_id,$search_key);
    public function getServiceById($id);
    public function deleteCategory($id);
}