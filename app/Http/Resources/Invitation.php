<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Invitation extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $status = $this->pivot->status;

        switch ($status) {
            case '0':
                $status = "rejected";
                break;
            case '1':
                $status = "accepted";
                break;
            default:
                $status = "unknown";
                break;
        }

        return [
            'user_id' => $this->pivot->user_id,
            'appointment_id' => $this->pivot->appointment_id,
            'visited' => isset($this->pivot->visited_at),
            'status' => $status,
        ];
    }
}
