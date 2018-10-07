<?php
namespace shopist\Http\Controllers;

use shopist\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Input;
use shopist\Models\UsersDetail;
use shopist\Models\User;
use shopist\Models\Post;
use shopist\Models\PostExtra;
use shopist\Models\VendorAnnouncement;
use shopist\Models\Comment;
use shopist\Models\VendorPackage;
use shopist\Models\VendorWithdraw;
use shopist\Models\VendorTotal;
use shopist\Models\Option;
use Illuminate\Support\Facades\Lang;
use Validator;
use Request;
use Session;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use shopist\Library\GetFunction;
use Illuminate\Support\Facades\App;
use shopist\Library\CommonFunction;



class VendorsController extends Controller
{
  public $carbonObject;
  public $option;
  public $env;
  public $classCommonFunction;


  public function __construct(){
		$this->carbonObject = new Carbon();
    $this->option  =  new OptionController();
    $this->classCommonFunction = new CommonFunction();
    $this->env = App::environment();
	}
  
  /**
   * 
   * Vendor list content
   *
   * @param null
   * @return response view
   */
  public function vendorListContent(){
    $data = array();
    $search_value = '';
    
    if(isset($_GET['term_vendors']) && $_GET['term_vendors'] != ''){
      $search_value = $_GET['term_vendors'];
    }
      
    $data = $this->classCommonFunction->commonDataForAllPages();
    $data['vendors_list_data']   =   $this->getAllVendors( true, $search_value, -1 );
    $data['search_value']        =   $search_value;

    $data['vendor_all']      = "class=active";
    $data['vendor_active']   = '';
    $data['vendor_pending']  = '';
     
    return view('pages.admin.vendors.vendors-list', $data);
  }
  
  /**
   * 
   * Vendor status content
   *
   * @param null
   * @return response view
   */
  public function vendorStatusContent(){
    $data = array();
    $search_value = '';
    
    if(isset($_GET['term_vendors']) && $_GET['term_vendors'] != ''){
      $search_value = $_GET['term_vendors'];
    }
      
    $data = $this->classCommonFunction->commonDataForAllPages();
    $data['vendor_all']      = '';
    $data['vendor_active']   = '';
    $data['vendor_pending']  = '';
    $data['search_value']  =   $search_value;
    
    if(Request::is('admin/vendors/list/active')){
      $data['vendor_active']      =  "class=active";
      $data['vendors_list_data']  =  $this->getAllVendors( true, $search_value, 1);
    }
    elseif(Request::is('admin/vendors/list/pending')){
      $data['vendor_pending']     =  "class=active";
      $data['vendors_list_data']  =  $this->getAllVendors( true, $search_value, 0);
    } 
     
    return view('pages.admin.vendors.vendors-list', $data);
  }
  
  /**
   * 
   * Vendor withdraw content
   *
   * @param null
   * @return response view
   */
  public function vendorWithdrawContent(){
    $data = array();
    
    $data = $this->classCommonFunction->commonDataForAllPages();
    
    if(is_vendor_login()){
      if(!Session::has('withdraw_request_update_target')){
        Session::flash('withdraw_request_update_target', 'default_withdrawal_account_label');
        $data['withdraw_update_target']   =  'default_withdrawal_account_label';
      }
      else{
        $data['withdraw_update_target']   =  Session::get('withdraw_request_update_target');
      }

      $data['withdraw_request_data']   =  $this->getVendorCurrentWithdrawRequest( Session::get('shopist_admin_user_id') );
      if(count($data['withdraw_request_data']) > 0){
        if(isset($data['withdraw_request_data']['payment_type']) && $data['withdraw_request_data']['payment_type'] == 'single_payment_with_custom_values'){
          $data['withdraw_request_data']['selected_payment_type'] = 'Single payment with custom values';
        }
        elseif(isset($data['withdraw_request_data']['payment_type']) && $data['withdraw_request_data']['payment_type'] == 'single_payment_with_all_earnings'){
          $data['withdraw_request_data']['selected_payment_type'] = 'Single payment with all earnings';
        }

        if(isset($data['withdraw_request_data']['payment_method']) && $data['withdraw_request_data']['payment_method'] == 'dbt'){
          $data['withdraw_request_data']['selected_payment_method'] = 'Direct bank transfer';
        }
        elseif(isset($data['withdraw_request_data']['payment_method']) && $data['withdraw_request_data']['payment_method'] == 'cod'){
          $data['withdraw_request_data']['selected_payment_method'] = 'Cash on delivery';
        }
        elseif(isset($data['withdraw_request_data']['payment_method']) && $data['withdraw_request_data']['payment_method'] == 'paypal'){
          $data['withdraw_request_data']['selected_payment_method'] = 'Paypal';
        }
        elseif(isset($data['withdraw_request_data']['payment_method']) && $data['withdraw_request_data']['payment_method'] == 'stripe'){
          $data['withdraw_request_data']['selected_payment_method'] = 'Stripe';
        }
      }

      $data['vendor_packages_data']  =  get_package_details_by_vendor_id( Session::get('shopist_admin_user_id') );
      
      $data['withdraw_total']        =  $this->getVendorWithdrawTotal( Session::get('shopist_admin_user_id') );
      $data['withdraw_history_data'] =  $this->getWithdrawHistoryData( Session::get('shopist_admin_user_id'), 'all' );
    }
    else{
      $data['withdraw_request_data_all']   =  $this->getVendorWithdrawRequestDataAll('all');
      $data['total_row'] = count($data['withdraw_request_data_all']);
      $data['total_completed'] = count($this->getVendorWithdrawRequestDataAll('COMPLETED'));
      $data['total_cancelled'] = count($this->getVendorWithdrawRequestDataAll('CANCELLED'));
      $data['total_pending'] = count($this->getVendorWithdrawRequestDataAll('ON_HOLD'));
    }

    $data['is_all']       = "class=active";
    $data['is_pending']   = '';
    $data['is_completed'] = '';
    $data['is_cancelled'] = '';
    
    return view('pages.admin.vendors.withdraw-content', $data);
  }
  
  /**
   * 
   * Vendor withdraw status content
   *
   * @param null
   * @return response view
   */
  public function vendorWithdrawStatusContent( $params ){
    $data = array();
    $is_all = '';
    $is_pending = '';
    $is_completed = '';
    $is_cancelled = '';
    $status = 'all';
    
    $data = $this->classCommonFunction->commonDataForAllPages();
    if(isset($params) && $params == 'pending'){
      $is_pending = "class=active";
      $status = 'ON_HOLD';
    }
    elseif(isset($params) && $params == 'completed'){
      $is_completed = "class=active";
      $status = 'COMPLETED';
    }
    else{
      $is_cancelled = "class=active";
      $status = 'CANCELLED';
    }

    $data['is_all']       = $is_all;
    $data['is_pending']   = $is_pending;
    $data['is_completed'] = $is_completed;
    $data['is_cancelled'] = $is_cancelled;

    $data['withdraw_request_data_all']   =  $this->getVendorWithdrawRequestDataAll( $status );
    $data['total_row'] = count($this->getVendorWithdrawRequestDataAll('all'));
    $data['total_completed'] = count($this->getVendorWithdrawRequestDataAll('COMPLETED'));
    $data['total_cancelled'] = count($this->getVendorWithdrawRequestDataAll('CANCELLED'));
    $data['total_pending'] = count($this->getVendorWithdrawRequestDataAll('ON_HOLD'));
    
    return view('pages.admin.vendors.withdraw-content', $data);
  }
  
  /**
   * 
   * Vendor earning reports content
   *
   * @param null
   * @return response view
   */
  public function vendorsEarningReportsContent(){
    $data = array();
    $start_date   =  date('Y-m-01');
    $current_date =  date('Y-m-d');
    
    $data = $this->classCommonFunction->commonDataForAllPages();
    if(isset($_GET['date_from']) && isset($_GET['date_to'])){
      $start_date   =  $_GET['date_from'];
      $current_date =  $_GET['date_to'];
    }

    $data['vendor_reports']  =  $this->getVendorReportsDataForDay(array('target' => 'day', 'start_date'=> $start_date, 'current_date' => $current_date));
    $data['vendor_reports_log'] =  $this->getVendorReportsDayLog(array('target' => 'day', 'start_date'=> $start_date, 'current_date' => $current_date));

    $order_total = 0;
    $total_earning = 0;
    if(count($data['vendor_reports_log']) > 0){
      foreach($data['vendor_reports_log'] as $report){
        $order_total += $report->order_total;
        $total_earning += ((float)$report->order_total - (float)$report->net_amount);
      }
    }

    $data['vendor_reports_total_details'] = array('number_of_order' => $data['vendor_reports_log']->count(), 'order_total' => $order_total, 'total_earning' => $total_earning);

    $data['tab_activation'] = array('day' => 'class="active"', 'year' => '', 'vendor' => ''); 
    $data['action_url'] = Request::url();
    $data['start_date']     = $start_date;
    $data['current_date']   = $current_date;
     
    return view('pages.admin.vendors.vendor-admin-reports', $data);
  }
  
