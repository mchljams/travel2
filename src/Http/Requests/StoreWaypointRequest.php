<?php

namespace Mchljams\TravelLog\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWaypointRequest extends FormRequest
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

        $admin = ($this->user()->getApiGuard() == 'admin') ? true : false;

        // initialize the rules array
        $rules = [];

        $rules['name'] = [
            'required'
        ];

        $rules['city_id'] = [
            'required'
        ];

        $rules['arrival'] = [
            'required',
            'date_format:Y-m-d'
        ];

        $rules['departure'] = [
            'required',
            'date_format:Y-m-d',
            'after:arrival'
        ];

        $rules['itinerary_id'] = [
            'required'
        ];

        if($admin) {
            $rules['user_id'] = [
                'required'
            ];
        }

        // return the rules array
        return $rules;
    }
}
