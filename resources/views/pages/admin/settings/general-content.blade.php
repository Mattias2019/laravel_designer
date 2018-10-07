@extends('layouts.admin.master')
@section('title', trans('admin.update_general_settings') .' < '. get_site_title())

@section('content')
@if($settings_data)
@include('pages-message.notify-msg-success') 
 
<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
  <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
  <input type="hidden" name="_settings_name" value="general">
  
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">{{ trans('admin.general_settings') }}</h3>
      <div class="box-tools pull-right">
        <button class="btn btn-primary pull-right" type="submit">{{ trans('admin.save') }}</button>
      </div>
    </div>
  </div>
  
<div class="box box-solid">
  <div class="row">
    <div class="col-md-12">
      <div class="box-body">
        <b><i>{{ trans('admin.general_options') }}</i></b><hr>
        <div class="form-group">
          <label class="col-sm-4 control-label" for="inputSiteTitle">{{ trans('admin.site_title') }}</label>
          <div class="col-sm-8">
            <input type="text" placeholder="{{ trans('admin.example_shopist') }}" id="inputSiteTitle" name="inputSiteTitle" class="form-control" value="{{ $settings_data['general_settings']['general_options']['site_title'] }}">
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4 control-label" for="inputEmailAddress">{{ trans('admin.email_address') }}</label>
          <div class="col-sm-8">
            <input type="text" placeholder="{{ trans('admin.email_address') }}" id="inputEmailAddress" name="inputEmailAddress" class="form-control" value="{{ $settings_data['general_settings']['general_options']['email_address'] }}">
          </div>
        </div>
        
        <div class="form-group">
          <label class="col-sm-4 control-label" for="inputRegistrationAllow">{{ trans('admin.user_registration_allow_status') }}</label>
          <div class="col-sm-8">
          @if($settings_data['general_settings']['general_options']['allow_registration_for_frontend'] == true)  
            <input type="checkbox" checked="checked" class="shopist-iCheck" name="inputEnableDisableFrontendRegistration" id="inputEnableDisableFrontendRegistration">            
          @else
            <input type="checkbox" class="shopist-iCheck" name="inputEnableDisableFrontendRegistration" id="inputEnableDisableFrontendRegistration">        
          @endif
          </div>
        </div>
        
        <div class="form-group">
          <label class="col-sm-4 control-label" for="inputDefaultRoleForSite">{{ trans('admin.default_role_for_site') }}</label>
          <div class="col-sm-8">
            <select class="form-control select2" name="inputDefaultRoleForSite" style="width: 100%;">
              @if(count($user_role_list_data)>0)
                @foreach($user_role_list_data as $row)
                  @if($row['slug'] == $settings_data['general_settings']['general_options']['default_role_slug_for_site'])
                    <option selected="selected" value="{{ $row['slug'] }}">{{ $row['role_name'] }}</option>
                  @else
                    <option value="{{ $row['slug'] }}">{{ $row['role_name'] }}</option>
                  @endif
                @endforeach
              @endif
            </select>                          
          </div>
        </div>
        
        <div class="form-group site-logo-panel">
          <label class="col-sm-4 control-label" for="inputUploadLogo">{{ trans('admin.site_logo') }}</label>
          <div class="col-sm-8">
            @if($settings_data['general_settings']['general_options']['site_logo'])
              <div class="site-logo-container">
                <div class="img-div"><img src="{{ get_image_url($settings_data['general_settings']['general_options']['site_logo']) }}" class="logo-image" alt=""/></div><br>
                <div class="btn-div"><button type="button" class="btn btn-default btn-sm remove-logo-image">{{ trans('admin.remove_image') }}</button></div>
              </div>
              <div class="no-logo-image" style="display:none;">
                <div class="img-div"><img src="{{ default_upload_sample_img_src() }}" class="logo-image" alt=""/></div><br>
                <div class="btn-div"><button data-toggle="modal" data-target="#uploadSiteLogo" type="button" class="btn btn-default btn-sm site-logo-uploader">{{ trans('admin.upload_image') }}</button></div>
              </div>
            @else
              <div class="site-logo-container" style="display:none;">
                <div class="img-div"><img src="" class="logo-image" alt=""/></div><br>
                <div class="btn-div"><button type="button" class="btn btn-default btn-sm remove-logo-image">{{ trans('admin.remove_image') }}</button></div>
              </div>
              <div class="no-logo-image">
                <div class="img-div"><img src="{{ default_upload_sample_img_src() }}" class="logo-image" alt=""/></div><br>
                <div class="btn-div"><button data-toggle="modal" data-target="#uploadSiteLogo" type="button" class="btn btn-default btn-sm site-logo-uploader">{{ trans('admin.upload_image') }}</button></div>
              </div>
            @endif
            
            
            <div class="modal fade" id="uploadSiteLogo" tabindex="-1" role="dialog" aria-labelledby="updater" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">✕</button>
                    <br>
                    <i class="icon-credit-card icon-7x"></i>
                    <p class="no-margin">{{ trans('admin.you_can_upload_1_image') }}</p>
                  </div>
                  <div class="modal-body">             
                    <div class="uploadform dropzone no-margin dz-clickable site-picture-uploader" id="site-picture-uploader" name="site-picture-uploader">
                      <div class="dz-default dz-message">
                        <span>{{ trans('admin.drop_your_cover_picture_here') }}</span>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default attachtopost" data-dismiss="modal">{{ trans('admin.close') }}</button>
                  </div>
                </div>
              </div>
            </div> 
            <input type="hidden" name="hf_site_picture" id="hf_site_picture" value="{{ $settings_data['general_settings']['general_options']['site_logo'] }}">
          </div>
        </div>
       
        <b><i>{{ trans('admin.taxes_options') }}</i></b><hr>
        <div class="form-group">
          <label class="col-sm-4 control-label" for="inputTaxesOptions">{{ trans('admin.taxes_options') }}</label>
          <div class="col-sm-8">
            <select class="form-control select2" name="inputTaxesOptions" style="width: 100%;">
              @if($settings_data['general_settings']['taxes_options']['enable_status'] == 1)
              <option selected="selected" value="1">{{ trans('admin.enable') }}</option>
              @else
              <option value="1">{{ trans('admin.enable') }}</option>
              @endif
              
              @if($settings_data['general_settings']['taxes_options']['enable_status'] == 0)
              <option selected="selected" value="0">{{ trans('admin.disable') }}</option>
              @else
              <option value="0">{{ trans('admin.disable') }}</option>
              @endif
            </select>                                        
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4 control-label" for="inputApplyTaxes">{{ trans('admin.apply_tax_on') }}</label>
          <div class="col-sm-8">
            <select class="form-control select2" name="inputApplyTaxes" style="width: 100%;">
              @if($settings_data['general_settings']['taxes_options']['apply_tax_for'] == 'per_product')
                <option selected="selected" value="per_product">{{ trans('admin.per_product') }}</option>
              @else
                <option value="per_product">{{ trans('admin.per_product') }}</option>
              @endif
              
              @if($settings_data['general_settings']['taxes_options']['apply_tax_for'] == 'order_total')
                <option selected="selected" value="order_total">{{ trans('admin.order_total') }}</option>
              @else
                <option value="order_total">{{ trans('admin.order_total') }}</option>
              @endif
            </select>
          </div>
        </div>  
        <div class="form-group">
          <label class="col-sm-4 control-label" for="inputTaxAmount">{{ trans('admin.tax_amount') }}</label>
          <div class="col-sm-8">
            <input type="number" placeholder="{{ trans('admin.tax_amount') }}" min="0" step="any" id="inputTaxAmount" name="inputTaxAmount" class="form-control" value="{{ $settings_data['general_settings']['taxes_options']['tax_amount'] }}">%
          </div>
        </div>
        
        <b><i>{{ trans('admin.checkout_options') }}</i></b><hr>
        <div class="form-group">
          <label class="col-sm-4 control-label" for="inputGuestUserAllow"></label>
          <div class="col-sm-8">
          @if($settings_data['general_settings']['checkout_options']['enable_guest_user'] == true)  
            <input type="checkbox" checked="checked" class="shopist-iCheck" name="inputEnableGuestUser" id="inputEnableGuestUser">            
          @else
            <input type="checkbox" class="shopist-iCheck" name="inputEnableGuestUser" id="inputEnableGuestUser">        
          @endif
          &nbsp; {{ trans('admin.allow_guest_user_at_checkout') }}
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4 control-label" for="inputLoginUserAllow"></label>
          <div class="col-sm-8">
          @if($settings_data['general_settings']['checkout_options']['enable_login_user'] == true)  
            <input type="checkbox" checked="checked" class="shopist-iCheck" name="inputEnableLoginUser" id="inputEnableLoginUser">            
          @else
            <input type="checkbox" class="shopist-iCheck" name="inputEnableLoginUser" id="inputEnableLoginUser">        
          @endif
          &nbsp; {{ trans('admin.allow_login_user_at_checkout') }}
          </div>
        </div>
        <br>
        
        <b><i>{!! trans('admin.downloadable_products_options') !!}</i></b><hr>
        <div class="form-group">
          <label class="col-sm-4 control-label" for="inputAccessRestriction"></label>
          <div class="col-sm-8">
          @if($settings_data['general_settings']['downloadable_products_options']['login_restriction'] == true)  
            <input type="checkbox" checked="checked" class="shopist-iCheck" name="inputLoginRestriction" id="inputLoginRestriction">            
          @else
            <input type="checkbox" class="shopist-iCheck" name="inputLoginRestriction" id="inputLoginRestriction">        
          @endif
          &nbsp; {!! trans('admin.downloads_require_login_label') !!}
          </div>
        </div>
        
        <div class="form-group">
          <label class="col-sm-4 control-label" for="inputGrantAccessThankYouPage"></label>
          <div class="col-sm-8">
          @if($settings_data['general_settings']['downloadable_products_options']['grant_access_from_thankyou_page'] == true)  
            <input type="checkbox" checked="checked" class="shopist-iCheck" name="inputGrantAccessOrderDetails" id="inputGrantAccessOrderDetails">            
          @else
            <input type="checkbox" class="shopist-iCheck" name="inputGrantAccessOrderDetails" id="inputGrantAccessOrderDetails">        
          @endif
          &nbsp; {!! trans('admin.grant_access_from_order_thank_you_label') !!}
          </div>
        </div>
        
        <div class="form-group" style="display:none;">
          <label class="col-sm-4 control-label" for="inputGrantAccessEmail"></label>
          <div class="col-sm-8">
          @if($settings_data['general_settings']['downloadable_products_options']['grant_access_from_email'] == true)  
            <input type="checkbox" checked="checked" class="shopist-iCheck" name="inputGrantAccessEmail" id="inputGrantAccessEmail">            
          @else
            <input type="checkbox" class="shopist-iCheck" name="inputGrantAccessEmail" id="inputGrantAccessEmail">        
          @endif
          &nbsp; {!! trans('admin.grant_access_from_email_label') !!}
          </div>
        </div>
        <br>
        
        <b><i>{{ trans('admin.recaptcha_label') }}</i></b><hr>
        <div class="form-group">
          <label class="col-sm-4 control-label" for="inputRecaptchaAllowForAdminLogin"></label>
          <div class="col-sm-8">
          @if($settings_data['general_settings']['recaptcha_options']['enable_recaptcha_for_admin_login'] == true)  
            <input type="checkbox" checked="checked" class="shopist-iCheck" name="inputEnableForAdmin" id="inputEnableForAdmin">            
          @else
            <input type="checkbox" class="shopist-iCheck" name="inputEnableForAdmin" id="inputEnableForAdmin">        
          @endif
          &nbsp; {{ trans('admin.recaptcha_for_admin_label') }}
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4 control-label" for="inputRecaptchaAllowForUserLogin"></label>
          <div class="col-sm-8">
          @if($settings_data['general_settings']['recaptcha_options']['enable_recaptcha_for_user_login'] == true)  
            <input type="checkbox" checked="checked" class="shopist-iCheck" name="inputEnableForUser" id="inputEnableForUser">            
          @else
            <input type="checkbox" class="shopist-iCheck" name="inputEnableForUser" id="inputEnableForUser">        
          @endif
          &nbsp; {{ trans('admin.recaptcha_for_user_label') }}
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4 control-label" for="inputRecaptchaAllowForUserReg"></label>
          <div class="col-sm-8">
          @if($settings_data['general_settings']['recaptcha_options']['enable_recaptcha_for_user_registration'] == true)  
            <input type="checkbox" checked="checked" class="shopist-iCheck" name="inputEnableForUserReg" id="inputEnableForUserReg">            
          @else
            <input type="checkbox" class="shopist-iCheck" name="inputEnableForUserReg" id="inputEnableForUserReg">        
          @endif
          &nbsp; {{ trans('admin.recaptcha_for_user_reg_label') }}
          </div>
        </div>
