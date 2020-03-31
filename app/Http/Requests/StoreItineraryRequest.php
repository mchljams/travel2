<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreItineraryRequest extends FormRequest
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
            'name' => 'required|regex:/^[a-zA-z0-9 ]+$/',
            'user_id' => 'sometimes|required|integer|exists:users,id'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'user_id.required' => 'The user_id field is required.',
            'user_id.integer'  => 'The user_id must be an integer.',
            'user_id.exists'   => 'The user_id provided does not exist.',
        ];
    }
}
