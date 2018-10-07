<?php
namespace shopist\Http\Controllers;

use shopist\Http\Controllers\Controller;
use shopist\Http\Controllers\OptionController;
use Validator;
use Request;
use Session;
use shopist\Models\Option;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Lang;
use shopist\Models\ManageLanguage;
use shopist\Library\GetFunction;
use shopist\Library\CommonFunction;

class SettingsController extends Controller
{
  public $option;
  public $classGetFunction;
  public $classCommonFunction;
  
  public function __construct(){
    $this->option   =  new OptionController();
    $this->classGetFunction   =   new GetFunction();
    $this->classCommonFunction  =   new CommonFunction();
  }
  
  /**
   * 
   * General settings content
   *
   * @param null
   * @return response view
   */
  public function settingsGeneralContent(){
    $data = array();
    
    $data = $this->classCommonFunction->commonDataForAllPages();
    $data['user_role_list_data'] = get_available_user_roles();
    $data['settings_data']   =   $this->option->getSettingsData();
    
    return view('pages.admin.settings.general-content', $data);
  }
  
  /**
   * 
   * Languages settings content
   *
   * @param null
   * @return response view
   */
  public function settingsLanguagesContent(){
    $data = array();
    $get_avaliable_lang = array();     
    
    $data = $this->classCommonFunction->commonDataForAllPages();
    $get_avaliable_lang = get_available_languages_data();
    $data['lang_data'] = $get_avaliable_lang;
    
    return view('pages.admin.settings.languages-content', $data);
  }
  
  /**
   * 
   * Languages settings Update content
   *
   * @param null
   * @return response view
   */
  public function settingsLanguagesUpdateContent( $params ){
    $data = array();
    $get_avaliable_lang = array();     
    $get_lang_by_id = array();     
    
    $data = $this->classCommonFunction->commonDataForAllPages();
    $get_avaliable_lang = get_available_languages_data();
    $data['lang_data'] = $get_avaliable_lang;
    $get_lang_by_id = ManageLanguage::where(['id' => $params])->get()->toArray();
    $data['lang_data_by_id'] = array_shift($get_lang_by_id);
    
    return view('pages.admin.settings.languages-content', $data);
  }
  
  /**
   * 
   * Settings appearance content
   *
   * @param null
   * @return response view
   */
  public function settingsAppearanceContent(){
    $data = array();
    $templates_details        =   array(); 
    $header_details           =   array();
    $home_details             =   array();
    $blog_details             =   array();
    $product_details          =   array(); 
    $single_product_details   =   array();
    $selected_tab             =   '';

    $unserialize_appearance_data  =   current_appearance_settings();

    //header dir
    $header_dir_list              =   \File::glob(base_path('resources/views/frontend-templates/header/*'), GLOB_ONLYDIR);

    if(count($header_dir_list) > 0){
      foreach($header_dir_list as $dir_name){
        array_push($header_details, basename($dir_name));
      }
    }

    //home dir
    $home_dir_list              =   \File::glob(base_path('resources/views/frontend-templates/home/*'), GLOB_ONLYDIR);

    if(count($home_dir_list) > 0){
    foreach($home_dir_list as $dir_name){
      array_push($home_details, basename($dir_name));
    }
    }

    //blog dir
    $blog_dir_list              =   \File::glob(base_path('resources/views/frontend-templates/blog/*'), GLOB_ONLYDIR);

    if(count($blog_dir_list) > 0){
    foreach($blog_dir_list as $dir_name){
      array_push($blog_details, basename($dir_name));
    }
    }

    //product dir
    $product_dir_list           =   \File::glob(base_path('resources/views/frontend-templates/product/*'), GLOB_ONLYDIR);

    if(count($product_dir_list) > 0){
    foreach($product_dir_list as $dir_name){
      array_push($product_details, basename($dir_name));
    }
    }

    //single product dir
    $single_product_dir_list    =   \File::glob(base_path('resources/views/frontend-templates/single-product/*'), GLOB_ONLYDIR);

    if(count($single_product_dir_list) > 0){
    foreach($single_product_dir_list as $dir_name){
      array_push($single_product_details, basename($dir_name));
    }
    }

    if(Session::has('appearance_active_tab_name')){
    $selected_tab = Session::get('appearance_active_tab_name');
    Session::forget('appearance_active_tab_name');
    }

    $templates_details['header_details']            =   $header_details;
    $templates_details['home_details']              =   $home_details;
    $templates_details['blog_details']              =   $blog_details;
    $templates_details['product_details']           =   $product_details;
    $templates_details['single_product_details']    =   $single_product_details;
    $templates_details['appearance_tab']            =   $unserialize_appearance_data;
    $templates_details['current_tab']               =   $selected_tab;
    $templates_details['parent_cat']                =   get_product_parent_categories();
    
    $data = $this->classCommonFunction->commonDataForAllPages();
    $data['frontend_templates_details'] = $templates_details;   
    
    return view('pages.admin.settings.appearance-content', $data);
  }
  
