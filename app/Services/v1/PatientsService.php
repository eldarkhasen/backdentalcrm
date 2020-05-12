<?php


namespace App\Services\v1;
use App\Http\Requests\Api\V1\Patients\StoreAndUpdatePatientApiRequest;

interface PatientsService
{
    public function getAllPaginatedPatients($perPage);
    public function getAllPatientsArray();
    public function searchPaginatedPatients($searchKey, $perPage);
    public function searchPatientsArray($searchKey);
    public function storePatient(StoreAndUpdatePatientApiRequest $request);
    public function updatePatient(StoreAndUpdatePatientApiRequest $request,$id);
    public function deletePatient($id);
    public function getPatientById($id);

}