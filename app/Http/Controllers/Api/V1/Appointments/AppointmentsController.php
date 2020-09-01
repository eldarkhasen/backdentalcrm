<?php

namespace App\Http\Controllers\Api\V1\Appointments;

use App\Http\Controllers\ApiBaseController;
use App\Http\Requests\Api\V1\Appointments\FilterAppointmentsApiRequest;
use App\Http\Requests\Api\V1\Appointments\StoreAndUpdateAppointmentApiRequest;
use App\Http\Resources\AppointmentResource;
use App\Services\v1\AppointmentsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentsController extends ApiBaseController
{
    protected $appointmentsService;

    /**
     * AppointmentsController constructor.
     * @param $appointmentsService
     */
    public function __construct(AppointmentsService $appointmentsService)
    {
        $this->appointmentsService = $appointmentsService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param FilterAppointmentsApiRequest $request
     * @return JsonResponse|object
     */
    public function index(FilterAppointmentsApiRequest $request)
    {
        if($request->has('employee_id')){
            $appointments = $this->appointmentsService->getAppointmentsByEmployee($request);
        }else{
            $appointments = $this->appointmentsService->getAppointments($request, Auth::user());
        }

        return $this->successResponse(
            AppointmentResource::collection($appointments)
        );
    }

    /**
     * @param $id
     * @return JsonResponse|object
     */
    public function show($id)
    {
        return $this->successResponse(
            new AppointmentResource($this->appointmentsService->getAppointmentById($id))
        );
    }

    /**
     * @param StoreAndUpdateAppointmentApiRequest $request
     * @return JsonResponse|object
     */
    public function store(StoreAndUpdateAppointmentApiRequest $request)
    {
        return $this->successResponse(
            $this->appointmentsService->storeAppointment(
                $request
            )
        );
    }

    /**
     * @param StoreAndUpdateAppointmentApiRequest $request
     * @param $id
     * @return JsonResponse|object
     */
    public function update(StoreAndUpdateAppointmentApiRequest $request, $id)
    {
        return $this->successResponse(
            $this->appointmentsService->updateAppointment(
                $request,
                $id
            )
        );
    }

    /**
     * @param $id
     * @return JsonResponse|object
     */
    public function destroy($id)
    {
        return $this->successResponse(
            $this->appointmentsService->deleteAppointment($id)
        );
    }

    public function getPatientLastAppointment($patient_id){
        return $this->successResponse(
            $this->appointmentsService->getPatientLastAppointments($patient_id, Auth::user())
        );
    }

    public function updateAppointmentTime($id, Request $request){
        $starts_at = Carbon::parse($request->get('starts_at'));
        $ends_at = Carbon::parse($request->get('ends_at'));

        return $this->successResponse(
            $this->appointmentsService->updateAppointmentTime($id,$starts_at,$ends_at)
        );
    }
}