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
            'user_id' => $this->id,
            'name' => (isset($this->name) && $this->name != null)?$this->name:'',
            'mobile' => (isset($this->mobile) && $this->mobile != null)?$this->mobile:'',
            'shopname' => (isset($this->shopname) && $this->shopname != null)?$this->shopname:'',
            'address' => (isset($this->address) && $this->address != null)?$this->address:'',
            'role' => $this->role_id,
            'email' => $this->email,
            'token' => $this->accessToken->accessToken,
        ];
    }
}