  /**
   * 
   * Settings email content
   *
   * @param null
   * @return response view
   */
  public function settingsEmailContent(){
    $data = array();
    
    $data = $this->classCommonFunction->commonDataForAllPages();
    
    return view('pages.admin.settings.emails', $data);
  }
  
  /**
   * 
   * Settings email details content
   *
   * @param null
   * @return response view
   */
  public function settingsEmailDetailsContent(){
    $data = array();
    $email_temp = array();
    
    $temp_dir_list    =   \File::glob(base_path('resources/views/emails/order-confirmation/*'), GLOB_ONLYDIR);

    if(count($temp_dir_list) > 0){
      foreach($temp_dir_list as $dir_name){
        array_push($email_temp, basename($dir_name));
      }
    }
      
    $data = $this->classCommonFunction->commonDataForAllPages();
    $data['email_templates'] = $email_temp;
    $data['emails_notification_data'] = $this->option->getEmailsNotificationsData();
    
    return view('pages.admin.settings.email-content', $data);
  }
  
  
  /**
  * 
  * Update settings data
  *
  * @param null
  * @return void
  */
  public function updateSettingsData(){
    if( Request::isMethod('post') && Session::token() == Input::get('_token') ){
      $get_return_settings_data = array();
      
      if(Input::get('_settings_name') == 'general'){
        $is_reg_enable_at_frontend          = (Input::has('inputEnableDisableFrontendRegistration')) ? true : false;
        $is_guest_enable_at_frontend        = (Input::has('inputEnableGuestUser')) ? true : false;
        $is_login_enable_at_frontend        = (Input::has('inputEnableLoginUser')) ? true : false;
        $is_enable_recaptcha_admin_login    = (Input::has('inputEnableForAdmin')) ? true : false;
        $is_enable_recaptcha_user_login     = (Input::has('inputEnableForUser')) ? true : false;
        $is_enable_recaptcha_user_reg_login = (Input::has('inputEnableForUserReg')) ? true : false;
        
        $is_enable_recaptcha_vendor_login     = (Input::has('inputEnableForVendor')) ? true : false;
        $is_enable_recaptcha_vendor_reg_login = (Input::has('inputEnableForVendorReg')) ? true : false;
        
        $is_download_require_login_at_frontend     = (Input::has('inputLoginRestriction')) ? true : false;
        $is_access_downloadable_product_order_ty   = (Input::has('inputGrantAccessOrderDetails')) ? true : false;
        $is_access_downloadable_product_email      = (Input::has('inputGrantAccessEmail')) ? true : false;
        $is_enable_nexmo      = (Input::has('inputEnableNexmo')) ? true : false;
        
        
        $general_array = array(
            'general_options'     => array('site_title' => Input::get('inputSiteTitle'), 'email_address' => Input::get('inputEmailAddress'), 'site_logo' => Input::get('hf_site_picture'), 'allow_registration_for_frontend' => $is_reg_enable_at_frontend, 'default_role_slug_for_site' => Input::get('inputDefaultRoleForSite')),
            'taxes_options' => array('enable_status' => Input::get('inputTaxesOptions'), 'apply_tax_for' => Input::get('inputApplyTaxes'), 'tax_amount' => Input::get('inputTaxAmount')),
            'checkout_options'    => array('enable_guest_user' => $is_guest_enable_at_frontend, 'enable_login_user' => $is_login_enable_at_frontend),
            'downloadable_products_options'    => array('login_restriction' => $is_download_require_login_at_frontend, 'grant_access_from_thankyou_page' => $is_access_downloadable_product_order_ty, 'grant_access_from_email' => $is_access_downloadable_product_email), 
            'recaptcha_options'   => array('enable_recaptcha_for_admin_login' => $is_enable_recaptcha_admin_login, 'enable_recaptcha_for_user_login' => $is_enable_recaptcha_user_login, 'enable_recaptcha_for_user_registration' => $is_enable_recaptcha_user_reg_login, 'enable_recaptcha_for_vendor_login' => $is_enable_recaptcha_vendor_login, 'enable_recaptcha_for_vendor_registration' => $is_enable_recaptcha_vendor_reg_login, 'recaptcha_secret_key' => Input::get('inputRecaptchaSecretKey'), 'recaptcha_site_key' => Input::get('inputRecaptchaSiteKey')),
            'nexmo_config_option' => array('enable_nexmo_option' => $is_enable_nexmo, 'nexmo_key' => Input::get('inputNexmoKey'), 'nexmo_secret' => Input::get('inputNexmoSecret'), 'number_to' => Input::get('inputNexmoNumberTo'), 'number_from' => Input::get('inputNexmoNumberFrom'), 'message' => Input::get('inputNexmoSendingMessage')),
            'fixer_config_option' => array('fixer_api_access_key' => Input::get('inputCurrencyConverterAccessKey')),
            'currency_options' => array('currency_name' => Input::get('inputCurrency'), 'currency_position' => Input::get('inputCurrencyPosition'), 'thousand_separator' => Input::get('inputThousandSeparator'), 'decimal_separator' => Input::get('inputDecimalSeparator'), 'number_of_decimals' => Input::get('inputNumberofDecimals'), 'frontend_currency' => Input::get('selected_currency_for_frontend')),
            'date_format_options' => array('date_format' => Input::get('inputSelectFormat')),
            'default_frontend_currency' =>  Input::get('selected_currency_for_frontend')
        );
         
        $get_return_settings_data = $this->create_settings_array_data( Input::get('_settings_name'), $general_array );
      }
      
      $data = array(
                    'option_value'  =>  serialize($get_return_settings_data)
      );
      
      if( Option::where('option_name', '_settings_data')->update($data)){
        Session::flash('success-message', Lang::get('admin.successfully_updated_msg'));
        return redirect()->back();
      }
    }
    else {
      return redirect()-> back();
    }
  }
  
