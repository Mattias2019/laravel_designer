@extends('layouts.frontend.master')
@section('title', trans('frontend.shopist_checkout') .' < '. get_site_title() )

@section('content')
  <div class="extra-margin-top-for-content"></div>
  <div id="checkout_page" class="container">
    <div class="row">
      @if( Cart::count() >0 )
      <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}"> 
        <div class="col-md-10 col-sm-12 col-centered">    
          <div class="checkout-content">
            @if (count($errors) > 0)
              <div class="alert alert-danger">
                <strong>{!! trans('validation.whoops') !!}</strong> {!! trans('validation.input_error') !!}<br /><br />
                <ul>
                  @foreach ($errors->all() as $error)
                    <li>{!! $error !!}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <div class="progress">
              <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            
            <div id="cart_summary" class="step well">
              <h2 class="step-title">{!! trans('frontend.shopping_cart_summary_label') !!}</h2><hr>
              <div class="shopping-cart-summary-content">
                <ul class="cart-data">
                  <li class="row list-inline columnCaptions">
                    <div class="header-items">{!! trans('frontend.cart_item') !!}</div>
                    <div class="header-price">{!! trans('frontend.price') !!}</div>
                    <div class="header-qty">{!! trans('frontend.quantity') !!}</div>
                    <div class="header-line-total last-total">{!! trans('frontend.total') !!}</div>
                  </li>
                  @foreach(Cart::items() as $index => $items)
                    <li class="row items-inline">
                      <div class="itemName">
                        @if($items->img_src)
                          <div class="product-img">
                            <a href="{{ route('details-page', get_product_slug($items->id)) }}">
                              <img src="{{ get_image_url($items->img_src) }}" alt="product">
                            </a>
                          </div>
                        @else
                          <div class="product-img">
                            <a href="{{ route('details-page', get_product_slug($items->id)) }}">
                              <img src="{{ default_placeholder_img_src() }}" alt="product">
                            </a>
                          </div>
                        @endif
                        <div class="item-name">
                          <a href="{{ route('details-page', get_product_slug($items->id)) }}">{!! $items->name !!}</a>
                          <?php $count = 1; ?>
                          @if(count($items->options) > 0)
                          <p>
                            @foreach($items->options as $key => $val)
                              @if($count == count($items->options))
                                {!! $key .' &#8658; '. $val !!}
                              @else
                                {!! $key .' &#8658; '. $val. ' , ' !!}
                              @endif
                              <?php $count ++ ; ?>
                            @endforeach
                          </p>
                          @endif

                          @if(get_product_type($items->id) === 'customizable_product')
                            @if($items->acces_token)
                              @if(count(get_customize_images_by_access_token($items->acces_token))>0)
                                <button class="btn btn-block btn-xs view-customize-images" data-images="{{ json_encode( get_customize_images_by_access_token($items->acces_token) ) }}">{{ trans('frontend.design_images') }}</button>
                              @endif
                            @endif
                          @endif
                          
                          @if( count(get_vendor_details_by_product_id($items->product_id)) >0 )
                          <p class="vendor-title"><strong>{!! trans('frontend.vendor_label') !!}</strong> : {!! get_vendor_name_by_product_id( $items->product_id) !!}</p>
                          @endif
                        </div>
                      </div>  

                      <div class="price">{!! price_html( get_product_price_html_by_filter($items->price) ) !!}</div>
                      <div class="quantity"><input type="number" class="form-control cart_quantity_input" name="cart_quantity[{{ $index }}]" value="{{ $items->quantity }}" min="1"></div>
                      <div class="price line-total last-total">{!! price_html(  get_product_price_html_by_filter(Cart::getRowPrice($items->quantity, $items->price) )) !!}</div>
                      <div class="popbtn"><a class="cart_quantity_delete delete-extra-padding" href="{{ route('removed-item-from-cart', $index)}}"><i class="fa fa-close"></i></a></div>
                    </li>
                  @endforeach
                  
                  <li class="row cart-button-main">
                    <div class="apply-coupon">
                      <input type="text" class="form-control" id="apply_coupon_code" name="apply_coupon" placeholder="{{ trans('frontend.coupon_code_placeholder_text') }}">
                      <button class="btn btn-primary" name="apply_coupon_post" id="apply_coupon_post">{!! trans('frontend.apply_coupon_label') !!}</button>
                      <div class="clearfix visible-xs"></div>
                    </div>
                    <div class="btn-cart-action">
                      <button class="btn btn-primary empty" type="submit" name="empty_cart" value="empty_cart">{{ trans('frontend.empty_cart') }}</button>
                      <button class="btn btn-primary update" type="submit" name="update_cart" value="update_cart">{{ trans('frontend.update_cart') }}</button>
                    </div>
                  </li>
                  
                  @include('pages.ajax-pages.cart-total-html')
                </ul>
              </div>
            </div>
            
            @if($_settings_data['general_settings']['checkout_options']['enable_guest_user'] == true && $_settings_data['general_settings']['checkout_options']['enable_login_user'] == true)
            <div id="user_mode" class="step well">
              <h2 class="step-title">{!! trans('frontend.user_mode_label') !!}</h2><hr>  
              <div class="checkout-process-user-mode">
                <ul class="nav">
                  <li>
                      <label><input type="radio" class="shopist-iCheck" name="user_checkout_complete_type" value="guest">&nbsp; {!! trans('frontend.guest_checkout') !!}</label>
                  </li>
                  <li>
                    <label><input type="radio" class="shopist-iCheck" name="user_checkout_complete_type" value="login_user">&nbsp; {!! trans('frontend.login_user_checkout') !!}</label>
                  </li>
                </ul>
              </div>
            </div>
            @endif
            
            @if($_settings_data['general_settings']['checkout_options']['enable_guest_user'] == true || ($_settings_data['general_settings']['checkout_options']['enable_guest_user'] == false && $_settings_data['general_settings']['checkout_options']['enable_login_user'] == false))
            <div id="guest_user_address" class="step well">
              <h2 class="step-title">{!! trans('frontend.checkout_address_label') !!}</h2><hr> 
              <div class="user-address-content">
                <div class="address-information clearfix">
                  <div class="address-content-sub">
                    <h3 class="page-subheading">{!! trans('frontend.billing_address') !!}</h3><hr>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <div class="col-sm-4">
                            <label class="control-label" for="inputAccountTitle">{{ trans('frontend.account_title') }}</label>
                          </div>
                          <div class="col-sm-8">
                            <input type="text" class="form-control" placeholder="{{ trans('frontend.title') }}" name="account_bill_title" id="account_bill_title" value="{{ old('account_bill_title') }}">
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="col-sm-4">
                            <label class="control-label" for="inputAccountCompanyName">{{ trans('frontend.checkout_company_name_label') }}</label>
                          </div>
                          <div class="col-sm-8">
                            <input type="text" class="form-control" placeholder="{{ trans('frontend.company_name') }}" name="account_bill_company_name" id="account_bill_company_name" value="{{ old('account_bill_company_name') }}">
                          </div>
                        </div>

                        <div class="form-group required">
                          <div class="col-sm-4">
                            <label class="control-label" for="inputAccountFirstName">{{ trans('frontend.account_first_name') }}</label>
                          </div>
                          <div class="col-sm-8">
                            <input type="text" class="form-control" placeholder="{{ trans('frontend.first_name') }}" name="account_bill_first_name" id="account_bill_first_name" value="{{ old('account_bill_first_name') }}">
                          </div>
                        </div>

                        <div class="form-group required">
                          <div class="col-sm-4">
                            <label class="control-label" for="inputAccountLastName">{{ trans('frontend.account_last_name') }}</label>
                          </div>
                          <div class="col-sm-8">
                            <input type="text" class="form-control" placeholder="{{ trans('frontend.last_name') }}" name="account_bill_last_name" id="account_bill_last_name" value="{{ old('account_bill_last_name') }}">
                          </div>
                        </div>

                        <div class="form-group required">
                          <div class="col-sm-4">
                            <label class="control-label" for="inputAccountEmailAddress">{{ trans('frontend.account_email') }}</label>
                          </div>
                          <div class="col-sm-8">
                            <input type="email" class="form-control" placeholder="{{ trans('frontend.email') }}" name="account_bill_email_address" id="account_bill_email_address" value="{{ old('account_bill_email_address') }}">
                          </div>
                        </div>

                        <div class="form-group required">
                          <div class="col-sm-4">
                            <label class="control-label" for="inputAccountPhoneNumber">{{ trans('frontend.account_phone_number') }}</label>
                          </div>
                          <div class="col-sm-8">
                            <input type="number" class="form-control" placeholder="{{ trans('frontend.phone') }}" name="account_bill_phone_number" id="account_bill_phone_number" value="{{ old('account_bill_phone_number') }}">
                          </div>
                        </div>

                        <div class="form-group required">
                          <div class="col-sm-4">
                            <label class="control-label" for="inputAccountSelectCountry">{{ trans('frontend.checkout_select_country_label') }}</label>
                          </div>
                          <div class="col-sm-8">
                            <select class="form-control" id="account_bill_select_country" name="account_bill_select_country">
                              <option value=""> {{ trans('frontend.select_country') }} </option>
                              @foreach(get_country_list() as $key => $val)
                                @if(old('account_bill_select_country') == $key)
                                  <option selected value="{{ $key }}"> {!! $val !!}</option>
                                @else
                                  <option value="{{ $key }}"> {!! $val !!}</option>
                                @endif
                              @endforeach
                             </select>
                          </div>
                        </div>

                        <div class="form-group required">
                          <div class="col-sm-4">
                            <label class="control-label" for="inputAccountAddressLine1">{{ trans('frontend.account_address_line_1') }}</label>
                          </div>
                          <div class="col-sm-8">
                            <textarea class="form-control" id="account_bill_adddress_line_1" name="account_bill_adddress_line_1" placeholder="{{ trans('frontend.address_line_1') }}">{{ old('account_bill_adddress_line_1') }}</textarea>
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="col-sm-4">
                            <label class="control-label" for="inputAccountAddressLine2">{{ trans('frontend.account_address_line_2') }}</label>
                          </div>
                          <div class="col-sm-8">
                            <textarea class="form-control" id="account_bill_adddress_line_2" name="account_bill_adddress_line_2" placeholder="{{ trans('frontend.address_line_2') }}">{{ old('account_bill_adddress_line_2') }}</textarea>
                          </div>
                        </div>

                        <div class="form-group required">
                          <div class="col-sm-4">
                            <label class="control-label" for="inputAccountTownCity">{{ trans('frontend.account_address_town_city') }}</label>
                          </div>
                          <div class="col-sm-8">
                            <input type="text" class="form-control" placeholder="{{ trans('frontend.town_city') }}" name="account_bill_town_or_city" id="account_bill_town_or_city" value="{{ old('account_bill_town_or_city') }}">
                          </div>
                        </div>

                        <div class="form-group required">
                          <div class="col-sm-4">
                            <label class="control-label" for="inputAccountZipPostalCode">{{ trans('frontend.checkout_zip_postal_label') }}</label>
                          </div>
                          <div class="col-sm-8">
                            <input type="number" class="form-control" placeholder="{{ trans('frontend.zip_postal_code') }}" name="account_bill_zip_or_postal_code" id="account_bill_zip_or_postal_code" value="{{ old('account_bill_zip_or_postal_code') }}">
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="col-sm-4">
                            <label class="control-label" for="inputAccountFaxNumber">{{ trans('frontend.account_fax_number') }}</label>
                          </div>
                          <div class="col-sm-8">
                            <input type="number" class="form-control" placeholder="{{ trans('frontend.fax') }}" name="account_bill_fax_number" id="account_bill_fax_number" value="{{ old('account_bill_fax_number') }}">
                          </div>
                        </div>  
                      </div>
                    </div>
                  </div>
                  <div class="address-content-sub">
                    <h3 class="page-subheading">{!! trans('frontend.shipping_address') !!}</h3><hr>
                    <input type="checkbox" name="different_shipping_address" id="different_shipping_address" class="shopist-iCheck" value="different_address"> {{ trans('frontend.different_shipping_label') }}
                    <div class="row different-shipping-address">
                      <div class="col-md-12">
                        <div class="form-group">
                          <div class="col-sm-4">
                            <label class="control-label" for="inputAccountTitle">{{ trans('frontend.account_title') }}</label>
                          </div>
                          <div class="col-sm-8">
                            <input type="text" class="form-control" placeholder="{{ trans('frontend.title') }}" name="account_shipping_title" id="account_shipping_title" value="{{ old('account_shipping_title') }}">
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="col-sm-4">
                            <label class="control-label" for="inputAccountCompanyName">{{ trans('frontend.checkout_company_name_label') }}</label>
                          </div>
                          <div class="col-sm-8">
                            <input type="text" class="form-control" placeholder="{{ trans('frontend.company_name') }}" name="account_shipping_company_name" id="account_shipping_company_name" value="{{ old('account_shipping_company_name') }}">
                          </div>
                        </div>

                        <div class="form-group required">
                          <div class="col-sm-4">
                            <label class="control-label" for="inputAccountFirstName">{{ trans('frontend.account_first_name') }}</label>
                          </div>
                          <div class="col-sm-8">
                            <input type="text" class="form-control" placeholder="{{ trans('frontend.first_name') }}" name="account_shipping_first_name" id="account_shipping_first_name" value="{{ old('account_shipping_first_name') }}">
                          </div>
                        </div>

                        <div class="form-group required">
                          <div class="col-sm-4">
                            <label class="control-label" for="inputAccountLastName">{{ trans('frontend.account_last_name') }}</label>
                          </div>
                          <div class="col-sm-8">
                            <input type="text" class="form-control" placeholder="{{ trans('frontend.last_name') }}" name="account_shipping_last_name" id="account_shipping_last_name" value="{{ old('account_shipping_last_name') }}">
                          </div>
                        </div>

                        <div class="form-group required">
                          <div class="col-sm-4">
                            <label class="control-label" for="inputAccountEmailAddress">{{ trans('frontend.account_email') }}</label>
                          </div>
                          <div class="col-sm-8">
                            <input type="email" class="form-control" placeholder="{{ trans('frontend.email') }}" name="account_shipping_email_address" id="account_shipping_email_address" value="{{ old('account_shipping_email_address') }}">
                          </div>
                        </div>

                        <div class="form-group required">
                          <div class="col-sm-4">
                            <label class="control-label" for="inputAccountPhoneNumber">{{ trans('frontend.account_phone_number') }}</label>
                          </div>
                          <div class="col-sm-8">
                            <input type="number" class="form-control" placeholder="{{ trans('frontend.phone') }}" name="account_shipping_phone_number" id="account_shipping_phone_number" value="{{ old('account_shipping_phone_number') }}">
                          </div>
                        </div>

                        <div class="form-group required">
                          <div class="col-sm-4">
                            <label class="control-label" for="inputAccountSelectCountry">{{ trans('frontend.checkout_select_country_label') }}</label>
                          </div>
                          <div class="col-sm-8">
                            <select class="form-control" id="account_shipping_select_country" name="account_shipping_select_country">
                              <option value=""> {{ trans('frontend.select_country') }} </option>
                              @foreach(get_country_list() as $key => $val)
                                @if(old('account_bill_select_country') == $key)
                                  <option selected value="{{ $key }}"> {!! $val !!}</option>
                                @else
                                  <option value="{{ $key }}"> {!! $val !!}</option>
                                @endif
                              @endforeach
                             </select>
                          </div>
                        </div>

                        <div class="form-group required">
                          <div class="col-sm-4">
                            <label class="control-label" for="inputAccountAddressLine1">{{ trans('frontend.account_address_line_1') }}</label>
                          </div>
                          <div class="col-sm-8">
                            <textarea class="form-control" id="account_shipping_adddress_line_1" name="account_shipping_adddress_line_1" placeholder="{{ trans('frontend.address_line_1') }}">{{ old('account_shipping_adddress_line_1') }}</textarea>
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="col-sm-4">
                            <label class="control-label" for="inputAccountAddressLine2">{{ trans('frontend.account_address_line_2') }}</label>
                          </div>
                          <div class="col-sm-8">
                            <textarea class="form-control" id="account_shipping_adddress_line_2" name="account_shipping_adddress_line_2" placeholder="{{ trans('frontend.address_line_2') }}">{{ old('account_shipping_adddress_line_2') }}</textarea>
                          </div>
                        </div>

                        <div class="form-group required">
                          <div class="col-sm-4">
                            <label class="control-label" for="inputAccountTownCity">{{ trans('frontend.account_address_town_city') }}</label>
                          </div>
                          <div class="col-sm-8">
                            <input type="text" class="form-control" placeholder="{{ trans('frontend.town_city') }}" name="account_shipping_town_or_city" id="account_shipping_town_or_city" value="{{ old('account_shipping_town_or_city') }}">
                          </div>
                        </div>

                        <div class="form-group required">
                          <div class="col-sm-4">
                            <label class="control-label" for="inputAccountZipPostalCode">{{ trans('frontend.checkout_zip_postal_label') }}</label>
                          </div>
                          <div class="col-sm-8">
                            <input type="number" class="form-control" placeholder="{{ trans('frontend.zip_postal_code') }}" name="account_shipping_zip_or_postal_code" id="account_shipping_zip_or_postal_code" value="{{ old('account_shipping_zip_or_postal_code') }}">
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="col-sm-4">
                            <label class="control-label" for="inputAccountFaxNumber">{{ trans('frontend.account_fax_number') }}</label>
                          </div>
                          <div class="col-sm-8">
                            <input type="number" class="form-control" placeholder="{{ trans('frontend.fax') }}" name="account_shipping_fax_number" id="account_shipping_fax_number" value="{{ old('account_shipping_fax_number') }}">
                          </div>
                        </div>

                      </div>
                    </div>
                  </div>
                </div>  
              </div>
            </div>
            @endif
            
            @if($_settings_data['general_settings']['checkout_options']['enable_login_user'] == true && $is_user_login == false)
            <div id="authentication" class="step well">
              <h2 class="step-title">{!! trans('frontend.authentication_label') !!}</h2><hr>  
              <div class="user-login-content">
                <div class="login-information clearfix">
                  <div class="login-content-sub">
                    <h3 class="page-subheading">{!! trans('frontend.create_an_account_label') !!}</h3>
                    <div class="form_content">
                      <p>{!! trans('frontend.no_user_account_msg') !!}</p>
                      <a class="btn btn-primary" href="{{ route('user-registration-page') }}">{!! trans('frontend.create_account_label') !!}</a>
                    </div>
                  </div>
                  <div class="login-content-sub">
                    <h3 class="page-subheading">{!! trans('frontend.already_registered_label') !!}</h3>
                    <div class="form_content">
                      <p>{!! trans('frontend.has_user_account_msg') !!}</p>
                      <a class="btn btn-primary" href="{{ route('user-login-page') }}">{!! trans('frontend.signin_account_label') !!}</a>
                    </div>
                  </div>
                </div>  
              </div>
            </div>
            @endif
            
            @if($_settings_data['general_settings']['checkout_options']['enable_login_user'] == true && $is_user_login == true)
            <div id="login_user_address" class="step well">
              <h2 class="step-title">{!! trans('frontend.checkout_address_label') !!}</h2><hr> 
              <div class="text-right">
                @if(!empty($login_user_account_data) && !empty($login_user_account_data->address_details))
                  <a href="{{ route('my-address-edit-page') }}" class="btn btn-primary btn-sm">{{ trans('frontend.edit_address') }}</a>
                @else
                  <a href="{{ route('my-address-add-page') }}" class="btn btn-primary btn-sm">{{ trans('frontend.add_address') }}</a>
                @endif
              </div>
              <br>
              <div class="user-address-content">
                <div class="address-information clearfix">
                  <div class="address-content-sub">
                    <h3 class="page-subheading">{!! trans('frontend.billing_address') !!}</h3><br>
                    @if(!empty($login_user_account_data) && !empty($login_user_account_data->address_details))
                    <p>{!! $login_user_account_data->address_details->account_bill_first_name .' '. $login_user_account_data->address_details->account_bill_last_name !!}</p>

                    @if($login_user_account_data->address_details->account_bill_company_name)
                      <p><strong>{{ trans('admin.company') }}:</strong> {!! $login_user_account_data->address_details->account_bill_company_name !!}</p>
                    @endif

                    <p><strong>{{ trans('admin.address_1') }}:</strong> {!! $login_user_account_data->address_details->account_bill_adddress_line_1 !!}</p>

                    @if($login_user_account_data->address_details->account_bill_adddress_line_2)
                      <p><strong>{{ trans('admin.address_2') }}:</strong> {!! $login_user_account_data->address_details->account_bill_adddress_line_2 !!}</p>
                    @endif

                    <p><strong>{{ trans('admin.city') }}:</strong> {!! $login_user_account_data->address_details->account_bill_town_or_city !!}</p>

                    <p><strong>{{ trans('admin.postCode') }}:</strong> {!! $login_user_account_data->address_details->account_bill_zip_or_postal_code !!}</p>
                    <p><strong>{{ trans('admin.country') }}:</strong> {!! get_country_by_code( $login_user_account_data->address_details->account_bill_select_country ) !!}</p>

                    <br>

                    @if($login_user_account_data->address_details->account_bill_phone_number)
                      <p><strong>{{ trans('admin.phone') }}:</strong> {!! $login_user_account_data->address_details->account_bill_phone_number !!}</p>
                    @endif


                    @if($login_user_account_data->address_details->account_bill_fax_number)
                      <p><strong>{{ trans('admin.fax') }}:</strong> {!! $login_user_account_data->address_details->account_bill_fax_number !!}</p>
                    @endif

                    <p><strong>{{ trans('admin.email') }}:</strong> {!! $login_user_account_data->address_details->account_bill_email_address !!}</p>

                    @else
                    <p>{{ trans('admin.billing_address_not_available') }}</p>
                    @endif
                  </div>
                  <div class="address-content-sub">
                    <h3 class="page-subheading">{!! trans('frontend.shipping_address') !!}</h3><br>

                    @if(!empty($login_user_account_data) && !empty($login_user_account_data->address_details))
                    <p>{!! $login_user_account_data->address_details->account_shipping_first_name .' '. $login_user_account_data->address_details->account_shipping_last_name !!}</p>

                    @if($login_user_account_data->address_details->account_shipping_company_name)
                      <p><strong>{{ trans('admin.company') }}:</strong> {!! $login_user_account_data->address_details->account_shipping_company_name !!}</p>
                    @endif

                    <p><strong>{{ trans('admin.address_1') }}:</strong> {!! $login_user_account_data->address_details->account_shipping_adddress_line_1 !!}</p>

                    @if($login_user_account_data->address_details->account_shipping_adddress_line_2)
                      <p><strong>{{ trans('admin.address_2') }}:</strong> {!! $login_user_account_data->address_details->account_shipping_adddress_line_2 !!}</p>
                    @endif

                    <p><strong>{{ trans('admin.city') }}:</strong> {!! $login_user_account_data->address_details->account_shipping_town_or_city !!}</p>

                    <p><strong>{{ trans('admin.postCode') }}:</strong> {!! $login_user_account_data->address_details->account_shipping_zip_or_postal_code !!}</p>
                    <p><strong>{{ trans('admin.country') }}:</strong> {!! get_country_by_code( $login_user_account_data->address_details->account_shipping_select_country ) !!}</p>

                    <br>

                    @if($login_user_account_data->address_details->account_shipping_phone_number)
                      <p><strong>{{ trans('admin.phone') }}:</strong> {!! $login_user_account_data->address_details->account_shipping_phone_number !!}</p>
                    @endif


                    @if($login_user_account_data->address_details->account_shipping_fax_number)
                      <p><strong>{{ trans('admin.fax') }}:</strong> {!! $login_user_account_data->address_details->account_shipping_fax_number !!}</p>
                    @endif

                    <p><strong>{{ trans('admin.email') }}:</strong> {!! $login_user_account_data->address_details->account_shipping_email_address !!}</p>

                    @else
                    <p>{{ trans('admin.shipping_address_not_available') }}</p>
                    @endif
                  </div>
                </div>
              </div>
            </div>
            @endif
            
            @if($_settings_data['general_settings']['checkout_options']['enable_guest_user'] == true || ($_settings_data['general_settings']['checkout_options']['enable_login_user'] == true && $is_user_login == true) || ($_settings_data['general_settings']['checkout_options']['enable_guest_user'] == false && $_settings_data['general_settings']['checkout_options']['enable_login_user'] == false))
            <div id="payment" class="step well">
              <h2 class="step-title">{!! trans('frontend.choose_payment') !!}</h2><hr>
              @if($payment_method_data['payment_option']['enable_payment_method'] == 'yes' && ($payment_method_data['bacs']['enable_option'] == 'yes' || $payment_method_data['cod']['enable_option'] == 'yes' || $payment_method_data['paypal']['enable_option'] == 'yes' || $payment_method_data['stripe']['enable_option'] == 'yes'))
                <div class="payment-options">
                 @if($payment_method_data['bacs']['enable_option'] == 'yes')
                  <span>
                   <label>
                     @if(old('payment_option') == 'bacs')
                     <input type="radio" class="shopist-iCheck" checked name="payment_option" value="bacs"> {{ $payment_method_data['bacs']['method_title'] }}
                     @else
                      <input type="radio" class="shopist-iCheck" name="payment_option" value="bacs"> {{ $payment_method_data['bacs']['method_title'] }}
                     @endif
                   </label>
                  </span>
                 @endif

                 @if($payment_method_data['cod']['enable_option'] == 'yes')
                  <span>
                   <label>
                     @if(old('payment_option') == 'cod')
                      <input type="radio" checked name="payment_option" class="shopist-iCheck" value="cod"> {{ $payment_method_data['cod']['method_title'] }}
                     @else
                      <input type="radio" name="payment_option" class="shopist-iCheck" value="cod"> {{ $payment_method_data['cod']['method_title'] }}
                     @endif
                   </label>
                  </span>
                 @endif

                 @if($payment_method_data['paypal']['enable_option'] == 'yes')
                  <span>
                   <label>
                     @if(old('payment_option') == 'paypal')
                      <input type="radio" checked name="payment_option" class="shopist-iCheck" value="paypal"> {{ $payment_method_data['paypal']['method_title'] }}
                     @else
                      <input type="radio" name="payment_option" class="shopist-iCheck" value="paypal"> {{ $payment_method_data['paypal']['method_title'] }}
                     @endif
                   </label>
                  </span>
                 @endif
                 
                 @if($payment_method_data['stripe']['enable_option'] == 'yes')
                  <script src='https://js.stripe.com/v2/' type='text/javascript'></script>
                  <input type="hidden" name="stripe_api_key" value="{{ $stripe_api_key }}" id="stripe_api_key">
                  <span>
                   <label>
                     @if(old('payment_option') == 'stripe')
                      <input type="radio" checked name="payment_option" class="shopist-iCheck" value="stripe"> {{ $payment_method_data['stripe']['method_title'] }}
                     @else
                      <input type="radio" name="payment_option" class="shopist-iCheck" value="stripe"> {{ $payment_method_data['stripe']['method_title'] }}
                     @endif
                   </label>
                  </span>
                 @endif
                 
                 @if($payment_method_data['2checkout']['enable_option'] == 'yes')
                 <script type="text/javascript" src="https://www.2checkout.com/checkout/api/2co.min.js"></script>
                 <input type="hidden" name="2checkout_api_data" value="{{ $twocheckout_api_data }}" id="2checkout_api_data">
                  <span>
                   <label>
                     @if(old('payment_option') == '2checkout')
                      <input type="radio" checked name="payment_option" class="shopist-iCheck" value="2checkout"> {{ $payment_method_data['2checkout']['method_title'] }}
                     @else
                      <input type="radio" name="payment_option" class="shopist-iCheck" value="2checkout"> {{ $payment_method_data['2checkout']['method_title'] }}
                     @endif
                   </label>
                  </span>
                 @endif

                 @if($payment_method_data['bacs']['enable_option'] == 'yes')
                  <div id="bacsPopover">
                    <p>{{ $payment_method_data['bacs']['method_description'] }}</p>
                  </div>
                 @endif
                 @if($payment_method_data['cod']['enable_option'] == 'yes')
                  <div id="codPopover">
                    <p>{{ $payment_method_data['cod']['method_description'] }}</p>
                  </div>
                 @endif
                 @if($payment_method_data['paypal']['enable_option'] == 'yes')
                  <div id="paypalPopover">
                    <p>{{ $payment_method_data['paypal']['method_description'] }}</p>
                  </div>
                 @endif
                 
                 @if($payment_method_data['stripe']['enable_option'] == 'yes')
                  <div id="stripePopover">
                    <p>{{ $payment_method_data['stripe']['method_description'] }}</p><br>
                    
                    <div id="stripe_content">
                      <div class="input-group row">
                        <div class="col-xs-12 required">    
                          <label class="control-label">{!! trans('frontend.email_address_label') !!}</label> 
                          <input class="form-control" type="email" id="email_address" name="email_address" placeholder="email address">
                        </div>
                      </div>
                        
                      <div class="input-group row">
                        <div class="col-xs-12 required">      
                          <label class="control-label">{!! trans('frontend.card_number_label') !!}</label> 
                          <input class="form-control" type="text" id="card_number" name="card_number" placeholder="card number">
                        </div>
                      </div>
                        
                      <div class="input-group row">
                        <div class="col-xs-4 required">  
                          <label class="control-label">{!! trans('frontend.cvc_label') !!}</label> 
                          <input class="form-control" type="text" id="card_cvc" name="card_cvc" placeholder="ex. 311">
                        </div>
                        <div class="col-xs-4 required">  
                          <label class="control-label">{!! trans('frontend.expiration_month_label') !!}</label> 
                          <input class="form-control" type="text" id="card_expiry_month" name="card_expiry_month" placeholder="MM">
                        </div>
                        <div class="col-xs-4 required">  
                          <label class="control-label">{!! trans('frontend.expiration_year_label') !!}</label> 
                          <input class="form-control" type="text" id="card_expiry_year" name="card_expiry_year" placeholder="YYYY">
                        </div>  
                      </div>
                    </div>
                  </div>
                 @endif
                 
                 @if($payment_method_data['2checkout']['enable_option'] == 'yes')
                  <div id="twocheckoutPopover">
                    <p>{{ $payment_method_data['2checkout']['method_description'] }}</p><br>
                    
                    <div id="2checkout_content">  
                      <div class="input-group row">
                        <div class="col-xs-12 required">      
                          <label class="control-label">{!! trans('frontend.card_number_label') !!}</label> 
                          <input class="form-control" type="text" id="2checkout_card_number" name="2checkout_card_number" placeholder="card number">
                        </div>
                      </div>
                        
                      <div class="input-group row">
                        <div class="col-xs-4 required">  
                          <label class="control-label">{!! trans('frontend.cvc_label') !!}</label> 
                          <input class="form-control" type="text" id="2checkout_card_cvc" name="2checkout_card_cvc" placeholder="ex. 123">
                        </div>
                        <div class="col-xs-4 required">  
                          <label class="control-label">{!! trans('frontend.expiration_month_label') !!}</label> 
                          <input class="form-control" type="text" id="2checkout_card_expiry_month" name="2checkout_card_expiry_month" placeholder="MM">
                        </div>
                        <div class="col-xs-4 required">  
                          <label class="control-label">{!! trans('frontend.expiration_year_label') !!}</label> 
                          <input class="form-control" type="text" id="2checkout_card_expiry_year" name="2checkout_card_expiry_year" placeholder="YYYY">
                        </div>  
                      </div>
                    </div>
                  </div>
                 @endif
                </div>
              @else
                <p>{{ trans('frontend.checkout_payment_method_label') }}</p>
              @endif
            </div>
            @endif
            
            @if($_settings_data['general_settings']['checkout_options']['enable_guest_user'] == true || ($_settings_data['general_settings']['checkout_options']['enable_login_user'] == true && $is_user_login == true) || ($_settings_data['general_settings']['checkout_options']['enable_guest_user'] == false && $_settings_data['general_settings']['checkout_options']['enable_login_user'] == false))
            <div id="order_notes" class="step well">
              <h2 class="step-title">{!! trans('frontend.order_notes') !!}</h2><hr>
              <div class="order-extra-notes">
                <textarea name="checkout_order_extra_message" id="checkout_order_extra_message"  placeholder="{{ trans('frontend.notes_about_your_order') }}" class="form-control">{!! old('checkout_order_extra_message') !!}</textarea>
              </div>
            </div>
            @endif
            
            <button class="action next btn btn-primary">{!! trans('frontend.proceed_to_checkout_label') !!}</button>
            <button name="checkout_proceed" class="action submit btn btn-primary place-order" type="submit" value="checkout_proceed">{{ trans('frontend.place_order') }}</button>
          </div>
        </div>  
        <input type="hidden" id="selected_user_mode" name="selected_user_mode">
        <input type="hidden" id="is_user_login" name="is_user_login" value="{{ $is_user_login }}">
        <input type="hidden" id="selected_payment_method" name="selected_payment_method">
        @if(!empty($login_user_account_data) && !empty($login_user_account_data->address_details))
        <input type="hidden" id="is_login_user_address_exists" name="is_login_user_address_exists" value="address_added">
        @endif
      </form>    
      @else
        <p>@include('pages-message.notify-msg-error')</p>
        <h2 class="cart-shopping-label">{{ trans('frontend.checkout_process') }}</h2>
        <div class="empty-cart-msg">{{ trans('frontend.empty_cart_msg') }}</div>
        <div class="cart-return-shop"><a class="btn btn-default check_out" href="{{ route('shop-page') }}">{{ trans('frontend.return_to_shop') }}</a></div>
      @endif
    </div>
  </div>
@endsection