<?php
namespace shopist\Http\Controllers\Frontend;

use shopist\Http\Controllers\Controller;
use Request;
use Illuminate\Support\Facades\Input;
use shopist\Library\GetFunction;
use shopist\Models\Post;
use shopist\Models\PostExtra;
use shopist\Models\Product;
use Anam\Phpcart\Cart;
use shopist\Models\DownloadExtra;
use shopist\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Lang;
use Cookie;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use shopist\Http\Controllers\ProductsController;
use shopist\Library\CommonFunction;
use shopist\Http\Controllers\CMSController;
use shopist\Http\Controllers\OptionController;
use shopist\Models\OrdersItem;
use shopist\Http\Controllers\VendorsController;
use shopist\Models\SaveCustomDesign;
use shopist\Models\Term;
use Illuminate\Support\Facades\DB;

class FrontendManagerController extends Controller
{
  public $classGetFunction;
  public $cart;
  public $product;
  public $classCommonFunction;
  public $CMS;
  public $option;
  public $vendors;

  public function __construct() {
    $this->product              =  new ProductsController();
    $this->classCommonFunction  =  new CommonFunction();
    $this->cart                 =  new Cart();
    $this->classGetFunction     =  new GetFunction();
    $this->CMS                  =  new CMSController();
    $this->option               =  new OptionController();
    $this->vendors              =  new VendorsController();
  }
  
  /**
   * 
   * Home page content
   *
   * @param null
   * @return void 
   */
  public function homePageContent(){
    $data = array();
    
    $data = $this->classCommonFunction->get_dynamic_frontend_content_data(); 
    $data['advancedData']        =   $this->product->getAdvancedProducts();
    $data['brands_data']         =   $this->product->getTermData( 'product_brands', false, null, 1 );
    $data['testimonials_data']   =   get_all_testimonial_data();
    
    return view('pages.frontend.frontend-pages.home', $data);
  }
  
  /**
   * 
   * Product categories single page content
   *
   * @param null
   * @return void 
   */
  // 900
  public function ProductFristPageContent(){
    $category = DB::table('terms')->where('fb', '0')->first();
    $params =$category->name;
    // echo $params;
    // $params = 'brochure Back side';
    $data = array();
    $sort = null;
    $price_min = null;
    $price_max = null;
    $selected_colors = null;
    $selected_sizes = null;
      
    if(isset($_GET['sort_by'])){
      $sort = $_GET['sort_by'];
    }
      
    if(isset($_GET['price_min'])){
      $price_min = $_GET['price_min'];
    }
      
    if(isset($_GET['price_max'])){
      $price_max = $_GET['price_max'];
    }
      
    if(isset($_GET['selected_colors'])){
      $selected_colors = $_GET['selected_colors'];
    }

    if(isset($_GET['selected_sizes'])){
      $selected_sizes = $_GET['selected_sizes'];
    }
      
    $get_cat_product_and_breadcrumb  =  $this->product->getProductByCatSlug($params, array('sort' => $sort, 'price_min' => $price_min, 'price_max' => $price_max, 'selected_colors' => $selected_colors, 'selected_sizes' => $selected_sizes));

    if(count($get_cat_product_and_breadcrumb) > 0){
      $data = $this->classCommonFunction->get_dynamic_frontend_content_data(); 
      $data['product_by_cat_id']  =   $get_cat_product_and_breadcrumb;
      $data['brands_data']        =   $this->product->getTermData( 'product_brands', false, null, 1 );
      $data['colors_list_data']   =   $this->product->getTermData( 'product_colors', false, null, 1 );
      $data['sizes_list_data']    =   $this->product->getTermData( 'product_sizes', false, null, 1 );
    
      if(count($data['product_by_cat_id']) > 0){
        $data['product_by_cat_id']['action_url'] = Request::url();
        
        $currentQuery = Request::query();
        
        if(count($currentQuery) > 0){
          if(isset($currentQuery['view'])){
            unset($currentQuery['view']);
          }
          
          if(count($currentQuery) > 0){
            $currentQuery['view'] = 'list';
            $data['product_by_cat_id']['action_url_list_view'] = Request::url(). '?' . http_build_query($currentQuery);
            $currentQuery['view'] = 'grid';
            $data['product_by_cat_id']['action_url_grid_view'] = Request::url(). '?' . http_build_query($currentQuery);
          }
          else{
            $data['product_by_cat_id']['action_url_list_view'] = Request::url(). '?view=list';
            $data['product_by_cat_id']['action_url_grid_view'] = Request::url(). '?view=grid';
          }
        }
        else{
          $data['product_by_cat_id']['action_url_list_view'] = Request::url(). '?view=list';
          $data['product_by_cat_id']['action_url_grid_view'] = Request::url(). '?view=grid';
        }
        
        if(isset($_GET['view']) && $_GET['view'] == 'list'){
          $data['product_by_cat_id']['selected_view'] = 'list'; 
        }
        elseif(isset($_GET['view']) && $_GET['view'] == 'grid'){
          $data['product_by_cat_id']['selected_view'] = 'grid'; 
        }
        else{
          $data['product_by_cat_id']['selected_view'] = 'grid';
        }
      }
      
      return view('pages.frontend.frontend-pages.categories-main', $data);
    }
    else{
      return view('errors.no_data');
    }
  }
  public function productCategoriesSinglePageContent( $params ){
    $data = array();
    $sort = null;
    $price_min = null;
    $price_max = null;
    $selected_colors = null;
    $selected_sizes = null;
      
    if(isset($_GET['sort_by'])){
      $sort = $_GET['sort_by'];
    }
      
    if(isset($_GET['price_min'])){
      $price_min = $_GET['price_min'];
    }
      
    if(isset($_GET['price_max'])){
      $price_max = $_GET['price_max'];
    }
      
    if(isset($_GET['selected_colors'])){
      $selected_colors = $_GET['selected_colors'];
    }

    if(isset($_GET['selected_sizes'])){
      $selected_sizes = $_GET['selected_sizes'];
    }
      
    $get_cat_product_and_breadcrumb  =  $this->product->getProductByCatSlug($params);

    if(count($get_cat_product_and_breadcrumb) > 0){
      $data = $this->classCommonFunction->get_dynamic_frontend_content_data(); 
      $data['product_by_cat_id']  =   $get_cat_product_and_breadcrumb;
      $data['brands_data']        =   $this->product->getTermData( 'product_brands', false, null, 1 );
      $data['colors_list_data']   =   $this->product->getTermData( 'product_colors', false, null, 1 );
      $data['sizes_list_data']    =   $this->product->getTermData( 'product_sizes', false, null, 1 );
    
      if(count($data['product_by_cat_id']) > 0){
        $data['product_by_cat_id']['action_url'] = Request::url();
        
        $currentQuery = Request::query();
        
        if(count($currentQuery) > 0){
          if(isset($currentQuery['view'])){
            unset($currentQuery['view']);
          }
          
          if(count($currentQuery) > 0){
            $currentQuery['view'] = 'list';
            $data['product_by_cat_id']['action_url_list_view'] = Request::url(). '?' . http_build_query($currentQuery);
            $currentQuery['view'] = 'grid';
            $data['product_by_cat_id']['action_url_grid_view'] = Request::url(). '?' . http_build_query($currentQuery);
          }
          else{
            $data['product_by_cat_id']['action_url_list_view'] = Request::url(). '?view=list';
            $data['product_by_cat_id']['action_url_grid_view'] = Request::url(). '?view=grid';
          }
        }
        else{
          $data['product_by_cat_id']['action_url_list_view'] = Request::url(). '?view=list';
          $data['product_by_cat_id']['action_url_grid_view'] = Request::url(). '?view=grid';
        }
        
        if(isset($_GET['view']) && $_GET['view'] == 'list'){
          $data['product_by_cat_id']['selected_view'] = 'list'; 
        }
        elseif(isset($_GET['view']) && $_GET['view'] == 'grid'){
          $data['product_by_cat_id']['selected_view'] = 'grid'; 
        }
        else{
          $data['product_by_cat_id']['selected_view'] = 'grid';
        }
      }
      
      return view('pages.frontend.frontend-pages.categories-main', $data);
    }
    else{
      return view('errors.no_data');
    }
  }
  
  /**
   * 
   * Testimonial single page content
   *
   * @param null
   * @return void 
   */
  public function testimonialSinglePageContent( $params ){
    $data = array();
    $testimonial_arr = array();
    
    $get_testimonial = get_testimonial_data_by_slug($params);
    if(count($get_testimonial) > 0 && isset($get_testimonial['post_status']) && $get_testimonial['post_status'] == 1){
      $data = $this->classCommonFunction->get_dynamic_frontend_content_data(); 
      $data['testimonials_data_by_slug'] =  $get_testimonial;
      $get_testimonials_data  =   get_all_testimonial_data(1);

      if(count($get_testimonials_data) > 0){
        foreach($get_testimonials_data as $testimonials_data){
          if($testimonials_data['post_slug'] != $params){
            array_push($testimonial_arr, $testimonials_data);
          }
        }
      }

      if(count($testimonial_arr) > 0){
        $data['testimonials_data'] = $testimonial_arr;
      }
      else{
        $data['testimonials_data'] = array();
      }
      
      return view('pages.frontend.frontend-pages.testimonial-details', $data);
    }
    else{
      return view('errors.no_data');
    }
  }
  