  /**
   * 
   * Settings data process
   *
   * @param array
   * @return array
   */
  public function create_settings_array_data($source, $array = array()){
    $return_settings_array  = array();
    $general_settings_array = array();
    
    $get_option = $this->option->getSettingsData();
    
    if($source == 'general'){
      $general_settings_array = $array;
    }
    else{
      $general_settings_array = $get_option['general_settings'];
    }
    
    $return_settings_array = array( 
        'general_settings'  => $general_settings_array
    );
    
    return $return_settings_array;
  }
  
  /**
   * 
   * Language zip file processing and settings for default and frontend
   *
   * @param null
   * @return void
   */
  public function manageLangFile($id = ''){
    if( Request::isMethod('post') && Session::token() == Input::get('_token') ){
      $input  = Input::all();
      $zip = new \ZipArchive;
      $destinationPath =  base_path('resources/lang/');
      $upload_folder   =  base_path('public/uploads/');
             
      if(isset($input['post_lang_file_upload']) || isset($input['post_lang_file_edit_option'])){
        $file   = Input::file('lang_file_upload');
        
        $rules = [
                    'inputLangName'    =>  'required',
                 ];

        $validator = Validator:: make($input, $rules);

        if($validator->fails()){
          return redirect()-> back()
          ->withInput()
          ->withErrors( $validator );
        }
        else{
          if(isset($input['post_lang_file_upload'])){
            if(isset($input['lang_file_upload']) && $file->getMimeType() == 'application/zip'){
              $fileName        =  $file->getClientOriginalName();
              $parseExtension  = explode('.', $fileName);


              if( !file_exists($destinationPath.$parseExtension[0])){
                $file->move($destinationPath, $fileName);

                if(file_exists($destinationPath.$fileName)){
                  if ($zip->open($destinationPath.$fileName) === TRUE) {
                    $zip->extractTo($destinationPath);
                    $zip->close();

                    if($parseExtension && count($parseExtension) > 0){
                      $folder_name = $parseExtension[0];
                    }
                    
                    if($folder_name){ 
                      if (file_exists($destinationPath.$folder_name.'/lang_sample_img.png')) {
                        if(rename($destinationPath.$folder_name.'/lang_sample_img.png', $upload_folder. $folder_name. "_lang_sample_img.png")){
                          $manageLanguage = new ManageLanguage();
																										
                          $manageLanguage->lang_name              =    $input['inputLangName'];
                          $manageLanguage->lang_code              =    $folder_name;
                          $manageLanguage->lang_sample_img        =    '/public/uploads/'.$folder_name. "_lang_sample_img.png";
                          $manageLanguage->status                 =    0;
                          $manageLanguage->default_lang           =    0;

                          if($manageLanguage->save()){
                            //unlink($destinationPath.$fileName);
                            Session::flash('success-message', Lang::get('admin.zip_file_success_msg'));
                            return redirect()-> back();
                          }
                        }
                      }
                      else {
                        if(file_exists($destinationPath.$folder_name) && is_dir($destinationPath.$folder_name)){
                          $this->classGetFunction->removeDirectory($destinationPath.$folder_name);
                        }
                        
                        if(file_exists($destinationPath.$fileName)){
                          unlink($destinationPath.$fileName);
                        }
                        
                        Session::flash('error-message', Lang::get('admin.lang_sample_img_missing'));
                        return redirect()-> back();
                      }
                    }
                  } 
                  else{
                    Session::flash('error-message', Lang::get('admin.zip_file_validation_msg'));
                    return redirect()-> back();
                  }
                }
                else{
                  Session::flash('error-message', Lang::get('admin.lang_file_no_exists'));
                  return redirect()-> back();
                }
              }
              else{
                Session::flash('error-message', Lang::get('admin.file_exists'));
                return redirect()-> back();
              }
            }
            else{
              Session::flash('error-message', Lang::get('admin.zip_file_validation_msg'));
              return redirect()-> back();
            }
          }
          elseif(isset($input['post_lang_file_edit_option'])){
            $data = array();
            $data['lang_name'] = $input['inputLangName'];
            
            
            if(isset($input['lang_file_upload'])){
              if($file->getMimeType() == 'application/zip'){
                $fileName        =  $file->getClientOriginalName();
                $parseExtension  =  explode('.', $fileName);
                $get_lang_data   =  ManageLanguage::where(['id' => $id])->get()->toArray();
                $get_lang_by_id  =  array_shift($get_lang_data);
                
                if( file_exists($destinationPath.$parseExtension[0]) && $get_lang_by_id['lang_code'] == $parseExtension[0] || !file_exists($destinationPath.$parseExtension[0])){  
                  if(file_exists($destinationPath.$get_lang_by_id['lang_code'])){
                    if(is_dir($destinationPath.$get_lang_by_id['lang_code'])){
                      $this->classGetFunction->removeDirectory($destinationPath.$get_lang_by_id['lang_code']);
                    }
                  }
                  
                  if(file_exists($destinationPath.$get_lang_by_id['lang_code'].'.zip')){
                    unlink($destinationPath.$get_lang_by_id['lang_code'].'.zip');
                  }
                  
                  if(file_exists($upload_folder.$get_lang_by_id['lang_sample_img'])){
                    unlink($upload_folder.$get_lang_by_id['lang_sample_img']);
                  }
                  

                  $file->move($destinationPath, $fileName);
                  
                  if(file_exists($destinationPath.$fileName)){
                    if ($zip->open($destinationPath.$fileName) === TRUE){
                      $zip->extractTo($destinationPath);
                      $zip->close();
                      
                      if($parseExtension && count($parseExtension) > 0){
                        $folder_name = $parseExtension[0];
                      }
                      
                      if($folder_name){
                        if (file_exists($destinationPath.$folder_name.'/lang_sample_img.png')) {
                          if(rename($destinationPath.$folder_name.'/lang_sample_img.png', $upload_folder. $folder_name. "_lang_sample_img.png")){
                            $data['lang_code']        =  $folder_name;
                            $data['lang_sample_img']  =  $folder_name. "_lang_sample_img.png";
                          }
                        }
                        else {
                          if(file_exists($destinationPath.$folder_name) && is_dir($destinationPath.$folder_name)){
                            $this->classGetFunction->removeDirectory($destinationPath.$folder_name);
                          }
                          
                          if(file_exists($destinationPath.$fileName)){
                            unlink($destinationPath.$fileName);
                          }
                          
                          //unlink($destinationPath.$folder_name);
                          Session::flash('error-message', Lang::get('admin.lang_sample_img_missing'));
                          return redirect()-> back();
                        }
                      }
                    }
                    else{
                      Session::flash('error-message', Lang::get('admin.zip_file_validation_msg'));
                      return redirect()-> back();
                    }
                  }
                  else{
                    Session::flash('error-message', Lang::get('admin.lang_file_no_exists'));
                    return redirect()-> back();
                  }
                }
                else{
                  Session::flash('error-message', Lang::get('admin.file_exists'));
                  return redirect()-> back();
                }
              }
              else{
                Session::flash('error-message', Lang::get('admin.zip_file_validation_msg'));
                return redirect()-> back();
              }
            }
            
            
            if(count($data) > 0){
              if(ManageLanguage::where(['id' => $id])->update( $data )){
                Session::flash('success-message', Lang::get('admin.zip_file_success_updated_msg'));
                return redirect()-> route('admin.languages_settings_content');
              }
            }
          }
        }
      }
      elseif(isset($input['post_lang_settings'])){
        $get_lang_all = get_available_languages_data();
        $is_enabled   = false;
        $frontend_ary = array();
        $default_ary  = array();
        
        if(isset($input['switching_for_frontend']) && count($input['switching_for_frontend']) >0){
          $frontend_ary = $input['switching_for_frontend']; 
        }
        
        if(isset($input['switching_for_default']) && count($input['switching_for_default']) >0){
          $default_ary = $input['switching_for_default']; 
        }
        
        if(count($get_lang_all)>0){
          foreach($get_lang_all as $row){
            if( ( count($frontend_ary) > 0 && in_array($row['id'], $frontend_ary) ) && ( count($default_ary) > 0 && in_array($row['id'], $default_ary) ) ){
              $data = array(
                            'status'         =>    1,
                            'default_lang'   =>    1
              );

              if( ManageLanguage::where(['id' => $row['id']])->update( $data )){
                $is_enabled = true;
              }
            }
            elseif( ( count($default_ary) > 0 && in_array($row['id'], $default_ary) ) ){
              $data = array(
                            'status'         =>    0,
                            'default_lang'   =>    1
              );

              if( ManageLanguage::where(['id' => $row['id']])->update( $data )){
                $is_enabled = true;
              }
            }
            elseif( ( count($frontend_ary) > 0 && in_array($row['id'], $frontend_ary) ) ){
              $data = array(
                            'status'         =>    1,
                            'default_lang'   =>    0
              );

              if( ManageLanguage::where(['id' => $row['id']])->update( $data )){
                $is_enabled = true;
              }
            }
            else{
              $data = array(
                            'status'         =>    0,
                            'default_lang'   =>    0
              );

              if( ManageLanguage::where(['id' => $row['id']])->update( $data )){
                $is_enabled = true;
              }
            }
          }
        
          if($is_enabled){
            Session::flash('success-message', Lang::get('admin.update_language_settings_msg'));
            return redirect()-> back();
          }
        }
      }
    }
    else{
      return redirect()-> back();
    }
  }
  