  /**
   * 
   * Vendor earning reports parameter content
   *
   * @param null
   * @return response view
   */
  public function vendorsEarningReportsParmsContent(){
    $data = array();
    
    $data = $this->classCommonFunction->commonDataForAllPages();
    
    if(Request::is('admin/vendors/earning-reports/by-day')){
      $start_date   =  date('Y-m-01');
      $current_date =  date('Y-m-d');


      if(isset($_GET['date_from']) && isset($_GET['date_to'])){
        $start_date   =  $_GET['date_from'];
        $current_date =  $_GET['date_to'];
      }

      $data['vendor_reports'] =  $this->getVendorReportsDataForDay(array('target' => 'day', 'start_date'=> $start_date, 'current_date' => $current_date));
      $data['vendor_reports_log'] =  $this->getVendorReportsDayLog(array('target' => 'day', 'start_date'=> $start_date, 'current_date' => $current_date));

      $order_total = 0;
      $total_earning = 0;
      if(count($data['vendor_reports_log']) > 0){
        foreach($data['vendor_reports_log'] as $report){
          $order_total += $report->order_total;
          $total_earning += ((float)$report->order_total - (float)$report->net_amount);
        }
      }

      $data['vendor_reports_total_details'] = array('number_of_order' => $data['vendor_reports_log']->count(), 'order_total' => $order_total, 'total_earning' => $total_earning);

      $data['tab_activation'] = array('day' => 'class="active"', 'year' => '', 'vendor' => ''); 
      $data['action_url'] = Request::url();
      $data['start_date']     = $start_date;
      $data['current_date']   = $current_date;
    }
    elseif (Request::is('admin/vendors/earning-reports/by-year')) {
      $current_year = date("Y");
      
      if(isset($_GET['filter_year'])){
        $current_year = $_GET['filter_year'];
      }
        
      $data['tab_activation'] = array('day' => '', 'year' => 'class="active"', 'vendor' => ''); 
      $data['action_url'] = Request::url();
      $data['year'] = array(2013, 2014, 2015, 2016, 2017, 2018, 2019, 2020, 2021, 2022, 2023, 2024, 2025, 2026, 2027, 2028, 2029, 2030);
      $data['filter_year']  = $current_year;
      
      $data['vendor_reports'] =  $this->getVendorReportsDataForYear(array('target' => 'year', 'requested_year' => $current_year)); 
      $data['vendor_reports_log'] =  $this->getVendorReportsYearLog(array('target' => 'year', 'year' => $current_year));
      
      $order_total = 0;
      $total_earning = 0;
      if(count($data['vendor_reports_log']) > 0){
        foreach($data['vendor_reports_log'] as $report){
          $order_total += $report->order_total;
          $total_earning += ((float)$report->order_total - (float)$report->net_amount);
        }
      }
      
      $data['vendor_reports_total_details'] = array('number_of_order' => $data['vendor_reports_log']->count(), 'order_total' => $order_total, 'total_earning' => $total_earning);
    }
    elseif (Request::is('admin/vendors/earning-reports/by-vendor')) {
      $start_date   =  date('Y-m-01');
      $current_date =  date('Y-m-d');
      $vendor_name  =  '';
      $vendor_id  =  null;
      
      if(isset($_GET['date_from']) && isset($_GET['date_to'])){
        $start_date   =  $_GET['date_from'];
        $current_date =  $_GET['date_to'];
      }
      
      if(isset($_GET['vendor_name'])){
        $vendor_name  =  $_GET['vendor_name'];
        $get_user = User::where(['name' => $vendor_name])->first();
        if(!empty($get_user)){
          $vendor_id = $get_user->id;
        }
      }
      
      $data['tab_activation'] = array('day' => '', 'year' => '', 'vendor' => 'class="active"'); 
      $data['action_url'] = Request::url();
      $data['all_vendor'] = $this->getAllVendors(false, null, -1);
      
      $data['start_date']     = $start_date;
      $data['current_date']   = $current_date;
      $data['vendor_name']    = $vendor_name;  
      
       $data['vendor_reports'] =  $this->getVendorReportsDataForVendor(array('target' => 'vendor', 'requested_start_date' => $start_date, 'requested_end_date' => $current_date, 'requested_vendor_id' => $vendor_id ));
       $data['vendor_reports_log'] =  $this->getVendorReportsVendorLog(array('target' => 'vendor', 'start_date'=> $start_date, 'current_date' => $current_date, 'vendor_id' => $vendor_id));
      
      $order_total = 0;
      $total_earning = 0;
      if(count($data['vendor_reports_log']) > 0){
        foreach($data['vendor_reports_log'] as $report){
          $order_total += $report->order_total;
          $total_earning += ((float)$report->order_total - (float)$report->net_amount);
        }
      }
      
      $data['vendor_reports_total_details'] = array('number_of_order' => $data['vendor_reports_log']->count(), 'order_total' => $order_total, 'total_earning' => $total_earning);
    }
    
    return view('pages.admin.vendors.vendor-admin-reports', $data);
  }
  
  /**
   * 
   * Vendor announcement list content
   *
   * @param null
   * @return response view
   */
  public function vendorAnnouncementListContent(){
    $data = array();
    $search_value = '';
    
    if(isset($_GET['term_announcement']) && $_GET['term_announcement'] != ''){
      $search_value = $_GET['term_announcement'];
    }
    
    $data = $this->classCommonFunction->commonDataForAllPages();
    $data['announcement_list_data']  =   $this->getVendorAnnouncementList( true, $search_value, -1 );
    $data['search_value']            =   $search_value;
    
    return view('pages.admin.vendors.vendor-announcement-list-content', $data);
  }
  
  /**
   * 
   * Vendor announcement add content
   *
   * @param null
   * @return response view
   */
  public function vendorAnnouncementAddContent(){
    $data = array();
    
    $data = $this->classCommonFunction->commonDataForAllPages();
    
    return view('pages.admin.vendors.vendor-announcement', $data);
  }
  
  /**
   * 
   * Vendor announcement update content
   *
   * @param null
   * @return response view
   */
  public function vendorAnnouncementUpdateContent( $params ){
    $data = array();
    
    $data = $this->classCommonFunction->commonDataForAllPages();
    $data['vendor_announcement'] =  $this->getVendorAnnouncement( $params  );
    
    return view('pages.admin.vendors.update-vendor-announcement', $data);
  }
  
  /**
   * 
   * Vendor settings content
   *
   * @param null
   * @return response view
   */
  public function vendorSettingsContent(){
    $data = array();
    
    $data = $this->classCommonFunction->commonDataForAllPages();
    $data['vendor_settings_data'] = $this->option->getVendorSettingsData();
    
    return view('pages.admin.vendors.vendor-settings', $data);
  }
  
  /**
   * 
   * Vendor package list content
   *
   * @param null
   * @return response view
   */
  public function vendorPackageListContent(){
    $data = array();
    
    $data = $this->classCommonFunction->commonDataForAllPages();
    $data['vendors_packages'] = array();
    $data['selected_package'] = '';
    $get_vendor_packages = VendorPackage::get()->toArray();

    if(count($get_vendor_packages) > 0){
      $data['vendors_packages'] = $get_vendor_packages;

      if(is_vendor_login()){
        $vendor_details   = get_current_vendor_user_info();
        $get_user_details = json_decode(get_user_account_details_by_user_id( $vendor_details['user_id'] )[0]['details']);

        if(!empty($get_user_details->package->package_name)){
          $data['selected_package'] = $get_user_details->package->package_name;
        }
      }
    }
    
    return view('pages.admin.vendors.vendors-packages-list', $data);
  }
  
