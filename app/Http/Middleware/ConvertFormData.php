<?php

namespace App\Http\Middleware;

use Closure;

class ConvertFormData
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->isMethod('patch') || $request->isMethod('put')) {
            $request->merge(json_decode($request->getContent(), true) ?? []);
        }

        return $next($request);
    }
}
