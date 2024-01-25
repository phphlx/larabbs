<?php

namespace App\Http\Requests;

class ImageRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'qrcode' => 'mimes:jpeg,bmp,png,gif|dimensions:min_width=60,min_height=60',
        ];
    }
}
