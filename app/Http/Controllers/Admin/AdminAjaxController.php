<?php
namespace shopist\Http\Controllers\Admin;

use shopist\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Validator;
use Illuminate\Support\Facades\Response;
use Request;
use shopist\Models\Term;
use shopist\Models\TermExtra;
use shopist\Models\Post;
use shopist\Models\PostExtra;
use shopist\Models\VendorAnnouncement;
use shopist\Models\Option;
use shopist\Models\OrdersItem;
use shopist\Models\VendorPackage;
use shopist\Models\VendorWithdraw;
use shopist\Models\VendorTotal;
use shopist\Models\VendorOrder;
use Session;
use shopist\Library\CommonFunction;
use shopist\Library\GetFunction;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Lang;
use shopist\Models\ManageLanguage;
use shopist\Models\User;
use shopist\Models\RoleUser;
use shopist\Models\UsersDetail;
use shopist\Models\UserRolePermission;
use shopist\Models\Role;
use shopist\Models\Comment;
use shopist\Models\RequestProduct;
use shopist\Models\ObjectRelationship;
use Illuminate\Support\Facades\DB;
use shopist\Http\Controllers\ProductsController;
use shopist\Http\Controllers\OptionController;
use Illuminate\Support\Facades\App;
use shopist\Models\Product;
use shopist\Models\ProductExtra;


class AdminAjaxController extends Controller
{
  public $classCommonFunction;
  public $settingsData;
  public $currency_symbol;
  public $product;
  public $option;
  public $env;
  
  public function __construct() {
    $this->classCommonFunction  =  new CommonFunction();
		$this->product  =  new ProductsController();
    $this->option   =  new OptionController();
    $this->env = App::environment();
    
    $this->settingsData    = $this->option->getSettingsData();
    $this->currency_symbol = $this->classCommonFunction->get_currency_symbol( $this->settingsData['general_settings']['currency_options']['currency_name'] );
  }
  
