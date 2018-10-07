<?php
namespace shopist\Http\Controllers\Frontend;

use shopist\Http\Controllers\Controller;
use Request;
use Illuminate\Support\Facades\Input;
use shopist\Models\Post;
use shopist\Models\Product;
use shopist\Library\GetFunction;
use Session;
use Anam\Phpcart\Facades\Cart;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use shopist\Models\RequestProduct;
use shopist\Models\Subscription;
use shopist\Models\UsersDetail;
use shopist\Library\CommonFunction;
use shopist\Http\Controllers\OptionController;
use shopist\Http\Controllers\ProductsController;

class FrontendAjaxController extends Controller
{
  public $currency_symbol;
  public $settingsData              = array();
  public $shipping                  = array();
  public $classCommonFunction;
  public $option;
  public $product;


  public function __construct() 
  {
    $this->classGetFunction     = new GetFunction();
    $this->classCommonFunction  =  new CommonFunction();
    $this->option   =  new OptionController();
    $this->product   =  new ProductsController();
    
    
    $this->shipping = $this->option->getShippingMethodData();
    $this->settingsData   = $this->option->getSettingsData();
    $this->currency_symbol = $this->classCommonFunction->get_currency_symbol( $this->settingsData['general_settings']['currency_options']['currency_name'] );
  }
  
  /**
   * 
   *Products search by products title
   *
   * @param null
   * @return array
   */
  public function getProductsByFilterWithName()
  {
    if(Request::isMethod('post') && Request::ajax() && Session::token() == Request::header('X-XSRF-TOKEN'))
    {
      $input = Input::all();
      
       
      $get_posts_by_filter = Product::where(['status' => 1])-> where('title', 'LIKE', '%' .$input['data']. '%')->paginate(15);
     
      $returnHTML = view('pages.ajax-pages.products')->with(['filter_data' => $get_posts_by_filter, '_currency_symbol' => $this->currency_symbol])->render();
      
      return response()->json(array('success' => true, 'html'=> $returnHTML));
    }
  }
  
  /**
   * 
   *Products add to cart initialize
   *
   * @param null
   * @return void
   */
  public function productAddToCart()
  {
    if(Request::isMethod('post') && Request::ajax() && Session::token() == Request::header('X-CSRF-TOKEN')){
      $input = Request::all();
     
      if(isset($input['variation_id']) && $input['variation_id']){
        $this->classCommonFunction->add_to_cart($input['product_id'], $input['qty'], $input['variation_id']);
      }
      else{
        $this->classCommonFunction->add_to_cart($input['product_id'], $input['qty']);
      }
    }
  }
  
  /**
   * 
   *Cart update using shipping method 
   *
   * @param null
   * @return html
   */
  public function cartTotalUpdateUsingShippingMethod(){
    if(Request::isMethod('post') && Request::ajax() && Session::token() == Request::header('X-CSRF-TOKEN')){
      $input = Request::all();
      $shipping_array = array();
      $vendor_details = array();
      $shipping_cost  = 0;
      $shipping_details = array();
      
      if(Cart::items()->count() > 0){
        foreach(Cart::items() as $item){
          $get_vendor_details = get_vendor_details_by_product_id( $item->product_id );
          
          if(count($get_vendor_details) > 0 && $get_vendor_details['user_role_slug'] == 'vendor'){
           $vendor_details = json_decode($get_vendor_details['details']);
           break;
          }
        }
      }
      
      if(is_array($vendor_details) && count($vendor_details) > 0){
        $shipping_details = $this->classCommonFunction->objToArray($vendor_details->shipping_method, true);
      }
      else{
        $shipping_details = $this->shipping;
      }
      
      if($input['data'] == 'flat_rate'){
        $shipping_cost = $shipping_details['flat_rate']['method_cost'];
      }
      elseif($input['data'] == 'free_shipping'){
        $shipping_cost = 0;
      }
      elseif($input['data'] == 'local_delivery'){
        if($shipping_details['local_delivery']['fee_type'] == 'fixed_amount'){
          $shipping_cost = $shipping_details['local_delivery']['delivery_fee'];
        }
        elseif($shipping_details['local_delivery']['fee_type'] == 'cart_total'){
          $shipping_cost = Cart::getLocalDeliveryShippingPercentageTotal();
        }
        elseif($shipping_details['local_delivery']['fee_type'] == 'per_product'){
          $shipping_cost = Cart::getLocalDeliveryShippingPerProductTotal();
        }
      }
      
      $shipping_array = array('shipping_method' => $input['data'], 'shipping_cost' => $shipping_cost);
      
      if(count($shipping_array) > 0){   
        if(Cart::setShippingMethod( $shipping_array )){
          echo  price_html( get_product_price_html_by_filter(Cart::getCartTotal()) ); 
        }
      }
    }
  }
  
