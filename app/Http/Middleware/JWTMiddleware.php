<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Exceptions\Custom\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class JWTMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     * @throws JWTException If there is an error with the JWT token (e.g., expired, invalid).
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (TokenExpiredException $e) {
            throw new JWTException('The provided JWT token has expired. Please refresh your token.');
        } catch (TokenInvalidException $e) {
            throw new JWTException('The provided JWT token is invalid. Please check the token and try again.');
        } catch (Exception $e) {
            throw new JWTException('An error occurred while processing the JWT token. Please try again later.');
        }

        return $next($request);
    }
}
