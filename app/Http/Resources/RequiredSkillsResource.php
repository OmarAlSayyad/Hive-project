<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RequiredSkillsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'freelance_post_id' => $this->pivot ? $this->pivot->freelance_post_id : null,
            'skill_id' => $this->pivot ? $this->pivot->skill_id : null,
            'name' => $this->name,
        ];
    }
}