  /**
   * 
   * Blog single page content
   *
   * @param null
   * @return void 
   */
  public function blogSinglePageContent( $params ){
    $data = array();
    $get_blog_details_by_slug = $this->CMS->get_blog_by_slug($params);
      
    if(count($get_blog_details_by_slug) > 0 && isset($get_blog_details_by_slug['post_status']) && $get_blog_details_by_slug['post_status'] == 1){
      $object_id = 0;

      if(isset($get_blog_details_by_slug['id'])){
        $object_id = $get_blog_details_by_slug['id'];
      }
      
      $data = $this->classCommonFunction->get_dynamic_frontend_content_data();
      $data['advanced_data']            =   $this->CMS->get_blog_advanced_data($object_id);
      $data['blog_details_by_slug']     =   $get_blog_details_by_slug;
      $data['comments_details']         =   get_comments_data_by_object_id( $object_id, 'blog' );
      $data['comments_rating_details']  =   get_comments_rating_details( $object_id, 'blog' );

      if(!Session::has('shopist_blog_count') || (Session::has('shopist_blog_count') && Session::get('shopist_blog_count') != $get_blog_details_by_slug['id'])){  
        $get_post_meta =  PostExtra::where(['post_id' => $get_blog_details_by_slug['id'], 'key_name' => '_count_visit'])->first();

        if(!empty($get_post_meta)){
          $new_value = array(
                            'key_value'  =>  $get_post_meta->key_value + 1
          );

          PostExtra::where(['post_id' => $get_blog_details_by_slug['id'], 'key_name' => '_count_visit'])->update($new_value);
        }
        else{
            PostExtra::insert(array(
                    array(
                        'post_id'       =>      $get_blog_details_by_slug['id'],
                        'key_name'      =>      '_count_visit',
                        'key_value'     =>      1,
                        'created_at'    =>      date("y-m-d H:i:s", strtotime('now')),
                        'updated_at'    =>      date("y-m-d H:i:s", strtotime('now'))
                    )
            ));
        }

        Session::put('shopist_blog_count', $get_blog_details_by_slug['id']);
    }

      $get_seo_data = get_seo_data();

      if(isset($get_seo_data['meta_tag']['meta_keywords']) && isset($data['blog_details_by_slug']['blog_seo_keywords'])){
        $data['blog_details_by_slug']['meta_keywords'] = trim( trim($get_seo_data['meta_tag']['meta_keywords'], ','). ',' .trim($data['blog_details_by_slug']['blog_seo_keywords'], ','), ',');
      }
      elseif(!isset($get_seo_data['meta_tag']['meta_keywords']) && isset($data['blog_details_by_slug']['blog_seo_keywords'])){
        $data['blog_details_by_slug']['meta_keywords'] = trim($data['blog_details_by_slug']['blog_seo_keywords'], ',');
      }
      elseif(isset($get_seo_data['meta_tag']['meta_keywords']) && !isset($data['blog_details_by_slug']['blog_seo_keywords'])){
        $data['blog_details_by_slug']['meta_keywords'] = trim($get_seo_data['meta_tag']['meta_keywords'], ',');
      }
      else{
        $data['blog_details_by_slug']['meta_keywords'] = null;
      }
      
      return view('pages.frontend.frontend-pages.blog-single-page', $data);
    }
    else{
      return view('errors.no_data');
    }
  }
  
  /**
   * 
   * Brand single page content
   *
   * @param null
   * @return void 
   */
  public function brandSinglePageContent( $params ){
    $data = array();
    $get_brand_details_by_slug = $this->product->getBrandDataBySlug( $params );
     
    if(count($get_brand_details_by_slug) > 0){
      $data = $this->classCommonFunction->get_dynamic_frontend_content_data();
      $data['brand_details_by_slug'] = $get_brand_details_by_slug;
      
      return view('pages.frontend.frontend-pages.brand-single-page', $data);
    }
    else{
      return view('errors.no_data');
    }
  }
  
  /**
   * 
   * Products page content
   *
   * @param null
   * @return void 
   */

  //  900
  public function productsPageContent(){
    $data = array();
    $sort = null;
    $price_min = null;
    $price_max = null;
    $selected_colors = null;
    $selected_sizes = null;
    $search_term = null;

    if(isset($_GET['srch_term'])){
      $search_term = $_GET['srch_term'];
    }

    if(isset($_GET['sort_by'])){
      $sort = $_GET['sort_by'];
    }

    if(isset($_GET['price_min'])){
      $price_min = $_GET['price_min'];
    }

    if(isset($_GET['price_max'])){
      $price_max = $_GET['price_max'];
    }

    if(isset($_GET['selected_colors'])){
      $selected_colors = $_GET['selected_colors'];
    }

    if(isset($_GET['selected_sizes'])){
      $selected_sizes = $_GET['selected_sizes'];
    }

    $get_product  =  $this->product->getFilterProductsDataWithPagination(array('srch_term' => $search_term, 'sort' => $sort, 'price_min' => $price_min, 'price_max' => $price_max, 'selected_colors' => $selected_colors, 'selected_sizes' => $selected_sizes));

    if(count($get_product) > 0){
      $data = $this->classCommonFunction->get_dynamic_frontend_content_data();
      $data['brands_data']          =   $this->product->getTermData( 'product_brands', false, null, 1 );
      $data['advancedData']         =   $this->product->getAdvancedProducts();
      $data['colors_list_data']     =   $this->product->getTermData( 'product_colors', false, null, 1 );
      $data['sizes_list_data']      =   $this->product->getTermData( 'product_sizes', false, null, 1 );
      $data['all_products_details'] =   $get_product;

      if(count($data['all_products_details']) > 0){
        $data['all_products_details']['action_url'] = Request::url();

        $currentQuery = Request::query();

        if(count($currentQuery) > 0){
          if(isset($currentQuery['view'])){
            unset($currentQuery['view']);
          }

          if(count($currentQuery) > 0){
            $currentQuery['view'] = 'list';
            $data['all_products_details']['action_url_list_view'] = Request::url(). '?' . http_build_query($currentQuery);
            $currentQuery['view'] = 'grid';
            $data['all_products_details']['action_url_grid_view'] = Request::url(). '?' . http_build_query($currentQuery);
          }
          else{
            $data['all_products_details']['action_url_list_view'] = Request::url(). '?view=list';
            $data['all_products_details']['action_url_grid_view'] = Request::url(). '?view=grid';
          }
        }
        else{
          $data['all_products_details']['action_url_list_view'] = Request::url(). '?view=list';
          $data['all_products_details']['action_url_grid_view'] = Request::url(). '?view=grid';
        }

        if(isset($_GET['view']) && $_GET['view'] == 'list'){
          $data['all_products_details']['selected_view'] = 'list'; 
        }
        elseif(isset($_GET['view']) && $_GET['view'] == 'grid'){
          $data['all_products_details']['selected_view'] = 'grid'; 
        }
        else{
          $data['all_products_details']['selected_view'] = 'grid';
        }
      }
      
      return view('pages.frontend.frontend-pages.shop', $data);
    }
    else{
      return view('errors.no_data');
    }
  }
  
