<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'starts_at' => Carbon::parse($this->starts_at)->isoFormat('YYYY-MM-DD HH:mm'),
            'ends_at' => Carbon::parse($this->ends_at)->isoFormat('YYYY-MM-DD HH:mm'),
            'price' => $this->price,
            'status' => $this->status,
            'color' => $this->color,
            'employee' => $this->when(
                $this->relationLoaded('employee'),
                new EmployeeResource($this->employee)
            ),
            'patient' => $this->when(
                $this->relationLoaded('patient'),
                new PatientResource($this->patient)
            ),
            'treatment_course' => $this->when(
                $this->relationLoaded('treatmentCourse'),
                new TreatmentCourseResource($this->treatmentCourse)
            ),
            'services' => $this->when(
                $this->relationLoaded('services'),
                ServicesResource::collection($this->services)
            ),
            'is_first_visit' => $this->is_first_visit == 1,
            'initial_inspection' =>$this->when(
                $this->relationLoaded('initialInspection'),
                $this->initialInspection
//                Carbon::parse(data_get($this, 'initialInspection.created_at'))->isoFormat('MM-DD-YYYY HH:mm')
            )
        ];
    }
}
