<?php
namespace shopist\Library;

use Illuminate\Support\Facades\DB;
use shopist\Models\Post;
use shopist\Models\PostExtra;
use shopist\Models\CategoriesList;
use shopist\Models\UsersCustomDesign;
use shopist\Models\User;
use shopist\Models\OrdersItem;
use Session;
use Anam\Phpcart\Cart;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Lang;
use shopist\Models\UsersDetail;
use shopist\Models\ManageLanguage;
use shopist\Models\RoleUser;
use shopist\Models\VendorWithdraw;
use shopist\Models\VendorPackage;
use shopist\Models\VendorOrder;
use Cookie;
use Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use shopist\Http\Controllers\OptionController; 
use shopist\Http\Controllers\CMSController;
use shopist\Http\Controllers\Admin\UserController;
use shopist\Http\Controllers\ProductsController;
use shopist\Library\CommonFunction;
use shopist\Models\Term;
use shopist\Mail\ShopistMail;
use shopist\Models\ProductExtra;
use shopist\Models\Product;

class GetFunction
{
  public $str = '';
  public $products_details;
  public $cart;
  public $shipping = array();
  public $payment  = array();
  public $current_product_id = 0;
  public $carbonObject;
  public $settingsData = array();
  public $seoData = array();
  public $subscriptionData = array();
  public $subscriptionSettingsData = array();
  
  public $CMS;
  public $user;
  public $option;
  public $product;
  public $classCommonFunction;


  public function __construct() 
  {
    $this->carbonObject =  new Carbon();

    $this->CMS      =  new CMSController();
    $this->user     =  new UserController();
    $this->product   =  new ProductsController();
    $this->classCommonFunction  =   new CommonFunction();
    $this->cart     =  new Cart();
    
    if(\Schema::hasTable('options')){
      $this->option   =  new OptionController();
      $this->shipping   = $this->option->getShippingMethodData();
      $this->payment    =  $this->option->getPaymentMethodData();
      $this->settingsData =   $this->option->getSettingsData();
      $this->subscriptionData =   $this->option->getSubscriptionData();
      $this->subscriptionSettingsData =   $this->option->getSubscriptionSettingsData();
    }
  }
  
  /**
   * Get function for reports
   *
   * @param Start date, End date
   * @return obj
   */
  public function get_orders_by_date_range($start_date, $end_date)
  {
    if(is_vendor_login() && Session::has('shopist_admin_user_id')){
      $getOrdersByDate  =  DB::table('posts')
                           ->where(['posts.post_type' => 'shop_order', 'vendor_orders.vendor_id' => Session::get('shopist_admin_user_id')]) 
                           ->whereBetween('posts.created_at', array($start_date, $end_date.' 23:59:59'))
                           ->join('vendor_orders', 'posts.id', '=', 'vendor_orders.order_id')
                           ->select('posts.*')
                           ->orderBy('posts.created_at', 'DESC')
                           ->get();
    }
    else{
      $getOrdersByDate  =  Post::whereBetween('created_at', array($start_date, $end_date.' 23:59:59'))->where('post_type', 'shop_order')->orderBy('created_at', 'DESC')->get();
    }
    
    return  $getOrdersByDate;
  }
  
  /**
   * Get function for reports
   *
   * @param null
   * @return obj
   */
  public function get_orders_by_year()
  {
    if(is_vendor_login() && Session::has('shopist_admin_user_id')){
      $getOrdersByYear  =  DB::table('posts')
                           ->where(['posts.post_type' => 'shop_order', 'vendor_orders.vendor_id' => Session::get('shopist_admin_user_id')]) 
                           ->whereBetween('posts.created_at', [ $this->carbonObject->today()->startOfYear(), $this->carbonObject->today()->endOfYear() ])
                           ->join('vendor_orders', 'posts.id', '=', 'vendor_orders.order_id')
                           ->select('posts.*')
                           ->orderBy('posts.created_at', 'DESC')
                           ->get();
    }
    else{
      $getOrdersByYear  =  Post::whereBetween('created_at', [ $this->carbonObject->today()->startOfYear(), $this->carbonObject->today()->endOfYear() ])->where('post_type', 'shop_order')->orderBy('created_at', 'DESC')->get();
    }
    
    return  $getOrdersByYear;
  }
  
  /**
   * Get function for reports
   *
   * @param Orders data 
   * @return array
   */
  public function get_reports_gross_products_title_data( $productsTitleOrders )      
  {
    $sale_by_product_title = array();
    
    if(!empty($productsTitleOrders)){
      foreach($productsTitleOrders as $row){
        if(!empty($row)){
          $get_order_data_by_id = OrdersItem::where(['order_id' => $row->id])->first();
          $parse_order_data     = json_decode($get_order_data_by_id->order_data);

          foreach($parse_order_data as $count_row){
            if(!empty($count_row)){
              if(!array_key_exists(string_slug_format($count_row->name), $sale_by_product_title) || array_key_exists(string_slug_format($count_row->name), $sale_by_product_title) && !in_array($count_row->name, $sale_by_product_title[string_slug_format($count_row->name)])){
                $sale_by_product_title[string_slug_format($count_row->name)] = array('id' => $count_row->id, 'product_title' => $count_row->name, 'units_sold' => $count_row->quantity, 'gross_sales' => $count_row->quantity * $count_row->price, 'currency' => get_currency_symbol_by_code(PostExtra::where(['post_id' => $row->id, 'key_name' => '_order_currency'])->first()->key_value), 'gross_sales_with_currency' => price_html( $count_row->quantity * $count_row->price ));
              }
              elseif (array_key_exists(string_slug_format($count_row->name), $sale_by_product_title) && in_array($count_row->name, $sale_by_product_title[string_slug_format($count_row->name)])) {
                $sale_by_product_title[string_slug_format($count_row->name)]['units_sold']  +=  $count_row->quantity;
                $sale_by_product_title[string_slug_format($count_row->name)]['gross_sales'] +=  $count_row->quantity * $count_row->price;
                $sale_by_product_title[string_slug_format($count_row->name)]['gross_sales_with_currency'] =  price_html( $sale_by_product_title[string_slug_format($count_row->name)]['gross_sales'] );
              }
            }
          }
        }
      }
    }
   
    return $sale_by_product_title;
  }
  
  /**
   * Get function for reports
   *
   * @param Date range
   * @return array
   */
  public function get_order_by_specific_date_range($daysOrders)
  {
    $daysOrdersData = array();
    foreach($daysOrders as $rows)
    {
      $order_data = array();
      $order_data['order_id']       = $rows->id;
      $order_data['order_date']     = $this->carbonObject->parse($rows->created_at)->toDayDateTimeString();
      $order_data['order_status']   = PostExtra::where(['post_id' => $rows->id, 'key_name' => '_order_status'])->first()->key_value;
      $order_data['order_totals']   = PostExtra::where(['post_id' => $rows->id, 'key_name' => '_order_total'])->first()->key_value;
      $order_data['order_totals_with_currency']   = price_html( PostExtra::where(['post_id' => $rows->id, 'key_name' => '_order_total'])->first()->key_value );

      array_push($daysOrdersData, $order_data);
    }
    
    return $daysOrdersData;
  }
  
  /**
   * Get function for reports
   *
   * @param Orders data
   * @return array
   */
  public function get_report_data_order_details($data)
  {
    $new_ary = array();
    foreach($data as $row)
    {
      $index = $this->carbonObject->parse($row['order_date'])->year.'-'.$this->carbonObject->parse($row['order_date'])->month.'-'.$this->carbonObject->parse($row['order_date'])->day;
      
      if(!array_key_exists($index, $new_ary))
      {
        $new_ary[$index] = array('day' => $this->carbonObject->parse($row['order_date'])->format('d M'), 'gross_sales' => $row['order_totals']);
      }
      elseif(array_key_exists($index, $new_ary))
      {
        $new_ary[$index]['gross_sales'] +=  $row['order_totals'];
      }
    }
    return $new_ary;
  }
  
  /**
   * Get function for reports
   *
   * @param Orders data by month
   * @return array
   */
  public function get_report_data_order_details_by_month($data)
  {
    $new_ary = array();
    $month_name    =   array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December');
    
    for($i = 1; $i<= $this->carbonObject->today()->month; $i ++)
    {
      $index = $this->carbonObject->today()->year.'-'.$i;
      $new_ary[$index] = array('month' => $month_name[$i].', '.$this->carbonObject->today()->year, 'gross_sales' => 0);
    }
     
    foreach($data as $row)
    {
      $index = $this->carbonObject->parse($row['order_date'])->year.'-'.$this->carbonObject->parse($row['order_date'])->month;
      
      if(array_key_exists($index, $new_ary))
      {
        $new_ary[$index]['gross_sales'] +=  $row['order_totals'];
      }
    }
    return $new_ary;
  }
  
  /**
   * Get function for reports
   *
   * @param Orders data
   * @return array
   */
  public function get_reports_payment_method_data($data)
  {
    $new_ary = array();
    $method  = array('bacs' => Lang::get('admin.direct_bank_transfer'), 'cod' => Lang::get('admin.cash_on_delivery'), 'paypal' => Lang::get('admin.paypal'), 'stripe' => Lang::get('admin.stripe'), '2checkout' => Lang::get('admin.two_checkout'));
    
    foreach($method as $key => $val){
      $index = $key;
      $new_ary[$index] = array('method' => $method[$index], 'gross_sales' => 0, 'gross_sales_with_currency' => price_html( 0 ));
    }
    
    foreach($data as $rows){
      $index = PostExtra::where(['post_id' => $rows->id, 'key_name' => '_payment_method'])->first()->key_value;
      $order_total = PostExtra::where(['post_id' => $rows->id, 'key_name' => '_order_total'])->first()->key_value;
      
      if(array_key_exists($index, $new_ary)){
        $new_ary[$index]['gross_sales'] +=  $order_total;
        $new_ary[$index]['gross_sales_with_currency'] = price_html( $new_ary[$index]['gross_sales'] );
      }
    }
    
    return $new_ary;
  }
  
  /**
   * Get function for paypal config
   *
   * @param null
   * @return array
   */
  public function getPaypalConfig()
  {
    $mode = 'sandbox';
    if($this->payment['paypal']['paypal_sandbox_enable_option'] == 'no')
    {
      $mode = 'live';
    }
    
    return array('client_id' => $this->payment['paypal']['paypal_client_id'], 'secret' => $this->payment['paypal']['paypal_secret'], 'settings' => array('mode' => $mode, 'http.ConnectionTimeOut' => 30, 'log.LogEnabled' => true, 'log.FileName' => storage_path() . '/logs/paypal.log', 'log.LogLevel' => 'FINE'));
  }
  