  /**
   * 
   * Vendor package list content
   *
   * @param null
   * @return response view
   */
  public function vendorPackageUpdateContent( $params ){
    $get_vendor_package = VendorPackage::where(['id' => $params])->first();
      
    if(!empty($get_vendor_package)){
      $data = array();
    
      $data = $this->classCommonFunction->commonDataForAllPages();
      $data['package_update_data']['package_type'] = $get_vendor_package->package_type;
      $data['package_update_data']['options'] = json_decode($get_vendor_package->options);
      
      return view('pages.admin.vendors.update-vendors-package', $data);
    }
    else{
      return view('errors.no_data');
    }
  }
  
  /**
   * 
   * Vendor package create content
   *
   * @param null
   * @return response view
   */
  public function vendorPackageCreateContent(){
    $data = array();
    
    $data = $this->classCommonFunction->commonDataForAllPages();
    return view('pages.admin.vendors.vendors-package', $data);
  }
  
  /**
   * 
   * Vendor menu settings content
   *
   * @param null
   * @return response view
   */
  public function vendorMenuSettingsContent(){
    $data = array();
    
    $data = $this->classCommonFunction->commonDataForAllPages();
    $data['vendors_settings'] = null;
      
    if(is_vendor_login()){
      $vendor_details   = get_current_vendor_user_info();
      $get_user_details = json_decode(get_user_account_details_by_user_id( $vendor_details['user_id'] )[0]['details']);

      if(!empty($get_user_details)){
        if(!Session::has('update-target')){
          Session::flash('update-target', 'general');
          $data['update_target']   =  'general';
        }
        else{
          $data['update_target']   =  Session::get('update-target');
        }

        $data['vendors_settings'] = $get_user_details;
        $data['user_details']     = (object)$vendor_details;
      }
    }
    
    return view('pages.admin.vendors.vendors-menu-settings', $data);
  }
  
  /**
   * 
   * Vendor package manage content
   *
   * @param null
   * @return response view
   */
  public function vendorPackagesManage(){
    $data = array();
    
    $data = $this->classCommonFunction->commonDataForAllPages();
    $data['vendors_packages'] = array();
    $data['selected_package'] = '';
    $get_vendor_packages = VendorPackage::get()->toArray();

    if(count($get_vendor_packages) > 0){
      $data['vendors_packages'] = $get_vendor_packages;

      if(is_vendor_login()){
        $vendor_details   = get_current_vendor_user_info();
        $get_user_details = json_decode(get_user_account_details_by_user_id( $vendor_details['user_id'] )[0]['details']);

        if(!empty($get_user_details->package->package_name)){
          $data['selected_package'] = $get_user_details->package->package_name;
        }
      }
    }
    
    return view('pages.admin.vendors.vendor-packages-select-option', $data);
  }
  
  /**
   * 
   * Vendor reviews content
   *
   * @param null
   * @return response view
   */
  public function vendorReviewsContent(){
    $data = array();
    
    $data = $this->classCommonFunction->commonDataForAllPages();
    $data['vendor_reviews'] =  $this->getVendorReviews( Session::get('shopist_admin_user_id') );
    
    return view('pages.admin.vendors.vendor-reviews', $data);
  }
  
  /**
   * 
   * Vendor notice board content
   *
   * @param null
   * @return response view
   */
  public function vendorNoticeBoardContent(){
    $data = array();
    
    $data = $this->classCommonFunction->commonDataForAllPages();
    $data['vendor_all_notice'] =  $this->getVendorAnnouncementByVendorId( Session::get('shopist_admin_user_id') );
    
    return view('pages.admin.vendors.notice-board', $data);
  }
  
  /**
   * 
   * Vendor withdraw request update content
   *
   * @param request_id
   * @return response view
   */
  public function vendorWithdrawRequestUpdateContent( $params ){
    $data = array();
    $data = $this->classCommonFunction->commonDataForAllPages();
    $data['withdraw_request_data_by_update_id'] = $this->getVendorCurrentWithdrawRequestById( $params );
    
    return view('pages.admin.vendors.withdraw-request-update-content', $data);
  }
  
  /**
   * 
   * Vendor notice board admin single page content
   *
   * @param request_id
   * @return response view
   */
  public function vendorNoticeBoardAdminSinglePageContent( $params ){
    $vendor_single_details =  $this->getVendorAnnouncement( $params );
    
    if(!empty($vendor_single_details)){
      $data = array();
      $data = $this->classCommonFunction->commonDataForAllPages();
      $data['vendor_single_details'] =  $this->getVendorAnnouncement( $params );
      
      return view('pages.admin.vendors.single-notice-board-details', $data);
    }
    else{
      return view('errors.no_data');
    }
  }

  /**
   * 
   * Get all vendors
   *
   * @param null
   * @return array
   */
  public function getAllVendors( $pagination = false, $search_val = null, $status_flag = -1 ){
    $users_details = array();
    $get_role_details = get_roles_details_by_role_slug('vendor');
    
    if(!empty($get_role_details)){
      $get_users = get_users_by_role_id( $get_role_details->id, $search_val, $status_flag);
      
      if(count($get_users) > 0){
        $users_details = $get_users;
      }
    }
      
    if($pagination){
      $currentPage = LengthAwarePaginator::resolveCurrentPage();
      $col = new Collection( $users_details );
      $perPage = 10;
      $currentPageSearchResults = $col->slice(($currentPage - 1) * $perPage, $perPage)->all();
      $vendors_object = new LengthAwarePaginator($currentPageSearchResults, count($col), $perPage);
      
      $vendors_object->setPath( route('admin.vendors_list_content') );
    }
    
    if($pagination){
      return $vendors_object;
    }
    else{
      return $users_details;
    }
  }
  
  public function saveVendorSettings(){
    if( Request::isMethod('post') && Session::token() == Input::get('_token') ){
      if(is_vendor_login()){
        $vendor_details = get_current_vendor_user_info();
        $get_user_details = json_decode(get_user_account_details_by_user_id( $vendor_details['user_id'] )[0]['details']);
        
        if(Input::has('hf_update_vendor_profile') && Input::get('hf_update_vendor_profile') == 'update_vendor_profile'){
          $is_user_name_exists = User::where(['name' => Input::get('inputUserName')])->first();
          $is_email_exists     = User::where(['email' => Input::get('inputEmail')])->first();

          if($is_user_name_exists && $is_user_name_exists->id != Session::get('shopist_admin_user_id')){
            Session::flash('error-message', Lang::get('validation.unique', ['attribute' => 'user name']));
            return redirect()->back();
          } 

          if($is_email_exists && $is_email_exists->id != Session::get('shopist_admin_user_id')){
            Session::flash('error-message', Lang::get('validation.unique', ['attribute' => 'email id']));
            return redirect()->back();
          } 

          $data = array(
                        'display_name'         =>    Input::get('inputDisplayName'),
                        'name'                 =>    Input::get('inputUserName'),
                        'email'                =>    Input::get('inputEmail')
          );

          if(Input::get('inputNewPassword')){
            $data['password'] = bcrypt(Input::get('inputNewPassword'));
          }

          if(Input::get('hf_profile_picture')){
            $data['user_photo_url'] = Input::get('hf_profile_picture');
          }
          else{
            $data['user_photo_url'] = '';
          }

          User::where('id', Session::get('shopist_admin_user_id'))->update($data);
        }
        
        if(Input::has('hf_update_vendor_profile') && Input::get('hf_update_vendor_profile') == 'update_vendor_profile'){
          $get_user_details->profile_details->store_name = Input::get('inputStoreName');
          $get_user_details->profile_details->address_line_1 = Input::get('inputAddress1');
          $get_user_details->profile_details->address_line_2 = Input::get('inputAddress2');
          $get_user_details->profile_details->city = Input::get('inputCity');
          $get_user_details->profile_details->state = Input::get('inputState');
          $get_user_details->profile_details->country = Input::get('inputCountry');
          $get_user_details->profile_details->zip_postal_code = Input::get('inputZipPostalCode');
          $get_user_details->profile_details->phone = Input::get('inputPhoneNumber');
        }
        
        if(Input::has('hf_update_vendor_general_settings') && Input::get('hf_update_vendor_general_settings') == 'update_vendor_general_settings'){
          $get_user_details->general_details->cover_img = Input::get('hf_vendor_cover_picture');
          $get_user_details->general_details->vendor_home_page_cats = Input::get('selected_vendor_categories');
          $get_user_details->general_details->google_map_app_key = Input::get('google_map_api_key');
          $get_user_details->general_details->latitude = Input::get('google_map_latitude');
          $get_user_details->general_details->longitude = Input::get('google_map_longitude');
        }
        
        if(Input::has('hf_update_vendor_social_media') && Input::get('hf_update_vendor_social_media') == 'update_vendor_social_media'){
          $get_user_details->social_media->fb_follow_us_url = Input::get('fb_follow_us_url');
          $get_user_details->social_media->twitter_follow_us_url = Input::get('twitter_follow_us_url');
          $get_user_details->social_media->linkedin_follow_us_url = Input::get('linkedin_follow_us_url');
          $get_user_details->social_media->dribbble_follow_us_url = Input::get('dribbble_follow_us_url');
          $get_user_details->social_media->google_plus_follow_us_url = Input::get('google_plus_follow_us_url');
          $get_user_details->social_media->instagram_follow_us_url = Input::get('instagram_follow_us_url');
          $get_user_details->social_media->youtube_follow_us_url = Input::get('youtube_follow_us_url');
        }
        
        $data = array(
                    'details' =>  json_encode($get_user_details)
        );
        
        if(UsersDetail::where('user_id', $vendor_details['user_id'])->update( $data )){
          Session::flash('success-message', Lang::get('admin.successfully_updated_msg'));
          Session::flash('update-target', Input::get('hf_settings_target_tab'));
          return redirect()-> back();
        }
      }
    }
    else{ return redirect()-> back(); }
  }
  