  /**
   * 
   * Save appearance settings data 
   *
   * @param null
   * @return void
   */
  public function saveAppearanceSettingsData(){
    if( Request::isMethod('post') && Session::token() == Input::get('_token') ){
      $is_slider_enable             = false;
      $is_custom_css_enable         = false;
      $is_general_custom_css_enable = false;
      
      
      $unserialize_appearance_data  =   $this->option->getAppearanceData();
      
     
      if(Input::has('inputVisibilitySlider')){
        $is_slider_enable = true;
      }
      
      if(Input::has('inputHeaderCustomCSS')){
        $is_custom_css_enable = true;
      }
      
      if(Input::has('inputGeneralCustomCSS')){
        $is_general_custom_css_enable = true;
      }
       
      if(isset($unserialize_appearance_data['settings'])){
        $unserialize_appearance_data['settings'] = Input::get('_frontend_images_json');
      }
      
      if(isset($unserialize_appearance_data['settings_details']['header_details'])){
        if(isset($unserialize_appearance_data['settings_details']['header_details']['slider_visibility'])){
          $unserialize_appearance_data['settings_details']['header_details']['slider_visibility'] = $is_slider_enable;
        }
        
        if(isset($unserialize_appearance_data['settings_details']['header_details']['custom_css'])){
          $unserialize_appearance_data['settings_details']['header_details']['custom_css'] = $is_custom_css_enable;
        }
        
        if(isset($unserialize_appearance_data['settings_details']['header_details']['header_top_gradient_start_color'])){
          $unserialize_appearance_data['settings_details']['header_details']['header_top_gradient_start_color'] = Input::get('header_top_bg_start_color');
        }
        
        if(isset($unserialize_appearance_data['settings_details']['header_details']['header_top_gradient_end_color'])){
          $unserialize_appearance_data['settings_details']['header_details']['header_top_gradient_end_color'] = Input::get('header_top_bg_end_color');
        }
        
        if(isset($unserialize_appearance_data['settings_details']['header_details']['header_bottom_gradient_start_color'])){
          $unserialize_appearance_data['settings_details']['header_details']['header_bottom_gradient_start_color'] = Input::get('header_bottom_bg_start_color');
        }
        
        if(isset($unserialize_appearance_data['settings_details']['header_details']['header_bottom_gradient_end_color'])){
          $unserialize_appearance_data['settings_details']['header_details']['header_bottom_gradient_end_color'] = Input::get('header_bottom_bg_end_color');
        }
        
        if(isset($unserialize_appearance_data['settings_details']['header_details']['header_text_color'])){
          $unserialize_appearance_data['settings_details']['header_details']['header_text_color'] = Input::get('header_text_color');
        }
        
        if(isset($unserialize_appearance_data['settings_details']['header_details']['header_text_hover_color'])){
          $unserialize_appearance_data['settings_details']['header_details']['header_text_hover_color'] = Input::get('header_text_hover_color');
        }
        
        if(isset($unserialize_appearance_data['settings_details']['header_details']['header_text_size'])){
          $unserialize_appearance_data['settings_details']['header_details']['header_text_size'] = Input::get('header_text_size');
        }
        
        if(isset($unserialize_appearance_data['settings_details']['header_details']['header_selected_menu_bg_color'])){
          $unserialize_appearance_data['settings_details']['header_details']['header_selected_menu_bg_color'] = Input::get('header_selected_menu_bg_color');
        }
        
        if(isset($unserialize_appearance_data['settings_details']['header_details']['header_selected_menu_text_color'])){
          $unserialize_appearance_data['settings_details']['header_details']['header_selected_menu_text_color'] = Input::get('header_selected_menu_text_color');
        }
        
        if(isset($unserialize_appearance_data['settings_details']['header_details']['header_slogan'])){
          $unserialize_appearance_data['settings_details']['header_details']['header_slogan'] = Input::get('header_slogan');
        }
      }
      
      if(isset($unserialize_appearance_data['settings_details']['home_details'])){
        $unserialize_appearance_data['settings_details']['home_details']['cat_list_to_display'] = Input::get('inputSelectCatForHomePage');
      }
      
      if(isset($unserialize_appearance_data['settings_details']['home_details'])){
        $unserialize_appearance_data['settings_details']['home_details']['cat_collection_list_to_display'] = Input::get('inputSelectCatCollectionForHomePage');
      }
      
      if(isset($unserialize_appearance_data['settings_details']['footer_details'])){
        if(isset($unserialize_appearance_data['settings_details']['footer_details']['footer_about_us_description'])){
          $unserialize_appearance_data['settings_details']['footer_details']['footer_about_us_description'] = Input::get('about_us_description_editor');
        }
        
        if(isset($unserialize_appearance_data['settings_details']['footer_details']['follow_us_url']['fb'])){
          $unserialize_appearance_data['settings_details']['footer_details']['follow_us_url']['fb'] = Input::get('fb_follow_us_url');
        }
        
        if(isset($unserialize_appearance_data['settings_details']['footer_details']['follow_us_url']['twitter'])){
          $unserialize_appearance_data['settings_details']['footer_details']['follow_us_url']['twitter'] = Input::get('twitter_follow_us_url');
        }
        
        if(isset($unserialize_appearance_data['settings_details']['footer_details']['follow_us_url']['linkedin'])){
          $unserialize_appearance_data['settings_details']['footer_details']['follow_us_url']['linkedin'] = Input::get('linkedin_follow_us_url');
        }
        
        if(isset($unserialize_appearance_data['settings_details']['footer_details']['follow_us_url']['dribbble'])){
          $unserialize_appearance_data['settings_details']['footer_details']['follow_us_url']['dribbble'] = Input::get('dribbble_follow_us_url');
        }
        
        if(isset($unserialize_appearance_data['settings_details']['footer_details']['follow_us_url']['google_plus'])){
          $unserialize_appearance_data['settings_details']['footer_details']['follow_us_url']['google_plus'] = Input::get('google_plus_follow_us_url');
        }
        
        if(isset($unserialize_appearance_data['settings_details']['footer_details']['follow_us_url']['instagram'])){
          $unserialize_appearance_data['settings_details']['footer_details']['follow_us_url']['instagram'] = Input::get('instagram_follow_us_url');
        }
        
        if(isset($unserialize_appearance_data['settings_details']['footer_details']['follow_us_url']['youtube'])){
          $unserialize_appearance_data['settings_details']['footer_details']['follow_us_url']['youtube'] = Input::get('youtube_follow_us_url');
        }
      }
      
      if(isset($unserialize_appearance_data['settings_details']['general'])){
        if(isset($unserialize_appearance_data['settings_details']['general']['custom_css'])){
          $unserialize_appearance_data['settings_details']['general']['custom_css'] = $is_general_custom_css_enable;
        }
        
        if(isset($unserialize_appearance_data['settings_details']['general']['body_bg_color'])){
          $unserialize_appearance_data['settings_details']['general']['body_bg_color'] = Input::get('general_settings_body_bg');
        }
        
        if(isset($unserialize_appearance_data['settings_details']['general']['filter_price_min'])){
          $unserialize_appearance_data['settings_details']['general']['filter_price_min'] = Input::get('min_filter_price');
        }
        
        if(isset($unserialize_appearance_data['settings_details']['general']['filter_price_max'])){
          $unserialize_appearance_data['settings_details']['general']['filter_price_max'] = Input::get('max_filter_price');
        }
       
        if(isset($unserialize_appearance_data['settings_details']['general']['sidebar_panel_bg_color'])){
          $unserialize_appearance_data['settings_details']['general']['sidebar_panel_bg_color'] = Input::get('sidebar_panel_bg_color');
        }
        
        if(isset($unserialize_appearance_data['settings_details']['general']['sidebar_panel_title_text_color'])){
          $unserialize_appearance_data['settings_details']['general']['sidebar_panel_title_text_color'] = Input::get('sidebar_panel_title_text_color');
        }
        
        if(isset($unserialize_appearance_data['settings_details']['general']['sidebar_panel_title_text_bottom_border_color'])){
          $unserialize_appearance_data['settings_details']['general']['sidebar_panel_title_text_bottom_border_color'] = Input::get('sidebar_panel_title_text_bottom_border');
        }
        
        if(isset($unserialize_appearance_data['settings_details']['general']['sidebar_panel_content_text_color'])){
          $unserialize_appearance_data['settings_details']['general']['sidebar_panel_content_text_color'] = Input::get('sidebar_panel_content_text_color');
        }
        
        if(isset($unserialize_appearance_data['settings_details']['general']['product_box_bg_color'])){
          $unserialize_appearance_data['settings_details']['general']['product_box_bg_color'] = Input::get('product_box_bg_color');
        }
        
        if(isset($unserialize_appearance_data['settings_details']['general']['product_box_border_color'])){
          $unserialize_appearance_data['settings_details']['general']['product_box_border_color'] = Input::get('product_box_border_color');
        }
        
        if(isset($unserialize_appearance_data['settings_details']['general']['product_box_text_color'])){
          $unserialize_appearance_data['settings_details']['general']['product_box_text_color'] = Input::get('product_box_content_color');
        }
        
        if(isset($unserialize_appearance_data['settings_details']['general']['product_box_btn_bg_color'])){
          $unserialize_appearance_data['settings_details']['general']['product_box_btn_bg_color'] = Input::get('product_box_btn_bg_color');
        }
        
        if(isset($unserialize_appearance_data['settings_details']['general']['btn_text_color'])){
          $unserialize_appearance_data['settings_details']['general']['btn_text_color'] = Input::get('btn_text_color');
        }
        
        if(isset($unserialize_appearance_data['settings_details']['general']['product_box_btn_hover_color'])){
          $unserialize_appearance_data['settings_details']['general']['product_box_btn_hover_color'] = Input::get('product_box_btn_hover_color');
        }
        
        if(isset($unserialize_appearance_data['settings_details']['general']['btn_hover_text_color'])){
          $unserialize_appearance_data['settings_details']['general']['btn_hover_text_color'] = Input::get('btn_hover_text_color');
        }
        
        if(isset($unserialize_appearance_data['settings_details']['general']['sidebar_panel_title_text_font_size'])){
          $unserialize_appearance_data['settings_details']['general']['sidebar_panel_title_text_font_size'] = Input::get('sidebar_panel_title_text_size');
        }
        
        if(isset($unserialize_appearance_data['settings_details']['general']['sidebar_panel_content_text_font_size'])){
          $unserialize_appearance_data['settings_details']['general']['sidebar_panel_content_text_font_size'] = Input::get('sidebar_panel_content_text_size');
        }
        
        if(isset($unserialize_appearance_data['settings_details']['general']['product_box_text_font_size'])){
          $unserialize_appearance_data['settings_details']['general']['product_box_text_font_size'] = Input::get('product_box_content_text_size');
        }
        
        if(isset($unserialize_appearance_data['settings_details']['general']['selected_menu_border_color'])){
          $unserialize_appearance_data['settings_details']['general']['selected_menu_border_color'] = Input::get('selected_menu_border_color');
        }
        
        if(isset($unserialize_appearance_data['settings_details']['general']['pages_content_title_border_color'])){
          $unserialize_appearance_data['settings_details']['general']['pages_content_title_border_color'] = Input::get('pages_content_title_border_color');
        }
      }
      
      $data = array(
                    'option_value'  => serialize($unserialize_appearance_data)
      );
      
      if( Option::where('option_name', '_appearance_tab_data')->update($data)){
        return redirect()-> back();
      }
    }
  }
		
