@extends('layouts.admin.install')
@section('title', trans('admin.login') .' < '. get_site_title())
@section('content')

<div class="login-box">
  <div class="login-logo">
    {{ trans('admin.shopist') }} <b>{{ trans('admin.login') }}</b>
  </div>
  
  <div class="login-box-body">
    <p class="login-box-msg">{{ trans('admin.sign_in_as_a_user') }}</p>
    
    @include('pages-message.notify-msg-error')
    @include('pages-message.form-submit')
    
    <form method="post" action="" enctype="multipart/form-data">
      <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
      
      <div class="form-group has-feedback">
        <input type="email" class="form-control" placeholder="{{ strtolower(trans('admin.email')) }}" name="admin_login_email" value="{{$data['user']}}">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="{{ strtolower(trans('admin.password')) }}" name="admin_login_password" value="{{ $data['pass'] }}">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      @if($data['is_enable_recaptcha'] == true)
      <div class="form-group">
        <div class="captcha-style">{!! app('captcha')->display(); !!}</div>
      </div>
      @endif
      
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              @if (Cookie::has('remember_me_data'))
              <input type="checkbox" name="remember_me" checked="checked"> {{ trans('admin.remember_me') }}
              @else
              <input type="checkbox" name="remember_me" > {{ trans('admin.remember_me') }}
              @endif
            </label>
          </div>
        </div>
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat" name="admin_login_submit">{{ trans('admin.sign_in') }}</button>
        </div>
      </div>
      
    </form>
    
    <a href="{{route('forgotPassword')}}">{{ trans('admin.i_forgot_my_password') }}</a><br>
  </div>
</div>
@endsection
