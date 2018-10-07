<?php
namespace shopist\Http\Controllers\Common;

use shopist\Http\Controllers\Controller;
use Request;
use Response;
use shopist\Models\SaveCustomDesign;
use Illuminate\Support\Facades\Input;
use Session;
use Validator;
use Intervention\Image\Facades\Image;
use shopist\Library\GetFunction;
use Carbon\Carbon;
use shopist\Http\Controllers\DesignerElementsController;
use shopist\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\Lang;


class CommonAjaxController extends Controller
{
  public $classGetFunction;
  public $carbonObject;
  public $designer_elements;
  public $product;
  
  public function __construct()
  {
    $this->classGetFunction =   new GetFunction();  
    $this->carbonObject         = new Carbon();
    $this->designer_elements   =  new DesignerElementsController();
    $this->product             =  new ProductsController();
  }
  
  /**
   * 
   *Get function for clipart categories images
   *
   * @param null
   * @return html
   */
  public function getAvailableClipartCategoriesImagesWithHtml(){
    $input = Request::all();
    $str = '';
    
    if(Request::isMethod('post') && Request::ajax()){
      if(Session::token() == Request::header('X-CSRF-TOKEN')){
        $get_post = $this->designer_elements->getDesignerCatDataByCatId($input['id']);
        $get_term = $this->product->getTermDataById( $input['id'] );
        
        if(count($get_term) > 0){
          $term_name = array_shift($get_term)['name'];
        }
        
        $str .= '<div class="categories-images-list">';
        $str .= '<div class="breadcrumb-panel"><ol class="breadcrumb"><li><a href="#" class="show-categories-list">'. Lang::get('frontend.categories_list') .'</a></li><li class="active">'. $term_name .'</li></ol></div>';
        
        if( count($get_post)>0 ){
          foreach($get_post as $row){
            $str .= '<div class="categories-images-items">';
            $str .= '<img src="'. get_image_url($row->art_img) .'">';
            $str .= '</div>';
          }
          $str .= '<div class="clear_both"></div>';
        }
        else{
          $str .= '<div class="no-available-msg">'. Lang::get('frontend.no_related_data') .'</div>';
        }
        
        $str .= '</div>';
      }
    }
    
    return $str;
  }
  
  /**
   * 
   *Upload design images
   *
   * @param null
   * @return json
   */
  public function uploadDesignerImage()
  {
    if(Request::isMethod('post') && Request::ajax()){
      if(Session::token() == Request::header('X-CSRF-TOKEN')){
        $input = Input::all();
        $rules = array();

        $rules = array(
               'designer_upload_images' => 'image',
        );

        $validation = Validator::make($input, $rules);
         
        if ($validation->fails()) 
        {
          return Response::make($validation->errors->first(), 400);
        }
        else
        {
          $image = Input::file('designer_upload_images');
          $fileName = time()."-"."h-150-".$image->getClientOriginalName();
          $height = 150;
          
          $img   = Image::make($image);
          $path  = public_path('uploads/' . $fileName);
          
          $img->resize(null, $height, function ($constraint) {
                $constraint->aspectRatio();
          });
          
          if ($img->save($path)) 
          {
            if(Session::has('_recent_uploaded_images'))
            {
              $get_img_ary = Session::get('_recent_uploaded_images');
              $parse_ary = unserialize($get_img_ary);
              array_push($parse_ary, $fileName);
              
              Session::forget('_recent_uploaded_images');
              Session::put('_recent_uploaded_images', serialize($parse_ary));
            }
            elseif(!Session::has('_recent_uploaded_images'))
            {
              $img_ary = array($fileName);
              Session::put('_recent_uploaded_images', serialize($img_ary) );
            }
            return response()->json(array('status' => 'success', 'img_name' => $fileName));
          }
          else {
              return Response::json('error', 400);
          }
        }
      }
    }
  }
  
