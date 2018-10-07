<?php
namespace shopist\Library;

use shopist\Http\Controllers\OptionController;
use shopist\Http\Controllers\CMSController;
use shopist\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\App;
use shopist\Models\Role;
use Cookie;
use Session;
use shopist\Models\Post;
use shopist\Models\PostExtra;
use shopist\Models\OrdersItem;
use shopist\Models\DownloadExtra;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use shopist\Models\UsersDetail;
use Anam\Phpcart\Cart;
use Illuminate\Support\Facades\URL;
use Nexmo\Laravel\Facade\Nexmo;

class CommonFunction
{
  public $cart;
  
  public function __construct() {
    $this->cart =  new Cart();
  }
  public function get_currency_symbol( $currency = '' ){
    switch ( $currency ) {
		case 'AED' :
			$currency_symbol = 'د.إ';
			break;
		case 'AUD' :
		case 'ARS' :
		case 'CAD' :
		case 'CLP' :
		case 'COP' :
		case 'HKD' :
		case 'MXN' :
		case 'NZD' :
		case 'SGD' :
		case 'USD' :
			$currency_symbol = '&#36;';
			break;
		case 'BDT':
			$currency_symbol = '&#2547;&nbsp;';
			break;
		case 'BGN' :
			$currency_symbol = '&#1083;&#1074;.';
			break;
		case 'BRL' :
			$currency_symbol = '&#82;&#36;';
			break;
		case 'CHF' :
			$currency_symbol = '&#67;&#72;&#70;';
			break;
		case 'CNY' :
		case 'JPY' :
		case 'RMB' :
			$currency_symbol = '&yen;';
			break;
		case 'CZK' :
			$currency_symbol = '&#75;&#269;';
			break;
		case 'DKK' :
			$currency_symbol = 'DKK';
			break;
		case 'DOP' :
			$currency_symbol = 'RD&#36;';
			break;
		case 'EGP' :
			$currency_symbol = 'EGP';
			break;
		case 'EUR' :
			$currency_symbol = '&euro;';
			break;
		case 'GBP' :
			$currency_symbol = '&pound;';
			break;
		case 'HRK' :
			$currency_symbol = 'Kn';
			break;
		case 'HUF' :
			$currency_symbol = '&#70;&#116;';
			break;
		case 'IDR' :
			$currency_symbol = 'Rp';
			break;
		case 'ILS' :
			$currency_symbol = '&#8362;';
			break;
		case 'INR' :
			$currency_symbol = 'Rs.';
			break;
		case 'ISK' :
			$currency_symbol = 'Kr.';
			break;
		case 'KIP' :
			$currency_symbol = '&#8365;';
			break;
		case 'KRW' :
			$currency_symbol = '&#8361;';
			break;
		case 'MYR' :
			$currency_symbol = '&#82;&#77;';
			break;
		case 'NGN' :
			$currency_symbol = '&#8358;';
			break;
		case 'NOK' :
			$currency_symbol = '&#107;&#114;';
			break;
		case 'NPR' :
			$currency_symbol = 'Rs.';
			break;
		case 'PHP' :
			$currency_symbol = '&#8369;';
			break;
		case 'PLN' :
			$currency_symbol = '&#122;&#322;';
			break;
		case 'PYG' :
			$currency_symbol = '&#8370;';
			break;
		case 'RON' :
			$currency_symbol = 'lei';
			break;
		case 'RUB' :
			$currency_symbol = '&#1088;&#1091;&#1073;.';
			break;
		case 'SEK' :
			$currency_symbol = '&#107;&#114;';
			break;
		case 'THB' :
			$currency_symbol = '&#3647;';
			break;
		case 'TRY' :
			$currency_symbol = '&#8378;';
			break;
		case 'TWD' :
			$currency_symbol = '&#78;&#84;&#36;';
			break;
		case 'UAH' :
			$currency_symbol = '&#8372;';
			break;
		case 'VND' :
			$currency_symbol = '&#8363;';
			break;
		case 'ZAR' :
			$currency_symbol = '&#82;';
			break;
		default :
			$currency_symbol = '';
			break;
    }

    return $currency_symbol;
  }
  
  public function is_item_already_exists_in_array($index, $data = array()){
    $is_exists = false;
    
    if(count($data) > 0){
      foreach($data as $count){
        if(isset($count['id'])){
          if($index == $count['id']){
            $is_exists = true;
            break;
          }
          else{
            $is_exists = false;
          }
        }
      }
    }
    else{
      $is_exists = false;
    }
    
    return $is_exists;
  }
  
  /**
   * convert given price using currency
   *
   * @param currency from, currency to, convert amount
   * @return string
   */ 
  public function convertCurrency($from, $to, $amount){
    $convert_amount = null;
    $option  =  new OptionController();
    $get_settings_option = $option->getSettingsData();
    
    $endpoint = 'convert';
    $access_key = $get_settings_option['general_settings']['fixer_config_option']['fixer_api_access_key'];

    // initialize CURL:
    $ch = curl_init('https://data.fixer.io/api/'.$endpoint.'?access_key='.$access_key.'&from='.$from.'&to='.$to.'&amount='.$amount.'');   
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // get the JSON data:
    $json = curl_exec($ch);
    curl_close($ch);

    // Decode JSON response:
    $conversionResult = json_decode($json, true);
    if(isset($conversionResult['success']) && $conversionResult['success'] && isset($conversionResult['result'])){
      $convert_amount = $conversionResult['result'];
    }

    return $convert_amount;
	}
  
