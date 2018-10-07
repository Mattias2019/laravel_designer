@extends('layouts.frontend.master')

@section('title', trans('frontend.frontend_user_registration_title') .' - '. get_site_title())
@section('content')

@if($settings_data['general_options']['allow_registration_for_frontend'])
<div id="user_registration" class="container custom-extra-top-style">
  <div class="row">
    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
      @include('pages-message.notify-msg-error')
      @include('pages-message.form-submit')    

      <form method="post" action="" enctype="multipart/form-data">
        <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
        
        <h2>{!! trans('frontend.please_sign_up_label') !!} <small>{!! trans('frontend.sign_up_free_label') !!}</small></h2>
        <hr class="colorgraph">
        
        <div class="row">
          <div class="col-xs-12 col-sm-6 col-md-6">
            <div class="form-group has-feedback">
              <input type="text" placeholder="{{ trans('frontend.display_name') }}" class="form-control" value="{{ old('user_reg_display_name') }}" id="user_reg_display_name" name="user_reg_display_name">
              <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
          </div>
          <div class="col-xs-12 col-sm-6 col-md-6">
            <div class="form-group has-feedback">
              <input type="text" placeholder="{{ trans('frontend.user_name') }}" class="form-control" value="{{ old('user_reg_name') }}" id="user_reg_name" name="user_reg_name">
              <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
          </div>
        </div>
        
        <div class="form-group has-feedback">
          <input type="email" placeholder="{{ ucfirst( trans('frontend.email') ) }}" class="form-control" id="reg_email_id" value="{{ old('reg_email_id') }}" name="reg_email_id">
          <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        
        <div class="row">
          <div class="col-xs-12 col-sm-6 col-md-6">
            <div class="form-group has-feedback">
              <input type="password" placeholder="{{ ucfirst(trans('frontend.password')) }}" class="form-control" id="reg_password" name="reg_password">
              <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
          </div>
          <div class="col-xs-12 col-sm-6 col-md-6">
            <div class="form-group has-feedback">
              <input type="password" placeholder="{{ trans('frontend.retype_password') }}" class="form-control" id="reg_password_confirmation" name="reg_password_confirmation">
              <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
            </div>
          </div>
        </div>
        
        <div class="form-group has-feedback">
          <input type="text" placeholder="{{ ucfirst(trans('frontend.secret_key')) }}" class="form-control" id="reg_secret_key" name="reg_secret_key">
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        
        @if(!empty($is_enable_recaptcha) && $is_enable_recaptcha == true)
        <div class="form-group">
          <div class="captcha-style">{!! app('captcha')->display(); !!}</div>
        </div>
        @endif
        
        <hr class="colorgraph">
        <div class="row">
          <div class="col-xs-12 col-md-6"><input name="user_reg_submit" id="user_reg_submit" class="btn btn-primary btn-block btn-md" value="{{ trans('frontend.registration') }}" type="submit"> </div>
          <div class="col-xs-12 col-md-6"><a href="{{ route('user-login-page') }}" class="btn btn-primary btn-block btn-md">{{ trans('frontend.signin_account_label') }}</a></div>
        </div>
      </form>
    </div>
  </div>
</div>  
@else
<br>
<p>{{ trans('frontend.user_reg_not_available_label') }}</p>
@endif
@endsection  