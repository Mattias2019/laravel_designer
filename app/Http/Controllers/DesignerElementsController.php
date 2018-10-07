<?php
namespace shopist\Http\Controllers;

use shopist\Http\Controllers\Controller;
use Request;
use Session;
use Validator;
use Illuminate\Support\Facades\Input;
use shopist\Models\Term;
use shopist\Models\Post;
use shopist\Models\PostExtra;
use shopist\Models\Option;
use shopist\Models\ObjectRelationship;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use shopist\Http\Controllers\ProductsController;
use shopist\Library\CommonFunction;
use shopist\Http\Controllers\OptionController;


class DesignerElementsController extends Controller
{
  public $product;
  public $option;
  public $classCommonFunction;
  
   public function __construct(){
    $this->option  =  new OptionController();
		$this->product  =  new ProductsController();
    $this->classCommonFunction  =  new CommonFunction();
	}	
  
  /**
   * 
   * Designer clipart categories list content
   *
   * @param null
   * @return response view
   */
  public function designerArtCatListContent(){
    $data = array();
    $search_value = '';
    
    if(isset($_GET['term_art_cat']) && $_GET['term_art_cat'] != ''){
      $search_value = $_GET['term_art_cat'];
    }
    
    $data = $this->classCommonFunction->commonDataForAllPages();
    $data['art_cat_lists_data'] = $this->product->getTermData( 'designer_cat', true, $search_value, -1 );
    $data['search_value']       = $search_value;
     
    return view('pages.admin.custom-designer.art-categories-list', $data);
  }
  
  /**
   * 
   * Designer clipart categories add content
   *
   * @param null
   * @return response view
   */
  public function designerArtCatAddContent(){
    $data = array();
    
    $data = $this->classCommonFunction->commonDataForAllPages();
    
    return view('pages.admin.custom-designer.add-art-category-content', $data);
  }
  
  /**
   * 
   * Designer clipart categories update content
   *
   * @param null
   * @return response view
   */
  public function designerArtCatUpdateContent( $params ){
    $getArtCatData = Term :: where('slug', $params)->first();
      
    if(!empty($getArtCatData)){
      $data = array();
      
      $data = $this->classCommonFunction->commonDataForAllPages();
      $get_details_by_id =  $this->product->getTermDataById( $getArtCatData->term_id );
      $data['art_cat_update_data_by_id']  =  array_shift($get_details_by_id);
      
       return view('pages.admin.custom-designer.update-art-category-content', $data);
    }
    else{
      return view('errors.no_data');
    }
  }
  
  /**
   * 
   * Designer clipart list content
   *
   * @param null
   * @return response view
   */
  public function designerClipartListContent(){
    $data = array();
    $search_value = '';
    
    if(isset($_GET['term_art_cat']) && $_GET['term_art_cat'] != ''){
      $search_value = $_GET['term_art_cat'];
    }
    
    $data = $this->classCommonFunction->commonDataForAllPages();
    $data['art_lists']     =   $this->getArtListData(true, $search_value, -1);
    $data['search_value']  =   $search_value;
     
    return view('pages.admin.custom-designer.clipart-list', $data);
  }
  
  /**
   * 
   * Designer clipart add content
   *
   * @param null
   * @return response view
   */
  public function designerClipartAddContent(){
    $data = array();
    
    $data = $this->classCommonFunction->commonDataForAllPages();
    $data['getArtCatByFilter']  =  $this->product->getTermData( 'designer_cat', false, null, 1 );
    
    return view('pages.admin.custom-designer.add-new-art-content', $data);
  }
  
  /**
   * 
   * Designer clipart update content
   *
   * @param null
   * @return response view
   */
  public function designerClipartUpdateContent( $params ){
    $data = array();
    
    $data = $this->classCommonFunction->commonDataForAllPages();
    $data['art_update_data_by_id']  =  $this->getDesignerArtDataBySlug( $params );
       
    if(count($data['art_update_data_by_id']) > 0){
     $data['art_update_img_json']  =  '[{"id":"'.$data['art_update_data_by_id']['id'] .'","url":"'. $data['art_update_data_by_id']['art_img_url'] .'"}]';
     $data['getArtCatByFilter']    =  $this->product->getTermData( 'designer_cat', false, null, 1 );
     
     return view('pages.admin.custom-designer.update-art-content', $data);
    }
    else{
      return view('errors.no_data');
    }
  }
  
