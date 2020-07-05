<?php


namespace App\Services\v1;


use App\Http\Requests\Api\V1\Materials\MaterialDeliveryRequest;
use App\Http\Requests\Api\V1\Materials\MaterialRequest;
use App\Http\Requests\Api\V1\Materials\MaterialRestRequest;
use App\Http\Requests\Api\V1\Materials\MaterialUsageRequest;
use App\Models\Business\MaterialDelivery;
use App\Models\Business\MaterialUsage;
use Illuminate\Http\Request;

interface MaterialsService
{
    public function getAllMaterials();

    public function getCurrentOrgMaterialRests();

    public function getMaterialById($id);

    public function storeMaterial(MaterialRequest $request);

    public function updateMaterial(MaterialRequest $request, $id);

    public function storeMaterialRest(MaterialRestRequest $request);

    public function updateMaterialRest(MaterialRestRequest $request, $id);

    public function storeMaterialUsage(MaterialUsageRequest $request);

    public function updateMaterialUsage(MaterialUsageRequest $request, $id);

    public function deleteMaterialUsage($id);

    public function storeMaterialDelivery(MaterialDeliveryRequest $request);

    public function updateMaterialDelivery(MaterialDeliveryRequest $request, $id);

    public function deleteMaterialDelivery($id);

    public function commitUsage(MaterialUsage $usage);

    public function rollbackUsage(MaterialUsage $usage);

    public function commitDelivery(MaterialDelivery $delivery);

    public function rollbackDelivery(MaterialDelivery $delivery);

    public function deleteMaterial($id);

    public function getCurrentOrgMaterialUsages(Request $request);

    public function getCurrentOrgMaterialDeliveries(Request $request);

    public function getMaterialUsage($id);

    public function getMaterialDelivery($id);
}