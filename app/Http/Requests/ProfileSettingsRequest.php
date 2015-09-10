<?php

namespace ineluctable\Http\Requests;

use ineluctable\Http\Requests\Request;

class ProfileSettingsRequest extends Request
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
            'color_scheme' => 'required|in:blue,black',
            'main_character_id' => 'required|numeric',
            'email_notifications' => 'required|in:true,false',
            'thousand_seperator' => 'in:" ",",","."|size:1',
            'decimal_seperator' => 'required|in:",","."|size:1'
        ];
    }
}


/*'color_scheme' => 'required|in:blue,black',
        'main_character_id' => 'required|numeric',
        'email_notifications' => 'required|in:true,false',
        'thousand_seperator' => 'in:" ",",","."|size:1',
        'decimal_seperator' => 'required|in:",","."|size:1',*/