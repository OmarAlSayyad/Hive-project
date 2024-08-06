<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FavoriteFreelanceResource extends JsonResource
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
            'freelance_post'=> new FreelancePostsResource($this->whenLoaded('freelance_post')),

        ];
    }
}
