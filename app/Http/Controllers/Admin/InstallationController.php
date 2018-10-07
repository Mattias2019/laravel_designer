<?php
namespace shopist\Http\Controllers\Admin;

use shopist\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use shopist\Library\CommonFunction;

class InstallationController extends Controller
{
  public function __construct(){
    $this->middleware('verifyLoginPage');
  }
  
  /**
   * 
   * Installation process start. Create all database table
   *
   * @param null
   * @return response
   */
  public function installationCheck(){
    if(!\Schema::hasTable('users') && !\Schema::hasTable('roles') && !\Schema::hasTable('role_user') && !\Schema::hasTable('options') && !\Schema::hasTable('posts') && !\Schema::hasTable('post_extras') && !\Schema::hasTable('object_relationships') && !\Schema::hasTable('orders_items') && !\Schema::hasTable('save_custom_designs') && !\Schema::hasTable('users_custom_designs') && !\Schema::hasTable('users_details') && !\Schema::hasTable('manage_languages') && !\Schema::hasTable('user_role_permissions') && !\Schema::hasTable('comments') && !\Schema::hasTable('subscriptions') && !\Schema::hasTable('request_products') && !\Schema::hasTable('term_extras') && !\Schema::hasTable('terms') && !\Schema::hasTable('download_extras') && !\Schema::hasTable('vendor_packages')){
      Artisan::call('migrate', ["--force"=> true ]);
        
      if(!$this->isAdminRoleDataExist()){
        return redirect()->route('installation-process');
      }
    }
    else{
      if($this->isAdminRoleDataExist()){
        return redirect()->route('home-page');
      }
      else {
        return redirect()->route('installation-process');
      }
    }
  }
  
 
   /**
   * 
   * Check admin user data is exist or not
   *
   * @param null
   * @return boolean
   */
  public function isAdminRoleDataExist(){
    $classCommonFunction = new CommonFunction(); 
    
    if($classCommonFunction->is_shopist_admin_installed()){
      return true;
    }
    else{
      return false;
    }
  }
}