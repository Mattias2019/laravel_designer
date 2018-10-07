<?php
namespace shopist\Http\Controllers;

use shopist\Http\Controllers\Controller;
use shopist\Library\CommonFunction;
use shopist\Models\Product;
use shopist\Models\Post;
use shopist\Models\PostExtra;
use Carbon\Carbon;
use Session;
use Validator;
use Request;
use shopist\Http\Controllers\VendorsController;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Input;
use shopist\Library\GetFunction;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class AdminDashboardContentController extends Controller{
  public $carbonObject;
  public $vendors;
  public $classGetFunction;
  public $env;
  
  public function __construct(){
    $this->carbonObject = new Carbon();
    $this->vendors  = new VendorsController();
    $this->classGetFunction  =  new GetFunction();
    $this->env = App::environment();
  }
  /**
  * admin dashboard content
  *
  * @param null
  * @return response view
  */
  public function dashboardContent(){
    $data = array();
    $dashboard             = array();
    $last2DaysData         = array();
    $last2DaysProductsData = array();
    $todaysTotal           = 0;
    
    $common_obj  = new CommonFunction();
    $data = $common_obj->commonDataForAllPages();
    
    if(is_vendor_login() && Session::has('shopist_admin_user_id')){
      $totalProducts = Product::where(['author_id' => Session::get('shopist_admin_user_id')])->get();
    }
    else{
      $totalProducts = Product::get();
    }

    if(is_vendor_login() && Session::has('shopist_admin_user_id')){
      $todayOrders  =  DB::table('posts')
                       ->whereDate('posts.created_at', '=', $this->carbonObject->today()->toDateString())
                       ->where(['posts.post_type' => 'shop_order', 'posts.parent_id' => 0, 'vendor_orders.vendor_id' => Session::get('shopist_admin_user_id')])
                       ->join('vendor_orders', 'posts.id', '=', 'vendor_orders.order_id')
                       ->select('posts.*') 
                       ->get();
    }
    else{
      $todayOrders  =  Post::whereDate('created_at', '=', $this->carbonObject->today()->toDateString())
                       ->where(['post_type' => 'shop_order', 'parent_id' => 0])
                       ->get();
    }

    if(is_vendor_login() && Session::has('shopist_admin_user_id')){
      $totalOrders  =  DB::table('posts')
                       ->where(['posts.post_type' => 'shop_order', 'posts.parent_id' => 0, 'vendor_orders.vendor_id' => Session::get('shopist_admin_user_id')])
                       ->join('vendor_orders', 'posts.id', '=', 'vendor_orders.order_id')
                       ->select('posts.*') 
                       ->get();
    }
    else{
      $totalOrders  =  Post::where(['post_type' => 'shop_order', 'parent_id' => 0])
                       ->get();
    }

    if(is_vendor_login() && Session::has('shopist_admin_user_id')){
      $last2DaysOrders  =  DB::table('posts')
                           ->whereBetween('posts.created_at', array($this->carbonObject->yesterday()->toDateString(), $this->carbonObject->today()->toDateString().' 23:59:59')) 
                           ->where(['posts.post_type' => 'shop_order', 'posts.parent_id' => 0, 'vendor_orders.vendor_id' => Session::get('shopist_admin_user_id')])
                           ->join('vendor_orders', 'posts.id', '=', 'vendor_orders.order_id')
                           ->select('posts.*') 
                           ->orderBy('posts.created_at', 'DESC')
                           ->get();
    }
    else{
      $last2DaysOrders  =  Post::whereBetween('created_at', array($this->carbonObject->yesterday()->toDateString(), $this->carbonObject->today()->toDateString().' 23:59:59'))
                           ->where(['post_type' => 'shop_order', 'parent_id' => 0])
                           ->orderBy('created_at', 'DESC')
                           ->get();
    }

    if(is_vendor_login() && Session::has('shopist_admin_user_id')){
      $lastProducts  =  DB::table('products')
                        ->whereBetween('created_at', array($this->carbonObject->yesterday()->toDateString(), $this->carbonObject->today()->toDateString().' 23:59:59'))
                        ->where(['author_id' => Session::get('shopist_admin_user_id')])
                        ->orderBy('created_at', 'DESC')
                        ->take(5)
                        ->get();
    }
    else{
      $lastProducts  =  Product::whereBetween('created_at', array($this->carbonObject->yesterday()->toDateString(), $this->carbonObject->today()->toDateString().' 23:59:59'))
                        ->orderBy('created_at', 'DESC')
                        ->take(5)
                        ->get();
    }


    if($totalProducts && $totalProducts->count() > 0){
      $dashboard['total_products'] = $totalProducts->count();
    }
    else{
      $dashboard['total_products'] = 0;
    }

    if($todayOrders && $todayOrders->count() > 0){
      $dashboard['today_orders'] = $todayOrders->count();

      foreach($todayOrders as $rows){
        $get_order_total = PostExtra::where(['post_id' => $rows->id, 'key_name' => '_order_total'])->first();

        if(!empty($get_order_total->key_value)){
          $todaysTotal += $get_order_total->key_value;
        }
      }
      $dashboard['today_totals_sales'] = $todaysTotal;
    }
    else{
      $dashboard['today_orders'] = 0;
      $dashboard['today_totals_sales'] = $todaysTotal;
    }

    if($totalOrders && $totalOrders->count() > 0){
      $dashboard['total_orders'] = $totalOrders->count();
    }
    else{
      $dashboard['total_orders'] = 0;
    }

    if($last2DaysOrders && $last2DaysOrders->count() > 0){
      foreach($last2DaysOrders as $rows){
        $order_data = array();
        $order_data['order_id']       =   $rows->id;
        $order_data['order_date']     =   $this->carbonObject->parse($rows->created_at)->toDayDateTimeString();

        $order_status                 =   PostExtra::where(['post_id' => $rows->id, 'key_name' => '_order_status'])->first();
        if(!empty($order_status->key_value)){
          $order_data['order_status'] =   $order_status->key_value;
        }

        $order_total                  =   PostExtra::where(['post_id' => $rows->id, 'key_name' => '_order_total'])->first();
        if(!empty($order_total->key_value)){
          $order_data['order_totals'] =   $order_total->key_value;
        }
        else{
          $order_data['order_totals'] =   0;
        }

        $order_currency               =   PostExtra::where(['post_id' => $rows->id, 'key_name' => '_order_currency'])->first();
        if(!empty($order_currency->key_value)){
          $order_data['order_currency'] =   $order_currency->key_value;
        }

        array_push($last2DaysData, $order_data);
      }

      $dashboard['latest_orders'] = $last2DaysData;
    }
    else{
    $dashboard['latest_orders'] = array();
    }

    if($lastProducts && $lastProducts->count() > 0){
      foreach($lastProducts as $rows){
        $products_data = array();
        $products_data['id'] = $rows->id;

        if(!empty(get_product_image($rows->id))){
          $products_data['img_url'] = get_image_url( get_product_image($rows->id) );
        }
        else{
          $products_data['img_url'] = default_placeholder_img_src();
        }

        $products_data['title'] = $rows->title;
        
        if(get_product_type($rows->id) == 'simple_product'){
          $products_data['price'] = get_current_currency_symbol().get_product_price( $rows->id );
        }
        elseif (get_product_type($rows->id) == 'configurable_product') {
          $products_data['price'] = get_product_variations_min_to_max_price_html(get_current_currency_symbol(), $rows->id);
        }
        elseif ((get_product_type($rows->id) == 'customizable_product') || (get_product_type($rows->id) == 'downloadable_product')) {
          if(count(get_product_variations($rows->id))>0){  
            $products_data['price'] = get_product_variations_min_to_max_price_html(get_current_currency_symbol(), $rows->id);
          }
          else{  
            $products_data['price'] = get_current_currency_symbol().get_product_price( $rows->id );
          }
        }
        else{
          $products_data['price'] = 0;
        }

        $products_data['description'] = $rows->content;

        array_push($last2DaysProductsData, $products_data);
      }

      $dashboard['latest_products'] = $last2DaysProductsData;
    }
    else{
      $dashboard['latest_products'] = array();
    }

    $all_vendors			 =  $this->vendors->getAllVendors( false, null, -1);
    $active_vendors		 =  $this->vendors->getAllVendors( false, null, 1 );
    $pending_vendors   =  $this->vendors->getAllVendors( false, null, 0 );

    $dashboard['total_vendors']			= count($all_vendors);
    $dashboard['active_vendors']		= count($active_vendors);
    $dashboard['pending_vendors']   = count($pending_vendors);

    $dashboard['total_completed'] = count($this->vendors->getVendorWithdrawRequestDataAll('COMPLETED'));
    $dashboard['total_cancelled'] = count($this->vendors->getVendorWithdrawRequestDataAll('CANCELLED'));
    $dashboard['total_pending']   = count($this->vendors->getVendorWithdrawRequestDataAll('ON_HOLD'));


    $dashboard['dashbord_announcement']	 =  $this->vendors->getTopThreeVendorAnnouncementByVendorId( Session::get('shopist_admin_user_id') );

    //overview chart
    $start_date   =  date('Y-m-01');
    $current_date =  date('Y-m-d');

    $dashboard['overview_reports'] =  $this->vendors->getVendorReportsDataForDay(array('target' => 'day', 'start_date'=> $start_date, 'current_date' => $current_date));
    $dashboard['overview_reports_log'] =  $this->vendors->getVendorReportsDayLog(array('target' => 'day', 'start_date'=> $start_date, 'current_date' => $current_date));

    $order_total = 0;
    $total_earning = 0;
    if(count($dashboard['overview_reports_log']) > 0){
      foreach($dashboard['overview_reports_log'] as $report){
        $order_total += $report->order_total;
        $total_earning += ((float)$report->order_total - (float)$report->net_amount);
      }
    }

    $dashboard['overview_reports_total_details'] = array('number_of_order' => $dashboard['overview_reports_log']->count(), 'order_total' => price_html($order_total), 'total_earning' => price_html($total_earning));
    //overview chart end

    $data['dashboard_data'] = $dashboard;
    
    return view('pages.admin.dashboard-content', $data);
  }
  
  /**
   * 
   * Manage quick mail
   *
   * @param null
   * @return void
   */
  public function sendQuickMail(){
    if( Request::isMethod('post') && Session::token() == Input::get('_token') ){
      $input = Input::all();
      $rules = [
               'quickemailto'                  =>  'required',
               'quickmailsubject'              =>  'required',
               'quickmailbody'                 =>  'required',
               ];
      
      $validator = Validator:: make($input, $rules);
      
      if($validator->fails()){
        return redirect()-> back()
        ->withInput()
        ->withErrors( $validator );
      }
      else{
        $mailData = array();

        //load mailData Array
        $mailData['source']  =  'quick_mail';
        $mailData['data']    =   array('_mail_to' => Input::get('quickemailto'), '_subject' => Input::get('quickmailsubject'), '_message' => Input::get('quickmailbody'));
        
        if($this->env === 'production'){
          $this->classGetFunction->sendCustomMail( $mailData );
          Session::flash('success-message', Lang::get('admin.mail_sent_msg'));
        }
        
        return redirect()->back();
      }
    }
    else {
      return redirect()-> back();
    }
  }
}