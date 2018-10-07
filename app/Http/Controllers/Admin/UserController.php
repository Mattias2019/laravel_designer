<?php
namespace shopist\Http\Controllers\Admin;

use shopist\Http\Controllers\Controller;
use Validator;
use Request;
use Session;
use shopist\Models\UserRolePermission;
use shopist\Models\Role;
use Illuminate\Support\Facades\Lang;
use shopist\Models\User;
use shopist\Models\RoleUser;
use Illuminate\Support\Facades\Input;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use shopist\Models\VendorPackage;
use shopist\Models\UsersDetail;
use shopist\Library\GetFunction;
use Illuminate\Support\Facades\App;
use shopist\Library\CommonFunction;


class UserController extends Controller
{
  public $classCommonFunction;
  
  public function __construct(){
    $this->classCommonFunction  =   new CommonFunction();
	}	
  
  /**
   * 
   * users list content
   *
   * @param null
   * @return response view
   */
  public function usersListContent(){
    $data = array();
    $search_value = '';
    
    if(isset($_GET['term_user_name']) && $_GET['term_user_name'] != ''){
      $search_value = $_GET['term_user_name'];
    }
      
    $data = $this->classCommonFunction->commonDataForAllPages();
    $data['user_list_data'] = $this->getUserListData(true, $search_value, -1);
    $data['search_value']   = $search_value;
     
    return view('pages.admin.users.user-list', $data);
  }
  
  /**
   * 
   * users add content
   *
   * @param null
   * @return response view
   */
  public function usersAddContent(){
    $data = array();
    
    $data = $this->classCommonFunction->commonDataForAllPages();
      
    return view('pages.admin.users.add-users', $data);
  }
  
  /**
   * 
   * users update content
   *
   * @param null
   * @return response view
   */
  public function usersUpdateContent( $params ){
    $get_data = get_user_details( $params );
		  
    if(count($get_data)>0){
      $data = array();
      
      $data = $this->classCommonFunction->commonDataForAllPages();
      $data['user_edit_details'] = $get_data;
      
      return view('pages.admin.users.update-users', $data);
    }
    else{
      return view('errors.no_data');
    }
  }
  
  /**
   * 
   * users role list content
   *
   * @param null
   * @return response view
   */
  public function usersRoleListContent(){
    $data = array();
    $search_value = '';
    
    if(isset($_GET['term_user_role']) && $_GET['term_user_role'] != ''){
      $search_value = $_GET['term_user_role'];
    }
      
    $data = $this->classCommonFunction->commonDataForAllPages();
    $data['user_role_list_data'] = $this->getUserRoleListData(true, $search_value);
    $data['search_value']   = $search_value;
     
    return view('pages.admin.users.user-role-list', $data);
  }
  
  /**
   * 
   * users role add content
   *
   * @param null
   * @return response view
   */
  public function usersRoleAddContent(){
    $data = array();
    
    $data = $this->classCommonFunction->commonDataForAllPages();
      
    return view('pages.admin.users.add-users-roles', $data);
  }
  
  /**
   * 
   * users profile content
   *
   * @param null
   * @return response view
   */
  public function userProfileContent(){
    $get_user_data = User::where(['id' => Session::get('shopist_admin_user_id')])->first();
    
    if($get_user_data->count() > 0){
      $data = array();
    
      $data = $this->classCommonFunction->commonDataForAllPages();
      $data['user_profile_data']  = $get_user_data;
      
      return view('pages.admin.users.user-profile', $data);
    }
  }
  
  
  /**
   * 
   * users role update content
   *
   * @param null
   * @return response view
   */
  public function usersRoleUpdateContent( $params ){
    $get_role_data = get_roles_details_by_role_id( $params );
		  
    if(!empty($get_role_data)){
      $data = array();
      
      $data = $this->classCommonFunction->commonDataForAllPages();
      $data['user_roles_details'] = $get_role_data;
      
      return view('pages.admin.users.update-users-roles', $data);
    }
    else{
      return view('errors.no_data');
    }
  }
  
