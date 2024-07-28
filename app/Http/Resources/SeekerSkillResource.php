<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SeekerSkillResource extends JsonResource
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
        'skill_id'=>$this->skill_id,
            'skill_name' => optional($this->skill)->name,        //'name1'=>$this->ski,
    ];
    }
}
