<?php


namespace App\Http\Controllers\Api\V1\Appointments;


use App\Http\Controllers\ApiBaseController;
use App\Http\Requests\Api\V1\Diagnosis\DiagnosisStoreApiRequest;
use App\Http\Resources\Diagnosis\DiagnosisCollection;
use App\Models\Business\Diagnosis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiagnosisController extends ApiBaseController
{
    public function index()
    {
        return $this->successResponse(
            Diagnosis::with('types')
                ->select('id', 'name', 'code', 'organization_id')
                ->get()
        );
    }

    public function indexPaginate(Request $request)
    {
        $user = Auth::user();
        $user->load('employee');
        $diagnosis = Diagnosis::with('types')
            ->where(function ($q) use ($user) {
                $q->where('organization_id', data_get($user, 'employee.organization_id'))
                    ->orWhereNull('organization_id');
            })
            ->when($request->input('search'), function ($q) use ($request) {
                $q->where(function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->input('search') . '%')
                        ->orWhere('code', 'like', '%' . $request->input('search') . '%');
                });
            })
            ->paginate($request->input('paginate', 10));

        return new DiagnosisCollection($diagnosis);
    }

    public function show($id)
    {
        return $this->successResponse(
            Diagnosis::with('types')
                ->select('id', 'name', 'code', 'organization_id')
                ->findOrFail($id)
        );
    }

    public function edit($id)
    {
        return $this->successResponse(
            Diagnosis::with('types')
                ->select('id', 'name', 'code', 'organization_id')
                ->findOrFail($id)
        );
    }

    public function store(DiagnosisStoreApiRequest $request)
    {
        $user = Auth::user();
        $user->load('employee');

        $diagnosis = Diagnosis::updateOrCreate([
            'id' => $request->id
        ], [
            'name' => $request->name,
            'code' => $request->code,
            'organization_id' => data_get($user, 'employee.organization_id'),
        ]);
        return $this->successResponse($diagnosis);
    }

    public function delete($id)
    {
        Diagnosis::findOrFail($id)->delete();
        return $this->successResponse(['message' => 'Diagnosis deleted successfully']);
    }
}
