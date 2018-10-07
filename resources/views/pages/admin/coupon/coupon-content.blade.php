@extends('layouts.admin.master')
@section('title', trans('admin.coupon_manager_page_title') .' < '. get_site_title())

@section('content')
@include('pages-message.notify-msg-error')
@include('pages-message.form-submit')

<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
  <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
  <input type="hidden" name="hf_post_type" id="hf_post_type" value="add">
  
  <div class="row">
    <div class="col-md-12">
      <div class="box box-info">
        <div class="box-header">
          <h3 class="box-title">{{ trans('admin.create_new_coupon_label') }}</h3>
          <div class="box-tools pull-right">
            <button class="btn btn-block btn-primary" type="submit">{{ trans('admin.save') }}</button>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-7">
      <div class="box box-solid">
        <div class="box-header with-border">
          <h3 class="box-title">{{ trans('admin.coupon_code_label') }}</h3>
        </div> 
        <div class="box-body">
          <div><input type="text" placeholder="{{ trans('admin.enter_coupon_code_label') }}" class="form-control" name="coupon_code" id="coupon_code" value=""></div><br>
          <div><textarea id="coupon_description" name="coupon_description" class="dynamic-editor" placeholder="{{ trans('admin.coupon_desc_label') }}"></textarea></div>
        </div>
      </div>
      
      <div class="box box-solid">
        <div class="box-header with-border">
          <h3 class="box-title">{{ trans('admin.coupon_conditions_label') }}</h3>
        </div> 
        <div class="box-body">
          <div class="form-group">
            <label class="col-sm-4 control-label" for="inputConditionsType">{{ trans('admin.conditions_type_label') }}</label>
            <div class="col-sm-8">
              <select id="change_conditions_type" name="change_conditions_type" class="form-control select2" style="width: 100%;">
                <option selected="selected" value="">{{ trans('admin.select_type_label') }}</option>
                <option value="discount_from_product">{{ trans('admin.discount_from_product_label') }}</option>
                <option value="percentage_discount_from_product">{{ trans('admin.percentage_discount_from_product_label') }}</option>
                <option value="discount_from_total_cart">{{ trans('admin.discount_from_total_cart_label') }}</option>
                <option value="percentage_discount_from_total_cart">{{ trans('admin.percentage_discount_from_total_cart_label') }}</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label" for="inputCouponAmount">{{ trans('admin.coupon_amount_label') }}</label>
            <div class="col-sm-8">
              <input type="number" placeholder="{{ trans('admin.enter_coupon_amount_label') }}" class="form-control" name="coupon_amount" id="coupon_amount" value="">
            </div>
          </div>
            <div class="form-group" style="display: none;">
            <label class="col-sm-4 control-label" for="inputAllowShipping">{{ trans('admin.allow_free_shipping_label') }}</label>
            <div class="col-sm-8">
              <input type="checkbox" name="allow_free_shipping" id="allow_free_shipping" class="shopist-iCheck">
            </div>
          </div>
        </div>
      </div>
      
      <div class="box box-solid">
        <div class="box-header with-border">
          <h3 class="box-title">{{ trans('admin.usage_restriction') }}</h3>
        </div> 
        <div class="box-body">
          <div class="form-group">
            <label class="col-sm-4 control-label" for="inputMinAmount">{{ trans('admin.min_amount_usage_restriction') }}</label>
            <div class="col-sm-8">
              <input type="number" placeholder="{{ trans('admin.enter_min_amount_usage_restriction') }}" class="form-control" name="min_restriction_amount" id="min_restriction_amount" value="">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label" for="inputMaxAmount">{{ trans('admin.max_amount_usage_restriction') }}</label>
            <div class="col-sm-8">
              <input type="number" placeholder="{{ trans('admin.enter_max_amount_usage_restriction') }}" class="form-control" name="max_restriction_amount" id="max_restriction_amount" value="">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label" for="inputMaxAmount">{{ trans('admin.user_role_usage_restriction') }}</label>
            <div class="col-sm-8">
              <select name="user_role_usage_restriction" id="user_role_usage_restriction" class="form-control select2" style="width: 100%;">
                <option value="no_role">{!! trans('admin.select_role_title') !!}</option>
                @if(count($user_role_list_data)> 0)
                  @foreach($user_role_list_data as $roles)
                    <option value="{{ $roles['slug'] }}">{!! $roles['role_name'] !!}</option>
                  @endforeach
                @endif
              </select>
            </div>
          </div>
        </div>
      </div>
      
      {{-- <div class="box box-solid">
        <div class="box-header with-border">
          <h3 class="box-title">{{ trans('admin.usage_limit') }}</h3>
        </div> 
        <div class="box-body">
          <div class="form-group">
            <label class="col-sm-4 control-label" for="inputLimitPerCoupon">{{ trans('admin.usage_limit_per_coupon') }}</label>
            <div class="col-sm-8">
              <input type="number" placeholder="{{ trans('admin.unlimited_usage') }}" class="form-control" name="usage_limit_per_coupon" id="usage_limit_per_coupon" value="">
            </div>
          </div>
        </div>
      </div> --}}
    </div>

    <div class="col-md-5">
      <div class="box box-solid">
        <div class="box-header with-border">
          <h3 class="box-title">{{ trans('admin.usage_range') }}</h3>
        </div> 
        <div class="box-body">
          <div class="form-group" style="display: none;">
            <label class="col-sm-3 control-label" for="inputUsageStartDate">{{ trans('admin.usage_range_start_date') }}</label>
            <div class="col-sm-9">                  
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" placeholder="{{ trans('admin.date_format') }}" id="inputUsageStartDate" name="inputUsageStartDate" class="form-control" value="">
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label" for="inputUsageEndDate">{{ trans('admin.usage_range_end_date') }}</label>
            <div class="col-sm-9">                  
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" placeholder="{{ trans('admin.date_format') }}" id="inputUsageEndDate" name="inputUsageEndDate" class="form-control" value="">
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="box box-solid">
        <div class="box-header with-border">
          <i class="fa fa-eye"></i>
          <h3 class="box-title">{{ trans('admin.visibility') }}</h3>
        </div>
        <div class="box-body">
          <div class="form-group">
            <label class="col-sm-3 control-label" for="inputVisibility">{{ trans('admin.enable_coupon') }}</label>
            <div class="col-sm-9">
              <select class="form-control select2" name="coupon_visibility" style="width: 100%;">
                <option selected="selected" value="1">{{ trans('admin.enable') }}</option>
                <option value="0">{{ trans('admin.disable') }}</option>                  
              </select>                                         
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>  
@endsection