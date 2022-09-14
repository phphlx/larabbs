<?php

namespace App\Http\Requests\Api;

class ImageRequest extends FormRequest
{
    public function rules()
    {

        $rules = [
            'type' => 'required|string|in:avatar,topic,videoImg,video,qunImg',
        ];

        if ($this->type == 'avatar') {
            $rules['image'] = 'required|mimes:jpeg,bmp,png,gif|dimensions:min_width=200,min_height=200';
        } else if ($this->type === 'video') {
            $rules['video'] = 'required|mimes:mp4,flv,m3u8,ts,3gp,mov,avi,wmv|max:20480';
        } else {
            $rules['image'] = 'required|mimes:jpeg,bmp,png,gif';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'image.dimensions' => '图片的清晰度不够，宽和高需要 200px 以上',
            'video.max' => '视频大小不能超过 20M',
        ];
    }
}