  /**
   * 
   * Designer shape list content
   *
   * @param null
   * @return response view
   */
  public function designerShapeListContent(){
    $search_value = '';
    $data = array();
    
    if(isset($_GET['term_shape']) && $_GET['term_shape'] != ''){
      $search_value = $_GET['term_shape'];
    }
    
    $data = $this->classCommonFunction->commonDataForAllPages();
    $data['designer_shape_list'] = $this->product->getShapeList(true, $search_value, -1);
    $data['search_value'] =   $search_value;
    
    return view('pages.admin.custom-designer.shape-list', $data);
  }
  
  /**
   * 
   * Designer shape add content
   *
   * @param null
   * @return response view
   */
  public function designerShapeAddContent(){
    $data = array();
    
    $data = $this->classCommonFunction->commonDataForAllPages();
    return view('pages.admin.custom-designer.add-shape-content', $data);
  }
  
  /**
   * 
   * Designer shape update content
   *
   * @param null
   * @return response view
   */
  public function designerShapeUpdateContent( $params ){
    $data = array();
    $get_post  =  Post :: where('post_slug', $params)->first();
    
    if(!empty($get_post)){
      $data = $this->classCommonFunction->commonDataForAllPages();
      $data['designer_shape_data'] = $get_post;
      
      return view('pages.admin.custom-designer.update-shape-content', $data);
    }
    else{
      return view('errors.no_data');
    }
  }
  
  /**
   * 
   * Designer font list content
   *
   * @param null
   * @return response view
   */
  public function designerFontListContent(){
    $search_value = '';
    $data = array();
    
    if(isset($_GET['term_font']) && $_GET['term_font'] != ''){
      $search_value = $_GET['term_font'];
    }
    
    $data = $this->classCommonFunction->commonDataForAllPages();
    $data['designer_font_list'] = $this->product->getFontsList(true, $search_value, -1);
    $data['search_value'] =   $search_value;
    
    return view('pages.admin.custom-designer.font-list', $data);
  }
  
  /**
   * 
   * Designer font add content
   *
   * @param null
   * @return response view
   */
  public function designerFontAddContent(){
    $data = array();
    
    $data = $this->classCommonFunction->commonDataForAllPages();
    return view('pages.admin.custom-designer.add-font-content', $data);
  }
  
  /**
   * 
   * Designer font update content
   *
   * @param null
   * @return response view
   */
  public function designerFontUpdateContent( $params ){
    $data = array();
    $get_post  =  Post :: where('post_slug', $params)->first();
    
    if(!empty($get_post)){
      $get_post_extra = PostExtra :: where('post_id', $get_post['id'])->first();

      if(!empty($get_post_extra)){
        $parse_file_name = explode('uploads/', $get_post_extra['key_value']);

        if(count($parse_file_name) > 0){
          $get_post->font_url = $parse_file_name[1];
        }
      }
      
      $data = $this->classCommonFunction->commonDataForAllPages();
      $data['designer_font_data'] = $get_post;
      
      return view('pages.admin.custom-designer.update-font-content', $data);
    }
    else{
      return view('errors.no_data');
    }
  }
  
  /**
   * 
   * Designer settings content
   *
   * @param null
   * @return response view
   */
  public function designerSettingsContent(){
    $data = array();
    
    $data = $this->classCommonFunction->commonDataForAllPages();
    $data['custom_designer_settings_data']  =  $this->option->getCustomDesignerSettingsData();
    
    return view('pages.admin.custom-designer.settings', $data);
  }

