<?php

namespace ineluctable\Http\Requests;

use ineluctable\Http\Requests\Request;

class UserPasswordChangeRequest extends Request
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
            'oldPassword' => 'required',
            'newPassword'  => 'required|min:6|confirmed',
            'newPassword_confirmation' => 'required|min:6'
        ];
    }
}
