<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

final class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next): Response|RedirectResponse
    {
        if (!Auth::user() || !Auth::user()->is_admin) {
            abort(HttpResponse::HTTP_UNAUTHORIZED, 'Unauthorized action.');
        }

        return $next($request);
    }
}
