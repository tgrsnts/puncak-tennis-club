<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $seg1 = $request->segment(1);

        if (in_array($seg1, ['id', 'en'])) {
            App::setLocale($seg1);
            Session::put('locale', $seg1);
        } else {
            $locale = Session::get('locale', config('app.locale', 'id'));
            App::setLocale($locale);
        }

        return $next($request);
    }
}
