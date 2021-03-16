<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use App;
use Config;
use Cookie;
use Crypt;

class Locale
{
    /**
     * Handle an incoming request.
     * Set the user locale.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $rawLocale = Cookie::get('locale');
        if ($rawLocale) {
            $userLocale = Crypt::decrypt($rawLocale, false);
            $userLocale = substr(strrchr($userLocale, "|"), 1);
            if (in_array($userLocale, Config::get('app.locales'), false)) {
                App::setLocale($userLocale);
            }
        }

        return $next($request);
    }
}
