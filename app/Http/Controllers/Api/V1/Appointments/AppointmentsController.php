<?php

namespace App\Http\Controllers\Api\V1\Appointments;

use App\Http\Controllers\ApiBaseController;
use App\Http\Requests\Api\V1\Appointments\FilterAppointmentsApiRequest;
use App\Http\Requests\Api\V1\Appointments\StoreAndUpdateAppointmentApiRequest;
use App\Http\Resources\AppointmentResource;
use App\Services\v1\AppointmentsService;
use Illuminate\Http\JsonResponse;

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
        $appointments = $this->appointmentsService->getAppointments($request);
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
}