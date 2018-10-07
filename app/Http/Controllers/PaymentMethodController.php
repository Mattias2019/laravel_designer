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


class PaymentMethodController extends Controller
{
  public $option;
  public $classCommonFunction;
		
	public function __construct(){
		$this->option   =  new OptionController();
    $this->classCommonFunction  =   new CommonFunction();
	}
  
  /**
   * 
   * Payment method option content
   *
   * @param null
   * @return response view
   */
  public function paymentMethodOptionsContent(){
    $data = array();
    
    $data = $this->classCommonFunction->commonDataForAllPages();
    
    if(is_vendor_login()){
      $get_user_store_data = get_user_account_details_by_user_id( Session::get('shopist_admin_user_id'));
      $details = json_decode(array_shift($get_user_store_data)['details']);
      $data['payment_method_data']  =  $details->payment_method;
    }
    else{
      $data['payment_method_data']  =  $this->option->getPaymentMethodData();
    }
    
    if(is_vendor_login()){
      return view('pages.admin.payment.vendor-payment-options', $data);
    }
    else{
      return view('pages.admin.payment.payment-options', $data);
    }
  }
  
  /**
   * 
   * Payment method direct bank content
   *
   * @param null
   * @return response view
   */
  public function paymentMethodDirectBankContent(){
    $data = array();
    
    $data = $this->classCommonFunction->commonDataForAllPages();
    
    if(is_vendor_login()){
      $get_user_store_data = get_user_account_details_by_user_id( Session::get('shopist_admin_user_id'));
      $details = json_decode(array_shift($get_user_store_data)['details']);
      $data['payment_method_data']  =  $details->payment_method;
    }
    else{
      $data['payment_method_data']  =  $this->option->getPaymentMethodData();
    }
    
    if(is_vendor_login()){
      return view('pages.admin.payment.vendor-payment-direct-bank', $data);
    }
    else{
      return view('pages.admin.payment.payment-direct-bank', $data);
    }
  }
  
  /**
   * 
   * Payment method cash on delivery content
   *
   * @param null
   * @return response view
   */
  public function paymentMethodCashOnDeliveryContent(){
    $data = array();
    
    $data = $this->classCommonFunction->commonDataForAllPages();
    
    if(is_vendor_login()){
      $get_user_store_data = get_user_account_details_by_user_id( Session::get('shopist_admin_user_id'));
      $details = json_decode(array_shift($get_user_store_data)['details']);
      $data['payment_method_data']  =  $details->payment_method;
    }
    else{
      $data['payment_method_data']  =  $this->option->getPaymentMethodData();
    }
    
    if(is_vendor_login()){
      return view('pages.admin.payment.vendor-payment-cash-on-delivery', $data);
    }
    else{
      return view('pages.admin.payment.payment-cash-on-delivery', $data);
    }
  }
  
  /**
   * 
   * Payment method paypal content
   *
   * @param null
   * @return response view
   */
  public function paymentMethodPaypalContent(){
    $data = array();
    
    $data = $this->classCommonFunction->commonDataForAllPages();
    
    if(is_vendor_login()){
      $get_user_store_data = get_user_account_details_by_user_id( Session::get('shopist_admin_user_id'));
      $details = json_decode(array_shift($get_user_store_data)['details']);
      $data['payment_method_data']  =  $details->payment_method;
    }
    else{
      $data['payment_method_data']  =  $this->option->getPaymentMethodData();
    }
    
    if(is_vendor_login()){
      return view('pages.admin.payment.vendor-payment-paypal', $data);
    }
    else{
      return view('pages.admin.payment.payment-paypal', $data);
    }
  }
  
  /**
   * 
   * Payment method stripe content
   *
   * @param null
   * @return response view
   */
  public function paymentMethodStripeContent(){
    $data = array();
    
    $data = $this->classCommonFunction->commonDataForAllPages();
    
    if(is_vendor_login()){
      $get_user_store_data = get_user_account_details_by_user_id( Session::get('shopist_admin_user_id'));
      $details = json_decode(array_shift($get_user_store_data)['details']);
      $data['payment_method_data']  =  $details->payment_method;
    }
    else{
      $data['payment_method_data']  =  $this->option->getPaymentMethodData();
    }
    
    if(is_vendor_login()){
      return view('pages.admin.payment.vendor-payment-stripe', $data);
    }
    else{
      return view('pages.admin.payment.payment-stripe', $data);
    }
  }
  