  public function get_dynamic_frontend_content_data(){
    $data_ary = array();
    $product =  new ProductsController();
    $CMS     =  new CMSController();
    $option  =  new OptionController();
    
    //set language
    $this->set_frontend_lang();
    
    $get_settings_option = $option->getSettingsData();

    $data_ary['_currency_symbol']              =  $this->get_currency_symbol( $get_settings_option['general_settings']['currency_options']['currency_name'] );
    $data_ary['currency_symbol']              =   $get_settings_option['general_settings']['currency_options']['currency_name'];
    $data_ary['appearance_settings']          =   current_appearance_settings();
    $data_ary['appearance_all_data']          =   get_appearance_settings();
    $data_ary['blogs_data']                   =   $CMS->get_latest_blogs();
    $data_ary['popular_tags_list']            =   $product->getTermData( 'product_tag', false, null, 1 );
    $localization_array                       =   array('proceed_to_payPal' => Lang::get('frontend-js.proceed_to_payPal'), 'proceed_to_stripe' => Lang::get('frontend-js.proceed_to_stripe'), 'place_order' => Lang::get('frontend-js.place_order'), 'please_enter_valid_email' => Lang::get('frontend-js.please_enter_valid_email'), 'please_enter_email' => Lang::get('frontend-js.please_enter_email'), 'email_subscribed_successfully' => Lang::get('frontend-js.email_subscribed_successfully'), 'please_recheck_your_email' => Lang::get('frontend-js.please_recheck_your_email'), 'price_can_not_be_zero' => Lang::get('frontend-js.price_can_not_be_zero'), 'product_out_of_stock' => Lang::get('frontend-js.product_out_of_stock'), 'item_added_successfully' => Lang::get('frontend-js.item_added_successfully'), 'want_to_view_cart' => Lang::get('frontend-js.want_to_view_cart'), 'offer_msg' => Lang::get('frontend-js.offer_msg'), 'to' => Lang::get('frontend-js.to'), 'stock_available' => Lang::get('frontend-js.stock_available'), 'out_of_stock' => Lang::get('frontend-js.out_of_stock'), 'maxfilesexceeded_msg' => Lang::get('designer.maxfilesexceeded_msg'), 'file_larger' => Lang::get('designer.file_larger'), 'image_file_validation' => Lang::get('designer.image_file_validation'), 'good_job' => Lang::get('designer.good_job'), 'image_upload_success' => Lang::get('designer.image_upload_success'), 'designer_price_can_not_zero' => Lang::get('designer.designer_price_can_not_zero'), 'designer_product_out_of_stock' => Lang::get('designer.designer_product_out_of_stock'), 'designer_item_added_successfully' => Lang::get('designer.designer_item_added_successfully'), 'designer_cart_page_view' => Lang::get('designer.designer_cart_page_view'), 'enter_name' => Lang::get('frontend-js.enter_name'), 'enter_email' => Lang::get('frontend-js.enter_email'), 'enter_phone_number' => Lang::get('frontend-js.enter_phone_number'), 'enter_desc' => Lang::get('frontend-js.enter_desc'), 'enter_valid_email' => Lang::get('frontend-js.enter_valid_email'), 'enter_valid_phone_number' => Lang::get('frontend-js.enter_valid_phone_number'), 'request_saved_msg' => Lang::get('frontend-js.request_saved_msg'), 'login_for_wishlist_msg' => Lang::get('frontend-js.login_for_wishlist_msg'), 'wishlist_data_saved_msg' => Lang::get('frontend-js.wishlist_data_saved_msg'), 'already_item_in_wishlist_msg' => Lang::get('frontend-js.already_item_in_wishlist_msg'), 'subscribe_success_msg' => Lang::get('frontend-js.subscribe_success_msg'), 'subscribe_error_msg' => Lang::get('frontend-js.subscribe_error_msg'), 'error_message_text' => Lang::get('frontend-js.error_message_text'), 'user_mode_select_msg' => Lang::get('frontend-js.user_mode_select_msg'), 'billing_email_not_valid_msg' => Lang::get('frontend-js.billing_email_not_valid_msg'), 'shipping_email_not_valid_msg' => Lang::get('frontend-js.shipping_email_not_valid_msg'), 'required_field_still_empty_msg' => Lang::get('frontend-js.required_field_still_empty_msg'), 'select_payment_method_msg' => Lang::get('frontend-js.select_payment_method_msg'), 'signup_signin_checkout_msg' => Lang::get('frontend-js.signup_signin_checkout_msg'), 'billing_shipping_error_msg' => Lang::get('frontend-js.billing_shipping_error_msg'), 'coupon_not_exists_msg' => Lang::get('validation.coupon_not_exists_msg'), 'coupon_min_spend_msg' => Lang::get('validation.coupon_min_spend_msg'), 'coupon_max_spend_msg' => Lang::get('validation.coupon_max_spend_msg'), 'coupon_no_login_msg' => Lang::get('validation.coupon_no_login_msg'), 'coupon_no_role_match_msg' => Lang::get('validation.coupon_no_role_match_msg'), 'coupon_expired_msg' => Lang::get('validation.coupon_expired_msg'), 'coupon_label' => Lang::get('frontend-js.coupon_label'), 'coupon_added_msg' => Lang::get('frontend-js.coupon_added_msg'), 'coupon_already_sxist_label' => Lang::get('validation.coupon_already_sxist_label'), 'remove_coupon_label' => Lang::get('frontend-js.remove_coupon_label'), 'exceed_from_cart_total_msg' => Lang::get('validation.exceed_from_cart_total_msg'), 'stripe_api_empty_msg' => Lang::get('frontend-js.stripe_api_empty_msg'), 'compare_data_saved_msg' => Lang::get('frontend-js.compare_data_saved_msg'), 'compare_data_exists_msg' => Lang::get('frontend-js.compare_data_exists_msg'), 'compare_data_exceed_msg' => Lang::get('frontend-js.compare_data_exceed_msg'), 'continue_label' => Lang::get('frontend-js.continue_label'), 'wishlist_items_label' => Lang::get('frontend-js.wishlist_items_label'), 'compare_items_label' => Lang::get('frontend-js.compare_items_label'), 'vendor_not_same_msg' => Lang::get('frontend-js.vendor_not_same_msg'), 'no_product_available_label' => Lang::get('frontend-js.no_product_available_label'), 'proceed_to_2checkout' => Lang::get('frontend-js.proceed_to_2checkout'), 'twocheckout_api_empty_msg' => Lang::get('frontend-js.twocheckout_api_empty_msg'));

    $data_ary['frontend_js_localization']    =    json_encode($localization_array);
    $data_ary['subscriptions_data'] = get_subscription_settings_data();

    $is_subscribe_cookie_exists = false;
    if(Cookie::has('subscribe_popup_not_needed') && Cookie::get('subscribe_popup_not_needed') == 'no_need'){
      $is_subscribe_cookie_exists = true;
    }

    $data_ary['is_subscribe_cookie_exists'] = $is_subscribe_cookie_exists;
    $data_ary['productCategoriesTree']   =   $product->get_categories(0, 'product_cat');

    if(Session::has('shopist_selected_compare_product_ids') && count(Session::get('shopist_selected_compare_product_ids')) > 0){
      $data_ary['total_compare_item'] = count(Session::get('shopist_selected_compare_product_ids'));
    }
    else{
      $data_ary['total_compare_item'] = 0;
    }

    //$data_ary['appearance_settings_data'] = get_appearance_settings();
    $data_ary['current_parent_cat'] = get_product_parent_categories();
    $data_ary['pages_list'] = $CMS->get_pages(false, null, 1);
    $data_ary['seo_data'] = get_seo_data();

    return $data_ary;
  }
  
