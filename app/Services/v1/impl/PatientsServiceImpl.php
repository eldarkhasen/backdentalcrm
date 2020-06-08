<?php
/**
 * Created by PhpStorm.
 * User: eldarkhasen
 * Date: 5/1/20
 * Time: 14:36
 */

namespace App\Services\v1\impl;


use App\Exceptions\ApiServiceException;
use App\Http\Errors\ErrorCode;
use App\Http\Requests\Api\V1\Patients\StoreAndUpdatePatientApiRequest;
use App\Models\Core\OrganizationPatient;
use App\Models\Patients\Patient;
use App\Services\v1\PatientsService;
use Illuminate\Support\Facades\DB;

class PatientsServiceImpl implements PatientsService
{

    public function getAllPaginatedPatients($perPage)
    {
        return Patient::paginate($perPage);
    }

    public function getAllPatientsArray($currentUser)
    {
        if (!($currentUser->isEmployee() || $currentUser->isOwner())) {
            throw new ApiServiceException(400, false, [
                'errors' => [
                    'You are not allowed to do so'
                ],
                'errorCode' => ErrorCode::NOT_ALLOWED
            ]);
        }

        $currentUser->load(['employee', 'employee.organization', 'employee.organization.patients']);
        if (!($currentUser->employee && $currentUser->employee->organization)) {
            throw new ApiServiceException(400, false, [
                'errors' => [
                    'You are not allowed to do so'
                ],
                'errorCode' => ErrorCode::NOT_ALLOWED
            ]);
        }
        return $currentUser->employee->organization->patients;
    }

    public function searchPaginatedPatients($currentUser,$search_key, $perPage)
    {
        if (!($currentUser->isEmployee() || $currentUser->isOwner())) {
            throw new ApiServiceException(400, false, [
                'errors' => [
                    'You are not allowed to do so'
                ],
                'errorCode' => ErrorCode::NOT_ALLOWED
            ]);
        }

        $currentUser->load(['employee', 'employee.organization', 'employee.organization.patients']);
        if (!($currentUser->employee && $currentUser->employee->organization)) {
            throw new ApiServiceException(400, false, [
                'errors' => [
                    'You are not allowed to do so'
                ],
                'errorCode' => ErrorCode::NOT_ALLOWED
            ]);
        }

        return $currentUser->employee->organization->patients()->where('name', 'LIKE', '%' . $search_key . '%')
            ->orWhere('surname', 'LIKE', '%' . $search_key . '%')
            ->orWhere('patronymic', 'LIKE', '%' . $search_key . '%')
            ->orWhere('id_card', 'LIKE', '%' . $search_key . '%')
            ->orWhere('phone', 'LIKE', '%' . $search_key . '%')
            ->paginate($perPage);
    }

    public function searchPatientsArray($currentUser,$search_key)
    {
        if (!($currentUser->isEmployee() || $currentUser->isOwner())) {
            throw new ApiServiceException(400, false, [
                'errors' => [
                    'You are not allowed to do so'
                ],
                'errorCode' => ErrorCode::NOT_ALLOWED
            ]);
        }

        $currentUser->load(['employee', 'employee.organization', 'employee.organization.patients']);
        if (!($currentUser->employee && $currentUser->employee->organization)) {
            throw new ApiServiceException(400, false, [
                'errors' => [
                    'You are not allowed to do so'
                ],
                'errorCode' => ErrorCode::NOT_ALLOWED
            ]);
        }

        return $currentUser->employee->organization->patients()->where('name', 'LIKE', '%' . $search_key . '%')
            ->orWhere('surname', 'LIKE', '%' . $search_key . '%')
            ->orWhere('patronymic', 'LIKE', '%' . $search_key . '%')
            ->orWhere('id_card', 'LIKE', '%' . $search_key . '%')
            ->orWhere('phone', 'LIKE', '%' . $search_key . '%')->get();
    }

    public function storePatient(StoreAndUpdatePatientApiRequest $request, $currentUser)
    {
        DB::beginTransaction();
        try {
            if (!($currentUser->isEmployee() || $currentUser->isOwner())) {
                throw new ApiServiceException(400, false, [
                    'errors' => [
                        'You are not allowed to do so'
                    ],
                    'errorCode' => ErrorCode::NOT_ALLOWED
                ]);
            }

            $currentUser->load(['employee', 'employee.organization']);

            if (!($currentUser->employee && $currentUser->employee->organization)) {
                throw new ApiServiceException(400, false, [
                    'errors' => [
                        'You are not allowed to do so',
                    ],
                    'errorCode' => ErrorCode::NOT_ALLOWED
                ]);
            }

            $patient = Patient::create($request->all());

            $currentUser->employee->organization->patients()->attach($patient);
            DB::commit();
            return $patient;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new ApiServiceException(400, false, [
                'errors' => [
                    'System error',
                    $e->getMessage()
                ],
                'errorCode' => ErrorCode::SYSTEM_ERROR
            ]);
        }
    }

    public function updatePatient(StoreAndUpdatePatientApiRequest $request, $id)
    {
        $patient = Patient::findOrFail($id);
        return $patient->update($request->all());
    }

    public function deletePatient($id)
    {
        // TODO: Implement deletePatient() method.
    }

    public function getPatientById($id)
    {
        return Patient::findOrFail($id);
    }

    public function getAllPatientsByOrganization($currentUser,$perPage)
    {
        if (!($currentUser->isEmployee() || $currentUser->isOwner())) {
            throw new ApiServiceException(400, false, [
                'errors' => [
                    'You are not allowed to do so'
                ],
                'errorCode' => ErrorCode::NOT_ALLOWED
            ]);
        }

        $currentUser->load(['employee', 'employee.organization', 'employee.organization.patients']);
        if (!($currentUser->employee && $currentUser->employee->organization)) {
            throw new ApiServiceException(400, false, [
                'errors' => [
                    'You are not allowed to do so'
                ],
                'errorCode' => ErrorCode::NOT_ALLOWED
            ]);
        }

        return $currentUser->employee->organization->patients()->paginate($perPage);
    }

    public function connectPatientToOrganization($organization_id, $patient_id)
    {
        OrganizationPatient::updateOrCreate([
            'organization_id' => $organization_id,
            'patient_id' => $patient_id
        ]);
    }

}