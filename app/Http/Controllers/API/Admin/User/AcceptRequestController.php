<?php

namespace App\Http\Controllers\API\Admin\User;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\Admin\AcceptUserRequest;
use App\Responsables\ErrorResponse;
use App\Responsables\SuccessResponse;
use App\Services\Admin\UserRequestService;
use Illuminate\Support\Facades\Auth;

class AcceptRequestController extends BaseController
{
    /**
     * @param UserRequestService $userRequestService
     */
    public function __construct(private UserRequestService $userRequestService)
    {
    }

    /**
     * @param AcceptUserRequest $request
     * @return SuccessResponse|ErrorResponse
     * @throws \Exception
     */
    public function __invoke(AcceptUserRequest $request): SuccessResponse|ErrorResponse
    {
        return $this->sendResponse($this->userRequestService->acceptRequest($request,Auth::user()));
    }
}