  /**
   * 
   *Save custom design image
   *
   * @param null
   * @return json
   */
  public function saveCustomDesignImage()
  {
    if(Request::isMethod('post'))
    {
      if(Session::token() == Request::header('X-CSRF-TOKEN'))
      {
        $input = Request::all();
        //$destinationPath = 'uploads';
        $destinationPath = public_path('uploads');
        $fileName        = '';
        $upload_success  = '';
        $accessToken = uniqid (rand(), true);
        
        
        if(count($input) >0)
        {
          foreach($input as $key => $val)
          {        
            $fileName = uniqid(time(), true). '.' .'png';
            $upload_success = Input::file($key)->move($destinationPath, $fileName);
            
            if ($upload_success) 
            {
              if(Session::has('_recent_saved_custom_design_images'))
              {
                $get_img_ary = Session::get('_recent_saved_custom_design_images');
                $parse_ary = unserialize($get_img_ary);
                
                if(isset($parse_ary[$accessToken]))
                {
                  array_push($parse_ary[$accessToken], $fileName);
                }
                else
                {
                  $parse_ary[$accessToken] = array($fileName);
                }
                
                Session::forget('_recent_saved_custom_design_images');
                Session::put('_recent_saved_custom_design_images', serialize($parse_ary));
              }
              elseif(!Session::has('_recent_saved_custom_design_images'))
              {
                $img_ary = array($accessToken => array($fileName));
                Session::put('_recent_saved_custom_design_images', serialize($img_ary) );
              }
            }
          } 
          
          if(Session::has('_recent_saved_custom_design_images'))
          {
            return response()->json(array('status' => 'success', '_access_token' => $accessToken));
          }
        }
      }
    }
  }
  
  /**
   * 
   *Customize products add to cart initialize
   *
   * @param null
   * @return void
   */
  public function customizeProductAddToCart()
  {
    if(Request::isMethod('post') && Request::ajax() && Session::token() == Request::header('X-CSRF-TOKEN')){
      $input = Request::all();
      
      if(isset($input['customizeData'])){
        $expiresAt = Carbon::now()->addMinutes(50);
        
        if(Cache::add($input['accessToken'], $input['customizeData'], $expiresAt)){
          if(isset($input['variation_id']) && $input['variation_id']){
            $this->classCommonFunction->add_to_cart($input['product_id'], $input['qty'], $input['variation_id'], $input['accessToken']);
          }
          else{
            $this->classCommonFunction->add_to_cart($input['product_id'], $input['qty'], 0, $input['accessToken']);
          }
        }
      }
    }
  }
  
  /**
   * 
   * Request product data save
   *
   * @param null
   * @return json
   * since version 2.0
   */
  public function storeRequestedProductData(){
    if(Request::isMethod('post') && Request::ajax() && Session::token() == Request::header('X-CSRF-TOKEN')){
      $input = Request::all();
      $request_product  =  new RequestProduct;
      
      $request_product->product_id    =   $input['product_id'];
      $request_product->name          =   urldecode($input['product_name']);
      $request_product->email         =   urldecode($input['email']);
      $request_product->phone_number	=   urldecode($input['phone_number']);
      $request_product->description   =   urldecode($input['description']);
      
      if($request_product->save()){
        return response()->json(array('status' => 'saved'));
      }
    }
  }
  
