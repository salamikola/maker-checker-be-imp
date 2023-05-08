<?php

namespace App\Services\Admin;

use App\Http\Requests\Admin\LoginRequest;
use App\Models\Admin;
use App\Services\ServiceResponse;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    const FAILED_LOGIN_ATTEMPT_MESSAGE = 'Invalid email/password';

    public function __construct(private ServiceResponse $serviceResponse)
    {

    }

    public function login(LoginRequest $request): ServiceResponse
    {
        $admin = Admin::where(['email' => $request->email])->first();
        if (empty($admin) || !Hash::check($request->password, $admin->password)) {
            return $this->serviceResponse->setIsSuccess(false)
                ->setMessage(self::FAILED_LOGIN_ATTEMPT_MESSAGE);
        }
        $token = $admin->createToken('admin');
        $data['hasVerifiedEmail'] = !empty($admin->email_verified_at);
        $data['accessToken'] = $token->plainTextToken;
        $data['firstName'] = $admin->first_name;
        $data['lastName'] = $admin->last_name;
        return $this->serviceResponse->setIsSuccess(true)->setData(['userData' => $data])
            ->setMessage('Login Successfully');
    }

}
