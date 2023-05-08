<?php

namespace App\Http\Controllers\API\Admin\User;

use App\Http\Controllers\API\BaseController;
use App\Responsables\ErrorResponse;
use App\Responsables\SuccessResponse;
use App\Services\Admin\UserRequestService;


class FetchRequestController extends BaseController
{
    //
    /**
     * @param UserRequestService $userRequestService
     */
    public function __construct(private UserRequestService $userRequestService)
    {
    }

    /**
     * @return SuccessResponse|ErrorResponse
     */
    public function __invoke(): SuccessResponse|ErrorResponse
    {
        return $this->sendResponse($this->userRequestService->fetchRequests());
    }
}