   /**
   * 
   * Subscription data save
   *
   * @param null
   * @return json
   * since version 2.0
   */
  public function storeSubscriptionData()
  {
    if(Request::isMethod('post') && Request::ajax() && Session::token() == Request::header('X-CSRF-TOKEN'))
    {
      $input = Request::all();
      
      if($input['type'] == 'custom'){
        $subscriptions  =  new Subscription;
        
        $subscriptions->name    =   urldecode($input['name']);
        $subscriptions->email   =   urldecode($input['email']);
        
        if($subscriptions->save()){
          return response()->json(array('status' => 'saved'));
        }
      }   
      elseif($input['type'] == 'mailchimp'){
        $subscribe_data = get_subscription_data();
        
        if(isset($subscribe_data['mailchimp']['api_key']) && isset($subscribe_data['mailchimp']['list_id'])){
          $api_key = $subscribe_data['mailchimp']['api_key'];
          $listId  = $subscribe_data['mailchimp']['list_id'];
          $email   = urldecode($input['email']);
          $name    = urldecode($input['name']); 
          
          $data = [
              'email'     =>  $email,
              'status'    =>  'subscribed',
              'firstname' =>  $name,
              'lastname'  =>  ''
          ];
          
          $response = $this->classGetFunction->store_mailchimp_subscriber_data($api_key, $listId, $data);
          
          if($response['status'] == 400){
            return response()->json(array('status' => 'error'));
          }
          elseif($response['status'] == 'subscribed'){
            return response()->json(array('status' => 'saved'));
          }
        }
      }
    }
  }
  
  /**
  * 
  * Set cookie for subscription popup 
  *
  * @param null
  * @return response
  */
  public function setCookieForSubscriptionPopup(){
    if(Request::isMethod('post') && Request::ajax() && Session::token() == Request::header('X-CSRF-TOKEN')){
      return response()->json(array('status' => 'saved'))->withCookie(cookie()->forever('subscribe_popup_not_needed', 'no_need'));
    }
  }

   /**
   * 
   * Frontend user logout
   *
   * @param null
   * @return void
   */
  public function logoutFromFrontendUserLogin()
  {
    if(Request::isMethod('post') && Request::ajax() && Session::token() == Request::header('X-XSRF-TOKEN'))
    {
      if(Session::has('shopist_frontend_user_id'))
      {
        Session::forget('shopist_frontend_user_id');
        echo urlencode(route('user-login-page'));
      }
    }
  }
  
