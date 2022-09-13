<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class VideoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'POST':
            case 'PATCH':
                return [
                    'title' => 'required|string',
                    'video' => 'required',
                    'intro' => 'required|string',
                    'qrcode' => 'required',
                    'time' => 'required',
                    'type' => 'required',
                    'link' => 'nullable',
                    'btnText' => 'nullable',
                    'shareTitle' => 'required|string',
                    'shareImg' => 'required',
                ];
                break;
        }
    }
}