  /**
   * 
   * Product single page content
   *
   * @param null
   * @return void 
   */


   
  //  900
  public function productSinglePageContent( $params ){
    $get_product = Product::where(['slug' => $params, 'status' => 1])->first();
      
    if(!empty($get_product)){
      $data = array();
      $product_id  = $get_product->id;
      $get_current_user_data  =  get_current_frontend_user_info();
      
      $data = $this->classCommonFunction->get_dynamic_frontend_content_data();
      $data['single_product_details']  =  $this->product->getProductDataById( $product_id );
      
      if(is_frontend_user_logged_in() && isset($get_current_user_data['user_role_slug']) && $data['single_product_details']['_is_role_based_pricing_enable'] == 'yes'){
        if(isset($data['single_product_details']['_role_based_pricing'][$get_current_user_data['user_role_slug']])){

          $regular_price = $data['single_product_details']['_role_based_pricing'][$get_current_user_data['user_role_slug']]['regular_price'];
          $sale_price = $data['single_product_details']['_role_based_pricing'][$get_current_user_data['user_role_slug']]['sale_price'];

          if(isset($regular_price) && $regular_price && isset($sale_price) && $sale_price && $regular_price > $sale_price){
            $data['single_product_details']['offer_price'] = get_product_price_html_by_filter($regular_price);
            $data['single_product_details']['solid_price'] = get_product_price_html_by_filter($sale_price);
          }
          elseif(isset($regular_price) && $regular_price){
            $data['single_product_details']['offer_price'] = null;
            $data['single_product_details']['solid_price'] = get_product_price_html_by_filter($regular_price);
          }
          else{
            $data['single_product_details']['offer_price'] = null;
            $data['single_product_details']['solid_price'] = 0;
          }
        }
      }  
      else{
        if($data['single_product_details']['post_regular_price'] && $data['single_product_details']['post_regular_price'] >0 && $data['single_product_details']['post_sale_price'] && $data['single_product_details']['post_sale_price']>0 && $data['single_product_details']['post_regular_price'] > $data['single_product_details']['post_sale_price'] ){
          $data['single_product_details']['offer_price'] = get_product_price_html_by_filter($data['single_product_details']['post_regular_price']);
        }
        else{
          $data['single_product_details']['offer_price'] = null;
        }

        $data['single_product_details']['solid_price']   = get_product_price_html_by_filter($data['single_product_details']['post_price']);
      }


      $data['single_product_details']['is_user_login']   = 'no';
      $data['single_product_details']['login_user_slug'] = '';

      if(is_frontend_user_logged_in()){
        $data['single_product_details']['is_user_login'] = 'yes';
      }

      if(count($get_current_user_data) > 0 && isset($get_current_user_data['user_role_slug'])){
        $data['single_product_details']['login_user_slug'] = $get_current_user_data['user_role_slug'];
      }

      if(Cookie::has('shopist_multi_currency')){
        $current_currency_name = get_current_currency_name();
        $to_currency    =  Cookie::get('shopist_multi_currency');
      }

      $product_url = default_placeholder_img_src();
      $data['product_zoom_image'] = $product_url;

      if($data['single_product_details']['_product_related_images_url']->product_image){
        $product_url = $data['single_product_details']['_product_related_images_url']->product_image;
        $data['product_zoom_image'] = $this->classCommonFunction->createZoomImageUrl( $product_url );
      }


      // 900
      
      $data['single_product_details']['_product_related_images_url']->product_image = $product_url;


      $product = (object) array('id' => time(), 'url' => $product_url);
      $data['single_product_details']['_product_related_images_url']->product_gallery_images[0] = $product;

      $gallery_images = $data['single_product_details']['_product_related_images_url']->product_gallery_images;
      if(count($gallery_images) > 0){
        foreach($gallery_images as $images){
          $images->zoom_img_url = $this->classCommonFunction->createZoomImageUrl( $images->url );
        }
      }

      $data['attr_lists']               =   $this->product->getAllAttributes( $product_id );
      // if( $product_id  = $get_product->f)
      $data['related_items']            =   $this->product->getRelatedItems( $product_id ); 
      $data['backside_items']           =   $this->product->getBacksideItems( $product_id);
      $data['comments_details']         =   get_comments_data_by_object_id( $product_id, 'product' );
      $data['comments_rating_details']  =   get_comments_rating_details( $product_id, 'product' );
      $data['vendor_reviews_rating_details']  =   get_comments_rating_details( get_vendor_id_by_product_id($product_id), 'vendor' );


      $get_seo_data = get_seo_data();

      if(isset($get_seo_data['meta_tag']['meta_keywords']) && isset($data['single_product_details']['_product_seo_keywords'])){
        $data['single_product_details']['meta_keywords'] = trim( trim($get_seo_data['meta_tag']['meta_keywords'], ','). ',' .trim($data['single_product_details']['_product_seo_keywords'], ','), ',');
      }
      elseif(!isset($get_seo_data['meta_tag']['meta_keywords']) && isset($data['single_product_details']['_product_seo_keywords'])){
        $data['single_product_details']['meta_keywords'] = trim($data['single_product_details']['_product_seo_keywords'], ',');
      }
      elseif(isset($get_seo_data['meta_tag']['meta_keywords']) && !isset($data['single_product_details']['_product_seo_keywords'])){
        $data['single_product_details']['meta_keywords'] = trim($get_seo_data['meta_tag']['meta_keywords'], ',');
      }
      else{
        $data['single_product_details']['meta_keywords'] = null;
      }

      $data['upsell_products'] = get_upsell_products( $product_id );
      
      return view('pages.frontend.frontend-pages.product-details', $data);
    }
    else{
      return view('errors.no_data');
    }
  }
  
  /**
   * 
   * Checkout page content
   *
   * @param null
   * @return void 
   */
  public function checkoutPageContent(){
    $data = array();
    $vendor_details  = array();
    $is_user_login = false;
    $get_user_login_data = get_current_frontend_user_info();
    $user_account_parse_data = null;
    
    $data = $this->classCommonFunction->get_dynamic_frontend_content_data();
    
    if($this->cart->getItems()->count() > 0){
      foreach($this->cart->getItems() as $item){
        $get_vendor_details = get_vendor_details_by_product_id( $item->product_id );

        if(count($get_vendor_details) > 0 && $get_vendor_details['user_role_slug'] == 'vendor'){
         $vendor_details = json_decode($get_vendor_details['details']);
         break;
        }
      }
    }
      
    if(!empty($vendor_details)){
      $data['shipping_data'] = $this->classCommonFunction->objToArray($vendor_details->shipping_method, true);
    }
    else{
      $data['shipping_data'] = $this->option->getShippingMethodData();
    }
      
    $data['payment_method_data'] = $this->option->getPaymentMethodData();
    $data['stripe_api_key'] = json_encode(get_stripe_api_key());
    $data['twocheckout_api_data'] = json_encode(get_twocheckout_api_data());
    
      
    //coupon applay
    if($this->cart->is_coupon_applyed() && !empty($this->cart->couponCode())){
      $response = $this->classGetFunction->manage_coupon($this->cart->couponCode(), 'update');

      if($response == 'coupon_already_apply' || $response == 'less_from_min_amount' || $response == 'exceed_from_max_amount' || $response == 'no_login' || $response == 'user_role_not_match' || $response == 'coupon_expired' || $response == 'exceed_from_cart_total' || $response == 'no_coupon_data'){
        $this->cart->remove_coupon();
        Session::flash('error-message', Lang::get('validation.coupon_removed_from_cart_msg' ));
      }
    } 
         
    if(Session::has('shopist_frontend_user_id') && isset($get_user_login_data['user_id'])){
      $is_user_login = true;
      $get_data_by_user_id     =  get_user_account_details_by_user_id( $get_user_login_data['user_id'] ); 
      $get_array_shift_data    =  array_shift($get_data_by_user_id);
      $user_account_parse_data =  json_decode($get_array_shift_data['details']);

      if(!empty($user_account_parse_data)){
        $user_account_parse_data = $user_account_parse_data;
      }
    }

    $data['is_user_login'] = $is_user_login;
    $data['login_user_account_data'] = $user_account_parse_data;
    $data['_settings_data']   = $this->option->getSettingsData();
    
    return view('pages.frontend.frontend-pages.checkout', $data);
  }
  
  /**
   * 
   * Cart page content
   *
   * @param null
   * @return void 
   */
  public function cartPageContent(){
    $data = array();
    $vendor_details  = array();
      
    if($this->cart->getItems()->count() > 0){
      foreach($this->cart->getItems() as $item){
        $get_vendor_details = get_vendor_details_by_product_id( $item->product_id );

        if(count($get_vendor_details) > 0 && $get_vendor_details['user_role_slug'] == 'vendor'){
         $vendor_details = json_decode($get_vendor_details['details']);
         break;
        }
      }
    }
    
    $data = $this->classCommonFunction->get_dynamic_frontend_content_data();
    if(!empty($vendor_details)){
      $data['shipping_data'] = $this->classCommonFunction->objToArray($vendor_details->shipping_method, true);
    }
    else{
      $data['shipping_data'] = $this->option->getShippingMethodData();
    }

    $data['payment_method_data'] = $this->option->getPaymentMethodData();
    $data['stripe_api_key'] = json_encode(get_stripe_api_key());

    //coupon applay
    if($this->cart->is_coupon_applyed() && !empty($this->cart->couponCode())){
      $response = $this->classGetFunction->manage_coupon($this->cart->couponCode(), 'update');

      if($response == 'coupon_already_apply' || $response == 'less_from_min_amount' || $response == 'exceed_from_max_amount' || $response == 'no_login' || $response == 'user_role_not_match' || $response == 'coupon_expired' || $response == 'exceed_from_cart_total' || $response == 'no_coupon_data'){
        $this->cart->remove_coupon();
        Session::flash('error-message', Lang::get('validation.coupon_removed_from_cart_msg' ));
      }
    } 
    
    if($this->cart->getItems()->count() > 0){
      $product_id = array();
      $cross_sell_products = array();

      foreach($this->cart->getItems() as $item){
        array_push($product_id, $item->product_id);
        $get_cross_sell_products = get_crosssell_products($item->product_id);

        if(count($get_cross_sell_products) > 0){
          $cross_sell_products = array_merge($cross_sell_products, $get_cross_sell_products);
        }
      }

      $unique_1 = array_unique($product_id); 
      $unique_2 = array_unique($cross_sell_products); 

      $final_unique_cross_sell_products = array_diff($unique_2, $unique_1);
      $data['cross_sell_products'] = $final_unique_cross_sell_products;
    }
    
    return view('pages.frontend.frontend-pages.cart', $data);
  }
  
