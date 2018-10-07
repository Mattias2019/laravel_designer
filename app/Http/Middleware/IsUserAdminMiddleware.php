<?php
namespace shopist\Http\Middleware;

use Closure;
use Session;

class IsUserAdminMiddleware
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
    if (Session::has('shopist_frontend_user_id')){
			return $next($request);
		}
    
		return redirect()->route('user-login-page');
  }
}