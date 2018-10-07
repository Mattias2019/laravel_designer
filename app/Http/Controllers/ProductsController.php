<?php
namespace shopist\Http\Controllers;

use shopist\Http\Controllers\Controller;
use Request;
use Session;
use Validator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use shopist\Models\Term;
use shopist\Models\TermExtra;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Lang;
use shopist\Models\Post;
use shopist\Models\PostExtra;
use shopist\Models\Product;
use shopist\Models\ProductExtra;
use shopist\Models\ObjectRelationship;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use shopist\Http\Controllers\VendorsController;
use shopist\Http\Controllers\OptionController;
use shopist\Library\CommonFunction;
use Carbon\Carbon;
use shopist\Models\SaveCustomDesign;
use shopist\Library\GetFunction;



class ProductsController extends Controller
{
	public $option;
  public $carbonObject;
  public $classCommonFunction;
  public $cat_list_arr = array();
  public $parent_id = 0;
  public $vendors;


  public function __construct(){
		$this->option               =   new OptionController();
    $this->carbonObject         =   new Carbon();
    $this->classCommonFunction  =   new CommonFunction();
    $this->vendors              =   new VendorsController();
	}	
  
  /**
   * 
   * Product add content
   *
   * @param null
   * @return response view
   */
  public function productAddContent(){
    $data = array();
    $data = $this->classCommonFunction->commonDataForAllPages();
    $get_data = $this->createProductContentData( $data );
     
    return view('pages.admin.product.add-product-content', $get_data);
  }
  
  /**
   * 
   * Product update content
   *
   * @param null
   * @return response view
   */
  public function productUpdateContent( $params ){
    $get_post  =  Product :: where('slug', $params)->get()->toArray();
		  
    if(count($get_post) > 0){
      $data = array();
      $get_available_attribute =  array();
      $product_id = $get_post[0]['id'];
      
      $data = $this->classCommonFunction->commonDataForAllPages();
      $get_available_attribute	=  $this->getAllAttributes( $product_id );

      $data['attrs_list_data_by_product']     =   $get_available_attribute;
      $data['product_post_data']              =   $this->getProductDataById($product_id);
      $data['role_based_pricing_data']        =   get_role_based_pricing_by_product_id($product_id);
      $data['variation_data']                 =   $this->classCommonFunction->get_variation_and_data_by_product_id( $product_id );
      $data['custom_designer_settings_data']  =   $this->option->getCustomDesignerSettingsData();

      $get_variation_data = $this->classCommonFunction->get_variation_by_product_id( $product_id );

      if(!empty($get_variation_data)){
        $data['variation_json']  =  json_encode($get_variation_data);
      }
      else{
        $data['variation_json'] = null;
      }

      $get_post_attr  =  PostExtra::where(['post_id' => $product_id, 'key_name' => '_attribute_post_data'])->first();

      if(!empty($get_post_attr)){
        $data['attribute_post_meta_by_id'] = json_decode($get_post_attr->key_value);
      }
      else{
        $data['attribute_post_meta_by_id'] = null;
      }
      
      if($data['product_post_data']['_product_custom_designer_settings']['enable_global_settings'] == 'yes'){
        if(isset($data['custom_designer_settings_data']) && count($data['custom_designer_settings_data'])>0){
          $data['designer_hf_data']   =  $data['custom_designer_settings_data']['general_settings'];
        }
        else{
          $data['designer_hf_data'] = array();
        }
      }
      elseif($data['product_post_data']['_product_custom_designer_settings']['enable_global_settings'] == 'no'){
        if(isset($data['product_post_data']['_product_custom_designer_settings']) && count($data['product_post_data']['_product_custom_designer_settings']) >0){
          $data['designer_hf_data']   =   $data['product_post_data']['_product_custom_designer_settings'];
        }
        else{
          $data['designer_hf_data'] = array();
        }
      }
      
      $get_data = SaveCustomDesign ::where('product_id', $product_id)->first();

      if(!empty($get_data) && $get_data->count() > 0){
        $data['design_json_data']  =  $get_data['design_data'];
      }
      else{
        $data['design_json_data']  =  '';
      }

      $data['art_cat_lists_data']  =   $this->getTermData( 'designer_cat', false, null, 1 );
      $data['fonts_list']  =   $this->getFontsList(false, null, 1);
      $data['shape_list']  =   $this->getShapeList(false, null, 1);
      
      $generalTabActiveClass = '';
      $featureTabActiveClass = '';
      $customizeBtn          = 'style=display:none;';
      $tabSettings           = array();

      if($data['product_post_data']['post_type'] == 'simple_product' || $data['product_post_data']['post_type'] == 'downloadable_product'){
        $generalTabActiveClass = 'active';
      }
      elseif($data['product_post_data']['post_type'] == 'customizable_product'){
        $generalTabActiveClass = 'active';
        $customizeBtn          = 'style=display:none;';
      }
      elseif($data['product_post_data']['post_type'] == 'configurable_product'){
        $featureTabActiveClass = 'active';
      }

      $tabSettings['generalTab']   = $generalTabActiveClass;
      $tabSettings['featureTab']   = $featureTabActiveClass;
      $tabSettings['btnCustomize'] = $customizeBtn;

      $data['tabSettings'] = $tabSettings;


      $data['selected_cat']       =   $this->getCatByObjectId( $product_id );
      $data['selected_tag']       =   $this->getTagsByObjectId( $product_id );
      $data['selected_colors']    =   $this->getColorsByObjectId( $product_id );
      $data['selected_sizes']     =   $this->getSizesByObjectId( $product_id );
      $data['selected_brands']    =   $this->getManufacturerByObjectId( $product_id );
      $data['crosssell_products'] =   get_crosssell_products($product_id);

      $upsell_products = array();
      if(count(get_upsell_products($product_id)) > 0){
        foreach(get_upsell_products($product_id) as $upsell_ids){
          array_push($upsell_products, get_product_title($upsell_ids). ' #'.$upsell_ids);
        }
      }

      $data['upsell_products'] = json_encode( $upsell_products );

      $crosssell_products = array();
      if(count(get_crosssell_products($product_id)) > 0){
        foreach(get_crosssell_products($product_id) as $crosssell_ids){
          array_push($crosssell_products, get_product_title($crosssell_ids). ' #'.$crosssell_ids);
        }
      }

      $data['crosssell_products'] = json_encode( $crosssell_products );
      $get_data = $this->createProductContentData( $data );
      
      return view('pages.admin.product.update-product-content', $get_data);
    }
    else{
      return view('errors.no_data');
    }
  }
  
  /**
   * 
   * Product list content
   *
   * @param null
   * @return response view
   */
  public function productListContent( $params ){
    $data = array();
    $search_value = '';
      
    if(isset($_GET['term_product']) && $_GET['term_product'] != ''){
      $search_value = $_GET['term_product'];
    }
    
    $data = $this->classCommonFunction->commonDataForAllPages();
    $data['product_all_data']  =  $this->getProducts(true, $search_value, -1, $params);
    $data['search_value']      =  $search_value;
    
    return view('pages.admin.product.product-list', $data);
  }



  /**
   * 
   * Product categories list content
   *
   * @param null
   * @return response view
   */
  public function productCategoriesListContent(){
    $data = array();
    $search_value = '';
        
    if(isset($_GET['term_cat']) && $_GET['term_cat'] != ''){
      $search_value = $_GET['term_cat'];
    }
    
    $data = $this->classCommonFunction->commonDataForAllPages();
    $data['cat_list_data']           =  $this->getTermData( 'product_cat', true, $search_value, -1 );
    $data['only_cat_name']           =  $this->get_categories_name('product_cat');
    $data['search_value']            =  $search_value;
    $data['action']                  =  route('admin.product_categories_list');
    
    return view('pages.admin.categories-list', $data);
  }

  //daizheng

 public function productCategoriescustomListContent(){
    $data = array();
    $search_value = '';
        
    if(isset($_GET['term_cat']) && $_GET['term_cat'] != ''){
      $search_value = $_GET['term_cat'];
    }
    
    $data = $this->classCommonFunction->commonDataForAllPages();
    $data['cat_list_data']           =  $this->getTermCustomData( 'product_cat', true, $search_value, -1 );
    $data['only_cat_name']           =  $this->get_customcategories_name('product_cat');
    $data['search_value']            =  $search_value;
    $data['action']                  =  route('admin.product_categories_customlist');
    
    return view('pages.admin.categories-customlist', $data);
  }
  

    public function productTagscustomListContent(){
    $data = array();
    $search_value = '';
      
    if(isset($_GET['term_tag']) && $_GET['term_tag'] != ''){
      $search_value = $_GET['term_tag'];
    }
    
    $data = $this->classCommonFunction->commonDataForAllPages();
    $data['tag_list_data']   =  $this->getTermCustomData( 'product_tag', true, $search_value, -1 );
    $data['search_value']    =  $search_value;
    
    return view('pages.admin.product.product-tags-customlist', $data);
  }
  /**
   * 
   * Product tags list content
   *
   * @param null
   * @return response view
   */
  public function productTagsListContent(){
    $data = array();
    $search_value = '';
      
    if(isset($_GET['term_tag']) && $_GET['term_tag'] != ''){
      $search_value = $_GET['term_tag'];
    }
    
    $data = $this->classCommonFunction->commonDataForAllPages();
    $data['tag_list_data']   =  $this->getTermData( 'product_tag', true, $search_value, -1 );
    $data['search_value']    =  $search_value;
    
    return view('pages.admin.product.product-tags-list', $data);
  }

  
  
  /**
   * 
   * Product attributes list content
   *
   * @param null
   * @return response view
   */
  public function productAttributesListContent(){
    $data = array();
    $search_value = '';
      
    if(isset($_GET['term_attrs']) && $_GET['term_attrs'] != ''){
      $search_value = $_GET['term_attrs'];
    }
    
    $data = $this->classCommonFunction->commonDataForAllPages();
    $data['attribute_list_data']   =  $this->getTermData( 'product_attr', true, $search_value, -1 );
    $data['search_value']          =  $search_value;
    
    return view('pages.admin.product.product-attribute-list', $data);
  }
  
  /**
   * 
   * Product colors list content
   *
   * @param null
   * @return response view
   */
  public function productColorsListContent(){
    $data = array();
    $search_value = '';
      
    if(isset($_GET['term_colors']) && $_GET['term_colors'] != ''){
      $search_value = $_GET['term_colors'];
    }
    
    $data = $this->classCommonFunction->commonDataForAllPages();
    $data['colors_list_data']   =   $this->getTermData( 'product_colors', true, $search_value, -1 );
    $data['search_value']       =   $search_value;
    
    return view('pages.admin.product.product-colors-list', $data);
  }
  
  /**
   * 
   * Product sizes list content
   *
   * @param null
   * @return response view
   */
  public function productSizesListContent(){
    $data = array();
    $search_value = '';
      
    if(isset($_GET['term_sizes']) && $_GET['term_sizes'] != ''){
      $search_value = $_GET['term_sizes'];
    }
    
    $data = $this->classCommonFunction->commonDataForAllPages();
    $data['sizes_list_data']   =   $this->getTermData( 'product_sizes', true, $search_value, -1 );
    $data['search_value']      =   $search_value;
    
    return view('pages.admin.product.product-sizes-list', $data);
  }

  /**
   * 
   * Product comments list content
   *
   * @param null
   * @return response view
   */
  public function productCommentsListContent(){
    $data = array();
    
    $data = $this->classCommonFunction->commonDataForAllPages();
    $data['product_comments'] = $this->getProductCommentsList();
    
    return view('pages.admin.product.comments-list', $data);
  }

  
  /**
   * 
   * Get term data
   *
   * @param term type, pagination, search value, status flag
   * @param term type required
   * @param pagination required. Boolean type TRUE or FALSE, by default false
   * @param search value optional
	 * @param status flag by default -1. -1 for all data, 1 for status enable and 0 for disable status
   * @return array
   */
  // 900
	public function getTermData( $term_type, $pagination = false, $search_val = null, $status_flag = -1){
    $term_data = array();
    
    if($status_flag == -1){
        $where = ['type' => $term_type];
    }
    else{
        $where = ['type' => $term_type, 'status' => $status_flag];
    }
				
    if($search_val && $search_val != ''){
      $get_term_data = Term:: where($where)
                       ->where('name', 'LIKE', $search_val.'%')
                       ->orderBy('term_id', 'desc')
                       ->get()
                       ->toArray();
    }
    else{
      $get_term_data = Term:: where($where)
                       ->orderBy('term_id', 'desc')
                       ->get()
                       ->toArray();
    }
    	
    if(count($get_term_data) >0){
      foreach($get_term_data as $term){
        $term_extra = TermExtra:: where(['term_id' => $term['term_id']])
                      ->get();
       
        if(!empty($term_extra) && $term_extra->count() > 0){
          foreach($term_extra as $term_extra_row){
            
            if(!empty($term_extra_row) && $term_extra_row->key_name == '_category_img_url'){
              if(!empty($term_extra_row->key_value)){
                $term['category_img_url'] = $term_extra_row->key_value;
              }
              else{
                $term['category_img_url'] = '';
              }
            }
            elseif(!empty($term_extra_row) && $term_extra_row->key_name == '_category_description'){
              if(!empty($term_extra_row->key_value)){
                $term['category_description'] = $term_extra_row->key_value;
              }
              else{
                $term['category_description'] = '';
              }
            }
            elseif(!empty($term_extra_row) && $term_extra_row->key_name == '_tag_description'){
              if(!empty($term_extra_row->key_value)){
                $term['tag_description'] = $term_extra_row->key_value;
              }
              else{
                $term['tag_description'] = '';
              }
            }
            elseif(!empty($term_extra_row) && $term_extra_row->key_name == '_product_attr_values'){
              if(!empty($term_extra_row->key_value)){
                $term['product_attr_values'] = $term_extra_row->key_value;
              }
              else{
                $term['product_attr_values'] = '';
              }
            }
            elseif(!empty($term_extra_row) && $term_extra_row->key_name == '_product_color_code'){
              if(!empty($term_extra_row->key_value)){
                $term['color_code'] = $term_extra_row->key_value;
              }
              else{
                $term['color_code'] = '';
              }
            }
            elseif(!empty($term_extra_row) && $term_extra_row->key_name == '_brand_country_name'){
              if(!empty($term_extra_row->key_value)){
                $term['brand_country_name'] = $term_extra_row->key_value;
              }
              else{
                $term['brand_country_name'] = '';
              }
            }
            elseif(!empty($term_extra_row) && $term_extra_row->key_name == '_brand_short_description'){
              if(!empty($term_extra_row->key_value)){
                $term['brand_short_description'] = $term_extra_row->key_value;
              }
              else{
                $term['brand_short_description'] = '';
              }
            }
            elseif(!empty($term_extra_row) && $term_extra_row->key_name == '_brand_logo_img_url'){
              if(!empty($term_extra_row->key_value)){
                $term['brand_logo_img_url'] = $term_extra_row->key_value;
              }
              else{
                $term['brand_logo_img_url'] = '';
              }
            }
          }
        }
        
        array_push($term_data, $term);
      }
    }
    
    if($pagination){
      $currentPage = LengthAwarePaginator::resolveCurrentPage();
      $col = new Collection( $term_data );
      $perPage = 10;
      $currentPageSearchResults = $col->slice(($currentPage - 1) * $perPage, $perPage)->all();
      $term_object = new LengthAwarePaginator($currentPageSearchResults, count($col), $perPage);

      if($term_type == 'product_cat'){
        $term_object->setPath( route('admin.product_categories_list') );  
      }
      elseif($term_type == 'product_tag'){
        $term_object->setPath( route('admin.product_tags_list') );  
      }
      elseif($term_type == 'product_attr'){
        $term_object->setPath( route('admin.product_attributes_list') );  
      }
      elseif($term_type == 'product_brands'){
        $term_object->setPath( route('admin.manufacturers_list_content') );  
      }
    }
    
    if($pagination){
      return $term_object;
    }
    else{
      return $term_data;
    }
  }
  

  //daizheng

