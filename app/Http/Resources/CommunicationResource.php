<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommunicationResource extends JsonResource
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
            'mobile_phone' =>$this->mobile_phone,
            'line_phone' =>$this->line_phone,
            'website' =>$this->website,
            'linkedin_account' =>$this->linkedin_account,
            'github_account' =>$this->github_account,
            'facebook_account' =>$this->facebook_account,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];     }
}
