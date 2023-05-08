<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseFormRequest;


class CreateUserResouceRequest extends BaseFormRequest
{
    /**
     * Class CreateUserResouceRequest
     *
     * @package App\Http\Requests\Admin
     *
     * @property string $request_type
     * @property array $request_data
     * @property string $request_data['first_name']
     * @property string $request_data['last_name']
     * @property string $request_data['email']
     * @property int $user_id
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
            "request_type" => "required|string|in:create-user,update-user,delete-user",
            "request_data" => "required_if:request_type,create-user,update-user|array",
            "request_data.first_name" => "required_if:request_type,create-user,update-user|string|max:255|unique:users,email",
            "request_data.last_name" => "required_if:request_type,create-user,update-user|string|max:255",
            "request_data.email" => "required_if:request_type,create-user,update-user|email|unique:users,email|max:255",
            "user_id" => "required_if:request_type,update-user,delete-user|integer",
        ];
    }
}
