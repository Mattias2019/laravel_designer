<?php
namespace shopist\Http\Controllers\Frontend;

use shopist\Http\Controllers\Controller;
use Request;
use Illuminate\Support\Facades\Lang;
use Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use shopist\Models\Comment;

class UserCommentsController extends Controller
{
  public function saveUserComments(){
    if( Request::isMethod('post') && Session::token() == Input::get('_token') ){
      
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
          $comments->object_id   =    Input::get('object_id');
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
}