    /**
   * 
   * Save custom designer art categories data
   *
   * @param null
   * @return void
   */
  public function saveArtCategoryData(){
    if( Request::isMethod('post') && Session::token() == Input::get('_token') ){
      $data = Input::all();
      
      $rules = [
                'inputCategoryName'               => 'required'
               ];
        
      $validator = Validator:: make($data, $rules);
      
      if($validator->fails()){
        return redirect()-> back()
        ->withInput()
        ->withErrors( $validator );
      }
      else{
        $termObj    =  new Term;
        $term_slug  =  '';
        
        $check_slug  =  Term::where(['slug' => string_slug_format( Input::get('inputCategoryName') )])->orWhere('slug', 'like', '%' . string_slug_format( Input::get('inputCategoryName') ) . '%')->get()->count();

        if($check_slug === 0){
          $term_slug = string_slug_format( Input::get('inputCategoryName') );
        }
        elseif($check_slug > 0){
          $slug_count = $check_slug + 1;
          $term_slug  = string_slug_format( Input::get('inputCategoryName') ). '-' . $slug_count;
        }
        
        $termObj->name      =   Input::get('inputCategoryName');
        $termObj->slug      =   $term_slug;
        $termObj->type			=   'designer_cat';
        $termObj->parent		=   0;
        $termObj->status	  =   Input::get('inputCategoryStatus');
        
        if($termObj->save()){
          Session::flash('success-message', Lang::get('admin.successfully_saved_msg'));
          return redirect()->route('admin.update_art_category_content', $termObj->slug);
        }
      }
    }
    else{
      return redirect()-> back();
    }
  }
  
  /**
   * 
   * Update custom designer art categories data
   *
   * @param slug
   * @return void
   */
  public function updateArtCatDetails($slug){
    if( Request::isMethod('post') && Session::token() == Input::get('_token') ){
      $data = Input::all();
      
      $rules = [
                'inputCategoryName'               => 'required'
               ];
        
      $validator = Validator:: make($data, $rules);
      
      if($validator->fails()){
        return redirect()-> back()
        ->withInput()
        ->withErrors( $validator );
      }
      else{
        $termObj   =  new Term;
        
        $data = array(
                      'name'   =>    Input::get('inputCategoryName'),
                      'status' =>    Input::get('inputCategoryStatus')
        );
        
        if( $termObj::where('slug', $slug)->update($data)){
          Session::flash('success-message', Lang::get('admin.successfully_updated_msg'));
          return redirect()->route('admin.update_art_category_content', $slug);
        }
      }
    }
    else{
      return redirect()-> back();
    }
  }
  
