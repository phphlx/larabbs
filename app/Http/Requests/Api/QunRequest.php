<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class QunRequest extends FormRequest
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
                    'name' => 'required|string',
                    'intro' => 'required|string',
                    'type' => 'required',
                    'avatar' => 'required',
                    'qrcode' => 'required',
                    'num' => 'required',
                    'btnText' => 'nullable',
                    'shareTitle' => 'required|string',
                    'shareDesc' => 'nullable|string',
                    'shareImg' => 'required',
                ];
                break;
        }
    }
}
