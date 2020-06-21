<?php


namespace App\Services\v1\impl;


use App\Exceptions\ApiServiceException;
use App\Http\Errors\ErrorCode;
use App\Http\Requests\Api\V1\Materials\MaterialDeliveryRequest;
use App\Http\Requests\Api\V1\Materials\MaterialRequest;
use App\Http\Requests\Api\V1\Materials\MaterialRestRequest;
use App\Http\Requests\Api\V1\Materials\MaterialUsageRequest;
use App\Models\Business\Material;
use App\Models\Business\MaterialDelivery;
use App\Models\Business\MaterialRest;
use App\Models\Business\MaterialUsage;
use App\Services\v1\BaseServiceImpl;
use App\Services\v1\MaterialsService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MaterialsServiceImpl
    extends BaseServiceImpl
    implements MaterialsService
{

    public function getAllMaterials()
    {
        return Material::all();
    }

    public function getCurrentOrgMaterialRests()
    {
        $this->validateUserAccess(Auth::user());

        return Auth::user()->employee->organization->materialRests;
    }

    public function storeMaterial(MaterialRequest $request)
    {
        return $this->storeOrUpdateMaterial($request);
    }

    public function updateMaterial(MaterialRequest $request, $id)
    {
        return $this->storeOrUpdateMaterial($request, $id);
    }

    private function storeOrUpdateMaterial(MaterialRequest $request, $id = null)
    {
        $material = null;
        DB::beginTransaction();
        try {
            $this->validateUserAccess($request->user());

            if (!!$id) {
                $material = Material::findOrFail($id);
            } else {
                $material = new Material();
            }

            $material->fill($request->only([
                'name',
                'price',
                'measure_unit',
                'producer',
                'description'
            ]));

            $material->save();

            DB::commit();
        } catch (\Exception $e) {
            $this->onError($e, 'System Error', ErrorCode::SYSTEM_ERROR);
        }

        return $material;
    }


    public function storeMaterialRest(MaterialRestRequest $request)
    {
        return $this->storeOrUpdateMaterialRest($request);
    }

    public function updateMaterialRest(MaterialRestRequest $request, $id)
    {
        return $this->storeOrUpdateMaterialRest($request, $id);
    }

    private function storeOrUpdateMaterialRest(MaterialRestRequest $request, $id = null)
    {
        $rest = null;
        DB::beginTransaction();
        try {
            $this->validateUserAccess($request->user());

            $rest = !!$id ? MaterialRest::findOrFail($id) : new MaterialRest();

            $rest = $this->fillMaterialRest($rest, $request);

            $rest->save();

            DB::commit();
        } catch (\Exception $e) {
            $this->onError($e, 'System Error', ErrorCode::SYSTEM_ERROR);
        }

        return $rest;
    }

    private function fillMaterialRest(MaterialRest $rest, MaterialRestRequest $request)
    {
        $rest->count = $request->count;
        $rest->organization_id = $request->organization['id'];
        $rest->material_id = $request->material['id'];

        return $rest;
    }

    public function storeMaterialUsage(MaterialUsageRequest $request)
    {
        $materialRest = null;



        return $materialRest;
    }

    public function updateMaterialUsage(MaterialUsageRequest $request, $id)
    {
        // TODO: Implement updateMaterialUsage() method.
    }

    public function storeMaterialDelivery(MaterialDeliveryRequest $request)
    {
        $materialRest = null;

        DB::beginTransaction();
        try {
            $this->validateUserAccess($request->user());

            $delivery = new MaterialDelivery();

            $delivery = $this->fillDelivery($delivery, $request);

            $delivery->save();

            $materialRest = $this->commitDelivery($delivery);

            DB::commit();
        } catch (\Exception $e) {
            $this->onError($e, 'System Error', ErrorCode::SYSTEM_ERROR);
        }

        return $materialRest;
    }

    public function updateMaterialDelivery(MaterialDeliveryRequest $request, $id)
    {
        $materialRest = null;

        DB::beginTransaction();
        try {
            $this->validateUserAccess($request->user());

            $delivery = MaterialDelivery::findOrFail($id);

            $this->rollbackDelivery($delivery);

            $delivery = $this->fillDelivery($delivery, $request);

            $delivery->save();

            $materialRest = $this->commitDelivery($delivery);

            DB::commit();
        } catch (\Exception $e) {
            $this->onError($e, 'System Error', ErrorCode::SYSTEM_ERROR);
        }

        return $materialRest;
    }

    private function fillDelivery(
        MaterialDelivery $delivery, MaterialDeliveryRequest $request
    )
    {
        $delivery->fill($request->only([
            'quantity',
            'invoice_number',
            'delivery_date',
            'comments',
        ]));

        $delivery->material_rest_id = $request->get('materialRest')['id'];

        return $delivery;
    }

    public function commitUsage(MaterialUsage $usage)
    {
        // TODO: Implement commitUsage() method.
    }

    public function rollbackUsage(MaterialUsage $usage)
    {
        // TODO: Implement rollbackUsage() method.
    }

    public function commitDelivery(MaterialDelivery $delivery)
    {
        DB::beginTransaction();
        try {
            $this->validateUserAccess(Auth::user());

            if ($delivery->committed) {
                throw new ApiServiceException(400, false, [
                    'errors' => [
                        'Delivery had already been committed.'
                    ],
                    'errorCode' => ErrorCode::ALREADY_REQUESTED
                ]);
            }

            $delivery->materialRest->update([
                'count' => $delivery->materialRest->count + $delivery->quantity
            ]);

            $delivery->update([
               'committed' => true
            ]);

            DB::commit();
        } catch (\Exception $e) {
            $this->onError($e, 'System error', ErrorCode::SYSTEM_ERROR);
        }

        $delivery->load('materialRest');

        return $delivery->materialRest;
    }

    public function rollbackDelivery(MaterialDelivery $delivery)
    {
        DB::beginTransaction();
        try {
            $this->validateUserAccess(Auth::user());

            if (!$delivery->committed) {
                throw new ApiServiceException(400, false, [
                    'errors' => [
                        'Delivery had not been committed yet.'
                    ],
                    'errorCode' => ErrorCode::NOT_ALLOWED
                ]);
            }

            $delivery->materialRest->update([
                'count' => $delivery->materialRest->count - $delivery->quantity
            ]);

            $delivery->update([
                'committed' => false
            ]);

            DB::commit();
        } catch (\Exception $e) {
            $this->onError($e, 'System error', ErrorCode::SYSTEM_ERROR);
        }

        $delivery->load('materialRest');

        return $delivery->materialRest;
    }

    public function deleteMaterial($id)
    {
        return Material::findOrFail($id)->delete();
    }
}