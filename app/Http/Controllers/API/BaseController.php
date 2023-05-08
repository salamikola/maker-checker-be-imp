<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Responsables\ErrorResponse;
use App\Responsables\SuccessResponse;
use App\Services\ServiceResponse;

class BaseController extends Controller
{

    protected string $resourceType = 'ok';

    public function sendResponse(ServiceResponse $serviceResponse): SuccessResponse|ErrorResponse
    {
        if ($serviceResponse->isSuccess()) {
            $code = $this->resourceType == 'created' ? 201 : 200;
            return new SuccessResponse($serviceResponse->getMessage(), $serviceResponse->getData(), $code);
        }
        return new ErrorResponse($serviceResponse->getMessage(), $serviceResponse->getData(),400);
    }
}