  /**
  * Set admin default language
  *
  * @param null
  * @return string
  */
  
  public function set_admin_lang(){
    $get_current_default_lang = get_default_languages_data();
    if(count($get_current_default_lang) > 0){
      App::setLocale( $get_current_default_lang['lang_code'] ); 
    }
  }
  
  /**
  * Set frontend default language
  *
  * @param null
  * @return string
  */
  
  public function set_frontend_lang(){
    $get_current_frontend_lang = get_frontend_selected_languages_data();
    $get_current_default_lang  = get_default_languages_data();
     
    if(count($get_current_frontend_lang) > 0 && !empty($get_current_frontend_lang['status']) && $get_current_frontend_lang['status'] == 1){
      App::setLocale( $get_current_frontend_lang['lang_code'] ); 
    }
    else{
      App::setLocale( $get_current_default_lang['lang_code'] );
    }
  }
  
  public function is_shopist_admin_installed(){
    $roleArray      =   ['slug' => 'administrator'];
    $get_user_role  =   Role::where($roleArray)->get()->count();
    
    if(!empty($get_user_role) && $get_user_role >0){
      return TRUE;
    }
    else{
      return FALSE;
    }
  }
  
  /**
  * Get order details by order id
  *
  * @param order id
  * @return array
  */
  public function get_order_details_by_order_id($order = array()){
				$order_data = array();
    $option  =  new OptionController();
    $order_id = $order['order_id'];
    $order_process_id = $order['order_process_id'];
    
    $get_post_by_order_id     =   Post::where(['id' => $order_id])->first();
    $get_postmeta_by_order_id =   PostExtra::where(['post_id' => $order_id])->get();
    $get_process_key          =   PostExtra::where(['post_id' => $order_id, 'key_name' => '_order_process_key'])->first();
    $get_orders_items         =   OrdersItem::where(['order_id' => $order_id])->first();
    
    if(!empty($get_post_by_order_id) && $get_post_by_order_id ->count() > 0 && !empty($get_postmeta_by_order_id) && $get_postmeta_by_order_id ->count() > 0 && !empty($get_orders_items) && $get_orders_items->count() >0 && !empty($get_process_key) && $get_process_key->key_value == $order_process_id){
      
      $order_date_format = new Carbon( $get_post_by_order_id->created_at);
      $order_data['customer_address'] = get_customer_order_billing_shipping_info( $get_post_by_order_id->id );
      $order_data['order_id']    = $get_post_by_order_id->id;
      $order_data['order_date']  = $order_date_format->toDayDateTimeString();
 
      foreach($get_postmeta_by_order_id as $postmeta_row_data){
        if($postmeta_row_data->key_name === '_order_shipping_method'){
          $order_data[$postmeta_row_data->key_name] = $this->get_shipping_label($postmeta_row_data->key_value);
        }
        elseif($postmeta_row_data->key_name == '_order_currency' || $postmeta_row_data->key_name == '_customer_ip_address' || $postmeta_row_data->key_name == '_customer_user_agent' || $postmeta_row_data->key_name == '_customer_user' || $postmeta_row_data->key_name == '_order_shipping_cost' || $postmeta_row_data->key_name == '_order_shipping_method' || $postmeta_row_data->key_name == '_payment_method' || $postmeta_row_data->key_name == '_payment_method_title' || $postmeta_row_data->key_name == '_order_tax' || $postmeta_row_data->key_name == '_order_total' || $postmeta_row_data->key_name == '_order_notes' || $postmeta_row_data->key_name == '_order_status' || $postmeta_row_data->key_name == '_order_discount' || $postmeta_row_data->key_name == '_order_coupon_code' || $postmeta_row_data->key_name == '_is_order_coupon_applyed' || $postmeta_row_data->key_name == '_final_order_shipping_cost' || $postmeta_row_data->key_name == '_final_order_tax' || $postmeta_row_data->key_name == '_final_order_total' || $postmeta_row_data->key_name == '_final_order_discount'){
          $order_data[$postmeta_row_data->key_name] = $postmeta_row_data->key_value;
        }
      } 
      
      $order_data['ordered_items']  = json_decode( $get_orders_items->order_data, TRUE );
      
      if(isset($order_data['_payment_method']) && $order_data['_payment_method']){
        $payment_data = $option->getPaymentMethodData();
        $order_data['_payment_details']  = $payment_data[$order_data['_payment_method']];
      }
    }
    
    return $order_data;
  }
		
		/**
  * Get sub orders details by order id
  *
  * @param order id
  * @return array
  */
		
		public function get_sub_orders_details_by_order_id($order = array()){
				$order_data = array();
    $option  =  new OptionController();
				$order_id = $order['order_id'];
    $order_process_id = $order['order_process_id'];
				
				$get_post_by_order_id     =   Post::where(['id' => $order_id])->first();
				
				if(!empty($get_post_by_order_id)){
						$get_postmeta_by_order_id =   PostExtra::where(['post_id' => $get_post_by_order_id->parent_id])->get();
						$get_process_key          =   PostExtra::where(['post_id' => $order_id, 'key_name' => '_order_process_key'])->first();
						$get_orders_items         =   OrdersItem::where(['order_id' => $order_id])->first();
						
						if(!empty($get_postmeta_by_order_id) && $get_postmeta_by_order_id ->count() > 0 && !empty($get_orders_items) && $get_orders_items->count() >0 && !empty($get_process_key) && $get_process_key->key_value == $order_process_id){
								$order_date_format = new Carbon( $get_post_by_order_id->created_at);
								$order_data['customer_address'] = get_customer_order_billing_shipping_info( $get_post_by_order_id->parent_id );
								$order_data['order_id']    = $get_post_by_order_id->id;
								$order_data['order_date']  = $order_date_format->toDayDateTimeString();
								
								foreach($get_postmeta_by_order_id as $postmeta_row_data){
										if($postmeta_row_data->key_name === '_order_shipping_method'){
												$order_data[$postmeta_row_data->key_name] = $this->get_shipping_label($postmeta_row_data->key_value);
										}
										elseif($postmeta_row_data->key_name == '_order_currency' || $postmeta_row_data->key_name == '_customer_ip_address' || $postmeta_row_data->key_name == '_customer_user_agent' || $postmeta_row_data->key_name == '_customer_user' || $postmeta_row_data->key_name == '_order_shipping_cost' || $postmeta_row_data->key_name == '_order_shipping_method' || $postmeta_row_data->key_name == '_payment_method' || $postmeta_row_data->key_name == '_payment_method_title' || $postmeta_row_data->key_name == '_order_tax' || $postmeta_row_data->key_name == '_order_total' || $postmeta_row_data->key_name == '_order_notes' || $postmeta_row_data->key_name == '_order_status' || $postmeta_row_data->key_name == '_order_discount' || $postmeta_row_data->key_name == '_order_coupon_code' || $postmeta_row_data->key_name == '_is_order_coupon_applyed' || $postmeta_row_data->key_name == '_final_order_shipping_cost' || $postmeta_row_data->key_name == '_final_order_tax' || $postmeta_row_data->key_name == '_final_order_total' || $postmeta_row_data->key_name == '_final_order_discount'){
												$order_data[$postmeta_row_data->key_name] = $postmeta_row_data->key_value;
										}
								} 
								
								$order_data['ordered_items']  = json_decode( $get_orders_items->order_data, TRUE );
								
								if(isset($order_data['_payment_method']) && $order_data['_payment_method']){
										$payment_data = $option->getPaymentMethodData();
										$order_data['_payment_details']  = $payment_data[$order_data['_payment_method']];
								}
						}
				}
				
				return $order_data;
		}
  
