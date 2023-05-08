<?php

namespace App\Responsables;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class SuccessResponse implements Responsable
{

    public function __construct(private string $message,
                                public         $data,
                                public int     $status = ResponseAlias::HTTP_OK)
    {
    }

    public function toResponse($request): JsonResponse
    {
        $response = [
            'success' => true,
            'data' => $this->data,
            'message' => $this->message
        ];
        return new JsonResponse($response, $this->status);
    }
}