  public function saveVendorComments($param){
    if( Request::isMethod('post') && Session::token() == Input::get('_token') ){
      $get_user = User::where(['name' => $param])->first();
      
      if(empty($get_user)){ return redirect()-> back();}
      
      if(Session::has('shopist_frontend_user_id')){
        $input = Input::all();
        
        $rules =  [
                    'selected_rating_value'   => 'required',
                    'product_review_content'  => 'required',
        ];
        
        $messages = [
                    'selected_rating_value.required'  => Lang::get('validation.select_rating'),
                    'product_review_content.required' => Lang::get('validation.write_review')
        ];

        $validator = Validator:: make($input, $rules, $messages);
        
        if($validator->fails()){
          return redirect()-> back()
          ->withInput()
          ->withErrors( $validator );
        }
        else{
          $comments   =  new Comment;
          
          $comments->user_id     =    Session::get('shopist_frontend_user_id');
          $comments->content     =    Input::get('product_review_content');
          $comments->rating      =    Input::get('selected_rating_value');
          $comments->object_id   =    $get_user->id;
          $comments->target      =    Input::get('comments_target');
          $comments->status      =    0;
          
          if($comments->save()){
            Session::flash('success-message', Lang::get('frontend.comments_saved_msg') );
            return redirect()-> back()
                             ->withInput(); 
          }
        }
      }
      else{
        Session::flash('error-message', Lang::get('frontend.without_login_comments_msg') );
        return redirect()-> back()
                         ->withInput();
      }
    }
  }
  
  /**
  * Get vendor comments list
  *
  * @param null
  * @return array
  */
  public function getVendorCommentsList(){
    $comments_data = array();
    
    if(is_vendor_login()){
      $vendor_details = get_current_vendor_user_info();
       
      $get_comments = DB::table('comments')->where(['comments.object_id' => $vendor_details['user_id'], 'comments.target' => 'vendor'])
                      ->join('users', 'comments.user_id', '=', 'users.id')
                      ->select('comments.*', 'users.display_name', 'users.name', 'users.user_photo_url')        
                      ->get()
                      ->toArray();

      if(count($get_comments) > 0){
        $comments_data = $get_comments;
      }
    }
    
    return $comments_data;
  }
  
  /**
  * Create vendor packages
  *
  * @param null
  * @return void
  */
  public function saveVendorPackages(){
    if( Request::isMethod('post') && Session::token() == Input::get('_token') ){
      $input = Input::all();
      $rules =  [
                  'inputPackageType'            => 'required|unique:vendor_packages,package_type',  
                  'inputMaxNumberProducts'      => 'required',
                  'inputExpiredType'            => 'required',
                  'inputCommissionPercentage'   => 'required',
                  'inputMinWithdrawAmount'      => 'required',
      ];
      
      if(Input::get('inputExpiredType') == 'custom_date'){
        $rules['inputExpiredDate'] = 'required';
      }
      
      $messages = [
                  'inputPackageType.required'          => Lang::get('validation.package_type'),
                  'inputPackageType.unique'            => Lang::get('validation.vendor_package_type_unique_msg'),
                  'inputMaxNumberProducts.required'    => Lang::get('validation.all_vendor_max_products'),
                  'inputExpiredType.required'          => Lang::get('validation.vendor_expired_type'),
                  'inputCommissionPercentage.required' => Lang::get('validation.vendor_commission'),
                  'inputExpiredDate.required'          => Lang::get('validation.vendor_custom_expired_date')
      ];
      
      $validator = Validator:: make($input, $rules, $messages);
      
      if($validator->fails()){
          return redirect()-> back()
          ->withInput()
          ->withErrors( $validator );
      }
      else{
        $vendor_package = new VendorPackage;
        $is_map_show_store_page = true;
        $is_media_follow_btn_show_store_page = true;
        $is_media_share_btn_show_store_page = true;
        $is_contact_form_show_store_page = true;

        if(!Input::has('inputShowMap')){
          $is_map_show_store_page = false;
        }

        if(!Input::has('inputShowSocialMediaFollow')){
          $is_media_follow_btn_show_store_page = false;
        }

        if(!Input::has('inputShowSocialMediaShareBtn')){
          $is_media_share_btn_show_store_page = false;
        }

        if(!Input::has('inputShowContactForm')){
          $is_contact_form_show_store_page = false;
        }

        $package_data = array('max_number_product' => Input::get('inputMaxNumberProducts'), 'show_map_on_store_page' => $is_map_show_store_page, 'show_social_media_follow_btn_on_store_page' => $is_media_follow_btn_show_store_page, 'show_social_media_share_btn_on_store_page' => $is_media_share_btn_show_store_page, 'show_contact_form_on_store_page' => $is_contact_form_show_store_page, 'vendor_expired_date_type' => Input::get('inputExpiredType'), 'vendor_custom_expired_date' => Input::get('inputExpiredDate'), 'vendor_commission' => Input::get('inputCommissionPercentage'), 'min_withdraw_amount' => Input::get('inputMinWithdrawAmount'));

        $vendor_package->package_type  = Input::get('inputPackageType'); 
        $vendor_package->options       = json_encode($package_data);

        if($vendor_package->save()){
          Session::flash('success-message', Lang::get('admin.successfully_saved_msg') );
          return redirect()->route('admin.vendors_packages_update_content', $vendor_package->id);
        } 
      }  
    }
    else{
      return redirect()->back();
    }
  }
  