  /**
   * 
   * Create/update user role
   *
   * @param update id
   * @return response
   */
  public function postUserRole($params = ''){
    if( Request::isMethod('post') && Session::token() == Input::get('_token') ){
      $input  = Input::all();
      $rules = [
                  'user_role_name'    =>  'required',
               ];
      
      $validator = Validator:: make($input, $rules);
      
      if($validator->fails()){
        return redirect()-> back()
        ->withInput()
        ->withErrors( $validator );
      }
      else{
        $user_role_permission       =       new UserRolePermission;
        $Role                       =       new Role;
        
        $permissions_list = array();
        
        if(is_array(Input::get('allow_permissions')) && count(Input::get('allow_permissions'))>0){
          $permissions_list = Input::get('allow_permissions');
        }
        
        if(Input::has('allow_permissions_all')){
          array_push($permissions_list, Input::get('allow_permissions_all'));
        }
        else{
          array_push($permissions_list, 'all_checkbox_disable');
        }
        
        if(Input::get('hf_post_type') == 'add'){
          $role_slug = '';
          $check_slug  = Role::where(['slug' => string_slug_format( Input::get('user_role_name') )])->orWhere('slug', 'like', '%' . string_slug_format( Input::get('user_role_name') ) . '%')->get()->count();

          if($check_slug === 0){
            $role_slug = string_slug_format( Input::get('user_role_name') );
          }
          elseif($check_slug > 0){
            $slug_count = $check_slug + 1;
            $role_slug = string_slug_format( Input::get('user_role_name') ). '-' . $slug_count;
          }
          
          $Role->role_name        =    Input::get('user_role_name');
          $Role->slug             =    $role_slug;

          if( $Role->save() ){
            $user_role_permission->role_id           =    $Role->id;
            $user_role_permission->permissions       =    serialize($permissions_list);

            if($user_role_permission->save()){
              Session::flash('message', Lang::get('admin.successfully_saved_msg') );
              Session::flash('update-message', "");
              return redirect()->route('admin.update_roles', $Role->id);
            }
          }
        }
        elseif (Input::get('hf_post_type') == 'update') {
          $role_data =  array(
                              'role_name'   => Input::get('user_role_name')
          );
          
          if( $Role::where(['id' => $params])->update( $role_data )){
            $permission_data = array(
                                    'permissions'   => serialize($permissions_list)
            );
            
            if( $user_role_permission::where(['role_id' => $params])->update( $permission_data )){
              Session::flash('message', Lang::get('admin.successfully_saved_msg') );
              Session::flash('update-message', "");
              return redirect()->back();
            }
          }
        }
      }
    } 
  }
  
