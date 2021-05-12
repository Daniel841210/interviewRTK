<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class ManagerHasAuth
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
        //訪問者身分若不是主管
        if ( !(Session::get('status') === 'manager') ) {
            return redirect('login'); //重新導向登入頁面
        }

        return $next($request);
    }
}