  /**
  * Create vendor packages
  *
  * @param null
  * @return void
  */
  public function updateVendorPackages($param){
    if( Request::isMethod('post') && Session::token() == Input::get('_token') ){
      $input = Input::all();
      $rules =  [
                  'inputPackageType'            => 'required',  
                  'inputMaxNumberProducts'      => 'required',
                  'inputExpiredType'            => 'required',
                  'inputCommissionPercentage'   => 'required',
                  'inputMinWithdrawAmount'      => 'required',
      ];
      
      if(Input::get('inputExpiredType') == 'custom_date'){
        $rules['inputExpiredDate'] = 'required';
      }
      
      $messages = [
                  'inputPackageType.required'          => Lang::get('validation.package_type'),
                  'inputPackageType.unique'            => Lang::get('validation.vendor_package_type_unique_msg'),
                  'inputMaxNumberProducts.required'    => Lang::get('validation.all_vendor_max_products'),
                  'inputExpiredType.required'          => Lang::get('validation.vendor_expired_type'),
                  'inputCommissionPercentage.required' => Lang::get('validation.vendor_commission'),
                  'inputExpiredDate.required'          => Lang::get('validation.vendor_custom_expired_date')
      ];
      
      $validator = Validator:: make($input, $rules, $messages);
      
      if($validator->fails()){
          return redirect()-> back()
          ->withInput()
          ->withErrors( $validator );
      }
      else{
        $get_package = VendorPackage::where(['package_type' => Input::get('inputPackageType')])->first();
        if(!empty($get_package) && $get_package->id != $param){
          Session::flash('error-message', Lang::get('admin.given_package_type_error_msg'));
          return redirect()->route('admin.vendors_packages_update_content', $param);
        }
          
        $vendor_package = new VendorPackage;
        $is_map_show_store_page = true;
        $is_media_follow_btn_show_store_page = true;
        $is_media_share_btn_show_store_page = true;
        $is_contact_form_show_store_page = true;

        if(!Input::has('inputShowMap')){
          $is_map_show_store_page = false;
        }

        if(!Input::has('inputShowSocialMediaFollow')){
          $is_media_follow_btn_show_store_page = false;
        }

        if(!Input::has('inputShowSocialMediaShareBtn')){
          $is_media_share_btn_show_store_page = false;
        }

        if(!Input::has('inputShowContactForm')){
          $is_contact_form_show_store_page = false;
        }

        $package_data = array('max_number_product' => Input::get('inputMaxNumberProducts'), 'show_map_on_store_page' => $is_map_show_store_page, 'show_social_media_follow_btn_on_store_page' => $is_media_follow_btn_show_store_page, 'show_social_media_share_btn_on_store_page' => $is_media_share_btn_show_store_page, 'show_contact_form_on_store_page' => $is_contact_form_show_store_page, 'vendor_expired_date_type' => Input::get('inputExpiredType'), 'vendor_custom_expired_date' => Input::get('inputExpiredDate'), 'vendor_commission' => Input::get('inputCommissionPercentage'), 'min_withdraw_amount' => Input::get('inputMinWithdrawAmount'));
        
        $data = array(
                      'package_type'   =>  Input::get('inputPackageType'),
                      'options'        =>  json_encode($package_data)
        );
        
        

        if(VendorPackage::where('id', $param)->update($data)){
          Session::flash('success-message', Lang::get('admin.successfully_updated_msg'));
          return redirect()->route('admin.vendors_packages_update_content', $param);
        }
      }  
    }
    else{
      return redirect()->back();
    }
  }
  
  /**
  * Save vendor package
  *
  * @param null
  * @return void
  */
  public function saveVendorPackage(){
    if( Request::isMethod('post') && Session::token() == Input::get('_token') ){
      if(is_vendor_login()){
        $vendor_details   = get_current_vendor_user_info();
        $get_user_details = json_decode(get_user_account_details_by_user_id( $vendor_details['user_id'] )[0]['details']);
        
        $get_user_details->package->package_name = Input::get('package_name');
        
        $data = array(
                    'details' =>  json_encode($get_user_details)
        );
        
        if(UsersDetail::where('user_id', $vendor_details['user_id'])->update( $data )){
          Session::flash('success-message', Lang::get('admin.suitable_package_update_label'));
          return redirect()-> back();
        }
      }    
    }
  }
  
  /**
  * Save vendor withdraw request data
  *
  * @param null
  * @return void
  */
  public function vendorWithdrawRequestContentSave($parm = null){
    if( Request::isMethod('post') && Session::token() == Input::get('_token') ){
      $input = Input::all();
      $rules =  [
                  'payment_type'        => 'required',  
                  'payment_method'      => 'required'
      ];

      if(Input::get('payment_type') == 'single_payment_with_custom_values'){
        $rules['single_payment_with_custom_values'] = 'required';
      }
      
      $messages = [
                  'payment_type.required'     => Lang::get('validation.select_vendor_payment_type_msg'),
                  'payment_method.unique'     => Lang::get('validation.select_vendor_payment_method_msg'),
                  'single_payment_with_custom_values.unique'     => Lang::get('validation.enter_single_payment_custom_value')
      ];
      
      $validator = Validator:: make($input, $rules, $messages);
      Session::flash('withdraw_request_update_target', Input::get('hf_withdraw_request_target_tab'));
      
      if($validator->fails()){
        return redirect()-> back()
        ->withInput()
        ->withErrors( $validator );
      }
      else{
        $user_id = 0;
        $custom_values = 0;
        $total_earn = 0;
        $amount = 0;
        $getFunction = new GetFunction();
        
        if(is_vendor_login() && Session::has('shopist_admin_user_id')){
          $user_id = Session::get('shopist_admin_user_id');
        }
        
        if(Input::has('single_payment_with_custom_values') && Input::get('single_payment_with_custom_values')){
          $custom_values = Input::get('single_payment_with_custom_values');
        }
        
        $get_vendor_total = VendorTotal::where(['vendor_id' => $user_id])->first();
        if(!empty($get_vendor_total)){
          $total_earn = $get_vendor_total->totals; 
        }
        
        if(Input::get('payment_type') == 'single_payment_with_custom_values' && Input::has('single_payment_with_custom_values')){
          $amount = $custom_values;
        }
        else{
          $amount = $total_earn;
        }
        
        $get_package_details = get_package_details_by_vendor_id( Session::get('shopist_admin_user_id') );
        if($get_package_details->min_withdraw_amount > $amount){
          Session::flash('error-message', Lang::get('admin.vendor_min_withdraw_amount_error_msg', ['amount' => $get_package_details->min_withdraw_amount]) );
          return redirect()->back()->withInput(); 
        }
        
        if(Input::get('payment_type') == 'single_payment_with_custom_values' && Input::has('single_payment_with_custom_values') && Input::get('single_payment_with_custom_values') > $total_earn){
        
          Session::flash('error-message', Lang::get('admin.vendor_amount_less_than_error_msg', ['amount' => $amount]) );
          return redirect()->back()->withInput(); 
        }
        
        $get_user_data = get_user_details($user_id);
        $email_options = get_emails_option_data();
        
        $vendor_withdraw_request = new VendorWithdraw;
        if(Input::get('target') == 'add_withdraw_request'){
          $get_withdraw_request = VendorWithdraw::where(['user_id' => $user_id, 'status' => 'ON_HOLD'])->first();
          
          if(!empty($get_withdraw_request)){
            Session::flash('error-message', Lang::get('admin.vendor_withdraw_request_already_send_msg'));
            return redirect()->back()->withInput(); 
          }
          
          $vendor_withdraw_request->user_id           = $user_id; 
          $vendor_withdraw_request->amount            = $amount;
          $vendor_withdraw_request->custom_amount     = $custom_values;  
          $vendor_withdraw_request->status            = 'ON_HOLD';
          $vendor_withdraw_request->payment_type      = Input::get('payment_type');
          $vendor_withdraw_request->payment_method    = Input::get('payment_method');
          $vendor_withdraw_request->ip                = Request::ip();

          if($vendor_withdraw_request->save()){
            if($email_options['vendor_withdraw_request']['enable_disable'] == true && $this->env === 'production'){
              $value = '';
              $payment_method = '';
              if(Input::get('payment_type') == 'single_payment_with_custom_values'){
                $value = price_html($amount);
              }
              else{
                $value = 'all earnings';
              }
              
              if(Input::get('payment_method') == 'dbt'){
                $payment_method = 'Direct Bank Transfer';
              }
              elseif(Input::get('payment_method') == 'cod'){
                $payment_method = 'Cash on Delivery';
              }
              elseif(Input::get('payment_method') == 'paypal'){
                $payment_method = 'Paypal';
              }
              elseif(Input::get('payment_method') == 'stripe'){
                $payment_method = 'Stripe';
              }
              
              $getFunction->sendCustomMail( array('source' => 'withdraw_request', 'email' => $get_user_data['user_email'], 'target' => 'add', 'value' => $value, 'payment_method' => $payment_method) );
            }
            
            Session::flash('success-message', Lang::get('admin.vendor_withdraw_request_send_msg') );
            return redirect()->back()->withInput(); 
          }
        }
        elseif(Input::get('target') == 'update_withdraw_request'){
          $data = array(
                    'amount'          =>  $amount,
                    'custom_amount'   =>  $custom_values,
                    'payment_type'    =>  Input::get('payment_type'),
                    'payment_method'  =>  Input::get('payment_method')
          );
          
          if(VendorWithdraw::where('id', $parm)->update( $data )){
            if($email_options['vendor_withdraw_request']['enable_disable'] == true && $this->env === 'production'){
              $value = '';
              $payment_method = '';
              
              if(Input::get('payment_type') == 'single_payment_with_custom_values'){
                $value = price_html($amount);
              }
              else{
                $value = 'all earnings';
              }
              
              if(Input::get('payment_method') == 'dbt'){
                $payment_method = 'Direct Bank Transfer';
              }
              elseif(Input::get('payment_method') == 'cod'){
                $payment_method = 'Cash on Delivery';
              }
              elseif(Input::get('payment_method') == 'paypal'){
                $payment_method = 'Paypal';
              }
              elseif(Input::get('payment_method') == 'stripe'){
                $payment_method = 'Stripe';
              }
              
              $getFunction->sendCustomMail( array('source' => 'withdraw_request', 'email' => $get_user_data['user_email'], 'target' => 'update', 'value' => $value, 'payment_method' => $payment_method) );
            }
            
            Session::flash('success-message', Lang::get('admin.vendor_withdraw_request_update_msg'));
            return redirect()-> back();
          }
        }
      }
    }
  }

