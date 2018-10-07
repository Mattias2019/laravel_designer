@extends('layouts.admin.master')
@section('title', trans('admin.vendors_package_label') .' < '. get_site_title())

@section('content')
<div id="vendors_package_create">
  @include('pages-message.notify-msg-success')
  @include('pages-message.form-submit')
  
  <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
    <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">

    <div class="box box-info">
      <div class="box-header">
        <h3 class="box-title">{!! trans('admin.create_vendors_package_label') !!} &nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-default btn-xs" href="{{ route('admin.vendors_packages_list_content') }}">{!! trans('admin.vendors_package_list_label') !!}</a></h3>
        <div class="box-tools pull-right">
          <button class="btn btn-block btn-primary" type="submit">{!! trans('admin.save') !!}</button>
        </div>
      </div>
    </div>  

    <div class="box box-solid">
      <div class="row">
        <div class="col-md-12">
          <div class="box-body">
            <div class="form-group">
              <label class="col-sm-4 control-label" for="inputPackages">{{ trans('admin.vendors_package_type_label') }}</label>
              <div class="col-sm-8">
                <input type="text" id="inputPackageType" name="inputPackageType" class="form-control">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-4 control-label" for="inputAllowMaxProducts">{{ trans('admin.allow_max_products_label') }}</label>
              <div class="col-sm-8">
                <input type="number" id="inputMaxNumberProducts" name="inputMaxNumberProducts" class="form-control">
              </div>
            </div>  
            <div class="form-group">
              <label class="col-sm-4 control-label" for="inputShowMap">{{ trans('admin.map_show_label') }} <i class="fa fa-question-circle" data-container="body" data-toggle="popover" data-placement="right" data-content="{{ trans('popover.show_map_extra_label') }}"></i></label>
              <div class="col-sm-8">
                <input type="checkbox" id="inputShowMap" name="inputShowMap" class="shopist-iCheck">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-4 control-label" for="inputShowFollowBtn">{{ trans('admin.show_social_media_follow_label') }}</label>
              <div class="col-sm-8">
                <input type="checkbox" id="inputShowSocialMediaFollow" name="inputShowSocialMediaFollow" class="shopist-iCheck">
              </div>
            </div>  
            <div class="form-group">
              <label class="col-sm-4 control-label" for="inputShowShareBtn">{{ trans('admin.show_social_media_share_label') }}</label>
              <div class="col-sm-8">
                <input type="checkbox" id="inputShowSocialMediaShareBtn" name="inputShowSocialMediaShareBtn" class="shopist-iCheck">
              </div>
            </div>    
            <div class="form-group">
              <label class="col-sm-4 control-label" for="inputShowContactForm">{{ trans('admin.show_contact_form_label') }} <i class="fa fa-question-circle" data-container="body" data-toggle="popover" data-placement="right" data-content="{{ trans('popover.show_contact_form_extra_label') }}"></i></label>
              <div class="col-sm-8">
                <input type="checkbox" id="inputShowContactForm" name="inputShowContactForm" class="shopist-iCheck">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-4 control-label" for="inputExpiredType">{{ trans('admin.vendor_expired_date_label') }}</label>
              <div class="col-sm-8">
                <ul class="vendor-expired-option">
                  <li>
                    <input type="radio" id="inputCustomDateVendor" name="inputExpiredType" value="custom_date" class="shopist-iCheck">&nbsp; {!! trans('admin.vendor_custom_expired_date_label') !!} &nbsp; 
                  </li>  
                  <li style="display:none;" class="allow-expired-date-picker"><input type="text" id="inputExpiredDate" name="inputExpiredDate" class="form-control"></li>
                  <li><input type="radio" id="inputLifeTimeVendor" name="inputExpiredType" value="lifetime" class="shopist-iCheck">&nbsp; {!! trans('admin.vendor_lifetime_expired_date_label') !!}</li>
                </ul>  
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-4 control-label" for="inputCommission">{{ trans('admin.vendor_commission_label') }} <i class="fa fa-question-circle" data-container="body" data-toggle="popover" data-placement="right" data-content="{{ trans('popover.vendor_commission_msg') }}"></i></label>
              <div class="col-sm-8">
                <input type="number" id="inputCommissionPercentage" name="inputCommissionPercentage" class="form-control">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-4 control-label" for="inputMinWithdrawAmount">{{ trans('admin.vendor_min_withdraw_amount') }}</label>
              <div class="col-sm-8">
                <input type="number" id="inputMinWithdrawAmount" name="inputMinWithdrawAmount" class="form-control">
              </div>
            </div>  
          </div>  
        </div>
      </div>
    </div>
  </form>        
</div>
@endsection