  /**
   * 
   * Blogs page content
   *
   * @param null
   * @return void 
   */
  public function blogsPageContent(){
    $data = array();
    
    $data = $this->classCommonFunction->get_dynamic_frontend_content_data();
    $data['blogs_all_data']  =   get_all_blogs_data(1);
    $data['categoriesTree']  =   $this->product->get_categories(0, 'blog_cat');
    $data['advanced_data']   =   $this->CMS->get_blog_advanced_data();
    
    return view('pages.frontend.frontend-pages.blogs-main', $data);
  }
  
  /**
   * 
   * Blog categories page content
   *
   * @param null
   * @return void 
   */
  public function blogCategoriesPageContent( $params ){
    $data = array();
    
    $get_cat_post  =   $this->CMS->getBlogPostByCatSlug( $params );
      
    if(count($get_cat_post) > 0){
      $data = $this->classCommonFunction->get_dynamic_frontend_content_data();
      $data['blogs_cat_post']  =   $get_cat_post;
      $data['advanced_data']   =   $this->CMS->get_blog_advanced_data();
      $data['categoriesTree']  =   $this->product->get_categories(0, 'blog_cat');
      
      return view('pages.frontend.frontend-pages.blog-categories-post', $data);
    }
    else{
      return view('errors.no_data');
    }
  }
  
  /**
   * 
   * Single page content
   *
   * @param null
   * @return void 
   */
  public function singlePageContent( $params ){
    $data = array();
    $get_page_by_filter = Post :: where(['post_slug' => $params, 'post_status' => 1, 'post_type' => 'page'])->first();

    if(!empty($get_page_by_filter)){
      $data = $this->classCommonFunction->get_dynamic_frontend_content_data();
      $data['page_data'] = $get_page_by_filter;
      
      return view('pages.frontend.frontend-pages.custom-single-page', $data);
    }
    else{
      return view('errors.no_data');
    }
  }
  
  /**
   * 
   * Multivendor store list page content
   *
   * @param null
   * @return void 
   */
  public function multivendorStoreListPageContent(){
    $data = array();
    
    $data = $this->classCommonFunction->get_dynamic_frontend_content_data();
    $data['vendors_list'] = $this->vendors->getAllVendors( false, null, 1 );
    
    return view('pages.frontend.vendors.vendors-list', $data);
  }
  
  /**
   * 
   * Multivendor store single page home content
   *
   * @param null
   * @return void 
   */
  public function multivendorStoreSinglePageHomeContent( $params ){
    $data = array();
    $user = $params;
    
    $get_user = User::where(['name' => $user, 'user_status' => 1])->first();
    if(empty($get_user)){
      return view('errors.vendor_not_active');
    }
    
    $data = $this->classCommonFunction->get_dynamic_frontend_content_data();
    $data['vendor_settings'] = null;
    $data['vendor_selected_cats_id'] = array();
    
    $get_user = User::where(['name' => $user])->first();
    if(!empty($get_user)){
      if(is_vendor_expired( $get_user->id )){
        return view('errors.vendor_expired');
      }
      
      $data['vendor_package_details'] = get_package_details_by_vendor_id($get_user->id);
      $data['vendor_settings'] = null;
      $get_user_details = null;
      $user_details = get_user_account_details_by_user_id( $get_user->id );

      if(count($user_details) > 0){
        $get_user_details = json_decode($user_details[0]['details']);
      } 

      $data['vendor_info'] = $get_user;
      $data['vendor_settings'] = $get_user_details;
      
      $get_global_seo = get_seo_data();
      $store_seo = $get_user_details->seo;

      $data['store_seo_meta_keywords'] = null;
      $data['store_seo_meta_description'] = null;

      if(isset($get_global_seo['meta_tag']['meta_keywords']) && !empty($store_seo->meta_keywords)){
        $data['store_seo_meta_keywords'] = trim($get_global_seo['meta_tag']['meta_keywords'].', '.$store_seo->meta_keywords, ',');
      }
      elseif(isset($get_global_seo['meta_tag']['meta_keywords']) && empty($store_seo->meta_keywords)){
        $data['store_seo_meta_keywords'] = $get_global_seo['meta_tag']['meta_keywords'];
      }
      else{
        $data['store_seo_meta_keywords'] = $store_seo->meta_keywords;
      }

      if(!empty($store_seo->meta_decription)){
        $data['store_seo_meta_description'] = $store_seo->meta_decription;
      }
      
      $data['vendor_home_page_cats'] = array();
      if(!empty($get_user_details->general_details->vendor_home_page_cats)){
        $vendor_home_cats = json_decode($get_user_details->general_details->vendor_home_page_cats);
        
        if(count($vendor_home_cats) > 0){
          foreach($vendor_home_cats as $cat){
            $explod_val = explode('#', $cat);
            $get_id = end($explod_val);
            $parent_cat = $this->product->getTermDataById( $get_id );

            array_push($data['vendor_home_page_cats'], array('parent_cat' => array_shift($parent_cat), 'child_cat' => $this->product->get_categories($get_id, 'product_cat')));
          }
        }
      }

      $data['vendor_advanced_items'] = $this->product->getVendorAdvancedProducts( $get_user->id );
      $data['vendor_reviews_rating_details']  =  get_comments_rating_details( $get_user->id, 'vendor' );
      
      return view('pages.frontend.vendors.vendor-details', $data);
    }
    else{
      return view('errors.no_data');
    }
  }
  
