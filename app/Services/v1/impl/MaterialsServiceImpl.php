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
use Illuminate\Http\Request;
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

    public function getMaterialById($id)
    {
        return Material::findOrFail($id);
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
        $rest->organization_id = $request->user()->employee->organization_id;
        $rest->material_id = $request->input('material.id');

        return $rest;
    }

    public function storeMaterialUsage(MaterialUsageRequest $request)
    {
        $materialRest = null;

        DB::beginTransaction();
        try {
            $this->validateUserAccess($request->user());

            $usage = new MaterialUsage();

            $usage = $this->fillUsage($usage, $request);

            $usage->save();

            $materialRest = $this->commitUsage($usage);

            DB::commit();
        } catch (\Exception $e) {
            $this->onError($e, 'System Error', ErrorCode::SYSTEM_ERROR);
        }

        return $materialRest;
    }

    public function updateMaterialUsage(MaterialUsageRequest $request, $id)
    {
        $materialRest = null;

        DB::beginTransaction();
        try {
            $this->validateUserAccess($request->user());

            $usage = MaterialUsage::findOrFail($id);

            $this->rollbackUsage($usage);

            $usage = $this->fillUsage($usage, $request);

            $usage->save();

            $materialRest = $this->commitUsage($usage);

            DB::commit();
        } catch (\Exception $e) {
            $this->onError($e, 'System Error', ErrorCode::SYSTEM_ERROR);
        }

        return $materialRest;
    }

    private function fillUsage(
        MaterialUsage $usage, MaterialUsageRequest $request
    )
    {
        $usage->fill($request->only([
            'quantity',
            'comments',
        ]));

        $usage->material_rest_id = $request->input('materialRest.id');
        $usage->employee_id = $request->get('employee.id', $request->user()->employee->id);

        return $usage;
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

        $delivery->material_rest_id = $request->input('materialRest.id');

        return $delivery;
    }

    public function commitUsage(MaterialUsage $usage)
    {
        DB::beginTransaction();
        try {
            $this->validateUserAccess(Auth::user());

            if ($usage->committed) {
                throw new ApiServiceException(400, false, [
                    'errors' => [
                        'Usage had already been committed.'
                    ],
                    'errorCode' => ErrorCode::ALREADY_REQUESTED
                ]);
            }

            $usage->materialRest->update([
                'count' => $usage->materialRest->count - $usage->quantity
            ]);

            $usage->update([
                'committed' => true
            ]);

            DB::commit();
        } catch (\Exception $e) {
            $this->onError($e, 'System error', ErrorCode::SYSTEM_ERROR);
        }

        $usage->load('materialRest');

        return $usage->materialRest;
    }

    public function rollbackUsage(MaterialUsage $usage)
    {
        DB::beginTransaction();
        try {
            $this->validateUserAccess(Auth::user());

            if (!$usage->committed) {
                throw new ApiServiceException(400, false, [
                    'errors' => [
                        'Usage had not been committed yet.'
                    ],
                    'errorCode' => ErrorCode::NOT_ALLOWED
                ]);
            }

            $usage->materialRest->update([
                'count' => $usage->materialRest->count + $usage->quantity
            ]);

            $usage->update([
                'committed' => false
            ]);

            DB::commit();
        } catch (\Exception $e) {
            $this->onError($e, 'System error', ErrorCode::SYSTEM_ERROR);
        }

        $usage->load('materialRest');

        return $usage->materialRest;
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

    public function deleteMaterialUsage($id)
    {
        $usage = MaterialUsage::findOrFail($id);

        $rest = $this->rollbackUsage($usage);

        $usage->delete();

        return $rest;
    }

    public function deleteMaterialDelivery($id)
    {
        $delivery = MaterialDelivery::findOrFail($id);

        $rest = $this->rollbackDelivery($delivery);

        $delivery->delete();

        return $rest;
    }

    public function getCurrentOrgMaterialDeliveries(Request $request)
    {
        $this->validateUserAccess(Auth::user());

        $per_page = $request->get('perPage',20);
        $search_key = $request->get('searchKey',null);
        $from_date = $request->get('fromDate',null);
        $to_date = $request->get('toDate',null);


        $query = MaterialDelivery::with(['materialRest'])
            ->whereHas('materialRest.organization', function ($query) {
                $query->where('id', Auth::user()->employee->organization->id);
            });

        if (isset($search_key)) {
            $query->whereHas('materialRest.material', function ($q) use ($search_key) {
                $q->where('name', 'like', '%' . $search_key . '%');
            });
        }

        if (isset($from_date)) {
            $query->whereDate('created_at', '>=', $from_date);
        }

        if (isset($to_date)) {
            $query->whereDate('created_at', '<=', $to_date);
        }

        return $query->paginate($per_page);
    }

    public function getCurrentOrgMaterialUsages(Request $request)
    {
        $this->validateUserAccess(Auth::user());

        $per_page = $request->input('perPage',20);
        $search_key = $request->input('searchKey',null);
        $from_date = $request->get('fromDate',null);
        $to_date = $request->get('toDate',null);
        $employee_ids = $request->get('employee_ids',null);

        $query = MaterialUsage::with(['employee', 'materialRest'])
                    ->whereHas('employee.organization', function ($query) {
                        $query->where('id', Auth::user()->employee->organization->id);
                    });

        if (isset($search_key)) {
            $query->whereHas('materialRest.material', function ($q) use ($search_key) {
                $q->where('name', 'like', '%' . $search_key . '%');
            });
        }

        if (isset($from_date)) {
            $query->whereDate('created_at', '>=', $from_date);
        }

        if (isset($to_date)) {
            $query->whereDate('created_at', '<=', $to_date);
        }

        if (isset($employee_ids) && count($employee_ids) > 0) {
            $query->whereHas('employee', function ($q) use ($employee_ids) {
                $q->whereIn('id', $employee_ids);
            });
        }

        return $query->paginate($per_page);
    }

    public function getMaterialUsage($id)
    {
        return MaterialUsage::findOrFail($id);
    }

    public function getMaterialDelivery($id)
    {
        return MaterialDelivery::findOrFail($id);
    }
}