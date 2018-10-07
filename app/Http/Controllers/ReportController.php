<?php
namespace shopist\Http\Controllers;

use shopist\Http\Controllers\Controller;
use shopist\Library\CommonFunction;
use shopist\Library\GetFunction;
use Carbon\Carbon;

class ReportController extends Controller
{
  public $classCommonFunction;
  public $classGetFunction;
  public $carbonObject;
  
  public function __construct(){
    $this->classCommonFunction  =  new CommonFunction();
    $this->classGetFunction     =  new GetFunction();
    $this->carbonObject         =  new Carbon();
	}	
  
  /**
   * 
   * Report list content
   *
   * @param null
   * @return response view
   */
  public function reportListContent(){
    $data = array();
    $data = $this->classCommonFunction->commonDataForAllPages();
     
    return view('pages.admin.reports.reports-main', $data);
  }
  
  /**
   * 
   * Report sales by product title content
   *
   * @param null
   * @return response view
   */
  public function reportSalesByProductTitle(){
    $data = array();
    $reports_data                    =  array();
		$reports_data['report_details']  =  array();
		$report_name                     =  '';
		$reports_data['report_date']     =  array();
		
    $data = $this->classCommonFunction->commonDataForAllPages();
		$reports_data['report_currency_symbol'] = get_current_currency_symbol();
    $productsTitleOrders  = $this->classGetFunction->get_orders_by_date_range($this->carbonObject->today()->toDateString(), $this->carbonObject->today()->toDateString());
		  
    if($productsTitleOrders && $productsTitleOrders->count() > 0){
      $reports_data['report_details']['gross_sales_by_product_title'] = $this->classGetFunction->get_reports_gross_products_title_data( $productsTitleOrders );
    }
    else{
      $reports_data['report_details']['gross_sales_by_product_title'] = array();
    }

    $report_name = 'sales_by_product_title';
    $reports_data['report_date'] = $this->carbonObject->today()->toFormattedDateString().' - '.$this->carbonObject->today()->toFormattedDateString();
    
    $reports_data['report_name'] = $report_name;
		$data['report_data'] = $reports_data;
    
     
    return view('pages.admin.reports.reports-content', $data);
  }
  
  /**
   * 
   * Report sales by month content
   *
   * @param null
   * @return response view
   */
  public function reportSalesByMonth(){
    $data = array();
    $reports_data                    =  array();
		$reports_data['report_details']  =  array();
		$report_name                     =  '';
		$reports_data['report_date']     =  array();
		
    $data = $this->classCommonFunction->commonDataForAllPages();
		$reports_data['report_currency_symbol'] = get_current_currency_symbol();
    $yearOrders    =   $this->classGetFunction->get_orders_by_year();
    
    if($yearOrders && $yearOrders->count() > 0){
      $get_order_details = $this->classGetFunction->get_order_by_specific_date_range($yearOrders);
      $reports_data['report_details']['gross_sales_by_month'] =  $this->classGetFunction->get_report_data_order_details_by_month($get_order_details);
    }
    else{
      $reports_data['report_details']['gross_sales_by_month'] = array();
    }

    $report_name = 'sales_by_month';
    $reports_data['report_date'] = 'Jan 01, '.$this->carbonObject->today()->year.' - '.$this->carbonObject->today()->toFormattedDateString();
    $reports_data['report_name'] = $report_name;
		$data['report_data'] = $reports_data;
     
    return view('pages.admin.reports.reports-content', $data);
  }
  