  /**
   * 
   * Create new user and update 
   *
   * @param update id
   * @return response
   */
  public function postUserCreate($id = ''){
    if( Request::isMethod('post') && Session::token() == Input::get('_token') ){
      $input  = Input::all();
      $rules = [
                  'user_display_name'          =>  'required',
                  'user_name'                  =>  'required',
                  'user_email'                 =>  'required|email'
               ];
      
      if(Input::get('hf_post_type') == 'add'){
        $rules['user_password']             =   'required|min:5';   
        $rules['user_secret_key']           =   'required';   
      }
      
      $validator = Validator:: make($input, $rules);
      
      if($validator->fails()){
        return redirect()-> back()
        ->withInput()
        ->withErrors( $validator );
      }
      else{
        $User =       new User;
        $Role =       new Role;
        $Roleuser =   new RoleUser;
        
        $role_data = $this->get_role_by_slug(Input::get('user_role'));
        
        if(!empty($role_data)){
          $is_user_name_exists = User::where(['name' => Input::get('user_name')])->first();
          $is_email_exists     = User::where(['email' => Input::get('user_email')])->first();

          if(Input::get('hf_post_type') == 'add'){
            if(!empty($is_user_name_exists)){
              Session::flash('error-message', Lang::get('validation.unique', ['attribute' => 'user name']));
              return redirect()->back();
            } 

            if(!empty($is_email_exists)){
              Session::flash('error-message', Lang::get('validation.unique', ['attribute' => 'email id']));
              return redirect()->back();
            } 
          
            $User->display_name       =    Input::get('user_display_name');
            $User->name               =    Input::get('user_name');
            $User->email              =    Input::get('user_email');
            $User->password           =    bcrypt( trim(Input::get('user_password')) );
            $User->user_photo_url     =    '';
            $User->user_status        =    1;
            $User->secret_key         =    bcrypt( trim(Input::get('user_secret_key')) );

            if($User->save()){
              $Roleuser->user_id    =    $User->id;
              $Roleuser->role_id    =    $role_data->id;

              if($Roleuser->save()){
                
                if(Input::get('user_role') == 'vendor'){
                  $Userdetails = new UsersDetail;
                  $classGetFunction  =  new GetFunction();
                  $email_options = get_emails_option_data();
                  $get_package  = VendorPackage::where(['package_type' => 'Default'])->first();
                  
                  $vendor_data['profile_details'] = array('store_name' => '', 'address_line_1' => '', 'address_line_2' => '', 'city' => '', 'state' => '', 'country' => '', 'zip_postal_code' => '', 'phone' => '');
                  
                  $vendor_data['general_details'] = array('cover_img' => '', 'vendor_home_page_cats' => '', 'google_map_app_key' => '', 'latitude' => '-25.363', 'longitude' => '131.044');
                  
                  $vendor_data['social_media'] = array('fb_follow_us_url' => '', 'twitter_follow_us_url' => '', 'linkedin_follow_us_url' => '', 'dribbble_follow_us_url' => '', 'google_plus_follow_us_url' => '', 'instagram_follow_us_url' => '', 'youtube_follow_us_url' => '');
                  
                  $vendor_data['seo'] = array('meta_keywords' => '', 'meta_decription' => '');
                  
                  $vendor_data['shipping_method'] = array('shipping_option' => array('enable_shipping' => false, 'display_mode' => ''), 'flat_rate' => array('enable_option' => false, 'method_title' => '', 'method_cost' => 0), 'free_shipping' => array('enable_option' => false, 'method_title' => '', 'order_amount' => ''), 'local_delivery' => array('enable_option' => false, 'method_title' => '', 'fee_type' => '', 'delivery_fee' => ''));
                  
                  $vendor_data['payment_method'] = array('payment_option' => '', 'dbt' => array('status' => false, 'title' => '', 'description' => '', 'instructions' => '', 'account_name' => '', 'account_number' => '', 'bank_name' => '', 'short_code' => '', 'IBAN' => '', 'SWIFT' =>''), 'cod' => array('status' => false, 'title' => '', 'description' => '', 'instructions' => ''), 'paypal' => array('status' => false, 'title' => '', 'email_id' => '', 'description' => ''), 'stripe' => array('status' => false, 'title' => '', 'email_id' => '', 'card_number' => '', 'cvc' => '', 'expiration_month' => '', 'expiration_year' => '', 'description' => ''), 'twocheckout' => array('status' => false, 'title' => '', 'card_number' => '', 'cvc' => '', 'expiration_month' => '', 'expiration_year' => '', 'description' => ''));
                  
                  if(!empty($get_package)){
                    $vendor_data['package'] = array('package_name' => $get_package->id);
                  }
                  else{
                    $vendor_data['package'] = array('package_name' => '');
                  }
                  
                  $Userdetails->user_id = $User->id;
                  $Userdetails->details = json_encode($vendor_data);
                  
                  if ($Userdetails->save()) {
                    $env = App::environment();
                    if($email_options['vendor_new_account']['enable_disable'] == true && $env === 'production'){
                      $classGetFunction->sendCustomMail( array('source' => 'vendor_new_account', 'email' => Input::get('user_email')) );
                    }
                  }
                }
                
                Session::flash('success-message', Lang::get('admin.successfully_saved_msg') );
                Session::flash('update-message', "");
                return redirect()->route('admin.update_new_user', $User->id);
              }
            }
          }
          elseif (Input::get('hf_post_type') == 'update' && $id) {
            if($is_user_name_exists && $is_user_name_exists->id != $id){
              Session::flash('error-message', Lang::get('validation.unique', ['attribute' => 'user name']));
              return redirect()->back();
            } 

            if($is_email_exists && $is_email_exists->id != $id){
              Session::flash('error-message', Lang::get('validation.unique', ['attribute' => 'email id']));
              return redirect()->back();
            } 
            
            $user_data  =    array(
                                  'display_name'    => Input::get('user_display_name'),
                                  'name'            => Input::get('user_name'),
                                  'email'           => Input::get('user_email')
            );
            
            if(Input::get('user_password')){
              $user_data['password'] = bcrypt(Input::get('user_password'));
            }
            
            if(Input::get('user_secret_key')){
              $user_data['secret_key'] = bcrypt(Input::get('user_secret_key'));
            }
            
            if(User::where('id', $id)->update($user_data)){
              $update_role_data = array(
                                'role_id'    =>   $role_data->id
              );
              
              if(RoleUser::where('user_id', $id)->update($update_role_data)){
                Session::flash('success-message', Lang::get('admin.successfully_updated_msg'));
                return redirect()->back();
              }
            }
          }
        }
        else{
          Session::flash('success-message', Lang::get('admin.role_not_exists_msg'));
          return redirect()->back();
        }
      }
    }
  }
		