  /**
   * 
   * Frontend user wishlist data save
   *
   * @param null
   * @return json
   */
  public function userWishlistDataSaved()
  {
    if(Request::isMethod('post') && Request::ajax() && Session::token() == Request::header('X-CSRF-TOKEN')){
      $input               =  Request::all();
      $wishlist            =  array();
      $get_current_user_id =  get_current_frontend_user_info();
      $user_details        =  new UsersDetail;
      $get_data_by_user_id =  array();
      
      if(isset($get_current_user_id['user_id']) && $get_current_user_id['user_id']){
        $wishlist[$input['data']] = $input['data'];
        $wishlist_data = array('post_type' => 'wishlist', 'details' => $wishlist);

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
          
          if(isset($parse_details['wishlists_details'])){
            $get_wishlist = $parse_details['wishlists_details'];
            
            if(!empty($get_wishlist) && count($get_wishlist) > 0 && array_key_exists(key($wishlist_data['details']), $get_wishlist)){
              return response()->json(array('status' => 'error', 'notice_type' => 'item_already_exists'));
            }
            else{
              if($this->classCommonFunction->frontendUserAccountDataProcess( $wishlist_data )){
                return response()->json(array('status' => 'success', 'notice_type' => 'user_wishlist_saved'));
              }
            }
          }
        }
      }
      else{
        return response()->json(array('status' => 'error', 'notice_type' => 'user_login_required'));
      }
    }
  }
  
  /**
   * 
   * Manage multi language
   *
   * @param null
   * @return json
   */
  public function multiLangProcessing(){
    if(Request::isMethod('post') && Request::ajax() && Session::token() == Request::header('X-CSRF-TOKEN')){
      $input = Request::all();
     
      return response()->json(array('status' => 'success'))->withCookie( cookie()->forever('shopist_multi_lang', $input['data']) );
    }
  }
  
  /**
   * 
   * Manage multi currency
   *
   * @param null
   * @return json
   */
  public function multiCurrencyProcessing(){
    if(Request::isMethod('post') && Request::ajax() && Session::token() == Request::header('X-CSRF-TOKEN')){
      $input = Request::all();
      return response()->json(array('status' => 'success'))->withCookie( cookie()->forever('shopist_multi_currency', $input['data']) );
    }
  }
  
  /**
   * 
   * Get function for products quick view
   *
   * @param null
   * @return html
   */
  public function getQuickViewProductData(){
    $input = Request::all();
    
    if(Request::isMethod('post') && Request::ajax() && Session::token() == Request::header('X-CSRF-TOKEN')){
      $data = array();
      
      $data = $this->classCommonFunction->get_dynamic_frontend_content_data();
      $data['single_product_details']  =  $this->product->getProductDataById( $input['product_id'] );
      $data['attr_lists']              =  $this->product->getAllAttributes( $input['product_id'] );
      $data['comments_rating_details'] =  get_comments_rating_details( $input['product_id'], 'product' );
          
      $returnHTML = view('pages.ajax-pages.quick-view-content')->with( $data )->render();

      return response()->json(array('success' => true, 'html'=> $returnHTML));
    }
  }
  
  /**
   * 
   * Check and apply user coupon
   *
   * @param coupon code
   * @return response
   */
  public function applyUserCoupon(){
    $input = Request::all();
    
    if(Request::isMethod('post') && Request::ajax() && Session::token() == Request::header('X-CSRF-TOKEN')){
      $response = $this->classGetFunction->manage_coupon($input['_couponCode'], 'new_add');
      $coupon_response = $this->classGetFunction->get_coupon_response( $input['_couponCode'] );
      
      if(!empty($response) && $response == 'no_coupon_data'){
        return response()->json(array('error' => true, 'error_type'=> 'no_coupon_data'));
      }
      elseif(!empty($response) && $response == 'coupon_already_apply'){
        return response()->json(array('error' => true, 'error_type'=> 'coupon_already_apply'));
      }
      elseif(!empty($response) && $response == 'less_from_min_amount'){
        return response()->json(array('error' => true, 'error_type'=> 'less_from_min_amount', 'min_amount' => price_html( get_product_price_html_by_filter($coupon_response['coupon_min_restriction_amount'], get_frontend_selected_currency() ))));
      }
      elseif(!empty($response) && $response == 'exceed_from_max_amount'){
        return response()->json(array('error' => true, 'error_type'=> 'exceed_from_max_amount', 'max_amount' => price_html( get_product_price_html_by_filter($coupon_response['coupon_max_restriction_amount'], get_frontend_selected_currency() ))));
      }
      elseif(!empty($response) && $response == 'no_login'){
        return response()->json(array('error' => true, 'error_type'=> 'no_login'));
      }
      elseif(!empty($response) && $response == 'user_role_not_match'){
        $get_login_user = get_current_frontend_user_info();
        return response()->json(array('error' => true, 'error_type'=> 'user_role_not_match', 'role_name' => $get_login_user['user_role']));
      }
      elseif(!empty($response) && $response == 'coupon_expired'){
        return response()->json(array('error' => true, 'error_type'=> 'coupon_expired'));
      }
      elseif(!empty($response) && $response == 'discount_from_product'){
        return response()->json(array('success' => true, 'success_type'=> 'discount_from_product', 'discount_price' => price_html( get_product_price_html_by_filter(Cart::couponPrice(), get_frontend_selected_currency() )), 'grand_total' => price_html( get_product_price_html_by_filter(Cart::getCartTotal(), get_frontend_selected_currency() ))));
      }
      elseif(!empty($response) && $response == 'percentage_discount_from_product'){
        return response()->json(array('success' => true, 'success_type'=> 'percentage_discount_from_product', 'discount_price' => price_html( get_product_price_html_by_filter(Cart::couponPrice(), get_frontend_selected_currency() )), 'grand_total' => price_html( get_product_price_html_by_filter(Cart::getCartTotal(), get_frontend_selected_currency() ))));
      }
      elseif(!empty($response) && $response == 'discount_from_total_cart'){
        return response()->json(array('success' => true, 'success_type'=> 'discount_from_total_cart', 'discount_price' => price_html( get_product_price_html_by_filter(Cart::couponPrice(), get_frontend_selected_currency() )), 'grand_total' => price_html( get_product_price_html_by_filter(Cart::getCartTotal(), get_frontend_selected_currency() ))));
      }
      elseif(!empty($response) && $response == 'percentage_discount_from_total_cart'){
        return response()->json(array('success' => true, 'success_type'=> 'percentage_discount_from_total_cart', 'discount_price' => price_html( get_product_price_html_by_filter(Cart::couponPrice(), get_frontend_selected_currency() )), 'grand_total' => price_html( get_product_price_html_by_filter(Cart::getCartTotal(), get_frontend_selected_currency() ))));
      }
      elseif(!empty($response) && $response == 'exceed_from_cart_total'){
        return response()->json(array('error' => true, 'error_type'=> 'exceed_from_cart_total'));
      }
    }
  }
  
  /**
   * 
   * user coupon remove
   *
   * @param null
   * @return response
   */
  public function removeUserCoupon(){
    if(Cart::remove_coupon()){
      return response()->json(array('success' => true, 'grand_total'=> price_html( get_product_price_html_by_filter(Cart::getCartTotal(), get_frontend_selected_currency() ))));
    }
  }
  
  /**
   * 
   * delete item from wishlist
   *
   * @param null
   * @return response
   */
  public function deleteItemFromWishlist(){
    if(Request::isMethod('post') && Request::ajax() && Session::token() == Request::header('X-CSRF-TOKEN')){
      $input               =  Request::all();
      $get_current_user_id =  get_current_frontend_user_info();
      
      if(!empty($get_current_user_id) && count($get_current_user_id) > 0){
        $get_data_by_user_id = get_user_account_details_by_user_id( $get_current_user_id['user_id'] );

        if(count($get_data_by_user_id) > 0){
          $array_shift   = array_shift($get_data_by_user_id );
          $parse_details = json_decode($array_shift['details'], true);

          if(isset($parse_details['wishlists_details']) && count($parse_details['wishlists_details']) > 0 ){
            $get_wishlist = $parse_details['wishlists_details'];

            if(!empty($get_wishlist) && count($get_wishlist) > 0 && array_key_exists($input['data'], $get_wishlist)){
              $unsetData =  array_diff($get_wishlist, array($input['data'] => $input['data']));
              
              $wishlist_data = array('post_type' => 'wishlist','post_action' => 'delete', 'details' => $unsetData);
              if($this->classCommonFunction->frontendUserAccountDataProcess( $wishlist_data )){
                return response()->json(array('status' => 'success', 'notice_type' => 'deleted_item'));
              }
            }
          }
        }
      }  
    }
  }
  
  /**
   * 
   * Get Mini cart data
   *
   * @param null
   * @return response
   */
  public function getMiniCartData(){
    if(Request::isMethod('post') && Request::ajax() && Session::token() == Request::header('X-CSRF-TOKEN')){
      $returnHTML = view('pages.ajax-pages.mini-cart-html')->render();
     
      return response()->json(array('status' => 'success', 'type' => 'mini_cart_data', 'html'=> $returnHTML));
    }
  }
  
  /**
   * 
   * Product compare data process
   *
   * @param null
   * @return response
   */
  public function productCompareDataSaved(){
    if(Request::isMethod('post') && Request::ajax() && Session::token() == Request::header('X-CSRF-TOKEN')){
      $input = Request::all();
      
      if(!Session::has('shopist_selected_compare_product_ids')){
        Session::put('shopist_selected_compare_product_ids', array($input['id']));
        return response()->json(array('status' => 'success', 'notice_type' => 'compare_data_saved', 'item_count' => 1));
      }
      elseif(Session::has('shopist_selected_compare_product_ids')){
        $get_data = Session::get('shopist_selected_compare_product_ids');
        
        if(in_array($input['id'], $get_data)){
          return response()->json(array('status' => 'error', 'notice_type' => 'already_saved', 'item_count' => count($get_data)));
        }
        else{
          if(count($get_data) < 4){
            array_push($get_data, $input['id']);
            Session::forget('shopist_selected_compare_product_ids');
            Session::put('shopist_selected_compare_product_ids', $get_data);

            return response()->json(array('status' => 'success', 'notice_type' => 'compare_data_saved', 'item_count' => count($get_data)));
          }
          else{
            return response()->json(array('status' => 'error', 'notice_type' => 'compare_data_exceed_limit', 'item_count' => count($get_data)));
          }
        }
       
      }
    }
  }
  
  /**
   * 
   * Contact with vendor via email
   *
   * @param name, message
   * @return response
   */
  public function contactWithVendorEmail(){
    if(Request::isMethod('post') && Request::ajax() && Session::token() == Request::header('X-CSRF-TOKEN')){
      $input = Request::all(); 
      $mailData = array();
      
      $mailData['source']           =   'contact_to_vendor_mail';
      $mailData['data']             =   array('_mail_to' => base64_decode($input['vendor_mail']), '_mail_from' => base64_decode($input['customer_email']), '_subject' => base64_decode($input['name']), '_message' => base64_decode($input['message']));

      $this->classGetFunction->sendCustomMail( $mailData );
      
      return response()->json(array('status' => 'success'));
    }
  }
}