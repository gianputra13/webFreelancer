<?php

namespace App\Http\Requests\Dashbaord\Service;

use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceRequest extends FormRequest
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
        return [
            'title' => [
                'required', 'string', 'max:255'
            ],
            'description' => [
                'required', 'string', 'max:5000'
            ],
            'delivery_time' => [
                'required', 'integer', 'max:100'
            ],
            'revision_limit' => [
                'required', 'integer', 'max:100'
            ],
            'price' => [
                'required', 'string'
            ],
            'note' => [
                'nullable', 'string', 'max:5000'
            ]
        ];
    }
}
