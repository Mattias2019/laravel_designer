<?php
namespace shopist\Http\Middleware;

use Closure;
use Session;
use shopist\Models\Role;

class LoginFilterMiddleware
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
      if(!\Schema::hasTable('users') && !\Schema::hasTable('roles') && !\Schema::hasTable('role_user') && !\Schema::hasTable('options') && !\Schema::hasTable('posts') && !\Schema::hasTable('post_extras') && !\Schema::hasTable('object_relationships') && !\Schema::hasTable('orders_items') && !\Schema::hasTable('save_custom_designs') && !\Schema::hasTable('users_custom_designs') && !\Schema::hasTable('users_details') && !\Schema::hasTable('manage_languages') && !\Schema::hasTable('user_role_permissions') && !\Schema::hasTable('comments') && !\Schema::hasTable('subscriptions') && !\Schema::hasTable('request_products') && !\Schema::hasTable('term_extras') && !\Schema::hasTable('terms') && !\Schema::hasTable('download_extras') && !\Schema::hasTable('vendor_packages')){
    if(!$request->is('installation')){
      return response(view('errors.not-installed'));
    }
  }
      
      if(\Schema::hasTable('users') && \Schema::hasTable('roles') && \Schema::hasTable('role_user') && \Schema::hasTable('options') && \Schema::hasTable('posts') && \Schema::hasTable('post_extras') && \Schema::hasTable('object_relationships') && \Schema::hasTable('orders_items') && \Schema::hasTable('save_custom_designs') && \Schema::hasTable('users_custom_designs') && \Schema::hasTable('users_details') && \Schema::hasTable('manage_languages') && \Schema::hasTable('user_role_permissions') && \Schema::hasTable('comments') && \Schema::hasTable('subscriptions') && \Schema::hasTable('request_products') && \Schema::hasTable('term_extras') && \Schema::hasTable('terms') && \Schema::hasTable('download_extras') && !\Schema::hasTable('vendor_packages')){
        $roleArray      =   ['slug' => 'administrator'];
        $get_user_role  =   Role::where($roleArray)->get()->toArray();
      
        if(count($get_user_role) == 0 && !$request->is('installation')){
          return response(view('errors.reinstalled'));
        }
      }
       
      if ( Session::has('shopist_admin_user_id') && ( $request->is('admin/login') || $request->is('installation') || $request->is('admin/forgot-password') ) ) {
        return redirect()->route('admin.dashboard');
      }
      
      if ( Session::has('shopist_frontend_user_id') && ( $request->is('user/login') || $request->is('user/forgot-password') ) ) {
        return redirect()->route('user-dashboard-page');
      }
       
    return $next($request);
  }
}