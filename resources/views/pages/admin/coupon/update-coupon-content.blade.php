@extends('layouts.admin.master')
@section('title', trans('admin.update_coupon_page_title') .' < '. get_site_title())

@section('content')
@include('pages-message.notify-msg-error')
@include('pages-message.form-submit')

<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
  <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
  <input type="hidden" name="hf_post_type" id="hf_post_type" value="update">
  
  <div class="row">
    <div class="col-md-12">
      <div class="box box-info">
        <div class="box-header">
          <h3 class="box-title">{{ trans('admin.update_coupon_label') }} &nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-default btn-xs" href="{{ route('admin.coupon_manager_list') }}">{{ trans('admin.coupon_list_label') }}</a></h3>
          <div class="box-tools pull-right">
            <button class="btn btn-block btn-primary" type="submit">{{ trans('admin.update') }}</button>
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
          <div><input type="text" placeholder="{{ trans('admin.enter_coupon_code_label') }}" class="form-control" name="coupon_code" id="coupon_code" value="{{ $coupon_update_data['post_title'] }}"></div><br>
          <div><textarea id="coupon_description" name="coupon_description" class="dynamic-editor" placeholder="{{ trans('admin.coupon_desc_label') }}">{!! string_decode($coupon_update_data['post_content']) !!}</textarea></div>
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
                
                @if($coupon_update_data['coupon_condition_type'] == 'discount_from_product')
                <option value="discount_from_product" selected="selected">{{ trans('admin.discount_from_product_label') }}</option>
                @else
                <option value="discount_from_product">{{ trans('admin.discount_from_product_label') }}</option>
                @endif
                
                @if($coupon_update_data['coupon_condition_type'] == 'percentage_discount_from_product')
                <option value="percentage_discount_from_product" selected="selected">{{ trans('admin.percentage_discount_from_product_label') }}</option>
                @else
                <option value="percentage_discount_from_product">{{ trans('admin.percentage_discount_from_product_label') }}</option>
                @endif
                
                @if($coupon_update_data['coupon_condition_type'] == 'discount_from_total_cart')
                <option value="discount_from_total_cart" selected="selected">{{ trans('admin.discount_from_total_cart_label') }}</option>
                @else
                <option value="discount_from_total_cart">{{ trans('admin.discount_from_total_cart_label') }}</option>
                @endif

                @if($coupon_update_data['coupon_condition_type'] == 'percentage_discount_from_total_cart')
                <option value="percentage_discount_from_total_cart" selected="selected">{{ trans('admin.percentage_discount_from_total_cart_label') }}</option>
                @else
                <option value="percentage_discount_from_total_cart">{{ trans('admin.percentage_discount_from_total_cart_label') }}</option>
                @endif

              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label" for="inputCouponAmount">{{ trans('admin.coupon_amount_label') }}</label>
            <div class="col-sm-8">
              <input type="number" placeholder="{{ trans('admin.enter_coupon_amount_label') }}" class="form-control" name="coupon_amount" id="coupon_amount" value="{{ $coupon_update_data['coupon_amount'] }}">
            </div>
          </div>
          {{-- <div class="form-group" style="display: none;">
            <label class="col-sm-4 control-label" for="inputAllowShipping">{{ trans('admin.allow_free_shipping_label') }}</label>
            <div class="col-sm-8">
              @if($coupon_update_data['coupon_shipping_allow_option'] == 'yes')
              <input type="checkbox" checked="checked" name="allow_free_shipping" id="allow_free_shipping" class="shopist-iCheck">
              @else
              
              @endif
            </div>
          </div> --}}
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
              <input type="number" placeholder="{{ trans('admin.enter_min_amount_usage_restriction') }}" class="form-control" name="min_restriction_amount" id="min_restriction_amount" value="{{ $coupon_update_data['coupon_min_restriction_amount'] }}">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label" for="inputMaxAmount">{{ trans('admin.max_amount_usage_restriction') }}</label>
            <div class="col-sm-8">
              <input type="number" placeholder="{{ trans('admin.enter_max_amount_usage_restriction') }}" class="form-control" name="max_restriction_amount" id="max_restriction_amount" value="{{ $coupon_update_data['coupon_max_restriction_amount'] }}">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label" for="inputMaxAmount">{{ trans('admin.user_role_usage_restriction') }}</label>
            <div class="col-sm-8">
              <select name="user_role_usage_restriction" id="user_role_usage_restriction" class="form-control select2" style="width: 100%;">
                <option value="no_role">{!! trans('admin.select_role_title') !!}</option>
                @if(count($user_role_list_data)> 0)
                  @foreach($user_role_list_data as $roles)
                    @if($coupon_update_data['coupon_allow_role_name'] == $roles['slug'])
                      <option selected="selected" value="{{ $roles['slug'] }}">{!! $roles['role_name'] !!}</option>
                    @else
                      <option value="{{ $roles['slug'] }}">{!! $roles['role_name'] !!}</option>
                    @endif
                  @endforeach
                @endif
              </select>
            </div>
          </div>
        </div>
      </div>
      
      {{--<div class="box box-solid">
        <div class="box-header with-border">
          <h3 class="box-title">{{ trans('admin.usage_limit') }}</h3>
        </div> 
        <div class="box-body">
          <div class="form-group">
            <label class="col-sm-4 control-label" for="inputLimitPerCoupon">{{ trans('admin.usage_limit_per_coupon') }}</label>
            <div class="col-sm-8">
              <input type="number" placeholder="{{ trans('admin.unlimited_usage') }}" class="form-control" name="usage_limit_per_coupon" id="usage_limit_per_coupon" value="{{ $coupon_update_data['usage_limit_per_coupon'] }}">
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
        {{--  <div class="form-group" style="display: none;">
            <label class="col-sm-3 control-label" for="inputUsageStartDate">{{ trans('admin.usage_range_start_date') }}</label>
            <div class="col-sm-9">                  
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" placeholder="{{ trans('admin.usage_range_start_date') }}" id="inputUsageStartDate" name="inputUsageStartDate" class="form-control" value="{{ $coupon_update_data['usage_range_start_date'] }}">
              </div>
            </div>
          </div> --}}
          <div class="form-group">
            <label class="col-sm-3 control-label" for="inputUsageEndDate">{{ trans('admin.usage_range_end_date') }}</label>
            <div class="col-sm-9">                  
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" placeholder="{{ trans('admin.usage_range_end_date') }}" id="inputUsageEndDate" name="inputUsageEndDate" class="form-control" value="{{ $coupon_update_data['usage_range_end_date'] }}">
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
                @if($coupon_update_data['post_status'] == true)
                <option selected="selected" value="1">{{ trans('admin.enable') }}</option>
                @else
                <option value="1">{{ trans('admin.enable') }}</option>
                @endif
                
                @if($coupon_update_data['post_status'] == false)
                <option selected="selected" value="0">{{ trans('admin.disable') }}</option>                  
                @else
                <option value="0">{{ trans('admin.disable') }}</option>                  
                @endif
                
              </select>                                         
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>  
@endsection