  /**
   * 
   * Save custom designer art data
   *
   * @param null
   * @return void
   */
  public function saveArtData(){
    if( Request::isMethod('post') && Session::token() == Input::get('_token') ){
      $data  = Input::all();
      
      $rules = [
                'inputArtName'          => 'required',
                'inputSelectCategory'   => 'required'
               ];
        
      $validator = Validator:: make($data, $rules);
      
      if($validator->fails()){
        return redirect()-> back()
        ->withInput()
        ->withErrors( $validator );
      }
      else{
        $imgUrlArray = json_decode(Input::get('ht_art_all_uploaded_images'));
        
        if(is_array($imgUrlArray) && count($imgUrlArray)>0){
          $id = '';
          
          foreach($imgUrlArray as $url){
            $post_new_slug = '';
            
            $slug  =  Post::where(['post_slug' => string_slug_format( Input::get('inputArtName') )])->orWhere('post_slug', 'like', '%' . string_slug_format( Input::get('inputArtName') ) . '%')->get()->count();

            if($slug === 0){
              $post_new_slug = string_slug_format( Input::get('inputArtName') );
            }
            elseif($slug > 0){
              $slug_count = $slug + 1;
              $post_new_slug  = string_slug_format( Input::get('inputArtName') ). '-' . $slug_count;
            }
        
            $id = DB::table('posts')->insertGetId(
                array(
                    'post_author_id'  =>  Session::get('shopist_admin_user_id'),
                    'post_content'    =>  'Custom designer art content',
                    'post_title'      =>  Input::get('inputArtName'),
                    'post_slug'       =>  $post_new_slug,
                    'parent_id'       =>  0,
                    'post_status'     =>  Input::get('inputArtStatus'),
                    'post_type'       =>  'designer_art',
                    'created_at'      =>  date("y-m-d H:i:s", strtotime('now')),
                    'updated_at'      =>  date("y-m-d H:i:s", strtotime('now'))  
            ));
            
            if(PostExtra::insert(array(
                                    array(
                                        'post_id'       =>  $id,
                                        'key_name'      =>  '_art_img_url',
                                        'key_value'     =>  str_replace(url('/'), '', $url->url),
                                        'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                        'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                    )
                                )
            )){
              
              //save categories
              if(Input::has('inputSelectCategory')){
                $cat_data = array('term_id'  =>  Input::get('inputSelectCategory'), 'object_id'  =>  $id, 'created_at'  =>  date("y-m-d H:i:s", strtotime('now')), 'updated_at'  =>  date("y-m-d H:i:s", strtotime('now')));
                
                ObjectRelationship::insert( $cat_data );    
              }
            }
          }
          
          if($id){
            $get_post = Post::where(['id' => $id])->first();
            
            if(!empty($get_post)){
              Session::flash('success-message', Lang::get('admin.successfully_saved_msg'));
              return redirect()->route('admin.update_clipart_content', $get_post->post_slug);
            }
          }
        }
        else{
          $post_slug  =  '';
        
          $check_slug  =  Post::where(['post_slug' => string_slug_format( Input::get('inputArtName') )])->orWhere('post_slug', 'like', '%' . string_slug_format( Input::get('inputArtName') ) . '%')->get()->count();

          if($check_slug === 0){
            $post_slug = string_slug_format( Input::get('inputArtName') );
          }
          elseif($check_slug > 0){
            $slug_count = $check_slug + 1;
            $post_slug  = string_slug_format( Input::get('inputArtName') ). '-' . $slug_count;
          }
        
          $postObj   =  new Post;
          
          $postObj->post_author_id    =   Session::get('shopist_admin_user_id');
          $postObj->post_content      =   'Custom designer art content';
          $postObj->post_title        =   Input::get('inputArtName');
          $postObj->post_slug         =   $post_slug;
          $postObj->parent_id         =   0;
          $postObj->post_status       =   Input::get('inputArtStatus');
          $postObj->post_type         =   'designer_art';
          
          if( $postObj->save() ){
            if(PostExtra::insert(array(
                                    array(
                                        'post_id'       =>  $postObj->id,
                                        'key_name'      =>  '_art_img_url',
                                        'key_value'     =>  '',
                                        'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                        'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                    )
                                )
            )){
              
              //save categories
              if(Input::has('inputSelectCategory')){
                $cat_data = array('term_id'  =>  Input::get('inputSelectCategory'), 'object_id'  =>  $postObj->id, 'created_at'  =>  date("y-m-d H:i:s", strtotime('now')), 'updated_at'  =>  date("y-m-d H:i:s", strtotime('now')));
                
                ObjectRelationship::insert( $cat_data );    
              }
              
              Session::flash('success-message', Lang::get('admin.successfully_saved_msg'));
              return redirect()->route('admin.update_clipart_content', $postObj->post_slug);
            }
          }
        }
      }
    }
    else{
      return redirect()-> back();
    }
  }
  
  /**
   * 
   * Update custom designer art data
   *
   * @param slug
   * @return void
   */
  public function updateArtData($slug){
    if( Request::isMethod('post') && Session::token() == Input::get('_token') ){
      $data  = Input::all();
      
      $rules = [
                'inputArtName'          => 'required',
                'inputSelectCategory'   => 'required'
               ];
        
      $validator = Validator:: make($data, $rules);
      
      if($validator->fails()){
        return redirect()-> back()
        ->withInput()
        ->withErrors( $validator );
      }
      else{
        $img_url = '';
        $imgUrlArray = json_decode(Input::get('ht_art_all_uploaded_images'));
        
        if(count($imgUrlArray)>0){
          if(!empty($imgUrlArray[0]->url)){
            $img_url = $imgUrlArray[0]->url;
          }
        }
        
        $img_url = str_replace(url('/'), '', $img_url);
        
        $data = array(
                      'post_author_id'	   =>  Session::get('shopist_admin_user_id'),
                      'post_title'         =>  Input::get('inputArtName'),
                      'post_status'        =>  Input::get('inputArtStatus')
        );

        if( Post::where('post_slug', $slug)->update($data)){
          $get_post = Post::where(['post_slug' => $slug])->first();
          
          $img_url = array(
                           'key_value'    =>  $img_url
          );
          
          PostExtra::where(['post_id' => $get_post->id, 'key_name' => '_art_img_url'])->update($img_url);
          
          $is_object_exist = ObjectRelationship::where('object_id', $get_post->id)->get();
              
          if(count($is_object_exist)>0){
            ObjectRelationship::where('object_id', $get_post->id)->delete();
          }
          
          //save categories
          if(Input::has('inputSelectCategory')){
            $cat_data = array('term_id'  =>  Input::get('inputSelectCategory'), 'object_id'  =>  $get_post->id, 'created_at'  =>  date("y-m-d H:i:s", strtotime('now')), 'updated_at'  =>  date("y-m-d H:i:s", strtotime('now')));

            ObjectRelationship::insert( $cat_data );    
          }
          
          Session::flash('success-message', Lang::get('admin.successfully_updated_msg'));
          return redirect()->route('admin.update_clipart_content', $slug);
        }
      }
    }
    else{
      return redirect()-> back();
    }
  }
  
