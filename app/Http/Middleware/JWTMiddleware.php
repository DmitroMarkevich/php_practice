<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use App\Constants\Message;
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
        } catch (TokenExpiredException) {
            throw new JWTException(Message::AuthErrors['TOKEN_EXPIRED']);
        } catch (TokenInvalidException) {
            throw new JWTException(Message::AuthErrors['TOKEN_INVALID']);
        } catch (Exception) {
            throw new JWTException();
        }

        return $next($request);
    }
}