  /**
   * Get function for shipping label
   *
   * @param Shipping name
   * @return string
   */
  public function get_shipping_label($name = ''){
    $option  =  new OptionController();
    $get_shipping = $option->getShippingMethodData();
    
    if(isset($get_shipping[$name])){
      return $get_shipping[$name]['method_title'];
    }
  }
  
  /**
   * save control for frontend account data
   *
   * @param array
   * @return boolean
   */  
  public function frontendUserAccountDataProcess( $data = array() ){
    $get_current_user_id = get_current_frontend_user_info();
    
    if(isset($get_current_user_id['user_id']) && $get_current_user_id['user_id']){
      $account_data_details   =   array();
      $user_details           =   new UsersDetail;
      $get_data_by_user_id    =   array();
      
      $get_data_by_user_id = get_user_account_details_by_user_id( $get_current_user_id['user_id'] );
      
      if( count($get_data_by_user_id) == 0){
        $account_data_details = array('address_details' => '', 'wishlists_details' => '');
        
        $user_details->user_id      =       $get_current_user_id['user_id'];
        $user_details->details      =       json_encode( $account_data_details );

        $user_details->save();
        
        $get_data_by_user_id = get_user_account_details_by_user_id( $get_current_user_id['user_id'] );
      }
      
      if(count($get_data_by_user_id) > 0){
        $array_shift   = array_shift($get_data_by_user_id );
        $parse_details = json_decode($array_shift['details'], true);
        
        if(isset($data['post_type']) && $data['post_type'] == 'address'){
          $parse_details['address_details'] = $data['details'];
        }
        
        if(isset($data['post_type']) && $data['post_type'] == 'wishlist'){
          if(isset($data['post_action']) && $data['post_action'] == 'delete' ){
            $parse_details['wishlists_details'] = $data['details'];
          }
          else{
            if(!empty($parse_details['wishlists_details'])){
              $get_wishlist = $parse_details['wishlists_details'];
              
              if(!array_key_exists(key($data['details']), $get_wishlist)){
                $parse_details['wishlists_details'] = $get_wishlist + $data['details'];
              }
            }
            else{
              $parse_details['wishlists_details'] = $data['details'];
            }
          }
        }
        
        $final_data = array(
                    'details' =>  json_encode($parse_details)
        );
        
        if( $user_details::where('user_id', $get_current_user_id['user_id'])->update($final_data)){
          return true;
        }
      }
    }
  }
		
		/**
   * Get function for variable products
   *
   * @param Products Id
   * @return obj
   */
  public function get_variation_by_product_id($product_id){
    $get_variation_data = null;
    
    $get_variation_data = DB::table('posts')
                          ->where(['posts.parent_id' => $product_id, 'posts.post_type' => 'product_variation', 'post_extras.key_name' => '_variation_post_data'])
													->join('post_extras', 'post_extras.post_id', '=', 'posts.id')
													->select('posts.*', 'post_extras.key_value')     
													->get();
				
    return $get_variation_data;
  }
		
		/**
   * Get function for variable products
   *
   * @param Products Id
   * @return array
   */
  public function get_variation_and_data_by_product_id($product_id){
    $get_variation = '';
    $variation_array = array();
    
    $get_variation = $this->get_variation_by_product_id($product_id);
    
    if($get_variation && count($get_variation)>0){
      foreach ($get_variation as $data){
        $get_meta_by_id  =  PostExtra::where('post_id', $data->id)->get();
        $data_array      =  array();
        
        $data_array['id']             =  $data->id;
        $data_array['author_id']      =  $data->post_author_id;
        $data_array['description']    =  $data->post_content;
        $data_array['title']          =  $data->post_title;
        $data_array['parent_id']      =  $data->parent_id;
        $data_array['status']         =  $data->post_status;
        $data_array['post_type']      =  $data->post_type;
        
        foreach($get_meta_by_id as $row){
          if($row->key_name == '_variation_post_data'){
            $data_array['_variation_array_data'] = json_decode($row->key_value);
          }
										
          if ($row->key_name == '_role_based_pricing') {
            $data_array['_role_based_pricing_array'] = unserialize($row->key_value);
          }
										
          $data_array[$row->key_name]  =  $row->key_value;
        }
        
        if(count($data_array)>0){
          array_push($variation_array, $data_array);
        }
      }
    }
    
    return $variation_array;
  }
		
