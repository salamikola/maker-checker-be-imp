<?php

namespace App\Http\Controllers\API\Admin\Auth;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\Admin\LoginRequest;
use App\Responsables\ErrorResponse;
use App\Responsables\SuccessResponse;
use App\Services\Admin\AuthService;
use Illuminate\Http\Request;

class LoginController extends BaseController
{
    /**
     * @param AuthService $authService
     */
    public function __construct(private AuthService $authService)
    {
    }

    /**
     * @param LoginRequest $request
     * @return SuccessResponse|ErrorResponse
     */
    public function __invoke(LoginRequest $request): SuccessResponse|ErrorResponse
    {
        return $this->sendResponse($this->authService->login($request));
    }
}