  /**
   * 
   * Save all images
   *
   * @param null
   * @return void
   */
  public function saveRelatedImage(){
    if(Request::isMethod('post') && Request::ajax()){
      if(Session::token() == Request::header('X-CSRF-TOKEN')){
        $input = Input::all();
        $rules = array();

        if(isset($input['product_image'])){
          $rules = array(
												'product_image' => 'image',
          );
        }
        elseif(isset($input['shop_banner_image'])){
          $rules = array(
            'shop_banner_image' => 'image',
          );
        }
        elseif(isset($input['cat_thumbnail_image'])){
          $rules = array(
            'cat_thumbnail_image' => 'image',
          );
        }
        elseif(isset($input['manufacturers_logo'])){
          $rules = array(
            'manufacturers_logo' => 'image',
          );
        }
        elseif(isset($input['variation_img'])){
          $rules = array(
            'variation_img' => 'image',
          );
        }
        elseif(isset($input['designer_img'])){
          $rules = array(
            'designer_img' => 'image',
          );
        }
        elseif(isset($input['update_art_imges'])){
          $rules = array(
            'update_art_imges' => 'image',
          );
        }
        elseif(isset($input['profile_picture'])){
          $rules = array(
            'profile_picture' => 'image',
          );
        }
        elseif(isset($input['site_picture'])){
          $rules = array(
            'site_picture' => 'image',
          );
        }
        elseif(isset($input['vendor_cover_picture'])){
          $rules = array(
            'vendor_cover_picture' => 'image',
          );
        }
        elseif(isset($input['testimonial_image'])){
          $rules = array(
            'testimonial_image' => 'image',
          );
        }
        elseif(isset($input['featured_image'])){
          $rules = array(
            'featured_image' => 'image',
          );
        }
        

        $validation = Validator::make($input, $rules);

        if ($validation->fails()) {
          return Response::make($validation->errors->first(), 400);
        }
        else{
          $fileName = '';
          $image    = '';
          $width    = 0;
          $height   = 0;
          
          
          if(isset($input['product_image'])){
            $image = Input::file('product_image');
            $fileName = time()."-"."h-250-".$image->getClientOriginalName();
            $height = 250;
          }
          elseif(isset($input['shop_banner_image'])){
            $image = Input::file('shop_banner_image');
            $fileName = time()."-"."w-1170-h-150-".$image->getClientOriginalName();
            $width  = 1170;
          }
          elseif(isset($input['cat_thumbnail_image'])){
            $image = Input::file('cat_thumbnail_image');
            $fileName = time()."-"."h-150-".$image->getClientOriginalName();
            $height = 150;
          }
          elseif(isset($input['manufacturers_logo'])){
            $image = Input::file('manufacturers_logo');
            $fileName = time()."-"."h-80-".$image->getClientOriginalName();
            $height = 80;
          }
          elseif(isset($input['variation_img'])){
            $image = Input::file('variation_img');
            $fileName = time()."-"."h-250-".$image->getClientOriginalName();
            $height = 250;
          }
          elseif(isset($input['designer_img'])){
            $image = Input::file('designer_img');
            $dimension = getimagesize($image);
            
            $fileName = time()."-"."design-image-".$image->getClientOriginalName();
            $width  = $dimension[0];
            $height = $dimension[1];
          }
          elseif(isset($input['update_art_imges'])){
            $image = Input::file('update_art_imges');
            $fileName = time()."-"."h-150-".$image->getClientOriginalName();
            $height = 150;
          }
          elseif(isset($input['profile_picture'])){
            $image = Input::file('profile_picture');
            $fileName = time()."-"."h-100-".$image->getClientOriginalName();
            $height = 100;
          }
          elseif(isset($input['site_picture'])){
            $image = Input::file('site_picture');
            $fileName = time()."-"."h-40-".$image->getClientOriginalName();
            $height = 40;
          }
          elseif(isset($input['vendor_cover_picture'])){
            $image = Input::file('vendor_cover_picture');
            $fileName = time()."-"."w-1200-h-500-".$image->getClientOriginalName();
            $width  = 1200;
            $height = 500;
          }
          elseif(isset($input['testimonial_image'])){
            $image = Input::file('testimonial_image');
            $fileName = time()."-"."h-100-".$image->getClientOriginalName();
            $height = 100;
          }
          elseif(isset($input['featured_image'])){
            $image = Input::file('featured_image');
            $fileName = time()."-"."h-320-".$image->getClientOriginalName();
            $width  = 397;
            $height = 303;
          }
          
          $img   = Image::make($image);
          $path  = public_path('uploads/' . $fileName);
          
          if(isset($input['product_image'])){
            $img->resize(900, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            
            $img->save(public_path('uploads/' . 'large-'.$fileName));
          }
          
          if($width > 0 && $height > 0){
            $img->resize($width, $height);
          }
          elseif($width >0 && $height == 0){
            $img->resize($width, null, function ($constraint) {
                $constraint->aspectRatio();
            });
          }
          else{
            $img->resize(null, $height, function ($constraint) {
                $constraint->aspectRatio();
            });
          }
          
          if ($img->save($path)) {
            return response()->json(array('status' => 'success', 'name' => $fileName));
          } else {
            return Response::json('error', 400);
          }
        }
      }
    }
  }
  
  /**
   * 
   * Save product gallery images
   *
   * @param null
   * @return void
   */
  public function saveProductGalleryImages(){
    if(Request::isMethod('post') && Request::ajax()){
      if(Session::token() == Request::header('X-CSRF-TOKEN')){
        $input = Input::all();
        $files = array();
        
        $count = 0;
        foreach($input['product_gallery_images'] as $key => $value ){
          $rules = array(
                 $key => 'image',
          );

          $validation = Validator::make($input['product_gallery_images'], $rules);

          if ($validation->fails()) {
            return Response::make($validation->errors->first(), 400);
          }
          else{
            $image = $value;
            $fileName = $count.time()."-"."h-250-".$image->getClientOriginalName();
            $path  = public_path('uploads/' . $fileName);
            
            $img   = Image::make($image);
            
            //zoom image save
            $img->resize(900, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            
            $img->save(public_path('uploads/' . 'large-'.$fileName));
            //end zoom image save
            
            
            $img->resize(null, 250, function ($constraint) {
                $constraint->aspectRatio();
            });
            
            if ($img->save($path)) {
              $files[] = $fileName;
            }
          }
          
          $count ++;
        }
        
        if (count($files) > 0) {
            return response()->json(array('status' => 'success', 'name' => json_encode($files)));
        } else {
            return Response::json('error', 400);
        }
      }  
    }
  }
  
  /**
   * 
   * Save custom design art images
   *
   * @param null
   * @return void
   */
  public function saveArtAllImages(){
    if(Request::isMethod('post') && Request::ajax() && Session::token() == Request::header('X-CSRF-TOKEN')){
      $input = Input::all();
      $files = array();

      $count = 0;
      foreach($input['art_imges'] as $key => $value ){
        $rules = array(
               $key => 'image',
        );

        $validation = Validator::make($input['art_imges'], $rules);

        if ($validation->fails()){
          return Response::make($validation->errors->first(), 400);
        }
        else{
          $image = $value;
          $fileName = $count.time()."-"."h-150-".$image->getClientOriginalName();
          $path  = public_path('uploads/' . $fileName);

          $img   = Image::make($image);

          $img->resize(null, 150, function ($constraint) {
              $constraint->aspectRatio();
          });

          if ($img->save($path)) {
            $files[] = $fileName;
          }
        }

        $count ++;
      }

      if (count($files) > 0) {
          return response()->json(array('status' => 'success', 'name' => json_encode($files)));
      } else {
          return Response::json('error', 400);
      }
    }
  }
  
  /**
   * 
   * Save categories details
   *
   * @param null
   * @return void
   */
  public function saveCategoriesDetails(){
    $input = Request::all();
    
    if(Request::isMethod('post') && Request::ajax()){
      if(Session::token() == Request::header('X-CSRF-TOKEN')){
        if((isset($input['data']['name'])&& $input['data']['name']) && (isset($input['data']['slug']) && $input['data']['slug'])){
          
					$termObj					=			new Term;
					$termExtraObj			=			new TermExtra;
          $cat_slug					=			'';
												
          $check_slug  = Term::where(['slug' => string_slug_format( $input['data']['slug'] )])->orWhere('slug', 'like', '%' . string_slug_format( $input['data']['slug'] ) . '%')->get()->count();

          if($check_slug === 0){
						$cat_slug = string_slug_format( $input['data']['slug'] );
          }
          elseif($check_slug > 0){
            $slug_count = $check_slug + 1;
            $cat_slug = string_slug_format( $input['data']['slug'] ). '-' . $slug_count;
          }

          if($input['data']['click_source'] == 'for_add'){
												$termObj->name        =   $input['data']['name'];
												$termObj->slug        =   $cat_slug;
												$termObj->type				=   $input['data']['cat_for'];
												$termObj->parent		  =   $input['data']['parent'];
                        $termObj->status			=   $input['data']['status'];
                        $termObj->fb      =   $input['data']['fb'];
														
            if( $termObj->save() ){
              if(TermExtra::insert(array(
                                      array(
                                          'term_id'       =>  $termObj->id,
                                          'key_name'      =>  '_category_description',
                                          'key_value'     =>  $input['data']['description'],
                                          'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                          'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                      ),
                                      array(
                                          'term_id'       =>  $termObj->id,
                                          'key_name'      =>  '_category_img_url',
                                          'key_value'     =>  $input['data']['img_url'],
                                          'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                          'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                      )
                                  )
              )){
                      return response()->json(array('success' => TRUE));
              }
            }
          }
          elseif ($input['data']['click_source'] == 'for_update'){
            $cat_slug = $input['data']['slug'];
            $data = array(
                          'name'				=>    $input['data']['name'],
                          'slug'				=>    $cat_slug,
                          'type'        =>    $input['data']['cat_for'],
                          'parent'      =>    $input['data']['parent'],
                          'status'      =>    $input['data']['status'],
                          'fb'          =>   $input['data']['fb']

            );
              
            if( Term::where('term_id', $input['data']['id'])->update($data)){
              $description = array(
                              'key_value'    =>  $input['data']['description']
              );

              $img_url = array(
                          'key_value'    =>  $input['data']['img_url']
              );

              TermExtra::where(['term_id' => $input['data']['id'], 'key_name' => '_category_description'])->update($description);
              TermExtra::where(['term_id' => $input['data']['id'], 'key_name' => '_category_img_url'])->update($img_url);
																
              return response()->json(array('success' => TRUE));
            }
          }
        }
        else {
          return response()->json(array('error_no_entered' => FALSE));
        }
      }
    }
  }
  
  /**
   * 
   * Save product tags details
   *
   * @param null
   * @return void
   */
  public function saveTagsDetails(){
    $input = Request::all();
    
    if(Request::isMethod('post') && Request::ajax() && Session::token() == Request::header('X-CSRF-TOKEN')){
      if(isset($input['data']['name'])&& $input['data']['name']){
        $termObj			 =		new Term;
				$termExtraObj	 =		new TermExtra;
        $tag_slug      =    '';
        
        $check_slug  =  Term::where(['slug' => string_slug_format( $input['data']['name'] )])->orWhere('slug', 'like', '%' . string_slug_format( $input['data']['name'] ) . '%')->get()->count();

        if($check_slug === 0){
          $tag_slug = string_slug_format( $input['data']['name'] );
        }
        elseif($check_slug > 0){
          $slug_count = $check_slug + 1;
          $tag_slug = string_slug_format( $input['data']['name'] ). '-' . $slug_count;
        }
        
        if($input['data']['click_source'] == 'for_add'){
            $termObj->name        =   $input['data']['name'];
            $termObj->slug        =   $tag_slug;
            $termObj->type				=   'product_tag';
            $termObj->parent		  =   0;
            $termObj->status			=   $input['data']['status'];
             $termObj->fb      =   $input['data']['fb'];

          if( $termObj->save() ){
            if(TermExtra::insert(array(
                                    array(
                                        'term_id'       =>  $termObj->id,
                                        'key_name'      =>  '_tag_description',
                                        'key_value'     =>  $input['data']['description'],
                                        'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                        'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                    )
                                )
            )){
              return response()->json(array('success' => TRUE));
            }
          }
        }
        elseif ($input['data']['click_source'] == 'for_update'){
          $data = array(
                        'name'				=>    $input['data']['name'],
                        'status'      =>    $input['data']['status'],
                        'fb'          =>   $input['data']['fb']
          );

          if( Term::where('term_id', $input['data']['id'])->update($data)){
            $description = array(
                            'key_value'    =>  $input['data']['description']
            );

            TermExtra::where(['term_id' => $input['data']['id'], 'key_name' => '_tag_description'])->update($description);
            return response()->json(array('success' => TRUE));
          }
        }
      }
      else {
        return response()->json(array('error_no_entered' => FALSE));
      }
    }
  }
  
  /**
   * 
   * Save product attribute details
   *
   * @param null
   * @return void
   */
  public function saveAttributesDetails(){
    $input = Request::all();
    
    if(Request::isMethod('post') && Request::ajax() && Session::token() == Request::header('X-CSRF-TOKEN')){
      if((isset($input['data']['attrName'])&& $input['data']['attrName']) && (isset($input['data']['attrVal'])&& $input['data']['attrVal'])){
        $termObj			 =		new Term;
				$termExtraObj	 =		new TermExtra;
        $attr_slug      =    '';
        
        $check_slug  =  Term::where(['slug' => string_slug_format( $input['data']['attrName'] )])->orWhere('slug', 'like', '%' . string_slug_format( $input['data']['attrName'] ) . '%')->get()->count();

        if($check_slug === 0){
          $attr_slug = string_slug_format( $input['data']['attrName'] );
        }
        elseif($check_slug > 0){
          $slug_count = $check_slug + 1;
          $attr_slug = string_slug_format( $input['data']['attrName'] ). '-' . $slug_count;
        }
        
        if($input['data']['click_source'] == 'for_add'){
            $termObj->name        =   $input['data']['attrName'];
            $termObj->slug        =   $attr_slug;
            $termObj->type				=   'product_attr';
            $termObj->parent		  =   0;
            $termObj->status			=   $input['data']['status'];

          if( $termObj->save() ){
            if(TermExtra::insert(array(
                                    array(
                                        'term_id'       =>  $termObj->id,
                                        'key_name'      =>  '_product_attr_values',
                                        'key_value'     =>  $input['data']['attrVal'],
                                        'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                        'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                    )
                                )
            )){
              return response()->json(array('success' => TRUE));
            }
          }
        }
        elseif ($input['data']['click_source'] == 'for_update'){
          $data = array(
                        'name'				=>    $input['data']['attrName'],
                        'status'      =>    $input['data']['status']
          );

          if( Term::where('term_id', $input['data']['id'])->update($data)){
            $attrVal = array(
                            'key_value'    =>  $input['data']['attrVal']
            );

            TermExtra::where(['term_id' => $input['data']['id'], 'key_name' => '_product_attr_values'])->update($attrVal);
            return response()->json(array('success' => TRUE));
          }
        }
      }
      else {
        return response()->json(array('error_no_entered' => FALSE));
      }
    }
  }
  
  /**
   * 
   * Save product color details
   *
   * @param null
   * @return void
   */
  public function saveColorDetails(){
    $input = Request::all();
    
    if(Request::isMethod('post') && Request::ajax() && Session::token() == Request::header('X-CSRF-TOKEN')){
      if((isset($input['data']['colorName'])&& $input['data']['colorName'])){
        $termObj			 =		new Term;
				$termExtraObj	 =		new TermExtra;
        $color_slug    =    '';
        
        $check_slug  =  Term::where(['slug' => string_slug_format( $input['data']['colorName'] )])->orWhere('slug', 'like', '%' . string_slug_format( $input['data']['colorName'] ) . '%')->get()->count();

        if($check_slug === 0){
          $color_slug = string_slug_format( $input['data']['colorName'] );
        }
        elseif($check_slug > 0){
          $slug_count = $check_slug + 1;
          $color_slug = string_slug_format( $input['data']['colorName'] ). '-' . $slug_count;
        }
        
        if($input['data']['click_source'] == 'for_add'){
            $termObj->name        =   $input['data']['colorName'];
            $termObj->slug        =   $color_slug;
            $termObj->type				=   'product_colors';
            $termObj->parent		  =   0;
            $termObj->status			=   $input['data']['status'];

          if( $termObj->save() ){
            if(TermExtra::insert(array(
                                    array(
                                        'term_id'       =>  $termObj->id,
                                        'key_name'      =>  '_product_color_code',
                                        'key_value'     =>  $input['data']['colorCode'],
                                        'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                        'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                    )
                                )
            )){
              return response()->json(array('success' => TRUE));
            }
          }
        }
        elseif ($input['data']['click_source'] == 'for_update'){
          $data = array(
                        'name'				=>    $input['data']['colorName'],
                        'status'      =>    $input['data']['status']
          );

          if( Term::where('term_id', $input['data']['id'])->update($data)){
            $colorCode = array(
                         'key_value'    =>  $input['data']['colorCode']
            );

            TermExtra::where(['term_id' => $input['data']['id'], 'key_name' => '_product_color_code'])->update($colorCode);
            return response()->json(array('success' => TRUE));
          }
        }
      }
      else {
        return response()->json(array('error_no_entered' => FALSE));
      }
    }
  }
  
  /**
   * 
   * Save product size details
   *
   * @param null
   * @return void
   */
  public function saveSizeDetails(){
    $input = Request::all();
    
    if(Request::isMethod('post') && Request::ajax() && Session::token() == Request::header('X-CSRF-TOKEN')){
      if((isset($input['data']['sizeName'])&& $input['data']['sizeName'])){
        $termObj			 =		new Term;
				$termExtraObj	 =		new TermExtra;
        $size_slug     =    '';
        
        $check_slug  =  Term::where(['slug' => string_slug_format( $input['data']['sizeName'] )])->orWhere('slug', 'like', '%' . string_slug_format( $input['data']['sizeName'] ) . '%')->get()->count();

        if($check_slug === 0){
          $size_slug = string_slug_format( $input['data']['sizeName'] );
        }
        elseif($check_slug > 0){
          $slug_count = $check_slug + 1;
          $size_slug = string_slug_format( $input['data']['sizeName'] ). '-' . $slug_count;
        }
        
        if($input['data']['click_source'] == 'for_add'){
            $termObj->name        =   $input['data']['sizeName'];
            $termObj->slug        =   $size_slug;
            $termObj->type				=   'product_sizes';
            $termObj->parent		  =   0;
            $termObj->status			=   $input['data']['status'];

          if( $termObj->save() ){
            return response()->json(array('success' => TRUE));
          }
        }
        elseif ($input['data']['click_source'] == 'for_update'){
          $data = array(
                        'name'		 =>    $input['data']['sizeName'],
                        'status'   =>    $input['data']['status']
          );

          if( Term::where('term_id', $input['data']['id'])->update($data)){
            return response()->json(array('success' => TRUE));
          }
        }
      }
      else {
        return response()->json(array('error_no_entered' => FALSE));
      }
    }
  }
  
  /**
   * 
   * Save products variations
   *
   * @param null
   * @return void
   */
  public function saveProductsVariations(){
    $input = Request::all();
    
    if(Request::isMethod('post') && Request::ajax() && Session::token() == Request::header('X-CSRF-TOKEN')){
      if((isset($input['data']['variation_sku'])&& $input['data']['variation_sku'])){
        $skuCheck  =  PostExtra :: where(['key_name' => '_variation_post_sku', 'key_value' => $input['data']['variation_sku']])->first();
        
        if( ( !empty($skuCheck) &&  $skuCheck->post_id == $input['data']['variation_id'] ) ||  empty($skuCheck)){
           
          $price          = 0;
          $regular_price  = '';
          $sale_price     = '';
          $stock_qty      = 0;
          $pfb            = 0;
          $status         = false;
          $role_price = array();
          $downloadable_data = array();
          $download_limit = '';
          $download_expiry_date = '';
          $today = date("Y-m-d");


          if(is_numeric($input['data']['regular_price'])){
            $regular_price = $input['data']['regular_price'];
          }

          if(is_numeric($input['data']['sale_price']) && isset($input['data']['regular_price'])){
            $sale_price = $input['data']['sale_price'];
          }

          if(is_numeric($input['data']['stock_qty'])){
            $stock_qty = $input['data']['stock_qty'];
          }
          
          if(is_numeric($input['data']['stock_qty'])){
            $stock_qty = $input['data']['stock_qty'];
          }
          
         
          if(($input['data']['regular_price'] && is_numeric($input['data']['regular_price'])) || ($input['data']['sale_price'] && is_numeric($input['data']['sale_price'])) ){
            if(($input['data']['regular_price'] && $input['data']['sale_price']) && $input['data']['sale_price'] < $input['data']['regular_price']){
              $price = $input['data']['sale_price'];
            }
            else{
              $price = $input['data']['regular_price'];
            }
          }
          
          //role based pricing
          $is_pricing_enable = $input['data']['role_based_pricing_status'];
          
          if(isset($input['data']['role_based_pricing']) && count($input['data']['role_based_pricing']) > 0){
            foreach($input['data']['role_based_pricing'] as $role){
              $role_regular_price = $role['regular_price'];
              $role_sale_price = '';
              
              if($role_regular_price){
                $role_sale_price = $role['sale_price'];
              }
              $role_price[$role['role_name']] = array('regular_price' => $role_regular_price, 'sale_price' => $role_sale_price);
            }
          }
          
          //downloadable product
          if(is_numeric($input['data']['download_limit'])){
            $download_limit = $input['data']['download_limit'];
          } 
          
          if($input['data']['download_expiry']  >= $today ){
            $download_expiry_date = $input['data']['download_expiry'];
          }
          
          if(isset($input['data']['downloadable_data']) && count($input['data']['downloadable_data']) > 0){
            foreach($input['data']['downloadable_data'] as $data){
              $url = str_replace(url('/'), '', $data['uploaded_file_url']);
              $downloadable_data[$data['id']] = array('file_name' => $data['file_name'], 'uploaded_file_url' => $url, 'online_file_url' => $data['online_file_url']);
            }
          }
          
          
          $post_slug = '';
          $check_slug  = Post::where(['post_slug' => string_slug_format( 'New product variation' )])->orWhere('post_slug', 'like', '%' . string_slug_format( 'New product variation' ) . '%')->get()->count();

          if($check_slug === 0){
            $post_slug = string_slug_format( 'New product variation' );
          }
          elseif($check_slug > 0){
            $slug_count = $check_slug + 1;
            $post_slug = string_slug_format( 'New product variation' ). '-' . $slug_count;
          }

          if(isset($input['data']['post_type'])&& $input['data']['post_type'] == 'add_post'){
            $postObj = new Post;

            $postObj->post_author_id	          =  Session::get('shopist_admin_user_id');
            $postObj->post_content	            =  $input['data']['variation_description'];
            $postObj->post_title                =  'New product variation';
            $postObj->post_slug                 =  $post_slug;
            $postObj->parent_id                 =  $input['data']['product_id'];
            $postObj->post_status               =  $input['data']['variation_enable_status'];
            $postObj->post_type                 =  'product_variation';


            if( $postObj->save() ){
              if(PostExtra::insert(array(
                array(
                    'post_id'       =>  $postObj->id,
                    'key_name'      =>  '_variation_post_img_url',
                    'key_value'     =>  $input['data']['url'],
                    'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                    'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                ),
                array(
                    'post_id'       =>  $postObj->id,
                    'key_name'      =>  '_variation_post_sku',
                    'key_value'     =>  $input['data']['variation_sku'],
                    'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                    'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                ),
                array(
                    'post_id'       =>  $postObj->id,
                    'key_name'      =>  '_variation_post_regular_price',
                    'key_value'     =>  $regular_price,
                    'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                    'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                ),
                array(
                    'post_id'       =>  $postObj->id,
                    'key_name'      =>  '_variation_post_sale_price',
                    'key_value'     =>  $sale_price,
                    'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                    'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                ),
                array(
                    'post_id'       =>  $postObj->id,
                    'key_name'      =>  '_variation_post_price',
                    'key_value'     =>  $price,
                    'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                    'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                ),
                array(
                    'post_id'       =>  $postObj->id,
                    'key_name'      =>  '_variation_post_sale_price_start_date',
                    'key_value'     =>  $input['data']['sale_price_start_date'],
                    'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                    'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                ),
                array(
                    'post_id'       =>  $postObj->id,
                    'key_name'      =>  '_variation_post_sale_price_end_date',
                    'key_value'     =>  $input['data']['sale_price_end_date'],
                    'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                    'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                ),
                array(
                    'post_id'       =>  $postObj->id,
                    'key_name'      =>  '_variation_post_manage_stock',
                    'key_value'     =>  $input['data']['manage_stock'],
                    'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                    'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                ),
                array(
                    'post_id'       =>  $postObj->id,
                    'key_name'      =>  '_variation_post_manage_stock_qty',
                    'key_value'     =>  $stock_qty,
                    'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                    'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                ),
                array(
                    'post_id'       =>  $postObj->id,
                    'key_name'      =>  '_variation_post_back_to_order',
                    'key_value'     =>  $input['data']['back_order'],
                    'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                    'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                ),
                array(
                    'post_id'       =>  $postObj->id,
                    'key_name'      =>  '_variation_post_stock_availability',
                    'key_value'     =>  $input['data']['stock_status'],
                    'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                    'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                ),
                array(
                    'post_id'       =>  $postObj->id,
                    'key_name'      =>  '_variation_post_enable_tax',
                    'key_value'     =>  $input['data']['tax'],
                    'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                    'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                ),  
                array(
                    'post_id'       =>  $postObj->id,
                    'key_name'      =>  '_variation_post_data',
                    'key_value'     =>  $input['data']['variation_json'],
                    'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                    'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                ),
                array(
                    'post_id'       =>  $postObj->id,
                    'key_name'      =>  '_is_role_based_pricing_enable',
                    'key_value'     =>  $is_pricing_enable,
                    'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                    'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                ),
                array(
                    'post_id'       =>  $postObj->id,
                    'key_name'      =>  '_role_based_pricing',
                    'key_value'     =>  serialize($role_price),
                    'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                    'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                ),
                array(
                    'post_id'       =>  $postObj->id,
                    'key_name'      =>  '_downloadable_product_data',
                    'key_value'     =>  serialize($downloadable_data),
                    'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                    'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                ),
                array(
                    'post_id'       =>  $postObj->id,
                    'key_name'      =>  '_downloadable_limit',
                    'key_value'     =>  $download_limit,
                    'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                    'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                ),
                array(
                    'post_id'       =>  $postObj->id,
                    'key_name'      =>  '_download_expiry',
                    'key_value'     =>  $download_expiry_date,
                    'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                    'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                )
              ))){
                $status = TRUE;
              }
            }
          }
          elseif(isset($input['data']['post_type'])&& $input['data']['post_type'] == 'update_post'){
            $data = array(
                        'post_author_id'	          =>  Session::get('shopist_admin_user_id'),
                        'post_content'	            =>  $input['data']['variation_description'],
                        'parent_id'                 =>  $input['data']['product_id'],
                        'post_status'               =>  $input['data']['variation_enable_status'],
                        'post_type'                 =>  'product_variation'
            );

            if( Post::where('id', $input['data']['variation_id'])->update($data)){
              $data_url = array(
                                'key_value'    =>  $input['data']['url']
              );
              $data_sku = array(
                                'key_value'    =>  $input['data']['variation_sku']
              );
              $data_regular_price = array(
                                          'key_value'    =>  $regular_price
              );
              $data_sale_price = array(
                                        'key_value'    =>  $sale_price
              );
              $data_price = array(
                                  'key_value'    =>  $price
              );
              $data_start_date = array(
                                      'key_value'    =>  $input['data']['sale_price_start_date']
              );
              $data_end_date = array(
                                      'key_value'    =>  $input['data']['sale_price_end_date']
              );
              $data_manage_stock = array(
                                      'key_value'    =>  $input['data']['manage_stock'],
              );
              $data_stock_qty = array(
                                      'key_value'    =>  $stock_qty
              );
              $data_back_order = array(
                                      'key_value'    =>  $input['data']['back_order']
              );
              $data_stock_status = array(
                                      'key_value'    =>  $input['data']['stock_status']
              );
              $data_tax = array(
                                      'key_value'    =>  $input['data']['tax']
              );
              $data_variation_json = array(
                                      'key_value'    =>  $input['data']['variation_json']
              );
              
              $data_is_role_based_enable = array(
                                'key_value'    => $is_pricing_enable
              );
														
							$data_role_based_pricing = array(
                                'key_value'    => serialize($role_price)
              );
              
              $data_downloadable_product_data = array(
                                'key_value'    => serialize($downloadable_data)
              );
              
              $downloadable_limit = array(
                                'key_value'    => $input['data']['download_limit']
              );
              
              $downloadable_expiry = array(
                                'key_value'    => $download_expiry_date
              );

              PostExtra::where(['post_id' => $input['data']['variation_id'], 'key_name' => '_variation_post_img_url'])->update($data_url);
              PostExtra::where(['post_id' => $input['data']['variation_id'], 'key_name' => '_variation_post_sku'])->update($data_sku);
              PostExtra::where(['post_id' => $input['data']['variation_id'], 'key_name' => '_variation_post_regular_price'])->update($data_regular_price);
              PostExtra::where(['post_id' => $input['data']['variation_id'], 'key_name' => '_variation_post_sale_price'])->update($data_sale_price);
              PostExtra::where(['post_id' => $input['data']['variation_id'], 'key_name' => '_variation_post_price'])->update($data_price);
              PostExtra::where(['post_id' => $input['data']['variation_id'], 'key_name' => '_variation_post_sale_price_start_date'])->update($data_start_date);
              PostExtra::where(['post_id' => $input['data']['variation_id'], 'key_name' => '_variation_post_sale_price_end_date'])->update($data_end_date);
              PostExtra::where(['post_id' => $input['data']['variation_id'], 'key_name' => '_variation_post_manage_stock'])->update($data_manage_stock);
              PostExtra::where(['post_id' => $input['data']['variation_id'], 'key_name' => '_variation_post_manage_stock_qty'])->update($data_stock_qty);
              PostExtra::where(['post_id' => $input['data']['variation_id'], 'key_name' => '_variation_post_back_to_order'])->update($data_back_order);
              PostExtra::where(['post_id' => $input['data']['variation_id'], 'key_name' => '_variation_post_stock_availability'])->update($data_stock_status);
              PostExtra::where(['post_id' => $input['data']['variation_id'], 'key_name' => '_variation_post_enable_tax'])->update($data_tax);
              PostExtra::where(['post_id' => $input['data']['variation_id'], 'key_name' => '_variation_post_data'])->update($data_variation_json);
              PostExtra::where(['post_id' => $input['data']['variation_id'], 'key_name' => '_is_role_based_pricing_enable'])->update($data_is_role_based_enable);
							PostExtra::where(['post_id' => $input['data']['variation_id'], 'key_name' => '_role_based_pricing'])->update($data_role_based_pricing);
              PostExtra::where(['post_id' => $input['data']['variation_id'], 'key_name' => '_downloadable_product_data'])->update($data_downloadable_product_data);
              PostExtra::where(['post_id' => $input['data']['variation_id'], 'key_name' => '_downloadable_limit'])->update($downloadable_limit);
              PostExtra::where(['post_id' => $input['data']['variation_id'], 'key_name' => '_download_expiry'])->update($downloadable_expiry);

              $status = TRUE;
            }
          }

          if($status){ 
            $get_variation        =   $this->classCommonFunction->get_variation_by_product_id( $input['data']['product_id'] );
            $get_variation_data   =   $this->getVariationHTML( $input['data']['product_id'] );
            $str = '';

            if($get_variation_data){
              $str = $get_variation_data;
            }

            return response()->json(array('success' => true, 'variation_data'=> json_encode( $get_variation ), 'variation_html' => $str));
          }
        }
        else {
							return response()->json(array('error_sku_exists' => FALSE));
        }
      }
      else {
        return response()->json(array('error_no_sku_entered' => FALSE));
      }
    }
  }

  /**
   * 
   * Get function for categoris, tags, variations data
   *
   * @param null
   * @return json
   */
  public function getSpecificDetailsById(){
    $input = Request::all();
    
    if(Request::isMethod('post') && Request::ajax()){
      if(Session::token() == Request::header('X-CSRF-TOKEN')){
        if($input['data']['id'] && $input['data']['track']){
          $get_details_by_id = '';

          if($input['data']['track'] == 'cat_list'){
            $get_details_by_id =  $this->product->getTermDataById($input['data']['id']);
            $get_details_by_id = array_shift($get_details_by_id);
            
            $data = array('success' => TRUE, 'name' => $get_details_by_id['name'], 'slug' => $get_details_by_id['slug'], 'description' => $get_details_by_id['category_description'], 'parent_id' => $get_details_by_id['parent'], 'img_url' => $get_details_by_id['category_img_url'], 'status' => $get_details_by_id['status']);
          }
          elseif($input['data']['track'] == 'tag_list'){
            $get_details_by_id =  $this->product->getTermDataById($input['data']['id']);
            $get_details_by_id = array_shift($get_details_by_id);
            
            $data = array('success' => TRUE, 'name' => $get_details_by_id['name'], 'slug' => $get_details_by_id['slug'], 'description' => $get_details_by_id['tag_description'], 'status' => $get_details_by_id['status']);
          }
          elseif($input['data']['track'] == 'attr_list'){
            $get_details_by_id =  $this->product->getTermDataById($input['data']['id']);
            $get_details_by_id = array_shift($get_details_by_id);
            
            $data = array('success' => TRUE, 'attrName' => $get_details_by_id['name'], 'slug' => $get_details_by_id['slug'], 'attrVal' => $get_details_by_id['product_attr_values'], 'status' => $get_details_by_id['status']);
          }
          elseif($input['data']['track'] == 'color_list'){
            $get_details_by_id =  $this->product->getTermDataById($input['data']['id']);
            $get_details_by_id = array_shift($get_details_by_id);
            
            $data = array('success' => TRUE, 'colorName' => $get_details_by_id['name'], 'slug' => $get_details_by_id['slug'], 'colorCode' => $get_details_by_id['color_code'], 'status' => $get_details_by_id['status']);
          }
          elseif($input['data']['track'] == 'size_list'){
            $get_details_by_id =  $this->product->getTermDataById($input['data']['id']);
            $get_details_by_id = array_shift($get_details_by_id);
            
            $data = array('success' => TRUE, 'sizeName' => $get_details_by_id['name'], 'slug' => $get_details_by_id['slug'], 'status' => $get_details_by_id['status']);
          }
          elseif($input['data']['track'] == 'variation_data_list'){
            $get_details_by_id =  $this->classCommonFunction->get_variation_and_data_by_post_id( $input['data']['id'] );
            
            $get_details_by_id['_role_based_pricing'] = unserialize($get_details_by_id['_role_based_pricing']);
            $get_details_by_id['_downloadable_product_data'] = unserialize($get_details_by_id['_downloadable_product_data']);
            
            $data = array('success' => TRUE, 'edit_data' => json_encode($get_details_by_id));
          }
          
          return response()->json( $data );
        }
      }
    }
  }
  
  /**
   * 
   * Item deleted by selected id
   *
   * @param null
   * @return json
   */
  public function selectedItemDeleteById(){
    $input = Request::all();
    
    if(Request::isMethod('post') && Request::ajax() && Session::token() == Request::header('X-CSRF-TOKEN')){
      if($input['data']['id'] && $input['data']['track']){
        if($input['data']['track'] == 'cat_list' || $input['data']['track'] == 'tag_list' || $input['data']['track'] == 'attr_list' || $input['data']['track'] == 'color_list' || $input['data']['track'] == 'size_list' || $input['data']['track'] == 'manufacturers_list'){
          if(Term::where('term_id', $input['data']['id'])->delete()){
            TermExtra::where('term_id', $input['data']['id'])->delete();
            return response()->json(array('delete' => true));
          }
        }
        elseif($input['data']['track'] == 'art_cat_list'){
          if(Term::where('term_id', $input['data']['id'])->delete()){
            return response()->json(array('delete' => true));
          }
        }
        elseif($input['data']['track'] == 'art_list'){
          if(Post::where('id', $input['data']['id'])->delete()){
            PostExtra::where('post_id', $input['data']['id'])->delete();
            ObjectRelationship::where('object_id', $input['data']['id'])->delete();
            return response()->json(array('delete' => true));
          }
        }
        elseif($input['data']['track'] == 'variation_data_list'){
          $parent_id = 0;
          $str       = '';
          
          $parent_id = Post::where('id', $input['data']['id'])->first();
          
          if(Post::where('id', $input['data']['id'])->delete()){
            if(PostExtra::where('post_id', $input['data']['id'])->delete()){
              $get_variation   =   $this->classCommonFunction->get_variation_by_product_id( $parent_id->parent_id );
              $get_HTML        =   $this->getVariationHTML( $parent_id->parent_id );
              
              if($get_HTML){
                $str = $get_HTML;
              }
              
              return response()->json(array('delete' => true, 'variation_json' =>  json_encode($get_variation), 'variation_new_html' => $str));
            }
          }
        }
        elseif($input['data']['track'] == 'product_list'){
          if(Product::where('id', $input['data']['id'])->delete()){
            if(ProductExtra::where('product_id', $input['data']['id'])->delete()){
              return response()->json(array('delete' => true));
            }
          }
        }
        elseif($input['data']['track'] == 'attr_data_list' && $input['data']['item_id']){
          $postmeta_count   =  PostExtra::where(['post_id' => $input['data']['id'], 'key_name' => '_attribute_post_data'])->count();
          $postmeta         =  PostExtra::where(['post_id' => $input['data']['id'], 'key_name' => '_attribute_post_data'])->first();
          
          if($postmeta_count>0){
            $get_attr_data = json_decode( $postmeta->key_value, true );
            $get_request_item_id = $input['data']['item_id'];
            
            if(count($get_attr_data)>0){
              foreach($get_attr_data as $key => $vals){
                if($vals['id'] == $get_request_item_id){
                  unset($get_attr_data[$key]);
                }
              }
              
              $data_attr = array(
																'key_value'    => json_encode($get_attr_data)
              );

              PostExtra::where(['post_id' => $input['data']['id'], 'key_name' => '_attribute_post_data'])->update($data_attr);
              
              return response()->json( array( 'delete' => true, 'attr_new_html' => $this->getAttributeListWithHTML( $input['data']['id'] ) ));
            }
          }
        }
        elseif($input['data']['track'] == 'order_list'){
          if(Post::where('id', $input['data']['id'])->delete()){
            if(PostExtra::where('post_id', $input['data']['id'])->delete()){
              if(OrdersItem::where('order_id', $input['data']['id'])->delete()){
                return response()->json(array('delete' => true));
              }
            }
          }
        }
        elseif($input['data']['track'] == 'manage_languages'){
					$classGetFunction  =  new GetFunction();
          $destinationPath =  base_path('resources/lang/');
          $upload_folder   =  base_path('public/uploads/');
      
          $get_lang_data_by_id   =  ManageLanguage::where(['id' => $input['data']['id']])->get()->toArray();
          $get_data              =  array_shift($get_lang_data_by_id);
										  
          if(file_exists($destinationPath.$get_data['lang_code']) && is_dir($destinationPath.$get_data['lang_code'])){
            $classGetFunction->removeDirectory($destinationPath.$get_data['lang_code']);
          }
          
          if(file_exists($destinationPath.$get_data['lang_code'].'.zip')){
            unlink($destinationPath.$get_data['lang_code'].'.zip');
          }
          
          if(file_exists($upload_folder.$get_data['lang_sample_img'])){
            unlink($upload_folder.$get_data['lang_sample_img']);
          }

          if(ManageLanguage::where('id', $input['data']['id'])->delete()){
            return response()->json(array('delete' => true));
          }
        }
        elseif($input['data']['track'] == 'user_list'){
          if(User::where('id', $input['data']['id'])->delete())
          {
            if(RoleUser::where('user_id', $input['data']['id'])->delete())
            {
              $get_user_details_by_id = UsersDetail::where(['user_id' => $input['data']['id']])->get()->toArray();
              if(count($get_user_details_by_id) >0){
                UsersDetail::where('user_id', $input['data']['id'])->delete();
              }
              
              return response()->json(array('delete' => true));
            }
          }
        }
        elseif($input['data']['track'] == 'user_roles'){
          if(Role::where('id', $input['data']['id'])->delete())
          {
            if(UserRolePermission::where('role_id', $input['data']['id'])->delete())
            {
              return response()->json(array('delete' => true));
            }
          }
        }
        elseif($input['data']['track'] == 'testimonial_list'){
          if(Post::where('id', $input['data']['id'])->delete()){
            if(PostExtra::where('post_id', $input['data']['id'])->delete()){
              return response()->json(array('delete' => true));
            }
          }
        }
        elseif($input['data']['track'] == 'blog_list'){
          if(Post::where('id', $input['data']['id'])->delete()){
            if(PostExtra::where('post_id', $input['data']['id'])->delete()){
              return response()->json(array('delete' => true));
            }
          }
        }
        elseif($input['data']['track'] == 'product_comments_list' || $input['data']['track'] == 'vendor_reviews_list')
        {
          if(Comment::where('id', $input['data']['id'])->delete())
          {
            return response()->json(array('delete' => true));
          }
        }
        elseif($input['data']['track'] == 'request_product_list')
        {
          if(RequestProduct::where('id', $input['data']['id'])->delete())
          {
            return response()->json(array('delete' => true));
          }
        }
        elseif($input['data']['track'] == 'coupon_list'){
          if(Post::where('id', $input['data']['id'])->delete()){
            if(PostExtra::where('post_id', $input['data']['id'])->delete()){
              return response()->json(array('delete' => true));
            }
          }
        }
        elseif($input['data']['track'] == 'pages_list')
        {
          if(Post::where('id', $input['data']['id'])->delete())
          {
            return response()->json(array('delete' => true));
          }
        }
        elseif($input['data']['track'] == 'vendors_list'){
          if(User::where('id', $input['data']['id'])->delete()){
            if(RoleUser::where('user_id', $input['data']['id'])->delete()){
              if(UsersDetail::where('user_id', $input['data']['id'])->delete()){
                 return response()->json(array('delete' => true));
              }
            }
          }
        }
        elseif($input['data']['track'] == 'vendor_packages_list'){
          if(VendorPackage::where('id', $input['data']['id'])->delete()){
            return response()->json(array('delete' => true));
          }
        }
        elseif($input['data']['track'] == 'vendor_announcement_list'){
          if(Post::where('id', $input['data']['id'])->delete()){
            if(PostExtra::where('post_id', $input['data']['id'])->delete()){
              VendorAnnouncement::where('post_id', $input['data']['id'])->delete();
              return response()->json(array('delete' => true));
            }
          }
        }
        elseif($input['data']['track'] == 'designer_shape_list'){
          if(Post::where('id', $input['data']['id'])->delete()){
            return response()->json(array('delete' => true));
          }
        }
        elseif($input['data']['track'] == 'designer_font_list'){
          if(Post::where('id', $input['data']['id'])->delete()){
            if(PostExtra::where('post_id', $input['data']['id'])->delete()){
              return response()->json(array('delete' => true));
            }
          }
        }
      }
    }
  }
  
  /**
  * 
  * manage comments status
  *
  * @param null
  * @return json
  */
  public function selectedCommentsStatusChange(){
    $input = Request::all();
    
    if(Request::isMethod('post') && Request::ajax() && Session::token() == Request::header('X-CSRF-TOKEN')){
      if(isset($input['data']['id']) && isset($input['data']['status']) && isset($input['data']['target'])){
        $status_val  = 0;
        
        if($input['data']['status'] == 'enable'){
          $status_val = 1;
        }
        
        $update_data = array(
                            'status' => $status_val
        );

        if(Comment::where(['id' => $input['data']['id'], 'target' => $input['data']['target']])->update($update_data)){
          return response()->json(array('status_change' => true));
        }
      }
    }
  }

   /**
   * 
   * Get function for products variations
   *
   * @param null
   * @return json
   */
  public function getProductsVariationsDataById(){
    $input = Request::all();
    
    if(Request::isMethod('post') && Request::ajax() && Session::token() == Request::header('X-CSRF-TOKEN')){
      $get_data  = $this->classCommonFunction->get_variation_and_data_by_post_id( $input['id'] );
      
      $returnHTML = view('pages.ajax-pages.variation-view')->with(['variation_view_data' => $get_data, 'currency_symbol' => $this->currency_symbol])->render();
      return response()->json(array('success' => true, 'html'=> $returnHTML));
    }
  }
  
		
  /**
   * 
   * Get function for products variations
   *
   * @param products id
   * @return html
   */
  public function getVariationHTML($product_id){
    $str = '';
    $get_variation_data = $this->classCommonFunction->get_variation_and_data_by_product_id( $product_id );
    
    if(count($get_variation_data)>0){
      $str .= '<table id="variation_list" class="table table-bordered table-striped">';
      $str .= '<thead><tr><th>'. Lang::get('admin.image') .'</th><th>'. Lang::get('admin.variation_combination') .'</th><th>'. Lang::get('admin.price') .'</th><th>'. Lang::get('admin.action') .'</th></tr></thead>';
      $str .= '<tbody>';

      foreach($get_variation_data as $row){

        $str .= '<tr>';
								
        if($row['_variation_post_img_url']){
          $str .= '<td><img src="'. get_image_url($row['_variation_post_img_url']) .'" alt="'. basename ($row['_variation_post_img_url']) .'"></td>';
        }
        else {
          $str .= '<td><img src="'. default_placeholder_img_src() .'" alt="no image"></td>';
        }

        $parse_attr = json_decode($row['_variation_post_data']);
        $valStr     = '';

        foreach($parse_attr as $val){
          $valStr .= $val->attr_name .' &#8658; '. $val->attr_val . ', ';
        }
								
        $str .= '<td>'.  trim($valStr, ', ').'</td>';
        $str .= '<td>'.$this->currency_symbol.$row['_variation_post_price'].'</td>';
        $str .= '<td>';
        $str .= '<div class="btn-group">';
        $str .= '<button class="btn btn-success btn-flat" type="button">'. Lang::get('admin.action') .'</button>';    
        $str .= '<button data-toggle="dropdown" class="btn btn-success btn-flat dropdown-toggle" type="button">'; 
        $str .=  '<span class="caret"></span>';
        $str .=  '<span class="sr-only">Toggle Dropdown</span>';
        $str .=  '</button>';
        $str .=  '<ul role="menu" class="dropdown-menu">'; 
        $str .=  '<li><a href="#" class="view-data" data-track_name="variation_data_list" data-id="'. $row['id'] .'"><i class="fa fa-eye"></i>'. Lang::get('admin.view') .'</a></li>';
        $str .=  '<li><a href="#" class="edit-data" data-track_name="variation_data_list" data-id="'. $row['id'] .'"><i class="fa fa-edit"></i>'. Lang::get('admin.edit') .'</a></li>';
        $str .=  '<li><a class="remove-selected-data-from-list" data-track_name="variation_data_list" data-id="'. $row['id'] .'" href="#"><i class="fa fa-remove"></i>'. Lang::get('admin.delete') .'</a></li>';
        $str .=  '</ul>';
        $str .=  '</div>';
        $str .=  '</td>';  
        $str .= '</tr>';

      }

      $str .= '</tbody>';
      $str .= '<tfoot><tr><th>'. Lang::get('admin.image') .'</th><th>'. Lang::get('admin.variation_combination') .'</th><th>'. Lang::get('admin.price') .'</th><th>'. Lang::get('admin.action') .'</th></tr></tfoot>';
      $str .= '</table>';
    }
    
    return $str;
  }
  
  /**
   * 
   * Save attribute by product id
   *
   * @param null
   * @return html
   */
  public function addAttributeByProductId(){
    $input = Request::all();
    $str = '';
    
    if(Request::isMethod('post') && Request::ajax()){
      if(Session::token() == Request::header('X-CSRF-TOKEN')){
        $postmeta_count   =  PostExtra::where(['post_id' => $input['id'], 'key_name' => '_attribute_post_data'])->count();
        $postmeta         =  PostExtra::where(['post_id' => $input['id'], 'key_name' => '_attribute_post_data'])->first();
        $new_ary = array();
        
        if($input['action'] == 'save'){
          if($postmeta_count>0){
            $a1 = json_decode( $postmeta->key_value, true );
            $a2 = json_decode( $input['data'], true );
            
            $res = array_merge_recursive( $a1, $a2 );

            foreach (array_map('unserialize', array_unique(array_map('serialize', $res))) as $val){
                $new_ary[] = $val;
            }

            $data_attr = array(
                               'key_value'  => json_encode($new_ary)
            );

            PostExtra::where(['post_id' => $input['id'], 'key_name' => '_attribute_post_data'])->update($data_attr);
          }
          else{
            PostExtra::insert(array(
                                      'post_id'       =>  $input['id'],
                                      'key_name'      =>  '_attribute_post_data',
                                      'key_value'     =>  $input['data'],
                                      'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                      'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                    )
            );
          }
        }
        elseif($input['action'] == 'update'){
          if($postmeta_count>0){
            $get_attr_data = json_decode( $postmeta->key_value, true );
            $get_request_json_data = json_decode($input['data']);
            
            if(count($get_attr_data)>0){
              foreach($get_attr_data as $vals){
                if($vals['id'] == $get_request_json_data[0]->id){
                  $vals['attr_name'] = $get_request_json_data[0]->attr_name;
                  $vals['attr_val'] = $get_request_json_data[0]->attr_val;
                  $new_ary[] = $vals;
                }
                else{
                  $new_ary[] = $vals;
                }
              }
              
              $data_attr = array(
                                'key_value'  =>  json_encode($new_ary)
              );

              PostExtra::where(['post_id' => $input['id'], 'key_name' => '_attribute_post_data'])->update($data_attr);
            }
          }
        }
        
        $str = $this->getAttributeListWithHTML( $input['id'] );
      }
      else{
        $str = 'token_mismatch';
      }
    }
    
    return $str;
  }
  
  /**
   * 
   * Get function for attribute
   *
   * @param product id
   * @return html
   */
  public function getAttributeListWithHTML( $post_id ){
    $postmeta_count  =  PostExtra::where(['post_id' => $post_id, 'key_name' => '_attribute_post_data'])->count();
    $str = '';
    
    if($postmeta_count>0){
      $postmeta  =  PostExtra::where(['post_id' => $post_id, 'key_name' => '_attribute_post_data'])->first();
      
      $str .= '<table id="attr_list" class="table table-bordered table-striped">';
      $str .= '<thead><tr><th>'. Lang::get('admin.attribute_name') .'</th><th>'. Lang::get('admin.attribute_value') .'</th><th>'. Lang::get('admin.action') .'</th></tr></thead>';
      $str .= '<tbody>';

      foreach(json_decode($postmeta->key_value) as $row){
        $str .= '<tr>';
        $str .= '<td>'. $row->attr_name .'</td>';
        $str .= '<td>'. $row->attr_val .'</td>';
        $str .= '<td>';
        $str .= '<div class="btn-group">';
        $str .= '<button class="btn btn-success btn-flat" type="button">'. Lang::get('admin.action') .'</button>';    
        $str .= '<button data-toggle="dropdown" class="btn btn-success btn-flat dropdown-toggle" type="button">'; 
        $str .=  '<span class="caret"></span>';
        $str .=  '<span class="sr-only">Toggle Dropdown</span>';
        $str .=  '</button>';
        $str .=  '<ul role="menu" class="dropdown-menu">'; 

        $str .=  '<li><a href="#" data-toggle="modal" data-target="#edit_attributes" class="edit-attribute-data" data-track_name="attr_data_list" data-id="'. $post_id .'" data-line_variation_json="'. htmlspecialchars( json_encode( array('id' =>$row->id, 'attr_name' =>$row->attr_name, 'attr_val' =>$row->attr_val )) ) .'"><i class="fa fa-edit"></i>'. Lang::get('admin.edit') .'</a></li>';
        $str .=  '<li><a class="remove-selected-data-from-list" data-track_name="attr_data_list" data-id="'. $post_id .'" data-item_id="'. $row->id .'" href="#"><i class="fa fa-remove"></i>'. Lang::get('admin.delete') .'</a></li>';
        $str .=  '</ul>';
        $str .=  '</div>';
        $str .=  '</td>';  
        $str .= '</tr>';
      }
      $str .= '</tbody>';
      $str .= '<tfoot><tr><th>'. Lang::get('admin.attribute_name') .'</th><th>'. Lang::get('admin.attribute_value') .'</th><th>'. Lang::get('admin.action') .'</th></tr></tfoot>';
      $str .= '</table>';
    }
    else{
      $str = Lang::get('admin.no_variation_yet');
    }
    
    return $str;
  }
  
  /**
   * 
   * Get function for attribute
   *
   * @param null
   * @return json
   */
  public function getAvailableAttributesWithHtml(){
    if(Request::isMethod('post') && Request::ajax()){
      if(Session::token() == Request::header('X-CSRF-TOKEN')){
        $input = Request::all();
        $str = '';
        $get_attr_from_global = array();
								
        $get_global_attribute  =   $this->product->getTermData( 'product_attr', false, null, 1 );
        $get_attr_by_products  =   PostExtra::where(['post_id' => $input['post_id'], 'key_name' => '_attribute_post_data'])->get();
								
        if(count($get_global_attribute) > 0){
          foreach($get_global_attribute as $term){
              $ary = array();
              $ary['attr_id']     = $term['term_id'];
              $ary['attr_name']   = $term['name'];
              $ary['attr_values'] = $term['product_attr_values'];
              $ary['attr_status'] = $term['status'];
              $ary['created_at']  = $term['created_at'];
              $ary['updated_at']  = $term['updated_at'];

              array_push($get_attr_from_global, (object) $ary);
          }
          
          $str .= $this->get_attribute_html( $get_attr_from_global );
        }
        
        if($get_attr_by_products->count()>0){
          $str .= $this->get_attribute_html( json_decode( $get_attr_by_products[0]->key_value ) );
        }
        
        return response()->json(array('success' => true, 'html'=> $str));
      }
    }
  }
  
  /**
   * 
   * Get function for attribute
   *
   * @param array data
   * @return html
   */
  public function get_attribute_html( $data ){
    $str = '';
				
    if(count($data)){
      foreach($data as $rows){
        $str .= '<div class="attribute-name">';
        $str .= '<select class="form-control select2 variation-attr-list" style="width: 100%;" data-attr_name="'. $rows->attr_name .'">';
        $str .= '<option selected="selected" value="all">'. trans('admin.any_label') .' '. $rows->attr_name .'</option>';
        
        if(isset($rows->attr_values)){
          foreach(explode(',', $rows->attr_values) as $val){
            $str .= "<option value='". trim($val) ."'>". trim($val) ."</option>";
          }
        }
        elseif(isset($rows->attr_val)){
          foreach(explode(',', $rows->attr_val) as $val){
            $str .= "<option value='". trim($val) ."'>". trim($val) ."</option>";
          } 
        }
        $str .= '</select>';
        $str .= '</select>';
        $str .= '</div>';
      }
    }
    
    return $str;
  }
  
  /**
   * 
   * Manage and save appearance data
   *
   * @param null
   * @return json
   */
  public function appearanceDataSave(){
    if(Request::isMethod('post') && Session::token() == Request::header('X-CSRF-TOKEN')){
      $input = Request::all();
      $unserialize_appearance_data  =   $this->option->getAppearanceData();
      
      if(isset($unserialize_appearance_data[$input['tab_name']])){
        $unserialize_appearance_data[$input['tab_name']] = $input['template_name'];
      }
      
      $data = array(
                      'option_value'  => serialize($unserialize_appearance_data)
      );
      
      if( Option::where('option_name', '_appearance_tab_data')->update($data)){
        if(!Session::has('appearance_active_tab_name')){
          Session::put('appearance_active_tab_name', $input['tab_name']);
        }
        return response()->json(array('status' => 'success'));
      }
    }
  }
  
  /**
   * 
   * Manage frontend images upload
   *
   * @param null
   * @return json
   */
  public function uploadFrontendImages(){
    if(Request::isMethod('post') && Request::ajax()){
      if(Session::token() == Request::header('X-CSRF-TOKEN')){
        $input = Input::all();
        $files = array();
        
        $count = 0;
        foreach($input['frontend_all_images'] as $key => $value ){
          $rules = array(
                 $key => 'image',
          );

          $validation = Validator::make($input['frontend_all_images'], $rules);

          if ($validation->fails()) {
            return Response::make($validation->errors->first(), 400);
          }
          else{
            $image = $value;
            $width    = 0;
            $height   = 0;
        
            $fileName = $count.time()."w-1920-h-800-".$image->getClientOriginalName();
            $path  = public_path('uploads/' . $fileName);
            
            $width = 1920;
            $height = 800;
            
            $img   = Image::make($image);
            
            if($width > 0 && $height > 0){
              $img->resize($width, $height);
            }
            else{
              $img->resize(null, $height, function ($constraint) {
                  $constraint->aspectRatio();
              });
            }
        
            if ($img->save($path)) {
              $files[] = $fileName;
            }
          }
          
          $count ++;
        }
        
        if (count($files) > 0) {
            return response()->json(array('status' => 'success', 'name' => json_encode($files)));
        } else {
            return Response::json('error', 400);
        }
      }  
    }
  }
		
  public function manageImportProductFile(){
    if(Request::isMethod('post') && Request::ajax() && Session::token() == Request::header('X-CSRF-TOKEN')){
        $file = Input::file('csvFileImport')->getClientOriginalName();
        $extension = pathinfo($file, PATHINFO_EXTENSION);
        
        if($extension == 'csv'){
          $header_array = array('Title', 'Description(HTML)', 'Regular Price', 'SKU', 'Features(HTML)', 'Recommended Product', 'Features Product', 'Latest Product', 'Related Product', 'Home Page Product', 'Visibility', 'Enable Reviews', 'Enable Review Product Page', 'Enable Review Details Page', 'SEO Title', 'SEO Description', 'SEO Keywords(Comma Separator)');
          
          $parse_data = array();
          $csvFile = fopen(Input::file('csvFileImport'), 'r');
          $header = fgetcsv($csvFile);
          
          $count = 0;
          if(serialize($header_array) == serialize($header)){
            //fseek( $csvFile, 2);
            while ( ( $line = fgetcsv( $csvFile, 0, ',' ) ) !== FALSE ) {
              $row = array();
              $row['title'] = $line[0];
              $row['description'] = $line[1];
              $row['regular_price'] = $line[2];
              $row['sku'] = $line[3];
              $row['features'] = $line[4];
              $row['recommended_product'] = $line[5];
              $row['features_product'] = $line[6];
              $row['latest_product'] = $line[7];
              $row['related_product'] = $line[8];
              $row['home_page_product'] = $line[9];
              $row['visibility'] = $line[10];
              $row['enable_reviews'] = $line[11];
              $row['enable_review_product_page'] = $line[12];
              $row['enable_review_details_page'] = $line[13];
              $row['seo_title'] = $line[14];
              $row['seo_description'] = $line[15];  
              $row['seo_keywords'] = $line[16];
              
              array_push($parse_data, $row);
              
              $count ++;
            }
            fclose($csvFile);
            
            if(is_vendor_login() && Session::has('shopist_admin_user_id')){
              $selected_package_details = get_package_details_by_vendor_id( Session::get('shopist_admin_user_id') );
              $get_total_product = Product::where(['author_id' => Session::get('shopist_admin_user_id')])->first()->count() + 1;

              if($get_total_product > $selected_package_details->max_number_product){
                return response()->json(array('status' => 'notice', 'type' => 'exceed_product'));
              }
            }
            
            if(is_array($parse_data) && count($parse_data) > 0){
              if( 100 >= count($parse_data)){
                foreach($parse_data as $row){
                  $is_visibility = 0;
                  $enable_recommended = 'no';
                  $enable_features = 'no';
                  $enable_latest = 'no';
                  $enable_related = 'no';
                  $home_page_product = 'no';
                  $enable_review = 'no';
                  $enable_p_page = 'no';
                  $enable_d_page = 'no';
                  $sku = '';
                  $regular_price = '';
                  $extra_features = '';
                  $title = 'Sample Product';
                  $content = '';
                  $seo_title = '';
                  $seo_description = '';
                  $seo_keywords = '';

                  if(isset($row['title']) && !empty($row['title'])){
                    $title = $row['title'];
                  }

                  if(isset($row['description']) && !empty($row['description'])){
                    $content = string_encode($row['description']);
                  }

                  if(isset($row['regular_price']) && !empty($row['regular_price'])){
                    $regular_price = $row['regular_price'];
                  }

                  if(isset($row['sku']) && !empty($row['sku'])){
                    $sku = $row['sku'];
                  }

                  if(isset($row['features']) && !empty($row['features'])){
                    $extra_features = string_encode($row['features']);
                  }

                  if(isset($row['recommended_product']) && !empty($row['recommended_product']) && $row['recommended_product'] == 'TRUE'){
                    $enable_recommended = 'yes';
                  }
                  
                  if(isset($row['features_product']) && !empty($row['features_product']) && $row['features_product'] == 'TRUE'){
                    $enable_features = 'yes';
                  }

                  if(isset($row['latest_product']) && !empty($row['latest_product']) && $row['latest_product'] == 'TRUE'){
                    $enable_latest = 'yes';
                  }

                  if(isset($row['related_product']) && !empty($row['related_product']) && $row['related_product'] == 'TRUE'){
                    $enable_related = 'yes';
                  }

                  if(isset($row['home_page_product']) && !empty($row['home_page_product']) && $row['home_page_product'] == 'TRUE'){
                    $home_page_product = 'yes';
                  }

                  if(isset($row['visibility']) && !empty($row['visibility']) && $row['visibility'] == 'TRUE'){
                    $is_visibility = 1;
                  }

                  if(isset($row['enable_reviews']) && !empty($row['enable_reviews']) && $row['enable_reviews'] == 'TRUE'){
                    $enable_review = 'yes';
                  }

                  if(isset($row['enable_review_product_page']) && !empty($row['enable_review_product_page']) && $row['enable_review_product_page'] == 'TRUE'){
                    $enable_p_page = 'yes';
                  }

                  if(isset($row['enable_review_details_page']) && !empty($row['enable_review_details_page']) && $row['enable_review_details_page'] == 'TRUE'){
                    $enable_d_page = 'yes';
                  }

                  if(isset($row['seo_title']) && !empty($row['seo_title'])){
                    $seo_title = $row['seo_title'];
                  }
                  else{
                    $seo_title = $title;
                  }

                  if(isset($row['seo_description']) && !empty($row['seo_description'])){
                    $seo_description = $row['seo_description'];
                  }

                  if(isset($row['seo_keywords']) && !empty($row['seo_keywords'])){
                    $seo_keywords = $row['seo_keywords'];
                  }
                  
                  //slug
                  $post_slug   =  '';
                  $check_slug  =  Product::where(['slug' => string_slug_format( $title )])->orWhere('slug', 'like', '%' . string_slug_format( $title ) . '%')->get()->count();

                  if($check_slug === 0){
                    $post_slug = string_slug_format( $title );
                  }
                  elseif($check_slug > 0){
                    $slug_count = $check_slug + 1;
                    $post_slug = string_slug_format( $title ). '-' . $slug_count;
                  }

                  //role based pricing
                  $role_price = array();
                  $available_user_roles = get_available_user_roles();

                  if(count($available_user_roles) > 0 ){
                    foreach($available_user_roles as $roles){
                      $role_price[$roles['role_name']] = array('regular_price' => '', 'sale_price' => '');
                    }
                  }

                  $post_id = DB::table('products')->insertGetId(['author_id' => Session::get('shopist_admin_user_id'), 'content' => $content, 'title' => $title, 'slug' => $post_slug, 'status' => $is_visibility, 'sku' => $sku, 'regular_price' => $regular_price, 'sale_price' => '', 'price' => $regular_price, 'stock_qty' => 0, 'stock_availability' => 'in_stock', 'type' => 'simple_product', 'image_url' => '', 'created_at' => date("y-m-d H:i:s", strtotime('now')), 'updated_at' => date("y-m-d H:i:s", strtotime('now'))]);

                    ProductExtra::insert(array(
                                            array(
                                                'product_id'    =>  $post_id,
                                                'key_name'      =>  '_product_related_images_url',
                                                'key_value'     =>  '{"product_image":"","product_gallery_images":[],"shop_banner_image":""}',
                                                'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                                'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                            ),
                                            array(
                                                'product_id'    =>  $post_id,
                                                'key_name'      =>  '_product_sale_price_start_date',
                                                'key_value'     =>  '',
                                                'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                                'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                            ),
                                            array(
                                                'product_id'    =>  $post_id,
                                                'key_name'      =>  '_product_sale_price_end_date',
                                                'key_value'     =>  '',
                                                'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                                'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                            ),
                                            array(
                                                'product_id'    =>  $post_id,
                                                'key_name'      =>  '_product_manage_stock',
                                                'key_value'     =>  'no',
                                                'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                                'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                            ),
                                            array(
                                                'product_id'    =>  $post_id,
                                                'key_name'      =>  '_product_manage_stock_back_to_order',
                                                'key_value'     =>  'not_allow',
                                                'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                                'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                            ),
                                            array(
                                                'product_id'    =>  $post_id,
                                                'key_name'      =>  '_product_extra_features',
                                                'key_value'     =>  $extra_features,
                                                'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                                'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                            ),
                                            array(
                                                'product_id'    =>  $post_id,
                                                'key_name'      =>  '_product_enable_as_recommended',
                                                'key_value'     =>  $enable_recommended,
                                                'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                                'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                            ),
                                            array(
                                                'product_id'    =>  $post_id,
                                                'key_name'      =>  '_product_enable_as_features',
                                                'key_value'     =>  $enable_features,
                                                'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                                'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                            ),
                                            array(
                                                'product_id'    =>  $post_id,
                                                'key_name'      =>  '_product_enable_as_latest',
                                                'key_value'     =>  $enable_latest,
                                                'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                                'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                            ),
                                            array(
                                                'product_id'    =>  $post_id,
                                                'key_name'      =>  '_product_enable_as_related',
                                                'key_value'     =>  $enable_related,
                                                'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                                'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                            ),
                                            array(
                                                'product_id'    =>  $post_id,
                                                'key_name'      =>  '_product_enable_as_custom_design',
                                                'key_value'     =>  'yes',
                                                'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                                'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                            ),
                                            array(
                                                'product_id'    =>  $post_id,
                                                'key_name'      =>  '_product_enable_as_selected_cat',
                                                'key_value'     =>  $home_page_product,
                                                'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                                'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                            ),
                                            array(
                                                'product_id'    =>  $post_id,
                                                'key_name'      =>  '_product_enable_taxes',
                                                'key_value'     =>  'no',
                                                'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                                'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                            ),
                                            array(
                                                'product_id'    =>  $post_id,
                                                'key_name'      =>  '_product_custom_designer_settings',
                                                'key_value'     =>  'a:3:{s:16:"canvas_dimension";a:3:{s:13:"small_devices";a:2:{s:5:"width";i:280;s:6:"height";i:300;}s:14:"medium_devices";a:2:{s:5:"width";i:480;s:6:"height";i:480;}s:13:"large_devices";a:2:{s:5:"width";i:500;s:6:"height";i:550;}}s:25:"enable_layout_at_frontend";s:2:"no";s:22:"enable_global_settings";s:2:"no";}',
                                                'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                                'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                            ),
                                            array(
                                                'product_id'    =>  $post_id,
                                                'key_name'      =>  '_product_custom_designer_data',
                                                'key_value'     =>  '',
                                                'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                                'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                            ),
                                            array(
                                                'product_id'    =>  $post_id,
                                                'key_name'      =>  '_product_enable_reviews',
                                                'key_value'     =>  $enable_review,
                                                'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                                'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                            ),
                                            array(
                                                'product_id'    =>  $post_id,
                                                'key_name'      =>  '_product_enable_reviews_add_link_to_product_page',
                                                'key_value'     =>  $enable_p_page,
                                                'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                                'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                            ),
                                            array(
                                                'product_id'    =>  $post_id,
                                                'key_name'      =>  '_product_enable_reviews_add_link_to_details_page',
                                                'key_value'     =>  $enable_d_page,
                                                'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                                'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                            ),
                                            array(
                                                'product_id'    =>  $post_id,
                                                'key_name'      =>  '_product_enable_video_feature',
                                                'key_value'     =>  'no',
                                                'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                                'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                            ),
                                            array(
                                                'product_id'    =>  $post_id,
                                                'key_name'      =>  '_product_video_feature_display_mode',
                                                'key_value'     =>  'content',
                                                'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                                'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                            ),
                                            array(
                                                'product_id'    =>  $post_id,
                                                'key_name'      =>  '_product_video_feature_title',
                                                'key_value'     =>  '',
                                                'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                                'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                            ),
                                            array(
                                                'product_id'    =>  $post_id,
                                                'key_name'      =>  '_product_video_feature_panel_size',
                                                'key_value'     =>  serialize(array('width' => '', 'height' => '')),
                                                'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                                'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                            ),
                                            array(
                                                'product_id'    =>  $post_id,
                                                'key_name'      =>  '_product_video_feature_source',
                                                'key_value'     =>  '',
                                                'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                                'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                            ),
                                            array(
                                                'product_id'    =>  $post_id,
                                                'key_name'      =>  '_product_video_feature_source_embedded_code',
                                                'key_value'     =>  '',
                                                'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                                'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                            ),
                                            array(
                                                'product_id'    =>  $post_id,
                                                'key_name'      =>  '_product_video_feature_source_online_url',
                                                'key_value'     =>  '',
                                                'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                                'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                            ),
                                            array(
                                                'product_id'    =>  $post_id,
                                                'meta_key'      =>  '_product_enable_manufacturer',
                                                'meta_value'    =>  'no',
                                                'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                                'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                            ),
                                            array(
                                                'product_id'    =>  $post_id,
                                                'key_name'      =>  '_product_enable_visibility_schedule',
                                                'key_value'     =>  'no',
                                                'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                                'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                            ),
                                            array(
                                                'product_id'    =>  $post_id,
                                                'key_name'      =>  '_product_seo_title',
                                                'key_value'     =>  $seo_title,
                                                'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                                'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                            ),
                                            array(
                                                'product_id'    =>  $post_id,
                                                'key_name'      =>  '_product_seo_description',
                                                'key_value'     =>  $seo_description,
                                                'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                                'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                            ),
                                            array(
                                                'product_id'    =>  $post_id,
                                                'key_name'      =>  '_product_seo_keywords',
                                                'key_value'     =>  $seo_keywords,
                                                'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                                'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                            ),
                                            array(
                                                'product_id'    =>  $post_id,
                                                'key_name'      =>  '_product_compare_data',
                                                'key_value'     =>  '',
                                                'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                                'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                            ),
                                            array(
                                                'product_id'    =>  $post_id,
                                                'key_name'      =>  '_is_role_based_pricing_enable',
                                                'key_value'     =>  'no',
                                                'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                                'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                            ),
                                            array(
                                                'product_id'    =>  $post_id,
                                                'key_name'      =>  '_role_based_pricing',
                                                'key_value'     =>  serialize($role_price),
                                                'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                                'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                            ),
                                            array(
                                                'product_id'    =>  $post_id,
                                                'key_name'      =>  '_downloadable_product_files',
                                                'key_value'     =>  'a:0:{}',
                                                'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                                'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                            ),
                                            array(
                                                'product_id'    =>  $post_id,
                                                'key_name'      =>  '_downloadable_product_download_limit',
                                                'key_value'     =>  '',
                                                'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                                'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                            ),
                                            array(
                                                'product_id'    =>  $post_id,
                                                'key_name'      =>  '_downloadable_product_download_expiry',
                                                'key_value'     =>  '',
                                                'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                                'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                            )
                  ));
                }
                
                return response()->json(array('status' => 'success', 'type' => 'saved'));
              }
              else{
                return response()->json(array('status' => 'error', 'type' => 'not_more_hundred'));
              }
            }  
          }
          else{
            fclose($csvFile);
            return response()->json(array('status' => 'error', 'type' => 'header_format_mismatch'));
          }
        }
        else{
          return response()->json(array('status' => 'error', 'type' => 'wrong_extension'));
        }
      }   
  }
  
  /**
   * 
   *Upload downloadable files
   *
   * @param null
   * @return json
   */
  public function uploadDownloadableFiles(){
    if(Request::isMethod('post') && Request::ajax() && Session::token() == Request::header('X-CSRF-TOKEN')){
      try {
        $input = Input::all();
        $file = null;
        
        if(isset($input['simple_product']) && $input['simple_product'] == 'simple_product'){
          $file = Input::file('uploadDownloadableProductFile');
        }
        elseif(isset($input['variable_product']) && $input['variable_product'] == 'variable_product'){
          $file = Input::file('uploadDownloadableVariableProductFile');
        }
        
        
        $fileName = time().uniqid()."-". $file->getClientOriginalName();
        $destinationPath  = public_path('uploads/');
        
        $file->move($destinationPath, $fileName);

        if($file->getError() == 0){
          return response()->json(array('status' => 'success', 'filename' => $fileName));
        }
        else{
          return response()->json(array('status' => 'error'));
        }
        

      } catch (Exception $ex) {
        return response()->json(array('status' => 'error'));
      }
    }
  }   
  
  /**
   * 
   *Upload variable products downloadable files
   *
   * @param null
   * @return json
   */
  public function uploadVariableProductDownloadableFiles(){
    if(Request::isMethod('post') && Request::ajax() && Session::token() == Request::header('X-CSRF-TOKEN')){
      try {
        $file = Input::file('variableProductFileUpload');
        
        $fileName = time().uniqid()."-". $file->getClientOriginalName();
        $destinationPath  = public_path('uploads/');
        
        $file->move($destinationPath, $fileName);

        if($file->getError() == 0){
          return response()->json(array('status' => 'success', 'filename' => $fileName));
        }
        else{
          return response()->json(array('status' => 'error'));
        }
        

      } catch (Exception $ex) {
        return response()->json(array('status' => 'error'));
      }
    }
  }
		
	public function getProductsForLinkedType(){
    if(Session::token() == Request::header('X-CSRF-TOKEN')){
      $input = Request::all();
      $query = $input['query'];
      $json = [];

      $get_products = DB::table('products')
                      ->where(['status' => 1])
                      ->where('title', 'LIKE', '%'. $query .'%')
                      ->get()
                      ->toArray();

      if(count($get_products) > 0){
        foreach($get_products as $products){
          if(isset($input['product_id']) && $input['product_id'] != $products->id){
            $data['id']   = $products->id;
            $data['name'] = $products->title;
            array_push($json, $data);
          }
        }
      }

      return json_encode($json);
    }  
  }
  
  public function getAllVendor(){
    if(Session::token() == Request::header('X-CSRF-TOKEN')){
      $input = Request::all();
      $query = $input['query'];
      $json = [];
      
      $get_role_details = get_roles_details_by_role_slug('vendor');
      $get_vendors =  DB::table('users')
                      ->where(['role_user.role_id' => $get_role_details->id])
                      ->where('users.name', 'LIKE', '%'. $query .'%')
                      ->join('role_user', 'role_user.user_id', '=', 'users.id')
                      ->get()
                      ->toArray();

      if(count($get_vendors) > 0){
        foreach($get_vendors as $vendor){
          $data['id']   = $vendor->id;
          $data['name'] = $vendor->name;
          array_push($json, $data);
        }
      }

      return json_encode($json);
    }  
  }
  
  /**
   * 
   * Get vendor profile details by id
   *
   * @param null
   * @return response
   */
  public function getVendorProfileById(){
    if(Request::isMethod('post') && Request::ajax() && Session::token() == Request::header('X-CSRF-TOKEN')){
      $input = Request::all();
      $user_data = array();
      $get_user_details = get_user_details( $input['id'] );
      $get_user_extra   = get_user_account_details_by_user_id( $input['id'] );
      
      $user_data = $get_user_details;
      $user_data['details'] = (array) json_decode(array_shift($get_user_extra)['details']);
      
      $returnHTML = view('pages.admin.vendors.vendor-profile')->with( $user_data )->render();
      return response()->json(array('status' => 'success', 'type' => 'vendor_profile', 'html'=> $returnHTML));
    }  
  }
  
  /**
   * 
   * Vendor status change
   *
   * @param null
   * @return response
   */
  public function vendorStatusChange(){
    if(Request::isMethod('post') && Request::ajax() && Session::token() == Request::header('X-CSRF-TOKEN')){
      $input = Request::all();
      $email_options = get_emails_option_data();
      
      $data = array(
                    'user_status'  => $input['status']   
      );
      
       if(User::where('id', $input['id'])->update($data)){
        if($email_options['vendor_account_activation']['enable_disable'] == true && $this->env === 'production'){
          $classGetFunction  =  new GetFunction();
          $get_vendor = User::where(['id' => $input['id']])->first();
          
          $classGetFunction->sendCustomMail( array('source' => 'vendor_account_activation', 'email' => $get_vendor->email, 'status' => $input['status']) );
        } 
        
        return response()->json(array('status' => 'success', 'type' => 'vendor_status_updated'));
       }
    }
  }
  
  /**
   * 
   * Get vendor system categories
   *
   * @param null
   * @return json string
   */
  public function getParentCatForVendor(){
    if(Session::token() == Request::header('X-CSRF-TOKEN')){
      $input = Request::all();
      $query = $input['query'];
      $json = [];
      
      $parent_categories = array();
      $get_categories_data  = Term::where(['type' => 'product_cat', 'parent' => 0, 'status' => 1])
                              ->where('name', 'LIKE', '%'. $query .'%')
                              ->get()
                              ->toArray();

      if(count($get_categories_data) > 0){
        $parent_categories = $get_categories_data;
      }
      
      if(count($parent_categories) > 0){
        foreach($parent_categories as $cat){
          $data['id']   = $cat['term_id'];
          $data['name'] = $cat['name'];
          array_push($json, $data);
        }
      }

      return json_encode($json);
    }
  }
  
  /**
   * 
   * Get vendor withdraw requested data by id
   *
   * @param null
   * @return response
   */
  public function getVendorWithdrawRequestedDataById(){
    if(Request::isMethod('post') && Request::ajax() && Session::token() == Request::header('X-CSRF-TOKEN')){
      $input = Request::all();
      $user_data = array();
      $get_requested_withdraw = VendorWithdraw::where(['id' => $input['id']])->first();
      
      if(!empty($get_requested_withdraw)){
        $user_data['withdraw_details'] = $get_requested_withdraw;
        $user_data['payment_details'] = get_payment_details_by_vendor_id($get_requested_withdraw->user_id);
        
        $returnHTML = view('pages.ajax-pages.vendor-withdraw-requested-details')->with( $user_data )->render();
        return response()->json(array('status' => 'success', 'type' => 'vendor_withdraw_request_data', 'html'=> $returnHTML));
      }
    }  
  }
  
  /**
   * 
   * Requested withdraw status change
   *
   * @param null
   * @return response
   */
  public function requestedWithdrawStatusChange(){
    if(Request::isMethod('post') && Request::ajax() && Session::token() == Request::header('X-CSRF-TOKEN')){
      $classGetFunction  =  new GetFunction();
      $input = Request::all(); 
      $get_requested_withdraw = VendorWithdraw::where(['id' => $input['id']])->first();
     
      if(!empty($get_requested_withdraw)){
        $email_options = get_emails_option_data();
        $user_details  = get_user_details( $get_requested_withdraw->user_id ); 
        
        if($input['target'] == 'completed'){
          $data_for_vendorwithdraw = array('status' => 'COMPLETED', 'updated_at' => date("y-m-d H:i:s", strtotime('now')));

          if(VendorWithdraw::where('id', $input['id'])->update( $data_for_vendorwithdraw )){
            if($get_requested_withdraw->payment_type == 'single_payment_with_all_earnings'){
              $data_for_vendortotals = array('totals' => 0, 'updated_at' => date("y-m-d H:i:s", strtotime('now')));
              VendorTotal::where('vendor_id', $get_requested_withdraw->user_id)->update( $data_for_vendortotals );
            }
            elseif($get_requested_withdraw->payment_type == 'single_payment_with_custom_values'){
              $get_totals = VendorTotal::where(['vendor_id' => $get_requested_withdraw->user_id])->first();
              $data_for_vendortotals = array('totals' => $get_totals->totals - $get_requested_withdraw->custom_amount, 'updated_at' => date("y-m-d H:i:s", strtotime('now')));
              VendorTotal::where('vendor_id', $get_requested_withdraw->user_id)->update( $data_for_vendortotals );
            }
            
            $data_for_vendororder = array('order_status' => 'COMPLETED', 'updated_at' => date("y-m-d H:i:s", strtotime('now')));
            VendorOrder::where(['vendor_id' => $get_requested_withdraw->user_id, 'order_status' => 'ON-HOLD'])->update( $data_for_vendororder );
          }
          
          if($email_options['vendor_withdraw_request_completed']['enable_disable'] == true && $this->env === 'production'){
            $classGetFunction->sendCustomMail( array('source' => 'vendor_withdraw_request_completed', 'email' => $user_details['user_email']) );
          }
        }
        elseif($input['target'] == 'cancelled'){
          $data_for_vendorwithdraw = array('status' => 'CANCELLED', 'updated_at' => date("y-m-d H:i:s", strtotime('now')));
          VendorWithdraw::where('id', $input['id'])->update( $data_for_vendorwithdraw );
          
          $data_for_vendororder = array('order_status' => 'CANCELLED', 'updated_at' => date("y-m-d H:i:s", strtotime('now')));
          VendorOrder::where(['vendor_id' => $get_requested_withdraw->user_id, 'order_status' => 'ON-HOLD'])->update( $data_for_vendororder );
          
          if($email_options['vendor_withdraw_request_cancelled']['enable_disable'] == true && $this->env === 'production'){
            $classGetFunction->sendCustomMail( array('source' => 'vendor_withdraw_request_cancelled', 'email' => $user_details['user_email']) );
          }
        }
        
        return response()->json(array('status' => 'success', 'type' => 'vendor_status_updated'));
      }
    }
  }
}

 
    