  /**
   * 
   * Multivendor store single page products content
   *
   * @param null
   * @return void 
   */
  public function multivendorStoreSinglePageProductsContent( $params ){
    $data = array();
    $user = $params;
    
    $get_user = User::where(['name' => $user, 'user_status' => 1])->first();
    if(empty($get_user)){
      return view('errors.vendor_not_active');
    }
    
    $data = $this->classCommonFunction->get_dynamic_frontend_content_data();
    $data['vendor_settings'] = null;
    $data['vendor_selected_cats_id'] = array();
    
    $get_user = User::where(['name' => $user])->first();
    if(!empty($get_user)){
      if(is_vendor_expired( $get_user->id )){
        return view('errors.vendor_expired');
      }
      
      $data['vendor_package_details'] = get_package_details_by_vendor_id($get_user->id);
      $data['vendor_settings'] = null;
      $get_user_details = null;
      $user_details = get_user_account_details_by_user_id( $get_user->id );

      if(count($user_details) > 0){
        $get_user_details = json_decode($user_details[0]['details']);
      } 

      $data['vendor_info'] = $get_user;
      $data['vendor_settings'] = $get_user_details;
      
      $get_global_seo = get_seo_data();
      $store_seo = $get_user_details->seo;

      $data['store_seo_meta_keywords'] = null;
      $data['store_seo_meta_description'] = null;

      if(isset($get_global_seo['meta_tag']['meta_keywords']) && !empty($store_seo->meta_keywords)){
        $data['store_seo_meta_keywords'] = trim($get_global_seo['meta_tag']['meta_keywords'].', '.$store_seo->meta_keywords, ',');
      }
      elseif(isset($get_global_seo['meta_tag']['meta_keywords']) && empty($store_seo->meta_keywords)){
        $data['store_seo_meta_keywords'] = $get_global_seo['meta_tag']['meta_keywords'];
      }
      else{
        $data['store_seo_meta_keywords'] = $store_seo->meta_keywords;
      }

      if(!empty($store_seo->meta_decription)){
        $data['store_seo_meta_description'] = $store_seo->meta_decription;
      }
      
      $data['vendor_home_page_cats'] = array();
      if(!empty($get_user_details->general_details->vendor_home_page_cats)){
        $vendor_home_cats = json_decode($get_user_details->general_details->vendor_home_page_cats);
        
        if(count($vendor_home_cats) > 0){
          foreach($vendor_home_cats as $cat){
            $explod_val = explode('#', $cat);
            $get_id = end($explod_val);
            $parent_cat = $this->product->getTermDataById( $get_id );
            array_push($data['vendor_selected_cats_id'], $get_id);
            array_push($data['vendor_home_page_cats'], array('parent_cat' => array_shift($parent_cat), 'child_cat' => $this->product->get_categories($get_id, 'product_cat')));
          }
        }
      }

      $data['vendor_advanced_items'] = $this->product->getVendorAdvancedProducts( $get_user->id );
      $data['vendor_reviews_rating_details']  =  get_comments_rating_details( $get_user->id, 'vendor' );
      
      //
      $sort = null;
      $price_min = null;
      $price_max = null;
      $selected_colors = null;
      $selected_sizes = null;

      if(isset($_GET['sort_by'])){
        $sort = $_GET['sort_by'];
      }

      if(isset($_GET['price_min'])){
        $price_min = $_GET['price_min'];
      }

      if(isset($_GET['price_max'])){
        $price_max = $_GET['price_max'];
      }

      if(isset($_GET['selected_colors'])){
        $selected_colors = $_GET['selected_colors'];
      }

      if(isset($_GET['selected_sizes'])){
        $selected_sizes = $_GET['selected_sizes'];
      }

      $data['popular_tags_list']  =   $this->product->getTermData( 'product_tag', false, null, 1 );
      $data['colors_list_data']   =   $this->product->getTermData( 'product_colors', false, null, 1 );
      $data['sizes_list_data']    =   $this->product->getTermData( 'product_sizes', false, null, 1 );

      $get_product = $this->product->getProductsByUserId( $get_user->id, $params, array('sort' => $sort, 'price_min' => $price_min, 'price_max' => $price_max, 'selected_colors' => $selected_colors, 'selected_sizes' => $selected_sizes) );

      if(count($get_product) > 0){
        $data['vendor_products'] = $get_product;

        if(count($data['vendor_products']) > 0){
          $data['vendor_products']['action_url'] = Request::url();

          $currentQuery = Request::query();

          if(count($currentQuery) > 0){
            if(isset($currentQuery['view'])){
              unset($currentQuery['view']);
            }

            if(count($currentQuery) > 0){
              $currentQuery['view'] = 'list';
              $data['vendor_products']['action_url_list_view'] = Request::url(). '?' . http_build_query($currentQuery);
              $currentQuery['view'] = 'grid';
              $data['vendor_products']['action_url_grid_view'] = Request::url(). '?' . http_build_query($currentQuery);
            }
            else{
              $data['vendor_products']['action_url_list_view'] = Request::url(). '?view=list';
              $data['vendor_products']['action_url_grid_view'] = Request::url(). '?view=grid';
            }
          }
          else{
            $data['vendor_products']['action_url_list_view'] = Request::url(). '?view=list';
            $data['vendor_products']['action_url_grid_view'] = Request::url(). '?view=grid';
          }

          if(isset($_GET['view']) && $_GET['view'] == 'list'){
            $data['vendor_products']['selected_view'] = 'list'; 
          }
          elseif(isset($_GET['view']) && $_GET['view'] == 'grid'){
            $data['vendor_products']['selected_view'] = 'grid'; 
          }
          else{
            $data['vendor_products']['selected_view'] = 'grid';
          }
        }
      }
      else{
        return view('errors.no_data');
      }
      
      return view('pages.frontend.vendors.vendor-details', $data);
    }
    else{
      return view('errors.no_data');
    }
  }
  
  /**
   * 
   * Multivendor store single page review content
   *
   * @param null
   * @return void 
   */
  public function multivendorStoreSinglePageReviewContent( $params ){
    $data = array();
    $user = $params;
    
    $get_user = User::where(['name' => $user, 'user_status' => 1])->first();
    if(empty($get_user)){
      return view('errors.vendor_not_active');
    }
    
    $data = $this->classCommonFunction->get_dynamic_frontend_content_data();
    $data['vendor_settings'] = null;
    $data['vendor_selected_cats_id'] = array();
    
    $get_user = User::where(['name' => $user])->first();
    if(!empty($get_user)){
      if(is_vendor_expired( $get_user->id )){
        return view('errors.vendor_expired');
      }
      
      $data['vendor_package_details'] = get_package_details_by_vendor_id($get_user->id);
      $data['vendor_settings'] = null;
      $get_user_details = null;
      $user_details = get_user_account_details_by_user_id( $get_user->id );

      if(count($user_details) > 0){
        $get_user_details = json_decode($user_details[0]['details']);
      } 

      $data['vendor_info'] = $get_user;
      $data['vendor_settings'] = $get_user_details;
      
      $get_global_seo = get_seo_data();
      $store_seo = $get_user_details->seo;

      $data['store_seo_meta_keywords'] = null;
      $data['store_seo_meta_description'] = null;

      if(isset($get_global_seo['meta_tag']['meta_keywords']) && !empty($store_seo->meta_keywords)){
        $data['store_seo_meta_keywords'] = trim($get_global_seo['meta_tag']['meta_keywords'].', '.$store_seo->meta_keywords, ',');
      }
      elseif(isset($get_global_seo['meta_tag']['meta_keywords']) && empty($store_seo->meta_keywords)){
        $data['store_seo_meta_keywords'] = $get_global_seo['meta_tag']['meta_keywords'];
      }
      else{
        $data['store_seo_meta_keywords'] = $store_seo->meta_keywords;
      }

      if(!empty($store_seo->meta_decription)){
        $data['store_seo_meta_description'] = $store_seo->meta_decription;
      }
      
      $data['comments_details']               =  get_comments_data_by_object_id( $get_user->id, 'vendor' );
      $data['comments_rating_details']        =  get_comments_rating_details( $get_user->id, 'vendor' );
      $data['vendor_reviews_rating_details']  =  get_comments_rating_details( $get_user->id, 'vendor' );
      $data['user_name']                      =  $user;
      
      return view('pages.frontend.vendors.vendor-details', $data);
    }
    else{
      return view('errors.no_data');
    }
  }
  
  /**
   * 
   * Multivendor store single page products categories content
   *
   * @param null
   * @return void 
   */
  public function multivendorStoreSinglePageProductsCatContent( $params, $params1 ){
    $data = array();
    $user = $params1;
    
    $get_user = User::where(['name' => $user, 'user_status' => 1])->first();
    if(empty($get_user)){
      return view('errors.vendor_not_active');
    }
    
    $data = $this->classCommonFunction->get_dynamic_frontend_content_data();
    $data['vendor_settings'] = null;
    $data['vendor_selected_cats_id'] = array();
    
    $get_user = User::where(['name' => $user])->first();
    if(!empty($get_user)){
      if(is_vendor_expired( $get_user->id )){
        return view('errors.vendor_expired');
      }
      
      $data['vendor_package_details'] = get_package_details_by_vendor_id($get_user->id);
      $data['vendor_settings'] = null;
      $get_user_details = null;
      $user_details = get_user_account_details_by_user_id( $get_user->id );

      if(count($user_details) > 0){
        $get_user_details = json_decode($user_details[0]['details']);
      } 

      $data['vendor_info'] = $get_user;
      $data['vendor_settings'] = $get_user_details;
      
      $get_global_seo = get_seo_data();
      $store_seo = $get_user_details->seo;

      $data['store_seo_meta_keywords'] = null;
      $data['store_seo_meta_description'] = null;

      if(isset($get_global_seo['meta_tag']['meta_keywords']) && !empty($store_seo->meta_keywords)){
        $data['store_seo_meta_keywords'] = trim($get_global_seo['meta_tag']['meta_keywords'].', '.$store_seo->meta_keywords, ',');
      }
      elseif(isset($get_global_seo['meta_tag']['meta_keywords']) && empty($store_seo->meta_keywords)){
        $data['store_seo_meta_keywords'] = $get_global_seo['meta_tag']['meta_keywords'];
      }
      else{
        $data['store_seo_meta_keywords'] = $store_seo->meta_keywords;
      }

      if(!empty($store_seo->meta_decription)){
        $data['store_seo_meta_description'] = $store_seo->meta_decription;
      }
      
      $data['vendor_home_page_cats'] = array();
      if(!empty($get_user_details->general_details->vendor_home_page_cats)){
        $vendor_home_cats = json_decode($get_user_details->general_details->vendor_home_page_cats);
        
        if(count($vendor_home_cats) > 0){
          foreach($vendor_home_cats as $cat){
            $explod_val = explode('#', $cat);
            $get_id = end($explod_val);
            $parent_cat = $this->product->getTermDataById( $get_id );
            array_push($data['vendor_selected_cats_id'], $get_id);
            array_push($data['vendor_home_page_cats'], array('parent_cat' => array_shift($parent_cat), 'child_cat' => $this->product->get_categories($get_id, 'product_cat')));
          }
        }
      }

      $data['vendor_advanced_items'] = $this->product->getVendorAdvancedProducts( $get_user->id );
      $data['vendor_reviews_rating_details']  =  get_comments_rating_details( $get_user->id, 'vendor' );
      
      //
      $sort = null;
      $price_min = null;
      $price_max = null;
      $selected_colors = null;
      $selected_sizes = null;
      
      if(isset($_GET['sort_by'])){
        $sort = $_GET['sort_by'];
      }
      
      if(isset($_GET['price_min'])){
        $price_min = $_GET['price_min'];
      }
      
      if(isset($_GET['price_max'])){
        $price_max = $_GET['price_max'];
      }
      
      if(isset($_GET['selected_colors'])){
        $selected_colors = $_GET['selected_colors'];
      }

      if(isset($_GET['selected_sizes'])){
        $selected_sizes = $_GET['selected_sizes'];
      }
      
			$data['popular_tags_list']  =   $this->product->getTermData( 'product_tag', false, null, 1 );
      $data['colors_list_data']   =   $this->product->getTermData( 'product_colors', false, null, 1 );
      $data['sizes_list_data']    =   $this->product->getTermData( 'product_sizes', false, null, 1 );
										
      $get_cat_product_and_breadcrumb  =  $this->product->getProductByCatSlug($params, array('sort' => $sort, 'price_min' => $price_min, 'price_max' => $price_max, 'selected_colors' => $selected_colors, 'selected_sizes' => $selected_sizes));
      
      if(count($get_cat_product_and_breadcrumb) > 0){
        $data['vendor_products'] = $get_cat_product_and_breadcrumb;
      }
      else{
        return view('errors.no_data');
      }
      
       
      if(count($data['vendor_products']) > 0){
        $data['vendor_products']['action_url'] = Request::url();
        
        $currentQuery = Request::query();
        
        if(count($currentQuery) > 0){
          if(isset($currentQuery['view'])){
            unset($currentQuery['view']);
          }
          
          if(count($currentQuery) > 0){
            $currentQuery['view'] = 'list';
            $data['vendor_products']['action_url_list_view'] = Request::url(). '?' . http_build_query($currentQuery);
            $currentQuery['view'] = 'grid';
            $data['vendor_products']['action_url_grid_view'] = Request::url(). '?' . http_build_query($currentQuery);
          }
          else{
            $data['vendor_products']['action_url_list_view'] = Request::url(). '?view=list';
            $data['vendor_products']['action_url_grid_view'] = Request::url(). '?view=grid';
          }
        }
        else{
          $data['vendor_products']['action_url_list_view'] = Request::url(). '?view=list';
          $data['vendor_products']['action_url_grid_view'] = Request::url(). '?view=grid';
        }
        
        if(isset($_GET['view']) && $_GET['view'] == 'list'){
          $data['vendor_products']['selected_view'] = 'list'; 
        }
        elseif(isset($_GET['view']) && $_GET['view'] == 'grid'){
          $data['vendor_products']['selected_view'] = 'grid'; 
        }
        else{
          $data['vendor_products']['selected_view'] = 'grid';
        }
      }
      
      return view('pages.frontend.vendors.vendor-details', $data);
    }
    else{
      return view('errors.no_data');
    }
  }
  
