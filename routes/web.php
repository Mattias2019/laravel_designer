<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

//installation route
Route::get('/installation', [
  'uses' => 'Admin\InstallationController@installationCheck',
  'as'   => 'installation-int'
]);

Route::group(['namespace' => 'Auth'], function () {
  Route::get('/installation-process', [
    'uses' => 'RegisterController@redirectToInstallationProcess',
    'as'   => 'installation-process'
  ]);

  Route::post('/installation-process', [
    'uses' => 'RegisterController@installationDataSave',
    'as'   => 'admin-data-save'
  ]);

  //admin login route
  Route::get( '/admin/login', [
    'uses' => 'LoginController@goToAdminLoginPage',
    'as'   => 'admin.login'
  ]);

  Route::post( '/admin/login' , [
    'uses' => 'LoginController@postAdminLogin',
    'as'   => 'admin.post_login'
  ]);

  //admin logout route
  Route::post( '/admin/logout', [
    'uses' => 'LoginController@logoutFromLogin',
    'as'   => 'admin.logout'
  ]);

  //admin forgot password route 
  Route::get( '/admin/forgot-password', [
    'uses' => 'ForgotPasswordController@redirectForgotPassword',
    'as' => 'forgotPassword'
  ]);

  Route::post( '/admin/forgot-password', [
    'uses' => 'ForgotPasswordController@postForgotPassword',
    'as' => 'forgotPasswordUpdate'
  ]);

  //frontend user and vendor login route
  Route::get( '/user/login', [
    'uses' => 'LoginController@goToFrontendLoginPage',
    'as'   => 'user-login-page'
  ]);

  Route::post( '/user/login', [
    'uses' => 'LoginController@postFrontendLogin',
    'as'   => 'user-login-post'
  ]);

  //frontend user and vendor registration route
  Route::get( '/user/registration', [
    'uses' => 'RegisterController@redirectToUserRegistrationProcess',
    'as'   => 'user-registration-page'
  ]);

  Route::get( '/vendor/registration', [
    'uses' => 'RegisterController@redirectToVendorRegistrationProcess',
    'as'   => 'vendor-registration-page'
  ]);

  Route::post( '/user/registration', [
    'uses' => 'RegisterController@userRegistration',
    'as'   => 'user-registration-post'
  ]);

  Route::post( '/vendor/registration', [
    'uses' => 'RegisterController@vendorRegistration',
    'as'   => 'vendor-registration-post'
  ]);

  //frontend forgot password route
  Route::get( '/user/forgot-password', [
    'uses' => 'ForgotPasswordController@redirectForgotPassword',
    'as'   => 'user-forgot-password-page' 
  ]);

  Route::post( '/user/forgot-password', [
    'uses' => 'ForgotPasswordController@manageFrontendUserForgotPassword',
    'as'   => 'user-forgot-password-post'
  ]);
});

Route::group(['prefix' => 'admin'], function () {
  //cache clear route 
  Route::get('/clear-cache', [
    'uses' => 'FeaturesController@clearDesignCache',
    'as'   => 'admin.clearCache'
  ]);
});