  public function getTermCustomData( $term_type, $pagination = false, $search_val = null, $status_flag = -1){
    $term_data = array();
    
    if($status_flag == -1){
        $where = ['type' => $term_type];
    }
    else{
        $where = ['type' => $term_type, 'status' => $status_flag];
    }
				
    if($search_val && $search_val != ''){
      $get_term_data = Term:: where($where)
                       ->where('name', 'LIKE', $search_val.'%')
                       ->orderBy('term_id', 'desc')
                       ->get()
                       ->toArray();
    }
    else{
      $get_term_data = Term:: where($where)
                       ->orderBy('term_id', 'desc')
                       ->get()
                       ->toArray();
    }
    	
    if(count($get_term_data) >0){
      foreach($get_term_data as $term){
        $term_extra = TermExtra:: where(['term_id' => $term['term_id']])
                      ->get();
       
        if(!empty($term_extra) && $term_extra->count() > 0){
          foreach($term_extra as $term_extra_row){
            
            if(!empty($term_extra_row) && $term_extra_row->key_name == '_category_img_url'){
              if(!empty($term_extra_row->key_value)){
                $term['category_img_url'] = $term_extra_row->key_value;
              }
              else{
                $term['category_img_url'] = '';
              }
            }
            elseif(!empty($term_extra_row) && $term_extra_row->key_name == '_category_description'){
              if(!empty($term_extra_row->key_value)){
                $term['category_description'] = $term_extra_row->key_value;
              }
              else{
                $term['category_description'] = '';
              }
            }
            elseif(!empty($term_extra_row) && $term_extra_row->key_name == '_tag_description'){
              if(!empty($term_extra_row->key_value)){
                $term['tag_description'] = $term_extra_row->key_value;
              }
              else{
                $term['tag_description'] = '';
              }
            }
            elseif(!empty($term_extra_row) && $term_extra_row->key_name == '_product_attr_values'){
              if(!empty($term_extra_row->key_value)){
                $term['product_attr_values'] = $term_extra_row->key_value;
              }
              else{
                $term['product_attr_values'] = '';
              }
            }
            elseif(!empty($term_extra_row) && $term_extra_row->key_name == '_product_color_code'){
              if(!empty($term_extra_row->key_value)){
                $term['color_code'] = $term_extra_row->key_value;
              }
              else{
                $term['color_code'] = '';
              }
            }
            elseif(!empty($term_extra_row) && $term_extra_row->key_name == '_brand_country_name'){
              if(!empty($term_extra_row->key_value)){
                $term['brand_country_name'] = $term_extra_row->key_value;
              }
              else{
                $term['brand_country_name'] = '';
              }
            }
            elseif(!empty($term_extra_row) && $term_extra_row->key_name == '_brand_short_description'){
              if(!empty($term_extra_row->key_value)){
                $term['brand_short_description'] = $term_extra_row->key_value;
              }
              else{
                $term['brand_short_description'] = '';
              }
            }
            elseif(!empty($term_extra_row) && $term_extra_row->key_name == '_brand_logo_img_url'){
              if(!empty($term_extra_row->key_value)){
                $term['brand_logo_img_url'] = $term_extra_row->key_value;
              }
              else{
                $term['brand_logo_img_url'] = '';
              }
            }
          }
        }
        
        array_push($term_data, $term);
      }
    }
    
    if($pagination){
      $currentPage = LengthAwarePaginator::resolveCurrentPage();
      $col = new Collection( $term_data );
      $perPage = 10;
      $currentPageSearchResults = $col->slice(($currentPage - 1) * $perPage, $perPage)->all();
      $term_object = new LengthAwarePaginator($currentPageSearchResults, count($col), $perPage);

      if($term_type == 'product_cat'){
        $term_object->setPath( route('admin.product_categories_list') );  
      }
      elseif($term_type == 'product_tag'){
        $term_object->setPath( route('admin.product_tags_list') );  
      }
      elseif($term_type == 'product_attr'){
        $term_object->setPath( route('admin.product_attributes_list') );  
      }
      elseif($term_type == 'product_brands'){
        $term_object->setPath( route('admin.manufacturers_list_content') );  
      }
    }
    
    if($pagination){
      return $term_object;
    }
    else{
      return $term_data;
    }
  }
  
  /**
   * 
   * Get term data by term id
   *
   * @param term id
   * @param term id required
   * @return array
   */
	public function getTermDataById( $term_id ){
    $term_data = array();
    
    $get_term_data = Term:: where(['term_id' => $term_id])
                     ->get()
                     ->toArray();
    	
    if(count($get_term_data) >0){
      foreach($get_term_data as $term){
        $term_extra = TermExtra:: where(['term_id' => $term['term_id']])
                      ->get();
       
        if(!empty($term_extra) && $term_extra->count() > 0){
          foreach($term_extra as $term_extra_row){
            if(!empty($term_extra_row) && $term_extra_row->key_name == '_category_img_url'){
              if(!empty($term_extra_row->key_value)){
                $term['category_img_url'] = $term_extra_row->key_value;
              }
              else{
                $term['category_img_url'] = '';
              }
            }
            elseif(!empty($term_extra_row) && $term_extra_row->key_name == '_category_description'){
              if(!empty($term_extra_row->key_value)){
                $term['category_description'] = $term_extra_row->key_value;
              }
              else{
                $term['category_description'] = '';
              }
            }
            elseif(!empty($term_extra_row) && $term_extra_row->key_name == '_tag_description'){
              if(!empty($term_extra_row->key_value)){
                $term['tag_description'] = $term_extra_row->key_value;
              }
              else{
                $term['tag_description'] = '';
              }
            }
            elseif(!empty($term_extra_row) && $term_extra_row->key_name == '_product_attr_values'){
              if(!empty($term_extra_row->key_value)){
                $term['product_attr_values'] = $term_extra_row->key_value;
              }
              else{
                $term['product_attr_values'] = '';
              }
            }
            elseif(!empty($term_extra_row) && $term_extra_row->key_name == '_product_color_code'){
              if(!empty($term_extra_row->key_value)){
                $term['color_code'] = $term_extra_row->key_value;
              }
              else{
                $term['color_code'] = '';
              }
            }
            elseif(!empty($term_extra_row) && $term_extra_row->key_name == '_brand_country_name'){
              if(!empty($term_extra_row->key_value)){
                $term['brand_country_name'] = $term_extra_row->key_value;
              }
              else{
                $term['brand_country_name'] = '';
              }
            }
            elseif(!empty($term_extra_row) && $term_extra_row->key_name == '_brand_short_description'){
              if(!empty($term_extra_row->key_value)){
                $term['brand_short_description'] = $term_extra_row->key_value;
              }
              else{
                $term['brand_short_description'] = '';
              }
            }
            elseif(!empty($term_extra_row) && $term_extra_row->key_name == '_brand_logo_img_url'){
              if(!empty($term_extra_row->key_value)){
                $term['brand_logo_img_url'] = $term_extra_row->key_value;
              }
              else{
                $term['brand_logo_img_url'] = '';
              }
            }
          }
        }
        
        array_push($term_data, $term);
      }
    }
    
    return $term_data;
  }
  
  /**
   * 
   * Get function for categories name
   *
   * @param cat type
   * @return array
   */

  //daizheng
  public function get_categories_name($cat_type){
    $cat_list_array   =   array();
    $get_cats         =   Term:: where(['type' => $cat_type, 'status' => 1,'fb' =>0])
                          ->get()
                          ->toArray();
    
    if(count($get_cats) > 0){
      foreach($get_cats as $row){     
        $cat_list['id']   = $row['term_id'];
        $cat_list['name'] = $row['name'];
        $cat_list['slug'] = $row['slug'];
        $cat_list_array[] = $cat_list;
      }
    }
    
    return $cat_list_array;
  }

  //daizheng

  public function get_customcategories_name($cat_type){
    $cat_list_array   =   array();
    $get_cats         =   Term:: where(['type' => $cat_type, 'status' => 1,'fb' =>1])
                          ->get()
                          ->toArray();
    
    if(count($get_cats) > 0){
      foreach($get_cats as $row){   
        $cat_list['id']   = $row['term_id'];
        $cat_list['name'] = $row['name'];
        $cat_list['slug'] = $row['slug'];
        $cat_list_array[] = $cat_list;
      }
    }
    
    return $cat_list_array;
  }
		
	/**
   * Get function for parent and child categories
   *
   * @param cat id, cat type
   * @return array
   */

   //daizheng
  public function get_categories($cat_id = 0, $cat_type){
    $get_categories_data  =  Term::where(['type' => $cat_type, 'parent' => $cat_id, 'status' => 1,'fb'=>0])->get();
    
    $categories = array();

    if($get_categories_data->count() > 0){
      foreach ($get_categories_data as $mainCategory){
        $category = array();
								
        $category['id']                    =  $mainCategory->term_id;
        $category['name']                  =  $mainCategory->name;
        $category['slug']                  =  $mainCategory->slug;
        $category['parent']						     =  $mainCategory->parent;
								
				$term_extra = TermExtra:: where(['term_id' => $mainCategory->term_id])
                      ->get();
								
				if(!empty($term_extra) && $term_extra->count() > 0){
          foreach($term_extra as $term_extra_row){
            if(!empty($term_extra_row) && $term_extra_row->key_name == '_category_img_url'){
              if(!empty($term_extra_row->key_value)){
                $category['img_url'] = $term_extra_row->key_value;
              }
              else{
                $category['img_url'] = '';
              }
            }
            elseif(!empty($term_extra_row) && $term_extra_row->key_name == '_category_description'){
              if(!empty($term_extra_row->key_value)){
                $category['description'] = $term_extra_row->key_value;
              }
              else{
                $category['description'] = '';
              }
            }
					}
        }		
								
        $category['children']    =  $this->get_categories($category['id'], $cat_type);

        if($mainCategory->parent == 0){
          $category['parent']    =  'Parent Category';
        }
        else{
          $category['parent']    =  'Sub Category';
        }

        $categories[$mainCategory->term_id] =  $category;
      }
    }
    
    return $categories;
  }

  //daizheng
  public function get_customcategories($cat_id = 0, $cat_type){
    $get_categories_data  =  Term::where(['type' => $cat_type, 'parent' => $cat_id, 'status' => 1,'fb'=>1])->get();
    
    $categories = array();

    if($get_categories_data->count() > 0){
      foreach ($get_categories_data as $mainCategory){
        $category = array();
								
        $category['id']                    =  $mainCategory->term_id;
        $category['name']                  =  $mainCategory->name;
        $category['slug']                  =  $mainCategory->slug;
        $category['parent']						     =  $mainCategory->parent;
								
				$term_extra = TermExtra:: where(['term_id' => $mainCategory->term_id])
                      ->get();
								
				if(!empty($term_extra) && $term_extra->count() > 0){
          foreach($term_extra as $term_extra_row){
            if(!empty($term_extra_row) && $term_extra_row->key_name == '_category_img_url'){
              if(!empty($term_extra_row->key_value)){
                $category['img_url'] = $term_extra_row->key_value;
              }
              else{
                $category['img_url'] = '';
              }
            }
            elseif(!empty($term_extra_row) && $term_extra_row->key_name == '_category_description'){
              if(!empty($term_extra_row->key_value)){
                $category['description'] = $term_extra_row->key_value;
              }
              else{
                $category['description'] = '';
              }
            }
					}
        }		
								
        $category['children']    =  $this->get_categories($category['id'], $cat_type);

        if($mainCategory->parent == 0){
          $category['parent']    =  'Parent Category';
        }
        else{
          $category['parent']    =  'Sub Category';
        }

        $categories[$mainCategory->term_id] =  $category;
      }
    }
    
    return $categories;
  }
		
	/**
   * Get function for parent categories
   *
   * @param cat id, cat type
   * @return array
   */
  public function get_parent_categories($cat_id = 0, $cat_type){
		$parent_categories = array();
    $get_categories_data  =  Term::where(['type' => $cat_type, 'parent' => $cat_id, 'status' => 1])->get()->toArray();
				
    if(count($get_categories_data) > 0){
        $parent_categories = $get_categories_data;
    }

    return $parent_categories;
  }
  
  //daizheng

  public function get_parent_customcategories($cat_id = 0, $cat_type){
		$parent_categories = array();
    $get_categories_data  =  Term::where(['type' => $cat_type, 'parent' => $cat_id, 'status' => 1])->get()->toArray();
				
    if(count($get_categories_data) > 0){
        $parent_categories = $get_categories_data;
    }

    return $parent_categories;
	}
  
  /**
   * Get function for all categories array list
   *
   * @param cat array
   * @return array
   */
  public function createCategoriesSimpleList($cat_arr = array()){
    if(count($cat_arr) > 0){
      foreach($cat_arr as $cat){
        $cat_data['id'] = $cat['id'];
        $cat_data['name'] = $cat['name'];
        $cat_data['slug'] = $cat['slug'];
        $cat_data['parent'] = $cat['parent'];
        // $cat_data['fb'] = $cat['fb'];
        $cat_data['description'] = $cat['description'];
        $cat_data['img_url'] = $cat['img_url'];
        
        array_push($this->cat_list_arr, $cat_data);
        
        if(count($cat['children']) >0){
          $this->categoriesSimpleListExtra($cat['children']);
        }
      }
    }
  
    return $this->cat_list_arr;
	}
  
  /**
   * Get function for all categories list extra
   *
   * @param cat array
   * @return array
   */
  public function categoriesSimpleListExtra($cat_arr = array()){
    if(count($cat_arr) > 0){
      foreach($cat_arr as $cat){
        $cat_data['id'] = $cat['id'];
        $cat_data['name'] = $cat['name'];
        $cat_data['slug'] = $cat['slug'];
        
        //daizheng
        $cat_data['fb'] = $cat['fb'];
        $cat_data['parent'] = $cat['parent'];
        $cat_data['description'] = $cat['description'];
        $cat_data['img_url'] = $cat['img_url'];
        
        array_push($this->cat_list_arr, $cat_data);
        
        if(count($cat['children']) >0){
          $this->categoriesSimpleListExtra($cat['children']);
        }
      }
    }
	}
  
