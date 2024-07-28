<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EducationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'seeker_id' => $this->seeker_id,


            'institution_name'=>$this->institution_name,
            'field_of_study'=>$this->field_of_study,
            'start_date'=>$this->start_date,
            'graduation_date'=>$this->graduation_date,
            'graduation_degree'=>$this->graduation_degree,
            'scientific_level'=>$this->scientific_level,
        ];
    }
}