  /**
   * 
   * Product comparison page content
   *
   * @param null
   * @return void 
   */
  public function productComparisonPageContent(){
    $data = array();
    
    $data = $this->classCommonFunction->get_dynamic_frontend_content_data();
    $data['compare_product_data']  = array();
    $data['compare_product_label'] = null;

    $compare_data     =  $this->option->getProductCompareData();
    $custom_data      =  array('Image', 'Product', 'Price');

    if(!empty($compare_data)){
      $data['compare_product_label'] = (object) array_merge($custom_data, (array) $compare_data);
    }
    else{
      $data['compare_product_label'] = (object) $custom_data;
    }

    if(Session::has('shopist_selected_compare_product_ids') && count(Session::get('shopist_selected_compare_product_ids')) > 0){
      $get_comparison_product = Session::get('shopist_selected_compare_product_ids');

      foreach($get_comparison_product as $product){
        array_push($data['compare_product_data'],	$this->product->getProductDataById( $product ));
      }
    }
    
    return view('pages.frontend.frontend-pages.product-comparison', $data);
  }
  
  /**
   * 
   * Tag single page content
   *
   * @param null
   * @return void 
   */
  public function tagSinglePageContent( $params ){
    $data = array();
    $get_tag_by_slug = get_products_by_product_tag_slug( $params );
      
    if(count($get_tag_by_slug) > 0){
      $data = $this->classCommonFunction->get_dynamic_frontend_content_data();
      $data['tag_single_details']  =  $get_tag_by_slug;
      $data['popular_tags_list']   =  $this->product->getTermData( 'product_tag', false, null, 1 );
      
      return view('pages.frontend.frontend-pages.tag-single-page', $data);
    }
    else{
      return view('errors.no_data');
    }
  }
  
  /**
   * 
   * Designer single page content
   *
   * @param null
   * @return void 
   */
  //daizheng