  /**
   * 
   * Save products
   *
   * @param product slug
	 * @param product slug by default null
   * @return void
   */
  public function saveProduct($params = null){
    if( Request::isMethod('post') && Session::token() == Input::get('_token') ){
      
      //vendor product add restricted
      if(is_vendor_login() && Session::has('shopist_admin_user_id') && Input::get('hf_post_type') == 'add_post'){
        $selected_package_details = get_package_details_by_vendor_id( Session::get('shopist_admin_user_id') );
        $get_total_product = Product::where(['author_id' => Session::get('shopist_admin_user_id')])->first();
        
        if(!empty($get_total_product)){
          $count = $get_total_product->count() + 1;

          if($count > $selected_package_details->max_number_product){
            Session::flash('error-message', Lang::get('admin.vendor_product_exceed_msg', ['number' => $selected_package_details->max_number_product]) );
            return redirect()-> back();
          }
        }
      }
      
      $data = Input::all();

      $rules =  ['product_name'  => 'required'];

      $validator = Validator:: make($data, $rules);
      
      if($validator->fails()){
        return redirect()-> back()
        ->withInput()
        ->withErrors( $validator );
      }
      else{
        $product_id = 0;

        //downloadable product file manage
        $downloadable_product_data = array();
        $file_name = Input::get('downloadable_file_name');
        $uploaded_file_url = Input::get('downloadable_uploaded_file_url');
        $online_file_url = Input::get('downloadable_online_file_url');

        if(Input::has('downloadable_file_name') && Input::has('downloadable_uploaded_file_url') && Input::has('downloadable_online_file_url') && count($file_name) > 0 && count($uploaded_file_url) > 0 && count($online_file_url)){
          foreach($file_name as $key => $name){
            $url = str_replace(url('/'), '', $uploaded_file_url[$key]);
            $downloadable_product_data[$key] = array('file_name' => $name, 'uploaded_file_url' => $url, 'online_file_url' => $online_file_url[$key]);
          }
        }

        $download_limit = '';
        $download_expiry = '';

        if(Input::get('download_limit')){
          $download_limit = Input::get('download_limit');
        }


        //role based pricing
        $role_price = array();
        $available_user_role = get_available_user_roles();

        if(count($available_user_role) > 0 && Input::has('RoleRegularPricing') && Input::has('RoleSalePricing')){
          $role_based_regular_pricing = Input::get('RoleRegularPricing');
          $role_based_sale_pricing = Input::get('RoleSalePricing');


          foreach($role_based_regular_pricing as $key=> $role){
            $role_sale_price = '';
            $role_regular_price = $role;

            if($role_regular_price){
              $role_sale_price = $role_based_sale_pricing[$key];
            }

            $role_price[$key] = array('regular_price' => $role_regular_price, 'sale_price' => $role_sale_price);
          }
        }
        
        //manage cross sell and upsell products
        $selected_upsell_products = array();
        $selected_crosssell_products = array();
        
        $get_selected_upsell_product = json_decode(Input::get('selected_upsell_products'));
        $get_selected_crosssell_product = json_decode(Input::get('selected_crosssell_products'));
        
        if(!empty($get_selected_upsell_product) && count($get_selected_upsell_product) > 0){
          foreach($get_selected_upsell_product as $upsell_products){
            $explod_val = explode('#', $upsell_products);
            $get_id = end($explod_val);
            array_push($selected_upsell_products, $get_id);
          }
        }
        
        if(!empty($get_selected_crosssell_product) && count($get_selected_crosssell_product) > 0){
          foreach($get_selected_crosssell_product as $crosssell_products){
            $explod_val = explode('#', $crosssell_products);
            $get_id = end($explod_val);
            array_push($selected_crosssell_products, $get_id);
          }
        }
        
        
        if(!empty($params)){
          $get_post =  Product :: where('slug', $params)->get()->toArray();

          if(count($get_post) > 0){
            $product_id  =  $get_post[0]['id'];
          }
        }
        
        $price          = '';
        $regular_price  = '';
        $sale_price     = '';
        $stock_qty      = 0;
        $sale_price_start_date = '';
        $sale_price_end_date   = '';
        $stock_availability    = ''; 

        if(is_numeric(Input::get('inputRegularPrice'))){
          $regular_price = Input::get('inputRegularPrice');
        }

        if(is_numeric(Input::get('inputSalePrice')) && Input::has('inputRegularPrice')){
          $sale_price = Input::get('inputSalePrice');
        }


        if((Input::get('inputRegularPrice') && is_numeric(Input::get('inputRegularPrice'))) || (Input::get('inputSalePrice') && is_numeric(Input::get('inputSalePrice'))) ){
          if((Input::get('inputRegularPrice') && Input::get('inputSalePrice')) && Input::get('inputSalePrice') < Input::get('inputRegularPrice')){
            $price = Input::get('inputSalePrice');
          }
          else{
            $price = Input::get('inputRegularPrice');
          }
        }

        $today = date("Y-m-d");

        if(Input::get('inputSalePriceStartDate') >= $today){
          $sale_price_start_date = Input::get('inputSalePriceStartDate');
        }

        if(Input::get('inputSalePriceEndDate') >= $today){
          $sale_price_end_date = Input::get('inputSalePriceEndDate');
        }

        if(Input::get('download_expiry') >= $today){
          $download_expiry = Input::get('download_expiry');
        }

        if(is_numeric(Input::get('inputStockQty'))){
          $stock_qty = Input::get('inputStockQty');
        }


        $manage_stock         = 'yes';
        $enable_recommended   = 'yes';
        $enable_features      = 'yes';
        $enable_latest        = 'yes';
        $enable_related       = 'yes';
        $enable_custom_design = 'yes';
        $enable_taxes         = 'yes';
        $enable_review        = 'yes';
        $enable_p_page        = 'yes';
        $enable_d_page        = 'yes';
        $enable_review_totals = 'yes';
        $enable_product_video = 'yes';
        $enable_manufacturer  = 'yes';
        $visibilityschedule   = 'yes';
        $home_page_product    = 'yes';
        $is_pricing_enable    = 'no';

        $_stock           = (Input::has('manage_stock')) ? true : false;
        $_recommended     = (Input::has('enable_recommended_product')) ? true : false;
        $_features        = (Input::has('enable_features_product')) ? true : false;
        $_latest          = (Input::has('enable_latest_product')) ? true : false;
        $_related         = (Input::has('inputEnableForRelatedProduct')) ? true : false;
        $_custom_design   = (Input::has('inputEnableForCustomDesignProduct')) ? true : false;
        $_taxes           = (Input::has('inputEnableTaxesForProduct')) ? true : false;
        $_review          = (Input::has('inputEnableReviews')) ? true : false;
        $_review_p_page   = (Input::has('inputEnableAddReviewLinkToProductPage')) ? true : false;
        $_review_d_page   = (Input::has('inputEnableAddReviewLinkToDetailsPage')) ? true : false;
        $_product_video   = (Input::has('inputEnableProductVideo')) ? true : false;
        $_manufacturer    = (Input::has('inputEnableProductManufacturer')) ? true : false;
        $_visibility      = (Input::has('inputVisibilitySchedule')) ? true : false;
        $_home_product    = (Input::has('inputEnableForHomePage')) ? true : false;
        $_is_role_based_pricing_enable    = (Input::has('inputEnableDisableRoleBasedPricing')) ? true : false;


        if($_stock){
          $manage_stock = 'yes';
        }
        else{
          $manage_stock = 'no';
        }

        if($_recommended){
          $enable_recommended = 'yes';
        }
        else{
          $enable_recommended = 'no';
        }

        if($_features){
          $enable_features = 'yes';
        }
        else{
          $enable_features = 'no';
        }

        if($_latest){
          $enable_latest = 'yes';
        }
        else{
          $enable_latest = 'no';
        }

        if($_related){
          $enable_related = 'yes';
        }
        else{
          $enable_related = 'no';
        }

        if($_custom_design && Input::get('change_product_type') == 'customizable_product'){
          $enable_custom_design = 'yes';
        }
        else{
          $enable_custom_design = 'yes';
        }

        if($_taxes){
          $enable_taxes = 'yes';
        }
        else{
          $enable_taxes = 'no';
        }

        if($_review){
          $enable_review = 'yes';
        }
        else{
          $enable_review = 'no';
        }

        if($_review_p_page){
          $enable_p_page = 'yes';
        }
        else{
          $enable_p_page = 'no';
        }

        if($_review_d_page){
          $enable_d_page = 'yes';
        }
        else{
          $enable_d_page = 'no';
        }

        if($_product_video){
          $enable_product_video = 'yes';
        }
        else{
          $enable_product_video = 'no';
        }

        if($_manufacturer){
          $enable_manufacturer = 'yes';
        }
        else{
          $enable_manufacturer = 'no';
        }

        if($_visibility){
          $visibilityschedule = 'yes';
        }
        else{
          $visibilityschedule = 'no';
        } 

        if($_home_product){
          $home_page_product = 'yes';
        }
        else{
          $home_page_product = 'no';
        }

        if($_is_role_based_pricing_enable){
          $is_pricing_enable = 'yes';
        }
        else{
          $is_pricing_enable = 'no';
        }

        if($manage_stock == 'yes'){
          if ($manage_stock == 'yes' && $stock_qty > 0 && (Input::get('back_to_order_status') == 'allow_notify_customer' || Input::get('back_to_order_status') == 'only_allow')) {
            $stock_availability = 'in_stock';
          }
          else{
            $stock_availability = 'out_of_stock';
          }
        }
        else{
          $stock_availability = Input::get('stock_availability_status');
        }


        //designer settings 
        $cavas_small_width = 0;
        $cavas_small_height = 0;
        $cavas_medium_width = 0;
        $cavas_medium_height = 0;
        $cavas_large_width = 0;
        $cavas_large_height = 0;

        $enable_design_layout = 'no';
        $enable_global_settings = 'no';

        $get_designer_settings = $this->option->getCustomDesignerSettingsData();

        $_is_enable_design_layout     = (Input::has('inputEnableDesignLayout')) ? true : false;
        $_is_enable_global_settings   = (Input::has('inputEnableGlobalSettings')) ? true : false;


        if($_is_enable_global_settings){
          $enable_global_settings = 'yes';
        }
        else{
          $enable_global_settings = 'no';
        }

        if($_is_enable_design_layout){
          $enable_design_layout = 'yes';
        }
        else{
          $enable_design_layout = 'no';
        }


        // canvas size
        if(Input::has('specific_canvas_small_devices_width') && $enable_global_settings == 'no'){
          $cavas_small_width = Input::get('specific_canvas_small_devices_width');
        }
        elseif ($enable_global_settings == 'yes') {
          $cavas_small_width = '';
        }
        else{
          $cavas_small_width = $get_designer_settings['general_settings']['canvas_dimension']['small_devices']['width'];
        }

        if(Input::has('specific_canvas_small_devices_height') && $enable_global_settings == 'no'){
          $cavas_small_height = Input::get('specific_canvas_small_devices_height');
        }
        elseif ($enable_global_settings == 'yes') {
          $cavas_small_height = '';
        }
        else{
          $cavas_small_height = $get_designer_settings['general_settings']['canvas_dimension']['small_devices']['height'];
        }


        if(Input::has('specific_canvas_medium_devices_width') && $enable_global_settings == 'no'){
          $cavas_medium_width = Input::get('specific_canvas_medium_devices_width');
        }
        elseif ($enable_global_settings == 'yes'){
          $cavas_medium_width = '';
        }
        else{
          $cavas_medium_width = $get_designer_settings['general_settings']['canvas_dimension']['medium_devices']['width'];
        }

        if(Input::has('specific_canvas_medium_devices_height') && $enable_global_settings == 'no'){
          $cavas_medium_height = Input::get('specific_canvas_medium_devices_height');
        }
        elseif ($enable_global_settings == 'yes'){
          $cavas_medium_height = '';
        }
        else{
          $cavas_medium_height = $get_designer_settings['general_settings']['canvas_dimension']['medium_devices']['height'];
        }


        if(Input::has('specific_canvas_large_devices_width') && $enable_global_settings == 'no'){
          $cavas_large_width = Input::get('specific_canvas_large_devices_width');
        }
        elseif ($enable_global_settings == 'yes'){
          $cavas_large_width = '';
        }
        else{
          $cavas_large_width = $get_designer_settings['general_settings']['canvas_dimension']['large_devices']['width'];
        }

        if(Input::has('specific_canvas_large_devices_height') && $enable_global_settings == 'no'){
          $cavas_large_height = Input::get('specific_canvas_large_devices_height');
        }
        elseif ($enable_global_settings == 'yes') {
          $cavas_large_height = '';
        }
        else{
          $cavas_large_height = $get_designer_settings['general_settings']['canvas_dimension']['large_devices']['height'];
        }


        $designer_settings = array(
          'canvas_dimension' => array('small_devices' => array('width' => $cavas_small_width, 'height' => $cavas_small_height), 'medium_devices' => array('width'=> $cavas_medium_width, 'height' => $cavas_medium_height), 'large_devices' => array('width' => $cavas_large_width, 'height' => $cavas_large_height)),
          'enable_layout_at_frontend' => $enable_design_layout,
          'enable_global_settings' => $enable_global_settings
        );


        $videoSourceName = '';

        if(Input::get('inputVideoSourceName')){
          $videoSourceName = Input::get('inputVideoSourceName');
        }

        $page_title = '';
        $url_slug   = '';

        if(Input::has('seo_title') && !empty(Input::get('seo_title'))){
          $page_title = Input::get('seo_title');
        }
        else{
          $page_title = Input::get('product_name');
        }

        if(Input::has('seo_url_format') && !empty(Input::get('seo_url_format'))){
          $url_slug = string_slug_format(Input::get('seo_url_format'));
        }
        else{
          $url_slug = string_slug_format(Input::get('product_name'));
        }

        $post        =  new Product;
        $post_slug   =  '';
        $check_slug  =  Product::where(['slug' => string_slug_format( $url_slug )])->orWhere('slug', 'like', '%' . string_slug_format( $url_slug ) . '%')->get()->count();

        if($check_slug === 0){
          $post_slug = string_slug_format( $url_slug );
        }
        elseif($check_slug > 0){
          $slug_count = $check_slug + 1;
          $post_slug = string_slug_format( $url_slug ). '-' . $slug_count;
        }


        $author_id = 0;
        if(Input::has('vendor_list') && !empty(Input::get('vendor_list'))){
          $author_id = Input::get('vendor_list');
        }
        else{
          $author_id = Session::get('shopist_admin_user_id');
        }

        $get_images = json_decode(Input::get('hf_uploaded_all_images'));
        $product_image = $get_images->product_image;

        if(Input::get('hf_post_type') == 'add_post'){
          $post->author_id          =   $author_id;
          $post->content            =   string_encode(Input::get('eb_description_editor'));
          $post->title              =   Input::get('product_name');
          $post->slug               =   $post_slug;
          $post->status             =   Input::get('product_visibility');
          $post->sku                =   Input::get('ProductSKU');
          $post->regular_price      =   $regular_price;
          $post->sale_price         =   $sale_price;
          $post->price              =   $price;
          $post->stock_qty          =   $stock_qty;
          $post->stock_availability =   $stock_availability;
          $post->type               =   Input::get('change_product_type');
          $post->image_url          =   $product_image;

          if($post->save()){  
            if(ProductExtra::insert(array(
                                      array(
                                          'product_id'    =>  $post->id,
                                          'key_name'      =>  '_product_related_images_url',
                                          'key_value'     =>  Input::get('hf_uploaded_all_images'),
                                          'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                          'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                      ),
                                      array(
                                          'product_id'    =>  $post->id,
                                          'key_name'      =>  '_product_sale_price_start_date',
                                          'key_value'     =>  $sale_price_start_date,
                                          'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                          'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                      ),
                                      array(
                                          'product_id'    =>  $post->id,
                                          'key_name'      =>  '_product_sale_price_end_date',
                                          'key_value'     =>  $sale_price_end_date,
                                          'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                          'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                      ),
                                      array(
                                          'product_id'    =>  $post->id,
                                          'key_name'      =>  '_product_manage_stock',
                                          'key_value'     =>  $manage_stock,
                                          'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                          'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                      ),
                                      array(
                                          'product_id'    =>  $post->id,
                                          'key_name'      =>  '_product_manage_stock_back_to_order',
                                          'key_value'     =>  Input::get('back_to_order_status'),
                                          'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                          'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                      ),
                                      array(
                                          'product_id'    =>  $post->id,
                                          'key_name'      =>  '_product_extra_features',
                                          'key_value'     =>  string_encode(Input::get('eb_features_editor')),
                                          'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                          'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                      ),
                                      array(
                                          'product_id'    =>  $post->id,
                                          'key_name'      =>  '_product_enable_as_recommended',
                                          'key_value'     =>  $enable_recommended,
                                          'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                          'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                      ),
                                      array(
                                          'product_id'    =>  $post->id,
                                          'key_name'      =>  '_product_enable_as_features',
                                          'key_value'     =>  $enable_features,
                                          'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                          'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                      ),
                                      array(
                                          'product_id'    =>  $post->id,
                                          'key_name'      =>  '_product_enable_as_latest',
                                          'key_value'     =>  $enable_latest,
                                          'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                          'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                      ),
                                      array(
                                          'product_id'    =>  $post->id,
                                          'key_name'      =>  '_product_enable_as_related',
                                          'key_value'     =>  $enable_related,
                                          'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                          'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                      ),
                                      array(
                                          'product_id'    =>  $post->id,
                                          'key_name'      =>  '_product_enable_as_custom_design',
                                          'key_value'     =>  $enable_custom_design,
                                          'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                          'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                      ),
                                      array(
                                          'product_id'    =>  $post->id,
                                          'key_name'      =>  '_product_enable_as_selected_cat',
                                          'key_value'     =>  $home_page_product,
                                          'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                          'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                      ),
                                      array(
                                          'product_id'    =>  $post->id,
                                          'key_name'      =>  '_product_enable_taxes',
                                          'key_value'     =>  $enable_taxes,
                                          'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                          'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                      ),
                                      array(
                                          'product_id'    =>  $post->id,
                                          'key_name'      =>  '_product_custom_designer_settings',
                                          'key_value'     =>  serialize($designer_settings),
                                          'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                          'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                      ),
                                      array(
                                          'product_id'    =>  $post->id,
                                          'key_name'      =>  '_product_custom_designer_data',
                                          'key_value'     =>  Input::get('hf_custom_designer_data'),
                                          'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                          'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                      ),
                                      array(
                                          'product_id'    =>  $post->id,
                                          'key_name'      =>  '_product_enable_reviews',
                                          'key_value'     =>  $enable_review,
                                          'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                          'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                      ),
                                      array(
                                          'product_id'    =>  $post->id,
                                          'key_name'      =>  '_product_enable_reviews_add_link_to_product_page',
                                          'key_value'     =>  $enable_p_page,
                                          'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                          'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                      ),
                                      array(
                                          'product_id'    =>  $post->id,
                                          'key_name'      =>  '_product_enable_reviews_add_link_to_details_page',
                                          'key_value'     =>  $enable_d_page,
                                          'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                          'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                      ),
                                      array(
                                          'product_id'    =>  $post->id,
                                          'key_name'      =>  '_product_enable_video_feature',
                                          'key_value'     =>  $enable_product_video,
                                          'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                          'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                      ),
                                      array(
                                          'product_id'    =>  $post->id,
                                          'key_name'      =>  '_product_video_feature_display_mode',
                                          'key_value'     =>  Input::get('inputVideoDisplayMode'),
                                          'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                          'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                      ),
                                      array(
                                          'product_id'    =>  $post->id,
                                          'key_name'      =>  '_product_video_feature_title',
                                          'key_value'     =>  Input::get('inputTitleForVideo'),
                                          'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                          'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                      ),
                                      array(
                                          'product_id'    =>  $post->id,
                                          'key_name'      =>  '_product_video_feature_panel_size',
                                          'key_value'     =>  serialize(array('width' => Input::get('inputVideoPanelWidth'), 'height' => Input::get('inputVideoPanelHeight'))),
                                          'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                          'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                      ),
                                      array(
                                          'product_id'    =>  $post->id,
                                          'key_name'      =>  '_product_video_feature_source',
                                          'key_value'     =>  $videoSourceName,
                                          'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                          'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                      ),
                                      array(
                                          'product_id'    =>  $post->id,
                                          'key_name'      =>  '_product_video_feature_source_embedded_code',
                                          'key_value'     =>  Input::get('inputEmbedCode'),
                                          'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                          'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                      ),
                                      array(
                                          'product_id'    =>  $post->id,
                                          'key_name'      =>  '_product_video_feature_source_online_url',
                                          'key_value'     =>  Input::get('inputAddOnlineVideoUrl'),
                                          'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                          'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                      ),
                                      array(
                                          'product_id'    =>  $post->id,
                                          'meta_key'      =>  '_product_enable_manufacturer',
                                          'meta_value'    =>  $enable_manufacturer,
                                          'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                          'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                      ),
                                      array(
                                          'product_id'    =>  $post->id,
                                          'key_name'      =>  '_product_enable_visibility_schedule',
                                          'key_value'     =>  $visibilityschedule,
                                          'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                          'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                      ),
                                      array(
                                          'product_id'    =>  $post->id,
                                          'key_name'      =>  '_product_seo_title',
                                          'key_value'     =>  $page_title,
                                          'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                          'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                      ),
                                      array(
                                          'product_id'    =>  $post->id,
                                          'key_name'      =>  '_product_seo_description',
                                          'key_value'     =>  Input::get('seo_description'),
                                          'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                          'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                      ),
                                      array(
                                          'product_id'    =>  $post->id,
                                          'key_name'      =>  '_product_seo_keywords',
                                          'key_value'     =>  Input::get('seo_keywords'),
                                          'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                          'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                      ),
                                      array(
                                          'product_id'    =>  $post->id,
                                          'key_name'      =>  '_product_compare_data',
                                          'key_value'     =>  serialize(Input::get('inputCompareData')),
                                          'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                          'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                      ),
                                      array(
                                          'product_id'    =>  $post->id,
                                          'key_name'      =>  '_is_role_based_pricing_enable',
                                          'key_value'     =>  $is_pricing_enable,
                                          'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                          'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                      ),
                                      array(
                                          'product_id'    =>  $post->id,
                                          'key_name'      =>  '_role_based_pricing',
                                          'key_value'     =>  serialize($role_price),
                                          'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                          'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                      ),
                                      array(
                                          'product_id'    =>  $post->id,
                                          'key_name'      =>  '_downloadable_product_files',
                                          'key_value'     =>  serialize($downloadable_product_data),
                                          'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                          'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                      ),
                                      array(
                                          'product_id'    =>  $post->id,
                                          'key_name'      =>  '_downloadable_product_download_limit',
                                          'key_value'     =>  $download_limit,
                                          'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                          'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                      ),
                                      array(
                                          'product_id'    =>  $post->id,
                                          'key_name'      =>  '_downloadable_product_download_expiry',
                                          'key_value'     =>  $download_expiry,
                                          'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                          'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                      ),
                                      array(
                                          'product_id'    =>  $post->id,
                                          'key_name'      =>  '_upsell_products',
                                          'key_value'     =>  serialize($selected_upsell_products),
                                          'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                          'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                      ),
                                      array(
                                          'product_id'    =>  $post->id,
                                          'key_name'      =>  '_crosssell_products',
                                          'key_value'     =>  serialize($selected_crosssell_products),
                                          'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                          'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                      ),
                                      array(
                                          'product_id'    =>  $post->id,
                                          'key_name'      =>  '_selected_vendor',
                                          'key_value'     =>  $author_id,
                                          'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                          'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                      )



            ))){

            //save categories
            if(Input::has('inputCategoriesName') && count(Input::get('inputCategoriesName'))>0){
              $cat_array = array();

              foreach(Input::get('inputCategoriesName') as $cat_id){
                $cat_data = array('term_id'  =>  $cat_id, 'object_id'  =>  $post->id, 'created_at'  =>  date("y-m-d H:i:s", strtotime('now')), 'updated_at'  =>  date("y-m-d H:i:s", strtotime('now')));

                array_push($cat_array, $cat_data);
              }

              if(count($cat_array) > 0){
                ObjectRelationship::insert( $cat_array );    
              }
            }

            //save manufacturer
            if(Input::has('inputManufacturerName') && count(Input::get('inputManufacturerName'))>0){
              $manufacturer_array = array();

              foreach(Input::get('inputManufacturerName') as $brands_id){
                $manufacturer_data = array('term_id'  =>  $brands_id, 'object_id'  =>  $post->id, 'created_at'  =>  date("y-m-d H:i:s", strtotime('now')), 'updated_at'  =>  date("y-m-d H:i:s", strtotime('now')));

                array_push($manufacturer_array, $manufacturer_data);   
              }

              if(count($manufacturer_array) > 0){
                ObjectRelationship::insert( $manufacturer_array );    
              }
            }

            //save tags
            if(Input::has('inputTagsName') && count(Input::get('inputTagsName'))>0){
              $tags_array = array();

              foreach(Input::get('inputTagsName') as $tags_id){
                $tags_data = array('term_id'  =>  $tags_id, 'object_id'  =>  $post->id, 'created_at'  =>  date("y-m-d H:i:s", strtotime('now')), 'updated_at'  =>  date("y-m-d H:i:s", strtotime('now')));

                array_push($tags_array, $tags_data);   
              }

              if(count($tags_array) > 0){
                ObjectRelationship::insert( $tags_array );    
              }
            }

            //save colors
            if(Input::has('inputColorsName') && count(Input::get('inputColorsName'))>0){
              $colors_array = array();

              foreach(Input::get('inputColorsName') as $colors_id){
                $colors_data = array('term_id'  =>  $colors_id, 'object_id'  =>  $post->id, 'created_at'  =>  date("y-m-d H:i:s", strtotime('now')), 'updated_at'  =>  date("y-m-d H:i:s", strtotime('now')));

                array_push($colors_array, $colors_data);   
              }

              if(count($colors_array) > 0){
                ObjectRelationship::insert( $colors_array );    
              }
            }

            //save sizes
            if(Input::has('inputSizesName') && count(Input::get('inputSizesName'))>0){
              $sizes_array = array();

              foreach(Input::get('inputSizesName') as $sizes_id){
                $sizes_data = array('term_id'  =>  $sizes_id, 'object_id'  =>  $post->id, 'created_at'  =>  date("y-m-d H:i:s", strtotime('now')), 'updated_at'  =>  date("y-m-d H:i:s", strtotime('now')));

                array_push($sizes_array, $sizes_data);   
              }

              if(count($sizes_array) > 0){
                ObjectRelationship::insert( $sizes_array );    
              }
            }

            Session::flash('success-message', Lang::get('admin.successfully_saved_msg') );
            return redirect()->route('admin.update_product', $post->slug);
            }
          }
        }
        elseif (Input::get('hf_post_type') == 'update_post'){
          $data = array(
                        'content'	           =>  string_encode(Input::get('eb_description_editor')),
                        'title'              =>  Input::get('product_name'),
                        'status'             =>  Input::get('product_visibility'),
                        'sku'                =>  Input::get('ProductSKU'),
                        'regular_price'      =>  $regular_price,
                        'sale_price'         =>  $sale_price,
                        'price'              =>  $price,
                        'stock_qty'          =>  $stock_qty,
                        'stock_availability' =>  $stock_availability,
                        'type'               =>  Input::get('change_product_type'),
                        'image_url'          =>  $product_image
          );
          if( Product::where('id', $product_id)->update($data)){
            $data_related_url = array(
                              'key_value'    =>  Input::get('hf_uploaded_all_images')
            );

            $data_sale_price_start_date = array(
                              'key_value'    =>  $sale_price_start_date,
            );

            $data_sale_price_end_date = array(
                              'key_value'    =>  $sale_price_end_date,
            );

            $data_manage_stock = array(
                              'key_value'    =>  $manage_stock
            );

            $data_manage_stock_back_to_order = array(
                              'key_value'    =>  Input::get('back_to_order_status')
            );

            $data_extra_features = array(
                              'key_value'    =>  string_encode(Input::get('eb_features_editor'))
            );

            $data_enable_recommended = array(
                              'key_value'    =>  $enable_recommended
            );

            $data_enable_features = array(
                              'key_value'    =>  $enable_features
            );

            $data_enable_latest = array(
                              'key_value'    =>  $enable_latest
            );

            $data_enable_related = array(
                              'key_value'    =>  $enable_related
            );

            $data_enable_custom_design = array(
                              'key_value'    =>  $enable_custom_design
            );

            $data_enable_home_product = array(
                              'key_value'    =>  $home_page_product
            );

            $data_enable_taxes = array(
                              'key_value'    =>  $enable_taxes
            );

            $data_custom_designer_settings = array(
                              'key_value'    =>  serialize($designer_settings)
            );

            $data_custom_designer_data = array(
                              'key_value'    =>  Input::get('hf_custom_designer_data')
            );

            $data_enable_review = array(
                              'key_value'    =>  $enable_review
            );

            $data_p_page = array(
                              'key_value'    =>  $enable_p_page
            );

            $data_d_page = array(
                              'key_value'    =>  $enable_d_page
            );

            $data_enable_product_video = array(
                              'key_value'    =>  $enable_product_video
            );

            $data_display_mode = array(
                              'key_value'    =>  Input::get('inputVideoDisplayMode')
            );

            $data_title_for_video = array(
                              'key_value'    =>  Input::get('inputTitleForVideo')
            );

            $data_video_feature_panel_size = array(
                              'key_value'    =>  serialize(array('width' => Input::get('inputVideoPanelWidth'), 'height' => Input::get('inputVideoPanelHeight')))
            );

            $data_video_source_name = array(
                              'key_value'    =>  $videoSourceName
            );

            $data_video_embed_code = array(
                              'key_value'    =>  Input::get('inputEmbedCode')
            );

            $data_video_online_url = array(
                              'key_value'    =>  Input::get('inputAddOnlineVideoUrl')
            );

            $data_enable_manufacturer = array(
                              'key_value'    =>  $enable_manufacturer
            );

            $data_visibilityschedule = array(
                              'key_value'    =>  $visibilityschedule
            );

            $data_seo_title = array(
                              'key_value'    =>  $page_title
            );

            $data_seo_description = array(
                              'key_value'    =>  Input::get('seo_description')
            );

            $data_seo_keywords = array(
                              'key_value'    =>  Input::get('seo_keywords')
            );

            $data_compare_product = array(
                              'key_value'    => serialize(Input::get('inputCompareData'))
            );

            $data_is_role_based_enable = array(
                              'key_value'    => $is_pricing_enable
            );

            $data_role_based_pricing = array(
                              'key_value'    => serialize($role_price)
            );

            $data_downloadable_product_files = array(
                              'key_value'    => serialize($downloadable_product_data)
            );

            $data_downloadable_product_download_limit = array(
                              'key_value'    => $download_limit
            );

            $data_downloadable_product_download_expiry = array(
                              'key_value'    => $download_expiry
            );

            $upsell_selected_product = array(
                              'key_value'    => serialize($selected_upsell_products)
            );

            $crosssell_selected_product = array(
                              'key_value'    => serialize($selected_crosssell_products)
            );

            $selected_vendor = array(
                              'key_value'    => $author_id
            );


            ProductExtra::where(['product_id' => $product_id, 'key_name' => '_product_related_images_url'])->update($data_related_url);
            ProductExtra::where(['product_id' => $product_id, 'key_name' => '_product_sale_price_start_date'])->update($data_sale_price_start_date);
            ProductExtra::where(['product_id' => $product_id, 'key_name' => '_product_sale_price_end_date'])->update($data_sale_price_end_date);
            ProductExtra::where(['product_id' => $product_id, 'key_name' => '_product_manage_stock'])->update($data_manage_stock);
            ProductExtra::where(['product_id' => $product_id, 'key_name' => '_product_manage_stock_back_to_order'])->update($data_manage_stock_back_to_order);
            ProductExtra::where(['product_id' => $product_id, 'key_name' => '_product_extra_features'])->update($data_extra_features);
            ProductExtra::where(['product_id' => $product_id, 'key_name' => '_product_enable_as_recommended'])->update($data_enable_recommended);
            ProductExtra::where(['product_id' => $product_id, 'key_name' => '_product_enable_as_features'])->update($data_enable_features);
            ProductExtra::where(['product_id' => $product_id, 'key_name' => '_product_enable_as_latest'])->update($data_enable_latest);
            ProductExtra::where(['product_id' => $product_id, 'key_name' => '_product_enable_as_related'])->update($data_enable_related);
            ProductExtra::where(['product_id' => $product_id, 'key_name' => '_product_enable_as_custom_design'])->update($data_enable_custom_design);
            ProductExtra::where(['product_id' => $product_id, 'key_name' => '_product_enable_as_selected_cat'])->update($data_enable_home_product);
            ProductExtra::where(['product_id' => $product_id, 'key_name' => '_product_enable_taxes'])->update($data_enable_taxes);
            ProductExtra::where(['product_id' => $product_id, 'key_name' => '_product_custom_designer_settings'])->update($data_custom_designer_settings);
            ProductExtra::where(['product_id' => $product_id, 'key_name' => '_product_custom_designer_data'])->update($data_custom_designer_data);
            ProductExtra::where(['product_id' => $product_id, 'key_name' => '_product_enable_reviews'])->update($data_enable_review);
            ProductExtra::where(['product_id' => $product_id, 'key_name' => '_product_enable_reviews_add_link_to_product_page'])->update($data_p_page);
            ProductExtra::where(['product_id' => $product_id, 'key_name' => '_product_enable_reviews_add_link_to_details_page'])->update($data_d_page);
            ProductExtra::where(['product_id' => $product_id, 'key_name' => '_product_enable_video_feature'])->update($data_enable_product_video);
            ProductExtra::where(['product_id' => $product_id, 'key_name' => '_product_video_feature_display_mode'])->update($data_display_mode);
            ProductExtra::where(['product_id' => $product_id, 'key_name' => '_product_video_feature_title'])->update($data_title_for_video);
            ProductExtra::where(['product_id' => $product_id, 'key_name' => '_product_video_feature_panel_size'])->update($data_video_feature_panel_size);
            ProductExtra::where(['product_id' => $product_id, 'key_name' => '_product_video_feature_source'])->update($data_video_source_name);
            ProductExtra::where(['product_id' => $product_id, 'key_name' => '_product_video_feature_source_embedded_code'])->update($data_video_embed_code);
            ProductExtra::where(['product_id' => $product_id, 'key_name' => '_product_video_feature_source_online_url'])->update($data_video_online_url);
            ProductExtra::where(['product_id' => $product_id, 'key_name' => '_product_enable_manufacturer'])->update($data_enable_manufacturer);
            ProductExtra::where(['product_id' => $product_id, 'key_name' => '_product_enable_visibility_schedule'])->update($data_visibilityschedule);
            ProductExtra::where(['product_id' => $product_id, 'key_name' => '_product_seo_title'])->update($data_seo_title);
            ProductExtra::where(['product_id' => $product_id, 'key_name' => '_product_seo_description'])->update($data_seo_description);
            ProductExtra::where(['product_id' => $product_id, 'key_name' => '_product_seo_keywords'])->update($data_seo_keywords);
            ProductExtra::where(['product_id' => $product_id, 'key_name' => '_product_compare_data'])->update($data_compare_product);
            ProductExtra::where(['product_id' => $product_id, 'key_name' => '_is_role_based_pricing_enable'])->update($data_is_role_based_enable);
            ProductExtra::where(['product_id' => $product_id, 'key_name' => '_role_based_pricing'])->update($data_role_based_pricing);
            ProductExtra::where(['product_id' => $product_id, 'key_name' => '_downloadable_product_files'])->update($data_downloadable_product_files);
            ProductExtra::where(['product_id' => $product_id, 'key_name' => '_downloadable_product_download_limit'])->update($data_downloadable_product_download_limit);
            ProductExtra::where(['product_id' => $product_id, 'key_name' => '_downloadable_product_download_expiry'])->update($data_downloadable_product_download_expiry);
            ProductExtra::where(['product_id' => $product_id, 'key_name' => '_selected_vendor'])->update($selected_vendor);
            ProductExtra::where(['product_id' => $product_id, 'key_name' => '_upsell_products'])->update($upsell_selected_product);
            ProductExtra::where(['product_id' => $product_id, 'key_name' => '_crosssell_products'])->update($crosssell_selected_product);

            $is_object_exist = ObjectRelationship::where('object_id', $product_id)->get();

            if(count($is_object_exist)>0){
              ObjectRelationship::where('object_id', $product_id)->delete();
            }

            //save categories
            if(Input::has('inputCategoriesName') && count(Input::get('inputCategoriesName'))>0){
              $cat_array = array();

              foreach(Input::get('inputCategoriesName') as $cat_id){
                $cat_data = array('term_id'  =>  $cat_id, 'object_id'  => $product_id, 'created_at'  =>  date("y-m-d H:i:s", strtotime('now')), 'updated_at'  =>  date("y-m-d H:i:s", strtotime('now')));

                array_push($cat_array, $cat_data);
              }

              if(count($cat_array) > 0){
                ObjectRelationship::insert( $cat_array );    
              }
            }

            //save manufacturer
            if(Input::has('inputManufacturerName') && count(Input::get('inputManufacturerName'))>0){
              $manufacturer_array = array();

              foreach(Input::get('inputManufacturerName') as $brands_id){
                $manufacturer_data = array('term_id'  => $brands_id, 'object_id'  => $product_id, 'created_at'  =>  date("y-m-d H:i:s", strtotime('now')), 'updated_at'  =>  date("y-m-d H:i:s", strtotime('now')));

                array_push($manufacturer_array, $manufacturer_data);   
              }

              if(count($manufacturer_array) > 0){
                ObjectRelationship::insert( $manufacturer_array );    
              }
            }

            //save tags
            if(Input::has('inputTagsName') && count(Input::get('inputTagsName'))>0){
              $tags_array = array();

              foreach(Input::get('inputTagsName') as $tags_id){
                $tags_data = array('term_id'  => $tags_id, 'object_id'  => $product_id, 'created_at'  =>  date("y-m-d H:i:s", strtotime('now')), 'updated_at'  =>  date("y-m-d H:i:s", strtotime('now')));

                array_push($tags_array, $tags_data);   
              }

              if(count($tags_array) > 0){
                ObjectRelationship::insert( $tags_array );    
              }
            }

            //save colors
            if(Input::has('inputColorsName') && count(Input::get('inputColorsName'))>0){
              $colors_array = array();

              foreach(Input::get('inputColorsName') as $colors_id){
                $colors_data = array('term_id'  => $colors_id, 'object_id'  => $product_id, 'created_at'  =>  date("y-m-d H:i:s", strtotime('now')), 'updated_at'  =>  date("y-m-d H:i:s", strtotime('now')));

                array_push($colors_array, $colors_data);   
              }

              if(count($colors_array) > 0){
                ObjectRelationship::insert( $colors_array );    
              }
            }

            //save sizes
            if(Input::has('inputSizesName') && count(Input::get('inputSizesName'))>0){
              $sizes_array = array();

              foreach(Input::get('inputSizesName') as $sizes_id){
                $sizes_data = array('term_id'  => $sizes_id, 'object_id'  => $product_id, 'created_at'  =>  date("y-m-d H:i:s", strtotime('now')), 'updated_at'  =>  date("y-m-d H:i:s", strtotime('now')));

                array_push($sizes_array, $sizes_data);   
              }

              if(count($sizes_array) > 0){
                ObjectRelationship::insert( $sizes_array );    
              }
            }

            Session::flash('success-message', Lang::get('admin.successfully_updated_msg' ));
            return redirect()->route('admin.update_product', $params);
          }
        }
      }  
    }
    else{
      return redirect()-> back();
    }
  }
  
