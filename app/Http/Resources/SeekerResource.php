<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SeekerResource extends JsonResource
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
            'user_id' => $this->user_id,
            'location_id' => $this->location_id,
            'communication_id' => $this->communication_id,

            'rating' => $this->rating,
            'picture' => $this->picture,
            'cv' => $this->cv,
            'level' => $this->level,
            'bio' => $this->bio,
            'gender' => $this->gender,
            'hourly_rate' => $this->hourly_rate,
            'birth_date' => $this->birth_date,

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'user' => new UserResource($this->user),
            'location' => new LocationResource($this->location),
            'communication' => new CommunicationResource($this->communication),
           // 'wallet' => WalletResource::collection($this->whenLoaded('wallet')),

        ];
    }
}
