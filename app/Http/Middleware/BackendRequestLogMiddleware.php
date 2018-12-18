<?php

namespace App\Http\Middleware;

use App\BackendRequestLog;
use Auth;
use Closure;

class BackendRequestLogMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $currentAction = getCurrentAction();
        list($contollerName, $methodName) = $currentAction;

        $requestLog = new BackendRequestLog();
        $requestLog->backend_user_id = Auth::user()->id;
        $requestLog->path = $request->path();
        $requestLog->controller = $contollerName;
        $requestLog->method = $methodName;
        $requestLog->request_method = $request->method();
        $requestLog->params = json_encode($request->all());
        $requestLog->ip = $request->ip();
        $requestLog->save();

        return $next($request);
    }
}
