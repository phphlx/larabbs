<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QunResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'user' => new UserResource($this->whenLoaded('user')),
            'name' => $this->name,
            'intro' => $this->intro,
            'type' => $this->type,
            'avatar' => [['url' => $this->avatar]],
            'qrcode' => [['url' => str_replace(['https', 'http'], ['http', 'https'], $this->qrcode)]],
            'num' => $this->num,
            'btnText' => $this->btn_text,
            'shareTitle' => $this->share_title,
            'shareDesc' => $this->share_desc,
            'shareImg' => [['url' => $this->share_img]],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
