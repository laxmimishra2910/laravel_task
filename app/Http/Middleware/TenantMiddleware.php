<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class TenantMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $tenantId = Auth::check() ? Auth::user()->tenant_id : session('tenant_id');

        if ($tenantId) {
             app()->instance('tenant_id', $tenantId); // ✅ binds correctly
        }

        return $next($request);
    }
}
