<?php
namespace shopist\Http\Controllers;

use shopist\Http\Controllers\Controller;
use Request;
use Session;
use Illuminate\Support\Facades\Input;
use shopist\Models\Option;
use shopist\Http\Controllers\OptionController;
use shopist\Models\UsersDetail;
use Illuminate\Support\Facades\Lang;
use shopist\Library\CommonFunction;


class ShippingMethodController extends Controller
{
  public $option;
  public $classCommonFunction;
		
	public function __construct(){
		$this->option   =  new OptionController();
    $this->classCommonFunction  =   new CommonFunction();
	}
  
  /**
   * 
   * Shipping method option content
   *
   * @param null
   * @return response view
   */
  public function shippingMethodOptionContent(){
    $data = array();
    
    $data = $this->classCommonFunction->commonDataForAllPages();
    
    if(is_vendor_login()){
      $get_user_store_data = get_user_account_details_by_user_id( Session::get('shopist_admin_user_id'));
      $details = json_decode(array_shift($get_user_store_data)['details']);
      $data['shipping_method_data'] = $details->shipping_method;
    }
    else{
      $unserialize_data = $this->option->getShippingMethodData();
      $data['shipping_method_data']  =  $unserialize_data;
    }
    
    if(is_vendor_login()){
      return view('pages.admin.shipping.vendor-shipping-options', $data);
    }
    else{
      return view('pages.admin.shipping.shipping-options', $data);
    }
  }
  
   /**
   * 
   * Shipping method flat rate content
   *
   * @param null
   * @return response view
   */
  public function shippingMethodFlatRateContent(){
    $data = array();
    
    $data = $this->classCommonFunction->commonDataForAllPages();
    
    if(is_vendor_login()){
      $get_user_store_data = get_user_account_details_by_user_id( Session::get('shopist_admin_user_id'));
      $details = json_decode(array_shift($get_user_store_data)['details']);
      $data['shipping_method_data'] = $details->shipping_method;
    }
    else{
      $unserialize_data = $this->option->getShippingMethodData();
      $data['shipping_method_data']  =  $unserialize_data;
    }
    
    if(is_vendor_login()){
      return view('pages.admin.shipping.vendor-shipping-method-flat-rate', $data);
    }
    else{
      return view('pages.admin.shipping.shipping-method-flat-rate', $data);
    }
  }
  
  /**
   * 
   * Shipping method free shipping content
   *
   * @param null
   * @return response view
   */
  public function shippingMethodFreeShippingContent(){
    $data = array();
    
    $data = $this->classCommonFunction->commonDataForAllPages();
    
    if(is_vendor_login()){
      $get_user_store_data = get_user_account_details_by_user_id( Session::get('shopist_admin_user_id'));
      $details = json_decode(array_shift($get_user_store_data)['details']);
      $data['shipping_method_data'] = $details->shipping_method;
    }
    else{
      $unserialize_data = $this->option->getShippingMethodData();
      $data['shipping_method_data']  =  $unserialize_data;
    }
    
    if(is_vendor_login()){
      return view('pages.admin.shipping.vendor-shipping-method-free-shipping', $data);
    }
    else{
      return view('pages.admin.shipping.shipping-method-free-shipping', $data);
    }
  }
  
  /**
   * 
   * Shipping method local delivery content
   *
   * @param null
   * @return response view
   */
  public function shippingMethodLocalDeliveryContent(){
    $data = array();
    
    $data = $this->classCommonFunction->commonDataForAllPages();
    
    if(is_vendor_login()){
      $get_user_store_data = get_user_account_details_by_user_id( Session::get('shopist_admin_user_id'));
      $details = json_decode(array_shift($get_user_store_data)['details']);
      $data['shipping_method_data'] = $details->shipping_method;
    }
    else{
      $unserialize_data = $this->option->getShippingMethodData();
      $data['shipping_method_data']  =  $unserialize_data;
    }
    
    if(is_vendor_login()){
      return view('pages.admin.shipping.vendor-shipping-method-local-delivery', $data);
    }
    else{
      return view('pages.admin.shipping.shipping-method-local-delivery', $data);
    }
  }

