<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ApiLog
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        Log::channel("api_daily")->info("[REQUEST] " . json_encode([
            "method" => $request->method(),
            "url" => $request->fullUrl(),
            "headers" => [
                "authorization" => $request->header("authorization")
            ],
            "body" => $request->all()
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n");

        $response = $next($request);

        Log::channel("api_daily")->info("[RESPONSE] " . json_encode([
            "status" => $response->getStatusCode(),
            "headers" => [
                "content-type" => $response->headers->get("content-type")
            ],
            "body" => json_decode($response->getContent(), true)
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n");

        return $response;
    }
}
