<?php

namespace App\Http\Middleware;

use Closure;

class ChangeLocale
{
    public function handle($request, Closure $next)
    {
        $language = $request->header('accept-language');
        if ($language) {
//            \App::setLocale($language); // 这里引起了一个奇怪的问题: 电脑版打不开, locale报错
        }

        return $next($request);
    }
}