  public function designerSinglePageContents($param1,$param2){

    $frontside=$param1;
    $backside=$param2;
  
   
    $get_products[] = Product::where(['slug' => $frontside, 'status' => 1])->first();
    
    $get_products[] = Product::where(['id' => $backside, 'status' => 1])->first();

  
   
    foreach ($get_products as $get_product) {
          
   
    if(!empty($get_product)){
      $data = array();
      $product_id  = $get_product->id;
      $get_product_type = get_product_type($product_id);
      
      if($get_product_type == 'customizable_product'){
        $get_current_user_data  =  get_current_frontend_user_info();

        $data = $this->classCommonFunction->get_dynamic_frontend_content_data();
        $data['single_product_details']  =  $this->product->getProductDataById( $product_id );
        $data['single_product_detailsbackside']  = $this->product->getProductDataById($backside);
       
        if(is_frontend_user_logged_in() && isset($get_current_user_data['user_role_slug']) && $data['single_product_details']['_is_role_based_pricing_enable'] == 'yes'){
          if(isset($data['single_product_details']['_role_based_pricing'][$get_current_user_data['user_role_slug']])){

            $regular_price = $data['single_product_details']['_role_based_pricing'][$get_current_user_data['user_role_slug']]['regular_price'];
            $sale_price = $data['single_product_details']['_role_based_pricing'][$get_current_user_data['user_role_slug']]['sale_price'];

            if(isset($regular_price) && $regular_price && isset($sale_price) && $sale_price && $regular_price > $sale_price){
              $data['single_product_details']['offer_price'] = get_product_price_html_by_filter($regular_price);
              $data['single_product_details']['solid_price'] = get_product_price_html_by_filter($sale_price);
            }
            elseif(isset($regular_price) && $regular_price){
              $data['single_product_details']['offer_price'] = null;
              $data['single_product_details']['solid_price'] = get_product_price_html_by_filter($regular_price);
            }
            else{
              $data['single_product_details']['offer_price'] = null;
              $data['single_product_details']['solid_price'] = 0;
            }
          }
        }  
        else{
          if($data['single_product_details']['post_regular_price'] && $data['single_product_details']['post_regular_price'] >0 && $data['single_product_details']['post_sale_price'] && $data['single_product_details']['post_sale_price']>0 && $data['single_product_details']['post_regular_price'] > $data['single_product_details']['post_sale_price'] ){
            $data['single_product_details']['offer_price'] = get_product_price_html_by_filter($data['single_product_details']['post_regular_price']);
          }
          else{
            $data['single_product_details']['offer_price'] = null;
          }

          $data['single_product_details']['solid_price']   = get_product_price_html_by_filter($data['single_product_details']['post_price']);
        }


        $data['single_product_details']['is_user_login']   = 'no';
        $data['single_product_details']['login_user_slug'] = '';

        if(is_frontend_user_logged_in()){
          $data['single_product_details']['is_user_login'] = 'yes';
        }

        if(count($get_current_user_data) > 0 && isset($get_current_user_data['user_role_slug'])){
          $data['single_product_details']['login_user_slug'] = $get_current_user_data['user_role_slug'];
        }

        if(Cookie::has('shopist_multi_currency')){
          $current_currency_name = get_current_currency_name();
          $to_currency    =  Cookie::get('shopist_multi_currency');
        }

        $product_url = default_placeholder_img_src();
        $data['product_zoom_image'] = $product_url;

        if($data['single_product_details']['_product_related_images_url']->product_image){
          $product_url = $data['single_product_details']['_product_related_images_url']->product_image;
          $data['product_zoom_image'] = $this->classCommonFunction->createZoomImageUrl( $product_url );
        }

        $data['single_product_details']['_product_related_images_url']->product_image = $product_url;
        $data['single_product_detailsbackside']['_product_related_images_url']->product_image = $product_url;


        $product = (object) array('id' => time(), 'url' => $product_url);
        $data['single_product_details']['_product_related_images_url']->product_gallery_images[0] = $product;
        $data['single_product_detailsbackside']['_product_related_images_url']->product_gallery_images[0] = $product;

        $gallery_images = $data['single_product_details']['_product_related_images_url']->product_gallery_images;
        if(count($gallery_images) > 0){
          foreach($gallery_images as $images){
            $images->zoom_img_url = $this->classCommonFunction->createZoomImageUrl( $images->url );
          }
        }

        $data['attr_lists']               =   $this->product->getAllAttributes( $product_id );
        $data['related_items']            =   $this->product->getRelatedItems( $product_id );  
        $data['comments_details']         =   get_comments_data_by_object_id( $product_id, 'product' );
        $data['comments_rating_details']  =   get_comments_rating_details( $product_id, 'product' );
        $data['vendor_reviews_rating_details']  =   get_comments_rating_details( get_vendor_id_by_product_id($product_id), 'vendor' );
        $data['fonts_list']               =   $this->product->getFontsList( false, null, 1 );
        $data['shape_list']               =   $this->product->getShapeList( false, null, 1 );


        $get_seo_data = get_seo_data();

        if(isset($get_seo_data['meta_tag']['meta_keywords']) && isset($data['single_product_details']['_product_seo_keywords'])){
          $data['single_product_details']['meta_keywords'] = trim( trim($get_seo_data['meta_tag']['meta_keywords'], ','). ',' .trim($data['single_product_details']['_product_seo_keywords'], ','), ',');
        }
        elseif(!isset($get_seo_data['meta_tag']['meta_keywords']) && isset($data['single_product_details']['_product_seo_keywords'])){
          $data['single_product_details']['meta_keywords'] = trim($data['single_product_details']['_product_seo_keywords'], ',');
        }
        elseif(isset($get_seo_data['meta_tag']['meta_keywords']) && !isset($data['single_product_details']['_product_seo_keywords'])){
          $data['single_product_details']['meta_keywords'] = trim($get_seo_data['meta_tag']['meta_keywords'], ',');
        }
        else{
          $data['single_product_details']['meta_keywords'] = null;
        }

        $data['upsell_products'] = get_upsell_products( $product_id );
        $data['designer_settings'] = $this->option->getCustomDesignerSettingsData();
        $data['art_cat_lists_data']  =   $this->product->getTermData( 'designer_cat', false, null, 1 );

        if($data['single_product_details']['_product_custom_designer_settings']['enable_global_settings'] == 'yes'){
          if(count($data['designer_settings'])>0){
            $data['designer_hf_data'] = $data['designer_settings']['general_settings'];
          }
        }
        elseif($data['single_product_details']['_product_custom_designer_settings']['enable_global_settings'] == 'no'){
          if(count($data['single_product_details']['_product_custom_designer_settings']) >0){
            $data['designer_hf_data'] = $data['single_product_details']['_product_custom_designer_settings'];
            $data['designer_hf_databackside'] = $data['single_product_detailsbackside']['_product_custom_designer_settings'];
          }
        }

        $get_data = SaveCustomDesign ::where('product_id', $product_id)->first();
       
        if(!empty($get_data)){
          $data['design_json_data'] = $get_data['design_data'];
        }
        else{
          return view('errors.no_data');
          
        }

        $get_databack = SaveCustomDesign ::where('product_id',$backside)->first();
         if(!empty($get_databack)){
          $data['design_json_databackside'] = $get_databack['design_data'];
        }
        else{
          return view('errors.no_data');
          
        }


        return view('pages.frontend.frontend-pages.frontend-designer', $data);
      }
      else{
        return view('errors.no_data');
      }
    }
    else{
      return view('errors.no_data');
    }
    }
  }
  
// daizheng
  public function designerSinglePageContent($params){

    
    
    // $frontside = str_replace(" ","-",$fs);
    // echo $frontside;
    // exit;
    //  $get_product1 = Product::where(['slug' => $frontside, 'status' => 1])->first();
    // $get_product2 = Product::where(['id' => $backside, 'status' => 1])->first();
    $get_product = Product::where(['slug' => $params, 'status' => 1])->first();
      
    if(!empty($get_product)){
      $data = array();
      $product_id  = $get_product->id;
      $get_product_type = get_product_type($product_id);
      
      if($get_product_type == 'customizable_product'){
        $get_current_user_data  =  get_current_frontend_user_info();

        $data = $this->classCommonFunction->get_dynamic_frontend_content_data();
        $data['single_product_details']  =  $this->product->getProductDataById( $product_id );

        if(is_frontend_user_logged_in() && isset($get_current_user_data['user_role_slug']) && $data['single_product_details']['_is_role_based_pricing_enable'] == 'yes'){
          if(isset($data['single_product_details']['_role_based_pricing'][$get_current_user_data['user_role_slug']])){

            $regular_price = $data['single_product_details']['_role_based_pricing'][$get_current_user_data['user_role_slug']]['regular_price'];
            $sale_price = $data['single_product_details']['_role_based_pricing'][$get_current_user_data['user_role_slug']]['sale_price'];

            if(isset($regular_price) && $regular_price && isset($sale_price) && $sale_price && $regular_price > $sale_price){
              $data['single_product_details']['offer_price'] = get_product_price_html_by_filter($regular_price);
              $data['single_product_details']['solid_price'] = get_product_price_html_by_filter($sale_price);
            }
            elseif(isset($regular_price) && $regular_price){
              $data['single_product_details']['offer_price'] = null;
              $data['single_product_details']['solid_price'] = get_product_price_html_by_filter($regular_price);
            }
            else{
              $data['single_product_details']['offer_price'] = null;
              $data['single_product_details']['solid_price'] = 0;
            }
          }
        }  
        else{
          if($data['single_product_details']['post_regular_price'] && $data['single_product_details']['post_regular_price'] >0 && $data['single_product_details']['post_sale_price'] && $data['single_product_details']['post_sale_price']>0 && $data['single_product_details']['post_regular_price'] > $data['single_product_details']['post_sale_price'] ){
            $data['single_product_details']['offer_price'] = get_product_price_html_by_filter($data['single_product_details']['post_regular_price']);
          }
          else{
            $data['single_product_details']['offer_price'] = null;
          }

          $data['single_product_details']['solid_price']   = get_product_price_html_by_filter($data['single_product_details']['post_price']);
        }


        $data['single_product_details']['is_user_login']   = 'no';
        $data['single_product_details']['login_user_slug'] = '';

        if(is_frontend_user_logged_in()){
          $data['single_product_details']['is_user_login'] = 'yes';
        }

        if(count($get_current_user_data) > 0 && isset($get_current_user_data['user_role_slug'])){
          $data['single_product_details']['login_user_slug'] = $get_current_user_data['user_role_slug'];
        }

        if(Cookie::has('shopist_multi_currency')){
          $current_currency_name = get_current_currency_name();
          $to_currency    =  Cookie::get('shopist_multi_currency');
        }

        $product_url = default_placeholder_img_src();
        $data['product_zoom_image'] = $product_url;

        if($data['single_product_details']['_product_related_images_url']->product_image){
          $product_url = $data['single_product_details']['_product_related_images_url']->product_image;
          $data['product_zoom_image'] = $this->classCommonFunction->createZoomImageUrl( $product_url );
        }

        $data['single_product_details']['_product_related_images_url']->product_image = $product_url;


        $product = (object) array('id' => time(), 'url' => $product_url);
        $data['single_product_details']['_product_related_images_url']->product_gallery_images[0] = $product;

        $gallery_images = $data['single_product_details']['_product_related_images_url']->product_gallery_images;
        if(count($gallery_images) > 0){
          foreach($gallery_images as $images){
            $images->zoom_img_url = $this->classCommonFunction->createZoomImageUrl( $images->url );
          }
        }

        $data['attr_lists']               =   $this->product->getAllAttributes( $product_id );
        $data['related_items']            =   $this->product->getRelatedItems( $product_id );  
        $data['comments_details']         =   get_comments_data_by_object_id( $product_id, 'product' );
        $data['comments_rating_details']  =   get_comments_rating_details( $product_id, 'product' );
        $data['vendor_reviews_rating_details']  =   get_comments_rating_details( get_vendor_id_by_product_id($product_id), 'vendor' );
        $data['fonts_list']               =   $this->product->getFontsList( false, null, 1 );
        $data['shape_list']               =   $this->product->getShapeList( false, null, 1 );


        $get_seo_data = get_seo_data();

        if(isset($get_seo_data['meta_tag']['meta_keywords']) && isset($data['single_product_details']['_product_seo_keywords'])){
          $data['single_product_details']['meta_keywords'] = trim( trim($get_seo_data['meta_tag']['meta_keywords'], ','). ',' .trim($data['single_product_details']['_product_seo_keywords'], ','), ',');
        }
        elseif(!isset($get_seo_data['meta_tag']['meta_keywords']) && isset($data['single_product_details']['_product_seo_keywords'])){
          $data['single_product_details']['meta_keywords'] = trim($data['single_product_details']['_product_seo_keywords'], ',');
        }
        elseif(isset($get_seo_data['meta_tag']['meta_keywords']) && !isset($data['single_product_details']['_product_seo_keywords'])){
          $data['single_product_details']['meta_keywords'] = trim($get_seo_data['meta_tag']['meta_keywords'], ',');
        }
        else{
          $data['single_product_details']['meta_keywords'] = null;
        }

        $data['upsell_products'] = get_upsell_products( $product_id );
        $data['designer_settings'] = $this->option->getCustomDesignerSettingsData();
        $data['art_cat_lists_data']  =   $this->product->getTermData( 'designer_cat', false, null, 1 );

        if($data['single_product_details']['_product_custom_designer_settings']['enable_global_settings'] == 'yes'){
          if(count($data['designer_settings'])>0){
            $data['designer_hf_data'] = $data['designer_settings']['general_settings'];
          }
        }
        elseif($data['single_product_details']['_product_custom_designer_settings']['enable_global_settings'] == 'no'){
          if(count($data['single_product_details']['_product_custom_designer_settings']) >0){
            $data['designer_hf_data'] = $data['single_product_details']['_product_custom_designer_settings'];
          }
        }

        $get_data = SaveCustomDesign ::where('product_id', $product_id)->first();

        if(!empty($get_data)){
          $data['design_json_data'] = $get_data['design_data'];
        }
        else{
          return view('errors.no_data');
          
        }

        return view('pages.frontend.frontend-pages.frontend-designer', $data);
      }
      else{
        return view('errors.no_data');
      }
    }
    else{
      return view('errors.no_data');
    }
  }
  /**
   * 
   * Checkout received order
   *
   * @param order_id, order_processing_id
   * @return void 
   */
  public function thankyouPageContent( $params, $params2 ){
    $data = array();
    $get_order_data = $this->classCommonFunction->get_order_details_by_order_id(array('order_id' => $params, 'order_process_id' => $params2));
    $data = $this->classCommonFunction->get_dynamic_frontend_content_data();
    
    if(count($get_order_data) > 0){
      $get_order_data['settings'] = $this->option->getSettingsData();  
      $data['order_details_for_thank_you_page'] = $get_order_data;
    }
    else{
      $data['order_details_for_thank_you_page'] = array();
    }
    
    return view('pages.frontend.frontend-pages.thank-you', $data);
  }

