@extends('layouts.admin.install')
@section('title', trans('frontend.retrieve_password') .' < '. get_site_title() )
@section('content')

<br><br>
<div class="row">
  <div class="col-md-4 col-md-offset-4">
    <div class="panel panel-default">
      <div class="panel-body">
        <div class="text-center">
          <img src="{{ URL::asset('public/images/forgot-password.png') }}">
          
          <h3 class="text-center">{{ trans('frontend.forgot_password') }}</h3>
          
          <p>{{ trans('frontend.reset_password_msg') }}</p>
            <div class="panel-body">

              @include('pages-message.notify-msg-error')
              @include('pages-message.form-submit')

              <form method="post" action="" enctype="multipart/form-data">
                <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                <fieldset>                 
                  <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                      <input id="forgotEmailInput" placeholder="{{ trans('frontend.email_address') }}" class="form-control" type="email" name="forgotEmailInput">
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-lock color-blue"></i></span>
                      <input id="resetPasswordInput" placeholder="{{ trans('frontend.new_password') }}" class="form-control" type="password" name="resetPasswordInput">
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-lock color-blue"></i></span>
                      <input id="secretKeyInput" placeholder="{{ trans('frontend.secret_key') }}" class="form-control" type="text" name="secretKeyInput">
                    </div>
                  </div>

                  <div class="form-group">
                    <input class="btn btn-lg btn-primary btn-block" value="{{ trans('frontend.reset_my_password') }}" type="submit">
                  </div>
                </fieldset>
              </form>

            </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
