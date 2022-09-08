<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    protected $showSensitiveFields = false;

    public function toArray($request)
    {
        if (!$this->showSensitiveFields) {
            $this->resource->makeHidden(['phone', 'email']);
        }

        $data = parent::toArray($request);

        $data['bound_phone'] = $this->resource->phone ? true : false;
        $data['bound_wechat'] = ($this->resource->weixin_unionid || $this->resource->weixin_openid) ? true : false;
        $data['roles'] = RoleResource::collection($this->whenloaded('roles'));
        $data['member'] = $this->resource->end_at > Carbon::now();
        $data['last_day'] = $this->resource->end_at > Carbon::now()
            ? $this->resource->end_at->diffForHumans()
            : 0;

        return $data;
    }

    public function showSensitiveFields()
    {
        $this->showSensitiveFields = true;

        return $this;
    }
}
