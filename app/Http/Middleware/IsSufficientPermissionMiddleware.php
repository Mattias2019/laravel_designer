<?php
namespace shopist\Http\Middleware;

use Closure;
use Session;

class IsSufficientPermissionMiddleware
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
    if(is_sufficient_permission()){
			return $next($request);
		}
    
    return response(view('errors.no_permission'));
  }
}