  /**
   * Get function for products data
   *
   * @param products id
   * @param products id required
   * @return array
   */
  public function getProductDataById( $product_id ){
    $post_array       =   array();
    $get_post         =   Product :: where('id', $product_id)->first();
    $get_post_meta    =   ProductExtra :: where('product_id', $product_id)->get();
    
    if(!empty($get_post)){
      $post_array['id']                       =  $get_post->id;
      $post_array['author_id']                =  $get_post->author_id;
      $post_array['post_content']             =  $get_post->content;
      $post_array['post_title']               =  $get_post->title;
      $post_array['post_slug']                =  $get_post->slug;
      $post_array['post_status']              =  $get_post->status;
      $post_array['post_sku']                 =  $get_post->sku;
      $post_array['post_regular_price']       =  $get_post->regular_price;
      $post_array['post_sale_price']          =  $get_post->sale_price;
      $post_array['post_price']               =  $get_post->price;
      $post_array['post_stock_qty']           =  $get_post->stock_qty;
      $post_array['post_stock_availability']  =  $get_post->stock_availability;
      $post_array['post_type']                =  $get_post->type;
      $post_array['post_image_url']           =  $get_post->image_url;

      if(!empty($get_post_meta)){
        foreach($get_post_meta as $val){
          if($val->key_name == '_product_related_images_url'){
            $post_array[$val->key_name] = json_decode($val->key_value);
            $post_array['product_related_img_json'] = $val->key_value;
          }
          elseif($val->key_name == '_product_custom_designer_panel_size' || $val->key_name == '_product_video_feature_panel_size' ||  $val->key_name == '_product_selected_categories' || $val->key_name == '_product_selected_tags'){
            $post_array[$val->key_name] = unserialize($val->key_value);  
          }
          elseif($val->key_name == '_product_custom_designer_data'){
            $post_array[$val->key_name] = json_decode($val->key_value);
            $post_array['product_custom_designer_json'] = $val->key_value;
          }
          elseif($val->key_name == '_product_custom_designer_settings'){
            $post_array[$val->key_name] = unserialize($val->key_value);
          }
          elseif($val->key_name == '_product_compare_data' || $val->key_name == '_product_color_filter_data'){
            $post_array[$val->key_name] = unserialize($val->key_value);
          }
          elseif($val->key_name == '_role_based_pricing'){
            $post_array[$val->key_name] = unserialize($val->key_value);
          }
          elseif($val->key_name == '_downloadable_product_files'){
            $post_array[$val->key_name] = unserialize($val->key_value);
          }
          else{
            $post_array[$val->key_name] = $val->key_value;  
          }
        }
      }
    }
    
    return $post_array;
  }
  