  /**
  * Get vendor current withdraw request data
  *
  * @param vendor id
  * @return array
  */
  
  public function getVendorCurrentWithdrawRequest($vendor_id){
    $get_withdraw_request = array();
    $get_request = VendorWithdraw::where(['user_id' => $vendor_id, 'status' => 'ON_HOLD'])->get()->toArray();

    if(count($get_request) > 0){
      $get_withdraw_request = array_shift($get_request);
    }

    return $get_withdraw_request;
  }
  
  /**
  * Get vendor withdraw request data all
  *
  * @param null
  * @return array
  */
  
  public function getVendorWithdrawRequestDataAll($status){
    $get_withdraw_request = array();
    
    if($status == 'all'){
      $get_request = VendorWithdraw::get()->toArray();
    }
    else{
      $get_request = VendorWithdraw::where(['status' => $status])->get()->toArray();
    }

    if(count($get_request) > 0){
      $get_withdraw_request = $get_request;
    }
    
    $currentPage = LengthAwarePaginator::resolveCurrentPage();
    $col = new Collection( $get_withdraw_request );
    $perPage = 10;
    $currentPageSearchResults = $col->slice(($currentPage - 1) * $perPage, $perPage)->all();
    $withdraw_request_data = new LengthAwarePaginator($currentPageSearchResults, count($col), $perPage);
    $withdraw_request_data->setPath( route('admin.withdraws_content') );
    
    return $withdraw_request_data;
  }
  
  /**
  * Get vendor request data by update id
  *
  * @param update id
  * @return array
  */
  
  public function getVendorCurrentWithdrawRequestById($update_id){
    $get_withdraw_request = null;
    $get_request = VendorWithdraw::where(['id' => $update_id])->first();

    if(!empty($get_request) > 0){
      $get_withdraw_request = $get_request;
    }

    return $get_withdraw_request;
  }
  
  /**
  * Get specific vendor withdraw total 
  *
  * @param vendor_id
  * @return number
  */
  public function getVendorWithdrawTotal($vendor_id){
    $withdraw_total = 0;
    $get_withdraw_total = VendorTotal::where(['vendor_id' => $vendor_id])->first();
    
    if(!empty($get_withdraw_total)){
      $withdraw_total = $get_withdraw_total->totals;
    }
    
    return $withdraw_total;
  }
  
  /**
  * Get specific vendor withdraw total 
  *
  * @param vendor_id
  * @return number
  */
  public function getWithdrawHistoryData($vendor_id, $status){
    $withdraw_history_data = array();
    
    if($status == 'all'){
      $get_withdraw = VendorWithdraw::where(['user_id' => $vendor_id])->get()->toArray();
    }
    else{
      $get_withdraw = VendorWithdraw::where(['user_id' => $vendor_id, 'status' => $status])->get()->toArray();
    }
    
    if(count($get_withdraw) > 0){
      $withdraw_history_data = $get_withdraw;
    }
    
    $currentPage = LengthAwarePaginator::resolveCurrentPage();
    $col = new Collection( $withdraw_history_data );
    $perPage = 10;
    $currentPageSearchResults = $col->slice(($currentPage - 1) * $perPage, $perPage)->all();
    $withdraw_history_data_obj = new LengthAwarePaginator($currentPageSearchResults, count($col), $perPage);

    $withdraw_history_data_obj->setPath( route('admin.withdraws_content') );
    
    
    return $withdraw_history_data_obj;
  }
  
  /**
  * Get vendor reviews
  *
  * @param vendor_id
  * @return object
  */
  public function getVendorReviews( $vendor_id ){
    $vendor_reviews =  array();
    $get_reviews =  DB::table('comments')->where(['object_id' => $vendor_id, 'target' => 'vendor'])
                    ->join('users', 'comments.user_id', '=', 'users.id')
                    ->select('comments.*', 'users.display_name', 'users.user_photo_url')        
                    ->get()
                    ->toArray();
    
    if(count($get_reviews) > 0){
      $vendor_reviews = $get_reviews;
    }
    
    $currentPage = LengthAwarePaginator::resolveCurrentPage();
    $col = new Collection( $vendor_reviews );
    $perPage = 10;
    $currentPageSearchResults = $col->slice(($currentPage - 1) * $perPage, $perPage)->all();
    $vendor_reviews_object = new LengthAwarePaginator($currentPageSearchResults, count($col), $perPage);

    $vendor_reviews_object->setPath( route('admin.withdraws_content') );
    
    
    return $vendor_reviews_object;
  }
  
  /**
  * Save vendor announcement
  *
  * @param null
  * @return void
  */
  public function saveVendorAnnouncement(){
    if( Request::isMethod('post') && Session::token() == Input::get('_token') ){
      $data = Input::all();
      $rules =  [
                  'vendor_announcement_post_title'  => 'required',
                  'send_announcement'  => 'required'
                ];
      
      if(Input::has('send_announcement') && Input::get('send_announcement') == 'selected_vendor' && !Input::has('selected_vendors')){
        $rules['selected_vendors'] = 'required';
      }
      
      $validator = Validator:: make($data, $rules);
      
      if($validator->fails()){
        return redirect()-> back()
        ->withInput()
        ->withErrors( $validator );
      }
      else{
        $selected_vendors = array();
        
        if(Input::has('send_announcement') && Input::get('send_announcement') == 'all_vendor'){
          $get_all_vendors = $this->getAllVendors(false, null, -1);
          if(count($get_all_vendors) > 0){
            foreach($get_all_vendors as $vendor){
              array_push($selected_vendors, $vendor->id);
            }
          }
        }
        else{
          $get_selected_vendors = json_decode(Input::get('selected_vendors'));

          if(!empty($get_selected_vendors) && count($get_selected_vendors) > 0){
            foreach($get_selected_vendors as $vendor){
              $explod_val = explode('#', $vendor);
              $get_id = end($explod_val);
              array_push($selected_vendors, $get_id);
            }
          }
        }
        
        $post  =  new Post;
        
        $post_slug  = '';
        $check_slug = Post::where(['post_slug' => string_slug_format( Input::get('vendor_announcement_post_title') )])->orWhere('post_slug', 'like', '%' . string_slug_format( Input::get('vendor_announcement_post_title') ) . '%')->get()->count();

        if($check_slug === 0){
          $post_slug = string_slug_format( Input::get('vendor_announcement_post_title') );
        }
        elseif($check_slug > 0){
          $slug_count = $check_slug + 1;
          $post_slug = string_slug_format( Input::get('vendor_announcement_post_title') ). '-' . $slug_count;
        }

        $post->post_author_id         =   Session::get('shopist_admin_user_id');
        $post->post_content           =   string_encode(Input::get('announcement_description_editor'));
        $post->post_title             =   Input::get('vendor_announcement_post_title');
        $post->post_slug              =   $post_slug;
        $post->parent_id              =   0;
        $post->post_status            =   Input::get('announcement_post_visibility');
        $post->post_type              =   'vendor_announcement';

        if($post->save()){
          if(PostExtra::insert(
                              array(
                                  'post_id'       =>  $post->id,
                                  'key_name'      =>  '_announcement_receiver_name',
                                  'key_value'     =>  Input::get('send_announcement'),
                                  'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                  'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                              )
          ));  
          
          if(count($selected_vendors) > 0){
            foreach($selected_vendors as $vendor_id){
              $vendor_announcement = new VendorAnnouncement;
              $vendor_announcement->user_id    =   $vendor_id;
              $vendor_announcement->post_id    =   $post->id;
              $vendor_announcement->save();
            }
          }
          
          Session::flash('success-message', Lang::get('admin.successfully_saved_msg') );
          return redirect()->route('admin.announcement_update_content', $post->post_slug);
        }
      }
    }
  }
  