  /**
   * 
   * Save/Update shipping method data
   *
   * @param null
   * @return void
   */
  public function saveShippingMethod(){
    if( Request::isMethod('post') && Session::token() == Input::get('_token') ){
      $get_return_shipping_data = array();
      $vendor_data = null;
      
      if(is_vendor_login()){
        $get_user_store_data = get_user_account_details_by_user_id( Session::get('shopist_admin_user_id') );
        $vendor_data = json_decode(array_shift($get_user_store_data)['details']);
      }
           
      if(Input::get('_shipping_method_name') == 'save_options'){
        $enable_shipping = (Input::has('inputEnableShipping')) ? true : false;
        $display_mode    = Input::get('inputDisplayMode');
        
        if(is_vendor_login() && !empty($vendor_data)){
          $vendor_data->shipping_method->shipping_option->enable_shipping        =  $enable_shipping;
          $vendor_data->shipping_method->shipping_option->display_mode           =  $display_mode;

          $update_data = array(
                        'details' => json_encode($vendor_data)
          );

          if(UsersDetail::where('user_id', Session::get('shopist_admin_user_id'))->update( $update_data )){
            Session::flash('success-message', Lang::get('admin.successfully_updated_msg'));
            return redirect()->back();
          }
        }
        else{
          $get_return_shipping_data = $this->create_shipping_array_data('shipping_option', $enable_shipping, $display_mode, '', '');
        }
      }
      elseif (Input::get('_shipping_method_name') == 'save_flat_rate') {
        $enable_method   = (Input::has('inputEnableFlatRate')) ? true : false;
        $method_title    = Input::get('inputFlatRateTitle');
        $method_cost     = Input::get('inputFlatRateCost');
        
        if(is_vendor_login() && !empty($vendor_data)){
          $vendor_data->shipping_method->flat_rate->enable_option  =  $enable_method;
          $vendor_data->shipping_method->flat_rate->method_title   =  $method_title;
          $vendor_data->shipping_method->flat_rate->method_cost    =  $method_cost;

          $update_data = array(
                        'details' => json_encode($vendor_data)
          );

          if(UsersDetail::where('user_id', Session::get('shopist_admin_user_id'))->update( $update_data )){
            Session::flash('success-message', Lang::get('admin.successfully_updated_msg'));
            return redirect()->back();
          }
        }
        else{
          $get_return_shipping_data = $this->create_shipping_array_data('shipping_method_flat_rate', $enable_method, $method_title, $method_cost, '');
        }
      }
      elseif (Input::get('_shipping_method_name') == 'save_free_shipping') {
        $enable_method   = (Input::has('inputEnableFreeShipping')) ? true : false;
        $method_title    = Input::get('inputFreeShippingTitle');
        $method_amount   = Input::get('inputFreeShippingOrderAmount');
        
        if(is_vendor_login() && !empty($vendor_data)){
          $vendor_data->shipping_method->free_shipping->enable_option  =  $enable_method;
          $vendor_data->shipping_method->free_shipping->method_title   =  $method_title;
          $vendor_data->shipping_method->free_shipping->order_amount   =  $method_amount;

          $update_data = array(
                        'details' => json_encode($vendor_data)
          );

          if(UsersDetail::where('user_id', Session::get('shopist_admin_user_id'))->update( $update_data )){
            Session::flash('success-message', Lang::get('admin.successfully_updated_msg'));
            return redirect()->back();
          }
        }
        else{
          $get_return_shipping_data = $this->create_shipping_array_data('shipping_method_free_shipping', $enable_method, $method_title, $method_amount, '');
        }
      }
      elseif (Input::get('_shipping_method_name') == 'save_local_delivery') {
        $enable_method   = (Input::has('inputEnableLocalDelivery')) ? true : false;
        $method_title    = Input::get('inputLocalDeliveryTitle');
        $fee_type        = Input::get('inputLocalDeliveryFeeType');
        $delivery_fee    = Input::get('inputLocalDeliveryDeliveryFee');
        
        if(is_vendor_login() && !empty($vendor_data)){
          $vendor_data->shipping_method->local_delivery->enable_option    =  $enable_method;
          $vendor_data->shipping_method->local_delivery->method_title     =  $method_title;
          $vendor_data->shipping_method->local_delivery->fee_type         =  $fee_type;
          $vendor_data->shipping_method->local_delivery->delivery_fee     =  $delivery_fee;

          $update_data = array(
                        'details' => json_encode($vendor_data)
          );

          if(UsersDetail::where('user_id', Session::get('shopist_admin_user_id'))->update( $update_data )){
            Session::flash('success-message', Lang::get('admin.successfully_updated_msg'));
            return redirect()->back();
          }
        }
        else{
          $get_return_shipping_data = $this->create_shipping_array_data('shipping_method_local_delivery', $enable_method, $method_title, $fee_type, $delivery_fee);
        }
      }
      
      $data = array(
                    'option_value' => serialize($get_return_shipping_data)
      );
      
      if( Option::where('option_name', '_shipping_method_data')->update($data)){
        Session::flash('success-message', Lang::get('admin.successfully_updated_msg'));
        return redirect()->back();
      }
    }
    else{
      return redirect()-> back();
    }
  }
  
