<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseFormRequest;


class RejectUserRequest extends BaseFormRequest
{
    /**
     * Class RejectUserRequest
     *
     * @package App\Http\Requests\Admin
     *
     * @property string $maker_checker_id
     */

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
            //
            'maker_checker_id' => 'required'
        ];
    }
}