		/**
   * Get function for variable products
   *
   * @param Post Id
   * @return array
   */
  public function get_variation_and_data_by_post_id($post_id){
    $data = array();
    $get_post_by_id  =  Post::where('id', $post_id)->first();
    $get_meta_by_id  =  PostExtra::where('post_id', $post_id)->get();
    
    $data['id']                   =   $get_post_by_id->id;
    $data['post_author_id']       =   $get_post_by_id->post_author_id;
    $data['post_content']         =   $get_post_by_id->post_content;
    $data['post_title']           =   $get_post_by_id->post_title;
    $data['parent_id']            =   $get_post_by_id->parent_id;
    $data['post_status']          =   $get_post_by_id->post_status;
    $data['post_type']            =   $get_post_by_id->post_type;
    
    foreach($get_meta_by_id as $row){
      $data[$row->key_name]   =   $row->key_value;
    }
        
    return $data;
  }
  
  
  /**
   * Get function for products data
   *
   * @param Product id
   * @return array
   */
  public function get_product_data_by_product_id( $product_id = 0 ){
    $_this = new self;
    $product_data = array();
    $product =  new ProductsController();
    
    if($product_id>0){
      $get_data = $product->getProductDataById( $product_id );
       
      $product_data['id']                                =  $get_data['id'];
      $product_data['author_id']                         =  $get_data['author_id'];
      $product_data['post_title']                        =  $get_data['post_title'];
      $product_data['post_status']                       =  $get_data['post_status'];
      $product_data['post_type']                         =  $get_data['post_type'];
      $product_data['product_image']                     =  $get_data['post_image_url'];
      $product_data['product_type']                      =  $get_data['post_type'];
      $product_data['product_sku']                       =  $get_data['post_sku'];
      $product_data['product_price']                     =  $get_data['post_price'];
      $product_data['product_sale_price_start_date']     =  $get_data['_product_sale_price_start_date'];
      $product_data['product_sale_price_end_date']       =  $get_data['_product_sale_price_end_date'];
      $product_data['product_manage_stock']              =  $get_data['_product_manage_stock'];
      $product_data['product_manage_stock_qty']          =  $get_data['post_stock_qty'];
      $product_data['product_manage_stock_availability'] =  $get_data['post_stock_availability'];
      $product_data['product_enable_as_custom_design']   =  $get_data['_product_enable_as_custom_design'];
      $product_data['product_enable_taxes']              =  $get_data['_product_enable_taxes'];
      $product_data['is_role_based_pricing_enable']      =  $get_data['_is_role_based_pricing_enable'];
      $product_data['role_based_pricing']                =  $get_data['_role_based_pricing'];
      
      return $product_data;
    }
  }
  
  /**
   * Get function for products variations data
   *
   * @param Variations id
   * @return array
   */
  public function get_product_variation_data_by_variation_id( $variation_id = 0 ){
    $_this = new self;
    $variations_data  = array();
    
    if($variation_id >0){
      $get_variations_data = $_this->get_variation_and_data_by_post_id( $variation_id );
      
      $variations_data['variation_id'] = $get_variations_data['id'];
      $variations_data['variation_author_id'] = $get_variations_data['post_author_id'];
      $variations_data['variation_parent_id'] = $get_variations_data['parent_id'];
      $variations_data['variation_post_status'] = $get_variations_data['post_status'];
      $variations_data['variation_post_type'] = $get_variations_data['post_type'];
      $variations_data['variation_product_image'] = $get_variations_data['_variation_post_img_url'];
      $variations_data['variation_product_sku'] = $get_variations_data['_variation_post_sku'];
      $variations_data['variation_product_price'] = $get_variations_data['_variation_post_price'];
      $variations_data['variation_product_sale_price_start_date'] = $get_variations_data['_variation_post_sale_price_start_date'];
      $variations_data['variation_product_sale_price_end_date'] = $get_variations_data['_variation_post_sale_price_end_date'];
      $variations_data['variation_product_manage_stock'] = $get_variations_data['_variation_post_manage_stock'];
      $variations_data['variation_product_manage_stock_qty'] = $get_variations_data['_variation_post_manage_stock_qty'];
      $variations_data['variation_product_manage_stock_availability'] = $get_variations_data['_variation_post_stock_availability'];
      $variations_data['variation_product_enable_taxes'] = $get_variations_data['_variation_post_enable_tax'];
      $variations_data['variation_data'] = $get_variations_data['_variation_post_data'];
      $variations_data['is_role_based_pricing_enable'] = $get_variations_data['_is_role_based_pricing_enable'];
      $variations_data['role_based_pricing'] = unserialize( $get_variations_data['_role_based_pricing'] );
      
      return $variations_data;
    }
  }
  
  
  /**
   * Products add to cart
   *
   * @param products id, quantity, variations id, design access token
   * @return void
   */
  public function add_to_cart($product_id = 0, $qty = 1, $variation_id = 0, $accessToken = 0){
    
    //check this product vendor already in cart start
    $cart_vendor_id = null;
    $new_vendor_id  = null;
    
    if(!empty($this->cart->items())){
      foreach($this->cart->items() as $item){
        $cart_vendor_id = get_author_id_by_product_id( $item->product_id );
        break;
      }
    }
    
    $new_vendor_id = get_author_id_by_product_id( $product_id );
    if(!is_null($cart_vendor_id) && !is_null($new_vendor_id)){
      if($cart_vendor_id !== $new_vendor_id){
        echo 'vendor_not_same';
        die();
      }
    }
    //check this product vendor already in cart end
    
    $_this = new self;
    $product_id   = intval( $product_id );
	  $variation_id = intval( $variation_id );
    $quantity     = intval( $qty );

    $product_data             =  array();
    $product_variation_data   =  array();
    $product_cart_line_data   =  array();
    
    if($product_id > 0){
      $product_data = $_this->get_product_data_by_product_id( $product_id );
    }
    
    if($variation_id > 0){
      $product_variation_data = $_this->get_product_variation_data_by_variation_id( $variation_id );
    }
    
    if(count($product_data) > 0){
      $product_cart_line_data = $product_data;
    }
    
    if(count($product_variation_data) > 0){
      $product_cart_line_data['product_variation_data'] = $product_variation_data;
    }
    
    if($quantity > 0){
      $product_cart_line_data['product_line_quantity'] = $quantity;
    }
    
    if($accessToken){
      $product_cart_line_data['product_line_access_token'] = $accessToken;
    }
    
    if( count($product_cart_line_data) >0 ){
      $_this->set_cart_data( $product_cart_line_data );
    }
  }
  