  /**
   * 
   * Shipping data process for save
   *
   * @param shipping data
   * @return array
   */
  public function create_shipping_array_data($source, $parm1, $parm2, $parm3, $parm4){
    $enable_shipping_option         =   '';
    $shipping_option_display_mode   =   '';
    $flat_rate_enable               =   '';
    $flat_rate_title                =   '';
    $flat_rate_cost                 =   '';
    $free_shipping_enable           =   '';
    $free_shipping_title            =   '';
    $free_shipping_order_amount     =   '';
    $local_delivery_enable          =   '';
    $local_delivery_title           =   '';
    $local_delivery_fee_type        =   '';
    $local_delivery_fee             =   '';
    
    $unserialize_data = $this->option->getShippingMethodData();
    
    if($source == 'shipping_option'){
      $enable_shipping_option         =   $parm1;
      $shipping_option_display_mode   =   $parm2;
    }
    else {
      $enable_shipping_option         =   $unserialize_data['shipping_option']['enable_shipping'];
      $shipping_option_display_mode   =   $unserialize_data['shipping_option']['display_mode'];
    }
    
    if($source == 'shipping_method_flat_rate'){
      $flat_rate_enable               =   $parm1;
      $flat_rate_title                =   $parm2;
      $flat_rate_cost                 =   $parm3;
    }
    else{
      $flat_rate_enable               =   $unserialize_data['flat_rate']['enable_option'];
      $flat_rate_title                =   $unserialize_data['flat_rate']['method_title'];
      $flat_rate_cost                 =   $unserialize_data['flat_rate']['method_cost'];
    }

    if($source == 'shipping_method_free_shipping'){
      $free_shipping_enable           =   $parm1;
      $free_shipping_title            =   $parm2;
      $free_shipping_order_amount     =   $parm3;
    }
    else{
      $free_shipping_enable           =   $unserialize_data['free_shipping']['enable_option'];
      $free_shipping_title            =   $unserialize_data['free_shipping']['method_title'];
      $free_shipping_order_amount     =   $unserialize_data['free_shipping']['order_amount'];
    }
    
    if($source == 'shipping_method_local_delivery'){
      $local_delivery_enable          =   $parm1;
      $local_delivery_title           =   $parm2;
      $local_delivery_fee_type        =   $parm3;
      $local_delivery_fee             =   $parm4;
    }
    else {
      $local_delivery_enable          =   $unserialize_data['local_delivery']['enable_option'];
      $local_delivery_title           =   $unserialize_data['local_delivery']['method_title'];
      $local_delivery_fee_type        =   $unserialize_data['local_delivery']['fee_type'];
      $local_delivery_fee             =   $unserialize_data['local_delivery']['delivery_fee'];
    }
    
    $shipping_method_array = array( 
        'shipping_option'  => array('enable_shipping' => $enable_shipping_option, 'display_mode' => $shipping_option_display_mode),
        'flat_rate'        => array('enable_option' => $flat_rate_enable, 'method_title' => $flat_rate_title, 'method_cost' => $flat_rate_cost),
        'free_shipping'    => array('enable_option' => $free_shipping_enable, 'method_title' => $free_shipping_title, 'order_amount' => $free_shipping_order_amount),
        'local_delivery'   => array('enable_option' => $local_delivery_enable, 'method_title' => $local_delivery_title, 'fee_type' => $local_delivery_fee_type, 'delivery_fee' => $local_delivery_fee)
    );
    
    return $shipping_method_array;
  }
}