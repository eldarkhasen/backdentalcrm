<?php
/**
 * Created by PhpStorm.
 * User: eldarkhasen
 * Date: 5/1/20
 * Time: 14:36
 */

namespace App\Services\v1\impl;





use App\Http\Requests\Api\V1\Patients\StoreAndUpdatePatientApiRequest;
use App\Models\Patients\Patient;
use App\Services\v1\PatientsService;

class PatientsServiceImpl implements PatientsService
{

    public function getAllPaginatedPatients($perPage)
    {
        return Patient::paginate($perPage);
    }

    public function getAllPatientsArray()
    {
        return Patient::all();
    }

    public function searchPaginatedPatients($search_key, $perPage)
    {
        return Patient::where('name', 'LIKE', '%'.$search_key.'%')
            ->orWhere('surname', 'LIKE', '%'.$search_key.'%')
            ->orWhere('patronymic', 'LIKE', '%'.$search_key.'%')
            ->orWhere('id_card', 'LIKE', '%'.$search_key.'%')
            ->orWhere('phone', 'LIKE', '%'.$search_key.'%')
            ->paginate($perPage);
    }

    public function searchPatientsArray($search_key)
    {
        return Patient::where('name', 'LIKE', '%'.$search_key.'%')
            ->orWhere('surname', 'LIKE', '%'.$search_key.'%')
            ->orWhere('patronymic', 'LIKE', '%'.$search_key.'%')
            ->orWhere('id_card', 'LIKE', '%'.$search_key.'%')
            ->orWhere('phone', 'LIKE', '%'.$search_key.'%')->get();
    }

    public function storePatient(StoreAndUpdatePatientApiRequest $request)
    {
        return Patient::create($request->all());
//         return Patient::create([
//            "name" => $request->name,
//            "surname" => $request->surname,
//            "patronymic" => $request->patronymic,
//            'phone' => $request->phone,
//            'birth_date' => $request->birth_date,
//            'gender' => $request->gender,
//            "id_card" => $request->id_card,
//            "id_number" => $request->id_number,
//            "city" => $request->city,
//            "address" => $request->address,
//            "workplace" => $request->workplace,
//            "position" => $request->position,
//            "discount" => $request->discount
//        ]);

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
}