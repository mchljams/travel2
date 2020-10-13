<?php

namespace Mchljams\TravelLog\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

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
        $input = $this->input();
        // check if admin
        $admin = ($this->user()->getApiGuard() == 'admin') ? true : false;
        $name = $input['name'];
        // set the user id for the itinerary that will be created/updated
        $user_id = $admin ? $input['user_id'] : Auth::guard('api')->user()->id;
        // initialize the rules array
        $rules = [];
        // add the name rules to the array
        $rules['name'] = [
            'required',
            'regex:/^[a-zA-Z0-9 ]+$/', // lower alpha, upper alpha, numbers and spaces
            Rule::unique('itineraries')->where(function ($query) use ($user_id, $name) {
                return $query->where('user_id', $user_id);
            })->ignore($name, 'name')
        ];

        if($admin) {
            $rules['user_id'] = 'required|integer|exists:users,id';

        } else {
            $rules['user_id'] = 'integer';
        }

        return $rules;
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
