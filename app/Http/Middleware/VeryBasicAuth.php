<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VeryBasicAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!$this->authorize($request)) {
            return response('Invalid credentials.')
                ->withHeaders(['WWW-Authenticate' => 'Basic'])
                ->setStatusCode(401);
        }

        return $next($request);
    }

    private function authorize(Request $request)
    {
      return $request->getUser() === config('app.user') && $request->getPassword() === config('app.password');
    }
}