<!--        <div class="form-group">
          <label class="col-sm-4 control-label" for="inputRecaptchaAllowForVendorLogin"></label>
          <div class="col-sm-8">
          <input type="checkbox" checked="checked" class="shopist-iCheck" name="inputEnableForVendor" id="inputEnableForVendor">
          </div>
        </div>-->
        <div class="form-group">
          <label class="col-sm-4 control-label" for="inputRecaptchaAllowForVendorReg"></label>
          <div class="col-sm-8">
          @if(isset($settings_data['general_settings']['recaptcha_options']['enable_recaptcha_for_vendor_registration']) && $settings_data['general_settings']['recaptcha_options']['enable_recaptcha_for_vendor_registration'] == true)  
            <input type="checkbox" checked="checked" class="shopist-iCheck" name="inputEnableForVendorReg" id="inputEnableForVendorReg">            
          @else
            <input type="checkbox" class="shopist-iCheck" name="inputEnableForVendorReg" id="inputEnableForVendorReg">        
          @endif
          &nbsp; {{ trans('admin.recaptcha_for_vendor_reg_label') }}
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4 control-label" for="inputRecaptchaSecretKey">{!! trans('admin.recaptcha_secret_key_label') !!}</label>
          <div class="col-sm-8">
              <input type="text" name="inputRecaptchaSecretKey" id="inputRecaptchaSecretKey" class="form-control" placeholder="{{ trans('admin.recaptcha_secret_key_label') }}" value="{{ $settings_data['general_settings']['recaptcha_options']['recaptcha_secret_key'] }}">
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4 control-label" for="inputRecaptchaSiteKey">{!! trans('admin.recaptcha_site_key_label') !!}</label>
          <div class="col-sm-8">
            <input type="text" name="inputRecaptchaSiteKey" id="inputRecaptchaSiteKey" class="form-control" placeholder="{{ trans('admin.recaptcha_site_key_label') }}" value="{{ $settings_data['general_settings']['recaptcha_options']['recaptcha_site_key'] }}">
          </div>
        </div>
        <br>
        <b><i>{{ trans('admin.nexmo_config_option_label') }}</i></b><hr>
        <div class="form-group">
          <label class="col-sm-4 control-label" for="inputNexmoEnable"></label>
          <div class="col-sm-8">
          @if($settings_data['general_settings']['nexmo_config_option']['enable_nexmo_option'] == true)  
            <input type="checkbox" checked="checked" class="shopist-iCheck" name="inputEnableNexmo" id="inputEnableNexmo">            
          @else
            <input type="checkbox" class="shopist-iCheck" name="inputEnableNexmo" id="inputEnableNexmo">        
          @endif
          &nbsp; {{ trans('admin.nexmo_enable_label') }}
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4 control-label" for="inputNexmoKey">{!! trans('admin.nexmo_key_label') !!}</label>
          <div class="col-sm-8">
            <input type="text" name="inputNexmoKey" id="inputNexmoKey" class="form-control" placeholder="{{ trans('admin.nexmo_key_label') }}" value="{{ $settings_data['general_settings']['nexmo_config_option']['nexmo_key'] }}">
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4 control-label" for="inputNexmoSecret">{!! trans('admin.nexmo_secret_label') !!}</label>
          <div class="col-sm-8">
            <input type="text" name="inputNexmoSecret" id="inputNexmoSecret" class="form-control" placeholder="{{ trans('admin.nexmo_secret_label') }}" value="{{ $settings_data['general_settings']['nexmo_config_option']['nexmo_secret'] }}">
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4 control-label" for="inputNexmoNumberTo">{!! trans('admin.nexmo_number_to_label') !!}</label>
          <div class="col-sm-8">
            <input type="text" name="inputNexmoNumberTo" id="inputNexmoNumberTo" class="form-control" placeholder="{{ trans('admin.nexmo_number_to_label') }}" value="{{ $settings_data['general_settings']['nexmo_config_option']['number_to'] }}">
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4 control-label" for="inputNexmoNumberFrom">{!! trans('admin.nexmo_number_from_label') !!}</label>
          <div class="col-sm-8">
            <input type="text" name="inputNexmoNumberFrom" id="inputNexmoNumberFrom" class="form-control" placeholder="{{ trans('admin.nexmo_number_from_label') }}" value="{{ $settings_data['general_settings']['nexmo_config_option']['number_from'] }}">
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4 control-label" for="inputNexmoSendingMessage">{!! trans('admin.nexmo_sending_msg_label') !!}</label>
          <div class="col-sm-8">
            <textarea name="inputNexmoSendingMessage" id="inputNexmoSendingMessage" class="form-control" placeholder="{{ trans('admin.nexmo_sending_msg_label') }}">{{ $settings_data['general_settings']['nexmo_config_option']['message'] }}</textarea>  
          </div>
        </div>
        <br>
        <b><i>{{ trans('admin.currency_converter_option') }}</i></b><hr>
        <div class="form-group">
          <label class="col-sm-4 control-label" for="inputCurrencyConverterAccessKey">{{ trans('admin.fixer_access_key') }}</label>
          <div class="col-sm-8">
            <input type="text" name="inputCurrencyConverterAccessKey" id="inputCurrencyConverterAccessKey" class="form-control" placeholder="{{ trans('admin.fixer_access_key') }}" value="{{ $settings_data['general_settings']['fixer_config_option']['fixer_api_access_key'] }}">
            <span><i>Get API access key from <a href="https://fixer.io/" target="_blank">Fixer</a></i></span>
          </div>
        </div>
        <br>
        <b><i>{{ trans('admin.currency_options') }}</i></b><hr>
        <div class="form-group">
          <label class="col-sm-4 control-label" for="inputCurrency">{{ trans('admin.default_currency') }}</label>
          <div class="col-sm-8">
            <select class="form-control select2" name="inputCurrency" style="width: 100%;"> 
              @if(count(get_available_currency_name())>0)
                @foreach(get_available_currency_name() as $currency_code => $currency_name)
                  @if($settings_data['general_settings']['currency_options']['currency_name'] == $currency_code)
                    <option selected="selected" value="{{ $currency_code }}">{{ $currency_name }}</option>
                  @else  
                    <option value="{{ $currency_code }}">{{ $currency_name }}</option>
                  @endif
                @endforeach
              @endif
            </select>
          </div>
        </div>  
        <div class="form-group">
          <label class="col-sm-4 control-label" for="inputCurrencyPosition">{{ trans('admin.currency_position') }}</label>
          <div class="col-sm-8">
            <select class="form-control select2" name="inputCurrencyPosition" style="width: 100%;">
              @if($settings_data['general_settings']['currency_options']['currency_position'] == 'left')
              
                <option selected="selected" value="left">{{ trans('admin.left') }}({!! get_current_currency_symbol().'99.99' !!})</option>
              
              @else
              
                <option value="left">{{ trans('admin.left') }}({!! get_current_currency_symbol().'99.99' !!})</option>
              
              @endif
              
              @if($settings_data['general_settings']['currency_options']['currency_position'] == 'right')
              
                <option selected="selected" value="right">{{ trans('admin.right') }}({!! '99.99'.get_current_currency_symbol() !!})</option>
              
              @else
              
                <option value="right">{{ trans('admin.right') }}({!! '99.99'.get_current_currency_symbol() !!})</option>
              
              @endif
              
              @if($settings_data['general_settings']['currency_options']['currency_position'] == 'left_with_space')
              
                <option selected="selected" value="left_with_space">{{ trans('admin.left_with_space') }}({!! get_current_currency_symbol().' 99.99' !!})</option>
              
              @else
              
                <option value="left_with_space">{{ trans('admin.left_with_space') }}({!! get_current_currency_symbol().' 99.99' !!})</option>
              
              @endif
              
              @if($settings_data['general_settings']['currency_options']['currency_position'] == 'right_with_space')
              
                <option selected="selected" value="right_with_space">{{ trans('admin.right_with_space') }}({!! '99.99 '.get_current_currency_symbol() !!})</option>
              
              @else
              
                <option value="right_with_space">{{ trans('admin.right_with_space') }}({!! '99.99 '.get_current_currency_symbol() !!}) </option>
              
              @endif
            </select>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4 control-label" for="inputThousandSeparator">{{ trans('admin.thousand_separator') }}</label>
          <div class="col-sm-8">
            <input type="text" placeholder="{{ trans('admin.thousand_separator_example') }}" id="inputThousandSeparator" name="inputThousandSeparator" class="form-control" value="{{ $settings_data['general_settings']['currency_options']['thousand_separator'] }}">
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4 control-label" for="inputDecimalSeparator">{{ trans('admin.decimal_separator') }}</label>
          <div class="col-sm-8">
            <input type="text" placeholder="{{ trans('admin.decimal_separator_example') }}" id="inputDecimalSeparator" name="inputDecimalSeparator" class="form-control" value="{{ $settings_data['general_settings']['currency_options']['decimal_separator'] }}">
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4 control-label" for="inputNumberofDecimals">{{ trans('admin.number_of_decimals') }}</label>
          <div class="col-sm-8">
            <input type="number" placeholder="{{ trans('admin.number_of_decimals_example') }}" id="inputNumberofDecimals" name="inputNumberofDecimals" class="form-control" value="{{ $settings_data['general_settings']['currency_options']['number_of_decimals'] }}">
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4 control-label" for="inputFrontendCurrency">{{ trans('admin.frontend_currency') }}</label>
          <div class="col-sm-8">
            <div class="row">
              <?php $count = 1;?>  
              @if(count(get_available_currency_name())>0)
                @foreach(get_available_currency_name() as $currency_code => $currency_name)
                
                <?php if($count == 1){?>
                <div class="col-sm-12 margin-bottom-extra">
                <?php }?>  
                    
                  @if($settings_data['general_settings']['currency_options']['frontend_currency'] && in_array($currency_code, $settings_data['general_settings']['currency_options']['frontend_currency']))
                  <div class="col-sm-6"><input type="checkbox" class="shopist-iCheck" checked="checked" name="selected_currency_for_frontend[]" id="selected_currency_for_frontend" value="{{ $currency_code }}">&nbsp;{{ $currency_name }}</div>
                  @else
                    <div class="col-sm-6"><input type="checkbox" class="shopist-iCheck" name="selected_currency_for_frontend[]" id="selected_currency_for_frontend" value="{{ $currency_code }}">&nbsp;{{ $currency_name }}</div>
                  @endif
                  
                <?php if($count == 2){?>
                </div>
                <?php } $count ++ ; if($count == 3){$count = 1;}?>   
                
                @endforeach
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</form>

@endif
@endsection