<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VideoResource extends JsonResource
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
            'title' => $this->title,
            'video' => [['url' => $this->video]],
            'intro' => $this->intro,
            'qrcode' => [['url' => $this->qrcode]],
            'shareTitle' => $this->share_title,
            'shareImg' => [['url' => $this->share_img]],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
