<?php

namespace App\Http\Resources;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if (isset($this->picture) && Storage::exists($this->picture))
            $picture = base64_encode(Storage::get($this->picture));
            // $picture = Storage::temporaryUrl(
            //     $this->picture,
            //     now()->addMinutes(15)
            // );
        else
            $picture = '';

        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone_number' => $this->phone_number,
            'email' => $this->email,
            'picture' => $picture,
        ];
    }
}