  /**
   * Multiple mail send
   *
   * @param Mail array data
   * @return void
   */
  public function sendCustomMail($data)
  {
    $view          =  '';
    $get_view_data =  array();
    $site_title    =  'Shopist';
    $email         =  'yourEmail@domain.com';
    $logo          =  default_placeholder_img_src();
    $appearance    =  array();
    
    $email_options = get_emails_option_data();
      
    if(isset($this->settingsData['general_settings']['general_options']['site_title']) && $this->settingsData['general_settings']['general_options']['site_title']){
      $site_title = $this->settingsData['general_settings']['general_options']['site_title'];
    }

    if(isset($this->settingsData['general_settings']['general_options']['email_address']) && $this->settingsData['general_settings']['general_options']['email_address']){
      $email = $this->settingsData['general_settings']['general_options']['email_address'];
    }
    
    if(isset($this->settingsData['general_settings']['general_options']['site_logo']) && $this->settingsData['general_settings']['general_options']['site_logo']){
      $logo = $this->settingsData['general_settings']['general_options']['site_logo'];
    }
    
    $get_appearance = get_appearance_settings();
    
    if(isset($get_appearance['footer_details']['follow_us_url'])){
      $appearance = $get_appearance['footer_details']['follow_us_url'];
    }
    
    if(isset($data['data']['order_id']) || isset($data['order_id'])){
      $order_id = 0;
      if(isset($data['data']['order_id'])){
        $order_id = $data['data']['order_id'];
      }
      elseif(isset($data['order_id'])){
        $order_id = $data['order_id'];
      }
      
      $get_view_data = get_customer_order_billing_shipping_info( $order_id );
    }
    
    $get_view_data['_from_email'] = $email;
    $get_view_data['_site_title'] = $site_title;
    
    if($data['source'] == 'order_confirmation'){ 
      $view =   'emails.order-confirmation.'.$email_options['new_order']['selected_template'].'.'.$email_options['new_order']['selected_template'];
      $get_view_data['_view'] = $view;
      
      $get_post_meta    =   PostExtra :: where('post_id', $data['data']['order_id'])->get();
      $get_order_data   =   OrdersItem :: where('order_id', $data['data']['order_id'])->first();
      
      if($get_post_meta && $get_post_meta->count() > 0){
        $get_view_data['_order_id'] =  $data['data']['order_id'];
        
        foreach($get_post_meta as $rows){
          if($rows->key_name == '_order_currency' || $rows->key_name == '_customer_ip_address' || $rows->key_name == '_customer_user_agent' || $rows->key_name == '_customer_user' || $rows->key_name == '_order_shipping_cost' || $rows->key_name == '_order_shipping_method' || $rows->key_name == '_payment_method' || $rows->key_name == '_payment_method_title' || $rows->key_name == '_order_tax' || $rows->key_name == '_order_total' || $rows->key_name == '_order_notes' || $rows->key_name == '_order_status'){
            $get_view_data[$rows->key_name] = $rows->key_value;
          }
        }
        
        if(isset($get_view_data['_billing_email'])){
          $get_view_data['_mail_to'] = $get_view_data['_billing_email'];
        }
        
        $get_view_data['_payment_method_details'] =  $this->payment[$get_view_data['_payment_method']];
        $get_view_data['_order_items'] = json_decode($get_order_data->order_data);
      }
      
      $get_view_data['_subject']    = str_replace('#date_place#', $this->carbonObject->parse( $this->carbonObject->today() )->format('F d, Y'), $email_options['new_order']['subject']);
      
      $get_view_data['_logo'] = $logo;
      $get_view_data['_appearance'] = $appearance;
      $get_view_data['_order_date'] = $this->carbonObject->parse( $this->carbonObject->today() )->format('F d, Y');
    }
    
    elseif($data['source'] == 'quick_mail'){
      $view                      =   'emails.quick-mail';
      $get_view_data['_view']     =   $view;
      $get_view_data['_mail_to'] =   $data['data']['_mail_to'];
      $get_view_data['_subject'] =   $data['data']['_subject'];
      $get_view_data['_message'] =   $data['data']['_message'];
    }
    elseif($data['source'] == 'contact_to_vendor_mail'){
      $view                         =   'emails.contact-with-vendor-mail';
      $get_view_data['_view']        =   $view;  
      $get_view_data['_mail_to']    =   $data['data']['_mail_to'];
      $get_view_data['_subject']    =   $data['data']['_subject'];
      $get_view_data['_message']    =   $data['data']['_message'];
      $get_view_data['_from_email'] =   $data['data']['_mail_from'];
    }
    elseif($data['source'] == 'cancelled_order'){
      $view =   'emails.cancelled-order';
      $get_view_data['_view']     =   $view;
      $get_post_meta    =   PostExtra :: where('post_id', $data['order_id'])->get();
      $get_order_data   =   OrdersItem :: where('order_id', $data['order_id'])->first();
      
      if($get_post_meta && $get_post_meta->count() > 0){
        foreach($get_post_meta as $rows){
          if($rows->key_name == '_order_currency' || $rows->key_name == '_customer_ip_address' || $rows->key_name == '_customer_user_agent' || $rows->key_name == '_customer_user' || $rows->key_name == '_order_shipping_cost' || $rows->key_name == '_order_shipping_method' || $rows->key_name == '_payment_method' || $rows->key_name == '_payment_method_title' || $rows->key_name == '_order_tax' || $rows->key_name == '_order_total' || $rows->key_name == '_order_notes' || $rows->key_name == '_order_status'){
            $get_view_data[$rows->key_name] = $rows->key_value;
          }
        }
      }
      
      $get_view_data['_mail_to']    =   $data['email'];
      $get_view_data['_order_id']   =   $data['order_id'];
      $get_view_data['_order_date'] =   $this->carbonObject->parse( $this->carbonObject->today() )->format('F d, Y');
      $get_view_data['_subject']    =   $email_options['cancelled_order']['subject'];
      $get_view_data['_payment_method_details'] =  $this->payment[$get_view_data['_payment_method']];
      $get_view_data['_order_items'] = json_decode($get_order_data->order_data);
    }
    elseif($data['source'] == 'processed_order'){
      $view             =   'emails.processed-order';
      $get_view_data['_view']     =   $view;
      $get_post_meta    =   PostExtra :: where('post_id', $data['order_id'])->get();
      $get_order_data   =   OrdersItem :: where('order_id', $data['order_id'])->first();
      
      if($get_post_meta && $get_post_meta->count() > 0){
        foreach($get_post_meta as $rows){
          if($rows->key_name == '_order_currency' || $rows->key_name == '_customer_ip_address' || $rows->key_name == '_customer_user_agent' || $rows->key_name == '_customer_user' || $rows->key_name == '_order_shipping_cost' || $rows->key_name == '_order_shipping_method' || $rows->key_name == '_payment_method' || $rows->key_name == '_payment_method_title' || $rows->key_name == '_order_tax' || $rows->key_name == '_order_total' || $rows->key_name == '_order_notes' || $rows->key_name == '_order_status'){
            $get_view_data[$rows->key_name] = $rows->key_value;
          }
        }
      }  
      
      $get_view_data['_mail_to']    =   $data['email'];
      $get_view_data['_order_id']   =   $data['order_id'];
      $get_view_data['_order_date'] =   $this->carbonObject->parse( $this->carbonObject->today() )->format('F d, Y');
      $get_view_data['_subject']    =   str_replace('#order_id#', '#'.$data['order_id'], $email_options['processed_order']['subject']);
      $get_view_data['_payment_method_details'] =  $this->payment[$get_view_data['_payment_method']];
      $get_view_data['_order_items'] = json_decode($get_order_data->order_data);
    }
    elseif($data['source'] == 'completed_order'){
      $view                         =   'emails.completed-order';
      $get_view_data['_view']     =   $view;
      $get_post_meta    =   PostExtra :: where('post_id', $data['order_id'])->get();
      $get_order_data   =   OrdersItem :: where('order_id', $data['order_id'])->first();
      
      if($get_post_meta && $get_post_meta->count() > 0){
        foreach($get_post_meta as $rows){
          if($rows->key_name == '_order_currency' || $rows->key_name == '_customer_ip_address' || $rows->key_name == '_customer_user_agent' || $rows->key_name == '_customer_user' || $rows->key_name == '_order_shipping_cost' || $rows->key_name == '_order_shipping_method' || $rows->key_name == '_payment_method' || $rows->key_name == '_payment_method_title' || $rows->key_name == '_order_tax' || $rows->key_name == '_order_total' || $rows->key_name == '_order_notes' || $rows->key_name == '_order_status'){
            $get_view_data[$rows->key_name] = $rows->key_value;
          }
        }
      }  
      
      $get_view_data['_mail_to']    =   $data['email'];
      $get_view_data['_order_id']   =   $data['order_id'];
      $get_view_data['_order_date'] =   $this->carbonObject->parse( $this->carbonObject->today() )->format('F d, Y');
      $get_view_data['_subject']    =   str_replace('#order_id#', '#'.$data['order_id'], $email_options['completed_order']['subject']);
      $get_view_data['_payment_method_details'] =  $this->payment[$get_view_data['_payment_method']];
      $get_view_data['_order_items'] = json_decode($get_order_data->order_data);
    }
    elseif($data['source'] == 'new_customer_account'){
      $view                         =   'emails.new-customer-account';
      $get_view_data['_view']        =   $view;
      $get_view_data['_mail_to']    =   $data['email'];
      $get_view_data['_subject']    =   $email_options['new_customer_account']['subject'];
    }
    elseif($data['source'] == 'vendor_new_account'){
      $view                         =   'emails.vendor-new-account';
      $get_view_data['_view']        =   $view;
      $get_view_data['_mail_to']    =   $data['email'];
      $get_view_data['_subject']    =   $email_options['vendor_new_account']['subject'];
    }
    elseif($data['source'] == 'vendor_account_activation'){
      $view                         =   'emails.vendor-account-status';
      $get_view_data['_view']        =   $view;
      $get_view_data['_mail_to']    =   $data['email'];
      $get_view_data['_subject']    =   $email_options['vendor_account_activation']['subject'];
      $get_view_data['_status']     =   $data['status'];
    }
    elseif($data['source'] == 'withdraw_request'){
      $view                         =   'emails.vendor-withdraw-request';
      $get_view_data['_view']        =   $view;  
      $get_view_data['_mail_to']    =   $data['email'];
      $get_view_data['_subject']    =   $email_options['vendor_withdraw_request']['subject'];
      $get_view_data['_target']     =   $data['target'];
      $get_view_data['_value']      =   $data['value'];
      $get_view_data['_payment_method']  =   $data['payment_method'];
    }
    elseif($data['source'] == 'vendor_withdraw_request_cancelled'){
      $view                         =   'emails.vendor-withdraw-request-cancelled';
      $get_view_data['_view']        =   $view;
      $get_view_data['_mail_to']    =   $data['email'];
      $get_view_data['_subject']    =   $email_options['vendor_withdraw_request_cancelled']['subject'];
    }
    elseif($data['source'] == 'vendor_withdraw_request_completed'){
      $view                         =   'emails.vendor-withdraw-request-completed';
      $get_view_data['_view']        =   $view;
      $get_view_data['_mail_to']    =   $data['email'];
      $get_view_data['_subject']    =   $email_options['vendor_withdraw_request_completed']['subject'];
    }
      
    if(count($get_view_data) > 0){
       Mail::to($get_view_data['_mail_to'])
             ->send(new ShopistMail( $get_view_data ));
    }
  }
  
  
  /**
   * remove directory function
   *
   * @param path
   * @return boolean
   */  
  public function removeDirectory($path) 
  {
    $files = glob($path . '/*');
    foreach ($files as $file) {
      is_dir($file) ? removeDirectory($file) : unlink($file);
    }
    rmdir($path);
    return;
  }
  
  /**
   * Get comments list
   *
   * @param target name
   * @return array
   */
  
  public function get_comments_list($target){
    $comments_data = array();
    
    if(!empty($target)){
      $get_comments = DB::table('comments')->where(['comments.target' => $target])
                    ->join('posts', 'comments.object_id', '=', 'posts.id')
                    ->join('users', 'comments.user_id', '=', 'users.id')
                    ->select('comments.*', 'posts.post_title', 'posts.post_slug', 'users.display_name', 'users.user_photo_url')        
                    ->get()
                    ->toArray();
      
      if(count($get_comments) > 0){
        $comments_data = $get_comments;
      }
    }
    
    return $comments_data;
  }
  
  /**
   * Get coupon list
   *
   * @param null
   * @return array
   */
  public function get_coupon_all_data(){
    $coupon_data = array();
    $get_coupon_data = Post::where(['post_type' => 'user_coupon'])->get()->toArray();
    
    if(count($get_coupon_data) > 0){
      foreach($get_coupon_data as $row){
        if(isset($row['id'])){
           array_push($coupon_data, $this->get_coupon_post_meta( $row['id'], $row ));
        }
      }
    }
    
    return $coupon_data;
  }
  
  
  /**
   * Get coupon post meta
   *
   * @param post_id, array
   * @return array
   */
  public function get_coupon_post_meta( $post_id, $data ){
    $arr = $data;
    $get_coupon_postmeta   = PostExtra::where(['post_id' => $post_id])->get()->toArray();
    
    if(count($get_coupon_postmeta) >0 && count($arr) > 0){
      foreach($get_coupon_postmeta as $key => $val){
        if( isset($val['key_name']) && $val['key_name'] == '_coupon_condition_type'){
          $arr['coupon_condition_type'] = $val['key_value'];
        }
        elseif( isset($val['key_name']) && $val['key_name'] == '_coupon_amount'){
          $arr['coupon_amount'] = $val['key_value'];
        }
        elseif( isset($val['key_name']) && $val['key_name'] == '_coupon_shipping_allow_option'){
          $arr['coupon_shipping_allow_option'] = $val['key_value'];
        }
        elseif( isset($val['key_name']) && $val['key_name'] == '_coupon_min_restriction_amount'){
          $arr['coupon_min_restriction_amount'] = $val['key_value'];
        }
        elseif( isset($val['key_name']) && $val['key_name'] == '_coupon_max_restriction_amount'){
          $arr['coupon_max_restriction_amount'] = $val['key_value'];
        }
        elseif( isset($val['key_name']) && $val['key_name'] == '_usage_limit_per_coupon'){
          $arr['usage_limit_per_coupon'] = $val['key_value'];
        }
        elseif( isset($val['key_name']) && $val['key_name'] == '_coupon_allow_role_name'){
          $arr['coupon_allow_role_name'] = get_role_name_by_role_slug($val['key_value']);
        }
        elseif( isset($val['key_name']) && $val['key_name'] == '_usage_range_start_date'){
          $arr['usage_range_start_date'] = $val['key_value'];
        }
        elseif( isset($val['key_name']) && $val['key_name'] == '_usage_range_end_date'){
          $arr['usage_range_end_date'] = $val['key_value'];
        }
      }
    }
    
    return $arr;
  }
  
  /**
   * Store subscribers data in mailchimp 
   *
   * @param api_key, list_id, extra data array
   * @return json
   */
  
  public function store_mailchimp_subscriber_data($api_key, $list_Id, $data){
    $apiKey = $api_key;
    $listId = $list_Id;

    $memberId = md5(strtolower($data['email']));
    $dataCenter = substr($apiKey, strpos($apiKey,'-')+1);
    $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/' . $listId . '/members/' . $memberId;

    $json = json_encode([
        'email_address' => $data['email'],
        'status'        => $data['status'],
        'merge_fields'  => [
            'FNAME'     => $data['firstname'],
            'LNAME'     => $data['lastname']
        ]
    ]);

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);                                                                                                                 
    $response = curl_exec($ch);
    $result = json_decode($response, true);
    curl_close($ch);
    
