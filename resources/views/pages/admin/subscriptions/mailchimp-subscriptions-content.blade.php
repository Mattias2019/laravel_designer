@extends('layouts.admin.master')
@section('title', trans('admin.mailchimp_subscriptions_page_title') .' < '. get_site_title())

@section('content')
@include('pages-message.notify-msg-error')
@include('pages-message.form-submit')

<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
  <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
  
  <div class="row">
    <div class="col-md-12">
      <div class="box box-info">
        <div class="box-header">
          <h3 class="box-title"></h3>
          <div class="pull-right">
            <button class="btn btn-block btn-primary" type="submit">{{ trans('admin.save') }}</button>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-12">
      <div class="box box-solid">
        <div class="box-header with-border">
          <h3 class="box-title">{{ trans('admin.mailchimp_subscriptions_info_top_title') }}</h3>
        </div> 
        <div class="box-body">
          <div class="form-group">
            <label class="col-sm-2 control-label" for="inputMailchimpAPIKey">{{ trans('admin.api_key') }}</label>
            <div class="col-sm-10">
              <input type="text" placeholder="{{ trans('admin.enter_your_mailchimp_api_key') }}" id="inputMailchimpAPIKey" name="inputMailchimpAPIKey" class="form-control" value="{{ $subscription_data['mailchimp']['api_key'] }}">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="inputMailchimpListId">{{ trans('admin.list_id') }}</label>
            <div class="col-sm-10">
              <input type="text" placeholder="{{ trans('admin.enter_your_mailchimp_list_id') }}" id="inputMailchimpListId" name="inputMailchimpListId" class="form-control" value="{{ $subscription_data['mailchimp']['list_id'] }}">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>  
@endsection