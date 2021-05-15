<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class UserHasAuth
{
    /**
     * 執行請求過濾器。
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //若訪問者身分不是員工
        if ( !Session::get('userID') ) {
            return redirect('login'); //重新導向登入頁面
        }

        return $next($request);
    }
}