//admin menu route
Route::group(['prefix' => 'admin'], function () {

  Route::get('users/roles/list', [
    'uses' => 'Admin\UserController@usersRoleListContent',
    'as'   => 'admin.users_roles_list'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('users/roles/add', [
    'uses' => 'Admin\UserController@usersRoleAddContent',
    'as'   => 'admin.add_roles'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
   
  Route::get('users/roles/update/{roles_id}', [
    'uses' => 'Admin\UserController@usersRoleUpdateContent',
    'as'   => 'admin.update_roles'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('users/list', [
    'uses' => 'Admin\UserController@usersListContent',
    'as'   => 'admin.users_list'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('user/add', [
    'uses' => 'Admin\UserController@usersAddContent',
    'as'   => 'admin.add_new_user'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('user/update/{user_id}', [
    'uses' => 'Admin\UserController@usersUpdateContent',
    'as'   => 'admin.update_new_user'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('user/profile', [
    'uses' => 'Admin\UserController@userProfileContent',
    'as'   => 'admin.user_profile'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
 
  //admin blog menu
  Route::get('pages/list', [
    'uses' => 'CMSController@pageListContent',
    'as'   => 'admin.all_pages'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('page/add', [
    'uses' => 'CMSController@pageAddContent',
    'as'   => 'admin.add_page'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('page/update/{page_slug}', [
    'uses' => 'CMSController@pageUpdateContent',
    'as'   => 'admin.update_page'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('blog/list', [
    'uses' => 'CMSController@blogListContent',
    'as'   => 'admin.all_blogs'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('blog/add', [
    'uses' => 'CMSController@blogAddContent',
    'as'   => 'admin.add_blog'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('blog/categories/list', [
    'uses' => 'CMSController@blogCategoriesListContent',
    'as'   => 'admin.blog_categories_list'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('blog/comments-list', [
    'uses' => 'CMSController@blogCommentsListContent',
    'as'   => 'admin.all_blog_comments'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('blog/update/{blog_slug}', [
    'uses' => 'CMSController@blogUpdateContent',
    'as'   => 'admin.update_blog'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  
  //admin dashboard menu
  Route::get('dashboard', [
    'uses' => 'AdminDashboardContentController@dashboardContent',
    'as'   => 'admin.dashboard'
  ])->middleware('verifyLoginPage', 'admin');

  Route::post('dashboard', [
    'uses' => 'AdminDashboardContentController@sendQuickMail',
    'as'   => 'admin.quick_mail_dashboard'
  ]);
  
  
  //admin products menu
  Route::get('product/list/{author_id}', [
    'uses' => 'ProductsController@productListContent',
    'as'   => 'admin.product_list'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('product/add', [
    'uses' => 'ProductsController@productAddContent',
    'as'   => 'admin.add_product'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('product/tags/list', [
    'uses' => 'ProductsController@productTagsListContent',
    'as'   => 'admin.product_tags_list'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
 
    Route::get('product/tags/customlist', [
    'uses' => 'ProductsController@productTagscustomListContent',
    'as'   => 'admin.product_tags_customlist'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
 

  Route::get('product/categories/list', [
    'uses' => 'ProductsController@productCategoriesListContent',
    'as'   => 'admin.product_categories_list'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
 // 900 
    Route::get('product/categories/customlist', [
    'uses' => 'ProductsController@productCategoriescustomListContent',
    'as'   => 'admin.product_categories_customlist'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');


  Route::get('product/attributes/list', [
    'uses' => 'ProductsController@productAttributesListContent',
    'as'   => 'admin.product_attributes_list'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('product/colors/list', [
    'uses' => 'ProductsController@productColorsListContent',
    'as'   => 'admin.product_colors_list'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('product/sizes/list', [
    'uses' => 'ProductsController@productSizesListContent',
    'as'   => 'admin.product_sizes_list'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('product/comments-list', [
    'uses' => 'ProductsController@productCommentsListContent',
    'as'   => 'admin.all_products_comments'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('product/update/{slug}', [
    'uses' => 'ProductsController@productUpdateContent',
    'as'   => 'admin.update_product_content'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  
  //admin shipping menu
  Route::get('shipping-method/options', [
    'uses' => 'ShippingMethodController@shippingMethodOptionContent',
    'as'   => 'admin.shipping_method_options_content'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('shipping-method/flat-rate', [
    'uses' => 'ShippingMethodController@shippingMethodFlatRateContent',
    'as'   => 'admin.shipping_method_flat_rate_content'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('shipping-method/free-shipping', [
    'uses' => 'ShippingMethodController@shippingMethodFreeShippingContent',
    'as'   => 'admin.shipping_method_free_shipping_content'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('shipping-method/local-delivery', [
    'uses' => 'ShippingMethodController@shippingMethodLocalDeliveryContent',
    'as'   => 'admin.shipping_method_local_delivery_content'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  
  //admin payment menu
  Route::get('payment-method/options', [
    'uses' => 'PaymentMethodController@paymentMethodOptionsContent',
    'as'   => 'admin.payment_method_options_content'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('payment-method/direct-bank', [
    'uses' => 'PaymentMethodController@paymentMethodDirectBankContent',
    'as'   => 'admin.payment_method_direct_bank_content'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('payment-method/cash-on-delivery', [
    'uses' => 'PaymentMethodController@paymentMethodCashOnDeliveryContent',
    'as'   => 'admin.payment_method_cash_on_delivery_content'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('payment-method/paypal', [
    'uses' => 'PaymentMethodController@paymentMethodPaypalContent',
    'as'   => 'admin.payment_method_paypal_content'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('payment-method/stripe', [
    'uses' => 'PaymentMethodController@paymentMethodStripeContent',
    'as'   => 'admin.payment_method_stripe_content'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('payment-method/two-checkout', [
    'uses' => 'PaymentMethodController@paymentMethodTwoCheckoutContent',
    'as'   => 'admin.payment_method_two_checkout_content'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
 
  //admin manufacturer menu
  Route::get('manufacturers/list', [
    'uses' => 'CMSController@manufacturersListContent',
    'as'   => 'admin.manufacturers_list_content'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('manufacturers/add', [
    'uses' => 'CMSController@manufacturersAddContent',
    'as'   => 'admin.add_manufacturers_content'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('manufacturers/update/{manufacturers_id}', [
    'uses' => 'CMSController@manufacturersUpdateContent',
    'as'   => 'admin.update_manufacturers_content'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  
  //Extra features
	Route::get('extra-features/product-compare-fields', [
    'uses' => 'FeaturesController@productCompareFieldsContent',
    'as'   => 'admin.extra_features_compare_products_content'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
		
  //admin settings menu
  Route::get('settings/general', [
    'uses' => 'SettingsController@settingsGeneralContent',
    'as'   => 'admin.general_settings_content'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('settings/languages', [
    'uses' => 'SettingsController@settingsLanguagesContent',
    'as'   => 'admin.languages_settings_content'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('settings/languages/update/{update_id}', [
    'uses' => 'SettingsController@settingsLanguagesUpdateContent',
    'as'   => 'admin.update_languages_settings_content'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('settings/appearance', [
    'uses' => 'SettingsController@settingsAppearanceContent',
    'as'   => 'admin.frontend_layout_settings_content'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('settings/emails', [
    'uses' => 'SettingsController@settingsEmailContent',
    'as'   => 'admin.emails_settings_content'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('settings/emails/details/{emails_type}', [
    'uses' => 'SettingsController@settingsEmailDetailsContent',
    'as'   => 'admin.emails_type_content'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  //admin custom designer menu
  Route::get('designer/clipart/categories/list', [
    'uses' => 'DesignerElementsController@designerArtCatListContent',
    'as'   => 'admin.art_categories_list_content'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('designer/clipart/list', [
    'uses' => 'DesignerElementsController@designerClipartListContent',
    'as'   => 'admin.clipart_list_content'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('designer/clipart/category/add', [
    'uses' => 'DesignerElementsController@designerArtCatAddContent',
    'as'   => 'admin.art_new_category_content'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('designer/clipart/add', [
    'uses' => 'DesignerElementsController@designerClipartAddContent',
    'as'   => 'admin.add_new_art_content'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('designer/settings', [
    'uses' => 'DesignerElementsController@designerSettingsContent',
    'as'   => 'admin.designer_settings_content'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('designer/shape/list', [
    'uses' => 'DesignerElementsController@designerShapeListContent',
    'as'   => 'admin.shape_list_content'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('designer/shape/add', [
    'uses' => 'DesignerElementsController@designerShapeAddContent',
    'as'   => 'admin.shape_add_content'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('designer/shape/update/{shape_slug}', [
    'uses' => 'DesignerElementsController@designerShapeUpdateContent',
    'as'   => 'admin.shape_update_content'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('designer/fonts/list', [
    'uses' => 'DesignerElementsController@designerFontListContent',
    'as'   => 'admin.fonts_list_content'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('designer/font/add', [
    'uses' => 'DesignerElementsController@designerFontAddContent',
    'as'   => 'admin.font_add_content'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('designer/font/update/{font_slug}', [
    'uses' => 'DesignerElementsController@designerFontUpdateContent',
    'as'   => 'admin.font_update_content'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  
  //admin manage orders menu  
  Route::get('orders', [
    'uses' => 'OrderController@orderListsContent',
    'as'   => 'admin.shop_orders_list'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('orders/current-date', [
    'uses' => 'OrderController@orderCurrentDateContent',
    'as'   => 'admin.shop_current_date_orders_list'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('orders/details/{order_id}', [
    'uses' => 'OrderController@orderDetailsPageContent',
    'as'   => 'admin.view_order_details'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::post('orders/details/{order_id}', [
    'uses' => 'OrderController@updateOrderStatus',
    'as'   => 'admin.uppdate_order_status'
  ]);
  
  Route::get('reports', [
    'uses' => 'ReportController@reportListContent',
    'as'   => 'admin.reports_list'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('reports/sales-by-product-title', [
    'uses' => 'ReportController@reportSalesByProductTitle',
    'as'   => 'admin.reports_sales_by_product_title'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('reports/sales-by-month', [
    'uses' => 'ReportController@reportSalesByMonth',
    'as'   => 'admin.reports_sales_by_month'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('reports/sales-by-last-7-days', [
    'uses' => 'ReportController@reportSalesByLast7Days',
    'as'   => 'admin.reports_sales_by_last_7_days'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('reports/sales-by-custom-days', [
    'uses' => 'ReportController@reportSalesByCustomDaysDays',
    'as'   => 'admin.reports_sales_by_custom_days'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('reports/sales-by-payment-method', [
    'uses' => 'ReportController@reportSalesByPaymentMethod',
    'as'   => 'admin.reports_sales_by_payment_method'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('designer/clipart/category/update/{art_cat_id}', [
    'uses' => 'DesignerElementsController@designerArtCatUpdateContent',
    'as'   => 'admin.update_art_category_content'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('designer/clipart/update/{clipart_slug}', [
    'uses' => 'DesignerElementsController@designerClipartUpdateContent',
    'as'   => 'admin.update_clipart_content'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  
  //admin coupon menu 
  Route::get('coupon-manager/coupon/list', [
    'uses' => 'FeaturesController@couponListContent',
    'as'   => 'admin.coupon_manager_list'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('coupon-manager/coupon/add', [
    'uses' => 'FeaturesController@couponAddContent',
    'as'   => 'admin.coupon_manager_content'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('coupon-manager/coupon/update/{coupon_id}', [
    'uses' => 'FeaturesController@couponUpdateContent',
    'as'   => 'admin.update_coupon_manager_content'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
 
  //admin seo settings menu
  Route::get('manage/seo', [
    'uses' => 'CMSController@seoContent',
    'as'   => 'admin.manage_seo_content'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  //admin request product menu
  Route::get('customer/request-product', [
    'uses' => 'FeaturesController@customerRequestProductListContent',
    'as'   => 'admin.request_product_content'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  //admin subscription manager menu
  Route::get('subscription/custom', [
    'uses' => 'FeaturesController@subscriptionCustomContent',
    'as'   => 'admin.custom_subscription_content'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('subscription/mailchimp', [
    'uses' => 'FeaturesController@subscriptionMailchimpContent',
    'as'   => 'admin.mailchimp_subscription_content'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('subscription/settings', [
    'uses' => 'FeaturesController@subscriptionSettingsContent',
    'as'   => 'admin.settings_subscription_content'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::post('subscription/mailchimp', [
    'uses' => 'FeaturesController@updateSubscriptionData',
    'as'   => 'admin.update_mailchimp_subscription_content'
  ]);
  
  Route::post('subscription/settings', [
    'uses' => 'FeaturesController@updateSubscriptionSettings',
    'as'   => 'admin.update_subscription_settings_content'
  ]);
  
  
  //admin testimonial menu
  Route::get('testimonial/list', [
    'uses' => 'CMSController@testimonialListContent',
    'as'   => 'admin.testimonial_post_list_content'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('testimonial/add', [
    'uses' => 'CMSController@testimonialAddContent',
    'as'   => 'admin.testimonial_post_content'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('testimonial/update/{testimonial_slug}', [
    'uses' => 'CMSController@testimonialUpdateContent',
    'as'   => 'admin.update_testimonial_post_content'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  
  //admin vendors menu
  Route::get('vendors/list', [
    'uses' => 'VendorsController@vendorListContent',
    'as'   => 'admin.vendors_list_content'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('vendors/list/{status}', [
    'uses' => 'VendorsController@vendorStatusContent',
    'as'   => 'admin.vendors_list_with_status'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('vendor/settings', [
    'uses' => 'VendorsController@vendorMenuSettingsContent',
    'as'   => 'admin.vendors_settings_content'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  //admin vendor packages menu
  Route::get('vendors/package/create', [
    'uses' => 'VendorsController@vendorPackageCreateContent',
    'as'   => 'admin.vendors_packages_create_content'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('vendors/package/update/{update_id}', [
    'uses' => 'VendorsController@vendorPackageUpdateContent',
    'as'   => 'admin.vendors_packages_update_content'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('vendors/package/list', [
    'uses' => 'VendorsController@vendorPackageListContent',
    'as'   => 'admin.vendors_packages_list_content'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('vendors/withdraw', [
    'uses' => 'VendorsController@vendorWithdrawContent',
    'as'   => 'admin.withdraws_content'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('vendors/withdraw/{update_id}', [
    'uses' => 'VendorsController@vendorWithdrawRequestUpdateContent',
    'as'   => 'admin.withdraws_content_update'
  ]);
  
  Route::get('vendors/withdraw/request_delete/{id}', [
    'uses' => 'VendorsController@deleteVendorWithdrawRequest',
    'as'   => 'admin.delete_withdraws_request'
  ]);
  
  Route::get('status/vendors/withdraw/{status_name}', [
    'uses' => 'VendorsController@vendorWithdrawStatusContent',
    'as'   => 'admin.withdraws_status_change'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('vendors/earning-reports', [
    'uses' => 'VendorsController@vendorsEarningReportsContent',
    'as'   => 'admin.earning_reports_content'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('vendors/earning-reports/{tab_name}', [
    'uses' => 'VendorsController@vendorsEarningReportsParmsContent',
    'as'   => 'admin.earning_reports_content_by_tab'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('vendors/announcement/list', [
    'uses' => 'VendorsController@vendorAnnouncementListContent',
    'as'   => 'admin.announcement_list_content'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('vendors/announcement', [
    'uses' => 'VendorsController@vendorAnnouncementAddContent',
    'as'   => 'admin.announcement_content'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('vendors/announcement/{update_id}', [
    'uses' => 'VendorsController@vendorAnnouncementUpdateContent',
    'as'   => 'admin.announcement_update_content'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('vendors/settings', [
    'uses' => 'VendorsController@vendorSettingsContent',
    'as'   => 'admin.vendor_settings_content'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');

  Route::get('vendors/reviews', [
    'uses' => 'VendorsController@vendorReviewsContent',
    'as'   => 'admin.reviews_content'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('vendors/manage/packages', [
    'uses' => 'VendorsController@vendorPackagesManage',
    'as'   => 'admin.manage_packages_content'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('vendor/notice-board', [
    'uses' => 'VendorsController@vendorNoticeBoardContent',
    'as'   => 'admin.vendor_notice_board_content'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
  
  Route::get('vendor/notice-board/single/details/{slug}', [
    'uses' => 'VendorsController@vendorNoticeBoardAdminSinglePageContent',
    'as'   => 'admin.vendor_notice_board_single_content_details'
  ]);
  
  Route::get('order/invoice/{order_id}', [
    'uses' => 'OrderController@redirectOrderInvoice',
    'as'   => 'admin.order_invoice'
  ])->middleware('verifyLoginPage', 'admin', 'sufficientPermission');
});


// menu post
Route::group(['prefix' => 'admin'], function () {
  Route::post('manufacturers/add', [
    'uses' => 'CMSController@saveManufacturersData',
    'as'   => 'admin.save_manufacturers_content'
  ]);
  
  Route::post('manufacturers/update/{manufacturers_id}', [
    'uses' => 'CMSController@saveManufacturersData',
    'as'   => 'admin.update_post_manufacturers_content'
  ]);
  
  Route::post('product/add', [
    'uses' => 'ProductsController@saveProduct',
    'as'   => 'admin.save_product'
  ]);
  
  Route::post('product/update/{slug}', [
    'uses' => 'ProductsController@saveProduct',
    'as'   => 'admin.update_product'
  ]);
  
  Route::post('page/add', [
    'uses' => 'CMSController@savePagesData',
    'as'   => 'admin.save_page_data'
  ]);
  
  Route::post('page/update/{page_slug}', [
    'uses' => 'CMSController@savePagesData',
    'as'   => 'admin.update_page_content'
  ]);
  
  Route::post('blog/add', [
    'uses' => 'CMSController@blogPostSave',
    'as'   => 'admin.add_blog_post'
  ]);
  
  Route::post('blog/update/{blog_slug}', [
    'uses' => 'CMSController@blogPostSave',
    'as'   => 'admin.update_blog_post'
  ]);
  
  Route::post('testimonial/add', [
    'uses' => 'CMSController@saveTestimonialPost',
    'as'   => 'admin.save_testimonial_post_content'
  ]);
  
  Route::post('testimonial/update/{testimonial_slug}', [
    'uses' => 'CMSController@saveTestimonialPost',
    'as'   => 'admin.save_update_testimonial_post_content'
  ]);
  
  Route::post('shipping-method/options', [
    'uses' => 'ShippingMethodController@saveShippingMethod',
    'as'   => 'admin.save_shipping_method_option'
  ]);
  
  Route::post('shipping-method/flat-rate', [
    'uses' => 'ShippingMethodController@saveShippingMethod',
    'as'   => 'admin.save_shipping_method_flat_rate'
  ]);
  
  Route::post('shipping-method/free-shipping', [
    'uses' => 'ShippingMethodController@saveShippingMethod',
    'as'   => 'admin.save_shipping_method_free_shipping'
  ]);
  
  Route::post('shipping-method/local-delivery', [
    'uses' => 'ShippingMethodController@saveShippingMethod',
    'as'   => 'admin.save_shipping_method_local_delivery'
  ]);
  
  Route::post('payment-method/options', [
    'uses' => 'PaymentMethodController@savePaymentData',
    'as'   => 'admin.save_payment_method_options'
  ]);
  
  Route::post('payment-method/direct-bank', [
    'uses' => 'PaymentMethodController@savePaymentData',
    'as'   => 'admin.save_direct_bank_content'
  ]);
  
  Route::post('payment-method/cash-on-delivery', [
    'uses' => 'PaymentMethodController@savePaymentData',
    'as'   => 'admin.save_cash_on_delivery_content'
  ]);
  
  Route::post('payment-method/paypal', [
    'uses' => 'PaymentMethodController@savePaymentData',
    'as'   => 'admin.save_paypal_content'
  ]);
  
  Route::post('payment-method/stripe', [
    'uses' => 'PaymentMethodController@savePaymentData',
    'as'   => 'admin.save_stripe_content'
  ]);
  
  Route::post('payment-method/two-checkout', [
    'uses' => 'PaymentMethodController@savePaymentData',
    'as'   => 'admin.save_2checkout_content'
  ]);
  
  Route::post('designer/clipart/category/add', [
    'uses' => 'DesignerElementsController@saveArtCategoryData',
    'as'   => 'admin.save_art_category_content'
  ]);
  
  Route::post('designer/clipart/category/update/{art_cat_slug}', [
    'uses' => 'DesignerElementsController@updateArtCatDetails',
    'as'   => 'admin.update_post_art_category_content'
  ]);
  
  Route::post('designer/clipart/add', [
    'uses' => 'DesignerElementsController@saveArtData',
    'as'   => 'admin.save_art_content'
  ]);
  
  Route::post('designer/shape/add', [
    'uses' => 'DesignerElementsController@saveDesignerShape',
    'as'   => 'admin.save_shape_content'
  ]);
  
  Route::post('designer/shape/update/{shape_id}', [
    'uses' => 'DesignerElementsController@saveDesignerShape',
    'as'   => 'admin.update_shape_content'
  ]);
  
  Route::post('designer/font/add', [
    'uses' => 'DesignerElementsController@saveDesignerFont',
    'as'   => 'admin.save_font_content'
  ]);
  
  Route::post('designer/font/update/{font_slug}', [
    'uses' => 'DesignerElementsController@saveDesignerFont',
    'as'   => 'admin.update_font_content'
  ]);

  
  Route::post('designer/clipart/update/{clipart_slug}', [
    'uses' => 'DesignerElementsController@updateArtData',
    'as'   => 'admin.update_post_clipart_content'
  ]);
  
  Route::post('designer/settings', [
    'uses' => 'DesignerElementsController@updateDesignerSettings',
    'as'   => 'admin.update_designer_settings_content'
  ]);
		
	Route::post('coupon-manager/coupon/add', [
    'uses' => 'FeaturesController@saveCoupon',
    'as'   => 'admin.save_coupon_manager_content'
  ]);
		
	Route::post('coupon-manager/coupon/update/{coupon_slug}', [
    'uses' => 'FeaturesController@saveCoupon',
    'as'   => 'admin.update_post_coupon_manager_content'
  ]);
		
	Route::post('manage/seo', [
    'uses' => 'CMSController@updateSeoData',
    'as'   => 'admin.update_manage_seo_content'
  ]);
  
  Route::post('extra-features/product-compare-fields', [
    'uses' => 'FeaturesController@saveProductCompareMoreFields',
    'as'   => 'admin.save_product_compare_more_fields'
  ]);
  
  Route::post('user/add', [
    'uses' => 'Admin\UserController@postUserCreate',
    'as'   => 'admin.create_new_user'
  ]);
  
  Route::post('user/update/{user_id}', [
    'uses' => 'Admin\UserController@postUserCreate',
    'as'   => 'admin.update_post_new_user'
  ]);
  
  Route::post('users/roles/add', [
    'uses' => 'Admin\UserController@postUserRole',
    'as'   => 'admin.save_roles'
  ]);
  
  Route::post('users/roles/update/{roles_id}', [
    'uses' => 'Admin\UserController@postUserRole',
    'as'   => 'admin.update_roles'
  ]);
	
  Route::post('user/profile', [
    'uses' => 'Admin\UserController@updateUserProfile',
    'as'   => 'admin.update_user_profile'
  ]);
  
  Route::post('settings/general', [
    'uses' => 'SettingsController@updateSettingsData',
    'as'   => 'admin.update_general_settings_content'
  ]);
  
  Route::post('settings/languages', [
    'uses' => 'SettingsController@manageLangFile',
    'as'   => 'admin.manage_languages_file'
  ]);
  
  Route::post('settings/languages/update/{update_id}', [
    'uses' => 'SettingsController@manageLangFile',
    'as'   => 'admin.update_post_languages_settings_content'
  ]);
  
  Route::post('settings/appearance', [
    'uses' => 'SettingsController@saveAppearanceSettingsData',
    'as'   => 'admin.update_frontend_settings_data'
  ]);
  
  Route::post('vendor/settings', [
    'uses' => 'VendorsController@saveVendorSettings',
    'as'   => 'admin.save_vendors_settings_content'
  ]);
  
  Route::post('vendors/package/create', [
    'uses' => 'VendorsController@saveVendorPackages',
    'as'   => 'admin.vendors_packages_content_save'
  ]);
  
  Route::post('vendors/package/update/{update_id}', [
    'uses' => 'VendorsController@updateVendorPackages',
    'as'   => 'admin.vendors_packages_update'
  ]);
  
  Route::post('vendors/manage/packages', [
    'uses' => 'VendorsController@saveVendorPackage',
    'as'   => 'admin.vendor_package_save'
  ]);
  
  Route::post('vendors/withdraw', [
    'uses' => 'VendorsController@vendorWithdrawRequestContentSave',
    'as'   => 'admin.withdraws_request_content_save'
  ]);
  
  Route::post('vendors/withdraw/{update_id}', [
    'uses' => 'VendorsController@vendorWithdrawRequestContentSave',
    'as'   => 'admin.withdraws_request_content_update'
  ]);
  
  Route::post('vendors/announcement', [
    'uses' => 'VendorsController@saveVendorAnnouncement',
    'as'   => 'admin.announcement_content_save'
  ]);
  
  Route::post('vendors/announcement/{update_id}', [
    'uses' => 'VendorsController@updateVendorAnnouncement',
    'as'   => 'admin.announcement_content_update'
  ]);
  
  Route::post('vendors/settings', [
    'uses' => 'VendorsController@saveVendorSettingsData',
    'as'   => 'admin.vendor_settings_content_save'
  ]);
		
  Route::post('settings/emails/details/{emails_type}', [
    'uses' => 'SettingsController@saveEmailsContentData',
    'as'   => 'admin.save_emails_content_data'
  ]);
});



//admin upload product related image route
Route::post('/upload/product-related-image', [
  'uses' => 'Admin\AdminAjaxController@saveRelatedImage',
  'as'   => 'save-product-image'
]);

Route::post('/upload/product-gallery-images', [
  'uses' => 'Admin\AdminAjaxController@saveProductGalleryImages',
  'as'   => 'save-product-gallery-images'
]);

Route::post('/upload/art-all-images', [
  'uses' => 'Admin\AdminAjaxController@saveArtAllImages',
  'as'   => 'save-art-images'
]);

Route::post('/upload/product-video-file', [
  'uses' => 'Admin\AdminAjaxController@saveProductVideo',
  'as'   => 'save-product-video'
]);

Route::post('/upload/designer-images', [
  'uses' => 'Common\CommonAjaxController@uploadDesignerImage',
  'as'   => 'upload-designer-images'
]);

Route::post('/upload/upload-downloadable-file', [
  'uses' => 'Admin\AdminAjaxController@uploadDownloadableFiles',
  'as'   => 'upload-downloadable-files'
]);

Route::post('/upload/upload-variable-product-downloadable-file', [
  'uses' => 'Admin\AdminAjaxController@uploadVariableProductDownloadableFiles',
  'as'   => 'upload-variable-products-downloadable-files'
]);


//admin ajax post route
Route::post('/ajax/add-cat', [
  'uses' => 'Admin\AdminAjaxController@saveCategoriesDetails',
  'as'   => 'save-categories-details'
]);

Route::post('/ajax/add-tag', [
  'uses' => 'Admin\AdminAjaxController@saveTagsDetails',
  'as'   => 'save-tags-details'
]);

Route::post('/ajax/add-attribute', [
  'uses' => 'Admin\AdminAjaxController@saveAttributesDetails',
  'as'   => 'save-attr-details'
]);

Route::post('/ajax/add-color', [
  'uses' => 'Admin\AdminAjaxController@saveColorDetails',
  'as'   => 'save-color-details'
]);

Route::post('/ajax/add-size', [
  'uses' => 'Admin\AdminAjaxController@saveSizeDetails',
  'as'   => 'save-size-details'
]);

Route::post('/ajax/edit-data', [
  'uses' => 'Admin\AdminAjaxController@getSpecificDetailsById',
  'as'   => 'get-specific-details'
]);

Route::post('/ajax/delete-item', [
  'uses' => 'Admin\AdminAjaxController@selectedItemDeleteById',
  'as'   => 'selected-item-delete'
]);

Route::post('/ajax/comments-status-change', [
  'uses' => 'Admin\AdminAjaxController@selectedCommentsStatusChange',
  'as'   => 'selected-comments-status-change'
]);

Route::post('/ajax/add-variation', [
  'uses' => 'Admin\AdminAjaxController@saveProductsVariations',
  'as'   => 'save-products-variations'
]);

Route::post('/ajax/get-variation-view-data', [
  'uses' => 'Admin\AdminAjaxController@getProductsVariationsDataById',
  'as'   => 'get-products-variations-data'
]);

Route::post('/ajax/add-attributes-by-product', [
  'uses' => 'Admin\AdminAjaxController@addAttributeByProductId',
  'as'   => 'add-attribute'
]);

Route::post('/ajax/get-available-attributes-with-html', [
  'uses' => 'Admin\AdminAjaxController@getAvailableAttributesWithHtml',
  'as'   => 'get-available-attribute'
]);

Route::post('/ajax/get-clipart-categories-images-with-html', [
  'uses' => 'Common\CommonAjaxController@getAvailableClipartCategoriesImagesWithHtml',
  'as'   => 'get-available-cat-images'
]);

Route::post('/ajax/save_custom_data', [
  'uses' => 'Common\CommonAjaxController@saveCustomDesign',
  'as'   => 'save-custom-design'
]);

Route::post('/ajax/remove_custom_data', [
  'uses' => 'Common\CommonAjaxController@removeCustomDesign',
  'as'   => 'remove-custom-design'
]);

Route::post('/ajax/report_data_by_filter', [
  'uses' => 'Common\CommonAjaxController@getReportDataByFilter',
  'as'   => 'report-data-by-filter'
]);

Route::post('/ajax/appearance_data_manage', [
  'uses' => 'Admin\AdminAjaxController@appearanceDataSave',
  'as'   => 'appearance-data-save'
]);

Route::post('/upload/frontend-images', [
  'uses' => 'Admin\AdminAjaxController@uploadFrontendImages',
  'as'   => 'upload-frontend-images'
]);

Route::post('/ajax/import_product_file', [
  'uses' => 'Admin\AdminAjaxController@manageImportProductFile',
  'as'   => 'import-product-file'
]);

Route::get('/export_products', [
  'uses' => 'ProductsController@manageExportProducts',
  'as'   => 'export-products'
]);

Route::get('/ajax/get_products_for_linked_type', [
  'uses' => 'Admin\AdminAjaxController@getProductsForLinkedType',
  'as'   => 'linked-type-products'
]);

Route::get('/ajax/get_all_vendor', [
  'uses' => 'Admin\AdminAjaxController@getAllVendor',
  'as'   => 'all-vendor'
]);

Route::post('/ajax/get_vendor_profile_by_id', [
  'uses' => 'Admin\AdminAjaxController@getVendorProfileById',
  'as'   => 'vendor-profile-data'
]);

Route::post('/ajax/get_vendor_withdraw_requested_data_by_id', [
  'uses' => 'Admin\AdminAjaxController@getVendorWithdrawRequestedDataById',
  'as'   => 'vendor-withdraw-requested-data'
]);

Route::post('/ajax/requested_withdraw_status_change', [
  'uses' => 'Admin\AdminAjaxController@requestedWithdrawStatusChange',
  'as'   => 'requested-withdraw-status-change'
]);

Route::post('/ajax/vendor-status-change', [
  'uses' => 'Admin\AdminAjaxController@vendorStatusChange',
  'as'   => 'vendor-status-change'
]);

Route::get('/ajax/get_categories_for_vendor', [
  'uses' => 'Admin\AdminAjaxController@getParentCatForVendor',
  'as'   => 'get-cat-for-vendors'
]);



//frontend ajax route
Route::post('/ajax/filter_products', [
  'uses' => 'Frontend\FrontendAjaxController@getProductsByFilterWithName',
  'as'   => 'get-products-by-filter'
]);

Route::post('/ajax/add-to-cart', [
  'uses' => 'Frontend\FrontendAjaxController@productAddToCart',
  'as'   => 'product-add-to-cart'
]);

Route::post('/ajax/customize-product-add-to-cart', [
  'uses' => 'Frontend\FrontendAjaxController@customizeProductAddToCart',
  'as'   => 'customize-product-add-to-cart'
]);

Route::post('/ajax/cart-total-update-by-shipping-method', [
  'uses' => 'Frontend\FrontendAjaxController@cartTotalUpdateUsingShippingMethod',
  'as'   => 'cart-total-update-by-shipping'
]);

Route::post('/ajax/save_custom_design_img', [
  'uses' => 'Frontend\FrontendAjaxController@saveCustomDesignImage',
  'as'   => 'save-custom-design-image'
]);

Route::post('/ajax/requested_product_data', [
  'uses' => 'Frontend\FrontendAjaxController@storeRequestedProductData',
  'as'   => 'save-request-product-data'
]);

Route::post('/ajax/subscription_data', [
  'uses' => 'Frontend\FrontendAjaxController@storeSubscriptionData',
  'as'   => 'save-subscription-data'
]);

Route::post('/ajax/set_subscription_popup_cookie', [
  'uses' => 'Frontend\FrontendAjaxController@setCookieForSubscriptionPopup',
  'as'   => 'set-cookie-subscription'
]);

Route::post('/ajax/frontend-user-logout', [
  'uses' => 'Frontend\FrontendAjaxController@logoutFromFrontendUserLogin',
  'as'   => 'frontend-user-logout'
]);

Route::post('/ajax/user-wishlist-data-process', [
  'uses' => 'Frontend\FrontendAjaxController@userWishlistDataSaved',
  'as'   => 'wishlist-data-save'
]);

Route::post('/ajax/product-compare-data-process', [
  'uses' => 'Frontend\FrontendAjaxController@productCompareDataSaved',
  'as'   => 'product-compare-data-save'
]);

Route::post('/ajax/applyCoupon', [
  'uses' => 'Frontend\FrontendAjaxController@applyUserCoupon',
  'as'   => 'user-coupon-apply'
]);

Route::post('/ajax/removeCoupon', [
  'uses' => 'Frontend\FrontendAjaxController@removeUserCoupon',
  'as'   => 'user-coupon-remove'
]);

Route::post('/ajax/multi-lang-processing', [
  'uses' => 'Frontend\FrontendAjaxController@multiLangProcessing',
  'as'   => 'multi-lang-processing'
]);

Route::post('/ajax/multi-currency-processing', [
  'uses' => 'Frontend\FrontendAjaxController@multiCurrencyProcessing',
  'as'   => 'multi-currency-processing'
]);

Route::post('/ajax/get-quick-view-data-by-product-id', [
  'uses' => 'Frontend\FrontendAjaxController@getQuickViewProductData',
  'as'   => 'product-quick-view-data'
]);

Route::post('/ajax/delete-item-from-wishlist', [
  'uses' => 'Frontend\FrontendAjaxController@deleteItemFromWishlist',
  'as'   => 'wishlist-item-delete'
]);

Route::post('/ajax/get-mini-cart-data', [
  'uses' => 'Frontend\FrontendAjaxController@getMiniCartData',
  'as'   => 'mini-cart-data'
]);

Route::post('/ajax/contact-with-vendor', [
  'uses' => 'Frontend\FrontendAjaxController@contactWithVendorEmail',
  'as'   => 'contact-with-vendor-message'
]);


//frontend route
Route::get( '/', [
  'uses' => 'Frontend\FrontendManagerController@homePageContent',
  'as'   => 'home-page'
]);

// Route::get( '/shop', [
//   'uses' => 'Frontend\FrontendManagerController@productsPageContent',
//   'as'   => 'shop-page'
// ]);

Route::get('/shop',[
  'uses'=> 'Frontend\FrontendManagerController@ProductFristPageContent',
  'as'  => 'shop-page'
]);

Route::get( '/product/details/{details_slug}', [
  'uses' => 'Frontend\FrontendManagerController@productSinglePageContent',
  'as'   => 'details-page'
]);
// 900
Route::get( '/product/customize/{param1}/{param2}', [
  'uses' => 'Frontend\FrontendManagerController@designerSinglePageContents',
  'as'   => 'customizable-page'
]);
Route::get( '/product/customize/{details_id}', [
  'uses' => 'Frontend\FrontendManagerController@designerSinglePageContent',
  'as'   => 'customize-page'
]);

Route::get( '/product/categories/{cat_slug}', [
  'uses' => 'Frontend\FrontendManagerController@productCategoriesSinglePageContent',
  'as'   => 'categories-page'
]);

Route::get('/cart', [
  'uses' => 'Frontend\FrontendManagerController@cartPageContent',
  'as'   => 'cart-page'
]);

Route::get('/checkout', [
  'uses' => 'Frontend\FrontendManagerController@checkoutPageContent',
  'as'   => 'checkout-page'
]);

Route::get( '/page/{page_slug}', [
  'uses' => 'Frontend\FrontendManagerController@singlePageContent',
  'as'   => 'custom-page-content'
]);

Route::post('/cart', [
              'uses' => 'Frontend\FrontendManagerController@doActionFromCartPage',
              'as'   => 'cart-page-post'
]);

$router->get('/remove_item/{cart_id}', ['uses' => 'Frontend\FrontendManagerController@doActionForRemoveItem', 'as' => 'removed-item-from-cart']);
$router->get('/remove_compare_product/{product_id}', ['uses' => 'Frontend\FrontendManagerController@doActionForRemoveCompareProduct', 'as' => 'remove-compare-product-from-list']);

Route::post('/checkout', [
  'uses' => 'CheckoutController@doCheckoutProcess',
  'as'   => 'checkout-process'
]);

$router->get( '/checkout/order-received/{order_id}/{order_key}', ['uses' => 'Frontend\FrontendManagerController@thankyouPageContent', 'as' => 'frontend-order-received'])->where('order_id', '[0-9]+');

// this is after make the payment, PayPal redirect back to your site
Route::get('/checkout/status', array(
  'as' => 'payment.status',
  'uses' => 'CheckoutController@getPaymentStatus',
));

Route::get( '/brand/{brands_name}', [
  'uses' => 'Frontend\FrontendManagerController@brandSinglePageContent',
  'as'   => 'brands-single-page'
]);

Route::get( '/testimonial/{testimonial_slug}', [
  'uses' => 'Frontend\FrontendManagerController@testimonialSinglePageContent',
  'as'   => 'testimonial-single-page'
]);

Route::get( '/blogs', [
  'uses' => 'Frontend\FrontendManagerController@blogsPageContent',
  'as'   => 'blogs-page-content'
]);

Route::get( '/stores', [
  'uses' => 'Frontend\FrontendManagerController@multivendorStoreListPageContent',
  'as'   => 'store-list-page-content'
]);

Route::get( '/store/details/home/{store_user_name}', [
  'uses' => 'Frontend\FrontendManagerController@multivendorStoreSinglePageHomeContent',
  'as'   => 'store-details-page-content'
]);

Route::get( '/store/details/products/{store_user_name}', [
  'uses' => 'Frontend\FrontendManagerController@multivendorStoreSinglePageProductsContent',
  'as'   => 'store-products-page-content'
]);

Route::get( '/store/details/reviews/{store_user_name}', [
  'uses' => 'Frontend\FrontendManagerController@multivendorStoreSinglePageReviewContent',
  'as'   => 'store-reviews-page-content'
]);

Route::post( '/store/details/reviews/{store_user_name}', [
  'uses' => 'VendorsController@saveVendorComments',
  'as'   => 'vendor-reviews-save'
]);

Route::get( '/store/details/cat/products/{product_cat}/{store_user_name}', [
  'uses' => 'Frontend\FrontendManagerController@multivendorStoreSinglePageProductsCatContent',
  'as'   => 'store-products-cat-page-content'
]);

Route::get( '/blog/{blog_slug}', [
  'uses' => 'Frontend\FrontendManagerController@blogSinglePageContent',
  'as'   => 'blog-single-page'
]);

Route::get( '/categories/blog/{blog_cat_slug}', [
  'uses' => 'Frontend\FrontendManagerController@blogCategoriesPageContent',
  'as'   => 'blog-cat-page'
]);

Route::get( '/product/tag/{tag_slug}', [
  'uses' => 'Frontend\FrontendManagerController@tagSinglePageContent',
  'as'   => 'tag-single-page'
]);

Route::get( '/product/comparison', [
  'uses' => 'Frontend\FrontendManagerController@productComparisonPageContent',
  'as'   => 'product-comparison-page'
]);

Route::post( '/product/details/{details_slug}', [
  'uses' => 'Frontend\UserCommentsController@saveUserComments',
  'as'   => 'save-user-comments'
]);

Route::post( '/blog/{blog_slug}', [
  'uses' => 'Frontend\UserCommentsController@saveUserComments',
  'as'   => 'save-user-blog-comments'
]);



// frontend user account route
Route::group(['prefix' => 'user', 'namespace' => 'Frontend'], function () {
  Route::get( 'account', [
    'uses' => 'UserAccountManageController@userAccountPageContent',
    'as'   => 'user-account-page'
  ])->middleware('userAdmin');
  
  Route::get( 'account/dashboard', [
    'uses' => 'UserAccountManageController@userAccountPageContent',
    'as'   => 'user-dashboard-page'
  ])->middleware('userAdmin');
  
  Route::get( 'account/my-address', [
    'uses' => 'UserAccountManageController@userAccountAddressPageContent',
    'as'   => 'my-address-page'
  ])->middleware('userAdmin');
  
  Route::get( 'account/my-address/add', [
    'uses' => 'UserAccountManageController@userAccountAddressPageContent',
    'as'   => 'my-address-add-page'
  ])->middleware('userAdmin');
  
  Route::get( 'account/my-address/edit', [
    'uses' => 'UserAccountManageController@userAccountAddressPageContent',
    'as'   => 'my-address-edit-page'
  ])->middleware('userAdmin');
  
  Route::get( 'account/my-orders', [
    'uses' => 'UserAccountManageController@userAccountOrdersPageContent',
    'as'   => 'my-orders-page'
  ])->middleware('userAdmin');
  
  Route::get( 'account/view-orders-details/{user_order_id}', [
    'uses' => 'UserAccountManageController@goToDifferentPages',
    'as'   => 'user-order-details-page'
  ]);
  
  Route::get( 'account/my-saved-items', [
    'uses' => 'UserAccountManageController@userAccountAddressPageContent',
    'as'   => 'my-saved-items-page'
  ])->middleware('userAdmin');
  
  Route::get( 'account/my-coupons', [
    'uses' => 'UserAccountManageController@userAccountCouponsPageContent',
    'as'   => 'my-coupons-page'
  ])->middleware('userAdmin');
  
  Route::get( 'account/download', [
    'uses' => 'UserAccountManageController@userAccountDownloadPageContent',
    'as'   => 'download-page'
  ])->middleware('userAdmin');
  
  Route::get( 'account/my-profile', [
    'uses' => 'UserAccountManageController@userAccountProfilePageContent',
    'as'   => 'my-profile-page'
  ])->middleware('userAdmin');
  
  Route::get( 'account/order-details/{order_id}/{order_process_id}', [
    'uses' => 'UserAccountManageController@userAccountOrderDetailsContent',
    'as'   => 'account-order-details-page'
  ]);
  
  Route::post( 'account/my-address/add', [
    'uses' => 'UserAccountManageController@saveUserAccountData',
    'as'   => 'my-address-add-post'
  ]);
  
  Route::post( 'account/my-address/edit', [
    'uses' => 'UserAccountManageController@saveUserAccountData',
    'as'   => 'my-address-edit-post'
  ]);
  
  Route::post( 'account/my-profile', [
    'uses' => 'UserAccountManageController@updateFrontendUserProfile',
    'as'   => 'update-profile-post'
  ]);
  
  Route::post( 'account/logout', [
    'uses' => 'UserAccountManageController@userLogout',
    'as'   => 'user-logout'
  ]);
});

Route::get( '/download/file/{product_id}/{order_id}/{file_id}/{target}', [
  'uses' => 'Frontend\FrontendManagerController@forceDownload',
  'as'   => 'downloadable-product-download'
]);