  /**
   * 
   * Report sales by last 7 days content
   *
   * @param null
   * @return response view
   */
  public function reportSalesByLast7Days(){
    $data = array();
    $reports_data                    =  array();
		$reports_data['report_details']  =  array();
		$report_name                     =  '';
		$reports_data['report_date']     =  array();
		
    $data = $this->classCommonFunction->commonDataForAllPages();
		$reports_data['report_currency_symbol'] = get_current_currency_symbol();
    
    $last7DaysOrders    =   $this->classGetFunction->get_orders_by_date_range($this->carbonObject->parse($this->carbonObject->today())->subWeeks(1)->toDateString(), $this->carbonObject->today()->toDateString());
			
    if($last7DaysOrders && $last7DaysOrders->count() >0){
      $reports_data['report_details']['sales_order_by_last_7_days']['table_data']  = $this->classGetFunction->get_order_by_specific_date_range($last7DaysOrders);
      $reports_data['report_details']['sales_order_by_last_7_days']['report_data'] = $this->classGetFunction->get_report_data_order_details($reports_data['report_details']['sales_order_by_last_7_days']['table_data']);
    }
    else{
      $reports_data['report_details']['sales_order_by_last_7_days']['table_data'] = array();
      $reports_data['report_details']['sales_order_by_last_7_days']['report_data'] = array();
    }

    $report_name = 'sales_by_last_7_days';
    $reports_data['report_date'] = $this->carbonObject->parse($this->carbonObject->today())->subWeeks(1)->toFormattedDateString().' - '.$this->carbonObject->today()->toFormattedDateString();
    
    $reports_data['report_name'] = $report_name;
		$data['report_data'] = $reports_data;
     
    return view('pages.admin.reports.reports-content', $data);
  }
  
  /**
   * 
   * Report sales by custom days content
   *
   * @param null
   * @return response view
   */
  public function reportSalesByCustomDaysDays(){
    $data = array();
    $reports_data                    =  array();
		$reports_data['report_details']  =  array();
		$report_name                     =  '';
		$reports_data['report_date']     =  array();
		
    $data = $this->classCommonFunction->commonDataForAllPages();
		$reports_data['report_currency_symbol'] = get_current_currency_symbol();
    
    $customDaysOrders    =   $this->classGetFunction->get_orders_by_date_range($this->carbonObject->today()->toDateString(), $this->carbonObject->today()->toDateString());
			
    if($customDaysOrders && $customDaysOrders->count() >0){
      $reports_data['report_details']['sales_order_by_custom_days']['table_data']  = $this->classGetFunction->get_order_by_specific_date_range($customDaysOrders);
      $reports_data['report_details']['sales_order_by_custom_days']['report_data'] = $this->classGetFunction->get_report_data_order_details($reports_data['report_details']['sales_order_by_custom_days']['table_data']);
    }
    else{
      $reports_data['report_details']['sales_order_by_custom_days']['table_data'] = array();
      $reports_data['report_details']['sales_order_by_custom_days']['report_data'] = array();
    }

    $report_name = 'sales_by_custom_days';
    $reports_data['report_date'] = $this->carbonObject->today()->toFormattedDateString().' - '.$this->carbonObject->today()->toFormattedDateString();
    
    $reports_data['report_name'] = $report_name;
		$data['report_data'] = $reports_data;
     
    return view('pages.admin.reports.reports-content', $data);
  }
  
  /**
   * 
   * Report sales by payment method content
   *
   * @param null
   * @return response view
   */
  public function reportSalesByPaymentMethod(){
    $data = array();
    $reports_data                    =  array();
		$reports_data['report_details']  =  array();
		$report_name                     =  '';
		$reports_data['report_date']     =  array();
		
    $data = $this->classCommonFunction->commonDataForAllPages();
		$reports_data['report_currency_symbol'] = get_current_currency_symbol();
    
    $getOrders    =   $this->classGetFunction->get_orders_by_date_range($this->carbonObject->today()->toDateString(), $this->carbonObject->today()->toDateString());
			
    if($getOrders && $getOrders->count() > 0){
      $reports_data['report_details']['gross_sales_by_payment_method'] = $this->classGetFunction->get_reports_payment_method_data( $getOrders );
    }
    else{
      $reports_data['report_details']['gross_sales_by_payment_method'] = array();
    }

    $report_name = 'sales_by_payment_method';
    $reports_data['report_date'] = $this->carbonObject->today()->toFormattedDateString().' - '.$this->carbonObject->today()->toFormattedDateString();
    
    $reports_data['report_name'] = $report_name;
		$data['report_data'] = $reports_data;
     
    return view('pages.admin.reports.reports-content', $data);
  }
}