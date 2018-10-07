<?php $__env->startSection('title', trans('frontend.shopist_checkout') .' < '. get_site_title() ); ?>

<?php $__env->startSection('content'); ?>
  <div class="extra-margin-top-for-content"></div>
  <div id="checkout_page" class="container">
    <div class="row">
      <?php if( Cart::count() >0 ): ?>
      <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>"> 
        <div class="col-md-10 col-sm-12 col-centered">    
          <div class="checkout-content">
            <?php if(count($errors) > 0): ?>
              <div class="alert alert-danger">
                <strong><?php echo trans('validation.whoops'); ?></strong> <?php echo trans('validation.input_error'); ?><br /><br />
                <ul>
                  <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo $error; ?></li>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
              </div>
            <?php endif; ?>

            <div class="progress">
              <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            
            <div id="cart_summary" class="step well">
              <h2 class="step-title"><?php echo trans('frontend.shopping_cart_summary_label'); ?></h2><hr>
              <div class="shopping-cart-summary-content">
                <ul class="cart-data">
                  <li class="row list-inline columnCaptions">
                    <div class="header-items"><?php echo trans('frontend.cart_item'); ?></div>
                    <div class="header-price"><?php echo trans('frontend.price'); ?></div>
                    <div class="header-qty"><?php echo trans('frontend.quantity'); ?></div>
                    <div class="header-line-total last-total"><?php echo trans('frontend.total'); ?></div>
                  </li>
                  <?php $__currentLoopData = Cart::items(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="row items-inline">
                      <div class="itemName">
                        <?php if($items->img_src): ?>
                          <div class="product-img">
                            <a href="<?php echo e(route('details-page', get_product_slug($items->id))); ?>">
                              <img src="<?php echo e(get_image_url($items->img_src)); ?>" alt="product">
                            </a>
                          </div>
                        <?php else: ?>
                          <div class="product-img">
                            <a href="<?php echo e(route('details-page', get_product_slug($items->id))); ?>">
                              <img src="<?php echo e(default_placeholder_img_src()); ?>" alt="product">
                            </a>
                          </div>
                        <?php endif; ?>
                        <div class="item-name">
                          <a href="<?php echo e(route('details-page', get_product_slug($items->id))); ?>"><?php echo $items->name; ?></a>
                          <?php $count = 1; ?>
                          <?php if(count($items->options) > 0): ?>
                          <p>
                            <?php $__currentLoopData = $items->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <?php if($count == count($items->options)): ?>
                                <?php echo $key .' &#8658; '. $val; ?>

                              <?php else: ?>
                                <?php echo $key .' &#8658; '. $val. ' , '; ?>

                              <?php endif; ?>
                              <?php $count ++ ; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          </p>
                          <?php endif; ?>

                          <?php if(get_product_type($items->id) === 'customizable_product'): ?>
                            <?php if($items->acces_token): ?>
                              <?php if(count(get_customize_images_by_access_token($items->acces_token))>0): ?>
                                <button class="btn btn-block btn-xs view-customize-images" data-images="<?php echo e(json_encode( get_customize_images_by_access_token($items->acces_token) )); ?>"><?php echo e(trans('frontend.design_images')); ?></button>
                              <?php endif; ?>
                            <?php endif; ?>
                          <?php endif; ?>
                          
                          <?php if( count(get_vendor_details_by_product_id($items->product_id)) >0 ): ?>
                          <p class="vendor-title"><strong><?php echo trans('frontend.vendor_label'); ?></strong> : <?php echo get_vendor_name_by_product_id( $items->product_id); ?></p>
                          <?php endif; ?>
                        </div>
                      </div>  

                      <div class="price"><?php echo price_html( get_product_price_html_by_filter($items->price) ); ?></div>
                      <div class="quantity"><input type="number" class="form-control cart_quantity_input" name="cart_quantity[<?php echo e($index); ?>]" value="<?php echo e($items->quantity); ?>" min="1"></div>
                      <div class="price line-total last-total"><?php echo price_html(  get_product_price_html_by_filter(Cart::getRowPrice($items->quantity, $items->price) )); ?></div>
                      <div class="popbtn"><a class="cart_quantity_delete delete-extra-padding" href="<?php echo e(route('removed-item-from-cart', $index)); ?>"><i class="fa fa-close"></i></a></div>
                    </li>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  
                  <li class="row cart-button-main">
                    <div class="apply-coupon">
                      <input type="text" class="form-control" id="apply_coupon_code" name="apply_coupon" placeholder="<?php echo e(trans('frontend.coupon_code_placeholder_text')); ?>">
                      <button class="btn btn-primary" name="apply_coupon_post" id="apply_coupon_post"><?php echo trans('frontend.apply_coupon_label'); ?></button>
                      <div class="clearfix visible-xs"></div>
                    </div>
                    <div class="btn-cart-action">
                      <button class="btn btn-primary empty" type="submit" name="empty_cart" value="empty_cart"><?php echo e(trans('frontend.empty_cart')); ?></button>
                      <button class="btn btn-primary update" type="submit" name="update_cart" value="update_cart"><?php echo e(trans('frontend.update_cart')); ?></button>
                    </div>
                  </li>
                  
                  <?php echo $__env->make('pages.ajax-pages.cart-total-html', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </ul>
              </div>
            </div>
            
            <?php if($_settings_data['general_settings']['checkout_options']['enable_guest_user'] == true && $_settings_data['general_settings']['checkout_options']['enable_login_user'] == true): ?>
            <div id="user_mode" class="step well">
              <h2 class="step-title"><?php echo trans('frontend.user_mode_label'); ?></h2><hr>  
              <div class="checkout-process-user-mode">
                <ul class="nav">
                  <li>
                      <label><input type="radio" class="shopist-iCheck" name="user_checkout_complete_type" value="guest">&nbsp; <?php echo trans('frontend.guest_checkout'); ?></label>
                  </li>
                  <li>
                    <label><input type="radio" class="shopist-iCheck" name="user_checkout_complete_type" value="login_user">&nbsp; <?php echo trans('frontend.login_user_checkout'); ?></label>
                  </li>
                </ul>
              </div>
            </div>
            <?php endif; ?>
            
            <?php if($_settings_data['general_settings']['checkout_options']['enable_guest_user'] == true || ($_settings_data['general_settings']['checkout_options']['enable_guest_user'] == false && $_settings_data['general_settings']['checkout_options']['enable_login_user'] == false)): ?>
            <div id="guest_user_address" class="step well">
              <h2 class="step-title"><?php echo trans('frontend.checkout_address_label'); ?></h2><hr> 
              <div class="user-address-content">
                <div class="address-information clearfix">
                  <div class="address-content-sub">
                    <h3 class="page-subheading"><?php echo trans('frontend.billing_address'); ?></h3><hr>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <div class="col-sm-4">
                            <label class="control-label" for="inputAccountTitle"><?php echo e(trans('frontend.account_title')); ?></label>
                          </div>
                          <div class="col-sm-8">
                            <input type="text" class="form-control" placeholder="<?php echo e(trans('frontend.title')); ?>" name="account_bill_title" id="account_bill_title" value="<?php echo e(old('account_bill_title')); ?>">
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="col-sm-4">
                            <label class="control-label" for="inputAccountCompanyName"><?php echo e(trans('frontend.checkout_company_name_label')); ?></label>
                          </div>
                          <div class="col-sm-8">
                            <input type="text" class="form-control" placeholder="<?php echo e(trans('frontend.company_name')); ?>" name="account_bill_company_name" id="account_bill_company_name" value="<?php echo e(old('account_bill_company_name')); ?>">
                          </div>
                        </div>

                        <div class="form-group required">
                          <div class="col-sm-4">
                            <label class="control-label" for="inputAccountFirstName"><?php echo e(trans('frontend.account_first_name')); ?></label>
                          </div>
                          <div class="col-sm-8">
                            <input type="text" class="form-control" placeholder="<?php echo e(trans('frontend.first_name')); ?>" name="account_bill_first_name" id="account_bill_first_name" value="<?php echo e(old('account_bill_first_name')); ?>">
                          </div>
                        </div>

                        <div class="form-group required">
                          <div class="col-sm-4">
                            <label class="control-label" for="inputAccountLastName"><?php echo e(trans('frontend.account_last_name')); ?></label>
                          </div>
                          <div class="col-sm-8">
                            <input type="text" class="form-control" placeholder="<?php echo e(trans('frontend.last_name')); ?>" name="account_bill_last_name" id="account_bill_last_name" value="<?php echo e(old('account_bill_last_name')); ?>">
                          </div>
                        </div>

                        <div class="form-group required">
                          <div class="col-sm-4">
                            <label class="control-label" for="inputAccountEmailAddress"><?php echo e(trans('frontend.account_email')); ?></label>
                          </div>
                          <div class="col-sm-8">
                            <input type="email" class="form-control" placeholder="<?php echo e(trans('frontend.email')); ?>" name="account_bill_email_address" id="account_bill_email_address" value="<?php echo e(old('account_bill_email_address')); ?>">
                          </div>
                        </div>

                        <div class="form-group required">
                          <div class="col-sm-4">
                            <label class="control-label" for="inputAccountPhoneNumber"><?php echo e(trans('frontend.account_phone_number')); ?></label>
                          </div>
                          <div class="col-sm-8">
                            <input type="number" class="form-control" placeholder="<?php echo e(trans('frontend.phone')); ?>" name="account_bill_phone_number" id="account_bill_phone_number" value="<?php echo e(old('account_bill_phone_number')); ?>">
                          </div>
                        </div>

                        <div class="form-group required">
                          <div class="col-sm-4">
                            <label class="control-label" for="inputAccountSelectCountry"><?php echo e(trans('frontend.checkout_select_country_label')); ?></label>
                          </div>
                          <div class="col-sm-8">
                            <select class="form-control" id="account_bill_select_country" name="account_bill_select_country">
                              <option value=""> <?php echo e(trans('frontend.select_country')); ?> </option>
                              <?php $__currentLoopData = get_country_list(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(old('account_bill_select_country') == $key): ?>
                                  <option selected value="<?php echo e($key); ?>"> <?php echo $val; ?></option>
                                <?php else: ?>
                                  <option value="<?php echo e($key); ?>"> <?php echo $val; ?></option>
                                <?php endif; ?>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                             </select>
                          </div>
                        </div>

                        <div class="form-group required">
                          <div class="col-sm-4">
                            <label class="control-label" for="inputAccountAddressLine1"><?php echo e(trans('frontend.account_address_line_1')); ?></label>
                          </div>
                          <div class="col-sm-8">
                            <textarea class="form-control" id="account_bill_adddress_line_1" name="account_bill_adddress_line_1" placeholder="<?php echo e(trans('frontend.address_line_1')); ?>"><?php echo e(old('account_bill_adddress_line_1')); ?></textarea>
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="col-sm-4">
                            <label class="control-label" for="inputAccountAddressLine2"><?php echo e(trans('frontend.account_address_line_2')); ?></label>
                          </div>
                          <div class="col-sm-8">
                            <textarea class="form-control" id="account_bill_adddress_line_2" name="account_bill_adddress_line_2" placeholder="<?php echo e(trans('frontend.address_line_2')); ?>"><?php echo e(old('account_bill_adddress_line_2')); ?></textarea>
                          </div>
                        </div>

                        <div class="form-group required">
                          <div class="col-sm-4">
                            <label class="control-label" for="inputAccountTownCity"><?php echo e(trans('frontend.account_address_town_city')); ?></label>
                          </div>
                          <div class="col-sm-8">
                            <input type="text" class="form-control" placeholder="<?php echo e(trans('frontend.town_city')); ?>" name="account_bill_town_or_city" id="account_bill_town_or_city" value="<?php echo e(old('account_bill_town_or_city')); ?>">
                          </div>
                        </div>

                        <div class="form-group required">
                          <div class="col-sm-4">
                            <label class="control-label" for="inputAccountZipPostalCode"><?php echo e(trans('frontend.checkout_zip_postal_label')); ?></label>
                          </div>
                          <div class="col-sm-8">
                            <input type="number" class="form-control" placeholder="<?php echo e(trans('frontend.zip_postal_code')); ?>" name="account_bill_zip_or_postal_code" id="account_bill_zip_or_postal_code" value="<?php echo e(old('account_bill_zip_or_postal_code')); ?>">
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="col-sm-4">
                            <label class="control-label" for="inputAccountFaxNumber"><?php echo e(trans('frontend.account_fax_number')); ?></label>
                          </div>
                          <div class="col-sm-8">
                            <input type="number" class="form-control" placeholder="<?php echo e(trans('frontend.fax')); ?>" name="account_bill_fax_number" id="account_bill_fax_number" value="<?php echo e(old('account_bill_fax_number')); ?>">
                          </div>
                        </div>  
                      </div>
                    </div>
                  </div>
                  <div class="address-content-sub">
                    <h3 class="page-subheading"><?php echo trans('frontend.shipping_address'); ?></h3><hr>
                    <input type="checkbox" name="different_shipping_address" id="different_shipping_address" class="shopist-iCheck" value="different_address"> <?php echo e(trans('frontend.different_shipping_label')); ?>

                    <div class="row different-shipping-address">
                      <div class="col-md-12">
                        <div class="form-group">
                          <div class="col-sm-4">
                            <label class="control-label" for="inputAccountTitle"><?php echo e(trans('frontend.account_title')); ?></label>
                          </div>
                          <div class="col-sm-8">
                            <input type="text" class="form-control" placeholder="<?php echo e(trans('frontend.title')); ?>" name="account_shipping_title" id="account_shipping_title" value="<?php echo e(old('account_shipping_title')); ?>">
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="col-sm-4">
                            <label class="control-label" for="inputAccountCompanyName"><?php echo e(trans('frontend.checkout_company_name_label')); ?></label>
                          </div>
                          <div class="col-sm-8">
                            <input type="text" class="form-control" placeholder="<?php echo e(trans('frontend.company_name')); ?>" name="account_shipping_company_name" id="account_shipping_company_name" value="<?php echo e(old('account_shipping_company_name')); ?>">
                          </div>
                        </div>

                        <div class="form-group required">
                          <div class="col-sm-4">
                            <label class="control-label" for="inputAccountFirstName"><?php echo e(trans('frontend.account_first_name')); ?></label>
                          </div>
                          <div class="col-sm-8">
                            <input type="text" class="form-control" placeholder="<?php echo e(trans('frontend.first_name')); ?>" name="account_shipping_first_name" id="account_shipping_first_name" value="<?php echo e(old('account_shipping_first_name')); ?>">
                          </div>
                        </div>

                        <div class="form-group required">
                          <div class="col-sm-4">
                            <label class="control-label" for="inputAccountLastName"><?php echo e(trans('frontend.account_last_name')); ?></label>
                          </div>
                          <div class="col-sm-8">
                            <input type="text" class="form-control" placeholder="<?php echo e(trans('frontend.last_name')); ?>" name="account_shipping_last_name" id="account_shipping_last_name" value="<?php echo e(old('account_shipping_last_name')); ?>">
                          </div>
                        </div>

                        <div class="form-group required">
                          <div class="col-sm-4">
                            <label class="control-label" for="inputAccountEmailAddress"><?php echo e(trans('frontend.account_email')); ?></label>
                          </div>
                          <div class="col-sm-8">
                            <input type="email" class="form-control" placeholder="<?php echo e(trans('frontend.email')); ?>" name="account_shipping_email_address" id="account_shipping_email_address" value="<?php echo e(old('account_shipping_email_address')); ?>">
                          </div>
                        </div>

                        <div class="form-group required">
                          <div class="col-sm-4">
                            <label class="control-label" for="inputAccountPhoneNumber"><?php echo e(trans('frontend.account_phone_number')); ?></label>
                          </div>
                          <div class="col-sm-8">
                            <input type="number" class="form-control" placeholder="<?php echo e(trans('frontend.phone')); ?>" name="account_shipping_phone_number" id="account_shipping_phone_number" value="<?php echo e(old('account_shipping_phone_number')); ?>">
                          </div>
                        </div>

                        <div class="form-group required">
                          <div class="col-sm-4">
                            <label class="control-label" for="inputAccountSelectCountry"><?php echo e(trans('frontend.checkout_select_country_label')); ?></label>
                          </div>
                          <div class="col-sm-8">
                            <select class="form-control" id="account_shipping_select_country" name="account_shipping_select_country">
                              <option value=""> <?php echo e(trans('frontend.select_country')); ?> </option>
                              <?php $__currentLoopData = get_country_list(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(old('account_bill_select_country') == $key): ?>
                                  <option selected value="<?php echo e($key); ?>"> <?php echo $val; ?></option>
                                <?php else: ?>
                                  <option value="<?php echo e($key); ?>"> <?php echo $val; ?></option>
                                <?php endif; ?>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                             </select>
                          </div>
                        </div>

                        <div class="form-group required">
                          <div class="col-sm-4">
                            <label class="control-label" for="inputAccountAddressLine1"><?php echo e(trans('frontend.account_address_line_1')); ?></label>
                          </div>
                          <div class="col-sm-8">
                            <textarea class="form-control" id="account_shipping_adddress_line_1" name="account_shipping_adddress_line_1" placeholder="<?php echo e(trans('frontend.address_line_1')); ?>"><?php echo e(old('account_shipping_adddress_line_1')); ?></textarea>
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="col-sm-4">
                            <label class="control-label" for="inputAccountAddressLine2"><?php echo e(trans('frontend.account_address_line_2')); ?></label>
                          </div>
                          <div class="col-sm-8">
                            <textarea class="form-control" id="account_shipping_adddress_line_2" name="account_shipping_adddress_line_2" placeholder="<?php echo e(trans('frontend.address_line_2')); ?>"><?php echo e(old('account_shipping_adddress_line_2')); ?></textarea>
                          </div>
                        </div>

                        <div class="form-group required">
                          <div class="col-sm-4">
                            <label class="control-label" for="inputAccountTownCity"><?php echo e(trans('frontend.account_address_town_city')); ?></label>
                          </div>
                          <div class="col-sm-8">
                            <input type="text" class="form-control" placeholder="<?php echo e(trans('frontend.town_city')); ?>" name="account_shipping_town_or_city" id="account_shipping_town_or_city" value="<?php echo e(old('account_shipping_town_or_city')); ?>">
                          </div>
                        </div>

                        <div class="form-group required">
                          <div class="col-sm-4">
                            <label class="control-label" for="inputAccountZipPostalCode"><?php echo e(trans('frontend.checkout_zip_postal_label')); ?></label>
                          </div>
                          <div class="col-sm-8">
                            <input type="number" class="form-control" placeholder="<?php echo e(trans('frontend.zip_postal_code')); ?>" name="account_shipping_zip_or_postal_code" id="account_shipping_zip_or_postal_code" value="<?php echo e(old('account_shipping_zip_or_postal_code')); ?>">
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="col-sm-4">
                            <label class="control-label" for="inputAccountFaxNumber"><?php echo e(trans('frontend.account_fax_number')); ?></label>
                          </div>
                          <div class="col-sm-8">
                            <input type="number" class="form-control" placeholder="<?php echo e(trans('frontend.fax')); ?>" name="account_shipping_fax_number" id="account_shipping_fax_number" value="<?php echo e(old('account_shipping_fax_number')); ?>">
                          </div>
                        </div>

                      </div>
                    </div>
                  </div>
                </div>  
              </div>
            </div>
            <?php endif; ?>
            
            <?php if($_settings_data['general_settings']['checkout_options']['enable_login_user'] == true && $is_user_login == false): ?>
            <div id="authentication" class="step well">
              <h2 class="step-title"><?php echo trans('frontend.authentication_label'); ?></h2><hr>  
              <div class="user-login-content">
                <div class="login-information clearfix">
                  <div class="login-content-sub">
                    <h3 class="page-subheading"><?php echo trans('frontend.create_an_account_label'); ?></h3>
                    <div class="form_content">
                      <p><?php echo trans('frontend.no_user_account_msg'); ?></p>
                      <a class="btn btn-primary" href="<?php echo e(route('user-registration-page')); ?>"><?php echo trans('frontend.create_account_label'); ?></a>
                    </div>
                  </div>
                  <div class="login-content-sub">
                    <h3 class="page-subheading"><?php echo trans('frontend.already_registered_label'); ?></h3>
                    <div class="form_content">
                      <p><?php echo trans('frontend.has_user_account_msg'); ?></p>
                      <a class="btn btn-primary" href="<?php echo e(route('user-login-page')); ?>"><?php echo trans('frontend.signin_account_label'); ?></a>
                    </div>
                  </div>
                </div>  
              </div>
            </div>
            <?php endif; ?>
            
            <?php if($_settings_data['general_settings']['checkout_options']['enable_login_user'] == true && $is_user_login == true): ?>
            <div id="login_user_address" class="step well">
              <h2 class="step-title"><?php echo trans('frontend.checkout_address_label'); ?></h2><hr> 
              <div class="text-right">
                <?php if(!empty($login_user_account_data) && !empty($login_user_account_data->address_details)): ?>
                  <a href="<?php echo e(route('my-address-edit-page')); ?>" class="btn btn-primary btn-sm"><?php echo e(trans('frontend.edit_address')); ?></a>
                <?php else: ?>
                  <a href="<?php echo e(route('my-address-add-page')); ?>" class="btn btn-primary btn-sm"><?php echo e(trans('frontend.add_address')); ?></a>
                <?php endif; ?>
              </div>
              <br>
              <div class="user-address-content">
                <div class="address-information clearfix">
                  <div class="address-content-sub">
                    <h3 class="page-subheading"><?php echo trans('frontend.billing_address'); ?></h3><br>
                    <?php if(!empty($login_user_account_data) && !empty($login_user_account_data->address_details)): ?>
                    <p><?php echo $login_user_account_data->address_details->account_bill_first_name .' '. $login_user_account_data->address_details->account_bill_last_name; ?></p>

                    <?php if($login_user_account_data->address_details->account_bill_company_name): ?>
                      <p><strong><?php echo e(trans('admin.company')); ?>:</strong> <?php echo $login_user_account_data->address_details->account_bill_company_name; ?></p>
                    <?php endif; ?>

                    <p><strong><?php echo e(trans('admin.address_1')); ?>:</strong> <?php echo $login_user_account_data->address_details->account_bill_adddress_line_1; ?></p>

                    <?php if($login_user_account_data->address_details->account_bill_adddress_line_2): ?>
                      <p><strong><?php echo e(trans('admin.address_2')); ?>:</strong> <?php echo $login_user_account_data->address_details->account_bill_adddress_line_2; ?></p>
                    <?php endif; ?>

                    <p><strong><?php echo e(trans('admin.city')); ?>:</strong> <?php echo $login_user_account_data->address_details->account_bill_town_or_city; ?></p>

                    <p><strong><?php echo e(trans('admin.postCode')); ?>:</strong> <?php echo $login_user_account_data->address_details->account_bill_zip_or_postal_code; ?></p>
                    <p><strong><?php echo e(trans('admin.country')); ?>:</strong> <?php echo get_country_by_code( $login_user_account_data->address_details->account_bill_select_country ); ?></p>

                    <br>

                    <?php if($login_user_account_data->address_details->account_bill_phone_number): ?>
                      <p><strong><?php echo e(trans('admin.phone')); ?>:</strong> <?php echo $login_user_account_data->address_details->account_bill_phone_number; ?></p>
                    <?php endif; ?>


                    <?php if($login_user_account_data->address_details->account_bill_fax_number): ?>
                      <p><strong><?php echo e(trans('admin.fax')); ?>:</strong> <?php echo $login_user_account_data->address_details->account_bill_fax_number; ?></p>
                    <?php endif; ?>

                    <p><strong><?php echo e(trans('admin.email')); ?>:</strong> <?php echo $login_user_account_data->address_details->account_bill_email_address; ?></p>

                    <?php else: ?>
                    <p><?php echo e(trans('admin.billing_address_not_available')); ?></p>
                    <?php endif; ?>
                  </div>
                  <div class="address-content-sub">
                    <h3 class="page-subheading"><?php echo trans('frontend.shipping_address'); ?></h3><br>

                    <?php if(!empty($login_user_account_data) && !empty($login_user_account_data->address_details)): ?>
                    <p><?php echo $login_user_account_data->address_details->account_shipping_first_name .' '. $login_user_account_data->address_details->account_shipping_last_name; ?></p>

                    <?php if($login_user_account_data->address_details->account_shipping_company_name): ?>
                      <p><strong><?php echo e(trans('admin.company')); ?>:</strong> <?php echo $login_user_account_data->address_details->account_shipping_company_name; ?></p>
                    <?php endif; ?>

                    <p><strong><?php echo e(trans('admin.address_1')); ?>:</strong> <?php echo $login_user_account_data->address_details->account_shipping_adddress_line_1; ?></p>

                    <?php if($login_user_account_data->address_details->account_shipping_adddress_line_2): ?>
                      <p><strong><?php echo e(trans('admin.address_2')); ?>:</strong> <?php echo $login_user_account_data->address_details->account_shipping_adddress_line_2; ?></p>
                    <?php endif; ?>

                    <p><strong><?php echo e(trans('admin.city')); ?>:</strong> <?php echo $login_user_account_data->address_details->account_shipping_town_or_city; ?></p>

                    <p><strong><?php echo e(trans('admin.postCode')); ?>:</strong> <?php echo $login_user_account_data->address_details->account_shipping_zip_or_postal_code; ?></p>
                    <p><strong><?php echo e(trans('admin.country')); ?>:</strong> <?php echo get_country_by_code( $login_user_account_data->address_details->account_shipping_select_country ); ?></p>

                    <br>

                    <?php if($login_user_account_data->address_details->account_shipping_phone_number): ?>
                      <p><strong><?php echo e(trans('admin.phone')); ?>:</strong> <?php echo $login_user_account_data->address_details->account_shipping_phone_number; ?></p>
                    <?php endif; ?>


                    <?php if($login_user_account_data->address_details->account_shipping_fax_number): ?>
                      <p><strong><?php echo e(trans('admin.fax')); ?>:</strong> <?php echo $login_user_account_data->address_details->account_shipping_fax_number; ?></p>
                    <?php endif; ?>

                    <p><strong><?php echo e(trans('admin.email')); ?>:</strong> <?php echo $login_user_account_data->address_details->account_shipping_email_address; ?></p>

                    <?php else: ?>
                    <p><?php echo e(trans('admin.shipping_address_not_available')); ?></p>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            </div>
            <?php endif; ?>
            
            <?php if($_settings_data['general_settings']['checkout_options']['enable_guest_user'] == true || ($_settings_data['general_settings']['checkout_options']['enable_login_user'] == true && $is_user_login == true) || ($_settings_data['general_settings']['checkout_options']['enable_guest_user'] == false && $_settings_data['general_settings']['checkout_options']['enable_login_user'] == false)): ?>
            <div id="payment" class="step well">
              <h2 class="step-title"><?php echo trans('frontend.choose_payment'); ?></h2><hr>
              <?php if($payment_method_data['payment_option']['enable_payment_method'] == 'yes' && ($payment_method_data['bacs']['enable_option'] == 'yes' || $payment_method_data['cod']['enable_option'] == 'yes' || $payment_method_data['paypal']['enable_option'] == 'yes' || $payment_method_data['stripe']['enable_option'] == 'yes')): ?>
                <div class="payment-options">
                 <?php if($payment_method_data['bacs']['enable_option'] == 'yes'): ?>
                  <span>
                   <label>
                     <?php if(old('payment_option') == 'bacs'): ?>
                     <input type="radio" class="shopist-iCheck" checked name="payment_option" value="bacs"> <?php echo e($payment_method_data['bacs']['method_title']); ?>

                     <?php else: ?>
                      <input type="radio" class="shopist-iCheck" name="payment_option" value="bacs"> <?php echo e($payment_method_data['bacs']['method_title']); ?>

                     <?php endif; ?>
                   </label>
                  </span>
                 <?php endif; ?>

                 <?php if($payment_method_data['cod']['enable_option'] == 'yes'): ?>
                  <span>
                   <label>
                     <?php if(old('payment_option') == 'cod'): ?>
                      <input type="radio" checked name="payment_option" class="shopist-iCheck" value="cod"> <?php echo e($payment_method_data['cod']['method_title']); ?>

                     <?php else: ?>
                      <input type="radio" name="payment_option" class="shopist-iCheck" value="cod"> <?php echo e($payment_method_data['cod']['method_title']); ?>

                     <?php endif; ?>
                   </label>
                  </span>
                 <?php endif; ?>

                 <?php if($payment_method_data['paypal']['enable_option'] == 'yes'): ?>
                  <span>
                   <label>
                     <?php if(old('payment_option') == 'paypal'): ?>
                      <input type="radio" checked name="payment_option" class="shopist-iCheck" value="paypal"> <?php echo e($payment_method_data['paypal']['method_title']); ?>

                     <?php else: ?>
                      <input type="radio" name="payment_option" class="shopist-iCheck" value="paypal"> <?php echo e($payment_method_data['paypal']['method_title']); ?>

                     <?php endif; ?>
                   </label>
                  </span>
                 <?php endif; ?>
                 
                 <?php if($payment_method_data['stripe']['enable_option'] == 'yes'): ?>
                  <script src='https://js.stripe.com/v2/' type='text/javascript'></script>
                  <input type="hidden" name="stripe_api_key" value="<?php echo e($stripe_api_key); ?>" id="stripe_api_key">
                  <span>
                   <label>
                     <?php if(old('payment_option') == 'stripe'): ?>
                      <input type="radio" checked name="payment_option" class="shopist-iCheck" value="stripe"> <?php echo e($payment_method_data['stripe']['method_title']); ?>

                     <?php else: ?>
                      <input type="radio" name="payment_option" class="shopist-iCheck" value="stripe"> <?php echo e($payment_method_data['stripe']['method_title']); ?>

                     <?php endif; ?>
                   </label>
                  </span>
                 <?php endif; ?>
                 
                 <?php if($payment_method_data['2checkout']['enable_option'] == 'yes'): ?>
                 <script type="text/javascript" src="https://www.2checkout.com/checkout/api/2co.min.js"></script>
                 <input type="hidden" name="2checkout_api_data" value="<?php echo e($twocheckout_api_data); ?>" id="2checkout_api_data">
                  <span>
                   <label>
                     <?php if(old('payment_option') == '2checkout'): ?>
                      <input type="radio" checked name="payment_option" class="shopist-iCheck" value="2checkout"> <?php echo e($payment_method_data['2checkout']['method_title']); ?>

                     <?php else: ?>
                      <input type="radio" name="payment_option" class="shopist-iCheck" value="2checkout"> <?php echo e($payment_method_data['2checkout']['method_title']); ?>

                     <?php endif; ?>
                   </label>
                  </span>
                 <?php endif; ?>

                 <?php if($payment_method_data['bacs']['enable_option'] == 'yes'): ?>
                  <div id="bacsPopover">
                    <p><?php echo e($payment_method_data['bacs']['method_description']); ?></p>
                  </div>
                 <?php endif; ?>
                 <?php if($payment_method_data['cod']['enable_option'] == 'yes'): ?>
                  <div id="codPopover">
                    <p><?php echo e($payment_method_data['cod']['method_description']); ?></p>
                  </div>
                 <?php endif; ?>
                 <?php if($payment_method_data['paypal']['enable_option'] == 'yes'): ?>
                  <div id="paypalPopover">
                    <p><?php echo e($payment_method_data['paypal']['method_description']); ?></p>
                  </div>
                 <?php endif; ?>
                 
                 <?php if($payment_method_data['stripe']['enable_option'] == 'yes'): ?>
                  <div id="stripePopover">
                    <p><?php echo e($payment_method_data['stripe']['method_description']); ?></p><br>
                    
                    <div id="stripe_content">
                      <div class="input-group row">
                        <div class="col-xs-12 required">    
                          <label class="control-label"><?php echo trans('frontend.email_address_label'); ?></label> 
                          <input class="form-control" type="email" id="email_address" name="email_address" placeholder="email address">
                        </div>
                      </div>
                        
                      <div class="input-group row">
                        <div class="col-xs-12 required">      
                          <label class="control-label"><?php echo trans('frontend.card_number_label'); ?></label> 
                          <input class="form-control" type="text" id="card_number" name="card_number" placeholder="card number">
                        </div>
                      </div>
                        
                      <div class="input-group row">
                        <div class="col-xs-4 required">  
                          <label class="control-label"><?php echo trans('frontend.cvc_label'); ?></label> 
                          <input class="form-control" type="text" id="card_cvc" name="card_cvc" placeholder="ex. 311">
                        </div>
                        <div class="col-xs-4 required">  
                          <label class="control-label"><?php echo trans('frontend.expiration_month_label'); ?></label> 
                          <input class="form-control" type="text" id="card_expiry_month" name="card_expiry_month" placeholder="MM">
                        </div>
                        <div class="col-xs-4 required">  
                          <label class="control-label"><?php echo trans('frontend.expiration_year_label'); ?></label> 
                          <input class="form-control" type="text" id="card_expiry_year" name="card_expiry_year" placeholder="YYYY">
                        </div>  
                      </div>
                    </div>
                  </div>
                 <?php endif; ?>
                 
                 <?php if($payment_method_data['2checkout']['enable_option'] == 'yes'): ?>
                  <div id="twocheckoutPopover">
                    <p><?php echo e($payment_method_data['2checkout']['method_description']); ?></p><br>
                    
                    <div id="2checkout_content">  
                      <div class="input-group row">
                        <div class="col-xs-12 required">      
                          <label class="control-label"><?php echo trans('frontend.card_number_label'); ?></label> 
                          <input class="form-control" type="text" id="2checkout_card_number" name="2checkout_card_number" placeholder="card number">
                        </div>
                      </div>
                        
                      <div class="input-group row">
                        <div class="col-xs-4 required">  
                          <label class="control-label"><?php echo trans('frontend.cvc_label'); ?></label> 
                          <input class="form-control" type="text" id="2checkout_card_cvc" name="2checkout_card_cvc" placeholder="ex. 123">
                        </div>
                        <div class="col-xs-4 required">  
                          <label class="control-label"><?php echo trans('frontend.expiration_month_label'); ?></label> 
                          <input class="form-control" type="text" id="2checkout_card_expiry_month" name="2checkout_card_expiry_month" placeholder="MM">
                        </div>
                        <div class="col-xs-4 required">  
                          <label class="control-label"><?php echo trans('frontend.expiration_year_label'); ?></label> 
                          <input class="form-control" type="text" id="2checkout_card_expiry_year" name="2checkout_card_expiry_year" placeholder="YYYY">
                        </div>  
                      </div>
                    </div>
                  </div>
                 <?php endif; ?>
                </div>
              <?php else: ?>
                <p><?php echo e(trans('frontend.checkout_payment_method_label')); ?></p>
              <?php endif; ?>
            </div>
            <?php endif; ?>
            
            <?php if($_settings_data['general_settings']['checkout_options']['enable_guest_user'] == true || ($_settings_data['general_settings']['checkout_options']['enable_login_user'] == true && $is_user_login == true) || ($_settings_data['general_settings']['checkout_options']['enable_guest_user'] == false && $_settings_data['general_settings']['checkout_options']['enable_login_user'] == false)): ?>
            <div id="order_notes" class="step well">
              <h2 class="step-title"><?php echo trans('frontend.order_notes'); ?></h2><hr>
              <div class="order-extra-notes">
                <textarea name="checkout_order_extra_message" id="checkout_order_extra_message"  placeholder="<?php echo e(trans('frontend.notes_about_your_order')); ?>" class="form-control"><?php echo old('checkout_order_extra_message'); ?></textarea>
              </div>
            </div>
            <?php endif; ?>
            
            <button class="action next btn btn-primary"><?php echo trans('frontend.proceed_to_checkout_label'); ?></button>
            <button name="checkout_proceed" class="action submit btn btn-primary place-order" type="submit" value="checkout_proceed"><?php echo e(trans('frontend.place_order')); ?></button>
          </div>
        </div>  
        <input type="hidden" id="selected_user_mode" name="selected_user_mode">
        <input type="hidden" id="is_user_login" name="is_user_login" value="<?php echo e($is_user_login); ?>">
        <input type="hidden" id="selected_payment_method" name="selected_payment_method">
        <?php if(!empty($login_user_account_data) && !empty($login_user_account_data->address_details)): ?>
        <input type="hidden" id="is_login_user_address_exists" name="is_login_user_address_exists" value="address_added">
        <?php endif; ?>
      </form>    
      <?php else: ?>
        <p><?php echo $__env->make('pages-message.notify-msg-error', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?></p>
        <h2 class="cart-shopping-label"><?php echo e(trans('frontend.checkout_process')); ?></h2>
        <div class="empty-cart-msg"><?php echo e(trans('frontend.empty_cart_msg')); ?></div>
        <div class="cart-return-shop"><a class="btn btn-default check_out" href="<?php echo e(route('shop-page')); ?>"><?php echo e(trans('frontend.return_to_shop')); ?></a></div>
      <?php endif; ?>
    </div>
  </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.frontend.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>