  /**
   * Get function for brands products
   *
   * @param $term slug
   * @return array
   */
  public function getBrandDataBySlug($term_slug){
    $brand_data =  array();
    $get_brand_term = Term :: where(['slug' => $term_slug, 'type' => 'product_brands', 'status' => 1])->first();
    
    if(!empty($get_brand_term)){
      $brand_term_details = $this->getTermDataById($get_brand_term->term_id);
      $brand_data['brand_details']  =  array_shift($brand_term_details);
      
      $brand_data['products'] =  null;
      $get_object_data =  DB::table('products')
                          ->where(['products.status' => 1, 'object_relationships.term_id' => $get_brand_term->term_id ])
                          ->join('object_relationships', 'object_relationships.object_id', '=', 'products.id')
                          ->select('products.*')
                          ->orderBy('products.id', 'desc')
                          ->paginate(10);
      
      if(count($get_object_data) > 0){
        $brand_data['products'] =  $get_object_data;
      }
    }
     
    return $brand_data;
  }
  
  /**
   * Get function for categories list by object id
   *
   * @param object id
   * @return array
   */
  public function getCatByObjecterId($object_id){
    $get_cat_array = array('term_id' => array(), 'term_details' => array());
    $get_cat_list  =  DB::table('terms')
                      ->where(['object_relationships.object_id' => $object_id, 'terms.type' => 'product_cat' ])
                      ->join('object_relationships', 'object_relationships.term_id', '=', 'terms.term_id')
                      ->select('terms.*')        
                      ->get()
                      ->toArray();
     
    if(count($get_cat_list) > 0){
      $term_id   = array();
      $term_data = array();
      
      foreach($get_cat_list as $row){
        array_push($term_id, $row->term_id);
        
        $get_term = $this->getTermDataById( $row->term_id );
        if(count($get_term) > 0){
          array_push($term_data, array_shift( $get_term ));
        }
      }
      
      $get_cat_array['term_id']      = $term_id;
      $get_cat_array['term_details'] = $term_data;
    }
    
    return $get_cat_array;
  }
  public function getCatByObjectId($object_id){
    $get_cat_array = array('term_id' => array(), 'term_details' => array());
    $get_cat_list  =  DB::table('terms')
                      ->where(['object_relationships.object_id' => $object_id, 'terms.type' => 'product_cat' ])
                      ->join('object_relationships', 'object_relationships.term_id', '=', 'terms.term_id')
                      ->select('terms.*')        
                      ->get()
                      ->toArray();
     
    if(count($get_cat_list) > 0){
      $term_id   = array();
      $term_data = array();
      
      foreach($get_cat_list as $row){
        array_push($term_id, $row->term_id);
        
        $get_term = $this->getTermDataById( $row->term_id );
        if(count($get_term) > 0){
          array_push($term_data, array_shift( $get_term ));
        }
      }
      
      $get_cat_array['term_id']      = $term_id;
      $get_cat_array['term_details'] = $term_data;
    }
    
    return $get_cat_array;
  }

  //daizheng

  public function getCcatByObjectId($object_id){
    $get_cat_array = array('term_id' => array(), 'term_details' => array());
    $get_cat_list  =  DB::table('terms')
                      ->where(['object_relationships.object_id' => $object_id, 'terms.type' => 'product_cat', 'terms.fb' =>1 ])
                      ->join('object_relationships', 'object_relationships.term_id', '=', 'terms.term_id')
                      ->select('terms.*')        
                      ->get()
                      ->toArray();
     
    if(count($get_cat_list) > 0){
      $term_id   = array();
      $term_data = array();
      
      foreach($get_cat_list as $row){
        array_push($term_id, $row->term_id);
        
        $get_term = $this->getTermDataById( $row->term_id );
        if(count($get_term) > 0){
          array_push($term_data, array_shift( $get_term ));
        }
      }
      
      $get_cat_array['term_id']      = $term_id;
      $get_cat_array['term_details'] = $term_data;
    }
    
    return $get_cat_array;
  }
  
  /**
   * Get function for top parent
   *
   * @param cat id
   * @return parent id
   */
  public function getTopParentId($cat_id){
    $get_term = $this->getTermDataById($cat_id);
    
    if(count($get_term)>0){
      if($get_term[0]['parent'] > 0){
        $this->getTopParentId($get_term[0]['parent']);
      }
      else{
        $this->parent_id = $get_term[0]['term_id'];
      }
      
      if(!empty($this->parent_id) > 0){
        return $this->parent_id;
      }
    }
  }
  
  /**
   * Get function for tags list by object id
   *
   * @param object id
   * @return array
   */
  public function getTagsByObjectId($object_id){
    $get_tag_array = array('term_id' => array(), 'term_details' => array());
    $get_tag_list  =  DB::table('terms')
                      ->where(['object_relationships.object_id' => $object_id, 'terms.type' => 'product_tag' ])
                      ->join('object_relationships', 'object_relationships.term_id', '=', 'terms.term_id')
                      ->select('terms.*')        
                      ->get()
                      ->toArray();
     
    if(count($get_tag_list) > 0){
      $term_id = array();
      $term_data = array();
      
      foreach($get_tag_list as $row){
        array_push($term_id, $row->term_id);
        
        $get_term = $this->getTermDataById( $row->term_id );
        if(count($get_term) > 0){
          array_push($term_data, array_shift( $get_term ));
        }
      }
      
      $get_tag_array['term_id']      = $term_id;
      $get_tag_array['term_details'] = $term_data;
    }
    
    return $get_tag_array;
  }
  
  /**
   * Get function for colors list by object id
   *
   * @param object id
   * @return array
   */
  public function getColorsByObjectId($object_id){
    $get_colors_array = array('term_id' => array(), 'term_details' => array());
    $get_colors_list  =  DB::table('terms')
                         ->where(['object_relationships.object_id' => $object_id, 'terms.type' => 'product_colors' ])
                         ->join('object_relationships', 'object_relationships.term_id', '=', 'terms.term_id')
                         ->select('terms.*')        
                         ->get()
                         ->toArray();
     
    if(count($get_colors_list) > 0){
      $term_id = array();
      $term_data = array();
      
      foreach($get_colors_list as $row){
        array_push($term_id, $row->term_id);
        
        $get_term = $this->getTermDataById( $row->term_id );
        if(count($get_term) > 0){
          array_push($term_data, array_shift( $get_term ));
        }
      }
      
      $get_colors_array['term_id']      = $term_id;
      $get_colors_array['term_details'] = $term_data;
    }
    
    return $get_colors_array;
  }
  
  /**
   * Get function for sizes list by object id
   *
   * @param object id
   * @return array
   */
  public function getSizesByObjectId($object_id){
    $get_sizes_array = array('term_id' => array(), 'term_details' => array());
    $get_sizes_list  =  DB::table('terms')
                        ->where(['object_relationships.object_id' => $object_id, 'terms.type' => 'product_sizes' ])
                        ->join('object_relationships', 'object_relationships.term_id', '=', 'terms.term_id')
                        ->select('terms.*')        
                        ->get()
                        ->toArray();
     
    if(count($get_sizes_list) > 0){
      $term_id = array();
      $term_data = array();
      
      foreach($get_sizes_list as $row){
        array_push($term_id, $row->term_id);
        
        $get_term = $this->getTermDataById( $row->term_id );
        if(count($get_term) > 0){
          array_push($term_data, array_shift( $get_term ));
        }
      }
      
      $get_sizes_array['term_id']      = $term_id;
      $get_sizes_array['term_details'] = $term_data;
    }
    
    return $get_sizes_array;
  }
  
  /**
   * Get function for manufacturer list by object id
   *
   * @param object id
   * @return array
   */
  public function getManufacturerByObjectId($object_id){
    $get_brands_array = array('term_id' => array(), 'term_details' => array());
    $get_brands_list  = DB::table('terms')
                        ->where(['object_relationships.object_id' => $object_id, 'terms.type' => 'product_brands' ])
                        ->join('object_relationships', 'object_relationships.term_id', '=', 'terms.term_id')
                        ->select('terms.*')        
                        ->get()
                        ->toArray();
     
    if(count($get_brands_list) > 0){
      $term_id = array();
      $term_data = array();
      
      foreach($get_brands_list as $row){
        array_push($term_id, $row->term_id);
        
        $get_term = $this->getTermDataById( $row->term_id );
        if(count($get_term) > 0){
          array_push($term_data, array_shift( $get_term ));
        }
      }
      
      $get_brands_array['term_id']      = $term_id;
      $get_brands_array['term_details'] = $term_data;
    }
    
    return $get_brands_array;
  }
  
  /**
   * 
   * Get products list data
   *
   * @param pagination required. Boolean type TRUE or FALSE, by default false
   * @param search value optional
	 * @param status flag by default -1. -1 for all data, 1 for status enable and 0 for disable status
   * @return array
   */
  public function getProducts($pagination = false, $search_val = null, $status_flag = -1, $author_id){
    $where = '';
    
    if((is_vendor_login() && Session::has('shopist_admin_user_id')) || (!empty($author_id) && $author_id > 0 && $author_id != 'all')){
      $post_author_id = 0;
      
      if(!empty($author_id) && $author_id > 0 && $author_id != 'all'){
        $post_author_id = $author_id;
      }
      else{
        $post_author_id = Session::get('shopist_admin_user_id');
      }
       
      if($status_flag != -1){
        $where = ['author_id' => $post_author_id, 'status' => $status_flag];
      }
      else{
        $where = ['author_id' => $post_author_id];
      }
    }
    else{
      if($status_flag != -1){
        $where = ['status' => $status_flag];
      }
    }
    
    
    if(!empty($search_val) && $search_val != '' && !empty($where)){
      $get_posts_for_product = Product:: where($where)
                               ->where('title', 'LIKE', '%'. $search_val .'%')
                               ->orderBy('id', 'desc')
                               ->paginate(30);
    }
    elseif(!empty($search_val) && $search_val != '' && empty($where)){
      $get_posts_for_product = Product:: where('title', 'LIKE', '%'. $search_val .'%')
                               ->orderBy('id', 'desc')
                               ->paginate(30);
    }
    elseif (empty($search_val)  && !empty($where)) {
      $get_posts_for_product = Product:: where($where)
                               ->orderBy('id', 'desc')
                               ->paginate(30);
    }
    else{
      $get_posts_for_product = Product:: orderBy('id', 'desc')
                               ->paginate(30);
    }
        
    return $get_posts_for_product;
  }
  
