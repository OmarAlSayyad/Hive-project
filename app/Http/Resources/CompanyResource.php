<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
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

            'picture' => $this->picture,
            'industry' => $this->industry,
            'description' => $this->description,
            'rating' => $this->rating,
            'approved' => $this->approved,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'user' => new UserResource($this->user),
            'location' => new LocationResource($this->location),
            'communication' => new CommunicationResource($this->communication),
            //'wallet' => WalletResource::collection($this->whenLoaded('wallet')),
        ];

    }
}