  /**
  * Get vendor announcement
  *
  * @param post_slug
  * @return array
  */
  public function getVendorAnnouncement($slug){
    $vendor_announcement = null;
    $get_announcement = Post::where(['post_slug' => $slug, 'post_type' => 'vendor_announcement'])->first();
    
    if(!empty($get_announcement)){
      $vendor_announcement = $get_announcement;
      $get_announcement_postextra = PostExtra::where(['post_id' => $vendor_announcement->id])->get()->toArray();
      $get_announcement_extra = VendorAnnouncement::where(['post_id' => $vendor_announcement->id])->get()->toArray();
      
      if(count($get_announcement_postextra) > 0){
        foreach ($get_announcement_postextra as $postextra){
          if($postextra['key_name'] == '_announcement_receiver_name'){
            $vendor_announcement->announcement_receiver_name = $postextra['key_value']; 
          }
        }
      }
      
      $vendor_announcement->post = array();
      $vendor_announcement->post_json_data = null;
      
      if(count($get_announcement_extra) > 0){
        $vendor_announcement->post = $get_announcement_extra; 
        
        $vendors = array(); 
        foreach($get_announcement_extra as $data){
          $get_vendor_name = User::where(['id' => $data['user_id']])->first(); 
          
          if(!empty($get_vendor_name)){
            array_push($vendors, $get_vendor_name->name .' #'.$data['user_id']);
          }
        }
        $vendor_announcement->post_json_data = json_encode($vendors); 
      }
    }
    
    return $vendor_announcement;
  }
  
  /**
  * Update vendor announcement
  *
  * @param update_slug
  * @return void
  */
  public function updateVendorAnnouncement($parm){
    if( Request::isMethod('post') && Session::token() == Input::get('_token') ){
      $data = Input::all();
      $rules =  [
                  'vendor_announcement_post_title'  => 'required',
                  'send_announcement'  => 'required'
                ];
      
      if(Input::has('send_announcement') && Input::get('send_announcement') == 'selected_vendor' && !Input::has('selected_vendors')){
        $rules['selected_vendors'] = 'required';
      }
      
      $validator = Validator:: make($data, $rules);
      
      if($validator->fails()){
        return redirect()-> back()
        ->withInput()
        ->withErrors( $validator );
      }
      else{
        $selected_vendors = array();
        
        if(Input::has('send_announcement') && Input::get('send_announcement') == 'all_vendor'){
          $get_all_vendors = $this->getAllVendors(false, null, -1);
          
          if(count($get_all_vendors) > 0){
            foreach($get_all_vendors as $vendor){
              array_push($selected_vendors, $vendor->id);
            }
          }
        }
        else{
          $get_selected_vendors = json_decode(Input::get('selected_vendors'));
        
          if(!empty($get_selected_vendors) && count($get_selected_vendors) > 0){
            foreach($get_selected_vendors as $vendor){
              $explod_val = explode('#', $vendor);
              $get_id = end($explod_val);
              array_push($selected_vendors, $get_id);
            }
          }
        }
        
        $data = array(
                      'post_author_id'         =>  Session::get('shopist_admin_user_id'),
                      'post_content'           =>  string_encode(Input::get('announcement_description_editor')),
                      'post_title'             =>  Input::get('vendor_announcement_post_title'),
                      'post_status'            =>  Input::get('announcement_post_visibility')
        );
        
        if(Post::where('post_slug', $parm)->update($data)){
          $get_post =   Post :: where('post_slug', $parm)->first();
          $announcement_receiver  = array(
                                          'key_value'  =>  Input::get('send_announcement')
          );
          PostExtra::where(['post_id' => $get_post->id, 'key_name' => '_announcement_receiver_name'])->update($announcement_receiver);
          
          VendorAnnouncement::where('post_id', $get_post->id)->delete();
          if(count($selected_vendors) > 0){
            foreach($selected_vendors as $vendor_id){
              $vendor_announcement = new VendorAnnouncement;
              $vendor_announcement->user_id    =   $vendor_id;
              $vendor_announcement->post_id    =   $get_post->id;
              $vendor_announcement->save();
            }
          }
          
          Session::flash('success-message', Lang::get('admin.successfully_updated_msg'));
          return redirect()->route('admin.announcement_update_content', $parm);
        }
      }
    }
  }
  
  /**
  * Get vendor announcement list data
  *
  * @param pagination required. Boolean type TRUE or FALSE, by default false
  * @param search value optional
	* @param status flag by default -1. -1 for all data, 1 for status enable and 0 for disable status
  * @return object
  */
  public function getVendorAnnouncementList( $pagination = false, $search_val = null, $status_flag = -1 ){
    $announcement = array();
    if($status_flag == -1){
      $where = ['post_type' => 'vendor_announcement'];
    }
    else{
      $where = ['post_type' => 'vendor_announcement', 'post_status' => $status_flag];
    }
    
    if(!empty($search_val)){
      $get_announcement = Post:: where($where)
                          ->where('post_title', 'LIKE', '%'. $search_val. '%')
                          ->orderBy('id', 'desc')
                          ->get()
                          ->toArray();
    }
    else{
      $get_announcement = Post:: where($where)
                          ->orderBy('id', 'desc')
                          ->get()
                          ->toArray();
    }
    
    if(count($get_announcement) > 0){
      foreach($get_announcement as $data){
        $post_extra = PostExtra:: where(['post_id' => $data['id']])
                      ->get();
        if(!empty($post_extra) && $post_extra->count() > 0){
          foreach($post_extra as $post_extra_row){
            if(!empty($post_extra_row) && $post_extra_row->key_name == '_announcement_receiver_name'){
              if(!empty($post_extra_row->key_value)){
                $data['announcement_receiver_name'] = $post_extra_row->key_value;
              }
              else{
                $data['announcement_receiver_name'] = null;
              }
            }
          }
        }
        $data['vendor_receiver_list'] = array();
        $get_vendor_receiver = VendorAnnouncement::where(['post_id' => $data['id']])->get()->toArray();
        if(count($get_vendor_receiver) > 0){
          $data['vendor_receiver_list'] = $get_vendor_receiver;
        }
        
        array_push($announcement, $data);
      }
    }
    
    if($pagination){
      $currentPage = LengthAwarePaginator::resolveCurrentPage();
      $col = new Collection( $announcement );
      $perPage = 10;
      $currentPageSearchResults = $col->slice(($currentPage - 1) * $perPage, $perPage)->all();
      $announcement_object = new LengthAwarePaginator($currentPageSearchResults, count($col), $perPage);
      
      $announcement_object->setPath( route('admin.announcement_list_content') );
    }
    
    if($pagination){
      return $announcement_object;
    }
    else{
      return $announcement;
    }
  }
  
  /**
  * Get notice for specific vendor
  *
	* @param vendor_id
  * @return object
  */
  public function getVendorAnnouncementByVendorId($vendor_id){
    $announcements = array();
    $get_announcement =  DB::table('posts')->where(['posts.post_status' => 1, 'vendor_announcements.user_id' => $vendor_id])
                         ->join('vendor_announcements', 'posts.id', '=', 'vendor_announcements.post_id')
                         ->select('posts.*', 'vendor_announcements.user_id') 
                         ->orderBy('posts.id', 'desc')
                         ->get()
                         ->toArray();
    
    if(count($get_announcement) > 0){
      $announcements = $get_announcement;
    }
    
    $currentPage = LengthAwarePaginator::resolveCurrentPage();
    $col = new Collection( $announcements );
    $perPage = 10;
    $currentPageSearchResults = $col->slice(($currentPage - 1) * $perPage, $perPage)->all();
    $announcement_object = new LengthAwarePaginator($currentPageSearchResults, count($col), $perPage);

    $announcement_object->setPath( route('admin.announcement_list_content') );
    
    return $announcement_object;
  } 
  