  /**
   * Get products by user id and name
   *
   * @param user_id, user_name
   * @return array
   */
  public function getProductsByUserId( $user_id, $user_name, $filter = array() ){
	  $data_array    =  array();
    $product_data  =  array();
    $filter_arr    =  array();
    $get_posts_for_product = null;
    $final_data = array();
    
    $product_data['min_price']          =   0;
    $product_data['max_price']          =   300;
    $product_data['selected_colors']    =  array();
    $product_data['selected_sizes']     =  array();
    $product_data['selected_colors_hf'] =  '';
    $product_data['selected_sizes_hf']  =  '';
    $product_data['sort_by']            =  '';
    
    //color filter
    if(isset($filter['selected_colors'])){
      $parse_colors = explode(',', $filter['selected_colors']);

      if(count($parse_colors) > 0){
        $product_data['selected_colors'] = $parse_colors;

        foreach($parse_colors as $color){
          $get_color_term = Term::where(['slug' => $color, 'type' => 'product_colors'])->first();

          if(!empty($get_color_term) && $get_color_term->term_id){
            array_push($filter_arr, array('id' => $get_color_term->term_id, 'name' => $get_color_term->name, 'slug' => $get_color_term->slug, 'search_type' => 'color-filter'));
          }
        }
      }
    }
        
    //size filter
    if(isset($filter['selected_sizes'])){
      $parse_sizes = explode(',', $filter['selected_sizes']);

      if(count($parse_sizes) > 0){
        $product_data['selected_sizes']	 =  $parse_sizes;

        foreach($parse_sizes as $size){
          $get_size_term = Term::where(['slug' => $size, 'type' => 'product_sizes'])->first();

          if(!empty($get_size_term) && $get_size_term->term_id){
            array_push($filter_arr, array('id' => $get_size_term->term_id, 'name' => $get_size_term->name, 'slug' => $get_size_term->slug, 'search_type' => 'size-filter'));
          }
        }
      }
    }
      
    if(count($filter_arr) > 0){
      foreach($filter_arr as $term_filter){
        $get_posts_for_product  = DB::table('products')
                                  ->where(['products.author_id' => $user_id, 'products.status' => 1]);
        
        if( isset($filter['price_min']) && isset($filter['price_max']) && $filter['price_min'] >= 0 && $filter['price_max'] >=0){
          $get_posts_for_product->where(['object_relationships.term_id' => $term_filter['id']]);
          $get_posts_for_product->whereRaw('products.price >=' . $filter['price_min']);
          $get_posts_for_product->whereRaw('products.price <=' . $filter['price_max']);
          $get_posts_for_product->join('object_relationships', 'object_relationships.object_id', '=', 'products.id');
        }

        $get_posts_for_product->select('products.*'); 
        $get_posts_for_product = $get_posts_for_product->get()->toArray();
        
        if(count($get_posts_for_product) > 0){
          foreach($get_posts_for_product as $post){
            $post_data = (array)$post;
            $data_array[$post->id] = $post_data;
          }
        }
      }
    }
    else{
      $get_posts_for_product  = DB::table('products')
                                ->where(['author_id' => $user_id, 'status' => 1]);
      
      if( isset($filter['price_min']) && isset($filter['price_max']) && $filter['price_min'] >= 0 && $filter['price_max'] >=0 ){
        $get_posts_for_product->whereRaw('price >=' . $filter['price_min']);
        $get_posts_for_product->whereRaw('price <=' . $filter['price_max']);
      }
      
      $get_posts_for_product->select('products.*'); 
      
      //sorting
      if(isset($filter['sort']) && $filter['sort'] == 'alpaz'){
        $get_posts_for_product->orderBy('title', 'ASC');
      }
      elseif (isset($filter['sort']) && $filter['sort'] == 'alpza') {
        $get_posts_for_product->orderBy('title', 'DESC');
      }
      elseif (isset($filter['sort']) && $filter['sort'] == 'low-high') {
        $get_posts_for_product->orderBy('price', 'ASC');
      }
      elseif (isset($filter['sort']) && $filter['sort'] == 'high-low') {
        $get_posts_for_product->orderBy('price', 'DESC');
      }
      elseif (isset($filter['sort']) && $filter['sort'] == 'old-new') {
        $get_posts_for_product->orderBy('created_at', 'ASC');
      }
      elseif (isset($filter['sort']) && $filter['sort'] == 'new-old') {
        $get_posts_for_product->orderBy('created_at', 'DESC');
      }
      
      $get_posts_for_product = $get_posts_for_product->paginate(10);
    }
    
    if( isset($filter['price_min']) && isset($filter['price_max']) && $filter['price_min'] >= 0 && $filter['price_max'] >=0){
      $product_data['min_price']  =   $filter['price_min'];
      $product_data['max_price']  =   $filter['price_max'];
    }

    if(isset($filter['selected_colors'])){
      $product_data['selected_colors_hf'] =  $filter['selected_colors'];
    }

    if(isset($filter['selected_sizes'])){
      $product_data['selected_sizes_hf']  =  $filter['selected_sizes'];
    }

    if(isset($filter['sort'])){
      $product_data['sort_by'] = $filter['sort'];
    }
     
    
    if(count($filter_arr) > 0){
      if(count($data_array) > 0){
        if(isset($filter['sort']) && $filter['sort'] != 'all'){
          if($filter['sort'] == 'alpaz'){
            $data_array = $this->classCommonFunction->sortBy($data_array, 'title', 'asc');
          }
          elseif($filter['sort'] == 'alpza'){
            $data_array = $this->classCommonFunction->sortBy($data_array, 'title', 'desc');
          }
          elseif($filter['sort'] == 'low-high'){
            $data_array = $this->classCommonFunction->sortBy($data_array, 'price', 'asc');
          }
          elseif($filter['sort'] == 'high-low'){
            $data_array = $this->classCommonFunction->sortBy($data_array, 'price', 'desc');
          }
          elseif($filter['sort'] == 'old-new'){
            $data_array = $this->classCommonFunction->sortBy($data_array, 'created_at', 'asc');
          }
          elseif($filter['sort'] == 'new-old'){
            $data_array = $this->classCommonFunction->sortBy($data_array, 'created_at', 'desc');
          }
        }
        else{
          $data_array = $this->classCommonFunction->sortBy($data_array, 'id', 'desc');
        }
      }
    
      if(count($data_array) > 0){
        foreach($data_array as $row){
          array_push($final_data, (object)$row);
        }
      }
      
      $currentPage = LengthAwarePaginator::resolveCurrentPage();
      $col = new Collection( $final_data );
      $perPage = 10;
      $currentPageSearchResults = $col->slice(($currentPage - 1) * $perPage, $perPage)->all();
      $posts_object = new LengthAwarePaginator($currentPageSearchResults, count($col), $perPage);
      $posts_object->setPath(route('store-products-page-content', $user_name) );

      $product_data['products'] = $posts_object;
    }
    else{
      $product_data['products'] = $get_posts_for_product;
    }
    
    return $product_data;
  }

  /**
  * Get product comments list
  *
  * @param null
  * @return array
  */
  
  public function getProductCommentsList(){
    $comments_data = array();
    
    if(is_vendor_login() && Session::has('shopist_admin_user_id')){
      $where = ['products.author_id' => Session::get('shopist_admin_user_id'), 'comments.target' => 'product'];
    }
    else{
      $where = ['comments.target' => 'product'];
    }
    
    $get_comments = DB::table('comments')->where($where)
                    ->join('products', 'comments.object_id', '=', 'products.id')
                    ->join('users', 'comments.user_id', '=', 'users.id')
                    ->select('comments.*', 'products.title', 'products.slug', 'users.display_name', 'users.user_photo_url')   
                    ->get()
                    ->toArray();
      
    if(count($get_comments) > 0){
        $comments_data = $get_comments;
    }
    
    return $comments_data;
  }
  
  /**
   * Get function for advance products
   *
   * @param null
   * @return array
   */
  public function getAdvancedProducts(){
    $best_sales_arr      =  array();
    $todays_deal_arr     =  array();
    $advanced_arr        =  array();
    
    if(Request::is('/')){
      $get_recommended_items = DB::table('products')
                               ->select('products.*')
                               ->join(DB::raw("(SELECT product_id FROM product_extras WHERE key_name = '_product_enable_as_recommended' AND key_value = 'yes') T1") , 'products.id', '=', 'T1.product_id')
                               ->take(8)
                               ->get()
                               ->toArray();

      $get_features_items =    DB::table('products')
                               ->select('products.*')
                               ->join(DB::raw("(SELECT product_id FROM product_extras WHERE key_name = '_product_enable_as_features' AND key_value = 'yes') T1") , 'products.id', '=', 'T1.product_id')
                               ->take(8)
                               ->get()
                               ->toArray();
    }
    
    $get_latest_items =      DB::table('products')
                             ->select('products.*')
                             ->join(DB::raw("(SELECT product_id FROM product_extras WHERE key_name = '_product_enable_as_latest' AND key_value = 'yes') T1") , 'products.id', '=', 'T1.product_id')
                             ->take(5)
                             ->get()
                             ->toArray();
   
    if(Request::is('/')){ 
      $get_todays_items      =  DB::table('posts')
                                ->where('posts.post_type', 'shop_order')
                                ->whereDate('posts.created_at', '=', $this->carbonObject->today()->toDateString())
                                ->join('orders_items', 'orders_items.order_id', '=', 'posts.id')
                                ->orderBy('posts.id', 'desc')
                                ->select('orders_items.*')
                                ->take(5)
                                ->get()
                                ->toArray();
    }
    
    $get_best_sales        =  DB::table('product_extras')
                              ->select('product_id', DB::raw('max(cast(key_value as SIGNED INTEGER)) as max_number'))
                              ->where('key_name', '_total_sales')
                              ->groupBy('product_id')
                              ->orderBy('max_number', 'desc')
                              ->take(5)
                              ->get()
                              ->toArray();
     
    //best sales
    if(count($get_best_sales) > 0){
      foreach($get_best_sales as $items4){
        $get_post_for_best_sales = $this->getProductDataById($items4->product_id);
        
        if(count($get_post_for_best_sales)>0){
          array_push($best_sales_arr, $get_post_for_best_sales);
        }
      }
    }
    
    if(Request::is('/')){
      //todays deal
      if(count($get_todays_items) > 0){
        foreach($get_todays_items as $items5){
          if(!empty($items5->order_data)){
            $parse = json_decode($items5->order_data, true);

            if(count($parse) > 0){
              foreach($parse as $items6){
                if(isset($items6['id'])){
                  if(!$this->classCommonFunction->is_item_already_exists_in_array($items6['id'], $todays_deal_arr)){
                    $get_post_for_todays_deal = $this->getProductDataById($items6['id']);

                    if(count($get_post_for_todays_deal) > 0){
                      array_push($todays_deal_arr, $get_post_for_todays_deal);
                    }
                  }
                }
              }
            }
          }
        }
      }
    }
    
    if(Request::is('/')){
      $advanced_arr['recommended_items']  =   $get_recommended_items;
      $advanced_arr['features_items']     =   $get_features_items;
      $advanced_arr['todays_deal']        =   $todays_deal_arr; 
    }
    $advanced_arr['latest_items']         =   $get_latest_items;
    $advanced_arr['best_sales']           =   $best_sales_arr; 
     
    return $advanced_arr;
  }
  
  /**
   * Get function for vendor advance products
   *
   * @param vendor_id
   * @return array
   */
  public function getVendorAdvancedProducts( $vendor_id ){
    $best_sales_arr      =  array();
    $todays_deal_arr     =  array();
    $advanced_arr        =  array();
    
    $get_recommended_items = DB::table('products')
                             ->where('products.author_id', $vendor_id) 
                             ->select('products.*')
                             ->join(DB::raw("(SELECT product_id FROM product_extras WHERE key_name = '_product_enable_as_recommended' AND key_value = 'yes') T1") , 'products.id', '=', 'T1.product_id')
                             ->take(8)
                             ->get()
                             ->toArray();

    $get_features_items =    DB::table('products')
                             ->where('products.author_id', $vendor_id) 
                             ->select('products.*')
                             ->join(DB::raw("(SELECT product_id FROM product_extras WHERE key_name = '_product_enable_as_features' AND key_value = 'yes') T1") , 'products.id', '=', 'T1.product_id')
                             ->take(8)
                             ->get()
                             ->toArray();
    
    $get_latest_items =      DB::table('products')
                             ->where('products.author_id', $vendor_id) 
                             ->select('products.*')
                             ->join(DB::raw("(SELECT product_id FROM product_extras WHERE key_name = '_product_enable_as_latest' AND key_value = 'yes') T1") , 'products.id', '=', 'T1.product_id')
                             ->take(5)
                             ->get()
                             ->toArray();
    
    $get_todays_items      =  DB::table('posts')
                              ->where('posts.post_type', 'shop_order')
                              ->whereDate('posts.created_at', '=', $this->carbonObject->today()->toDateString())
                              ->join('orders_items', 'orders_items.order_id', '=', 'posts.id')
                              ->orderBy('posts.id', 'desc')
                              ->select('orders_items.*')
                              ->limit(10)
                              ->get()
                              ->toArray();
    
    $get_best_sales        =  DB::table('product_extras')
                              ->select('product_id', DB::raw('max(cast(key_value as SIGNED INTEGER)) as max_number'))
                              ->where('key_name', '_total_sales')
                              ->groupBy('product_id')
                              ->orderBy('max_number', 'desc')
                              ->limit(10)
                              ->get()
                              ->toArray();
     
    //best sales
    if(count($get_best_sales) > 0){
      foreach($get_best_sales as $items4){
        $get_post_for_best_sales = $this->getProductDataById($items4->product_id);
        
        if($get_post_for_best_sales['author_id'] == $vendor_id){
          if(count($get_post_for_best_sales)>0){
            array_push($best_sales_arr, $get_post_for_best_sales);
          }
        }
      }
    }
    
    //todays deal
    if(count($get_todays_items) > 0){
      foreach($get_todays_items as $items5){
        if(!empty($items5->order_data)){
          $parse = json_decode($items5->order_data, true);
          
          if(count($parse) > 0){
            foreach($parse as $items6){
              if(isset($items6['id'])){
                if(!$this->classCommonFunction->is_item_already_exists_in_array($items6['id'], $todays_deal_arr)){
                  $get_post_for_todays_deal = $this->getProductDataById($items6['id']);
                
                  if($get_post_for_todays_deal['author_id'] == $vendor_id){
                    if(count($get_post_for_todays_deal) > 0){
                      array_push($todays_deal_arr, $get_post_for_todays_deal);
                    }
                  }
                }
              }
            }
          }
        }
      }
    }
    
    $advanced_arr['recommended_items']    =   $get_recommended_items;
    $advanced_arr['features_items']       =   $get_features_items;
    $advanced_arr['latest_items']         =   $get_latest_items;
    $advanced_arr['best_sales']           =   $best_sales_arr; 
    $advanced_arr['todays_deal']          =   $todays_deal_arr; 
     
    return $advanced_arr;
  }
  
