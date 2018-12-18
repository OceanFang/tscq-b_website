<?php

namespace App\Http\Middleware;

use App\WhiteList;
use Closure;

class CheckForMaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // get whiteList ip
        $ipArr = [];
        $datas = WhiteList::orderBy('id', 'asc')->get();
        foreach ($datas as $val) {
            array_push($ipArr, $val['ip']);
        }

        if (in_array($request->getClientIp(), $ipArr)) {
            return $next($request);
        }

        $ipregexp = implode('|', str_replace(array('*', '.'), array('\d+', '\.'), $ipArr));
        $rs = preg_match("/^(" . $ipregexp . ")$/", $request->getClientIp());
        if ($rs) {
            return $next($request);
        }

        echo 'your ip is : ' . $request->getClientIp() . '<br>';
        return response('Be right back!', 503);
    }
}
