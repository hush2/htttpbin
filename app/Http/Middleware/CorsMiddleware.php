<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

class CorsMiddleware
{
    // https://developer.mozilla.org/en-US/docs/Web/HTTP/Access_control_CORS

    public function handle($request, Closure $next)
    {
        $response = $next($request);

//        if (gettype($response) == 'string') {
//            $response = new Response($response);
//        }

        $response->header('Access-Control-Allow-Origin', $request->header('Origin', '*'));

        $response->header('Access-Control-Allow-Credentials', 'true');

        if ($request->has('Origin')) {
            $response->header('Vary', 'Origin');
        }
        if ($request->getMethod() == 'OPTIONS') {
            $response->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
            $response->header('Access-Control-Allow-Methods', '3600'); // 1 hr
            if ($request->has('Access-Control-Request-Headers')) {
                $response->header('Access-Control-Allow-Headers', $request->header('Access-Control-Request-Headers'));
            }
        }

        return $response;
    }
}
