<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'is_admin' => $this->is_admin,
            'email' => $this->email,
            'email_verified_at' => parseRequestTime($this->email_verified_at)?->getTimestamp(),
            'avatar' => $this->avatar,
            'address' => $this->address,
            'phone_number' => $this->phone_number,
            'is_marketing' => $this->is_marketing,
            'last_login_at' => parseRequestTime($this->last_login_at)?->getTimestamp(),
            'created_at' => parseRequestTime($this->created_at)->getTimestamp(),
        ];
    }
}
