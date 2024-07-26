<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InterviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [

        'company_id'=>$this->company_id,
        'seeker_id'=>$this->seeker_id,

        'scheduled_at'=>$this->scheduled_at,
        'started_at'=>$this->started_at,
        'ended_at'=>$this->ended_at,
        'address'=>$this->address,
        'notes'=>$this->notes,
        'status'=>$this->status,
        'result'=>$this->result,

    ];

    }
}