  /**
   * 
   * Payment method 2checkout content
   *
   * @param null
   * @return response view
   */
  public function paymentMethodTwoCheckoutContent(){
    $data = array();
    
    $data = $this->classCommonFunction->commonDataForAllPages();
    
    if(is_vendor_login()){
      $get_user_store_data = get_user_account_details_by_user_id( Session::get('shopist_admin_user_id'));
      $details = json_decode(array_shift($get_user_store_data)['details']);
      $data['payment_method_data']  =  $details->payment_method;
    }
    else{
      $data['payment_method_data']  =  $this->option->getPaymentMethodData();
    }
    
    if(is_vendor_login()){
      return view('pages.admin.payment.vendor-payment-twocheckout', $data);
    }
    else{
      return view('pages.admin.payment.payment-two-checkout', $data);
    }
  }
  
  /**
   * 
   * Save/Update payment data
   *
   * @param null
   * @return void
   */
  public function savePaymentData(){
    if( Request::isMethod('post') && Session::token() == Input::get('_token') ){
      $get_return_payment_data = array();
      $vendor_data = null;
      
      if(is_vendor_login()){
        $get_user_store_data = get_user_account_details_by_user_id( Session::get('shopist_admin_user_id') );
        $vendor_data = json_decode(array_shift($get_user_store_data)['details']);
      }
      
      if(Input::get('_payment_method_type') == 'save_options'){
        $isEnable = 'no';
        $enable_payment_method = (Input::has('inputEnablePaymentMethod')) ? true : false;
        
        if($enable_payment_method){
          $isEnable = 'yes';
        }
        else{
          $isEnable = 'no';
        }
        
        if(is_vendor_login() && !empty($vendor_data)){
          $vendor_data->payment_method->payment_option  =  $isEnable;
          
          $update_data = array(
                        'details' => json_encode($vendor_data)
          );

          if(UsersDetail::where('user_id', Session::get('shopist_admin_user_id'))->update( $update_data )){
            Session::flash('success-message', Lang::get('admin.successfully_updated_msg'));
            return redirect()->back();
          }
        }
        else{
          $get_return_payment_data = $this->create_payment_array_data('payment_option', array('status' => $isEnable));
        }
      }
      elseif (Input::get('_payment_method_type') == 'bacs') {
        $isBacsEnable = 'no';
        $enable_bacs = (Input::has('inputEnablePaymentBACSMethod')) ? true : false;
        
        if($enable_bacs){
          $isBacsEnable = 'yes';
        }
        else{
          $isBacsEnable = 'no';
        }
        
        if(is_vendor_login() && !empty($vendor_data)){
          $vendor_data->payment_method->dbt->status         =  $isBacsEnable;
          $vendor_data->payment_method->dbt->title          =  Input::get('inputBACSTitle');
          $vendor_data->payment_method->dbt->description    =  Input::get('inputBACSDescription');
          $vendor_data->payment_method->dbt->instructions   =  Input::get('inputBACSInstructions');
          $vendor_data->payment_method->dbt->account_name   =  Input::get('inputBACSAccountName');
          $vendor_data->payment_method->dbt->account_number =  Input::get('inputBACSAccountNumber');
          $vendor_data->payment_method->dbt->bank_name      =  Input::get('inputBACSBankName');
          $vendor_data->payment_method->dbt->short_code     =  Input::get('inputBACSShortCode');
          $vendor_data->payment_method->dbt->IBAN           =  Input::get('inputBACSIBAN');
          $vendor_data->payment_method->dbt->SWIFT          =  Input::get('inputBACSSwift');
          
          $update_data = array(
                        'details' => json_encode($vendor_data)
          );

          if(UsersDetail::where('user_id', Session::get('shopist_admin_user_id'))->update( $update_data )){
            Session::flash('success-message', Lang::get('admin.successfully_updated_msg'));
            return redirect()->back();
          }
        }
        else{
          $get_return_payment_data = $this->create_payment_array_data('bacs', array('status' => $isBacsEnable, 'title' => Input::get('inputBACSTitle'), 'description' => Input::get('inputBACSDescription'), 'instructions' => Input::get('inputBACSInstructions'), 'account_details' => array('account_name' => Input::get('inputBACSAccountName'), 'account_number' => Input::get('inputBACSAccountNumber'), 'bank_name' => Input::get('inputBACSBankName'),'short_code' => Input::get('inputBACSShortCode'),'iban' => Input::get('inputBACSIBAN'), 'swift' => Input::get('inputBACSSwift'))));
        }
      }
      elseif (Input::get('_payment_method_type') == 'cod') {
        $isCodEnable = 'no';
        $enable_cod = (Input::has('inputEnablePaymentCODMethod')) ? true : false;
        
        if($enable_cod){
          $isCodEnable = 'yes';
        }
        else{
          $isCodEnable = 'no';
        }
        
        if(is_vendor_login() && !empty($vendor_data)){
          $vendor_data->payment_method->cod->status         =  $isCodEnable;
          $vendor_data->payment_method->cod->title          =  Input::get('inputCODTitle');
          $vendor_data->payment_method->cod->description    =  Input::get('inputCODDescription');
          $vendor_data->payment_method->cod->instructions   =  Input::get('inputCODInstructions');
          
          $update_data = array(
                        'details' => json_encode($vendor_data)
          );

          if(UsersDetail::where('user_id', Session::get('shopist_admin_user_id'))->update( $update_data )){
            Session::flash('success-message', Lang::get('admin.successfully_updated_msg'));
            return redirect()->back();
          }
        }
        else{
          $get_return_payment_data = $this->create_payment_array_data('cod', array('status' => $isCodEnable, 'title' => Input::get('inputCODTitle'), 'description' => Input::get('inputCODDescription'), 'instructions' => Input::get('inputCODInstructions')));
        }
      }
      elseif (Input::get('_payment_method_type') == 'paypal') {
        $isPaypalEnable        = 'no';
        $isPaypalSandboxEnable = 'no';
        $enable_paypal         = (Input::has('inputEnablePaymentPaypalMethod')) ? true : false;
        $enable_sandbox        = (Input::has('inputEnablePaypalSandboxOption')) ? true : false;
        
        if($enable_paypal){
          $isPaypalEnable = 'yes';
        }
        else{
          $isPaypalEnable = 'no';
        }
        
        if($enable_sandbox){
          $isPaypalSandboxEnable = 'yes';
        }
        else{
          $isPaypalSandboxEnable = 'no';
        }
        
        if(is_vendor_login() && !empty($vendor_data)){
          $vendor_data->payment_method->paypal->status         =  $isPaypalEnable;
          $vendor_data->payment_method->paypal->title          =  Input::get('inputPaypalTitle');
          $vendor_data->payment_method->paypal->email_id       =  Input::get('inputPaypalEmail');
          $vendor_data->payment_method->paypal->description    =  Input::get('inputPaypalDescription');
          
          $update_data = array(
                        'details' => json_encode($vendor_data)
          );

          if(UsersDetail::where('user_id', Session::get('shopist_admin_user_id'))->update( $update_data )){
            Session::flash('success-message', Lang::get('admin.successfully_updated_msg'));
            return redirect()->back();
          }
        }
        else{
          $get_return_payment_data = $this->create_payment_array_data('paypal', array('status' => $isPaypalEnable, 'title' => Input::get('inputPaypalTitle'), 'client_id' => Input::get('inputPaypalClientId'), 'secret' => Input::get('inputPaypalSecret'), 'sandbox_status' => $isPaypalSandboxEnable,  'description' => Input::get('inputPaypalDescription')));
        }
      }
      elseif (Input::get('_payment_method_type') == 'stripe') {
        $isStripeEnable          =  'no';
        $isStripeTestModeEnable  =  'no';
        $enable_stripe           =  (Input::has('inputEnablePaymentStripeMethod')) ? true : false;
        $enable_test_mode        =  (Input::has('inputEnableStripeTestOption')) ? true : false;
        
        if($enable_stripe){
          $isStripeEnable = 'yes';
        }
        else{
          $isStripeEnable = 'no';
        }
        
        if($enable_test_mode){
          $isStripeTestModeEnable = 'yes';
        }
        else{
          $isStripeTestModeEnable = 'no';
        }
       
        if(is_vendor_login() && !empty($vendor_data)){
          $vendor_data->payment_method->stripe->status                =  $isStripeEnable;
          $vendor_data->payment_method->stripe->title                 =  Input::get('inputStripeTitle');
          $vendor_data->payment_method->stripe->email_id              =  Input::get('inputStripeEmail');
          $vendor_data->payment_method->stripe->card_number           =  Input::get('inputStripeCardNumber');
          $vendor_data->payment_method->stripe->cvc                   =  Input::get('inputStripeCardCVC'); 
          $vendor_data->payment_method->stripe->expiration_month      =  Input::get('inputStripeCardExpirationMonth');
          $vendor_data->payment_method->stripe->expiration_year       =  Input::get('inputStripeCardExpirationYear');  
          $vendor_data->payment_method->stripe->description           =  Input::get('inputStripeDescription');
          
          
          $update_data = array(
                        'details' => json_encode($vendor_data)
          );

          if(UsersDetail::where('user_id', Session::get('shopist_admin_user_id'))->update( $update_data )){
            Session::flash('success-message', Lang::get('admin.successfully_updated_msg'));
            return redirect()->back();
          }
        }
        else{
          $get_return_payment_data = $this->create_payment_array_data('stripe', array('status' => $isStripeEnable, 'title' => Input::get('inputStripeTitle'), 'test_secret_key' => Input::get('inputTestSecretKey'), 'test_publishable_key' => Input::get('inputTestPublishableKey'), 'live_secret_key' => Input::get('inputLiveSecretKey'), 'live_publishable_key' => Input::get('inputLivePublishableKey'), 'test_mode_status' => $isStripeTestModeEnable,  'description' => Input::get('inputStripeDescription')));
        }
      }
      elseif (Input::get('_payment_method_type') == '2checkout') {
        $is2CheckouteEnable            =  'no';
        $is2CheckoutSandboxModeEnable  =  'no';
        $enable_2checkout      =  (Input::has('inputEnablePayment2CheckoutMethod')) ? true : false;
        $enable_sandbox_mode   =  (Input::has('input2CheckoutSandboxStatus')) ? true : false;
        
        if($enable_2checkout){
          $is2CheckouteEnable = 'yes';
        }
        else{
          $is2CheckouteEnable = 'no';
        }
        
        if($enable_sandbox_mode){
          $is2CheckoutSandboxModeEnable = 'yes';
        }
        else{
          $is2CheckoutSandboxModeEnable = 'no';
        }
       
        if(is_vendor_login() && !empty($vendor_data)){
          $vendor_data->payment_method->twocheckout->status                =  $is2CheckouteEnable;
          $vendor_data->payment_method->twocheckout->title                 =  Input::get('input2CheckoutTitle');
          $vendor_data->payment_method->twocheckout->card_number           =  Input::get('input2CheckoutCardNumber');
          $vendor_data->payment_method->twocheckout->cvc                   =  Input::get('input2CheckoutCardCVC'); 
          $vendor_data->payment_method->twocheckout->expiration_month      =  Input::get('input2CheckoutCardExpirationMonth');
          $vendor_data->payment_method->twocheckout->expiration_year       =  Input::get('input2CheckoutCardExpirationYear');  
          $vendor_data->payment_method->twocheckout->description           =  Input::get('input2CheckoutDescription');
          
          
          $update_data = array(
                        'details' => json_encode($vendor_data)
          );

          if(UsersDetail::where('user_id', Session::get('shopist_admin_user_id'))->update( $update_data )){
            Session::flash('success-message', Lang::get('admin.successfully_updated_msg'));
            return redirect()->back();
          }
        }
        else{
          $get_return_payment_data = $this->create_payment_array_data('2checkout', array('status' => $is2CheckouteEnable, 'title' => Input::get('input2CheckoutTitle'), 'sellerId' => Input::get('input2CheckoutSellerId'), 'publishableKey' => Input::get('input2CheckoutPublishableKey'), 'privateKey' => Input::get('input2CheckoutPrivateKey'), 'sandbox_enable_option' => $is2CheckoutSandboxModeEnable,  'description' => Input::get('input2CheckoutDescription')));
        }
      }
      
      $data = array(
                    'option_value'        => serialize($get_return_payment_data)
      );
      
      if( Option::where('option_name', '_payment_method_data')->update($data)){
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
   * Payment data process for save
   *
   * @param array
   * @return array
   */
  public function create_payment_array_data($source, $array){
    $enable_payment_option         =   '';
    $enable_bacs                   =   '';
    $bacs_method_title             =   '';
    $bacs_method_desc              =   '';
    $bacs_method_ins               =   '';
    $bacs_account_name             =   '';
    $bacs_account_number           =   '';
    $bacs_bank_name                =   '';
    $bacs_short_code               =   '';
    $bacs_iban                     =   '';
    $bacs_swift                    =   '';
    $enable_cod                    =   ''; 
    $cod_method_title              =   '';
    $cod_method_desc               =   '';
    $cod_method_ins                =   '';
    $enable_paypal                 =   '';
    $paypal_method_title           =   '';
    $paypal_client_id              =   '';
    $paypal_secret                 =   '';
    $enable_paypal_sandbox         =   '';
    $paypal_method_desc            =   '';
    $enable_stripe                 =   '';
    $stripe_method_title           =   '';
    $test_secret_key               =   '';
    $test_publishable_key          =   '';
    $live_secret_key               =   '';
    $live_publishable_key          =   '';
    $enable_stripe_test_mode       =   '';
    $stripe_method_desc            =   '';
    $twocheckout_enable            =   '';
    $twocheckout_title             =   '';
    $twocheckout_sellerId          =   '';
    $twocheckout_publishable_key   =   '';
    $twocheckout_private_key       =   '';
    $twocheckout_sandbox_status    =   '';
    $twocheckout_description       =   '';
    
    
    
    $unserialize_data = $this->option->getPaymentMethodData();
    
    if($source == 'payment_option'){
      $enable_payment_option         =   $array['status'];
    }
    else {
      $enable_payment_option         =   $unserialize_data['payment_option']['enable_payment_method'];
    }
    
    if($source == 'bacs'){
      $enable_bacs                   =   $array['status'];
      $bacs_method_title             =   $array['title'];
      $bacs_method_desc              =   $array['description'];
      $bacs_method_ins               =   $array['instructions'];
      $bacs_account_name             =   $array['account_details']['account_name'];
      $bacs_account_number           =   $array['account_details']['account_number'];
      $bacs_bank_name                =   $array['account_details']['bank_name'];
      $bacs_short_code               =   $array['account_details']['short_code'];
      $bacs_iban                     =   $array['account_details']['iban'];
      $bacs_swift                    =   $array['account_details']['swift'];
    }
    else{
      $enable_bacs                   =   $unserialize_data['bacs']['enable_option'];
      $bacs_method_title             =   $unserialize_data['bacs']['method_title'];
      $bacs_method_desc              =   $unserialize_data['bacs']['method_description'];
      $bacs_method_ins               =   $unserialize_data['bacs']['method_instructions'];
      $bacs_account_name             =   $unserialize_data['bacs']['account_details']['account_name'];
      $bacs_account_number           =   $unserialize_data['bacs']['account_details']['account_number'];
      $bacs_bank_name                =   $unserialize_data['bacs']['account_details']['bank_name'];
      $bacs_short_code               =   $unserialize_data['bacs']['account_details']['short_code'];
      $bacs_iban                     =   $unserialize_data['bacs']['account_details']['iban'];
      $bacs_swift                    =   $unserialize_data['bacs']['account_details']['swift'];
    }
    
    if($source == 'cod'){
      $enable_cod                   =   $array['status'];
      $cod_method_title             =   $array['title'];
      $cod_method_desc              =   $array['description'];
      $cod_method_ins               =   $array['instructions'];
    }
    else{
      $enable_cod                   =   $unserialize_data['cod']['enable_option'];
      $cod_method_title             =   $unserialize_data['cod']['method_title'];
      $cod_method_desc              =   $unserialize_data['cod']['method_description'];
      $cod_method_ins               =   $unserialize_data['cod']['method_instructions'];
    }

    if($source == 'paypal'){
      $enable_paypal                =   $array['status'];
      $paypal_method_title          =   $array['title'];
      $paypal_client_id             =   $array['client_id'];
      $paypal_secret                =   $array['secret'];
      $enable_paypal_sandbox        =   $array['sandbox_status'];
      $paypal_method_desc           =   $array['description'];
    }
    else{
      $enable_paypal                =   $unserialize_data['paypal']['enable_option'];
      $paypal_method_title          =   $unserialize_data['paypal']['method_title'];
      $paypal_client_id             =   $unserialize_data['paypal']['paypal_client_id'];
      $paypal_secret                =   $unserialize_data['paypal']['paypal_secret'];
      $enable_paypal_sandbox        =   $unserialize_data['paypal']['paypal_sandbox_enable_option'];
      $paypal_method_desc           =   $unserialize_data['paypal']['method_description'];
    }
    
    if($source == 'stripe'){
      $enable_stripe                =   $array['status'];
      $stripe_method_title          =   $array['title'];
      $test_secret_key              =   $array['test_secret_key'];
      $test_publishable_key         =   $array['test_publishable_key'];
      $live_secret_key              =   $array['live_secret_key'];
      $live_publishable_key         =   $array['live_publishable_key'];
      $enable_stripe_test_mode      =   $array['test_mode_status'];
      $stripe_method_desc           =   $array['description'];
    }
    else{
      $enable_stripe                =   $unserialize_data['stripe']['enable_option'];
      $stripe_method_title          =   $unserialize_data['stripe']['method_title'];
      $test_secret_key              =   $unserialize_data['stripe']['test_secret_key'];
      $test_publishable_key         =   $unserialize_data['stripe']['test_publishable_key'];
      $live_secret_key              =   $unserialize_data['stripe']['live_secret_key'];
      $live_publishable_key         =   $unserialize_data['stripe']['live_publishable_key'];
      $enable_stripe_test_mode      =   $unserialize_data['stripe']['stripe_test_enable_option'];
      $stripe_method_desc           =   $unserialize_data['stripe']['method_description'];
    }
    
    if($source == '2checkout'){
      $twocheckout_enable           =   $array['status'];
      $twocheckout_title            =   $array['title'];
      $twocheckout_sellerId         =   $array['sellerId'];
      $twocheckout_publishable_key  =   $array['publishableKey'];
      $twocheckout_private_key      =   $array['privateKey'];
      $twocheckout_sandbox_status   =   $array['sandbox_enable_option'];
      $twocheckout_description      =   $array['description'];
    }
    else{
      $twocheckout_enable           =   $unserialize_data['2checkout']['enable_option'];
      $twocheckout_title            =   $unserialize_data['2checkout']['method_title'];
      $twocheckout_sellerId         =   $unserialize_data['2checkout']['sellerId'];
      $twocheckout_publishable_key  =   $unserialize_data['2checkout']['publishableKey'];
      $twocheckout_private_key      =   $unserialize_data['2checkout']['privateKey'];
      $twocheckout_sandbox_status   =   $unserialize_data['2checkout']['sandbox_enable_option'];
      $twocheckout_description      =   $unserialize_data['2checkout']['method_description'];
    }

    
    
    $payment_method_array = array( 
      'payment_option'   => array('enable_payment_method' => $enable_payment_option),
      'bacs'             => array('enable_option' => $enable_bacs, 'method_title' => $bacs_method_title, 'method_description' => $bacs_method_desc, 'method_instructions' => $bacs_method_ins, 'account_details' => array('account_name' => $bacs_account_name, 'account_number' => $bacs_account_number, 'bank_name' => $bacs_bank_name, 'short_code' => $bacs_short_code, 'iban' => $bacs_iban, 'swift' => $bacs_swift) ),
      'cod'              => array('enable_option' => $enable_cod, 'method_title' => $cod_method_title, 'method_description' => $cod_method_desc, 'method_instructions' => $cod_method_ins),
      'paypal'           => array('enable_option' => $enable_paypal, 'method_title' => $paypal_method_title, 'paypal_client_id' => $paypal_client_id, 'paypal_secret' => $paypal_secret, 'paypal_sandbox_enable_option' => $enable_paypal_sandbox, 'method_description' => $paypal_method_desc),
      'stripe'           => array('enable_option' => $enable_stripe, 'method_title' => $stripe_method_title, 'test_secret_key' => $test_secret_key, 'test_publishable_key' => $test_publishable_key, 'live_secret_key' => $live_secret_key, 'live_publishable_key' => $live_publishable_key, 'stripe_test_enable_option' => $enable_stripe_test_mode, 'method_description' => $stripe_method_desc),
      '2checkout'        => array('enable_option' => $twocheckout_enable, 'method_title' => $twocheckout_title, 'sellerId' => $twocheckout_sellerId, 'publishableKey' => $twocheckout_publishable_key, 'privateKey' => $twocheckout_private_key, 'sandbox_enable_option' => $twocheckout_sandbox_status, 'method_description' => $twocheckout_description)
    );
    
    return $payment_method_array;
  }
}