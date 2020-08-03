<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'starts_at' => Carbon::parse($this->start_date)->isoFormat('DD.MM.YYYY HH:mm'),
            'ends_at' => Carbon::parse($this->end_date)->isoFormat('DD.MM.YYYY HH:mm'),
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
                new ServicesResource($this->services)
            ),
            'is_first_visit' => $this->is_first_visit == 1,
        ];
    }
}