  /**
   * 
   * Get custom designer art data
   *
   * @param slug
   * @return array
   */
  public function getDesignerArtDataBySlug($slug){
    $designer_post = array();
    $get_designer_post = Post :: where(['post_slug' => $slug, 'post_type' => 'designer_art'])->get()->toArray();
    
    if(count($get_designer_post) > 0){
      foreach($get_designer_post as $row){
        $get_designer_postextra = PostExtra :: where('post_id', $row['id'])->get()->toArray();
        
        if(count($get_designer_postextra) > 0){
          foreach($get_designer_postextra as $postextra_row){
            if($postextra_row['key_name'] == '_art_img_url'){
              $row['art_img_url'] = $postextra_row['key_value'];
            }
          }
        }
        
        $get_object_relationships = ObjectRelationship :: where(['object_id' => $row['id']])->first();
        if(!empty($get_object_relationships)){
          $row['art_cat_id'] = $get_object_relationships->term_id;
        }
        
        array_push($designer_post, $row);
        $designer_post = array_shift($designer_post);
      }
    }
    
    return $designer_post;
  }
  
  /**
   * 
   * Get art list data
   *
   * @param pagination, search value, status flag
   * @param pagination required. Boolean type TRUE or FALSE, by default false
   * @param search value optional
	 * @param status flag by default -1. -1 for all data, 1 for status enable and 0 for disable status
   * @return array
   */
	public function getArtListData( $pagination = false, $search_val = null, $status_flag = -1){
    $art_data  = array();
    
    if($status_flag == -1){
        $where = ['posts.post_type' => 'designer_art', 'post_extras.key_name' => '_art_img_url'];
    }
    else{
        $where = ['posts.post_status' => $status_flag, 'posts.post_type' => 'designer_art', 'post_extras.key_name' => '_art_img_url'];
    }
				
    if($search_val && $search_val != ''){
      $art_data =  DB::table('posts')->where( $where )
                   ->where('terms.name', 'LIKE', $search_val.'%')  
                   ->join('object_relationships', 'object_relationships.object_id', '=', 'posts.id')
                   ->join('terms', 'terms.term_id', '=', 'object_relationships.term_id')
                   ->join('post_extras', 'post_extras.post_id', '=', 'posts.id')
                   ->select('posts.*', 'terms.name as cat_name', 'post_extras.key_value as art_img') 
                   ->orderBy('posts.id', 'desc')
                   ->get()
                   ->toArray(); 
    }
    else{
      $art_data =  DB::table('posts')->where( $where )
                   ->join('object_relationships', 'object_relationships.object_id', '=', 'posts.id')
                   ->join('terms', 'terms.term_id', '=', 'object_relationships.term_id')
                   ->join('post_extras', 'post_extras.post_id', '=', 'posts.id')
                   ->select('posts.*', 'terms.name as cat_name', 'post_extras.key_value as art_img') 
                   ->orderBy('posts.id', 'desc')
                   ->get()
                   ->toArray(); 
    }
    	
    if($pagination){
      $currentPage = LengthAwarePaginator::resolveCurrentPage();
      $col = new Collection( $art_data );
      $perPage = 10;
      $currentPageSearchResults = $col->slice(($currentPage - 1) * $perPage, $perPage)->all();
      $art_object = new LengthAwarePaginator($currentPageSearchResults, count($col), $perPage);

      $art_object->setPath( route('admin.clipart_list_content') );
    }
    
    if($pagination){
      return $art_object;
    }
    else{
      return $art_data;
    }
  }
  