  /**
   * 
   *Save custom design
   *
   * @param null
   * @return void
   */
  public function saveCustomDesign()
  {
    if(Request::isMethod('post') && Request::ajax())
    {
      if(Session::token() == Request::header('X-CSRF-TOKEN'))
      {
        $input = Input::all();
        
        $save_custom_data =       new SaveCustomDesign;
        $get_data = SaveCustomDesign ::where('product_id', $input['product_id'])->first();
        
        
        
        if($get_data)
        {
          $data = array(
                      'product_id'        => $input['product_id'],
                      'design_data'       => json_encode($input['_data'])
          );
          if( $save_custom_data::where('product_id', $input['product_id'])->update($data))
          {
            return response()->json(array('status' => 'success'));
          }
        }
        else
        {
          $save_custom_data->product_id       = $input['product_id'];
          $save_custom_data->design_data	    = json_encode($input['_data']);
          
          if($save_custom_data->save())
          {
            return response()->json(array('status' => 'success'));
          }
        }
      }
    }
  }
  
  /**
   * 
   *Remove custom design
   *
   * @param null
   * @return json
   */
  public function removeCustomDesign(){
    if(Request::isMethod('post') && Request::ajax()){
      if(Session::token() == Request::header('X-CSRF-TOKEN')){
        $input = Input::all();
        
        if(SaveCustomDesign::where('product_id', $input['product_id'])->delete()){
          return response()->json(array('status' => 'deleted'));
        }
      }
    }
  }
  
  /**
   * 
   *Get function for difference reports
   *
   * @param null
   * @return void
   */
  public function getReportDataByFilter()
  {
    if(Request::isMethod('post') && Request::ajax() && Session::token() == Request::header('X-CSRF-TOKEN'))
    {
      $input          =   Input::all();
      $reports_data   =   array();
      $status         =   'success';
         
      $reports_data['report_date'] = $this->carbonObject->parse($input['dataObj']['_date_range_start_date'])->toFormattedDateString().' - '.$this->carbonObject->parse($input['dataObj']['_date_range_end_date'])->toFormattedDateString(); 
        
      
      if(isset($input['dataObj']['_report_name']) && $input['dataObj']['_report_name'] == 'sales_by_product_title')
      {
        $productsTitleOrders    =   $this->classGetFunction->get_orders_by_date_range($input['dataObj']['_date_range_start_date'], $input['dataObj']['_date_range_end_date']);
        
        if(!empty($productsTitleOrders) && $productsTitleOrders->count() > 0)
        {
          $reports_data['report_details'] = $this->classGetFunction->get_reports_gross_products_title_data( $productsTitleOrders );
        }
        else
        {
          $reports_data['report_details'] = array();
          $status = 'no_data';
        }
      }
      elseif(isset($input['dataObj']['_report_name']) && $input['dataObj']['_report_name'] == 'sales_by_custom_days')
      {
        $customDaysOrders    =   $this->classGetFunction->get_orders_by_date_range($input['dataObj']['_date_range_start_date'], $input['dataObj']['_date_range_end_date']);
        
        if($customDaysOrders && $customDaysOrders->count() >0)
        {
          $reports_data['report_details']['sales_order_by_custom_days']['table_data']  = $this->classGetFunction->get_order_by_specific_date_range($customDaysOrders);
          $reports_data['report_details']['sales_order_by_custom_days']['report_data'] = $this->classGetFunction->get_report_data_order_details($reports_data['report_details']['sales_order_by_custom_days']['table_data']);
        }
        else
        {
          $reports_data['report_details']['sales_order_by_custom_days']['table_data'] = array();
          $reports_data['report_details']['sales_order_by_custom_days']['report_data'] = array();
          $status = 'no_data';
        }
      }
      elseif(isset($input['dataObj']['_report_name']) && $input['dataObj']['_report_name'] == 'sales_by_payment_method')
      {
        $getOrders    =   $this->classGetFunction->get_orders_by_date_range($input['dataObj']['_date_range_start_date'], $input['dataObj']['_date_range_end_date']);
        
        if($getOrders && $getOrders->count() > 0)
        {
          $reports_data['report_details']['gross_sales_by_payment_method'] = $this->classGetFunction->get_reports_payment_method_data( $getOrders );
        }
        else
        {
          $reports_data['report_details']['gross_sales_by_payment_method'] = array();
          $status = 'no_data';
        }
      }
      
      return response()->json(array('status' => $status, 'data' => $reports_data));
    }
  }
}