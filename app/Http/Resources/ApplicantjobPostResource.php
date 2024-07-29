<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicantjobPostResource extends JsonResource
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
            'job_post_id'=>$this->job_post_id,
            'job_post'=> new JobPostsResource($this->whenLoaded('job_post')),

        ];
    }
}
