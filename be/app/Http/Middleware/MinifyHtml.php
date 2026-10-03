<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

class MinifyHtml
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // Only process HTML responses
        if ($response instanceof Response && str_contains($response->headers->get('Content-Type'), 'text/html')) {
            $output = $response->getContent();

            // Strip whitespace and line breaks
            $output = preg_replace([
                '/<!--(?!\[if).*?-->/',     // remove HTML comments except IE conditionals
                '/\>[^\S ]+/s',             // remove whitespace after tags
                '/[^\S ]+\</s',             // remove whitespace before tags
                '/(\s)+/s'                  // collapse multiple whitespace
            ], [
                '',
                '>',
                '<',
                '\\1'
            ], $output);

            $response->setContent($output);
        }

        return $response;
    }
}
