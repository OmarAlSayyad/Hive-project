<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicantFreelancePostResource extends JsonResource
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
            'seeker_id'=>$this->seeker_id,
            'freelance_post_id'=>$this->freelance_post_id,
            'status'=>$this->status,
            'price'=>$this->price,
            'Number_of_hours'=>$this->Number_of_hours,
           'seeker'=> new SeekerResource($this->whenLoaded('seeker')),
            'freelance_post'=> new FreelancePostsResource($this->whenLoaded('freelance_post')),

        ];
    }
}