  /**
   * Get function for product search filter with pagination
   *
   * @param search options
   * @return array
   */
  public function getFilterProductsDataWithPagination( $filter = array() ){
    $data_array    =  array();
    $product_data  =  array();
    $filter_arr    =  array();
    $get_posts_for_product = null;
    $final_data = array();
    
    $product_data['min_price']          =   0;
    $product_data['max_price']          =   300;
    $product_data['selected_colors']    =  array();
    $product_data['selected_sizes']     =  array();
    $product_data['selected_colors_hf'] =  '';
    $product_data['selected_sizes_hf']  =  '';
    $product_data['sort_by']            =  '';
    
    //color filter
    if(isset($filter['selected_colors'])){
      $parse_colors = explode(',', $filter['selected_colors']);

      if(count($parse_colors) > 0){
        $product_data['selected_colors'] = $parse_colors;

        foreach($parse_colors as $color){
          $get_color_term = Term::where(['slug' => $color, 'type' => 'product_colors'])->first();

          if(!empty($get_color_term) && $get_color_term->term_id){
            array_push($filter_arr, array('id' => $get_color_term->term_id, 'name' => $get_color_term->name, 'slug' => $get_color_term->slug, 'search_type' => 'color-filter'));
          }
        }
      }
    }
        
    //size filter
    if(isset($filter['selected_sizes'])){
      $parse_sizes = explode(',', $filter['selected_sizes']);

      if(count($parse_sizes) > 0){
        $product_data['selected_sizes']	 =  $parse_sizes;

        foreach($parse_sizes as $size){
          $get_size_term = Term::where(['slug' => $size, 'type' => 'product_sizes'])->first();

          if(!empty($get_size_term) && $get_size_term->term_id){
            array_push($filter_arr, array('id' => $get_size_term->term_id, 'name' => $get_size_term->name, 'slug' => $get_size_term->slug, 'search_type' => 'size-filter'));
          }
        }
      }
    }
      
    if(count($filter_arr) > 0){
      foreach($filter_arr as $term_filter){
        $get_posts_for_product  = DB::table('products')
                                  ->where(['products.status' => 1]);
        
        if( isset($filter['price_min']) && isset($filter['price_max']) && $filter['price_min'] >= 0 && $filter['price_max'] >=0){
          $get_posts_for_product->where(['object_relationships.term_id' => $term_filter['id']]);
          $get_posts_for_product->whereRaw('products.price >=' . $filter['price_min']);
          $get_posts_for_product->whereRaw('products.price <=' . $filter['price_max']);
          $get_posts_for_product->join('object_relationships', 'object_relationships.object_id', '=', 'products.id');
        }

        $get_posts_for_product->select('products.*'); 
        $get_posts_for_product = $get_posts_for_product->get()->toArray();
        
        if(count($get_posts_for_product) > 0){
          foreach($get_posts_for_product as $post){
            $post_data = (array)$post;
            $data_array[$post->id] = $post_data;
          }
        }
      }
    }
    else{
      $get_posts_for_product  = DB::table('products')
                                ->where(['status' => 1]);
      
      if(isset($filter['srch_term'])){
        $get_posts_for_product->where('title', 'like', '%'. $filter['srch_term'] .'%');
      }
      
      if( isset($filter['price_min']) && isset($filter['price_max']) && $filter['price_min'] >= 0 && $filter['price_max'] >=0 ){
        $get_posts_for_product->whereRaw('price >=' . $filter['price_min']);
        $get_posts_for_product->whereRaw('price <=' . $filter['price_max']);
      }
      
      $get_posts_for_product->select('products.*'); 
      
      //sorting
      if(isset($filter['sort']) && $filter['sort'] == 'alpaz'){
        $get_posts_for_product->orderBy('title', 'ASC');
      }
      elseif (isset($filter['sort']) && $filter['sort'] == 'alpza') {
        $get_posts_for_product->orderBy('title', 'DESC');
      }
      elseif (isset($filter['sort']) && $filter['sort'] == 'low-high') {
        $get_posts_for_product->orderBy('price', 'ASC');
      }
      elseif (isset($filter['sort']) && $filter['sort'] == 'high-low') {
        $get_posts_for_product->orderBy('price', 'DESC');
      }
      elseif (isset($filter['sort']) && $filter['sort'] == 'old-new') {
        $get_posts_for_product->orderBy('created_at', 'ASC');
      }
      elseif (isset($filter['sort']) && $filter['sort'] == 'new-old') {
        $get_posts_for_product->orderBy('created_at', 'DESC');
      }
      
      $get_posts_for_product = $get_posts_for_product->paginate(10);
    }
    
    if( isset($filter['price_min']) && isset($filter['price_max']) && $filter['price_min'] >= 0 && $filter['price_max'] >=0){
      $product_data['min_price']  =   $filter['price_min'];
      $product_data['max_price']  =   $filter['price_max'];
    }

    if(isset($filter['selected_colors'])){
      $product_data['selected_colors_hf'] =  $filter['selected_colors'];
    }

    if(isset($filter['selected_sizes'])){
      $product_data['selected_sizes_hf']  =  $filter['selected_sizes'];
    }

    if(isset($filter['sort'])){
      $product_data['sort_by'] = $filter['sort'];
    }
     
    
    if(count($filter_arr) > 0){
      if(count($data_array) > 0){
        if(isset($filter['sort']) && $filter['sort'] != 'all'){
          if($filter['sort'] == 'alpaz'){
            $data_array = $this->classCommonFunction->sortBy($data_array, 'title', 'asc');
          }
          elseif($filter['sort'] == 'alpza'){
            $data_array = $this->classCommonFunction->sortBy($data_array, 'title', 'desc');
          }
          elseif($filter['sort'] == 'low-high'){
            $data_array = $this->classCommonFunction->sortBy($data_array, 'price', 'asc');
          }
          elseif($filter['sort'] == 'high-low'){
            $data_array = $this->classCommonFunction->sortBy($data_array, 'price', 'desc');
          }
          elseif($filter['sort'] == 'old-new'){
            $data_array = $this->classCommonFunction->sortBy($data_array, 'created_at', 'asc');
          }
          elseif($filter['sort'] == 'new-old'){
            $data_array = $this->classCommonFunction->sortBy($data_array, 'created_at', 'desc');
          }
        }
        else{
          $data_array = $this->classCommonFunction->sortBy($data_array, 'id', 'desc');
        }
      }
    
      if(count($data_array) > 0){
        foreach($data_array as $row){
          array_push($final_data, (object)$row);
        }
      }
      
      $currentPage = LengthAwarePaginator::resolveCurrentPage();
      $col = new Collection( $final_data );
      $perPage = 10;
      $currentPageSearchResults = $col->slice(($currentPage - 1) * $perPage, $perPage)->all();
      $posts_object = new LengthAwarePaginator($currentPageSearchResults, count($col), $perPage);
      $posts_object->setPath( route('shop-page') );

      $product_data['products'] = $posts_object;
    }
    else{
      $product_data['products'] = $get_posts_for_product;
    }
    
    return $product_data;
  }
  
  /**
   * Get function for products by cat slug
   *
   * @param cat options
   * @return array
   */
  public function getProductByCatSlug($cat_slug, $filter = array()){
    $data_array         =   array();
    $post_array         =   array();
    $selected_cat       =   array();
    $color_size_obj_id  =   array(); 
    $filter_arr         =   array();
    
    $get_term = Term::where(['slug' => $cat_slug, 'type' => 'product_cat'])->first();
     
    if(!empty($get_term) && isset($get_term->term_id)){
      $str    = '';
      $cat_id = $get_term->term_id;
      
      $post_array['min_price']          =  0;
      $post_array['max_price']          =  300;
      $post_array['selected_colors']    =  array();
      $post_array['selected_sizes']     =  array();
      $post_array['selected_colors_hf'] =  '';
      $post_array['selected_sizes_hf']  =  '';
      $post_array['sort_by']  =  '';
      
      $get_term_data = $this->getTermDataById( $get_term->term_id );
      $get_child_cat = $this->get_categories($get_term->term_id, 'product_cat');
      $parent_id     = $this->getTopParentId( $get_term->term_id );

      $cat_data['id']    =  $get_term_data[0]['term_id'];
      $cat_data['name']  =  $get_term_data[0]['name'];
      $cat_data['slug']  =  $get_term_data[0]['slug'];
      
      if($get_term_data[0]['parent'] == 0){
        $cat_data['parent']  =  'Parent Categories';
      }
      else{
        $cat_data['parent']  =  'Sub Categories';
      }
      
      $cat_data['parent_id']  =  $get_term_data[0]['parent'] ;
      $cat_data['description']  =  $get_term_data[0]['category_description'];
      $cat_data['img_url']  =  $get_term_data[0]['category_img_url'];
      $cat_data['search_type']  =  'category-filter';
      
      
      //color filter
      if(isset($filter['selected_colors'])){
        $parse_colors = explode(',', $filter['selected_colors']);

        if(count($parse_colors) > 0){
          $post_array['selected_colors'] = $parse_colors;
            
          foreach($parse_colors as $color){
            $get_color_term = Term::where(['slug' => $color, 'type' => 'product_colors'])->first();

            if(!empty($get_color_term) && $get_color_term->term_id){
              array_push($filter_arr, array('id' => $get_color_term->term_id, 'name' => $get_color_term->name, 'slug' => $get_color_term->slug, 'search_type' => 'color-filter'));
            }
          }
        }
      }
        
      //size filter
      if(isset($filter['selected_sizes'])){
        $parse_sizes = explode(',', $filter['selected_sizes']);

        if(count($parse_sizes) > 0){
          $post_array['selected_sizes']	 =  $parse_sizes;
          
          foreach($parse_sizes as $size){
            $get_size_term = Term::where(['slug' => $size, 'type' => 'product_sizes'])->first();

            if(!empty($get_size_term) && $get_size_term->term_id){
              array_push($filter_arr, array('id' => $get_size_term->term_id, 'name' => $get_size_term->name, 'slug' => $get_size_term->slug, 'search_type' => 'size-filter'));
            }
          }
        }
      }
      
      if(count($get_child_cat) > 0){
				$all_cat = array();
        $cats_arr = $this->createCategoriesSimpleList( $get_child_cat );
                
				if(count($cats_arr) > 0){
          $cats_arr = array_map(function($cats_arr){
            return $cats_arr + ['search_type' => 'category-filter'];
          }, $cats_arr);
          
          array_push($cats_arr, $cat_data);
					$all_cat = $cats_arr;
        }
        				
        if(count($filter_arr) > 0 && count($cats_arr) > 0){
          $cats_arr = array_merge($filter_arr, $cats_arr);
        }
        
        foreach($cats_arr as $cat){
          if( (count($filter_arr) > 0 && ($cat['search_type'] == 'color-filter' || $cat['search_type'] == 'size-filter')) || (count($filter_arr) == 0 && $cat['search_type'] == 'category-filter')){
            $get_post_data =  DB::table('products');
            $get_post_data->where(['products.status' => 1, 'object_relationships.term_id' => $cat['id'] ]);

            if( isset($filter['price_min']) && isset($filter['price_max']) && $filter['price_min'] >= 0 && $filter['price_max'] >=0){
              $get_post_data->whereRaw('products.price >=' . $filter['price_min']);
              $get_post_data->whereRaw('products.price <=' . $filter['price_max']);
            }

            $get_post_data->join('object_relationships', 'object_relationships.object_id', '=', 'products.id');

            $get_post_data->select('products.*');
            $get_post_data = $get_post_data->get()->toArray();
            
            if(count($get_post_data) > 0){
              foreach($get_post_data as $post){
                $filter_cat = array();
                
                if($cat['search_type'] == 'color-filter' || $cat['search_type'] == 'size-filter'){
                  $filter_cat = $this->getCatByObjectId( $post->id );
                }

                if( (($cat['search_type'] == 'color-filter' || $cat['search_type'] == 'size-filter') && $this->classCommonFunction->is_product_cat_in_selected_cat($filter_cat, $all_cat)) || ($cat['search_type'] == 'category-filter') ){
                  $post_data = (array)$post;
                  $data_array[$post->id] = $post_data;
                }
              }
            }
          }		

          if($cat['search_type'] == 'category-filter'){
            array_push($selected_cat, $cat['id']);
          }
        }
      }
      else{
        $parent_cat_ary = array();
        $parent_cat_ary[] = $cat_data;
        $all_cat = $parent_cat_ary;
        
        if(count($filter_arr) > 0){
          $parent_cat_ary = array_merge($filter_arr, $parent_cat_ary);
        }
        
        if(count($parent_cat_ary) > 0){
          foreach($parent_cat_ary as $cat){
            if( (count($filter_arr) > 0 && ($cat['search_type'] == 'color-filter' || $cat['search_type'] == 'size-filter')) || (count($filter_arr) == 0 && $cat['search_type'] == 'category-filter')){
              
              $get_post_data =  DB::table('products');
              $get_post_data->where(['products.status' => 1, 'object_relationships.term_id' => $cat['id'] ]);

              if( isset($filter['price_min']) && isset($filter['price_max']) && $filter['price_min'] >= 0 && $filter['price_max'] >=0){
                $get_post_data->whereRaw('products.price >=' . $filter['price_min']);
                $get_post_data->whereRaw('products.price <=' . $filter['price_max']);
              }

              $get_post_data->join('object_relationships', 'object_relationships.object_id', '=', 'products.id');

              $get_post_data->select('products.*');
              $get_post_data = $get_post_data->get()->toArray();

              if(count($get_post_data) > 0){
                foreach($get_post_data as $post){
                  $filter_cat = array();

                  if($cat['search_type'] == 'color-filter' || $cat['search_type'] == 'size-filter'){
                    $filter_cat = $this->getCatByObjectId( $post->id );
                  }

                  if( (($cat['search_type'] == 'color-filter' || $cat['search_type'] == 'size-filter') && $this->classCommonFunction->is_product_cat_in_selected_cat($filter_cat, $all_cat)) || ($cat['search_type'] == 'category-filter') ){
                    $post_data = (array)$post;
                    $data_array[$post->id] = $post_data;
                  }
                }
              }
            }  

            if($cat['search_type'] == 'category-filter'){
              array_push($selected_cat, $cat['id']);
            }
          }
        }
      }
      
      if( isset($filter['price_min']) && isset($filter['price_max']) && $filter['price_min'] >= 0 && $filter['price_max'] >=0){
        $post_array['min_price']  =   $filter['price_min'];
        $post_array['max_price']  =   $filter['price_max'];
      }

      if(isset($filter['selected_colors'])){
        $post_array['selected_colors_hf'] =  $filter['selected_colors'];
      }

      if(isset($filter['selected_sizes'])){
        $post_array['selected_sizes_hf']  =  $filter['selected_sizes'];
      }
      
      if(isset($filter['sort'])){
        $post_array['sort_by'] = $filter['sort'];
      }
			
      if(count($data_array) > 0){
        if(isset($filter['sort']) && $filter['sort'] != 'all'){
          if($filter['sort'] == 'alpaz'){
            $data_array = $this->classCommonFunction->sortBy($data_array, 'title', 'asc');
          }
          elseif($filter['sort'] == 'alpza'){
            $data_array = $this->classCommonFunction->sortBy($data_array, 'title', 'desc');
          }
          elseif($filter['sort'] == 'low-high'){
            $data_array = $this->classCommonFunction->sortBy($data_array, 'price', 'asc');
          }
          elseif($filter['sort'] == 'high-low'){
            $data_array = $this->classCommonFunction->sortBy($data_array, 'price', 'desc');
          }
          elseif($filter['sort'] == 'old-new'){
            $data_array = $this->classCommonFunction->sortBy($data_array, 'created_at', 'asc');
          }
          elseif($filter['sort'] == 'new-old'){
            $data_array = $this->classCommonFunction->sortBy($data_array, 'created_at', 'desc');
          }
        }
        else{
          $data_array = $this->classCommonFunction->sortBy($data_array, 'id', 'desc');
        }
      }
      
      $currentPage = LengthAwarePaginator::resolveCurrentPage();
      $col = new Collection( $data_array );
      $perPage = 10;
      $currentPageSearchResults = $col->slice(($currentPage - 1) * $perPage, $perPage)->all();
      $posts_object = new LengthAwarePaginator($currentPageSearchResults, count($col), $perPage);
      $posts_object->setPath( route('categories-page', $cat_data['slug']) );
      
      
      if($cat_data['parent_id'] > 0){
        $parent_cat = $this->getTermDataById( $cat_data['parent_id'] );
        
        $str = '<ul class="breadcrumb"><li><a href="'. route('home-page') .'">'. Lang::get('frontend.home' ) .'</a></li><li><a href="'. route('shop-page') .'">'. Lang::get('frontend.all_products_label' ) .'</a></li><li><a href="'. route('categories-page', $parent_cat[0]['slug']) .'">'. $parent_cat[0]['name'] .'</a></li><li class="active">'. $cat_data['name'] .'</li></ul>';
      }
      else{
        $str = '<ul class="breadcrumb"><li><a href="'. route('home-page') .'">'. Lang::get('frontend.home' ) .'</a></li><li><a href="'. route('shop-page') .'">'. Lang::get('frontend.all_products_label' ) .'</a></li><li class="active">'. $cat_data['name'] .'</li></ul>';
      }

      $post_array['products']        =  $posts_object;
      $post_array['breadcrumb_html'] =  $str;
      $post_array['selected_cat']    =  $selected_cat;
      $post_array['parent_id']       =  $parent_id;
      $post_array['parent_slug']     =  $cat_data['slug'];
    }
 
    return $post_array;
  }
    
  /**
   * Get function for attributes
   *
   * @param product id
   * @return array
   */
  public function getAllAttributes($product_id){
    $get_available_attribute = array();
    $get_attr_from_global	 =  $this->getTermData( 'product_attr', false, null, 1 );
        
    if(count($get_attr_from_global) > 0){
      foreach($get_attr_from_global as $term){
        $ary = array();
        $ary['attr_id']     = $term['term_id'];
        $ary['attr_name']   = $term['name'];
        $ary['attr_values'] = $term['product_attr_values'];
        $ary['attr_status'] = $term['status'];
        $ary['created_at']  = $term['created_at'];
        $ary['updated_at']  = $term['updated_at'];

        array_push($get_available_attribute, $ary);
      }
    }
    
    $get_attr_by_products  =  PostExtra::where(['post_id' => $product_id, 'key_name' => '_attribute_post_data'])->get()->toArray();
    
    if(count($get_attr_by_products)>0){
      $parseJsonToArray = json_decode($get_attr_by_products[0]['key_value']);

      if(count($parseJsonToArray)>0){
        foreach($parseJsonToArray as $row){
          $ary = array();
          $ary['attr_id']     = $row->id;
          $ary['attr_name']   = $row->attr_name;
          $ary['attr_values'] = $row->attr_val;
          $ary['attr_status'] = 1;
          $ary['created_at']  = $get_attr_by_products[0]['created_at'];
          $ary['updated_at']  = $get_attr_by_products[0]['updated_at'];

          array_push($get_available_attribute, $ary);
        }
      }
    }
    
    return $get_available_attribute;
  }
  
