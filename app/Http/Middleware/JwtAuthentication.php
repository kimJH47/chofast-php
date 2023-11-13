<?php

namespace App\Http\Middleware;

use App\Exceptions\CustomException;
use App\Http\auths\JwtValidator;
use Closure;
use Illuminate\Http\Request;

class JwtAuthentication
{

    private JwtValidator $jwtValidator;

    public function __construct(JwtValidator $jwtValidator)
    {
        $this->jwtValidator = $jwtValidator;
    }


    /**
     * @throws CustomException
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();
        if ($token === null) {
            throw new CustomException("token is null");
        }
        $this->jwtValidator->validateToken($token);
        return $next($request);
    }
}
