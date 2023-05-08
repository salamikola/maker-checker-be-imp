<?php

namespace App\Responsables;

use Illuminate\Contracts\Support\Responsable;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\MessageBag;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;


class ErrorResponse implements Responsable
{

    public function __construct(private string $message,
                                public         $data = [],
                                public int     $status = ResponseAlias::HTTP_BAD_REQUEST)
    {
    }

    public function toResponse($request): JsonResponse
    {
        $data = $this->data;
        $message = $this->message;

        if (!empty($data) && $data instanceof MessageBag) {
            $data->add('error', $data->first());
            $message = $data->first();
            $data = ['error' => $message];
        } else if (empty($data)) {
            $data = ['error' => "$message"];
        }
        $response = [
            'success' => false,
            'message' => $message,
            'data' => $data
        ];

        return new JsonResponse($response, $this->status);
    }

}
