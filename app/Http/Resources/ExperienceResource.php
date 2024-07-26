<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExperienceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
                'seeker_id'=>$this->seeker_id,
                'job_title'=>$this->job_title,
                'company_name'=>$this->company_name,
                'job_description'=>$this->job_description,
                'start_date'=>$this->start_date,
                'end_date'=>$this->end_date,
        ];
    }
}
