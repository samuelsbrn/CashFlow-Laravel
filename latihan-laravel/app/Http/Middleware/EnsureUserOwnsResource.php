<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserOwnsResource
{
    /**
     * Handle an incoming request.
     *
     * Cara pakai di route:
     * Route::get('/transactions/{transaction}', ...)->middleware('owns:transaction');
     */
    public function handle(Request $request, Closure $next, string $param): Response
    {
        $model = $request->route($param);

        if ($model && method_exists($model, 'user_id')) {
            // tapi biasanya model punya property user_id langsung
        }

        if ($model && $model->user_id !== $request->user()->id) {
            abort(403, 'Anda tidak berhak mengakses data ini.');
        }

        return $next($request);
    }
}