  /**
   * Get products by cat id
   *
   * @param cat id
   * @return array
   */
  public function getProductsByTermId($term_id){
    $object_array = array();
    $get_post_data =  DB::table('products')
                      ->where(['products.status' => 1, 'object_relationships.term_id' => $term_id ])
                      ->join('object_relationships', 'object_relationships.object_id', '=', 'products.id')
                      ->select('products.*')
                      ->orderBy('products.id', 'desc')
                      ->get()
                      ->toArray();
    
    if(count($get_post_data) > 0){
      $object_array = $get_post_data;
    }
    
    return $object_array;
  }
  

  //daizheng

  public function getBacksideItems($product_id){
    $backside_items  =  array();
    $backside_products  =  array();
    
    //categories product search
    $cat_lists = $this->getCcatByObjectId($product_id);
    // get_product_type($single_product_details['id']) == 'customizable_product'
   
    
    if(count($cat_lists) > 0 && isset($cat_lists['term_id']) && count($cat_lists['term_id']) > 0){
      foreach($cat_lists['term_id'] as $cat_id){
        $cat_term = $this->getTermDataById($cat_id);
       
        if(count($cat_term) > 0){

          $get_cat_product_list  =  $this->getProductsByTermId($cat_term[0]['term_id']);
          
          if(count($get_cat_product_list) >0){
            foreach($get_cat_product_list as $product){
              if($product->id != $product_id ){
                array_push($backside_items, $product->id);
              }
            }
          }
        }
      }
    }
   
    //tags product search
    $tag_lists = $this->getTagsByObjectId($product_id);
    
    if(count($tag_lists) > 0 && isset($tag_lists['term_id']) && count($tag_lists['term_id']) > 0){
      foreach($tag_lists['term_id'] as $tag_id){
        $tag_term = $this->getTermDataById($tag_id);
        
        if(count($tag_term) > 0){
          $get_tag_productListContent  =  $this->getProductsByTermId($tag_term[0]['term_id']);
          
          if(count($get_tag_product_list) > 0 ){
            foreach($get_tag_product_list as $tag_product){
             if($tag_product->id != $product_id){
               array_push($backside_items, $tag_product->id);
             }
            }
          }
        }
      }
    }
     
    //brand product search
    $brand_lists = $this->getManufacturerByObjectId($product_id);
    
    if(count($brand_lists) > 0 && isset($brand_lists['term_id']) && count($brand_lists['term_id']) > 0){
      foreach($brand_lists['term_id'] as $brand_id){
        $brand_term = $this->getTermDataById($brand_id);
        
        if(count($brand_term) > 0){
          $get_brands_product_list  =  $this->getProductsByTermId($brand_term[0]['term_id']);
          
          if(count($get_brands_product_list) > 0){
            foreach($get_brands_product_list as $brand_product){
              if($brand_product->id != $product_id && get_product_type($product_id) == 'customizable_product'){
                array_push($backside_items, $brand_product->id);
              }
            }
          }
        }
      }
    }
    
    
    if(count($backside_items) > 0){
      $products_id_array = array_unique($backside_items);
   
      if(count($products_id_array) > 0){
        foreach($products_id_array as $backside_products_id){
          $get_post_meta  =  ProductExtra :: where(['product_id' => $backside_products_id, 'key_name' => '_product_enable_as_custom_design'])->first();

          if(!empty($get_post_meta) && $get_post_meta->key_value == 'yes'){
            array_push($backside_products, $this->getProductDataById($backside_products_id));
          }  
        }
      }
    }
    
    return $backside_products;
  }
  /**
   * Get related items
   *
   * @param product id
   * @return array
   */
  
  public function getRelatedItems($product_id){
    $related_items  =  array();
    $related_products  =  array();
    
    //categories product search
    $cat_lists = $this->getCatByObjectId($product_id);
    
    if(count($cat_lists) > 0 && isset($cat_lists['term_id']) && count($cat_lists['term_id']) > 0){
      foreach($cat_lists['term_id'] as $cat_id){
        $cat_term = $this->getTermDataById($cat_id);
        
        if(count($cat_term) > 0){
          $get_cat_product_list  =  $this->getProductsByTermId($cat_term[0]['term_id']);
          
          if(count($get_cat_product_list) >0){
            foreach($get_cat_product_list as $product){
              if($product->id != $product_id){
                array_push($related_items, $product->id);
              }
            }
          }
        }
      }
    }
   
    //tags product search
    $tag_lists = $this->getTagsByObjectId($product_id);
    
    if(count($tag_lists) > 0 && isset($tag_lists['term_id']) && count($tag_lists['term_id']) > 0){
      foreach($tag_lists['term_id'] as $tag_id){
        $tag_term = $this->getTermDataById($tag_id);
        
        if(count($tag_term) > 0){
          $get_tag_productListContent  =  $this->getProductsByTermId($tag_term[0]['term_id']);
          
          if(count($get_tag_product_list) > 0 ){
            foreach($get_tag_product_list as $tag_product){
             if($tag_product->id != $product_id){
               array_push($related_items, $tag_product->id);
             }
            }
          }
        }
      }
    }
     
    //brand product search
    $brand_lists = $this->getManufacturerByObjectId($product_id);
    
    if(count($brand_lists) > 0 && isset($brand_lists['term_id']) && count($brand_lists['term_id']) > 0){
      foreach($brand_lists['term_id'] as $brand_id){
        $brand_term = $this->getTermDataById($brand_id);
        
        if(count($brand_term) > 0){
          $get_brands_product_list  =  $this->getProductsByTermId($brand_term[0]['term_id']);
          
          if(count($get_brands_product_list) > 0){
            foreach($get_brands_product_list as $brand_product){
              if($brand_product->id != $product_id){
                array_push($related_items, $brand_product->id);
              }
            }
          }
        }
      }
    }
    
    
    if(count($related_items) > 0){
      $products_id_array = array_unique($related_items);
   
      if(count($products_id_array) > 0){
        foreach($products_id_array as $related_products_id){
          $get_post_meta  =  ProductExtra :: where(['product_id' => $related_products_id, 'key_name' => '_product_enable_as_related'])->first();

          if(!empty($get_post_meta) && $get_post_meta->key_value == 'yes'){
            array_push($related_products, $this->getProductDataById($related_products_id));
          }  
        }
      }
    }
    
    return $related_products;
  }
  
  /**
   * 
   *Export products 
   *
   * @param null
   * @return void
   */
  public function manageExportProducts(){
    $export_data  = array();
    $get_products = array();
    
    if(is_vendor_login() && Session::has('shopist_admin_user_id')){
      $get_products = Product :: where(['author_id' => Session::get('shopist_admin_user_id')])->orderBy('id', 'DESC')->get()->toArray();
    }
    else{
      $get_products = Product :: where([])->orderBy('id', 'DESC')->get()->toArray();
    }
    
    
    if(count($get_products) > 0){
      foreach($get_products as $rows){
        $regular_price = '';
        $sku = '';
        $short_features = '';
        $recommended = FALSE;
        $features = FALSE;
        $latest = FALSE;
        $related = FALSE;
        $home_page = FALSE;
        $reviews = FALSE;
        $p_reviews = FALSE;
        $d_reviews = FALSE;
        $seo_title = '';
        $seo_desc = '';
        $seo_keywords = '';
        $visibility = FALSE;
        
        $regular_price = $rows['regular_price'];
        $sku = $rows['sku'];
        
        if($rows['status'] == 1){
          $visibility = TRUE;
        }

        $get_post_extras = ProductExtra::where(['product_id' => $rows['id']])->get()->toArray();
        if(count($get_post_extras) > 0){
          foreach($get_post_extras as $post_extras){
            if($post_extras['key_name'] == '_product_extra_features'){
              $short_features = $post_extras['key_value'];
            }
            if($post_extras['key_name'] == '_product_enable_as_recommended'){
              if($post_extras['key_value'] == 'yes'){
                $recommended = TRUE;
              }
            }
            if($post_extras['key_name'] == '_product_enable_as_features'){
              if($post_extras['key_value'] == 'yes'){
                $features = TRUE;
              }
            }
            if($post_extras['key_name'] == '_product_enable_as_latest'){
              if($post_extras['key_value'] == 'yes'){
                $latest = TRUE;
              }
            }
            if($post_extras['key_name'] == '_product_enable_as_related'){
              if($post_extras['key_value'] == 'yes'){
                $related = TRUE;
              }
            }
            if($post_extras['key_name'] == '_product_enable_as_selected_cat'){
              if($post_extras['key_value'] == 'yes'){
                $home_page = TRUE;
              }
            }
            if($post_extras['key_name'] == '_product_enable_reviews'){
              if($post_extras['key_value'] == 'yes'){
                $reviews = TRUE;
              }
            }
            if($post_extras['key_name'] == '_product_enable_reviews_add_link_to_product_page'){
              if($post_extras['key_value'] == 'yes'){
                $p_reviews = TRUE;
              }
            }
            if($post_extras['key_name'] == '_product_enable_reviews_add_link_to_details_page'){
              if($post_extras['key_value'] == 'yes'){
                $d_reviews = TRUE;
              }
            }
            if($post_extras['key_name'] == '_product_seo_title'){
              $seo_title = $post_extras['key_value'];
            }
            if($post_extras['key_name'] == '_product_seo_description'){
              $seo_desc = $post_extras['key_value'];
            }
            if($post_extras['key_name'] == '_product_seo_keywords'){
              $seo_keywords = $post_extras['key_value'];
            }
          }
        }

        array_push($export_data, array('title' => $rows['title'], 'description' => $rows['content'], 'regular_price' => $regular_price, 'sku' => $sku, 'extra_features' => $short_features, 'enable_recommended' => ($recommended) ? 'TRUE' : 'FALSE', 'enable_features' => ($features) ? 'TRUE' : 'FALSE', 'enable_latest' => ($latest) ? 'TRUE' : 'FALSE', 'enable_related' => ($related) ? 'TRUE' : 'FALSE', 'enable_home' => ($home_page) ? 'TRUE' : 'FALSE', 'visibility' => ($visibility) ? 'TRUE' : 'FALSE', 'reviews' => ($reviews) ? 'TRUE' : 'FALSE', 'p_reviews' => ($p_reviews) ? 'TRUE' : 'FALSE', 'd_reviews' => ($d_reviews) ? 'TRUE' : 'FALSE', 'seo_title' => $seo_title, 'seo_desc' => $seo_desc, 'seo_keywords' => $seo_keywords));
      }
    }

    $filename = 'products_export_'.time().'-'.mt_rand().'.csv';
    $headers = array(
      "Content-type" => "text/csv",
      "Content-Disposition" => "attachment; filename=". $filename,
      "Pragma" => "no-cache",
      "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
      "Expires" => "0"
    );

    $columns = array('Title', 'Description(HTML)', 'Regular Price', 'SKU', 'Features(HTML)', 'Recommended Product', 'Features Product', 'Latest Product', 'Related Product', 'Home Page Product', 'Visibility', 'Enable Reviews', 'Enable Review Product Page', 'Enable Review Details Page', 'SEO Title', 'SEO Description', 'SEO Keywords(Comma Separator)');

    $callback = function() use ($export_data, $columns){
      $file = fopen('php://output', 'w');
      fputcsv($file, $columns);

      if(count($export_data) > 0){
        foreach($export_data as $data) {
          fputcsv($file, array($data['title'], $data['description'], $data['regular_price'], $data['sku'], $data['extra_features'], $data['enable_recommended'], $data['enable_features'], $data['enable_latest'], $data['enable_related'], $data['enable_home'], $data['visibility'], $data['reviews'], $data['p_reviews'], $data['d_reviews'], $data['seo_title'], $data['seo_desc'], $data['seo_keywords']));
        }
      }

      fclose($file);
    };

    return Response::stream($callback, 200, $headers);
  }
  
  /**
   * 
   * Get designer shape list
   *
   * @param null
   * @return void
   */
  public function getShapeList($pagination = false, $search_val = null, $status_flag = -1){
    $data = array();
    
    if($status_flag == -1){
      $where = ['post_type' => 'designer_shape'];
    }
    else{
      $where = ['post_type' => 'designer_shape', 'post_status' => $status_flag];
    }
    
    if($search_val && $search_val != null){
      $get_post = Post:: where($where)
                         ->where('post_title', 'LIKE', '%'. $search_val .'%')
                         ->orderBy('id', 'desc')
                         ->get()
                         ->toArray();
    }
    else{
      $get_post = Post:: where($where)
                         ->orderBy('id', 'desc')
                         ->get()
                         ->toArray();
    }
    
    if(count($get_post) > 0){
      $data = $get_post;
    }
    
    if($pagination){
      $currentPage = LengthAwarePaginator::resolveCurrentPage();
      $col = new Collection( $data );
      $perPage = 10;
      $currentPageSearchResults = $col->slice(($currentPage - 1) * $perPage, $perPage)->all();
      $posts_object = new LengthAwarePaginator($currentPageSearchResults, count($col), $perPage);
      $posts_object->setPath( route('admin.shape_list_content') );
    }
    
    if($pagination){
      return $posts_object;
    }
    else{
     return $data; 
    }
  }
  
  /**
   * 
   * Get designer fonts list
   *
   * @param null
   * @return void
   */
  public function getFontsList($pagination = false, $search_val = null, $status_flag = -1){
    $data = array();
    
    if($status_flag == -1){
      $where = ['post_type' => 'custom_font'];
    }
    else{
      $where = ['post_type' => 'custom_font', 'post_status' => $status_flag];
    }
    
    if($search_val && $search_val !=null){
      $get_post = Post:: where($where)
                         ->where('post_title', 'LIKE', '%'. $search_val .'%')
                         ->orderBy('id', 'desc')
                         ->get()
                         ->toArray();
    }
    else{
      $get_post = Post:: where($where)
                         ->orderBy('id', 'desc')
                         ->get()
                         ->toArray();
    }
    
    if(count($get_post) > 0){
      foreach($get_post as $row){
        $get_meta = PostExtra :: where('post_id', $row['id'])->first();
        if(!empty($get_meta)){
          $row['url'] = $get_meta['key_value'];
        }
        
        array_push($data, $row);
      }
    }
    
    if($pagination){
      $currentPage = LengthAwarePaginator::resolveCurrentPage();
      $col = new Collection( $data );
      $perPage = 10;
      $currentPageSearchResults = $col->slice(($currentPage - 1) * $perPage, $perPage)->all();
      $posts_object = new LengthAwarePaginator($currentPageSearchResults, count($col), $perPage);
      $posts_object->setPath( route('admin.fonts_list_content') );
    }
    
    if($pagination){
      return $posts_object;
    }
    else{
     return $data; 
    }
  }
  
  /**
   * 
   * Get post meta
   *
   * @param post_id, key_name
   * @return object
   */
  public function get_post_meta($post_id, $key_name){
    $get_post_meta = null;
    $post_meta  = PostExtra::where(['post_id' => $post_id, 'key_name' => $key_name])->first();
    if(!empty($post_meta)){
      $get_post_meta = $post_meta;
    }
    
    return $get_post_meta;
  }
  
  /**
   * 
   * Create product content data
   *
   * @param array
   * @return array
   */
  function createProductContentData($data){
    $data['tabSettings']['btnCustomize']   =   'style=display:none;';
    $data['categories_lists']              =   $this->get_categories( 0, 'product_cat');
    $data['categories_customlists']        =   $this->get_customcategories( 0, 'product_cat');
    $data['tags_lists']                    =   $this->getTermData( 'product_tag', false, null, 1 );
    $data['attrs_list_data']               =   $this->getTermData( 'product_attr', false, null, 1 );
    $data['colors_lists']                  =   $this->getTermData( 'product_colors', false, null, 1 );
    $data['sizes_lists']                   =   $this->getTermData( 'product_sizes', false, null, 1 );
    $data['manufacturer_lists']            =   $this->getTermData( 'product_brands', false, null, 1 );
    $data['available_user_roles']          =   get_available_user_roles();
    $data['vendors_list']                  =   $this->vendors->getAllVendors( false, null, 1 );
    $data['fields_name']                   =   $this->option->getProductCompareData();
    $data['settings_data']                 =   $this->option->getSettingsData();
    $data['currency_symbol']               =   $this->classCommonFunction->get_currency_symbol( $data['settings_data']['general_settings']['currency_options']['currency_name'] );
    
    $data['product_all_images_json']			=		 json_encode(  
      array(                                                                                           
        'product_image'            => '',
        'product_gallery_images'   => array(),
        'shop_banner_image'        => ''
      )
    );
    
    return $data;
  }
  
}