  /**
   * 
   * Update custom designer settings
   *
   * @param null
   * @return void
   */
  public function updateDesignerSettings(){
    if( Request::isMethod('post') && Session::token() == Input::get('_token') ){
      $designer_settings = array(
        'general_settings' => array(
          'canvas_dimension' => array('small_devices' => array('width' => Input::get('global_canvas_small_devices_width'), 'height' => Input::get('global_canvas_small_devices_height')), 'medium_devices' => array('width'=> Input::get('global_canvas_medium_devices_width'), 'height' => Input::get('global_canvas_medium_devices_height')), 'large_devices' => array('width' => Input::get('global_canvas_large_devices_width'), 'height' => Input::get('global_canvas_large_devices_height')))
        )
      );
      
      $data = array(
                    'option_value'  =>  serialize($designer_settings)
      );
      
      if( Option::where('option_name', '_custom_designer_settings_data')->update($data)){
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
   * Get designer cat data by cat id
   *
   * @param cat_id
   * @return array
   */
	public function getDesignerCatDataByCatId( $cat_id){
    $cat_data  = array();
    
    $get_post_data =  DB::table('posts')
                      ->where(['posts.post_status' => 1, 'posts.post_type' => 'designer_art', 'object_relationships.term_id' => $cat_id ])
                      ->join('object_relationships', 'object_relationships.object_id', '=', 'posts.id')
                      ->join('terms', 'terms.term_id', '=', 'object_relationships.term_id')
                      ->join('post_extras', 'post_extras.post_id', '=', 'posts.id')
                      ->select('posts.*', 'terms.name as cat_name', 'post_extras.key_value as art_img')
                      ->orderBy('posts.id', 'desc')
                      ->get()
                      ->toArray();
    
    if(count($get_post_data) > 0){
      $cat_data = $get_post_data;
    }
    
    return $cat_data;  
  }
  
  /**
   * 
   * save designer shape
   *
   * @param null
   * @return response
   */
  public function saveDesignerShape($params = null){
    if( Request::isMethod('post') && Session::token() == Input::get('_token') ){
      $data  = Input::all();
      
      $rules = [
                  'inputShapeName'      => 'required',
                  'inputShapeContent'   => 'required'
               ];
        
      $validator = Validator:: make($data, $rules);
      
      if($validator->fails()){
        return redirect()-> back()
        ->withInput()
        ->withErrors( $validator );
      }
      else{
        $post =  new Post;
        if(Input::get('post_type') == 'save'){
          $post_slug   =  '';
          $check_slug  =  Post::where(['post_slug' => string_slug_format( Input::get('inputShapeName') )])->orWhere('post_slug', 'like', '%' . string_slug_format( Input::get('inputShapeName') ) . '%')->get()->count();

          if($check_slug === 0){
            $post_slug = string_slug_format( Input::get('inputShapeName') );
          }
          elseif($check_slug > 0){
            $slug_count = $check_slug + 1;
            $post_slug = string_slug_format( Input::get('inputShapeName') ). '-' . $slug_count;
          }
          
          $post->post_author_id         =   Session::get('shopist_admin_user_id');
          $post->post_content           =   base64_encode(Input::get('inputShapeContent'));
          $post->post_title             =   Input::get('inputShapeName');
          $post->post_slug              =   $post_slug;
          $post->parent_id              =   0;
          $post->post_status            =   Input::get('inputShapeStatus');
          $post->post_type              =   'designer_shape';
          
          if($post->save()){  
            Session::flash('success-message', Lang::get('admin.successfully_saved_msg') );
            return redirect()->route('admin.shape_update_content', $post->post_slug);
          }
        }
        elseif(Input::get('post_type') == 'update'){
          $data = array(
                        'post_author_id'	         =>  Session::get('shopist_admin_user_id'),
                        'post_content'	           =>  base64_encode(Input::get('inputShapeContent')),
                        'post_title'               =>  Input::get('inputShapeName'),
                        'post_status'              =>  Input::get('inputShapeStatus')
          );
          if(Post::where('post_slug', $params)->update($data)){
            Session::flash('success-message', Lang::get('admin.successfully_updated_msg' ));
            return redirect()->route('admin.shape_update_content', $params);
          }
        }
      }
    }
  }
  
  /**
   * 
   * save designer fonts
   *
   * @param null
   * @return response
   */
  public function saveDesignerFont($params = null){
   if( Request::isMethod('post') && Session::token() == Input::get('_token') ){
     $data  = Input::all();
     $is_font_url_exist = false;
     $uploaded_file_name = null;
     $post_id = 0;
     
     if(!empty($params)){
       $get_post  =  Post :: where('post_slug', $params)->first();
       $post_id   =  $get_post['id'];
       $get_postextra  =  PostExtra :: where('post_id', $post_id)->first();
       
       if(!empty($get_postextra) && $get_postextra['key_value']){
         $is_font_url_exist = true;
       }
     }
      
     $rules = [
                'inputFontName'  => 'required'
              ];
     
      if(!$is_font_url_exist){
        $rules['font_upload'] = 'required';
      }
     
      $validator = Validator:: make($data, $rules);
      if($validator->fails()){
        return redirect()-> back()
        ->withInput()
        ->withErrors( $validator );
      }
      else{
        if(Input::has('font_upload')){
          $file  = Input::file('font_upload');
          $fileName  =  $file->getClientOriginalName();
          $get_extension  = explode('.', $fileName);

          
          if(count($get_extension) > 0 && ($get_extension[1] == 'woff2' || $get_extension[1] == 'woff')){
            $destinationPath = public_path('uploads');
            $file->move($destinationPath, time().'_'.$file->getClientOriginalName());
            $uploaded_file_name = 'uploads/'.time().'_'.$file->getClientOriginalName();
          }
          else{
            Session::flash('error-message', Lang::get('admin.font_format_msg'));
            return redirect()-> back();
          }
        }
        
        $post =  new Post;
        if(Input::get('post_type') == 'save'){
          $post_slug   =  '';
          $check_slug  =  Post::where(['post_slug' => string_slug_format( Input::get('inputFontName') )])->orWhere('post_slug', 'like', '%' . string_slug_format( Input::get('inputFontName') ) . '%')->get()->count();

          if($check_slug === 0){
            $post_slug = string_slug_format( Input::get('inputFontName') );
          }
          elseif($check_slug > 0){
            $slug_count = $check_slug + 1;
            $post_slug = string_slug_format( Input::get('inputFontName') ). '-' . $slug_count;
          }

          $post->post_author_id         =   Session::get('shopist_admin_user_id');
          $post->post_content           =   'custom fonts upload';
          $post->post_title             =   Input::get('inputFontName');
          $post->post_slug              =   $post_slug;
          $post->parent_id              =   0;
          $post->post_status            =   Input::get('inputFontStatus');
          $post->post_type              =   'custom_font';

          if($post->save()){
            if(PostExtra::insert(
                                  array(
                                      'post_id'       =>  $post->id,
                                      'key_name'      =>  '_font_uploaded_url',
                                      'key_value'     =>  $uploaded_file_name,
                                      'created_at'    =>  date("y-m-d H:i:s", strtotime('now')),
                                      'updated_at'    =>  date("y-m-d H:i:s", strtotime('now'))
                                  )
            )){
              Session::flash('success-message', Lang::get('admin.successfully_saved_msg') );
              return redirect()->route('admin.font_update_content', $post->post_slug);
            }
          }
        }
        elseif(Input::get('post_type') == 'update'){
          $data = array(
                        'post_author_id'	         =>  Session::get('shopist_admin_user_id'),
                        'post_title'               =>  Input::get('inputFontName'),
                        'post_status'              =>  Input::get('inputFontStatus')
          );
          if(Post::where('post_slug', $params)->update($data)){
            
            if(!is_null($uploaded_file_name)){
              $data_related_url = array(
                                'key_value'    =>  $uploaded_file_name
              );
              
              PostExtra::where(['post_id' => $post_id, 'key_name' => '_font_uploaded_url'])->update($data_related_url);
            }
            
            Session::flash('success-message', Lang::get('admin.successfully_updated_msg' ));
            return redirect()->route('admin.font_update_content', $params);
          }
        }
      }
   } 
  }
}