    return $result;
  }
  
  /**
   * Get coupon data by filter
   *
   * @param coupon code
   * @return respnse
   */
  public function get_coupon_response($coupon_code){
    $coupon_update_data = array();
    
    $get_coupon_data_by_id = Post::where(['post_title' => $coupon_code , 'post_status' => 1, 'post_type' => 'user_coupon'])->first();
        
    if(!empty($get_coupon_data_by_id)){
        
      $get_coupon_postmeta   = PostExtra::where(['post_id' => $get_coupon_data_by_id->id])->get()->toArray();

      $coupon_update_data['post_id']          = $get_coupon_data_by_id->id;
      $coupon_update_data['post_author_id']   = $get_coupon_data_by_id->post_author_id;
      $coupon_update_data['post_content']     = $get_coupon_data_by_id->post_content;
      $coupon_update_data['post_title']       = $get_coupon_data_by_id->post_title;
      $coupon_update_data['post_slug']        = $get_coupon_data_by_id->post_slug;
      $coupon_update_data['parent_id']        = $get_coupon_data_by_id->parent_id;
      $coupon_update_data['post_status']      = $get_coupon_data_by_id->post_status;
      $coupon_update_data['post_type']        = $get_coupon_data_by_id->post_type;


      if(count($get_coupon_postmeta) >0){

        foreach($get_coupon_postmeta as $key => $val){
          if($val['key_name'] == '_coupon_condition_type'){
            $coupon_update_data['coupon_condition_type'] = $val['key_value'];
          }
          elseif($val['key_name'] == '_coupon_amount'){
            $coupon_update_data['coupon_amount'] = $val['key_value'];
          }
          elseif($val['key_name'] == '_coupon_shipping_allow_option'){
            $coupon_update_data['coupon_shipping_allow_option'] = $val['key_value'];
          }
          elseif($val['key_name'] == '_coupon_min_restriction_amount'){
            $coupon_update_data['coupon_min_restriction_amount'] = $val['key_value'];
          }
          elseif($val['key_name'] == '_coupon_max_restriction_amount'){
            $coupon_update_data['coupon_max_restriction_amount'] = $val['key_value'];
          }
          elseif($val['key_name'] == '_usage_limit_per_coupon'){
            $coupon_update_data['usage_limit_per_coupon'] = $val['key_value'];
          }
          elseif($val['key_name'] == '_coupon_allow_role_name'){
            $coupon_update_data['coupon_allow_role_name'] = $val['key_value'];
          }
          elseif($val['key_name'] == '_usage_range_start_date'){
            $coupon_update_data['usage_range_start_date'] = $val['key_value'];
          }
          elseif($val['key_name'] == '_usage_range_end_date'){
            $coupon_update_data['usage_range_end_date'] = $val['key_value'];
          }
        }
      }
    }
   
    return $coupon_update_data;
  }
  
  /**
   * Coupon validation and response 
   *
   * @param coupon code
   * @return respnse
   */
  public function manage_coupon($coupon_code, $action){
    $response_str = '';
    $coupon_response = $this->get_coupon_response( $coupon_code );
    
    if(count($coupon_response) > 0){
      
      //coupon condition check
      if($this->cart->is_coupon_applyed() && $action == 'new_add'){
        $response_str = 'coupon_already_apply';
        return $response_str;
      }
     
      if(!empty($coupon_response['coupon_min_restriction_amount']) || !empty($coupon_response['coupon_max_restriction_amount']) ){
        if($this->cart->getTotal() < $coupon_response['coupon_min_restriction_amount'] ){
          $response_str = 'less_from_min_amount';
          return $response_str;
        }
        elseif($this->cart->getTotal() > $coupon_response['coupon_max_restriction_amount'] ){
          $response_str = 'exceed_from_max_amount';
          return $response_str;
        }
      }
      
      if(!empty($coupon_response['coupon_allow_role_name']) && $coupon_response['coupon_allow_role_name'] != 'no_role'){
        if(!Session::has('shopist_frontend_user_id')){
          $response_str = 'no_login';
          return $response_str;
        }
        elseif(Session::has('shopist_frontend_user_id')){
          $get_login_user = get_current_frontend_user_info();
          
          if($get_login_user['user_role_slug'] != $coupon_response['coupon_allow_role_name']){
            $response_str = 'user_role_not_match';
            return $response_str;
          }
        }
      }
      
      $today = date("Y-m-d");
      if(!empty($coupon_response['usage_range_end_date']) && $today > $coupon_response['usage_range_end_date']){
        $response_str = 'coupon_expired';
        return $response_str;
      }
      
      //coupon condition apply
      if(!empty($coupon_response['coupon_condition_type']) && $coupon_response['coupon_condition_type'] == 'discount_from_product'){
        $coupon_set_response = $this->cart->calculationCoupon($coupon_response['coupon_amount'], 'discount_from_product', $coupon_code);
        if($coupon_set_response){
          $response_str = 'discount_from_product';
          return $response_str;
        }
        else{
          $response_str = 'exceed_from_cart_total';
          return $response_str;
        }
      }
      elseif(!empty($coupon_response['coupon_condition_type']) && $coupon_response['coupon_condition_type'] == 'percentage_discount_from_product'){
        $coupon_set_response = $this->cart->calculationCoupon($coupon_response['coupon_amount'], 'percentage_discount_from_product', $coupon_code);
        if($coupon_set_response){
          $response_str = 'percentage_discount_from_product';
          return $response_str;
        }
        else{
          $response_str = 'exceed_from_cart_total';
          return $response_str;
        }
      }
      elseif(!empty($coupon_response['coupon_condition_type']) && $coupon_response['coupon_condition_type'] == 'discount_from_total_cart'){
        $coupon_set_response = $this->cart->calculationCoupon($coupon_response['coupon_amount'], 'discount_from_total_cart', $coupon_code);
        if($coupon_set_response){
          $response_str = 'discount_from_total_cart';
          return $response_str;
        }
        else{
          $response_str = 'exceed_from_cart_total';
          return $response_str;
        }
      }
      elseif(!empty($coupon_response['coupon_condition_type']) && $coupon_response['coupon_condition_type'] == 'percentage_discount_from_total_cart'){
        $coupon_set_response = $this->cart->calculationCoupon($coupon_response['coupon_amount'], 'percentage_discount_from_total_cart', $coupon_code);
        if($coupon_set_response){
          $response_str = 'percentage_discount_from_total_cart';
          return $response_str;
        }
        else{
          $response_str = 'exceed_from_cart_total';
          return $response_str;
        }
      }
    }
    else{
      $response_str = 'no_coupon_data';
      return $response_str;
    }
  }
  
  
  //*****  Start helper get function ********
  public static function title($product_id){
    $title =  '';
    $get_product = Product :: where('id', $product_id)->first();
    
    if(!empty($get_product)){
      $title = $get_product->title;
    }
    
    return $title;
  }
  
  public static function product_slug($product_id){
    $slug = '';
    $get_product = Product :: where('id', $product_id)->first();
    
    if(!empty($get_product)){
      $slug = $get_product->slug;
    }
    
    return $slug;
  }
  
  public static function product_img($product_id){
    $image_url = '';
    $get_product  =  Product :: where('id', $product_id)->first();
    
    if(!empty($get_product)){
      $image_url = $get_product->image_url;
    }
    
    return $image_url;
  }
  
  public static function product_price($product_id){ 
    $final_price  =  0;
    $_this        =  new self;
    $get_product  =  Product :: where('id', $product_id)->first();
    
    if(!empty($get_product)){
      $final_price  = $get_product->price;
    }
    
    
    $get_current_user_data  =  get_current_frontend_user_info();
    
    if(is_frontend_user_logged_in() && isset($get_current_user_data['user_role_slug']) ){
      $get_role_based_pricing_data = get_role_based_pricing_by_product_id( $product_id );
      
      if(count($get_role_based_pricing_data) > 0 && $get_role_based_pricing_data['is_enable'] == 'yes'){
        if(isset($get_role_based_pricing_data['pricing'][$get_current_user_data['user_role_slug']])){
          $regular_price =  $get_role_based_pricing_data['pricing'][$get_current_user_data['user_role_slug']]['regular_price'];
          $sale_price    =  $get_role_based_pricing_data['pricing'][$get_current_user_data['user_role_slug']]['sale_price'];

          if($regular_price && $sale_price && isset($regular_price) && isset($sale_price) && $regular_price > $sale_price){
            $final_price = $sale_price;
          }
          elseif($regular_price && isset($regular_price)){
            $final_price = $regular_price;
          }
        }
      }
    }
    
    return $_this->product_price_by_filter( $final_price );
  }
  
  public static function product_brands_lists( $product_id ){
    $_this = new self;
    $brands = array();
    
    $get_term = $_this->product->getManufacturerByObjectId( $product_id );
    if(count($get_term) > 0 && isset($get_term['term_details']) && count($get_term['term_details']) > 0){
      $brands = $get_term['term_details'];
    }
    
    return $brands;
  }
  
  public static function single_page_product_brands_lists($brands_list){
    $brands_list_str = '';
    
    if(count($brands_list) > 0){
      foreach($brands_list as $brand_name){
        $brands_list_str .= $brand_name['name']. ', ';
      }
      $brands_list_str = trim($brands_list_str, ', ');
    }
    
    return $brands_list_str;
  }
  
  public static function single_page_product_tags_lists($tags_list){
    $tags_list_str = '';
    
    if(count($tags_list) > 0){
      foreach($tags_list as $tag_name){
        $tags_list_str .= $tag_name['name']. ', ';
      }
      
      $tags_list_str = trim($tags_list_str, ', ');
    }
    
    return $tags_list_str;
  }
  
   public static function single_page_product_categories_lists($product_id){
    $categories_list_str = '';
    $_this = new self;
    
    if(isset($product_id) && $product_id> 0){
      $cat_lists = $_this->product->getCatByObjectId($product_id);
      
      if(count($cat_lists) > 0 && isset($cat_lists['term_details']) && count($cat_lists['term_details']) > 0){
        foreach($cat_lists['term_details'] as $cat_name){
          $categories_list_str .= $cat_name['name'] . ', ';
        }
        $categories_list_str = trim($categories_list_str, ', ');
      }
    }
    
    return $categories_list_str;
  }

  public static function check_extension( $url ){
    $filename = trim( $url );
    $filetype = pathinfo($filename, PATHINFO_EXTENSION);
    
    return $filetype;
  }
  
  public static function product_categories_lists( $cat_array)
  {
    $cat_name_list = '';
    
    if(count($cat_array)>0)
    {
      foreach($cat_array as $row)
      {
        $get_categories_details   =   CategoriesList::where('cat_id', $row)->first();
        $cat_name_list .= $get_categories_details->cat_name . ', ';
      }
      
      $cat_name_list = trim($cat_name_list, ', ');
    }
    
    return $cat_name_list;
  }
  
  public static function product_parent_categories(){
		$_this = new self;
    return $_this->product->get_parent_categories(0, 'product_cat');
  }

  public static function product_tags_lists( $product_id ){
    $_this = new self;
    $tags = array();
    
    $get_term = $_this->product->getTagsByObjectId( $product_id );
    
    if(count($get_term) > 0 && isset($get_term['term_details']) && count($get_term['term_details']) > 0){
      $tags = $get_term['term_details'];
    }
    
    return $tags;
  }
  
  public static function products_by_product_tag_slug( $slug ){
    $tag_products_details = array();
    $_this = new self;
    
    if(isset($slug)){
      $get_tag_by_slug = Term::where(['slug' => $slug, 'type' => 'product_tag'])->get()->toArray();
      
      if(count($get_tag_by_slug) > 0){
        $tag_data_shift =  array_shift($get_tag_by_slug);
        $get_products   =  $_this->product->getProductsByTermId( $tag_data_shift['term_id'] ); 
        
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $col = new Collection( $get_products );
        $perPage = 10;
        $currentPageSearchResults = $col->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $posts_object = new LengthAwarePaginator($currentPageSearchResults, count($col), $perPage);
        $posts_object->setPath( route('tag-single-page', $tag_data_shift['slug']) );
      
        $tag_products_details['tag_details'] = $tag_data_shift;
        $tag_products_details['products'] = $posts_object;
      }
    }
    
    return $tag_products_details;
  }
  
  public static function product_type( $product_id = '' ){
    $product_type =  '';
    $get_product = Product :: where('id', $product_id)->first();
    
    if(!empty($get_product)){
      $product_type = $get_product->type;
    }
    
    return $product_type;
  }
  
  public static function product_variations( $product_id = '' ){
    $return_array = array(); 
    $_this = new self;
   
    if(count($_this->classCommonFunction->get_variation_by_product_id($product_id))>0){
      $return_array = $_this->classCommonFunction->get_variation_by_product_id($product_id);
    }
    
    return $return_array;
  }
  
  public static function product_variations_with_data( $product_id ){
    $return_array = array(); 
    $_this = new self;
    
    if(count($_this->classCommonFunction->get_variation_and_data_by_product_id($product_id))>0){
      $return_array = $_this->classCommonFunction->get_variation_and_data_by_product_id($product_id);
    }

    return $return_array;
  }
  
  public static function product_variations_min_to_max_price_html( $currency, $product_id){
    $price_range = '';
    $_this = new self;
    $result = array();
    
    if(count($_this->classCommonFunction->get_variation_and_data_by_product_id($product_id))>0){
      $details = $_this->classCommonFunction->get_variation_and_data_by_product_id($product_id);
      $get_current_user_data  =  get_current_frontend_user_info();
     
      foreach ($details as $key => $value) {
        if(is_frontend_user_logged_in() && isset($get_current_user_data['user_role_slug']) && $value['_is_role_based_pricing_enable'] == 1){
          $get_role_based_pricing_data = unserialize($value['_role_based_pricing']);
          
          if(isset($get_role_based_pricing_data[$get_current_user_data['user_role_slug']])){
            $regular_price =  $get_role_based_pricing_data[$get_current_user_data['user_role_slug']]['regular_price'];
            $sale_price    =  $get_role_based_pricing_data[$get_current_user_data['user_role_slug']]['sale_price'];
            
            if(isset($regular_price) && $regular_price && isset($sale_price) && $sale_price && $regular_price > $sale_price){
              $result[$key] = $sale_price;
            }
            elseif(isset($regular_price) && $regular_price){
              $result[$key] = $regular_price;
            }
            else{
              $result[$key] = 0;
            }
          }
        }
        else{
          $result[$key] = $value['_variation_post_price'];
        }
      }
      
      if(count($result) == 1){
        $price_range = price_html( $_this->product_price_by_filter( min($result) ),  $currency);
      }
      else {
        $price_range = price_html($_this->product_price_by_filter( min($result) ), $currency). ' - '. price_html( $_this->product_price_by_filter( max($result) ), $currency );
      }
    }
    else{
      $price_range = price_html( $_this->product_price_by_filter( 0 ), $currency );
    }
    
    return $price_range;
  }
  
  public static function current_currency_symbol(){
    $_this = new self;
    $get_settings_data = $_this->option->getSettingsData();
    
    return $_this->classCommonFunction->get_currency_symbol( $get_settings_data['general_settings']['currency_options']['currency_name'] );
  }
  
  public static function currency_symbol_by_code($code){
    $_this = new self;
    
    return $_this->classCommonFunction->get_currency_symbol($code);
  }
  
  public static function current_currency_name(){
    $_this = new self;
    $unserialize_settings_data = $_this->option->getSettingsData();
    
    return $unserialize_settings_data['general_settings']['currency_options']['currency_name'];
  }
  
  public static function get_all_countries()
  {
    return array(
      'AF' => 'Afghanistan',
      'AL' => 'Albania',
      'DZ' => 'Algeria',
      'AD' => 'Andorra',
      'AO' => 'Angola',
      'AI' => 'Anguilla',
      'AQ' => 'Antarctica',
      'AG' => 'Antigua and Barbuda',
      'AR' => 'Argentina',
      'AM' => 'Armenia',
      'AW' => 'Aruba',
      'AU' => 'Australia',
      'AT' => 'Austria',
      'AZ' => 'Azerbaijan',
      'BS' => 'Bahamas',
      'BH' => 'Bahrain',
      'BD' => 'Bangladesh',
      'BB' => 'Barbados',
      'BY' => 'Belarus',
      'BE' => 'Belgium',
      'PW' => 'Belau',
      'BZ' => 'Belize',
      'BJ' => 'Benin',
      'BM' => 'Bermuda',
      'BT' => 'Bhutan',
      'BO' => 'Bolivia',
      'BQ' => 'Bonaire, Saint Eustatius and Saba',
      'BA' => 'Bosnia and Herzegovina',
      'BW' => 'Botswana',
      'BV' => 'Bouvet Island',
      'BR' => 'Brazil',
      'IO' => 'British Indian Ocean Territory',
      'VG' => 'British Virgin Islands',
      'BN' => 'Brunei',
      'BG' => 'Bulgaria',
      'BF' => 'Burkina Faso',
      'BI' => 'Burundi',
      'KH' => 'Cambodia',
      'CM' => 'Cameroon',
      'CA' => 'Canada',
      'CV' => 'Cape Verde',
      'KY' => 'Cayman Islands',
      'CF' => 'Central African Republic',
      'TD' => 'Chad',
      'CL' => 'Chile',
      'CN' => 'China',
      'CX' => 'Christmas Island',
      'CC' => 'Cocos (Keeling) Islands',
      'CO' => 'Colombia',
      'KM' => 'Comoros',
      'CG' => 'Congo (Brazzaville)',
      'CD' => 'Congo (Kinshasa)',
      'CK' => 'Cook Islands',
      'CR' => 'Costa Rica',
      'HR' => 'Croatia',
      'CU' => 'Cuba',
      'CW' => 'Cura&Ccedil;ao',
      'CY' => 'Cyprus',
      'CZ' => 'Czech Republic',
      'DK' => 'Denmark',
      'DJ' => 'Djibouti',
      'DM' => 'Dominica',
      'DO' => 'Dominican Republic',
      'EC' => 'Ecuador',
      'EG' => 'Egypt',
      'SV' => 'El Salvador',
      'GQ' => 'Equatorial Guinea',
      'ER' => 'Eritrea',
      'EE' => 'Estonia',
      'ET' => 'Ethiopia',
      'FK' => 'Falkland Islands',
      'FO' => 'Faroe Islands',
      'FJ' => 'Fiji',
      'FI' => 'Finland',
      'FR' => 'France',
      'GF' => 'French Guiana',
      'PF' => 'French Polynesia',
      'TF' => 'French Southern Territories',
      'GA' => 'Gabon',
      'GM' => 'Gambia',
      'GE' => 'Georgia',
      'DE' => 'Germany',
      'GH' => 'Ghana',
      'GI' => 'Gibraltar',
      'GR' => 'Greece',
      'GL' => 'Greenland',
      'GD' => 'Grenada',
      'GP' => 'Guadeloupe',
      'GT' => 'Guatemala',
      'GG' => 'Guernsey',
      'GN' => 'Guinea',
      'GW' => 'Guinea-Bissau',
      'GY' => 'Guyana',
      'HT' => 'Haiti',
      'HM' => 'Heard Island and McDonald Islands',
      'HN' => 'Honduras',
      'HK' => 'Hong Kong',
      'HU' => 'Hungary',
      'IS' => 'Iceland',
      'IN' => 'India',
      'ID' => 'Indonesia',
      'IR' => 'Iran',
      'IQ' => 'Iraq',
      'IE' => 'Republic of Ireland',
      'IM' => 'Isle of Man',
      'IL' => 'Israel',
      'IT' => 'Italy',
      'CI' => 'Ivory Coast',
      'JM' => 'Jamaica',
      'JP' => 'Japan',
      'JE' => 'Jersey',
      'JO' => 'Jordan',
      'KZ' => 'Kazakhstan',
      'KE' => 'Kenya',
      'KI' => 'Kiribati',
      'KW' => 'Kuwait',
      'KG' => 'Kyrgyzstan',
      'LA' => 'Laos',
      'LV' => 'Latvia',
      'LB' => 'Lebanon',
      'LS' => 'Lesotho',
      'LR' => 'Liberia',
      'LY' => 'Libya',
      'LI' => 'Liechtenstein',
      'LT' => 'Lithuania',
      'LU' => 'Luxembourg',
      'MO' => 'Macao S.A.R., China',
      'MK' => 'Macedonia',
      'MG' => 'Madagascar',
      'MW' => 'Malawi',
      'MY' => 'Malaysia',
      'MV' => 'Maldives',
      'ML' => 'Mali',
      'MT' => 'Malta',
      'MH' => 'Marshall Islands',
      'MQ' => 'Martinique',
      'MR' => 'Mauritania',
      'MU' => 'Mauritius',
      'YT' => 'Mayotte',
      'MX' => 'Mexico',
      'FM' => 'Micronesia',
      'MD' => 'Moldova',
      'MC' => 'Monaco',
      'MN' => 'Mongolia',
      'ME' => 'Montenegro',
      'MS' => 'Montserrat',
      'MA' => 'Morocco',
      'MZ' => 'Mozambique',
      'MM' => 'Myanmar',
      'NA' => 'Namibia',
      'NR' => 'Nauru',
      'NP' => 'Nepal',
      'NL' => 'Netherlands',
      'AN' => 'Netherlands Antilles',
      'NC' => 'New Caledonia',
      'NZ' => 'New Zealand',
      'NI' => 'Nicaragua',
      'NE' => 'Niger',
      'NG' => 'Nigeria',
      'NU' => 'Niue',
      'NF' => 'Norfolk Island',
      'KP' => 'North Korea',
      'NO' => 'Norway',
      'OM' => 'Oman',
      'PK' => 'Pakistan',
      'PS' => 'Palestinian Territory',
      'PA' => 'Panama',
      'PG' => 'Papua New Guinea',
      'PY' => 'Paraguay',
      'PE' => 'Peru',
      'PH' => 'Philippines',
      'PN' => 'Pitcairn',
      'PL' => 'Poland',
      'PT' => 'Portugal',
      'QA' => 'Qatar',
      'RE' => 'Reunion',
      'RO' => 'Romania',
      'RU' => 'Russia',
      'RW' => 'Rwanda',
      'BL' => 'Saint Barth&eacute;lemy',
      'SH' => 'Saint Helena',
      'KN' => 'Saint Kitts and Nevis',
      'LC' => 'Saint Lucia',
      'MF' => 'Saint Martin (French part)',
      'SX' => 'Saint Martin (Dutch part)',
      'PM' => 'Saint Pierre and Miquelon',
      'VC' => 'Saint Vincent and the Grenadines',
      'SM' => 'San Marino',
      'SA' => 'Saudi Arabia',
      'SN' => 'Senegal',
      'RS' => 'Serbia',
      'SC' => 'Seychelles',
      'SL' => 'Sierra Leone',
      'SG' => 'Singapore',
      'SK' => 'Slovakia',
      'SI' => 'Slovenia',
      'SB' => 'Solomon Islands',
      'SO' => 'Somalia',
      'ZA' => 'South Africa',
      'GS' => 'South Georgia/Sandwich Islands',
      'KR' => 'South Korea',
      'SS' => 'South Sudan',
      'ES' => 'Spain',
      'LK' => 'Sri Lanka',
      'SD' => 'Sudan',
      'SR' => 'Suriname',
      'SJ' => 'Svalbard and Jan Mayen',
      'SZ' => 'Swaziland',
      'SE' => 'Sweden',
      'CH' => 'Switzerland',
      'SY' => 'Syria',
      'TW' => 'Taiwan',
      'TJ' => 'Tajikistan',
      'TZ' => 'Tanzania',
      'TH' => 'Thailand',
      'TL' => 'Timor-Leste',
      'TG' => 'Togo',
      'TK' => 'Tokelau',
      'TO' => 'Tonga',
      'TT' => 'Trinidad and Tobago',
      'TN' => 'Tunisia',
      'TR' => 'Turkey',
      'TM' => 'Turkmenistan',
      'TC' => 'Turks and Caicos Islands',
      'TV' => 'Tuvalu',
      'UG' => 'Uganda',
      'UA' => 'Ukraine',
      'AE' => 'United Arab Emirates',
      'GB' => 'United Kingdom (UK)',
      'US' => 'United States (US)',
      'UY' => 'Uruguay',
      'UZ' => 'Uzbekistan',
      'VU' => 'Vanuatu',
      'VA' => 'Vatican',
      'VE' => 'Venezuela',
      'VN' => 'Vietnam',
      'WF' => 'Wallis and Futuna',
      'EH' => 'Western Sahara',
      'WS' => 'Western Samoa',
      'YE' => 'Yemen',
      'ZM' => 'Zambia',
      'ZW' => 'Zimbabwe'
    );
  }
  
  public static function available_currency_name()
  {
    return array(
      'AED' => 'United Arab Emirates Dirham (د.إ)',
      'ARS' => 'Argentine Peso ($)',
      'AUD' => 'Australian Dollars ($)', 
      'BDT' => 'Bangladeshi Taka (৳)',
      'BRL' => 'Brazilian Real (R$)',
      'BGN' => 'Bulgarian Lev (лв.)',
      'CAD' => 'Canadian Dollars ($)',
      'CLP' => 'Chilean Peso ($)',
      'CNY' => 'Chinese Yuan (¥)',
      'COP' => 'Colombian Peso ($)',
      'DKK' => 'Danish Krone (DKK)',
      'DOP' => 'Dominican Peso (RD$)',
      'EUR' => 'Euros (€)', 
      'HKD' => 'Hong Kong Dollar ($)',
      'HRK' => 'Croatia kuna (Kn)',
      'HUF' => 'Hungarian Forint (Ft)',
      'ISK' => 'Icelandic krona (Kr.)',
      'IDR' => 'Indonesia Rupiah (Rp)',
      'INR' => 'Indian Rupee (Rs.)',
      'NPR' => 'Nepali Rupee (Rs.)',
      'JPY' => 'Japanese Yen (¥)',
      'KRW' => 'South Korean Won (₩)',
      'MYR' => 'Malaysian Ringgits (RM)',
      'MXN' => 'Mexican Peso ($)', 
      'NGN' => 'Nigerian Naira (₦)',
      'NZD' => 'New Zealand Dollar ($)',
      'PHP' => 'Philippine Pesos (₱)',
      'GBP' => 'Pounds Sterling (£)',
      'RON' => 'Romanian Leu (lei)',
      'RUB' => 'Russian Ruble (руб.)',
      'SGD' => 'Singapore Dollar ($)',
      'ZAR' => 'South African rand (R)',
      'SEK' => 'Swedish Krona (kr)',
      'CHF' => 'Swiss Franc (CHF)',
      'TWD' => 'Taiwan New Dollars (NT$)',
      'THB' => 'Thai Baht (฿)',
      'UAH' => 'Ukrainian Hryvnia (₴)',
      'USD' => 'US Dollars ($)', 
      'VND' => 'Vietnamese Dong (₫)',
      'EGP' => 'Egyptian Pound (EGP)'
    );
  }

  public static function get_country_name_by_code( $code )
  {
    $country_code = strtoupper($code);
    $countryList = get_country_list();
    
    if( !$countryList[$country_code] ) 
    {
      return $country_code;
    }
    else 
    {
      return $countryList[$country_code];
    }
  }
  
  public static function recent_uploaded_images_for_designer( )
  {
    $get_images_data = array();
    
    if(Session::has('_recent_uploaded_images'))
    {
      $get_img_ary = unserialize( Session::get('_recent_uploaded_images') ) ;
      
      if(count($get_img_ary) > 0)
      {
        $get_images_data = $get_img_ary;
      }
    }
    
    return $get_images_data;
  }
  
  public static function customize_images_by_access_token( $access_token )
  {
    $images = array();
    
    if($access_token)
    {
      if(Session::has('_recent_saved_custom_design_images'))
      {
        $get_img_ary = Session::get('_recent_saved_custom_design_images');
        $parse_ary   = unserialize($get_img_ary);
        
        if (array_key_exists($access_token, $parse_ary))
        {
          if(count($parse_ary[$access_token]) > 0)
          {
            $images = $parse_ary[$access_token];
          }
        }
      }
    }
    
    return $images;
  }
  
  public static function admin_customize_images_by_access_token( $product_id, $order_id, $access_token )
  {
    $images = array();
    
    if($product_id && $order_id && $access_token)
    {
      $get_images = UsersCustomDesign::where(['product_id' => $product_id, 'order_id' => $order_id, 'access_token' => $access_token])->first(); 
      if(!empty($get_images))
      {
        $images = unserialize($get_images->design_images);
      }
    }
    
    return $images;
  }
  
  public static function payment_method_title($payment_method)
  {
    $_this = new self;
    
    if(isset($_this->payment[$payment_method]['method_title']))
    {
      return $_this->payment[$payment_method]['method_title'];
    }
  }
  
  public static function current_admin_user_info(){
    $userData = array();
    
    if(Session::has('shopist_admin_user_id')){
      $getuserdata = User::find(Session::get('shopist_admin_user_id'));
      
      if(!empty($getuserdata)){
        $userData['user_role_id'] = $getuserdata->roles[0]->id;
        $userData['user_role'] = $getuserdata->roles[0]->role_name;
        $userData['user_role_slug'] = $getuserdata->roles[0]->slug;
        $userData['user_display_name'] = $getuserdata->display_name;
        $userData['user_name'] = $getuserdata->name;
        $userData['user_email'] = $getuserdata->email;
        $userData['user_photo_url'] = $getuserdata->user_photo_url;
        $userData['user_status'] = $getuserdata->user_status;
        $userData['user_id'] = Session::get('shopist_admin_user_id');
        $userData['member_since'] = $getuserdata->roles[0]->created_at;
      }
    }
    else{
      $userData['user_role_id'] = '';
      $userData['user_role'] = '';
      $userData['user_role_slug'] = '';
      $userData['user_display_name'] = '';
      $userData['user_name'] = '';
      $userData['user_email'] = '';
      $userData['user_photo_url'] = '';
      $userData['user_status'] = '';
      $userData['user_id'] = '';
      $userData['member_since'] = '';
    }
    
    return $userData;
  }
  
  public static function current_frontend_user_info(){
    $userData = array();
    
    if(Session::has('shopist_frontend_user_id')){
      $getuserdata = User::find(Session::get('shopist_frontend_user_id'));
      
      if(!empty($getuserdata)){
        $userData['user_role_id'] = $getuserdata->roles[0]->id;
        $userData['user_role'] = $getuserdata->roles[0]->role_name;
        $userData['user_role_slug'] = $getuserdata->roles[0]->slug;
        $userData['user_display_name'] = $getuserdata->display_name;
        $userData['user_name'] = $getuserdata->name;
        $userData['user_email'] = $getuserdata->email;
        $userData['user_photo_url'] = $getuserdata->user_photo_url;
        $userData['user_status'] = $getuserdata->user_status;
        $userData['user_id'] = Session::get('shopist_frontend_user_id');
        $userData['member_since'] = $getuserdata->created_at;
      }
    }
    else{
      $userData['user_role_id'] = '';
      $userData['user_role'] = '';
      $userData['user_role_slug'] = '';
      $userData['user_display_name'] = '';
      $userData['user_name'] = '';
      $userData['user_email'] = '';
      $userData['user_photo_url'] = '';
      $userData['user_status'] = '';
      $userData['user_id'] = '';
      $userData['member_since'] = '';
    }
    
    return $userData;
  }
  
  public static function current_vendor_user_info(){
    $_this = new self;
    return $_this->current_admin_user_info();
  }
  
  public static function create_slug_format($str)
  {
    if($str)
    {
      return Str::slug($str, '-');
    } 
  }
  
  public static function check_design_enable_by_product_id($product_id){
    if($product_id > 0){
      $post_meta   =   ProductExtra::where(['product_id' => $product_id, 'key_name' => '_product_enable_as_custom_design'])->first();
      
      if($post_meta->key_value == 'yes'){
        return true;
      }
      else {
        return false;
      }
    }
  }
  
  public static function product_review($product_id){
    if($product_id){
      $review_settings = array('enable_reviews' => '', 'product_page_reviews' => '', 'details_page_reviews' => '', 'totals_reviews' => '');
      $post_meta_1   =   ProductExtra::where(['product_id' => $product_id, 'key_name' => '_product_enable_reviews'])->first();
      $post_meta_2   =   ProductExtra::where(['product_id' => $product_id, 'key_name' => '_product_enable_reviews_add_link_to_product_page'])->first();
      $post_meta_3   =   ProductExtra::where(['product_id' => $product_id, 'key_name' => '_product_enable_reviews_add_link_to_details_page'])->first();
      $post_meta_4   =   ProductExtra::where(['product_id' => $product_id, 'key_name' => '_product_enable_reviews_totals_with_link'])->first();
      
      if(!empty($post_meta_1)){
        $review_settings['enable_reviews']       =  $post_meta_1->key_value;
      }
      
      if(!empty($post_meta_2)){
        $review_settings['product_page_reviews'] =  $post_meta_2->key_value;
      }
      
      if(!empty($post_meta_3)){
        $review_settings['details_page_reviews'] =  $post_meta_3->key_value;
      }
      
      if(!empty($post_meta_4)){
         $review_settings['totals_reviews']      =  $post_meta_4->key_value;
      }

      return $review_settings;
    }
  }
  
  public static function create_price_view($price, $currency_code = null){
    $_this      =   new self;
    $currency   =   '';
    $price_html =   '';
    $settings =  $_this->option->getSettingsData();
    $get_price = 0;
    
    if($price){
      $get_price = $price;
    }
   
    $number = number_format( $get_price , $settings['general_settings']['currency_options']['number_of_decimals'] , $settings['general_settings']['currency_options']['decimal_separator'] , $settings['general_settings']['currency_options']['thousand_separator'] );
    
    if($currency_code){
      $currency = get_currency_symbol_by_code( $currency_code );
    }
    else{
      $currency = get_currency_symbol_by_code( $settings['general_settings']['currency_options']['currency_name'] );
    }
    
    if($settings['general_settings']['currency_options']['currency_position'] == 'left'){
      $price_html = $currency.$number;
    }
    elseif($settings['general_settings']['currency_options']['currency_position'] == 'right'){
      $price_html = $number.$currency;
    }
    elseif($settings['general_settings']['currency_options']['currency_position'] == 'left_with_space'){
      $price_html = $currency.' '.$number;
    }
    elseif($settings['general_settings']['currency_options']['currency_position'] == 'right_with_space'){
      $price_html = $number .' '. $currency;
    }
    
    return $price_html;
  }
  
  public static function get_user_all_details( $user_id ){
    $userData = array();
    $getuserdata = User::find( $user_id );
    
    if($getuserdata && count($getuserdata->roles) > 0){
      $userData['user_role']          =   $getuserdata->roles[0]->role_name;
      $userData['user_role_slug']     =   $getuserdata->roles[0]->slug;
      $userData['user_display_name']  =   $getuserdata->display_name;
      $userData['user_name']          =   $getuserdata->name;
      $userData['user_email']         =   $getuserdata->email;
      $userData['user_password']      =   $getuserdata->password;
      $userData['user_secret_key']    =   $getuserdata->secret_key;
      $userData['user_photo_url']     =   $getuserdata->user_photo_url;
      $userData['user_status']        =   $getuserdata->user_status;
    }
    
    return $userData;
  }
  
  public static function get_user_account_details( $user_id ){
    $userAccuntData = array();
    $getUserAccuntData = UsersDetail::where( ['user_id' => $user_id] )->get()->toArray();
    
    if(count($getUserAccuntData) > 0){
      $userAccuntData = $getUserAccuntData;
    }
    
    return $userAccuntData;
  }
  
  public static function product_availability( $product_id ){
    $product_availability = '';
    $get_product  =  Product::where(['id' => $product_id])->first();
    
    if(!empty($get_product)){
      if($get_product->stock_availability == 'in_stock'){
        $product_availability = 'In Stock';
      }
      else{
        $product_availability = 'Out of Stock';
      }
    }
    
    return $product_availability;
  }
  
  public static function product_price_by_filter( $amount ){
    $price               =   0;
    $from_currency       =   '';
    $to_currency         =   '';
    $_this               =   new self;
    
    $current_currency_name = get_current_currency_name();
    
    if(Cookie::has('shopist_multi_currency')){
      $from_currency  =  $current_currency_name;
      $to_currency    =  Cookie::get('shopist_multi_currency');
      
      $results = $_this->classCommonFunction->convertCurrency($from_currency, $to_currency, $amount);
      
      if(!is_null($results)){
        $price =  $results;
      }
      else{
        $price = $amount;
      }
    }
    else{
      $price = $amount;
    }
    
    return $price;
  }
  
  public static function frontend_current_appearance_settings()
  {
		$_this  =   new self;
    return $_this->option->getAppearanceData();
  }
  
  public static function appearance_header_settings_data(){
    $_this  =   new self;
    $unserialize_appearance_data  =  $_this->option->getAppearanceData();
    
    $get_settings = json_decode($unserialize_appearance_data['settings']); 
    $slider_elements = array();
    
    if(count($get_settings->header_slider_images_and_text->slider_images) > 0 ){
      foreach($get_settings->header_slider_images_and_text->slider_images as $img){
        $data_obj = new \stdClass();

        $data_obj->id = $img->id;
        $data_obj->img_url = $img->url;

        if(count($get_settings->header_slider_images_and_text->slider_text) > 0){
          foreach($get_settings->header_slider_images_and_text->slider_text as $text){
            if($text->id == $img->id){
              $data_obj->text = $text->html_code;
              $data_obj->text_css = $text->advanced_css;

              break;
            }
          }
        }
        
        $slider_elements[] = $data_obj;
      }
    }
    
    return $slider_elements;
  }
  
  public static function available_languages_data()
  {
    $get_avaliable_lang = array();
    $avaliable_lang = ManageLanguage::all()->toArray();
    
    if(count($avaliable_lang) > 0){
      $get_avaliable_lang = $avaliable_lang;
    }
    
    return $get_avaliable_lang;
  }
  
  public static function available_languages_data_frontend(){
    $get_avaliable_lang_frontend = array();
    $avaliable_lang = ManageLanguage:: where(['status' => 1])->get()->toArray();
   
    if(count($avaliable_lang) > 0){
      $get_avaliable_lang_frontend = $avaliable_lang;
    }
    
    return $get_avaliable_lang_frontend;
  }
  
  public static function default_languages_data(){
    $get_default_lang = array();
    $default_lang = ManageLanguage:: where(['default_lang' => 1])->get()->toArray();
   
    if(count($default_lang) > 0){
      $get_default_lang = array_shift($default_lang);
    }
    else{
      $get_default_lang['id'] = null;
      $get_default_lang['lang_name'] = 'english';
      $get_default_lang['lang_code'] = 'en';  
      $get_default_lang['lang_sample_img'] = 'en_lang_sample_img.png';  
    }
    
    return $get_default_lang;
  }
  
  public static function permissions_files_list(){
    $_this  = new self;
    $permissions_data = array();
    $permissions_data =  $_this->option->getPermissionsFilesList();
    
    if(count($permissions_data) > 0){
      return $permissions_data;
    }
  }
  
  public static function roles_details_by_role_slug( $role_slug ){
    $get_role_data_obj = null;
    $role_data = DB::table('roles')->where('roles.slug', '=', $role_slug)
    ->join('user_role_permissions', 'user_role_permissions.role_id', '=', 'roles.id')
    ->select('roles.*', 'user_role_permissions.role_id', 'user_role_permissions.permissions')        
    ->first();
    
    if(!empty($role_data)){
      $get_role_data  = $role_data;
      $get_role_data->permissions = unserialize($get_role_data->permissions);
      $get_role_data_obj = $get_role_data;
    }
    
    return $get_role_data_obj;
  }
  
  public static function role_name_by_role_slug( $role_slug ){
    $_this   =   new self;
    return $_this->user->getRoleNameByRoleSlug( $role_slug );
  }
  
  public static function roles_details_by_role_id( $role_id ){
    $get_role_data_obj = null;
    $role_data = DB::table('roles')->where('roles.id', '=', $role_id)
    ->join('user_role_permissions', 'user_role_permissions.role_id', '=', 'roles.id')
    ->select('roles.*', 'user_role_permissions.role_id', 'user_role_permissions.permissions')        
    ->first();
      
    if(!empty($role_data)){
      $get_role_data  = $role_data;
      $get_role_data->permissions = unserialize($get_role_data->permissions);
      $get_role_data_obj = $get_role_data;
    }
    
    return $get_role_data_obj;
  }
  
  public static function available_user_role(){
    $_this   =   new self;
		return $_this->user->getAvailableUserRole();
  }
  
  public static function frontend_selected_languages_data(){
    $selected_lang = array();
    
    if(Cookie::has('shopist_multi_lang')){
      $get_lang_data_by_cookie_val = ManageLanguage::where('lang_code', Cookie::get('shopist_multi_lang'))->first();
      $selected_lang['id'] = $get_lang_data_by_cookie_val->id;
      $selected_lang['lang_name'] = $get_lang_data_by_cookie_val->lang_name;
      $selected_lang['lang_code'] = $get_lang_data_by_cookie_val->lang_code;
      $selected_lang['lang_sample_img'] = $get_lang_data_by_cookie_val->lang_sample_img;
      $selected_lang['status'] = $get_lang_data_by_cookie_val->status;
    }
    else{
      $get_default_lang = get_default_languages_data();
      
      $selected_lang['id'] = $get_default_lang['id'];
      $selected_lang['lang_name'] = $get_default_lang['lang_name'];
      $selected_lang['lang_code'] = $get_default_lang['lang_code'];
      $selected_lang['lang_sample_img'] = $get_default_lang['lang_sample_img'];
      $selected_lang['status'] = null;
    }
    
    return $selected_lang;
  }
  
  public static function frontend_selected_currency_data(){
    $selected_currency =   array();
    $_this             =   new self;
    $settings = $_this->option->getSettingsData();
    
    if(isset($settings['general_settings']['currency_options']['frontend_currency']) && count($settings['general_settings']['currency_options']['frontend_currency']) >0){
      $selected_currency = $settings['general_settings']['currency_options']['frontend_currency'];
    }
    
    return $selected_currency;
  }
  
  public static function currency_name_by_code( $code ){
    $currency_name = '';
    $_this    =   new self;
    
    if(count($_this->available_currency_name()) > 0){
      $get_currency_name =  $_this->available_currency_name();
      $currency_name     =  $get_currency_name[$code];
    }
    
    return $currency_name;
  }
  
  public static function frontend_selected_currency(){
    $selected_currency_name   =   '';
    $_this                    =   new self;
    $settings = $_this->option->getSettingsData();
    
    if(Cookie::has('shopist_multi_currency')){
      $selected_currency_name = Cookie::get('shopist_multi_currency');
    }
    else{
      if(isset($settings['general_settings']['currency_options']['currency_name'])){
        $selected_currency_name = $settings['general_settings']['currency_options']['currency_name'];
      }
    }
  
    return $selected_currency_name;
  }
  
  public static function site_logo_image(){
    $_this     =   new self;
    $url       =   '';
    $settings  = $_this->option->getSettingsData(); 
    
    $image_url   = url('/').'/public/images/';
    
    if(isset($settings['general_settings']['general_options']['site_logo']) && $settings['general_settings']['general_options']['site_logo']){
      $url = get_image_url($settings['general_settings']['general_options']['site_logo']);
    }
    else{
      $url = $image_url.'shopist-icon.png';
    }
    
    return $url;
  }
  
  public static function site_title(){
    $_this     =   new self;
    $settings  = $_this->option->getSettingsData(); 
    $title = 'Shopist';
    
    if(isset($settings['general_settings']['general_options']['site_title']) && $settings['general_settings']['general_options']['site_title']){
      $title = $settings['general_settings']['general_options']['site_title'];
    }
    
    return $title;
  }
  
  public static function appearance_settings(){
    $_this         =  new self;
    $settings_data =  array();
    
    $unserialize_appearance_data  =   $_this->option->getAppearanceData();
    
    if(isset($unserialize_appearance_data['settings_details']) && count($unserialize_appearance_data['settings_details']) >0){
      $settings_data = $unserialize_appearance_data['settings_details'];
      
      if(Request::is('/')){
        $settings_data['home_details']['cat_name_and_products'] = array();
        $settings_data['home_details']['collection_cat_list'] = array();
      
      
        if(isset($settings_data['home_details']['cat_list_to_display']) && count($settings_data['home_details']['cat_list_to_display']) > 0){
          $cat_name_products = array();

          foreach ($settings_data['home_details']['cat_list_to_display'] as $cat){
            $get_parent_categories   =   $_this->product->getTermDataById( $cat );

            if(!empty($get_parent_categories) && count($get_parent_categories) > 0){
              $get_products_data  =  DB::table('products')
                                     -> where(['products.status' => 1, 'object_relationships.term_id' => $cat, 'product_extras.key_name' => '_product_enable_as_selected_cat', 'product_extras.key_value' => 'yes'])
                                     -> join('object_relationships', 'object_relationships.object_id', '=', 'products.id')
                                     -> join('product_extras', 'product_extras.product_id', '=', 'products.id')
                                     -> select('products.*')        
                                     -> get();

              if( (!empty($get_parent_categories) && count($get_parent_categories) > 0) && (!empty($get_products_data) && $get_products_data->count() > 0)){
                $cat_name_products['cat_deails']   = array_shift($get_parent_categories);
                $cat_name_products['cat_products'] = $get_products_data;

                array_push($settings_data['home_details']['cat_name_and_products'], $cat_name_products);
              }
            }
          }
        }
      
        if(isset($settings_data['home_details']['cat_collection_list_to_display']) && count($settings_data['home_details']['cat_collection_list_to_display']) > 0){
          foreach ($settings_data['home_details']['cat_collection_list_to_display'] as $cat){
            $get_parent_categories   =   $_this->product->getTermDataById( $cat );

            if(!empty($get_parent_categories) && count($get_parent_categories) > 0){
              array_push($settings_data['home_details']['collection_cat_list'], array_shift($get_parent_categories));
            }
          }
        }
      }  
    }
    
    return $settings_data;
  }
  
  public static function testimonial_data_by_slug($slug){
    $testimonial_array =   array();
    $_this  =   new self;
    
    $get_testimonial = $_this->CMS->get_testimonial_data_by_slug($slug);
    
    if(count($get_testimonial) > 0){
      $testimonial_array = $get_testimonial;
    }
    
    return $testimonial_array;
  }
  
  public static function all_testimonial_data(){
    $_this  = new self;
    return $_this->CMS->get_testimonials(false, null, 1);
  }
  
  public static function limit_string($str, $val){
    $string = '';
    if(isset($str) && isset($val) && !empty($val)){
      $string =  strlen($str)<=$val?$str:substr($str,0,$val).'......';
    }
    else{
      $string = $str;
    }
    
    return $string;
  }
  
  public static function all_blogs_data($status = null){
    $_this             =   new self;
    $blog_data_array   =   array();
   
    if(isset($status)){
      $get_post_for_blogs =  Post :: where(['post_type' => 'post-blog', 'post_status' => $status])->get()->toArray();
    }
    else{
      $get_post_for_blogs =  Post :: where(['post_type' => 'post-blog'])->get()->toArray();
    }
    
    if(count($get_post_for_blogs) > 0){
      foreach($get_post_for_blogs as $row){
        $get_post_meta  =  PostExtra::where(['post_id' => $row['id']])->get()->toArray();
        
        if(count($get_post_meta) > 0){
          foreach($get_post_meta as $post_meta_data){
      
            if($post_meta_data['key_name'] == '_featured_image'){
              $row['featured_image'] = $post_meta_data['key_value'];
            }
            
            if($post_meta_data['key_name'] == '_allow_max_number_characters_at_frontend'){
              $row['allow_max_number_characters_at_frontend'] = $post_meta_data['key_value'];
            }
            
            if($post_meta_data['key_name'] == '_allow_comments_at_frontend'){
              $row['allow_comments_at_frontend'] = $post_meta_data['key_value'];
            }
          }
        }
        
        $get_comments_details = get_comments_rating_details( $row['id'], 'blog' );
        
        if(count($get_comments_details) > 0){
          $row['comments_details'] = $get_comments_details;
        }
        else{
          $row['comments_details'] = array();
        }
       
        array_push($blog_data_array, $row);
      }
    }
   
    return $blog_data_array;
  }
  
  public static function blog_postmeta_data($post_id, $metakey){
    $data = array();
    $data_str = '';
    
    if(isset($post_id)){
      $get_postmeta = PostExtra::where(['post_id' => $post_id])->get()->toArray();
      
      if(count($get_postmeta) > 0){
        foreach($get_postmeta as $row){
          if(isset($row['key_name']) && $row['key_name'] == '_featured_image'){
            $data['featured_image'] = $row['key_value'];
          }
          
          if(isset($row['key_name']) && $row['key_name'] == '_allow_max_number_characters_at_frontend'){
            $data['allow_max_number_characters_at_frontend'] = $row['key_value'];
          }
          
          if(isset($row['key_name']) && $row['key_name'] == '_allow_comments_at_frontend'){
            $data['allow_comments_at_frontend'] = $row['key_value'];
          }
        }
      }
      
      if(count($data) > 0 && array_key_exists($metakey, $data)){
        $data_str = $data[$metakey];
      }
    }
    return $data_str;
  }
  
  public static function key_value_exists($array, $key, $value){
    
    foreach ($array as $item)
        if (isset($item[$key]) && $item[$key] == $value)
            return true;
    return false;
  }
  
  public static function seo_data(){
    $_this  =  new self;
    return $_this->option->getSEOData();
  }
  
  public static function subscription_data(){
    $_this     =   new self;
    $subscription_data_array = array();
    
    if(count($_this->subscriptionData) > 0){
      $subscription_data_array = $_this->subscriptionData; 
    }
    
    return $subscription_data_array;
  }
  
  public static function subscription_settings_data(){
    $_this  = new self;
    return $_this->option->getSubscriptionSettingsData();
  }
  
  public static function comments_data_by_object_id($object_id, $target){
    $comments_data = array();
    
    if(!empty($object_id) && $object_id >0 && !empty($target)){
      if($target == 'product'){
        $get_comments = DB::table('comments')
                      ->where(['comments.object_id' => $object_id, 'comments.target' => $target, 'comments.status' => 1])
                      ->join('products', 'comments.object_id', '=', 'products.id')
                      ->join('users', 'comments.user_id', '=', 'users.id')
                      ->select('comments.*', 'products.title', 'products.slug', 'users.display_name', 'users.user_photo_url', DB::raw("((comments.rating/5)*100) as percentage"), DB::raw("((comments.rating/5)*100) as percentage"))
                      ->get()
                      ->toArray();
      }
      else{
        $get_comments = DB::table('comments')
                      ->where(['comments.object_id' => $object_id, 'comments.target' => $target, 'comments.status' => 1])
                      ->join('posts', 'comments.object_id', '=', 'posts.id')
                      ->join('users', 'comments.user_id', '=', 'users.id')
                      ->select('comments.*', 'posts.post_title', 'posts.post_slug', 'users.display_name', 'users.user_photo_url', DB::raw("((comments.rating/5)*100) as percentage"), DB::raw("((comments.rating/5)*100) as percentage"))
                      ->get()
                      ->toArray();
      }
      
      if(count($get_comments) > 0){
        $comments_data = $get_comments;
      }
    }
    
    return $comments_data;
  }
  
  public static function comments_rating_details($object_id, $target){
    $total  =  0;
    $individual  =  0;
    $comment_details =  array();
    
    if(!empty($object_id) && $object_id >0 && !empty($target)){
      $data = DB::table("comments")
            ->where(['object_id' => $object_id, 'target' => $target, 'status' => 1])
            ->select(DB::raw("COUNT(*) as count_row, rating"))
            ->groupBy(DB::raw("rating"))
            ->get()
            ->toArray();
      
      if(count($data) > 0){
        foreach($data as $row){
          $total += $row->count_row;
          $individual += $row->rating * $row->count_row;
          $comment_details[$row->rating] = $row->count_row * 100;
        }
      }  
        
      if(!empty($total) && $total > 0){
        $comment_details['total']  =  $total;
      }
      else{
        $comment_details['total']  =  0;
      }

      if(!empty($individual) && !empty($total) && $individual > 0 && $total >0){
        $comment_details['average']  =  number_format(($individual / $total), 2);
      }
      else{
        $comment_details['average']  =  0;
      }

      if(isset($comment_details['average']) && !empty($comment_details['average'])){
        $comment_details['percentage']   =  round((($comment_details['average'] / 5) * 100), 2);
      }
      else{
        $comment_details['percentage']   =  0;
      }

      if(isset($comment_details[5])){
        $comment_details[5] = round(($comment_details[5] / $comment_details['total']), 2);
      }
      else{
        $comment_details[5] = 0;
      }

      if(isset($comment_details[4])){
        $comment_details[4] = round(($comment_details[4] / $comment_details['total']), 2);
      }
      else{
        $comment_details[4] = 0;
      }

      if(isset($comment_details[3])){
        $comment_details[3] = round(($comment_details[3] / $comment_details['total']), 2);
      }
      else{
        $comment_details[3] =0;
      }

      if(isset($comment_details[2])){
        $comment_details[2] = round(($comment_details[2] / $comment_details['total']), 2);
      }
      else{
        $comment_details[2] = 0;
      }

      if(isset($comment_details[1])){
        $comment_details[1] = round(($comment_details[1] / $comment_details['total']), 2);
      }
      else{
        $comment_details[1] = 0;
      }
    }
    
    return $comment_details;
  }
  
  public static function reviews_settings_data($product_id){
    $details = array();
    $get_post_meta_1 = ProductExtra::where(['product_id' => $product_id, 'key_name' => '_product_enable_reviews'])->first();
    $get_post_meta_2 = ProductExtra::where(['product_id' => $product_id, 'key_name' => '_product_enable_reviews_add_link_to_product_page'])->first();
    $get_post_meta_3 = ProductExtra::where(['product_id' => $product_id, 'key_name' => '_product_enable_reviews_add_link_to_details_page'])->first();
    
    
    if(!empty($get_post_meta_1)){
      $details['enable_reviews'] = $get_post_meta_1->key_value;
    }
    else{
      $details['enable_reviews'] = '';
    }
    
    if(!empty($get_post_meta_2)){
      $details['enable_reviews_add_link_to_product_page'] = $get_post_meta_2->key_value;
    }
    else{
      $details['enable_reviews_add_link_to_product_page'] = '';
    }
    
    if(!empty($get_post_meta_3)){
      $details['enable_reviews_add_link_to_details_page'] = $get_post_meta_3->key_value;
    }
    else{
      $details['enable_reviews_add_link_to_details_page'] = '';
    }
    
    return $details;
  }
  
  public static function current_page_name(){
    $current_page_name = '';
    
    if(\Request::is('/')){
      $current_page_name = 'home';
    }
    elseif(\Request::is('shop')){
      $current_page_name = 'shop';
    }
    elseif(\Request::is('cart')){
      $current_page_name = 'cart';
    }
    elseif(\Request::is('blogs')){
      $current_page_name = 'blog';
    }
    
    return $current_page_name;
  }
  
  public static function customer_order_billing_shipping_info($order_id){
    $user_address = array();
    
    if(isset($order_id) &&  $order_id > 0){
      $get_order_user = PostExtra::where(['post_id' => $order_id, 'key_name' => '_customer_user'])->first();
      
      if(!empty($get_order_user)){
        $order_user = unserialize($get_order_user->key_value);
        
        if($order_user['user_mode'] == 'guest'){
          $get_order_post_meta    =   PostExtra :: where('post_id', $order_id)->get();
          
          if(!empty($get_order_post_meta) && $get_order_post_meta->count() > 0){
            foreach($get_order_post_meta as $rows){
              if($rows->key_name == '_billing_title'){
                $user_address['_billing_title'] = $rows->key_value;
              }
              elseif($rows->key_name == '_billing_first_name'){
                $user_address['_billing_first_name'] = $rows->key_value;
              }
              elseif($rows->key_name == '_billing_last_name'){
                $user_address['_billing_last_name'] = $rows->key_value;
              }
              elseif($rows->key_name == '_billing_company'){
                $user_address['_billing_company'] = $rows->key_value;
              }
              elseif($rows->key_name == '_billing_email'){
                $user_address['_billing_email'] = $rows->key_value;
              }
              elseif($rows->key_name == '_billing_phone'){
                $user_address['_billing_phone'] = $rows->key_value;
              }
              elseif($rows->key_name == '_billing_fax'){
                $user_address['_billing_fax'] = $rows->key_value;
              }
              elseif($rows->key_name == '_billing_country'){
                $user_address['_billing_country'] = $rows->key_value;
              }
              elseif($rows->key_name == '_billing_address_1'){
                $user_address['_billing_address_1'] = $rows->key_value;
              }
              elseif($rows->key_name == '_billing_address_2'){
                $user_address['_billing_address_2'] = $rows->key_value;
              }
              elseif($rows->key_name == '_billing_city'){
                $user_address['_billing_city'] = $rows->key_value;
              }
              elseif($rows->key_name == '_billing_postcode'){
                $user_address['_billing_postcode'] = $rows->key_value;
              }
              elseif($rows->key_name == '_shipping_title'){
                $user_address['_shipping_title'] = $rows->key_value;
              }
              elseif($rows->key_name == '_shipping_title'){
                $user_address['_shipping_title'] = $rows->key_value;
              }
              elseif($rows->key_name == '_shipping_first_name'){
                $user_address['_shipping_first_name'] = $rows->key_value;
              }
              elseif($rows->key_name == '_shipping_last_name'){
                $user_address['_shipping_last_name'] = $rows->key_value;
              }
              elseif($rows->key_name == '_shipping_company'){
                $user_address['_shipping_company'] = $rows->key_value;
              }
              elseif($rows->key_name == '_shipping_email'){
                $user_address['_shipping_email'] = $rows->key_value;
              }
              elseif($rows->key_name == '_shipping_phone'){
                $user_address['_shipping_phone'] = $rows->key_value;
              }
              elseif($rows->key_name == '_shipping_fax'){
                $user_address['_shipping_fax'] = $rows->key_value;
              }
              elseif($rows->key_name == '_shipping_country'){
                $user_address['_shipping_country'] = $rows->key_value;
              }
              elseif($rows->key_name == '_shipping_address_1'){
                $user_address['_shipping_address_1'] = $rows->key_value;
              }
              elseif($rows->key_name == '_shipping_address_2'){
                $user_address['_shipping_address_2'] = $rows->key_value;
              }
              elseif($rows->key_name == '_shipping_city'){
                $user_address['_shipping_city'] = $rows->key_value;
              }
              elseif($rows->key_name == '_shipping_postcode'){
                $user_address['_shipping_postcode'] = $rows->key_value;
              }
            }
          }
        }
        elseif($order_user['user_mode'] == 'login'){
          $get_data_by_user_id     =  get_user_account_details_by_user_id( $order_user['user_id'] ); 
          $get_array_shift_data    =  array_shift($get_data_by_user_id);
          $user_account_parse_data =  json_decode($get_array_shift_data['details']);
          
          if(!empty($user_account_parse_data) && !empty($user_account_parse_data->address_details)){
            $user_address['_billing_title'] = $user_account_parse_data->address_details->account_bill_title;
            $user_address['_billing_first_name'] = $user_account_parse_data->address_details->account_bill_first_name;
            $user_address['_billing_last_name'] = $user_account_parse_data->address_details->account_bill_last_name;
            $user_address['_billing_company'] = $user_account_parse_data->address_details->account_bill_company_name;
            $user_address['_billing_email'] = $user_account_parse_data->address_details->account_bill_email_address;
            $user_address['_billing_phone'] = $user_account_parse_data->address_details->account_bill_phone_number;
            $user_address['_billing_fax'] = $user_account_parse_data->address_details->account_bill_fax_number; 
            $user_address['_billing_country'] = $user_account_parse_data->address_details->account_bill_select_country; 
            $user_address['_billing_address_1'] = $user_account_parse_data->address_details->account_bill_adddress_line_1; 
            $user_address['_billing_address_2'] = $user_account_parse_data->address_details->account_bill_adddress_line_2; 
            $user_address['_billing_city'] = $user_account_parse_data->address_details->account_bill_town_or_city;
            $user_address['_billing_postcode'] = $user_account_parse_data->address_details->account_bill_zip_or_postal_code;
            
            $user_address['_shipping_title'] = $user_account_parse_data->address_details->account_shipping_title;
            $user_address['_shipping_first_name'] = $user_account_parse_data->address_details->account_shipping_first_name;
            $user_address['_shipping_last_name'] = $user_account_parse_data->address_details->account_shipping_last_name;
            $user_address['_shipping_company'] = $user_account_parse_data->address_details->account_shipping_company_name;
            $user_address['_shipping_email'] = $user_account_parse_data->address_details->account_shipping_email_address;
            $user_address['_shipping_phone'] = $user_account_parse_data->address_details->account_shipping_phone_number;
            $user_address['_shipping_fax'] = $user_account_parse_data->address_details->account_shipping_fax_number; 
            $user_address['_shipping_country'] = $user_account_parse_data->address_details->account_shipping_select_country; 
            $user_address['_shipping_address_1'] = $user_account_parse_data->address_details->account_shipping_adddress_line_1; 
            $user_address['_shipping_address_2'] = $user_account_parse_data->address_details->account_shipping_adddress_line_2; 
            $user_address['_shipping_city'] = $user_account_parse_data->address_details->account_shipping_town_or_city;
            $user_address['_shipping_postcode'] = $user_account_parse_data->address_details->account_shipping_zip_or_postal_code;
          }
        }
      }
    }
    
    return $user_address;
  }
  
  public static function check_sufficient_permission(){
    $currentAdminUserData = get_current_admin_user_info();
     
    if(count($currentAdminUserData) > 0){
      $get_role_data = get_roles_details_by_role_id( $currentAdminUserData['user_role_id'] );
      
      if(Request::is('admin/pages/list') && !in_array('pages_list_access', $get_role_data->permissions)){
        return false;
      }
      elseif(Request::is('admin/page/add') && !in_array('add_edit_delete_pages', $get_role_data->permissions)){
        return false;
      }
      elseif(Request::is('admin/blog/list') && !in_array('list_blogs_access', $get_role_data->permissions)){
        return false;
      }
      elseif((Request::is('admin/blog/add') || Request::is('admin/blog/update/*')) && !in_array('add_edit_delete_blog', $get_role_data->permissions)){
        return false;
      }
      elseif(Request::is('admin/blog/categories/list') && !in_array('blog_categories_access', $get_role_data->permissions)){
        return false;
      }
      elseif(Request::is('admin/blog/comments-list') && !in_array('blog_comments_list', $get_role_data->permissions)){
        return false;
      }
      elseif(Request::is('admin/testimonial/list') && !in_array('testimonial_list_access', $get_role_data->permissions)){
        return false;
      }
      elseif((Request::is('admin/testimonial/add') || Request::is('admin/testimonial/update/*')) && !in_array('add_edit_delete_testimonial', $get_role_data->permissions)){
        return false;
      }
      elseif(Request::is('admin/manufacturers/list') && !in_array('brands_list_access', $get_role_data->permissions)){
        return false;
      }
      elseif((Request::is('admin/manufacturers/add') || Request::is('admin/manufacturers/update/*')) && !in_array('add_edit_delete_brands', $get_role_data->permissions)){
        return false;
      }
      elseif(Request::is('admin/manage/seo') && !in_array('manage_seo_full', $get_role_data->permissions)){
        return false;
      }
      elseif(Request::is('admin/product/list/*') && !in_array('products_list_access', $get_role_data->permissions)){
        return false;
      }
      elseif((Request::is('admin/product/add') || Request::is('admin/product/update/*')) && !in_array('add_edit_delete_product', $get_role_data->permissions)){
        return false;
      }
      elseif(Request::is('admin/product/categories/list') && !in_array('product_categories_access', $get_role_data->permissions)){
        return false;
      }
      elseif(Request::is('admin/product/tags/list') && !in_array('product_tags_access', $get_role_data->permissions)){
        return false;
      }
      elseif((Request::is('admin/product/attributes/list')) && !in_array('product_attributes_access', $get_role_data->permissions)){
        return false;
      }
      elseif((Request::is('admin/product/colors/list')) && !in_array('product_colors_access', $get_role_data->permissions)){
        return false;
      }
      elseif((Request::is('admin/product/sizes/list')) && !in_array('product_sizes_access', $get_role_data->permissions)){
        return false;
      }
      elseif(Request::is('admin/product/comments-list') && !in_array('products_comments_list_access', $get_role_data->permissions)){
        return false;
      }
      elseif((Request::is('admin/orders') || Request::is('admin/orders/details/*') || Request::is('admin/orders/current-date')) && !in_array('manage_orders_list', $get_role_data->permissions)){
        return false;
      }
      elseif((Request::is('admin/reports') || Request::is('admin/reports/sales-by-product-title') || Request::is('admin/reports/sales-by-month') || Request::is('admin/reports/sales-by-last-7-days') || Request::is('admin/reports/sales-by-custom-days') || Request::is('admin/reports/sales-by-payment-method')) && !in_array('manage_reports_list', $get_role_data->permissions)){
        return false;
      }
      elseif(Request::is('admin/vendors/list') && !in_array('vendors_list_access', $get_role_data->permissions)){
        return false;
      }
      elseif(Request::is('admin/vendors/withdraw') && !in_array('vendors_withdraw_access', $get_role_data->permissions)){
        return false;
      }
      elseif(Request::is('admin/vendors/refund') && !in_array('vendors_refund_request_access', $get_role_data->permissions)){
        return false;
      }
      elseif(Request::is('admin/vendors/earning-reports') && !in_array('vendors_earning_reports_access', $get_role_data->permissions)){
        return false;
      }
      elseif(Request::is('admin/vendors/announcement/list') && !in_array('vendors_announcement_access', $get_role_data->permissions)){
        return false;
      }
      elseif(Request::is('admin/vendors/announcement') && !in_array('vendors_announcement_access', $get_role_data->permissions)){
        return false;
      }
      elseif(Request::is('admin/vendors/package/list') && !in_array('vendors_packages_list_access', $get_role_data->permissions)){
        return false;
      }
      elseif(Request::is('admin/vendors/package/create') && !in_array('vendors_packages_create_access', $get_role_data->permissions)){
        return false;
      }
      elseif(Request::is('admin/vendors/settings') && !in_array('vendor_settings', $get_role_data->permissions)){
        return false;
      }
      elseif((Request::is('admin/users/roles/list') || Request::is('admin/users/roles/add') || Request::is('admin/users/roles/update/*') || Request::is('admin/users/list') || Request::is('admin/user/add') || Request::is('admin/user/update/*') || Request::is('admin/user/profile')) && $get_role_data->slug != 'administrator'){
        return false;
      }
      elseif(Request::is('admin/shipping-method/options') && !in_array('manage_shipping_method_menu_access', $get_role_data->permissions)){
        return false;
      }
      elseif(Request::is('admin/shipping-method/flat-rate') && !in_array('manage_shipping_method_menu_access', $get_role_data->permissions)){
        return false;
      }
      elseif(Request::is('admin/shipping-method/free-shipping') && !in_array('manage_shipping_method_menu_access', $get_role_data->permissions)){
        return false;
      }
      elseif(Request::is('admin/shipping-method/local-delivery') && !in_array('manage_shipping_method_menu_access', $get_role_data->permissions)){
        return false;
      }
      elseif(Request::is('admin/payment-method/options') && !in_array('manage_payment_method_menu_access', $get_role_data->permissions)){
        return false;
      }
      elseif(Request::is('admin/payment-method/direct-bank') && !in_array('manage_payment_method_menu_access', $get_role_data->permissions)){
        return false;
      }
      elseif(Request::is('admin/payment-method/cash-on-delivery') && !in_array('manage_payment_method_menu_access', $get_role_data->permissions)){
        return false;
      }
      elseif(Request::is('admin/payment-method/paypal') && !in_array('manage_payment_method_menu_access', $get_role_data->permissions)){
        return false;
      }
      elseif(Request::is('admin/payment-method/stripe') && !in_array('manage_payment_method_menu_access', $get_role_data->permissions)){
        return false;
      }
      elseif((Request::is('admin/designer/clipart/categories/list') || Request::is('admin/designer/clipart/category/add') || Request::is('admin/designer/clipart/category/update/*') || Request::is('admin/designer/clipart/list') || Request::is('admin/designer/clipart/add') || Request::is('admin/designer/clipart/update/*') || Request::is('admin/designer/settings')) && !in_array('manage_designer_elements_menu_access', $get_role_data->permissions)){
        return false;
      }
      elseif((Request::is('admin/coupon-manager/coupon/add') || Request::is('admin/coupon-manager/coupon/update/*') || Request::is('admin/coupon-manager/coupon/list')) && !in_array('manage_coupon_menu_access', $get_role_data->permissions)){
        return false;
      }
      elseif((Request::is('admin/settings/general') || Request::is('admin/settings/languages') || Request::is('admin/settings/languages/update/*') || Request::is('admin/settings/appearance')) && !in_array('manage_settings_menu_access', $get_role_data->permissions)){
        return false;
      }
      elseif(Request::is('admin/customer/request-product') && !in_array('manage_requested_product_menu_access', $get_role_data->permissions)){
        return false;
      }
      elseif((Request::is('admin/subscription/custom') || Request::is('admin/subscription/mailchimp') || Request::is('admin/subscription/settings')) && !in_array('manage_subscription_menu_access', $get_role_data->permissions)){
        return false;
      }
      elseif(Request::is('admin/extra-features/product-compare-fields') && !in_array('manage_extra_features_access', $get_role_data->permissions)){
        return false;
      }
      else{
        return true;
      }
    }
  }
  
  public static function frontend_user_logged_in(){
    $is_logged_in = false;
    
    if(Session::has('shopist_frontend_user_id')){
      $is_logged_in = true;
    }
    
    return $is_logged_in;
  }
  
  public static function stripe_api_key(){
    $_this  =  new self;
    $payment_method = $_this->payment;
    $stripe_api_key = array('secret_key' => '', 'publishable_key' => '');
    
    if(count($payment_method) > 0 && isset($payment_method['stripe'])){
      if($payment_method['stripe']['stripe_test_enable_option'] == 'yes'){
        $stripe_api_key['secret_key'] =  $payment_method['stripe']['test_secret_key'];
        $stripe_api_key['publishable_key'] =  $payment_method['stripe']['test_publishable_key'];
      }
      else{
        $stripe_api_key['secret_key'] =  $payment_method['stripe']['live_secret_key'];
        $stripe_api_key['publishable_key'] =  $payment_method['stripe']['live_publishable_key'];
      }
    }
    
    return $stripe_api_key;
  }
  
  public static function twocheckout_api_data(){
    $_this  =  new self;
    $payment_method = $_this->payment;
    $twocheckout_api_data = array('sellerId' => '', 'publishableKey' => '', 'privateKey' => '', 'sandbox_enable_option' => '');
    
    if(count($payment_method) > 0 && isset($payment_method['2checkout'])){
      $twocheckout_api_data['sellerId'] = $payment_method['2checkout']['sellerId'];
      $twocheckout_api_data['publishableKey'] = $payment_method['2checkout']['publishableKey'];
      $twocheckout_api_data['privateKey'] = $payment_method['2checkout']['privateKey'];
      $twocheckout_api_data['sandbox_enable_option'] = $payment_method['2checkout']['sandbox_enable_option'];
    }
    
    return $twocheckout_api_data;
  }
  
  public static function recaptcha_data(){
    $recaptcha_data = array();
    $_this  =  new self;
    $settings_data = $_this->settingsData; 
    
    if(!empty($settings_data)){
      $recaptcha_data = $settings_data['general_settings']['recaptcha_options'];
    }
    
    return $recaptcha_data;
  }
  
  public static function nexmo_data(){
    $nexmo_data = array();
    $_this  =  new self;
    $settings_data = $_this->settingsData; 
    
    if(!empty($settings_data) && isset($settings_data['general_settings']['nexmo_config_option'])){
      $nexmo_data = $settings_data['general_settings']['nexmo_config_option'];
    }
    
    return $nexmo_data;
  }
		
		public static function create_string_encode($str){
				$encode = htmlentities($str, ENT_QUOTES | ENT_IGNORE, "UTF-8");
				return $encode;
  }
		
		public static function create_string_decode($str){
				$decode = html_entity_decode($str, ENT_QUOTES | ENT_IGNORE, "UTF-8");
				return $decode;
  }
  
  public static function placeholder_img_src(){
    return asset('public/images/no-image.png');
  }
  
  public static function avatar_img_src(){
    return asset('public/images/avatar.jpg');
  }

  public static function upload_sample_img_src(){
    return asset('public/images/upload.png');
  }
  
  public static function vendor_cover_img_src(){
    return asset('public/images/vendor-cover-placeholder.jpg');
  }
  
  public static function role_based_pricing_by_product_id($product_id){
    $pricing_data = array();
    $get_is_role_based_pricing_enable  =  ProductExtra::where(['product_id' => $product_id, 'key_name' => '_is_role_based_pricing_enable'])->first();
    $get_role_based_pricing  =  ProductExtra::where(['product_id' => $product_id, 'key_name' => '_role_based_pricing'])->first();

    if(!empty($get_is_role_based_pricing_enable)){
      $pricing_data['is_enable'] = $get_is_role_based_pricing_enable->key_value;
    }
    else{
      $pricing_data['is_enable'] = null;
    }

    if(!empty($get_role_based_pricing)){
      $pricing_data['pricing'] = unserialize($get_role_based_pricing->key_value);
    }
    else{
      $pricing_data['pricing'] = array();
    }

    return $pricing_data;
  }
  
  public static function role_based_price_by_product_id( $product_id, $price ){
    $_this  =  new self;
    $final_price = 0;
    $get_pricing = $_this-> role_based_pricing_by_product_id( $product_id );
    $get_current_user_data  =  get_current_frontend_user_info();
    
    if(is_frontend_user_logged_in() && isset($get_current_user_data['user_role_slug']) && $get_pricing['is_enable'] == 'yes'){
      if(isset($get_pricing['pricing'][$get_current_user_data['user_role_slug']])){
        $regular_price = $get_pricing['pricing'][$get_current_user_data['user_role_slug']]['regular_price'];
        $sale_price    = $get_pricing['pricing'][$get_current_user_data['user_role_slug']]['sale_price'];
        
        if(isset($regular_price) && $regular_price && isset($sale_price) && $sale_price && $regular_price > $sale_price){
          $final_price = $sale_price;
        }
        elseif(isset($regular_price) && $regular_price){
          $final_price = $regular_price;
        }
      }
    }
    else{
      $final_price = $price;
    }
    
    return $final_price;
  } 
  
  public static function currency_convert_value($from_currency, $to_currency, $amount){
    $_this  =  new self;
    $price = 0;
    $results = $_this->classCommonFunction->convertCurrency($from_currency, $to_currency, $amount);
   
    if(!is_null($results)){
      $price =  $results;
    }
    
    return $price;
  }
  
  public static function download_files( $post_id ){
    $_this  =  new self;
    $get_product_data = $_this->product->getProductDataById( $post_id );
		$download_files = array();
     
    if(isset($get_product_data['post_type']) && $get_product_data['post_type']== 'product_variation'){
      $get_product_data['_downloadable_product_data'] = unserialize($get_product_data['_downloadable_product_data']);
    }
    
    if(isset($get_product_data['post_type']) && $get_product_data['post_type']== 'product_variation'){
      if(count($get_product_data['_downloadable_product_data']) > 0){
        $download_files['downloadable_files'] = $get_product_data['_downloadable_product_data'];
      }
    }
    else{
      if(count($get_product_data['_downloadable_product_files']) > 0){
        $download_files['downloadable_files'] = $get_product_data['_downloadable_product_files'];
      }
    }
    
    if(isset($get_product_data['_downloadable_product_download_limit'])){
      $download_files['downloadable_product_download_limit'] = $get_product_data['_downloadable_product_download_limit'];
    }
    else{
      $download_files['downloadable_product_download_limit'] = $get_product_data['_downloadable_limit'];
    }
    
    if(isset($get_product_data['_downloadable_product_download_expiry'])){
      $download_files['downloadable_product_download_expiry'] = $get_product_data['_downloadable_product_download_expiry'];
    }
    else{
      $download_files['downloadable_product_download_expiry'] = $get_product_data['_download_expiry'];
    }
    
    return $download_files;
  }
  
  public static function create_download_files_html( $post_id, $data, $order_id ){
    $_this  =  new self;
    $validation = $_this->classCommonFunction->checkDownloadRequired( $data, $order_id );
    $str = '';
    
    if($validation){
      if(isset($data['downloadable_files']) && count($data['downloadable_files']) > 0){
        foreach($data['downloadable_files'] as $key => $files){
          $str .= '<div>'. Lang::get('frontend.downloadable_file_label') .': <a target="_blank" href="'. route('downloadable-product-download', [$post_id, $order_id, $key, 'uploaded_file_url']) .'">' .$files['file_name'] .'</a></div>';
        }
      }
    }
    
    echo $str;
  }
  
  public static function ip_address(){
    return Request::ip();
  }
  
  public static function create_image_url($img_path){
    if(!empty($img_path)){
      return url('/') . $img_path;
    }
    else{
      return '';
    } 
  }
  
  public static function upsell_products($product_id){
    $upsell_products = array();
    $get_upsell_products = ProductExtra::where(['product_id' => $product_id, 'key_name' => '_upsell_products'])->first();
    
    if(!empty($get_upsell_products)){
      $upsell_products = unserialize($get_upsell_products->key_value);
    }
    
    return $upsell_products;
  }
  
  public static function crosssell_products($product_id){
    $crosssell_products = array();
    $get_crosssell_products = ProductExtra::where(['product_id' => $product_id, 'key_name' => '_crosssell_products'])->first();
    
    if(!empty($get_crosssell_products)){
      $crosssell_products = unserialize($get_crosssell_products->key_value);
    }
    
    return $crosssell_products;
  }
  
  public static function users_by_role_id($role_id, $extra_search_term = null, $flag = null){
    if(($flag == -1) || is_null($flag)){
        $where = ['role_user.role_id' => $role_id];
    }
    else{
        $where = ['role_user.role_id' => $role_id, 'users.user_status' => $flag ];
    }
				
    if(!is_null($extra_search_term) || !empty($extra_search_term)){
      $get_users = DB::table('users')
                   ->where($where)
                   ->where('users.name', 'LIKE', '%'. $extra_search_term. '%')
                   ->join('role_user', 'users.id', '=', 'role_user.user_id')
                   ->join('users_details', 'users.id', '=', 'users_details.user_id')
                   ->select('users.*', 'users_details.details')
                   ->orderBy('users.id', 'desc')
                   ->get()
                   ->toArray();
    }
    else{
      $get_users = DB::table('users')
                   ->where($where)
                   ->join('role_user', 'users.id', '=', 'role_user.user_id')
                   ->leftJoin('users_details', 'users.id', '=', 'users_details.user_id')
                   ->select('users.*', 'users_details.details')
                   ->orderBy('users.id', 'desc')
                   ->get()
                   ->toArray();
    }
    
    return $get_users;
  }
  
  public static function check_vendor_login(){
    $_this = new self;
    $get_data = $_this->current_admin_user_info();
    
    if(!empty($get_data) && count($get_data) > 0 && isset($get_data['user_role_slug']) && $get_data['user_role_slug'] == 'vendor'){
      return true;
    }
    else{
      return false;
    }
  }
  
  public static function check_admin_login(){
    $_this = new self;
    $get_data = $_this->current_admin_user_info();
    
    if(!empty($get_data) && count($get_data) > 0 && isset($get_data['user_role_slug']) && $get_data['user_role_slug'] == 'administrator'){
      return true;
    }
    else{
      return false;
    }
  }
  
  public static function vendor_details_by_product_id($product_id){
    $vendor_final = array();
    $get_author_id  = Product::where(['id' => $product_id])->first();
   
    if(!empty($get_author_id)){
      $get_role_id = RoleUser::where(['user_id' => $get_author_id->author_id])->first();
      
      if(!empty($get_role_id)){
        $get_vendor_details = get_roles_details_by_role_id($get_role_id->role_id);
        
        if(!empty($get_vendor_details) && $get_vendor_details->slug == 'vendor'){
          $vendor_details = get_user_details( $get_author_id->author_id );
          $get_account_details = get_user_account_details_by_user_id( $get_author_id->author_id );
          $vendor_final = array_merge($vendor_details,  array_shift($get_account_details));
        }
      }
    }
    
    return $vendor_final;
  }
  
  public static function vendor_name_by_product_id($product_id){
    $vendor_name = '';
    $get_author_id  = Product::where(['id' => $product_id])->first();
    
    if(!empty($get_author_id)){
      $get_role_id = RoleUser::where(['user_id' => $get_author_id->author_id])->first();
      
      if(!empty($get_role_id)){
        $get_vendor_details = get_roles_details_by_role_id($get_role_id->role_id);
        
        if(!empty($get_vendor_details) && $get_vendor_details->slug == 'vendor'){
          $vendor_details = get_user_details( $get_author_id->author_id );
          $vendor_name = '<a target="_blank" href="'. route('store-details-page-content', $vendor_details['user_name']).'"><i>'. $vendor_details['user_name'] .'</i></a>';
        }
      }
    }
    
    return $vendor_name;
  }
  
  public static function vendor_id_by_product_id($product_id){
    $vendor_id = null;
    $get_author_id  = Product::where(['id' => $product_id])->first();
    
    if(!empty($get_author_id)){
      $get_role_id = RoleUser::where(['user_id' => $get_author_id->author_id])->first();
      
      if(!empty($get_role_id)){
        $get_vendor_details = get_roles_details_by_role_id($get_role_id->role_id);
        
        if(!empty($get_vendor_details) && $get_vendor_details->slug == 'vendor'){
          $vendor_id = $get_author_id->author_id;
        }
      }
    }
    
    return $vendor_id;
  }
  
  public static function author_total_products($author_id){
    $total_products = 0;
    $get_author_id  = Product::where(['author_id' => $author_id])->get()->toArray();
    
    if(is_array($get_author_id) && count($get_author_id) > 0){
      $total_products = count($get_author_id);
    }
    
    return $total_products;
  }
  
  public static function vendor_name( $author_id ){
    $vendor_name = '';
    $get_user = get_user_details($author_id);
    
    if(count($get_user) > 0 && isset($get_user['user_name'])){
      $vendor_name = $get_user['user_name'];
    }
    
    return $vendor_name;
  }
  
  public static function check_vendor_product_exist_in_cart_object( $cart_object ){
    $is_exist = false;
    if(!empty($cart_object)){
      foreach($cart_object as $item){
        $get_details = get_vendor_details_by_product_id($item->id);
        
        if(count($get_details) > 0 && isset($get_details['user_role_slug']) && $get_details['user_role_slug'] == 'vendor'){
          $is_exist = true;
          break;
        }
      }
    }
    
    return $is_exist;
  }
  
  public static function sub_order_by_order_id( $order_id ){
    $sub_order_data = array();
    $get_sub_order = Post::where(['parent_id' => $order_id, 'post_type' => 'shop_order'])->get()->toArray();
    
    if(count($get_sub_order) > 0){
      $sub_order_data = $get_sub_order;
    }
    
    return $sub_order_data;
  }
  
  public static function sub_order_total_by_order_id( $order_id ){
    $total = 0;
    $get_total = PostExtra::where(['post_id' => $order_id, 'key_name' => '_sub_order_total'])->first();
    
    if(!empty($get_total)){
      $total = $get_total->key_value;
    }
    
    return $total;
  }
  
  public static function sub_order_process_key_by_order_id( $order_id ){
    $process_key = 0;
    $get_process_key = PostExtra::where(['post_id' => $order_id, 'key_name' => '_order_process_key'])->first();
    
    if(!empty($get_process_key)){
      $process_key = $get_process_key->key_value;
    }
    
    return $process_key;
  }
  
  public static function vendor_name_by_order_id($order_id){
    $vendor_name = '';
    $get_post = Post::where(['id' => $order_id])->first();
    
    if(!empty($get_post)){
      $get_role_id = RoleUser::where(['user_id' => $get_post->post_author_id])->first();
      
      if(!empty($get_role_id)){
        $get_vendor_details = get_roles_details_by_role_id($get_role_id->role_id);
        
        if(!empty($get_vendor_details) && $get_vendor_details->slug == 'vendor'){
          $vendor_details = get_user_details( $get_post->post_author_id );
          $vendor_name = '<a target="_blank" href="'. route('store-details-page-content', $vendor_details['user_name']).'"><i>'. $vendor_details['user_name'] .'</i></a>';
        }
      }
    }
    
    return $vendor_name;
  }
    
  public static function vendor_sub_order_by_order_id($order_id){
    $sub_orders = array();
    $get_post = Post::where(['parent_id' => $order_id, 'post_type' => 'shop_order'])->get()->toArray();
    
    if(count($get_post) > 0){
     $sub_orders = $get_post;
    }
  
    return $sub_orders;
  }
  
  public static function vendor_withdraw_by_user_and_status($user_id, $status){
    $vendor_withdraw_request = null;
    $get_vendor_withdraw_request = VendorWithdraw::where(['user_id' => $user_id, 'status' => $status])->first();
   
    if(!empty($get_vendor_withdraw_request)){
      $vendor_withdraw_request = $get_vendor_withdraw_request;
    }
    
    return $vendor_withdraw_request;
  }
  
  public static function author_id_by_product_id($product_id){
    $author_id = null;
    $get_post = Product::where(['id' => $product_id])->first();
    
    if(!empty($get_post)){
      $author_id = $get_post->author_id; 
    }
    
    return $author_id;
  }
  
  public static function package_details_by_vendor_id($vendor_id){
    $package_details = null;
    $get_details = get_user_account_details_by_user_id( $vendor_id );
    
    if(count($get_details) > 0){
      $details  = array_shift($get_details);
      $get_details = json_decode($details['details']);
      
      if(isset($get_details->package) || !empty($get_details->package)){
        $get_selected_package = $get_details->package->package_name;

        if(!empty($get_selected_package)){
          $get_package_details = VendorPackage::where(['id' => $get_selected_package])->first();

          if(!empty($get_package_details) && !is_null($get_package_details)){
            $package_details = json_decode($get_package_details->options);
          }
        }
      }
    }
    
    return $package_details;
  }
  
  public static function check_is_vendor_expired($vendor_id){
    $_this = new self;
    $is_expired = false;
    $today = date("Y-m-d");
    
    $get_package_details = $_this->package_details_by_vendor_id($vendor_id);
    
    if(!empty($get_package_details) && $get_package_details->vendor_expired_date_type == 'custom_date' && $today > $get_package_details->vendor_custom_expired_date){
      $is_expired = true;
    }
    
    return $is_expired;
  }
  
  public static function payment_details_by_vendor_id($vendor_id){
    $vendor_details = null;
    $get_vendor_details = get_user_account_details_by_user_id($vendor_id);
    
    if(count($get_vendor_details) > 0){
      $vendor_details = array_shift($get_vendor_details);
      $vendor_details = json_decode($vendor_details['details']);
    }
    
    return $vendor_details->payment_method;
  }
  
  public static function user_name_by_user_id($user_id){
    $user_name = null;
    $get_user = User::where(['id' => $user_id])->first();
    if(!empty($get_user)){
      $user_name = $get_user->name;
    }
    
    return $user_name;
  }
  
  public static function vendor_settings_data(){
    $_this = new self;
    $get_settings = $_this->option->getVendorSettingsData();
    
    return $get_settings;
  }
  
  public static function emails_option_data(){
    $_this = new self;
    $get_options = $_this->option->getEmailsNotificationsData();
    
    return $get_options;
  }
  
  public static function variation_exist_in_combination($product_id, $combination){
    $combination_ary = array();
    $_this = new self;
    $is_combination_exist = false;
    
    $get_product_variations = Post::where(['parent_id' => $product_id, 'post_type' => 'product_variation'])->get()->toArray();
    if(count($get_product_variations) > 0){
      foreach($get_product_variations as $row){
        $get_post_meta = $_this->product->get_post_meta($row['id'], '_variation_post_data');
        
        if(!empty($get_post_meta)){
          $json_parse = json_decode($get_post_meta->key_value);
          
          if(count($json_parse) > 0){
            foreach($json_parse as $val){
              $combination_ary[] = array(string_slug_format($val->attr_name), string_slug_format($val->attr_val));
            }
          }
        }
      }
    }
    
    if(count($combination_ary) > 0){
      foreach($combination_ary as $com_val){
        if($com_val == $combination){
          $is_combination_exist = true;
        }
      }
    }
    
    return $is_combination_exist;
  }
  
  public static function settings_data(){
    $settings_data = array();
    $_this  =  new self;
    $settings_data = $_this->settingsData;
    
    if(isset($settings_data['general_settings']) && count($settings_data['general_settings']) >0){
      $settings_data = $settings_data['general_settings'];
    }
    
    return $settings_data;
  }
  
  public static function post_extra($post_id, $key_name){
    $data = '';
    $get_post_extra = PostExtra::where(['post_id' => $post_id, 'key_name' => $key_name])->first();
    if(!empty($get_post_extra)){
      $data = $get_post_extra->key_value;
    }
    
    return $data;
  }
  
  public static function permission_menu_heading($heading_slug){
    $user_permission_list = array();
    $get_user_data = get_current_admin_user_info();
    $get_role_data = get_roles_details_by_role_id( $get_user_data['user_role_id'] );
    
    if(!empty($get_role_data)){
      $user_permission_list  =  $get_role_data->permissions;
    }
    
    if($heading_slug == 'cms'){
      if((in_array('pages_list_access', $user_permission_list)) || (in_array('add_edit_delete_pages', $user_permission_list)) || (in_array('list_blogs_access', $user_permission_list)) || (in_array('add_edit_delete_blog', $user_permission_list)) ||(in_array('blog_categories_access', $user_permission_list)) || (in_array('blog_comments_list', $user_permission_list)) || (in_array('testimonial_list_access', $user_permission_list)) || (in_array('add_edit_delete_testimonial', $user_permission_list)) || (in_array('brands_list_access', $user_permission_list)) || (in_array('add_edit_delete_brands', $user_permission_list)) || (in_array('manage_seo_full', $user_permission_list))){ return true; }
      else{ return false; }
    }
    elseif ($heading_slug == 'sales') {
      if((in_array('products_list_access', $user_permission_list)) || (in_array('add_edit_delete_product', $user_permission_list)) || (in_array('product_categories_access', $user_permission_list)) || (in_array('product_tags_access', $user_permission_list)) || (in_array('product_attributes_access', $user_permission_list)) || (in_array('product_colors_access', $user_permission_list)) || (in_array('product_sizes_access', $user_permission_list)) || (in_array('products_comments_list_access', $user_permission_list)) || (in_array('manage_orders_list', $user_permission_list)) || (in_array('manage_reports_list', $user_permission_list))){ return true; }
      else{ return false; }
    }
    elseif ($heading_slug == 'vendors') {
      if((in_array('vendors_list_access', $user_permission_list)) || (in_array('vendors_withdraw_access', $user_permission_list)) || (in_array('vendors_earning_reports_access', $user_permission_list)) || (in_array('vendors_announcement_access', $user_permission_list)) || (in_array('vendor_settings', $user_permission_list)) || (in_array('vendors_packages_list_access', $user_permission_list)) || (in_array('vendors_packages_create_access', $user_permission_list))){ return true; }
      else{ return false; }
    }
    elseif ($heading_slug == 'config') {
      if((in_array('manage_shipping_method_menu_access', $user_permission_list)) || (in_array('manage_payment_method_menu_access', $user_permission_list)) || (in_array('manage_designer_elements_menu_access', $user_permission_list)) || (in_array('manage_coupon_menu_access', $user_permission_list)) || (in_array('manage_settings_menu_access', $user_permission_list))){ return true; }
      else{ return false; }
    }
    elseif ($heading_slug == 'features') {
      if((in_array('manage_requested_product_menu_access', $user_permission_list)) || (in_array('manage_subscription_menu_access', $user_permission_list)) || (in_array('manage_extra_features_access', $user_permission_list))){ return true; }
      else{ return false; }
    }
  }
  
  public static function vendor_id_by_order_id( $order_id ){
    $vendor_id = 0;
    $get_vendor_order = VendorOrder::where(['order_id' => $order_id])->first();
    if(!empty($get_vendor_order)){
      $vendor_id = $get_vendor_order->vendor_id;
    }
    
    return $vendor_id;
  }
}