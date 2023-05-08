<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Exceptions\HttpResponseException;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        $response = [
            'success' => false,
            'message' => 'Unauthenticated',
            'data' => ['error' => 'User is not authenticated']
        ];
        throw new HttpResponseException(response()->json($response, 401, []));

    }
}
