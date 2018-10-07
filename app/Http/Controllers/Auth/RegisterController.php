<?php

namespace shopist\Http\Controllers\Auth;

use shopist\Http\Controllers\Controller;
use shopist\Models\Role;
use shopist\Models\User;
use shopist\Models\RoleUser;
use shopist\Models\UsersDetail;
use shopist\Models\Option;
use shopist\Models\VendorPackage;
use Illuminate\Support\Facades\Input;
use Validator;
use Request;
use Session;
use Illuminate\Support\Facades\Lang;
use shopist\Models\ManageLanguage;
use shopist\Library\CommonFunction;
use shopist\Models\UserRolePermission;
use shopist\Http\Controllers\OptionController;
use shopist\Library\GetFunction;
use Illuminate\Support\Facades\App;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation.
    |
    */
  
    public $classCommonFunction;
    public $classGetFunction;
    public $settingsData = array();
    public $recaptchaData = array();
    public $option;
    public $env;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
	    $this->middleware('verifyLoginPage');
      $this->classCommonFunction  =  new CommonFunction();
      $this->classGetFunction     =   new GetFunction();
      $this->recaptchaData     =  get_recaptcha_data();
      $this->option  = new OptionController();
      $this->env = App::environment();
      
      $this->settingsData['_settings_data']   = $this->option->getSettingsData();
    }
    
  /**
   * 
   * Redirect to installation process
   *
   * @param null
   * @return response
   */
    
  public function redirectToInstallationProcess(){
    $this->classCommonFunction->set_admin_lang();
    if($this->classCommonFunction->is_shopist_admin_installed()){
      return redirect()->route('admin.login');
    }
    else{
      return view('pages.auth.install');
    }
  }
  
  /**
   * 
   * Redirect to user registration
   *
   * @param null
   * @return response
   */
    
  public function redirectToUserRegistrationProcess(){
    $data  = array(); 
    $this->classCommonFunction->set_frontend_lang();
    
    $data['target']   =   'empty_check';
    $get_data         =   $this->classCommonFunction->get_dynamic_frontend_content_data( $data );
    $get_data['is_enable_recaptcha'] = $this->recaptchaData['enable_recaptcha_for_user_registration'];
    $get_data['settings_data'] = global_settings_data();
    
    return view('pages.auth.user-registration')->with($get_data);
  }
  
  /**
   * 
   * Redirect to vendor registration
   *
   * @param null
   * @return response
   */
    
  public function redirectToVendorRegistrationProcess(){
    $data  = array(); 
    $this->classCommonFunction->set_frontend_lang();
    
    $data['target']   =   'empty_check';
    $get_data         =   $this->classCommonFunction->get_dynamic_frontend_content_data( $data );
				
				if(isset($this->recaptchaData['enable_recaptcha_for_vendor_registration'])){
						$get_data['is_enable_recaptcha'] = $this->recaptchaData['enable_recaptcha_for_vendor_registration'];
				}
				else{
						$get_data['is_enable_recaptcha'] = false;
				}
    
    return view('pages.auth.vendor-registration')->with($get_data);
  }
  
  /**
   * 
   * Save installation data
   *
   * @param null
   * @return response
   */
  public function installationDataSave(){
    if(!$this->classCommonFunction->is_shopist_admin_installed()){
      if( Request::isMethod('post') && Session::token() == Input::get('_token')){
        $data = Input::all();
        
        $rules = [
          'display_name'               => 'required',
          'user_name'                  => 'required|unique:users,name',
          'email_id'                   => 'required|email|unique:users,email',
          'password'                   => 'required|min:5|confirmed',
          'password_confirmation'      => 'required|min:5',
          'secret_key'                 => 'required'
        ];
        
        $messages = [
          'display_name.required' => Lang::get('validation.display_name_required'),
          'user_name.required' => Lang::get('validation.user_name_required'),
          'user_name.unique' => Lang::get('validation.user_name_unique'),
          'email_id.required' => Lang::get('validation.email_required'),
          'email_id.unique' => Lang::get('validation.email_unique'),
          'email_id.email' => Lang::get('validation.email_is_email'),
          'password.required' => Lang::get('validation.password_required'),
          'password_confirmation.required' => Lang::get('validation.password_confirmation_required'),
          'secret_key.required' => Lang::get('validation.secret_key_required')
        ];
        
        $validator = Validator:: make($data, $rules, $messages);
        
        if($validator->fails()){
          return redirect()-> back()
          ->withInput()
          ->withErrors( $validator );
        }
        else{
          $User =       new User;
          $Role =       new Role;
          $Roleuser =   new RoleUser;
          $Option =     new Option;
          
          if(Role::insert(
            array(
              array(
                  'role_name'       =>    'Administrator',
                  'slug'            =>    'administrator',
                  'created_at'      =>    date("y-m-d H:i:s", strtotime('now')),
                  'updated_at'      =>    date("y-m-d H:i:s", strtotime('now'))
              ),
              array(
                  'role_name'       =>    'Site User',
                  'slug'            =>    'site-user',
                  'created_at'      =>    date("y-m-d H:i:s", strtotime('now')),
                  'updated_at'      =>    date("y-m-d H:i:s", strtotime('now'))
              ),
														array(
                  'role_name'       =>    'Vendor',
                  'slug'            =>    'vendor',
                  'created_at'      =>    date("y-m-d H:i:s", strtotime('now')),
                  'updated_at'      =>    date("y-m-d H:i:s", strtotime('now'))
              )		
            )
          )){
              $User->display_name       =    Input::get('display_name');
              $User->name               =    Input::get('user_name');
              $User->email              =    Input::get('email_id');
              $User->password           =    bcrypt( trim(Input::get('password')) );
              $User->user_photo_url     =    '';
              $User->user_status        =    1;
              $User->secret_key         =    bcrypt( trim(Input::get('secret_key')) );
              
              if($User->save()){
                $roleArray      =   ['slug' => 'administrator'];
                $get_user_role  =   Role::where($roleArray)->first();
																
																$roleArray2       =   ['slug' => 'vendor'];
                $get_vendor_role  =   Role::where($roleArray2)->first();
                
                $Roleuser->user_id    =    $User->id;
                $Roleuser->role_id    =    $get_user_role->id;
                
                if($Roleuser->save()){
                  $bacs_desc = Lang::get('admin.bacs_desc');
                  $bacs_ins = Lang::get('admin.bacs_ins');
                  $cod_desc = Lang::get('admin.cod_desc');
                  $cod_ins = Lang::get('admin.cod_ins');
                  $paypal_desc = Lang::get('admin.paypal_desc');
                  $stripe_desc = Lang::get('admin.stripe_desc');
                  $twocheckout_desc = Lang::get('admin.2checkout_desc');
                  
                  $shipping_method_array = array( 
                    'shipping_option'  => array('enable_shipping' => '', 'display_mode' => 'radio_buttons'),
                    'flat_rate'        => array('enable_option' => '', 'method_title' => Lang::get('admin.flat_rate'), 'method_cost' => ''),
                    'free_shipping'    => array('enable_option' => '', 'method_title' => Lang::get('admin.free_shipping'), 'order_amount' => ''),
                    'local_delivery'   => array('enable_option' => '', 'method_title' => Lang::get('admin.local_delivery'), 'fee_type' => '', 'delivery_fee' => '')
                  );
                  
                  $settings_array = array( 
                    'general_settings'  => 
                                          array(
                                              'general_options'     => array('site_title' => 'Shopist', 'email_address' => 'yourEmail@domain.com', 'site_logo' => '', 'allow_registration_for_frontend' => true, 'default_role_slug_for_site' => 'site-user'),
                                              'taxes_options'       => array('enable_status' => 0, 'apply_tax_for' => '', 'tax_amount' => ''),
                                              'checkout_options'    => array('enable_guest_user' => true, 'enable_login_user' => true),
                                              'downloadable_products_options'    => array('login_restriction' => false, 'grant_access_from_thankyou_page' => true, 'grant_access_from_email' => false),  
                                              'recaptcha_options'   => array('enable_recaptcha_for_admin_login' => false, 'enable_recaptcha_for_user_login' => false, 'enable_recaptcha_for_user_registration' => false, 'enable_recaptcha_for_vendor_login' => false, 'enable_recaptcha_for_vendor_registration' => false, 'recaptcha_secret_key' => '', 'recaptcha_site_key' => ''),
                                              'nexmo_config_option' => array('enable_nexmo_option' => false, 'nexmo_key' => '', 'nexmo_secret' => '', 'number_to' => '', 'number_from' => '', 'message' => ''),
                                              'fixer_config_option' => array('fixer_api_access_key' => ''),
                                              'currency_options'    => array('currency_name' => 'USD', 'currency_position' => 'left', 'thousand_separator' => ',', 'decimal_separator' => '.', 'number_of_decimals' => '2', 'frontend_currency' => array('USD', 'GBP', 'BDT', 'EUR')),
                                              'date_format_options' => array('date_format' => 'Y-m-d'),
                                              'default_frontend_currency' => array('AUD', 'EUR', 'GBP', 'USD', 'BDT')
                                          )
                  );
                  
                  $designer_settings = array(
                    'general_settings' => array(
                        'canvas_dimension' => array('small_devices' => array('width' => 280, 'height' => 300), 'medium_devices' => array('width'=> 480, 'height' => 480), 'large_devices' => array('width' => 500, 'height' => 550))
                    )
                  );
                  
                  $payment_method_array = array( 
                    'payment_option'   => array('enable_payment_method' => ''),
                    'bacs'             => array('enable_option' => '', 'method_title' => Lang::get('admin.direct_bank_transfer'), 'method_description' => $bacs_desc, 'method_instructions' => $bacs_ins, 'account_details' => array('account_name' => '', 'account_number' => '', 'bank_name' => '', 'short_code' => '', 'iban' => '', 'swift' => '') ),
                    'cod'              => array('enable_option' => '', 'method_title' => Lang::get('admin.cash_on_delivery'), 'method_description' => $cod_desc, 'method_instructions' => $cod_ins),
                    'paypal'           => array('enable_option' => '', 'method_title' => Lang::get('admin.paypal'), 'paypal_client_id' => '', 'paypal_secret' => '', 'paypal_sandbox_enable_option' => 'yes', 'method_description' => $paypal_desc),
                    'stripe'           => array('enable_option' => '', 'method_title' => Lang::get('admin.stripe'), 'test_secret_key' => '', 'test_publishable_key' => '', 'live_secret_key' => '', 'live_publishable_key' => '', 'stripe_test_enable_option' => 'yes', 'method_description' => $stripe_desc),
                    '2checkout'        => array('enable_option' => '', 'method_title' => Lang::get('admin.two_checkout'), 'sellerId' => '', 'publishableKey' => '', 'privateKey' => '', 'sandbox_enable_option' => 'yes', 'method_description' => $twocheckout_desc) 
                  );
                  
                  $appearance_tab = array(
                    'settings'          =>    json_encode( array('header_slider_images_and_text'   => array('slider_images' => array(), 'slider_text' => array()))),
                    'settings_details'  =>    array('general' => array('custom_css' => false, 'body_bg_color' => 'd2d6de', 'filter_price_min' => 0, 'filter_price_max' => 1000, 'sidebar_panel_bg_color' => 'f2f0f1', 'sidebar_panel_title_text_color' => '333333', 'sidebar_panel_title_text_bottom_border_color' => '1fc0a0', 'sidebar_panel_title_text_font_size' => 14, 'sidebar_panel_content_text_color' => '333333', 'sidebar_panel_content_text_font_size' => 12, 'product_box_bg_color' => 'f2f0f1', 'product_box_border_color' => 'e1e1e1', 'product_box_text_color' => '333333', 'product_box_text_font_size' => 13, 'product_box_btn_bg_color' => '1fc0a0', 'product_box_btn_hover_color' => 'e1e1e1', 'btn_text_color' => 'FFFFFF', 'btn_hover_text_color' => '444444', 'selected_menu_border_color' => '1fc0a0', 'pages_content_title_border_color' => '1fc0a0'  ), 
                                            'header_details' => array('slider_visibility' => true, 'custom_css' => false, 'header_top_gradient_start_color' => '272727', 'header_top_gradient_end_color' => '272727', 'header_bottom_gradient_start_color' => '1e1e1e','header_bottom_gradient_end_color' => '1e1e1e', 'header_text_color' => 'B4B1AB', 'header_text_size' => '14', 'header_text_hover_color' => 'd2404d', 'header_selected_menu_bg_color' => 'C0C0C0', 'header_selected_menu_text_color' => 'd2404d', 'header_slogan' => 'Default welcome message'),
                                            'home_details'  => array('cat_list_to_display' => array(), 'cat_collection_list_to_display' => array()),
                                            'footer_details' => array('footer_about_us_description' => 'Your description here', 'follow_us_url' => array('fb' => '', 'twitter' => '', 'linkedin' => '', 'dribbble' => '', 'google_plus' => '', 'instagram' => '', 'youtube' => ''))),
                    'header'            =>    'customfy',
                    'home'              =>    'customfy',
                    'products'          =>    'crazy',
                    'single_product'    =>    'crazy',
                    'blogs'             =>    'crazy'
                  );
                  
                  $permissions_files = array('pages_list_access' => 'Pages list access', 'add_edit_delete_pages' => 'Add/edit/delete pages', 'list_blogs_access' => 'Blog list access', 'add_edit_delete_blog' => 'Add/edit/delete blog', 'blog_comments_list' => 'Blog comments access', 'blog_categories_access' => 'Add/edit/delete blog categories', 'testimonial_list_access' => 'Testimonial list access', 'add_edit_delete_testimonial' => 'Add/edit/delete testimonial', 'brands_list_access' => 'Manufacturers list access', 'add_edit_delete_brands' => 'Add/edit/delete manufacturers', 'manage_seo_full' => 'Manage SEO full access', 'products_list_access' => 'Products list access', 'add_edit_delete_product' => 'Add/edit/delete product', 'product_categories_access' => 'Add/edit/delete products categories', 'product_tags_access' => 'Add/edit/delete products tags', 'product_attributes_access' => 'Add/edit/delete products attributes', 'product_colors_access' => 'Add/edit/delete products colors', 'product_sizes_access' => 'Add/edit/delete products sizes', 'products_comments_list_access' => 'Products comments list access', 'manage_orders_list' => 'Manage orders list access', 'manage_reports_list' => 'Manage reports list access', 'vendors_list_access' => 'Vendors list access', 'vendors_withdraw_access' => 'Vendors withdraw access', 'vendors_refund_request_access' => 'Vendors refund request access', 'vendors_earning_reports_access' => 'Vendors earning reports access','vendors_announcement_access'=> 'Vendors announcement access', 'vendor_settings' => 'settings', 'vendors_packages_full_access' => 'Vendors packages menu full access', 'vendors_packages_list_access' => 'Vendors packages list access', 'vendors_packages_create_access' => 'Vendors packages create access', 'manage_shipping_method_menu_access' => 'Manage shipping method full access', 'manage_payment_method_menu_access' => 'Manage payment method full access', 'manage_designer_elements_menu_access' => 'Manage custom designer elements full access', 'manage_coupon_menu_access' => 'Manage coupon manager full access', 'manage_settings_menu_access' => 'Manage settings full access', 'manage_requested_product_menu_access' => 'Manage request products full access', 'manage_subscription_menu_access' => 'Manage subscription full access', 'manage_extra_features_access' => 'Manage extra features full access');
                  
                  $seo_data       =  array('meta_tag' => array('meta_keywords' => '', 'meta_description' => ''));   
                  $subscription   =  array('mailchimp' => array('api_key' => '', 'list_id' => ''));  
                  $subscription_settings   = array('subscription_visibility' => true, 'subscribe_type' => 'mailchimp', 'subscribe_options' => 'name_email', 'popup_bg_color' => 'f5f5f5', 'popup_content' => '', 'popup_display_page' => array('home', 'shop'), 'subscribe_btn_text' => 'Subscribe Now', 'subscribe_popup_cookie_set_visibility' => true, 'subscribe_popup_cookie_set_text' => 'No thanks, i am not interested!');
                  
                  $vendor_settings_data = array('term_n_conditions' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.');
                  
                  $emails_data = array('new_order' => array('enable_disable' => true, 'subject' => 'Your order receipt from #date_place#', 'email_heading' => 'Thank you for your order', 'body_bg_color' => '#f5f5f5', 'selected_template' => 'template-3'), 'cancelled_order' => array('enable_disable' => true, 'subject' => 'Cancelled order', 'email_heading' => 'Cancelled order', 'body_bg_color' => '#f5f5f5'), 'processed_order' => array('enable_disable' => true, 'subject' => 'Order #order_id# has been Processed', 'email_heading' => 'Processed order', 'body_bg_color' => '#f5f5f5'), 'completed_order' => array('enable_disable' => true, 'subject' => 'Your Order #order_id# is complete', 'email_heading' => 'Your order is complete', 'body_bg_color' => '#f5f5f5'), 'new_customer_account' => array('enable_disable' => true, 'subject' => 'Successfully created account', 'email_heading' => 'Customer account created', 'body_bg_color' => '#f5f5f5'), 'vendor_new_account' => array('enable_disable' => true, 'subject' => 'Successfully created account', 'email_heading' => 'Vendor account created', 'body_bg_color' => '#f5f5f5'), 'vendor_account_activation' => array('enable_disable' => true, 'subject' => 'account status', 'email_heading' => 'Vendor account activation', 'body_bg_color' => '#f5f5f5'), 'vendor_withdraw_request' => array('enable_disable' => true, 'subject' => 'Your Request for Withdrawal was Received', 'email_heading' => 'Withdraw request', 'body_bg_color' => '#f5f5f5'), 'vendor_withdraw_request_cancelled' => array('enable_disable' => true, 'subject' => 'Withdraw request has been cancelled', 'email_heading' => '', 'body_bg_color' => '#f5f5f5'), 'vendor_withdraw_request_completed' => array('enable_disable' => true, 'subject' => 'Withdraw request has been completed', 'email_heading' => '', 'body_bg_color' => '#f5f5f5'));
																		
                  if(Option::insert(array(
                    array(
                        'option_name'  =>  '_shipping_method_data',
                        'option_value' =>  serialize($shipping_method_array),
                        'created_at'   =>  date("y-m-d H:i:s", strtotime('now')),
                        'updated_at'   =>  date("y-m-d H:i:s", strtotime('now'))
                    ),
                    array(
                        'option_name'  =>  '_settings_data',
                        'option_value' =>  serialize($settings_array),
                        'created_at'   =>  date("y-m-d H:i:s", strtotime('now')),
                        'updated_at'   =>  date("y-m-d H:i:s", strtotime('now'))
                    ),
                    array(
                        'option_name'  =>  '_custom_designer_settings_data',
                        'option_value' =>  serialize($designer_settings),
                        'created_at'   =>  date("y-m-d H:i:s", strtotime('now')),
                        'updated_at'   =>  date("y-m-d H:i:s", strtotime('now'))
                    ),
                    array(
                        'option_name'  =>  '_payment_method_data',
                        'option_value' =>  serialize($payment_method_array),
                        'created_at'   =>  date("y-m-d H:i:s", strtotime('now')),
                        'updated_at'   =>  date("y-m-d H:i:s", strtotime('now'))
                    ),
                    array(
                        'option_name'  =>  '_appearance_tab_data',
                        'option_value' =>  serialize($appearance_tab),
                        'created_at'   =>  date("y-m-d H:i:s", strtotime('now')),
                        'updated_at'   =>  date("y-m-d H:i:s", strtotime('now'))
                    ),
                    array(
                        'option_name'  =>  '_permissions_files_list',
                        'option_value' =>  serialize($permissions_files),
                        'created_at'   =>  date("y-m-d H:i:s", strtotime('now')),
                        'updated_at'   =>  date("y-m-d H:i:s", strtotime('now'))
                    ),
                    array(
                        'option_name'  =>  '_seo_data',
                        'option_value' =>  serialize($seo_data),
                        'created_at'   =>  date("y-m-d H:i:s", strtotime('now')),
                        'updated_at'   =>  date("y-m-d H:i:s", strtotime('now'))
                    ),
                    array(
                        'option_name'  =>  '_subscription_data',
                        'option_value' =>  serialize($subscription),
                        'created_at'   =>  date("y-m-d H:i:s", strtotime('now')),
                        'updated_at'   =>  date("y-m-d H:i:s", strtotime('now'))
                    ),
                    array(
                        'option_name'  =>  '_subscription_settings_data',
                        'option_value' =>  serialize($subscription_settings),
                        'created_at'   =>  date("y-m-d H:i:s", strtotime('now')),
                        'updated_at'   =>  date("y-m-d H:i:s", strtotime('now'))
                    ),
                    array(
                        'option_name'  =>  '_vendor_settings_data',
                        'option_value' =>  serialize($vendor_settings_data),
                        'created_at'   =>  date("y-m-d H:i:s", strtotime('now')),
                        'updated_at'   =>  date("y-m-d H:i:s", strtotime('now'))
                    ),
                    array(
                        'option_name'  =>  '_emails_notification_data',
                        'option_value' =>  serialize($emails_data),
                        'created_at'   =>  date("y-m-d H:i:s", strtotime('now')),
                        'updated_at'   =>  date("y-m-d H:i:s", strtotime('now'))
                    )
                  ))){
                    
                    //package save
                    $vendor_package = new VendorPackage;
                    $package_data = array('max_number_product' => 100, 'show_map_on_store_page' => true, 'show_social_media_follow_btn_on_store_page' => true, 'show_social_media_share_btn_on_store_page' => true, 'show_contact_form_on_store_page' => true, 'vendor_expired_date_type' => 'lifetime', 'vendor_custom_expired_date' => '', 'vendor_commission' => 20, 'min_withdraw_amount' => 50);
                    $vendor_package->package_type  = 'Default'; 
                    $vendor_package->options       = json_encode($package_data);
                    $vendor_package->save();
                    
                    //save default store data
                    $user_details = new UsersDetail;
                    $vendor_data['profile_details'] = array('store_name' => 'admin', 'address_line_1' => 'address 1', 'address_line_2' => 'address 2', 'city' => 'city', 'state' => 'state', 'country' => 'country', 'zip_postal_code' => 2210, 'phone' => 123456);
                    
                    $vendor_data['general_details'] = array('cover_img' => '', 'vendor_home_page_cats' => '', 'google_map_app_key' => '', 'latitude' => '-25.363', 'longitude' => '131.044');
                    
                    $vendor_data['social_media'] = array('fb_follow_us_url' => '', 'twitter_follow_us_url' => '', 'linkedin_follow_us_url' => '', 'dribbble_follow_us_url' => '', 'google_plus_follow_us_url' => '', 'instagram_follow_us_url' => '', 'youtube_follow_us_url' => '');
                    
                    
                    $user_details->user_id  = $User->id; 
                    $user_details->details  = json_encode($vendor_data);
                    $user_details->save();
                    
                    
                    //save language
                    $manageLanguage = new ManageLanguage();
                  
                    $manageLanguage->lang_name              =    'english';
                    $manageLanguage->lang_code              =    'en';
                    $manageLanguage->lang_sample_img        =    'en_lang_sample_img.png';
                    $manageLanguage->status                 =    1;
                    $manageLanguage->default_lang           =    1;

                    if($manageLanguage->save()){
                      $permissions_list           =   array('manage_pages_full', 'pages_list_access', 'add_edit_delete_pages', 'manage_blog_manager_full', 'list_blogs_access', 'add_edit_delete_blog', 'blog_comments_list', 'blog_categories_access', 'manage_testimonial_full', 'testimonial_list_access', 'add_edit_delete_testimonial', 'manage_brands_full', 'brands_list_access', 'add_edit_delete_brands', 'manage_seo_full', 'manage_products_full', 'products_list_access', 'add_edit_delete_product', 'product_categories_access', 'product_tags_access', 'product_attributes_access', 'product_colors_access', 'product_sizes_access', 'products_comments_list_access', 'manage_orders_list', 'manage_reports_list','vendors_access_full', 'vendors_list_access', 'vendors_withdraw_access', 'vendors_refund_request_access', 'vendors_earning_reports_access', 'vendors_announcement_access', 'vendor_settings', 'vendors_packages_full_access', 'vendors_packages_list_access', 'vendors_packages_create_access', 'manage_shipping_method_menu_access', 'manage_payment_method_menu_access', 'manage_designer_elements_menu_access', 'manage_coupon_menu_access', 'manage_settings_menu_access', 'manage_requested_product_menu_access', 'manage_subscription_menu_access', 'manage_extra_features_access');
                      
                      $vendor_permissions_list   =    array('manage_seo_full', 'manage_products_full', 'products_list_access', 'add_edit_delete_product', 'products_comments_list_access', 'manage_orders_list', 'manage_reports_list', 'manage_shipping_method_menu_access', 'manage_payment_method_menu_access', 'manage_coupon_menu_access', 'vendors_withdraw_access', 'manage_requested_product_menu_access', 'manage_extra_features_access');
																						
                      
                      
                      if(UserRolePermission::insert(array(
                          array(
                                  'role_id'           =>  $get_user_role->id,
                                  'permissions'       =>  serialize($permissions_list),
                                  'created_at'				=>  date("y-m-d H:i:s", strtotime('now')),
                                  'updated_at'				=>  date("y-m-d H:i:s", strtotime('now'))
                          ),
                          array(
                                  'role_id'           =>  $get_vendor_role->id,
                                  'permissions'       =>  serialize($vendor_permissions_list),
                                  'created_at'				=>  date("y-m-d H:i:s", strtotime('now')),
                                  'updated_at'				=>  date("y-m-d H:i:s", strtotime('now'))
                          )		
                        ))){
                          return redirect()->route('admin.login');
                      }
                    }
                  }
                }
              }
          }
        }
      }
      else{
        return redirect()-> back();
      }
    }
  }
  
  /**
   * 
   * User registration
   *
   * @param null
   * @return void
   */
  public function userRegistration(){
    if( Request::isMethod('post') && Session::token() == Input::get('_token')){
      $data = Input::all();
      
      $rules = [
        'user_reg_display_name'          => 'required',
        'user_reg_name'                  => 'required|unique:users,name',
        'reg_email_id'                   => 'required|email|unique:users,email',
        'reg_password'                   => 'required|min:5|confirmed',
        'reg_password_confirmation'      => 'required|min:5',
        'reg_secret_key'                 => 'required'
      ];
      
      $messages = [
        'user_reg_display_name.required' => Lang::get('validation.display_name_required'),
        'user_reg_name.required' => Lang::get('validation.user_name_required'),
        'user_reg_name.unique' => Lang::get('validation.user_name_unique'),
        'reg_email_id.required' => Lang::get('validation.email_required'),
        'reg_email_id.unique' => Lang::get('validation.email_unique'),
        'reg_email_id.email' => Lang::get('validation.email_is_email'),
        'reg_password.required' => Lang::get('validation.password_required'),
        'reg_password_confirmation.required' => Lang::get('validation.password_confirmation_required'),
        'reg_secret_key.required' => Lang::get('validation.secret_key_required')
      ];
      
      if($this->recaptchaData['enable_recaptcha_for_user_registration'] == true){
        $rules['g-recaptcha-response']  = 'required|captcha';
        $messages['g-recaptcha-response.required']  =  Lang::get('validation.g_recaptcha_response_required');
      }
      
      $validator = Validator:: make($data, $rules, $messages);
      
      if($validator->fails()){
        return redirect()-> back()
        ->withInput()
        ->withErrors( $validator );
      }
      else{
        if(isset($this->settingsData['_settings_data']['general_settings']['general_options']['default_role_slug_for_site']) && !empty($this->settingsData['_settings_data']['general_settings']['general_options']['default_role_slug_for_site'])){
          $User =       new User;
          $Role =       new Role;
          $Roleuser =   new RoleUser;
          $email_options = get_emails_option_data();
          
          $get_role = Role::where(['slug' => $this->settingsData['_settings_data']['general_settings']['general_options']['default_role_slug_for_site']])->first();
          
          if(!empty($get_role->id)){
            $User->display_name       =    Input::get('user_reg_display_name');
            $User->name               =    Input::get('user_reg_name');
            $User->email              =    Input::get('reg_email_id');
            $User->password           =    bcrypt( trim(Input::get('reg_password')) );
            $User->user_photo_url     =    '';
            $User->user_status        =    1;
            $User->secret_key         =    bcrypt( trim(Input::get('reg_secret_key')) );

            if($User->save()){
              $Roleuser->user_id    =    $User->id;
              $Roleuser->role_id    =    $get_role->id;

              if($Roleuser->save()){
                if($email_options['new_customer_account']['enable_disable'] == true && $this->env === 'production'){
                  $this->classGetFunction->sendCustomMail( array('source' => 'new_customer_account', 'email' => Input::get('reg_email_id')) );
                }
                return redirect()->route('user-login-page');
              }
            }
          }
          else{
            Session::flash('error-message', Lang::get('frontend.user_role_not_selected_msg'));
            return redirect()-> back();
          }
        }
        else{
          Session::flash('error-message', Lang::get('frontend.user_role_not_selected_msg'));
          return redirect()-> back();
        }
      }
    }
    else{
      return redirect()-> back();
    }
  }
  
  /**
   * 
   * Vendor registration
   *
   * @param null
   * @return void
   */
  public function vendorRegistration(){
    if( Request::isMethod('post') && Session::token() == Input::get('_token')){
      $data = Input::all();
						
      $rules = [
        'vendor_reg_display_name'           => 'required',
        'vendor_reg_name'                   => 'required|unique:users,name',
        'vendor_reg_email_id'               => 'required|email|unique:users,email',
        'vendor_reg_password'               => 'required|min:5|confirmed',
        'vendor_reg_password_confirmation'  => 'required|min:5',
        'vendor_reg_store_name'             => 'required',
        'vendor_reg_address_line_1'         => 'required',
        'vendor_reg_city'                   => 'required',
        'vendor_reg_state'                  => 'required',
        'vendor_reg_country'                => 'required',
        'vendor_reg_zip_code'               => 'required',
        'vendor_reg_phone_number'           => 'required',
        'vendor_reg_secret_key'             => 'required',
        't_and_c'                           => 'required',          
      ];
      
      $messages = [
        'vendor_reg_display_name.required' => Lang::get('validation.display_name_required'),
        'vendor_reg_name.required' => Lang::get('validation.user_name_required'),
        'vendor_reg_name.unique' => Lang::get('validation.user_name_unique'),
        'vendor_reg_email_id.required' => Lang::get('validation.email_required'),
        'vendor_reg_email_id.unique' => Lang::get('validation.email_unique'),
        'vendor_reg_email_id.email' => Lang::get('validation.email_is_email'),
        'vendor_reg_password.required' => Lang::get('validation.password_required'),
        'vendor_reg_password_confirmation.required' => Lang::get('validation.password_confirmation_required'),
        'vendor_reg_store_name.required' => Lang::get('validation.vendor_reg_store_name'),
        'vendor_reg_address_line_1.required' => Lang::get('validation.vendor_reg_address_line_1'),
        'vendor_reg_city.required' => Lang::get('validation.vendor_reg_city'),
        'vendor_reg_state.required' => Lang::get('validation.vendor_reg_state'),
        'vendor_reg_country.required' => Lang::get('validation.vendor_reg_country'),
        'vendor_reg_zip_code.required' => Lang::get('validation.vendor_reg_zip_code'),
        'vendor_reg_phone_number.required' => Lang::get('validation.vendor_reg_phone_number'),
        'vendor_reg_secret_key.required' => Lang::get('validation.vendor_reg_secret_key'),
        't_and_c.required' => Lang::get('validation.t_and_c')
      ];
      
      if(isset($this->recaptchaData['enable_recaptcha_for_vendor_registration']) && $this->recaptchaData['enable_recaptcha_for_vendor_registration'] == true){
        $rules['g-recaptcha-response']  = 'required|captcha';
        $messages['g-recaptcha-response.required']  =  Lang::get('validation.g_recaptcha_response_required');
      }
      
      $validator = Validator:: make($data, $rules, $messages);
      
      if($validator->fails()){
        return redirect()-> back()
        ->withInput()
        ->withErrors( $validator );
      } else{
        
        $get_available_roles = get_roles_details_by_role_slug('vendor');
        				
        if (!empty($get_available_roles)) {
          $User = new User;
          $Roleuser = new RoleUser;
          $Userdetails = new UsersDetail;
          $email_options = get_emails_option_data();
          
          $User->display_name = Input::get('vendor_reg_display_name');
          $User->name = Input::get('vendor_reg_name');
          $User->email = Input::get('vendor_reg_email_id');
          $User->password = bcrypt(trim(Input::get('vendor_reg_password')));
          $User->user_photo_url = '';
          $User->user_status = 0;
          $User->secret_key = bcrypt(trim(Input::get('vendor_reg_secret_key')));

          if ($User->save()) {
            $Roleuser->user_id = $User->id;
            $Roleuser->role_id = $get_available_roles->id;

            if ($Roleuser->save()) {
              $get_package  = VendorPackage::where(['package_type' => 'Default'])->first();
              
              $vendor_data['profile_details'] = array('store_name' => Input::get('vendor_reg_store_name'), 'address_line_1' => Input::get('vendor_reg_address_line_1'), 'address_line_2' => Input::get('vendor_reg_address_line_2'), 'city' => Input::get('vendor_reg_city'), 'state' => Input::get('vendor_reg_state'), 'country' => Input::get('vendor_reg_country'), 'zip_postal_code' => Input::get('vendor_reg_zip_code'), 'phone' => Input::get('vendor_reg_phone_number'));
              
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
                if($email_options['vendor_new_account']['enable_disable'] == true && $this->env === 'production'){
                  $this->classGetFunction->sendCustomMail( array('source' => 'vendor_new_account', 'email' => Input::get('vendor_reg_email_id')) );
                }
                Session::flash('success-message', Lang::get('frontend.vendor_account_created_label'));
                return redirect()->back();
              }
            }
          }
        } else {
          Session::flash('error-message', Lang::get('frontend.not_role_selected_label'));
          return redirect()->back();
        }
      }
    } else {
      return redirect()->back();
    }
  }
}