  /**
   * Products add to cart set 
   *
   * @param Cart data
   * @return string
   */
  public function set_cart_data( $cart_data = array() ){
    if( count($cart_data) > 0 ){      
      $price = 0;
      $options = array();
      $variation_id = null;
      $img_src = '/public/images/no-image.png';
      $stock_availability = false;
      $tax = false;
      $access_token = '';
      $is_qty_available = true;
      
      if(isset($cart_data['product_line_access_token']) && $cart_data['product_line_access_token']){
        $access_token = $cart_data['product_line_access_token'];
      }
      
      if(isset($cart_data['product_variation_data']) && count( $cart_data['product_variation_data'] ) >0 && isset($cart_data['product_variation_data']['variation_product_price'])){
       $get_pricing  = $this->getPricing($cart_data['product_variation_data']); 
       
       if(!is_null($get_pricing)){
         $price = $get_pricing;
       }
       else{
         $price  =  $cart_data['product_variation_data']['variation_product_price'];
       }
       
       $variation_id = $cart_data['product_variation_data']['variation_id'];
       $get_options  = json_decode($cart_data['product_variation_data']['variation_data'], TRUE);

       if(count($get_options) >0){
         foreach($get_options as $vals){
           $options[$vals['attr_name']] = $vals['attr_val'];
         }
       }
       
       if($cart_data['product_variation_data']['variation_product_image']){
         $img_src = $cart_data['product_variation_data']['variation_product_image'];
       }
       
       if($cart_data['product_variation_data']['variation_product_manage_stock_availability'] == 'variation_in_stock'){
         $stock_availability = TRUE;
       }
       
       if($cart_data['product_variation_data']['variation_product_enable_taxes']){
         $tax = true;
       }
       
       if($cart_data['product_variation_data']['variation_product_manage_stock'] == 1){
         if($cart_data['product_variation_data']['variation_product_manage_stock_qty'] == 0){
           $is_qty_available = false;
         }
         
         if(isset($this->cart->get($cart_data['id'])->quantity)){
           $cat_qty = $this->cart->get($cart_data['id'])->quantity + 1;
           
           if($cat_qty > $cart_data['product_variation_data']['variation_product_manage_stock_qty']){
             $is_qty_available = false;
           }
         }
       }
      }
      else {
       $get_pricing  = $this->getPricing($cart_data); 
       
       if(!is_null($get_pricing)){
         $price = $get_pricing;
       }
       else{
         $price  = $cart_data['product_price'];
       }

       if($cart_data['product_image']){
         $img_src = $cart_data['product_image'];
       }
       
       if($cart_data['product_manage_stock_availability'] == 'in_stock'){
         $stock_availability = TRUE;
       }
       
       if($cart_data['product_enable_taxes'] == 'yes'){
         $tax = true;
       }
       
       if($cart_data['product_manage_stock'] == 'yes'){
         if($cart_data['product_manage_stock_qty'] == 0){
           $is_qty_available = false;
         }
         
         if(isset($this->cart->get($cart_data['id'])->quantity)){
           $cat_qty = $this->cart->get($cart_data['id'])->quantity + 1;
           
           if($cat_qty > $cart_data['product_manage_stock_qty']){
             $is_qty_available = false;
           }
         }
       }
      }
      
      if( !$stock_availability || !$is_qty_available){
        echo 'out_of_stock';
        die();
      }
      
      $product_id = 0;
      
      if(!empty($variation_id) && $variation_id > 0 && ( get_product_type($cart_data['id']) == 'configurable_product' || get_product_type($cart_data['id']) == 'downloadable_product')){
        $product_id = $variation_id;
      }
      else{
        $product_id = $cart_data['id'];
      }
      
      
      $this->cart->add([
        'id'            =>  $product_id,
        'product_id'    =>  $cart_data['id'],
        'name'          =>  $cart_data['post_title'],
        'quantity'      =>  $cart_data['product_line_quantity'],
        'price'         =>  $price,
        'order_price'   =>  get_product_price_html_by_filter($price),
        'img_src'       =>  $img_src,  
        'variation_id'  =>  $variation_id,
        'options'       =>  $options,
        'tax'           =>  $tax,
        'product_type'  =>  get_product_type( $cart_data['id'] ),
        'acces_token'   =>  $access_token  
      ]);
      
      if($this->cart->count() > 0){ 
        echo 'item_added';
      }
    }
  }
  
  /**
   * Get role pricing after check some required 
   *
   * @param array
   * @return float number, integer number
   */
  function getPricing($data = array()){
    $price = null;
    
    if(count($data) > 0){
      $get_current_user_data  =  get_current_frontend_user_info();
      
      if(is_frontend_user_logged_in() && isset($get_current_user_data['user_role_slug']) && ($data['is_role_based_pricing_enable'] == 'yes' || $data['is_role_based_pricing_enable'] == 1)){
        if( isset($data['role_based_pricing'][$get_current_user_data['user_role_slug']]) ){
          $regular_price = $data['role_based_pricing'][$get_current_user_data['user_role_slug']]['regular_price'];
          $sale_price = $data['role_based_pricing'][$get_current_user_data['user_role_slug']]['sale_price'];
          
          if(isset($regular_price) && $regular_price && isset($sale_price) && $sale_price && $regular_price > $sale_price){
            $price = $sale_price;
          }
          elseif(isset($regular_price) && $regular_price){
            $price = $regular_price;
          }
        }
      }
    }
    
    return $price;
  }
  
  
  /**
   * Products add to cart set 
   *
   * @param Cart data
   * @return string
   */
  function sortBy($array, $key, $sort, $sort_flags = SORT_REGULAR) {
    if (is_array($array) && count($array) > 0) {
      if (!empty($key)) {
        $mapping = array();
        foreach ($array as $k => $v) {
          $sort_key = '';
          if (!is_array($key)) {
            $sort_key = $v[$key];
          } else {
            foreach ($key as $key_key) {
              $sort_key .= $v[$key_key];
            }
            $sort_flags = SORT_STRING;
          }
          $mapping[$k] = $sort_key;
        }
        
        if($sort == 'asc'){
          asort($mapping, $sort_flags); //ascending 
        }
        elseif($sort == 'desc'){
          arsort($mapping, $sort_flags); //descending 
        }
     
        $sorted = array();
        foreach ($mapping as $k => $v) {
          $sorted[] = $array[$k];
        }
        return $sorted;
      }
    }
    return $array;
  }
		
  /**
  * Check product cats are same for some reason
  *
  * @param array, array
  * @return boolean
  */
  public function is_product_cat_in_selected_cat($array1, $array2){
    $filter_ary  = array();
    $normal_ary  = array();
    $matched_ary = array();
    $is_matched  = false;
    
    if(count($array1) > 0 && isset($array1['term_id'])){
      $filter_ary = $array1['term_id'];
    }

    if(count($array2) > 0){
      foreach($array2 as $cat){
        array_push($normal_ary, $cat['id']);
      }
    }

    if(count($filter_ary) > 0 && count($normal_ary)){
      $matched_ary = array_intersect($filter_ary, $normal_ary);
    }

    if(count($matched_ary) > 0){
      $is_matched = true;
    }
    
    return $is_matched;
  }
  
  /**
  * create zoom image url for product gallery 
  *
  * @param product url
  * @return string url
  */
  public function createZoomImageUrl( $product_url ){
    $old_file_name = basename($product_url);
    $new_file_name = 'large-'.$old_file_name;
    $file_new_url = str_replace($old_file_name, $new_file_name, $product_url);
    
    return $file_new_url;
  }
  
