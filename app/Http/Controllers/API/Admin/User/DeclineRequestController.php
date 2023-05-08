<?php

namespace App\Http\Controllers\API\Admin\User;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\Admin\RejectUserRequest;
use App\Responsables\ErrorResponse;
use App\Responsables\SuccessResponse;
use App\Services\Admin\UserRequestService;
use Illuminate\Support\Facades\Auth;

class DeclineRequestController extends BaseController
{
    /**
     * @param UserRequestService $userRequestService
     */
    public function __construct(private UserRequestService $userRequestService)
    {
    }

    /**
     * @param RejectUserRequest $request
     * @return SuccessResponse|ErrorResponse
     */
    public function __invoke(RejectUserRequest $request): SuccessResponse|ErrorResponse
    {
        return $this->sendResponse($this->userRequestService->rejectRequest($request,Auth::user()));
    }
}
