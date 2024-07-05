<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobPostsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'company_id' => $this->company_id,

            'title' => $this->title,
            'description' => $this->description,
            'job_requirement' => $this->job_requirement,
            'address' => $this->address,
            'gender' => $this->gender,
            'min_age' => $this->min_age,
            'max_age' => $this->max_age,
            'scientific_level' => $this->scientific_level,
            'job_type' => $this->job_type,
            'min_salary' => $this->min_salary,
            'max_salary' => $this->max_salary,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'experience_years' => $this->experience_years,

            'company' => new CompanyResource($this->company),
            'category' => new CategoryResource($this->category),
            'skill' => new SkillsResource($this->skill),

        ];
    }


}