  /**
  * This check what is required for the downloadable product download 
  *
  * @param post_id
  * @return boolean
  */
  public function checkDownloadRequired($data, $order_id){
    $today = date("Y-m-d");
    $condition = false;
    
    $count_download = DownloadExtra::where(['order_id' => $order_id])->get()->toArray();
    
    if( ((!empty($data['downloadable_product_download_expiry']) &&  $data['downloadable_product_download_expiry'] <= $today) || (empty($data['downloadable_product_download_expiry'])) ) && ( (!empty($data['downloadable_product_download_limit']) && count($count_download) < $data['downloadable_product_download_limit']) || (empty($data['downloadable_product_download_limit']))) ){
      $condition = true;
    }
    
    if( $condition ){
      return true;
    }
    else{
      return false;
    }
  }
  
  /**
  * Object to array conversion
  *
  * @param object, array
  * @return array
  */
  public function objToArray($obj){
    if (!is_object($obj) && !is_array($obj)) {
        return $obj;
    }

    foreach ($obj as $key => $value) {
        $arr[$key] = $this->objToArray($value);
    }

    return $arr;
  }
  
  /**
  * Send SMS to the admin
  *
  * @param null
  * @return void
  */
  public function sendSMSToAdmin(){
    $nexmo_data = get_nexmo_data();
    
    if(!empty($nexmo_data['number_to']) && !empty($nexmo_data['number_from']) && !empty($nexmo_data['message'])){
      Nexmo::message()->send([
          'to'   =>   $nexmo_data['number_to'],
          'from' =>   $nexmo_data['number_from'],
          'text' =>   $nexmo_data['message']
      ]);
    }
  }
  