		/**
   * 
   * Save email notifications content data
   *
   * @param null
   * @return void
   */
		public function saveEmailsContentData(){
      if( Request::isMethod('post') && Session::token() == Input::get('_token') ){
        $emails_data  =  $this->option->getEmailsNotificationsData();

        if(Input::has('email_type') && Input::get('email_type') == 'new_order'){
          $is_new_order_enable = false;

          if(Input::has('new_order_enable_disable')){
            $is_new_order_enable = true;
          }

          $emails_data['new_order']['enable_disable']			 =		$is_new_order_enable;
          $emails_data['new_order']['subject']				     =		Input::get('new_order_subject');
          $emails_data['new_order']['email_heading']			 =    Input::get('new_order_email_heading');
          $emails_data['new_order']['body_bg_color']			 =		Input::get('new_order_body_bg_color');
          $emails_data['new_order']['selected_template']   =    Input::get('templates_name');
        }
        elseif(Input::has('email_type') && Input::get('email_type') == 'cancelled_order'){
          $is_cancelled_order_enable = false;

          if(Input::has('cancelled_order_enable_disable')){
            $is_cancelled_order_enable = true;
          }

          $emails_data['cancelled_order']['enable_disable']			 =		$is_cancelled_order_enable;
          $emails_data['cancelled_order']['subject']				     =		Input::get('cancelled_order_subject');
          $emails_data['cancelled_order']['email_heading']			 =    Input::get('cancelled_order_email_heading');
          $emails_data['cancelled_order']['body_bg_color']			 =		Input::get('cancelled_order_body_bg_color');
        }
        elseif(Input::has('email_type') && Input::get('email_type') == 'processed_order'){
          $is_processed_order_enable = false;

          if(Input::has('processed_order_enable_disable')){
            $is_processed_order_enable = true;
          }

          $emails_data['processed_order']['enable_disable']			 =		$is_processed_order_enable;
          $emails_data['processed_order']['subject']				     =		Input::get('processed_order_subject');
          $emails_data['processed_order']['email_heading']			 =    Input::get('processed_order_email_heading');
          $emails_data['processed_order']['body_bg_color']			 =		Input::get('processed_order_body_bg_color');
        }
        elseif(Input::has('email_type') && Input::get('email_type') == 'completed_order'){
          $is_completed_order_enable = false;

          if(Input::has('completed_order_enable_disable')){
            $is_completed_order_enable = true;
          }

          $emails_data['completed_order']['enable_disable']			 =		$is_completed_order_enable;
          $emails_data['completed_order']['subject']				     =		Input::get('completed_order_subject');
          $emails_data['completed_order']['email_heading']			 =    Input::get('completed_order_email_heading');
          $emails_data['completed_order']['body_bg_color']			 =		Input::get('completed_order_body_bg_color');
        }
        elseif(Input::has('email_type') && Input::get('email_type') == 'new_customer_account'){
          $is_new_customer_account_enable = false;

          if(Input::has('new_customer_account_enable_disable')){
            $is_new_customer_account_enable = true;
          }

          $emails_data['new_customer_account']['enable_disable']		 =		$is_new_customer_account_enable;
          $emails_data['new_customer_account']['subject']				     =		Input::get('new_customer_account_subject');
          $emails_data['new_customer_account']['email_heading']			 =    '';
          $emails_data['new_customer_account']['body_bg_color']			 =		'';
        }
        elseif(Input::has('email_type') && Input::get('email_type') == 'vendor_new_customer_account'){
          $is_vendor_new_account_enable = false;

          if(Input::has('vendor_new_account_enable_disable')){
            $is_vendor_new_account_enable = true;
          }

          $emails_data['vendor_new_account']['enable_disable']		 =		$is_vendor_new_account_enable;
          $emails_data['vendor_new_account']['subject']				     =		Input::get('vendor_new_account_subject');
          $emails_data['vendor_new_account']['email_heading']			 =    '';
          $emails_data['vendor_new_account']['body_bg_color']			 =		'';
        }
        elseif(Input::has('email_type') && Input::get('email_type') == 'vendor_account_activation'){
          $is_vendor_account_activation_enable = false;

          if(Input::has('vendor_account_activation_enable_disable')){
            $is_vendor_account_activation_enable = true;
          }

          $emails_data['vendor_account_activation']['enable_disable']		 =		$is_vendor_account_activation_enable;
          $emails_data['vendor_account_activation']['subject']				   =		Input::get('vendor_account_activation_subject');
          $emails_data['vendor_account_activation']['email_heading']		 =    '';
          $emails_data['vendor_account_activation']['body_bg_color']		=		  '';
        }
        elseif(Input::has('email_type') && Input::get('email_type') == 'vendor_withdraw_request'){
          $is_vendor_withdraw_request_enable = false;

          if(Input::has('vendor_withdraw_request_enable_disable')){
            $is_vendor_withdraw_request_enable = true;
          }

          $emails_data['vendor_withdraw_request']['enable_disable']		 =		$is_vendor_withdraw_request_enable;
          $emails_data['vendor_withdraw_request']['subject']				   =		Input::get('vendor_withdraw_request_subject');
          $emails_data['vendor_withdraw_request']['email_heading']		 =    '';
          $emails_data['vendor_withdraw_request']['body_bg_color']		 =		'';
        }
        elseif(Input::has('email_type') && Input::get('email_type') == 'vendor_withdraw_request_cancelled'){
          $is_vendor_withdraw_request_cancelled_enable = false;

          if(Input::has('vendor_withdraw_request_cancelled_enable_disable')){
            $is_vendor_withdraw_request_cancelled_enable = true;
          }

          $emails_data['vendor_withdraw_request_cancelled']['enable_disable']		 =		$is_vendor_withdraw_request_cancelled_enable;
          $emails_data['vendor_withdraw_request_cancelled']['subject']				   =		Input::get('vendor_withdraw_request_cancelled_subject');
          $emails_data['vendor_withdraw_request_cancelled']['email_heading']		 =    '';
          $emails_data['vendor_withdraw_request_cancelled']['body_bg_color']		 =		'';
        }
        elseif(Input::has('email_type') && Input::get('email_type') == 'vendor_withdraw_request_completed'){
          $is_vendor_withdraw_request_completed_enable = false;

          if(Input::has('vendor_withdraw_request_completed_enable_disable')){
            $is_vendor_withdraw_request_completed_enable = true;
          }

          $emails_data['vendor_withdraw_request_completed']['enable_disable']		 =		$is_vendor_withdraw_request_completed_enable;
          $emails_data['vendor_withdraw_request_completed']['subject']				   =		Input::get('vendor_withdraw_request_completed_subject');
          $emails_data['vendor_withdraw_request_completed']['email_heading']		 =    '';
          $emails_data['vendor_withdraw_request_completed']['body_bg_color']		 =		'';
        }

        $data = array(
                'option_value'  => serialize($emails_data)
        );

        if( Option::where('option_name', '_emails_notification_data')->update($data)){
          Session::flash('success-message', Lang::get('admin.successfully_updated_msg'));
          return redirect()-> back();
        }
      }
		}	
}