  /**
  * Get top 3 notice for specific vendor 
  *
	* @param vendor_id
  * @return array
  */
  public function getTopThreeVendorAnnouncementByVendorId($vendor_id){
    $announcements = array();
    $get_announcement =  DB::table('posts')->where(['posts.post_status' => 1, 'vendor_announcements.user_id' => $vendor_id])
                         ->join('vendor_announcements', 'posts.id', '=', 'vendor_announcements.post_id')
                         ->select('posts.*', 'vendor_announcements.user_id') 
                         ->orderBy('posts.id', 'desc')
                         ->take(3)
                         ->get()
                         ->toArray();
    
    if(count($get_announcement) > 0){
      $announcements = $get_announcement;
    }
    
    return $announcements;
  } 
  
  /**
  * Get vendor reports data by day
  *
	* @param array target, start, end date
  * @return object
  */
 public function getVendorReportsDataForDay($request_parms){
   $reports_data = array();
   if($request_parms['target'] == 'day' && isset($request_parms['start_date']) && isset($request_parms['current_date'])){
     $get_data = DB::table('vendor_orders')
                 ->where(['order_status' => 'COMPLETED'])
                 ->whereBetween('created_at', array($this->carbonObject->parse($request_parms['start_date'])->toDateString(), $this->carbonObject->parse($request_parms['current_date'])->toDateString().' 23:59:59'))
                 ->select(DB::raw('date(created_at) as dates'), DB::raw('count(*) as total_order'), DB::raw('SUM(order_total) as order_total_amount'), DB::raw('SUM(net_amount) as commision'))
                 ->groupBy(DB::raw('CAST(created_at AS DATE)'))
                 ->get()
                 ->toArray();
     
     if(count($get_data) > 0){
       $reports_data = $get_data;
     }
   }
   
   return $reports_data;
 }
 
 /**
  * Get vendor reports data by year
  *
	* @param array target, year
  * @return object
  */
 public function getVendorReportsDataForYear($request_parms){
   $reports_data = array();
   if($request_parms['target'] == 'year'){
     $get_data = DB::table('vendor_orders')
                 ->where(['order_status' => 'COMPLETED'])
                 ->whereYear('created_at', '=', $request_parms['requested_year'])
                 ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as date'), DB::raw('count(*) as total_order'), DB::raw('SUM(order_total) as order_total_amount'), DB::raw('SUM(net_amount) as commision'))
                 ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
                 ->get()
                 ->toArray();
     
     if(count($get_data) > 0){
       $reports_data = $get_data;
     }
   }
   
   return $reports_data;
 }
 
 /**
  * Get vendor reports data by vendor
  *
	* @param array target, vendor
  * @return object
  */
 public function getVendorReportsDataForVendor($request_parms){
   $reports_data = array();
   if($request_parms['target'] == 'vendor'){
     $get_data = DB::table('vendor_orders')
                 ->where(['vendor_id' => $request_parms['requested_vendor_id'], 'order_status' => 'COMPLETED'])
                 ->whereBetween('created_at', array($this->carbonObject->parse($request_parms['requested_start_date'])->toDateString(), $this->carbonObject->parse($request_parms['requested_end_date'])->toDateString().' 23:59:59'))
                 ->select(DB::raw('date(created_at) as dates'), DB::raw('count(*) as total_order'), DB::raw('SUM(order_total) as order_total_amount'), DB::raw('SUM(net_amount) as commision'))
                 ->groupBy(DB::raw('CAST(created_at AS DATE)'))
                 ->get()
                 ->toArray();
     
     if(count($get_data) > 0){
       $reports_data = $get_data;
     }
   }
   
   return $reports_data;
 }
 
 /**
  * Get vendor reports data for log
  *
	* @param array start, end date, current month or any vendor
  * @return object
  */
 public function getVendorReportsDayLog($request_parms){
   $reports_data = array();
   if($request_parms['target'] == 'day' && isset($request_parms['start_date']) && isset($request_parms['current_date'])){
     $get_data = DB::table('vendor_orders')
                 ->where(['order_status' => 'COMPLETED'])
                 ->whereBetween('created_at', array($this->carbonObject->parse($request_parms['start_date'])->toDateString(), $this->carbonObject->parse($request_parms['current_date'])->toDateString().' 23:59:59')) 
                 ->orderby('order_id', 'desc')
                 ->get()
                 ->toArray();
     
     if(count($get_data) > 0){
       $reports_data = $get_data;
     }
   }
   
   $currentPage = LengthAwarePaginator::resolveCurrentPage();
   $col = new Collection( $reports_data );
   $perPage = 10;
   $currentPageSearchResults = $col->slice(($currentPage - 1) * $perPage, $perPage)->all();
   $reports_object = new LengthAwarePaginator($currentPageSearchResults, count($col), $perPage);

   $reports_object->setPath( route('admin.earning_reports_content') );
 
   return $reports_object;
 }
 
 /**
  * Get vendor reports year data for log
  *
	* @param year
  * @return object
  */
 public function getVendorReportsYearLog($request_parms){
   $reports_data = array();
   if($request_parms['target'] == 'year' && isset($request_parms['year'])){
     $get_data = DB::table('vendor_orders')
                 ->where(['order_status' => 'COMPLETED'])
                 ->whereYear('created_at', '=', $request_parms['year'])
                 ->orderby('order_id', 'desc')
                 ->get()
                 ->toArray();
     
     if(count($get_data) > 0){
       $reports_data = $get_data;
     }
   }
   
   $currentPage = LengthAwarePaginator::resolveCurrentPage();
   $col = new Collection( $reports_data );
   $perPage = 10;
   $currentPageSearchResults = $col->slice(($currentPage - 1) * $perPage, $perPage)->all();
   $reports_object = new LengthAwarePaginator($currentPageSearchResults, count($col), $perPage);

   $reports_object->setPath( route('admin.earning_reports_content') );
 
   return $reports_object;
 }
 
 /**
  * Get vendor reports data for log
  *
	* @param array start, end date, current month or any vendor
  * @return object
  */
 public function getVendorReportsVendorLog($request_parms){
   $reports_data = array();
   if($request_parms['target'] == 'vendor' && isset($request_parms['start_date']) && isset($request_parms['current_date'])){
     $get_data = DB::table('vendor_orders')
                 ->where(['vendor_id' => $request_parms['vendor_id'], 'order_status' => 'COMPLETED'])
                 ->whereBetween('created_at', array($this->carbonObject->parse($request_parms['start_date'])->toDateString(), $this->carbonObject->parse($request_parms['current_date'])->toDateString().' 23:59:59')) 
                 ->orderby('order_id', 'desc')
                 ->get()
                 ->toArray();
     
     if(count($get_data) > 0){
       $reports_data = $get_data;
     }
   }
   
   $currentPage = LengthAwarePaginator::resolveCurrentPage();
   $col = new Collection( $reports_data );
   $perPage = 10;
   $currentPageSearchResults = $col->slice(($currentPage - 1) * $perPage, $perPage)->all();
   $reports_object = new LengthAwarePaginator($currentPageSearchResults, count($col), $perPage);

   $reports_object->setPath( route('admin.earning_reports_content') );
 
   return $reports_object;
 }
 
 /**
  * Save vendor settings data
  *
	* @param null
  * @return void
  */
  public function saveVendorSettingsData(){
    if( Request::isMethod('post') && Session::token() == Input::get('_token') ){
      $vendor_settings = $this->option->getVendorSettingsData();
      $vendor_settings['term_n_conditions'] = string_encode(Input::get('terms_and_conditions_content'));
      
      $data = array(
                   'option_value' => serialize($vendor_settings)
      );
      
      if( Option::where('option_name', '_vendor_settings_data')->update($data)){
        Session::flash('success-message', Lang::get('admin.successfully_saved_msg') );
        return redirect()-> back();
      }
    }
  } 
  
  /**
  * Delete withdraw request
  *
  * @param delete_id
  * @return void
  */
    public function deleteVendorWithdrawRequest($parm){
    if($parm){
      if(VendorWithdraw::where('id', $parm)->delete()){
        return redirect()->back();
      }
    }
  }
}