  /**
  * Common data for admin all pages 
  *
  * @param null
  * @return void
  */
  // 900
  public function commonDataForAllPages(){
    $data = array();
    $parm = 'all';
    $user_permission = array();
    
    //set lang
    $this->set_admin_lang();
    
    //check vendor expired
    if(is_vendor_login() && Session::has('shopist_admin_user_id')){
      if(is_vendor_expired(Session::get('shopist_admin_user_id'))){
        return view('errors.vendor_expired');
      }
    }
      
    $get_user_data = get_current_admin_user_info();
    $get_role_data = get_roles_details_by_role_id( $get_user_data['user_role_id'] );
    
    if(!empty($get_role_data)){
      $user_permission  =  $get_role_data->permissions;
    }
 
    if(is_vendor_login()){
      $parm = Session::get('shopist_admin_user_id');
    }
    
    $adminJsLocalization = array('variations_exists_msg' => Lang::get('admin-js.variations_exists_msg'), 'create_new_category' => Lang::get('admin-js.create_new_category'), 'create_category' => Lang::get('admin-js.create_category'), 'create_new_product_tag' => Lang::get('admin-js.create_new_product_tag'), 'create_tag' => Lang::get('admin-js.create_tag'), 'create_new_product_variation' => Lang::get('admin-js.create_new_product_variation'), 'add_variation' => Lang::get('admin-js.add_variation'), 'work_at_edit_page' => Lang::get('admin-js.work_at_edit_page'), 'name_slug_field_are_required' => Lang::get('admin-js.name_slug_field_are_required'), 'slug_already_exists' => Lang::get('admin-js.slug_already_exists'), 'sku_field_require' => Lang::get('admin-js.sku_field_require'), 'sku_already_exists' => Lang::get('admin-js.sku_already_exists'),  'update_product_category' => Lang::get('admin-js.update_product_category'), 'update_category' => Lang::get('admin-js.update_category'), 'update_product_tag' => Lang::get('admin-js.update_product_tag'), 'update_tag' => Lang::get('admin-js.update_tag'), 'update_product_variation' => Lang::get('admin-js.update_product_variation'), 'update_variation_data' => Lang::get('admin-js.update_variation_data'), 'no_attributes_available' => Lang::get('admin-js.no_attributes_available'), 'are_you_sure' => Lang::get('admin-js.are_you_sure'), 'you_want_to_delete_this_item' => Lang::get('admin-js.you_want_to_delete_this_item'), 'yes_delete_it' => Lang::get('admin-js.yes_delete_it'), 'deleted' => Lang::get('admin-js.deleted'), 'your_selected_item_deleted' => Lang::get('admin-js.your_selected_item_deleted'), 'good_job' => Lang::get('admin-js.good_job'), 'selected_item_successfully_deleted' => Lang::get('admin-js.selected_item_successfully_deleted'), 'selected_item_successfully_saved' => Lang::get('admin-js.selected_item_successfully_saved'), 'selected_item_successfully_updated' => Lang::get('admin-js.selected_item_successfully_updated'),'upload_design_image' => Lang::get('admin-js.upload_design_image'), 'remove_image' => Lang::get('admin-js.remove_image'), 'upload_design_transparent_image' => Lang::get('admin-js.upload_design_transparent_image'), 'upload_design_title_icon' => Lang::get('admin-js.upload_design_title_icon'), 'no_result_found' => Lang::get('admin-js.no_result_found'), 'dropzone_file_exceeded_msg_1' => Lang::get('admin-js.dropzone_file_exceeded_msg_1'), 'dropzone_file_exceeded_msg_2' => Lang::get('admin-js.dropzone_file_exceeded_msg_2'), 'dropzone_file_exceeded_msg_3' => Lang::get('admin-js.dropzone_file_exceeded_msg_3'), 'please_upload_only_image_file' => Lang::get('admin-js.please_upload_only_image_file'), 'successfully_uploaded_your_image' => Lang::get('admin-js.successfully_uploaded_your_image'), 'total' => Lang::get('admin-js.total'), 'maxfilesexceeded_msg' => Lang::get('designer.maxfilesexceeded_msg'), 'file_larger' => Lang::get('designer.file_larger'), 'image_file_validation' => Lang::get('designer.image_file_validation'), 'good_job' => Lang::get('designer.good_job'), 'image_upload_success' => Lang::get('designer.image_upload_success'), 'admin_dashboard' => Lang::get('admin-js.eb-admin'), 'logout' => Lang::get('admin-js.logout'), 'appearance_running_template_text' => Lang::get('admin-js.appearance_running_template_text'), 'appearance_template_activated_text' => Lang::get('admin-js.appearance_template_activated_text'),  'text_add_btn_label' => Lang::get('admin-js.add_text_on_image_btn_text'), 'html_code_required_msg' => Lang::get('admin-js.html_code_required_msg'), 'html_code_added_msg' => Lang::get('admin-js.html_code_added_msg'), 'comment_enable_msg' => Lang::get('admin-js.comment_enable_msg'), 'comment_btn_enable_msg' => Lang::get('admin-js.comment_btn_enable_msg'), 'comment_enable_done_msg' => Lang::get('admin-js.comment_enable_done_msg'), 'comment_disable_msg' => Lang::get('admin-js.comment_disable_msg'), 'comment_btn_disable_msg' => Lang::get('admin-js.comment_btn_disable_msg'), 'comment_disable_done_msg' => Lang::get('admin-js.comment_disable_done_msg'), 'comment_disable_done_msg' => Lang::get('admin-js.comment_disable_done_msg'), 'more_compare_field_placeholder' => Lang::get('admin-js.more_compare_field_placeholder'), 'remove_text' => Lang::get('admin-js.remove_text'), 'color_filter_color_name_placeholder' => Lang::get('admin-js.color_filter_color_name_placeholder'), 'create_new_product_attrs' => Lang::get('admin-js.create_new_product_attrs'), 'create_attr' => Lang::get('admin-js.create_attr'), 'attr_name_values_are_required' => Lang::get('admin-js.attr_name_values_are_required'), 'update_product_attr' => Lang::get('admin-js.update_product_attr'), 'update_attr' => Lang::get('admin-js.update_attr'), 'colors_are_required' => Lang::get('admin-js.colors_are_required'), 'sizes_are_required' => Lang::get('admin-js.sizes_are_required'), 'create_new_product_color' => Lang::get('admin-js.create_new_product_color'), 'create_color' => Lang::get('admin-js.create_color'), 'create_new_product_size' => Lang::get('admin-js.create_new_product_size'), 'create_size' => Lang::get('admin-js.create_size'), 'update_product_color' => Lang::get('admin-js.update_product_color'), 'update_color' => Lang::get('admin-js.update_color'), 'update_product_size' => Lang::get('admin-js.update_product_size'), 'update_size' => Lang::get('admin-js.update_size'), 'downloadable_name_label' => Lang::get('admin-js.downloadable_name_label'), 'downloadable_file_url_label' => Lang::get('admin-js.downloadable_file_url_label'), 'downloadable_placeholder_file_name' => Lang::get('admin-js.downloadable_placeholder_file_name'), 'downloadable_file_label' => Lang::get('admin-js.downloadable_file_label'), 'downloadable_url_label' => Lang::get('admin-js.downloadable_url_label'), 'downloadable_choose_file_label' => Lang::get('admin-js.downloadable_choose_file_label'), 'downloadable_uploaded_file_url_placeholder' => Lang::get('admin-js.downloadable_uploaded_file_url_placeholder'), 'downloadable_online_file_url_placeholder' => Lang::get('admin-js.downloadable_online_file_url_placeholder'), 'downloadable_add_more_file_label' => Lang::get('admin-js.downloadable_add_more_file_label'), 'unknown_msg_label' => Lang::get('admin-js.unknown_msg_label'), 'remove_text' => Lang::get('admin-js.remove_text'), 'csv_extension_error_label' => Lang::get('admin-js.csv_extension_error_label'), 'csv_header_error_label' => Lang::get('admin-js.csv_header_error_label'), 'csv_saved_label' => Lang::get('admin-js.csv_saved_label'), 'choose_csv_file_label' => Lang::get('admin-js.choose_csv_file_label'), 'you_want_to_enable_vendor_this_item' => Lang::get('admin-js.you_want_to_enable_vendor_this_item'), 'you_want_to_disable_vendor_this_item' => Lang::get('admin-js.you_want_to_disable_vendor_this_item'), 'yes_enable_it' => Lang::get('admin-js.yes_enable_it'), 'yes_disable_it' => Lang::get('admin-js.yes_disable_it'), 'updated_label' => Lang::get('admin-js.updated_label'), 'vendor_enable_update_label' => Lang::get('admin-js.vendor_enable_update_label'), 'vendor_disable_update_label' => Lang::get('admin-js.vendor_disable_update_label'), 'vendor_package_title_label' => Lang::get('admin-js.vendor_package_title_label'), 'vendor_max_products_label' => Lang::get('admin-js.vendor_max_products_label'), 'vendor_show_map_on_store_page_label' => Lang::get('admin-js.vendor_show_map_on_store_page_label'), 'vendor_show_follow_btn_on_store_page_label' => Lang::get('admin-js.vendor_show_follow_btn_on_store_page_label'), 'vendor_show_share_btn_on_store_page_label' => Lang::get('admin-js.vendor_show_share_btn_on_store_page_label'), 'vendor_show_contact_form_on_store_page_label' => Lang::get('admin-js.vendor_show_contact_form_on_store_page_label'), 'vendor_payment_withdraw_options_label' => Lang::get('admin-js.vendor_payment_withdraw_options_label'), 'vendor_expired_type_label' => Lang::get('admin-js.vendor_expired_type_label'), 'vendor_commission_label' => Lang::get('admin-js.vendor_commission_label'), 'vendor_expired_date_label' => Lang::get('admin-js.vendor_expired_date_label'), 'yes_label' => Lang::get('admin-js.yes_label'), 'no_label' => Lang::get('admin-js.no_label'), 'mass_payment_label' => Lang::get('admin-js.mass_payment_label'), 'manually_payment_label' => Lang::get('admin-js.manually_payment_label'), 'custom_date_label' => Lang::get('admin-js.custom_date_label'), 'lifetime_label' => Lang::get('admin-js.lifetime_label'), 'order_label' => Lang::get('admin-js.order_label'), 'exceed_product_add' => Lang::get('admin-js.exceed_product_add'), 'min_withdraw_amount_label' => Lang::get('admin-js.min_withdraw_amount_label'), 'withdrawal_successfully_completed' => Lang::get('admin-js.withdrawal_successfully_completed'), 'withdrawal_successfully_cancelled' => Lang::get('admin-js.withdrawal_successfully_cancelled'), 'completed_it_label' => Lang::get('admin-js.completed_it_label'), 'cancelled_it_label' => Lang::get('admin-js.cancelled_it_label'), 'request_completed_msg' => Lang::get('admin-js.request_completed_msg'), 'request_cancelled_msg' => Lang::get('admin-js.request_cancelled_msg'), 'select_attr_values' => Lang::get('admin-js.select_attr_values'), 'exceed_hundred_products' => Lang::get('admin-js.exceed_hundred_products'));
    
    $data['user_data']              =   $get_user_data;
    $data['user_permission_list']   =   $user_permission;
    $data['product_parm']           =   $parm;
    $data['admin_js_localization']  =   json_encode( $adminJsLocalization );
    
    return $data;
  }
}