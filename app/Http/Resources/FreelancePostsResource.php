<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FreelancePostsResource extends JsonResource
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

            'seeker_id' => $this->seeker_id,
            'company_id' => $this->company_id,

            'title' => $this->title,
            'description' => $this->description,
            'delivery_date' => $this->delivery_date,
            'min_budget' => $this->min_budget,
            'max_budget' => $this->max_budget,

            'seeker' => new SeekerResource($this->seeker),
            'category' => new CategoryResource($this->category),
          //  'skill' => new SkillsResource($this->skill),
        ];
    }
}