  /**
   * 
   *Manage for cart page
   *
   * @param null
   * @return void 
   */
  public function doActionFromCartPage(){
    $data = Input::all();
            
    if( Request::isMethod('post') && isset($data['empty_cart']) && Session::token() == Input::get('_token')){
      $this->cart->clear();
      return redirect()->back();
    }
    elseif( Request::isMethod('post') && isset($data['update_cart']) && Session::token() == Input::get('_token')){
      if(count($data['cart_quantity']) > 0){
        foreach($data['cart_quantity'] as $key => $qty){
          $this->cart->updateQty($key, $qty);
        }
      }
      return redirect()->back();
    }
    elseif( Request::isMethod('post') && isset($data['checkout']) && Session::token() == Input::get('_token')){
      if($this->cart->getItems()){
        foreach($this->cart->getItems() as $items){
          if($items->variation_id && count($items->options) > 0){
            $variation_product_data = $this->classCommonFunction->get_variation_and_data_by_post_id( $items->variation_id );
            
            if($variation_product_data['_variation_post_price'] == 0){
              Session::flash('message', Lang::get('frontend.sorry_label') .' '. get_product_title($variation_product_data['parent_id']) .' '. Lang::get('frontend.price_zero_validation'));
              $this->cart->clear();
              return redirect()->back();
            }

            if($variation_product_data['_variation_post_manage_stock'] == 1){
              if($variation_product_data['_variation_post_manage_stock_qty'] == 0){
                Session::flash('message', Lang::get('frontend.sorry_label') .' '.get_product_title($variation_product_data['parent_id']) .' '. Lang::get('frontend.stock_validation'));
                $this->cart->clear();
                return redirect()->back();
              }

              if(isset($this->cart->get($items->id)->quantity)){
               $cat_qty = $this->cart->get($items->id)->quantity;

               if($cat_qty > $variation_product_data['_variation_post_manage_stock_qty']){
                 Session::flash('message', Lang::get('frontend.sorry_label') .' '.get_product_title($variation_product_data['parent_id']) .' '. Lang::get('frontend.stock_validation'));
                 $this->cart->clear();
                 return redirect()->back();
               }
              }
            }
          }
          else{
            $product_data = $this->classCommonFunction->get_product_data_by_product_id( $items->id );
          
            if($product_data['product_price'] == 0){
              Session::flash('message', Lang::get('frontend.sorry_label') .' '.$product_data['post_title'] .' '. Lang::get('frontend.price_zero_validation'));
              $this->cart->clear();
              return redirect()->back();
            }

            if($product_data['product_manage_stock'] == 'yes'){
              if($product_data['product_manage_stock_qty'] == 0){
                Session::flash('message', Lang::get('frontend.sorry_label') .' '.$product_data['post_title'] .' '. Lang::get('frontend.stock_validation'));
                $this->cart->clear();
                return redirect()->back();
              }

              if(isset($this->cart->get($items->id)->quantity)){
               $cat_qty = $this->cart->get($items->id)->quantity;

               if($cat_qty > $product_data['product_manage_stock_qty']){
                 Session::flash('message', Lang::get('frontend.sorry_label') .' '.$product_data['post_title'] .' '. Lang::get('frontend.stock_validation'));
                 $this->cart->clear();
                 return redirect()->back();
               }
              }
            }
          }
        }
        
        return redirect()->route('checkout-page');
      }
    }
  }

  /**
   * 
   *Item remove from cart
   *
   * @param item id
   * @return void
   */
  public function doActionForRemoveItem( $item_id ){
    if($item_id){
      if( $this->cart->remove( $item_id ) ){
        return redirect()->back();
      }
    }
  }
  
  /**
   * 
   *Remove compare product from list
   *
   * @param product id
   * @return void
   */
  public function doActionForRemoveCompareProduct( $product_id ){
    if($product_id){
      if(Session::has('shopist_selected_compare_product_ids') && count(Session::get('shopist_selected_compare_product_ids')) > 0){
        $array = array();
        foreach(Session::get('shopist_selected_compare_product_ids') as $val){
          if($val != $product_id){
            array_push($array, $val);
          }
        }
        
        Session::forget('shopist_selected_compare_product_ids');
        Session::put('shopist_selected_compare_product_ids', $array);
        
        return redirect()->back();
      }
    }
  }
  
  /**
   * 
   * Force file download for downloadable product
   *
   * @param product id, file key
   * @return void
   */
  public function forceDownload( $post_id, $order_id, $file_key, $target ){
    $get_orders_items  =   OrdersItem::where(['order_id' => $order_id])->first();
    
    if(!empty($get_orders_items)){
      $orders_items = json_decode( $get_orders_items->order_data, TRUE );
    }
    
    if( $this->classCommonFunction->checkDownloadRequired( $orders_items[$post_id]['download_data'], $order_id ) && isset($orders_items[$post_id]['download_data']['downloadable_files'][$file_key]) && isset($orders_items[$post_id]['download_data']['downloadable_files'][$file_key][$target]) ){
      $parse_url = explode('uploads', $orders_items[$post_id]['download_data']['downloadable_files'][$file_key][$target]);
   
      if(count($parse_url) > 0 && isset($parse_url[1])){
        $file_path = public_path().'/uploads'.$parse_url[1];
        
        if(File::exists($file_path)){
          $get_extension = File::extension($file_path);
          $get_content_type = File::mimeType($file_path);

          if(!empty($get_extension) && !empty($get_content_type)){
            $filename = time().'-'.uniqid(true).'.'.$get_extension;
            
            $user_id = 0;
            $get_post = PostExtra::where(['post_id' => $order_id, 'key_name' => '_order_process_key'])->first();

            if(is_frontend_user_logged_in()){
              $get_user_info = get_current_frontend_user_info();
              $user_id = $get_user_info['user_id'];
            }
            
            $headers = array(
              'Content-Type:'.$get_content_type,
            );
            
            //save download data
            $downloadextra = new DownloadExtra;
            $downloadextra->post_id      =   $post_id;
            $downloadextra->order_id     =   $order_id;
            $downloadextra->order_key		 =   $get_post->key_value;
            $downloadextra->user_id			 =   $user_id;
            $downloadextra->file_name		 =   $orders_items[$post_id]['download_data']['downloadable_files'][$file_key]['file_name'];
            $downloadextra->file_url		 =   $parse_url[1];
            
            if($downloadextra->save()){
              return Response::download($file_path, $filename, $headers);
            }
          }
        } 
      }
    }
  }
}