@extends('layouts.admin.install')
@section('title', trans('admin.create_admin'))
@section('content')

<div class="register-box">
  <div class="register-logo">
    <h2>{{ trans('admin.create_shopist_admin') }}</h2>
  </div>

  <div class="register-box-body">
    <p class="login-box-msg">{{ trans('admin.register_as_a_administrator') }}</p>
    
    @include('pages-message.form-submit')
    
    <form method="post" action="" enctype="multipart/form-data">
      <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
      
      <div class="form-group has-feedback">
        <input type="text" placeholder="{{ trans('admin.display_name') }}" class="form-control" value="{{ old('display_name') }}" id="display_name" name="display_name">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      
      <div class="form-group has-feedback">
        <input type="text" placeholder="{{ trans('admin.user_name') }}" class="form-control" value="{{ old('user_name') }}" id="user_name" name="user_name">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      
      <div class="form-group has-feedback">
        <input type="email" placeholder="{{ strtolower( trans('admin.email') ) }}" class="form-control" id="email_id" value="{{ old('email_id') }}" name="email_id">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      
      <div class="form-group has-feedback">
        <input type="password" placeholder="{{ strtolower(trans('admin.password')) }}" class="form-control" id="password" name="password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      
      <div class="form-group has-feedback">
        <input type="password" placeholder="{{ trans('admin.retype_password') }}" class="form-control" id="password_confirmation" name="password_confirmation">
        <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
      </div>
      
      <div class="form-group has-feedback">
        <input type="text" placeholder="{{ trans('admin.secret_key') }}" class="form-control" id="secret_key" name="secret_key">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <br>
      <div class="row">
        <div class="col-xs-12">
          <button class="btn btn-primary btn-block btn-flat" type="submit" name="administrator_register_submit" id="register_submit">{{ trans('admin.register') }}</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection