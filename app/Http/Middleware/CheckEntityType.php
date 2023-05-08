<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class CheckEntityType
{
    const ENTITYTYPETOMODEL = ['admin' => 'App\Models\Admin'];

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        $userTypeCheck = $role;
        $entityModel = get_class(auth()->user());
        $userTypeCheckModel = self::ENTITYTYPETOMODEL[$userTypeCheck] ?? '';
        if ($userTypeCheckModel != $entityModel) {
            $response = [
                'success' => false,
                'message' => 'Unauthorized',
                'data' => ['error' => 'Unauthorized user']
            ];
            throw new HttpResponseException(response()->json($response, 403, []));
        }
        return $next($request);
    }
}
