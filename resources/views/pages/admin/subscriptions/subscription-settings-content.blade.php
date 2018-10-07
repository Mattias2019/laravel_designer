@extends('layouts.admin.master')
@section('title', trans('admin.subscription_settings_page_title') .' < '. get_site_title())

@section('content')
@include('pages-message.notify-msg-success')

<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
  <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
  
  <div class="box box-info">
    <div class="box-header">
      <div class="pull-right">
        <button class="btn btn-block btn-primary" type="submit">{!! trans('admin.save') !!}</button>
      </div>
    </div>
  </div>
  
  <div class="row">
    <div class="col-md-12">
      <div class="box box-solid"> 
        <div class="box-body">
          <div class="form-group">
            <label class="col-sm-4 control-label" for="inputSubscribeEnableDisable">{{ trans('admin.enable_disable_subscribe_label') }}</label>
            <div class="col-sm-8">
              @if($subscription_settings_data['subscription_visibility'] == true)  
                <input type="checkbox" checked="checked" class="shopist-iCheck" name="subscriptions_visibility">
              @else
                <input type="checkbox" class="shopist-iCheck" name="subscriptions_visibility">
              @endif
            </div>
          </div>  
          <div class="form-group">
            <label class="col-sm-4 control-label" for="inputMode">{{ trans('admin.subscriptions_type') }}</label>
            <div class="col-sm-8">
              @if($subscription_settings_data['subscribe_type'] == 'custom')  
                <div style="margin-bottom: 10px;"><input type="radio" checked="checked" class="shopist-iCheck" name="subscriptions_type" value="custom">&nbsp; {{ trans('admin.custom_subscriptions_label') }}</div>
              @else
                <div style="margin-bottom: 10px;"><input type="radio" class="shopist-iCheck" name="subscriptions_type" value="custom">&nbsp; {{ trans('admin.custom_subscriptions_label') }}</div>
              @endif
              
              @if($subscription_settings_data['subscribe_type'] == 'mailchimp')
                <div><input type="radio" checked="checked" class="shopist-iCheck" name="subscriptions_type" value="mailchimp">&nbsp; {{ trans('admin.mailchimp_subscriptions_label') }}</div>
              @else
                <div><input type="radio" class="shopist-iCheck" name="subscriptions_type" value="mailchimp">&nbsp; {{ trans('admin.mailchimp_subscriptions_label') }}</div>
              @endif
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label" for="inputOptions">{{ trans('admin.subscription_options_label') }}</label>
            <div class="col-sm-8">
              @if($subscription_settings_data['subscribe_options'] == 'email')  
                <div style="margin-bottom: 10px;"><input type="radio" checked="checked" class="shopist-iCheck" name="subscribe_options" value="email">&nbsp; {{ trans('admin.subscribe_by_email_label') }}</div>
              @else
                <div style="margin-bottom: 10px;"><input type="radio" class="shopist-iCheck" name="subscribe_options" value="email">&nbsp; {{ trans('admin.subscribe_by_email_label') }}</div>
              @endif
              
              @if($subscription_settings_data['subscribe_options'] == 'name_email') 
                <div><input type="radio" class="shopist-iCheck" checked="checked" name="subscribe_options" value="name_email">&nbsp; {{ trans('admin.subscribe_by_name_and_email_label') }}</div>
              @else 
                <div><input type="radio" class="shopist-iCheck" name="subscribe_options" value="name_email">&nbsp; {{ trans('admin.subscribe_by_name_and_email_label') }}</div>
              @endif
            </div>
          </div>  
          <div class="form-group">
            <label class="col-sm-4 control-label" for="inputBGColor">{{ trans('admin.subscription_popupbg_color_label') }}</label>
            <div class="col-sm-8">
              <input type="text" class="color form-control" id="subscriptions_popup_bg_color" name="subscriptions_popup_bg_color" value="{{ $subscription_settings_data['popup_bg_color'] }}"/>
            </div>
          </div>  
          <div class="form-group">
            <label class="col-sm-4 control-label" for="inputHTMLContent">{{ trans('admin.subscription_popup_content_label') }}</label>
            <div class="col-sm-8">
              <textarea id="subscription_content_editor" name="subscription_content_editor" class="dynamic-editor">{!! string_decode($subscription_settings_data['popup_content']) !!}</textarea>
            </div>
          </div> 
          <div class="form-group">
            <label class="col-sm-4 control-label" for="inputDisplay">{{ trans('admin.subscription_popup_display_at_label') }}</label>
            <div class="col-sm-8">
              @if(is_array($subscription_settings_data['popup_display_page']) && count($subscription_settings_data['popup_display_page']) >0 && in_array('home', $subscription_settings_data['popup_display_page']))  
                <div style="margin-bottom: 10px;">
                  <input type="checkbox" checked="checked" class="shopist-iCheck" name="popup_display[]" value="home">&nbsp; {{ trans('admin.subscription_popup_display_at_home_label') }}
                </div>  
              @else
                <div style="margin-bottom: 10px;">
                  <input type="checkbox" class="shopist-iCheck" name="popup_display[]" value="home">&nbsp; {{ trans('admin.subscription_popup_display_at_home_label') }}
                </div>
              @endif
              
              @if(is_array($subscription_settings_data['popup_display_page']) && count($subscription_settings_data['popup_display_page']) >0 && in_array('shop', $subscription_settings_data['popup_display_page']))  
                <div style="margin-bottom: 10px;">
                  <input type="checkbox" checked="checked" class="shopist-iCheck" name="popup_display[]" value="shop">&nbsp; {{ trans('admin.subscription_popup_display_at_shop_label') }}
                </div> 
              @else
                <div style="margin-bottom: 10px;">
                  <input type="checkbox" class="shopist-iCheck" name="popup_display[]" value="shop">&nbsp; {{ trans('admin.subscription_popup_display_at_shop_label') }}
                </div>
              @endif
              
              @if(is_array($subscription_settings_data['popup_display_page']) && count($subscription_settings_data['popup_display_page']) >0 && in_array('blog', $subscription_settings_data['popup_display_page']))  
                <div style="margin-bottom: 10px;">
                  <input type="checkbox" checked="checked" class="shopist-iCheck" name="popup_display[]" value="blog">&nbsp; {{ trans('admin.subscription_popup_display_at_blog_label') }}
                </div>
              @else
                <div style="margin-bottom: 10px;">
                  <input type="checkbox" class="shopist-iCheck" name="popup_display[]" value="blog">&nbsp; {{ trans('admin.subscription_popup_display_at_blog_label') }}
                </div>
              @endif
              
              @if(is_array($subscription_settings_data['popup_display_page']) && count($subscription_settings_data['popup_display_page']) >0 && in_array('cart', $subscription_settings_data['popup_display_page']))  
                <div style="margin-bottom: 10px;">
                  <input type="checkbox" checked="checked" class="shopist-iCheck" name="popup_display[]" value="cart">&nbsp; {{ trans('admin.subscription_popup_display_at_cart_label') }}
                </div>   
              @else
                <div style="margin-bottom: 10px;">
                  <input type="checkbox" class="shopist-iCheck" name="popup_display[]" value="cart">&nbsp; {{ trans('admin.subscription_popup_display_at_cart_label') }}
                </div>   
              @endif
            </div>
          </div>  
          <div class="form-group">
            <label class="col-sm-4 control-label" for="inputBtnLabel">{{ trans('admin.subscribe_btn_label') }}</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" name="subscribe_btn_text" id="subscribe_btn_text" value="{{ $subscription_settings_data['subscribe_btn_text'] }}">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label" for="inputCookieSet">{{ trans('admin.subscribe_cookie_set_label') }}</label>
            <div class="col-sm-8">
              @if($subscription_settings_data['subscribe_popup_cookie_set_visibility'] == true)
                <input type="checkbox" class="shopist-iCheck" checked="checked" name="subscribe_popup_cookie_set" id="subscribe_popup_cookie_set">
              @else
                <input type="checkbox" class="shopist-iCheck" name="subscribe_popup_cookie_set" id="subscribe_popup_cookie_set">
              @endif
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label" for="inputCookieSetText">{{ trans('admin.subscribe_cookie_set_text') }}</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" name="subscribe_popup_cookie_set_text" id="subscribe_popup_cookie_set_text" value="{{ $subscription_settings_data['subscribe_popup_cookie_set_text'] }}">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>  
@endsection