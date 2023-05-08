<?php

namespace App\Http\Controllers\API\Admin\User;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\Admin\CreateUserResouceRequest;
use App\Responsables\ErrorResponse;
use App\Responsables\SuccessResponse;
use App\Services\Admin\UserRequestService;
use Illuminate\Support\Facades\Auth;

class CreateRequestController extends BaseController
{
    /**
     * @param UserRequestService $userRequestService
     */
    public function __construct(private UserRequestService $userRequestService)
    {
    }

    /**
     * @param CreateUserResouceRequest $request
     * @return SuccessResponse|ErrorResponse
     */
    public function __invoke(CreateUserResouceRequest $request): SuccessResponse|ErrorResponse
    {
        $this->resourceType = 'created';
        return $this->sendResponse($this->userRequestService->createRequest($request,Auth::user()));
    }
}
