<?php

namespace shopist\Http\Controllers\Auth;

use shopist\Http\Controllers\Controller;
use shopist\Models\User;
use Request;
use Illuminate\Support\Facades\Input;
use Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use shopist\Library\CommonFunction;
use shopist\Http\Controllers\ProductsController;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset with emails and secret key
    |
    */
     public $CommonFunction;
     public $product;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
      $this->middleware('verifyLoginPage');
      $this->classCommonFunction  = new CommonFunction();
      $this->product  = new ProductsController();
    }
    
  /**
   * 
   * Redirect to forgot page
   *
   * @param null
   * @return response
   */
  public function redirectForgotPassword(){ 
    if(Request::is('admin/forgot-password')){
      $this->classCommonFunction->set_admin_lang();
      return view('pages.auth.forgot-password');
    }
    elseif(Request::is('user/forgot-password')){
      $this->classCommonFunction->set_frontend_lang();
      
      $data = array(); 
      
      $data['target'] = 'empty_check';
      $get_data = $this->classCommonFunction->get_dynamic_frontend_content_data( $data );
      
      return view('pages.auth.user-forgot-password')->with($get_data);
    }
    elseif(Request::is('vendor/forgot-password')){
      $this->classCommonFunction->set_frontend_lang();
      
      $data   = array(); 
      
      $data['target'] = 'empty_check';
      $get_data = $this->classCommonFunction->get_dynamic_frontend_content_data( $data );
      
      return view('pages.auth.vendor-forgot-password')->with($get_data);
    }
  }
  
  /**
   * 
   * Save forgot post data
   *
   * @param null
   * @return response
   */
  public function postForgotPassword(){
    if( Request::isMethod('post') && Session::token() == Input::get('_token') ){
      
      $data = Input::all();
      
      $rules = [
        'forgotEmailInput'                  => 'required|email',
        'resetPasswordInput'                => 'required|min:5',
        'secretKeyInput'                    => 'required'
      ];
      
      $messages = [
        'forgotEmailInput.required' => Lang::get('validation.email_required'),
        'forgotEmailInput.email' => Lang::get('validation.email_is_email'),
        'resetPasswordInput.required' => Lang::get('validation.new_password_required'),
        'secretKeyInput.required' => Lang::get('validation.secret_key_required')
      ];
      
      $validator = Validator:: make($data, $rules, $messages);
      
      if($validator->fails()){
        return redirect()-> back()
        ->withInput(Input::except('resetPasswordInput'))
        ->withErrors( $validator );
      }
      else{
         $User =       new User;
       
         $userdata  = ['email' => Input::get('forgotEmailInput')];
         
         $get_key   = $User::where($userdata)->first();
         $data      = $User::where($userdata)->get()->count();
         $_key      = bcrypt(Input::get('secretKeyInput')); 
        
         if($data>0 && isset($get_key->secret_key) && Hash::check(Input::get('secretKeyInput'), $_key) && Hash::check(Input::get('secretKeyInput'), $get_key->secret_key)){
           if($User :: where('email', Input::get('forgotEmailInput'))->update(['password' => bcrypt(Input::get('resetPasswordInput'))])){
             return redirect()->route('admin.login');
           }
         }
         else{
           Session::flash('error-message', Lang::get('admin.authentication_failed_with_email_secret'));
           return redirect()-> back();
         }
      }
    }
    else {
      return redirect()-> back();
    }
  }
  
  /**
   * 
   * Manage user forgot password page
   *
   * @param null
   * @return void
   */
  public function manageFrontendUserForgotPassword(){
    if( Request::isMethod('post') && Session::token() == Input::get('_token') ){
      
      $data = Input::all();
      
      $rules = [
        'user_forgot_pass_email_id'                  => 'required|email',
        'user_forgot_new_password'                   => 'required|min:5',
        'user_forgot_secret_key'                     => 'required'
      ];
      
      $messages = [
        'user_forgot_pass_email_id.required' => Lang::get('validation.email_required'),
        'user_forgot_pass_email_id.email' => Lang::get('validation.email_is_email'),
        'user_forgot_new_password.required'   =>  Lang::get('validation.password_required'),
        'user_forgot_secret_key.required' => Lang::get('validation.secret_key_required'),
      ];
      
      $validator = Validator:: make($data, $rules, $messages);
      
      if($validator->fails()){
        return redirect()-> back()
        ->withInput(Input::except('user_forgot_new_password'))
        ->withErrors( $validator );
      }
      else{
         $User =       new User;
       
         $userdata  = ['email' => Input::get('user_forgot_pass_email_id')];
         
         $get_key   = $User::where($userdata)->first();
         $data      = $User::where($userdata)->get()->count();
         $_key      = bcrypt(Input::get('user_forgot_secret_key')); 
        
         if($data>0 && isset($get_key->secret_key) && Hash::check(Input::get('user_forgot_secret_key'), $_key) && Hash::check(Input::get('user_forgot_secret_key'), $get_key->secret_key)){
           if($User :: where('email', Input::get('user_forgot_pass_email_id'))->update(['password' => bcrypt(Input::get('user_forgot_new_password'))])){
             Session::flash('success-message', Lang::get('frontend.new_password_updated'));
             return redirect()->route('user-login-page');
           }
         }
         else{
           Session::flash('error-message', Lang::get('admin.authentication_failed_with_email_secret'));
           return redirect()-> back();
         }
      }
    }
    else {
      return redirect()-> back();
    }
  }
  
  /**
   * 
   * Manage vendor forgot password page
   *
   * @param null
   * @return void
   */
  public function manageVendorForgotPassword(){
    if( Request::isMethod('post') && Session::token() == Input::get('_token') ){
      
      $data = Input::all();
      
      $rules = [
        'vendor_forgot_pass_email_id'             => 'required|email',
        'vendor_forgot_new_password'              => 'required|min:5',
        'vendor_forgot_secret_key'                => 'required'
      ];
      
      $messages = [
        'vendor_forgot_pass_email_id.required' => Lang::get('validation.email_required'),
        'vendor_forgot_pass_email_id.email' => Lang::get('validation.email_is_email'),
        'vendor_forgot_new_password.required'   =>  Lang::get('validation.password_required'),
        'vendor_forgot_secret_key.required' => Lang::get('validation.secret_key_required'),
      ];
      
      $validator = Validator:: make($data, $rules, $messages);
      
      if($validator->fails()){
        return redirect()-> back()
        ->withInput(Input::except('vendor_forgot_new_password'))
        ->withErrors( $validator );
      }
      else{
         $User =       new User;
       
         $userdata  = ['email' => Input::get('vendor_forgot_pass_email_id')];
         
         $get_key   = $User::where($userdata)->first();
         $data      = $User::where($userdata)->get()->count();
         $_key      = bcrypt(Input::get('vendor_forgot_secret_key')); 
        
         if($data>0 && isset($get_key->secret_key) && Hash::check(Input::get('vendor_forgot_secret_key'), $_key) && Hash::check(Input::get('vendor_forgot_secret_key'), $get_key->secret_key)){
           if($User :: where('email', Input::get('vendor_forgot_pass_email_id'))->update(['password' => bcrypt(Input::get('vendor_forgot_new_password'))])){
             Session::flash('success-message', Lang::get('frontend.new_password_updated'));
             return redirect()->route('vendor-login-page');
           }
         }
         else{
           Session::flash('error-message', Lang::get('admin.authentication_failed_with_email_secret'));
           return redirect()-> back();
         }
      }
    }
    else {
      return redirect()-> back();
    }
  }
}