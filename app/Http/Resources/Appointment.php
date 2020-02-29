<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Invitation as InvitationResource;


class Appointment extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'due_date' => $this->due_date,
            'title' => $this->title,
            'info' => $this->info,
            'invitees' => InvitationResource::collection($this->invitees)
        ];
    }
}