		/**
   * 
   * Get function for available user role
   *
   * @param null
   * @return array
   */
		public function getAvailableUserRole(){
		$available_roles = array();
    $get_roles = Role::all()->toArray();
    
    if(count($get_roles) > 0){
      $available_roles = $get_roles;
    }
    
    return $available_roles;
		}
		
	/**
   * 
   * Get function for user role
   *
   * @param role_slug
   * @return object
   */
		public function getRoleNameByRoleSlug( $role_slug ){
    $roles_name = '';
    $roles = Role::where('slug', $role_slug)->first();
    
    if(!empty($roles)){
      $roles_name = $roles->role_name;
    }
    
    return $roles_name;
  }
  
  /**
   * 
   * Get user list data
   *
   * @param pagination, search value, status flag
   * @param pagination required. Boolean type TRUE or FALSE, by default false
   * @param search value optional
	  * @param status flag by default -1. -1 for all data, 1 for status enable and 0 for disable status
   * @return array
   */
	public function getUserListData( $pagination = false, $search_val = null, $status_flag = -1){
    $user_data  = array();
    
    if($status_flag == -1){
        $where = [];
    }
    else{
        $where = ['user_status' => $status_flag];
    }
				
    if($search_val && $search_val != ''){
      $getuserdata = User::where($where)
                     ->where('name', 'LIKE', $search_val.'%')  
                     ->get();
    }
    else{
      $getuserdata = User::where($where)
                     ->get();
    }
    
    
		if(count($getuserdata) > 0){
			foreach($getuserdata as $val){
			  $data['id'] = $val->id;
			  $data['display_name'] = $val->display_name;
			  $data['name'] = $val->name;
			  $data['email'] = $val->email;
			  $data['user_status'] = $val->user_status;
			  $data['created_at'] = $val->created_at;
			  
			  if($val->roles->count() >0 && $val->roles[0]){
          $data['user_role'] = $val->roles[0]->role_name;
          $data['role_name_slug'] = $val->roles[0]->slug;
			  }
			  
			  array_push($user_data, $data);
			}
		}		
    
    
    if($pagination){
      $currentPage = LengthAwarePaginator::resolveCurrentPage();
      $col = new Collection( $user_data );
      $perPage = 10;
      $currentPageSearchResults = $col->slice(($currentPage - 1) * $perPage, $perPage)->all();
      $user_object = new LengthAwarePaginator($currentPageSearchResults, count($col), $perPage);

      $user_object->setPath( route('admin.users_list') );
    }
    
    if($pagination){
      return $user_object;
    }
    else{
      return $user_data;
    }
  }
  
