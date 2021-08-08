<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Auth;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'avatar' => $this->icon,
            'email' => $this->email,
            'qq' => $this->qq,
            'home' => $this->home,
            'github' => $this->github,
            'wechat' => $this->wechat,
            'weibo' => $this->weibo,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'group' => $this->group,
            'mobile' => $this->when($this->check(), $this->mobile)
        ];
    }
    protected function check()
    {
        if (Auth::check()) {
            return Auth::id() == $this->resource->id;
        }
    }
}