  /**
   * 
   * Get function for user role
   *
   * @param role_slug
   * @return object
   */
  public function get_role_by_slug($slug){
    $role_obj = null;
    $get_role = Role::where(['slug' => $slug])
                ->first();
    
    if(!empty($get_role)){
      $role_obj = $get_role;
    }
    
    return $role_obj;
  }
  
   /**
   * 
   * Get user role list data
   *
   * @param pagination, search value, status flag
   * @param pagination required. Boolean type TRUE or FALSE, by default false
   * @param search value optional
	 * @param status flag by default -1. -1 for all data, 1 for status enable and 0 for disable status
   * @return array
   */
	public function getUserRoleListData( $pagination = false, $search_val = null ){
    $user_role_data  = array();
    
    if($search_val && $search_val != ''){
      $getuserroledata = Role::where('role_name', 'LIKE', $search_val.'%')  
                         ->get()
                         ->toArray();
    }
    else{
      $getuserroledata = Role::all()
                         ->toArray();        
    }
    
    if($pagination){
      $currentPage = LengthAwarePaginator::resolveCurrentPage();
      $col = new Collection( $getuserroledata );
      $perPage = 10;
      $currentPageSearchResults = $col->slice(($currentPage - 1) * $perPage, $perPage)->all();
      $user_role_object = new LengthAwarePaginator($currentPageSearchResults, count($col), $perPage);

      $user_role_object->setPath( route('admin.users_roles_list') );
    }
    
    if($pagination){
      return $user_role_object;
    }
    else{
      return $user_role_data;
    }
  }
  
  /**
   * 
   * Update user profile data
   *
   * @param null
   * @return void
   */
  public function updateUserProfile(){
    if( Request::isMethod('post') && Session::token() == Input::get('_token') ){
      $input = Input::all();
      $rules = [
               'display_name'     =>  'required',
               'user_name'        =>  'required',
               'email_id'         =>  'required|email',
               ];

      if(Input::get('password')){
        $rules['password']             =   'min:5';                 
      }

      $validator = Validator:: make($input, $rules);

      if($validator->fails()){
        return redirect()-> back()
        ->withInput()
        ->withErrors( $validator );
      }
      else{
        $is_user_name_exists = User::where(['name' => Input::get('user_name')])->first();
        $is_email_exists     = User::where(['email' => Input::get('email_id')])->first();
        
        if($is_user_name_exists && $is_user_name_exists->id != Session::get('shopist_admin_user_id')){
          Session::flash('error-message', Lang::get('validation.unique', ['attribute' => 'user name']));
          return redirect()->back();
        } 
        
        if($is_email_exists && $is_email_exists->id != Session::get('shopist_admin_user_id')){
          Session::flash('error-message', Lang::get('validation.unique', ['attribute' => 'email id']));
          return redirect()->back();
        } 
        
        $data = array(
                      'display_name'         =>    Input::get('display_name'),
                      'name'                 =>    Input::get('user_name'),
                      'email'                =>    Input::get('email_id')
        );

        if(Input::get('password')){
          $data['password'] = bcrypt(Input::get('password'));
        }

        if(Input::get('hf_profile_picture')){
          $data['user_photo_url'] = Input::get('hf_profile_picture');
        }
        else{
          $data['user_photo_url'] = '';
        }

        if(User::where('id', Session::get('shopist_admin_user_id'))->update($data)){
          Session::flash('success-message', Lang::get('admin.successfully_updated_msg'));
          return redirect()->back();
        }
      }
    }
    else{
      return redirect()-> back();
    }
  }
}