<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'The :attribute must be accepted.',
    'active_url'           => 'The :attribute is not a valid URL.',
    'after'                => 'The :attribute must be a date after :date.',
    'alpha'                => 'The :attribute may only contain letters.',
    'alpha_dash'           => 'The :attribute may only contain letters, numbers, and dashes.',
    'alpha_num'            => 'The :attribute may only contain letters and numbers.',
    'array'                => 'The :attribute must be an array.',
    'before'               => 'The :attribute must be a date before :date.',
    'between'              => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file'    => 'The :attribute must be between :min and :max kilobytes.',
        'string'  => 'The :attribute must be between :min and :max characters.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => 'The :attribute field must be true or false.',
    'confirmed'            => 'The :attribute confirmation does not match.',
    'date'                 => 'The :attribute is not a valid date.',
    'date_format'          => 'The :attribute does not match the format :format.',
    'different'            => 'The :attribute and :other must be different.',
    'digits'               => 'The :attribute must be :digits digits.',
    'digits_between'       => 'The :attribute must be between :min and :max digits.',
    'email'                => 'The :attribute must be a valid email address.',
    'exists'               => 'The selected :attribute is invalid.',
    'filled'               => 'The :attribute field is required.',
    'image'                => 'The :attribute must be an image.',
    'in'                   => 'The selected :attribute is invalid.',
    'integer'              => 'The :attribute must be an integer.',
    'ip'                   => 'The :attribute must be a valid IP address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => 'The :attribute may not be greater than :max.',
        'file'    => 'The :attribute may not be greater than :max kilobytes.',
        'string'  => 'The :attribute may not be greater than :max characters.',
        'array'   => 'The :attribute may not have more than :max items.',
    ],
    'mimes'                => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => 'The :attribute must be at least :min.',
        'file'    => 'The :attribute must be at least :min kilobytes.',
        'string'  => 'The :attribute must be at least :min characters.',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => 'The selected :attribute is invalid.',
    'numeric'              => 'The :attribute must be a number.',
    'regex'                => 'The :attribute format is invalid.',
    'required'             => 'The :attribute field is required.',
    'required_if'          => 'The :attribute field is required when :other is :value.',
    'required_with'        => 'The :attribute field is required when :values is present.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => 'The :attribute and :other must match.',
    'size'                 => [
        'numeric' => 'The :attribute must be :size.',
        'file'    => 'The :attribute must be :size kilobytes.',
        'string'  => 'The :attribute must be :size characters.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => 'The :attribute has already been taken.',
    'url'                  => 'The :attribute format is invalid.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],
    'whoops'                                                  =>  'Whoops!',
    'input_error'                                             =>  'There were some problems with your input.',
    'billing_fill_first_name_field'                           =>  'please fill billing First Name field',
    'shipping_fill_first_name_field'                          =>  'please fill shipping First Name field',
    'billing_fill_last_name_field'                            =>  'please fill billing Last Name field',
    'billing_fill_phone_number_field'                         =>  'please fill billing Phone Number field',
    'shipping_fill_last_name_field'                           =>  'please fill shipping Last Name field',
    'billing_fill_email_field'                                =>  'please fill billing Email field',
    'shipping_fill_email_field'                               =>  'please fill shipping Email field',
    'billing_fill_valid_email_field'                          =>  'please fill valid Email in billing field',
    'shipping_fill_valid_email_field'                         =>  'please fill valid Email in shipping field',
    'billing_country_name_field'                              =>  'please select billing Country Name field',
    'shipping_country_name_field'                             =>  'please select shipping Country Name field',
    'billing_address_line_1_field'                            =>  'please fill billing Address Line 1 field',
    'shipping_address_line_1_field'                           =>  'please fill shipping Address Line 1 field',
    'billing_fill_town_city_field'                            =>  'please fill billing Town Or City field',
    'shipping_fill_town_city_field'                           =>  'please fill shipping Town Or City field',
    'billing_fill_zip_postal_field'                           =>  'please fill billing Zip Or Postal Code field',
    'shipping_fill_zip_postal_field'                          =>  'please fill shipping Zip Or Postal Code field',
    'shipping_fill_phone_number_field'                        =>  'please fill shipping Phone Number field',
    'fill_payment_gateway'                                    =>  'please select Payment Gateway',
    'stripe_required_msg'                                     =>  'Stripe token key need to continue the process',
    'twocheckout_required_msg'                                =>  'TwoCheckout token key need to continue the process',		
    'display_name_required'                                   =>  'Please fill Display Name field',
    'user_name_required'                                      =>  'Please fill User Name field',
    'user_name_unique'                                        =>  'User name field is unique, try with another one',
    'email_required'                                          =>  'Please fill Email Address field',
    'email_unique'                                            =>  'Email address field is unique, try with another one',
    'email_is_email'                                          =>  'Please fill with correct email address',
    'password_required'                                       =>  'Please fill Password field',
    'password_confirmation_required'                          =>  'Please fill Password Confirmation field',
    'secret_key_required'                                     =>  'Please fill Secret Key field',
    'g_recaptcha_response_required'                           =>  'Please manage recaptcha response',
    'new_password_required'                                   =>  'Please fill New Password field',
    'account_bill_first_name'                                 =>  'Please fill Billing First Name field',
    'account_bill_last_name'                                  =>  'Please fill Billing Last Name field',
    'account_bill_phone_number_name'                          =>  'Please fill Billing Phone Number field',
    'account_bill_select_country'                             =>  'Please Select Country Name field',
    'account_bill_adddress_line_1'                            =>  'Please fill Address Line 1 field',
    'account_shipping_first_name'                             =>  'Please fill Shipping First Name field',
    'account_shipping_last_name'                              =>  'Please fill Shipping Last Name field',
    'account_bill_email_address'                              =>  'please fill Billing Email field',
    'account_bill_email_address_is_email'                     =>  'Please fill Billing Email field with correct email address',
    'account_bill_select_country'                             =>  'please Select Billing Country Name field',
    'account_bill_adddress_line_1'                            =>  'please fill Billing Address Line 1 field',
    'account_bill_town_or_city'                               =>  'please fill Billing Town Or City field',
    'account_bill_zip_or_postal_code'                         =>  'please fill Billing Zip Or Postal Code field',
    'account_shipping_email_address'                          =>  'please fill Shipping Email field',
    'account_shipping_email_address_is_email'                 =>  'Please fill Shipping Email field with correct email address',
    'account_shipping_select_country'                         =>  'please Select Shipping Country Name field',
    'account_shipping_adddress_line_1'                        =>  'please fill Shipping Address Line 1 field',
    'account_shipping_town_or_city'                           =>  'please fill Shipping Town Or City field',
    'account_shipping_zip_or_postal_code'                     =>  'please fill Shipping Zip Or Postal Code field',
    'account_shipping_phone_number_name'                      =>  'Please fill Shipping Phone Number field',
    'select_rating'                                           =>  'please select a rating',
    'write_review'                                            =>  'please write your review',
    'coupon_not_exists_msg'                                   =>  'Coupon does not exist!',
    'coupon_min_spend_msg'                                    =>  'The minimum spend for this coupon is',
    'coupon_max_spend_msg'                                    =>  'The maximum spend for this coupon is',
    'coupon_no_login_msg'                                     =>  'need to login as a user for using this coupon',
    'coupon_no_role_match_msg'                                =>  'role user is not applicable for this coupon',  
    'coupon_expired_msg'                                      =>  'Now this coupon has expired',
    'coupon_already_sxist_label'                              =>  'Sorry, this coupon already exist',
    'exceed_from_cart_total_msg'                              =>  'Discount price can not be greater than from cart total',
    'coupon_removed_from_cart_msg'                            =>  'Coupon has been removed from cart for some condition false',
    'vendor_reg_store_name'                                   =>  'please fill Store Name',
    'vendor_reg_address_line_1'                               =>  'please fill Address Line 1',
    'vendor_reg_city'                                         =>  'please fill City',
    'vendor_reg_state'                                        =>  'please fill State',
    'vendor_reg_country'                                      =>  'please fill Country',
    'vendor_reg_zip_code'                                     =>  'please fill Zip Code',
    'vendor_reg_phone_number'                                 =>  'please fill Phone Number',
    'vendor_reg_secret_key'                                   =>  'please fill Secret Key',
    't_and_c'                                                 =>  'please read Terms and Conditions and select',
    'all_vendor_max_products'                                 =>  'please enter max number of products',
    'vendor_expired_type'                                     =>  'Please select vendor expired type',
    'vendor_commission'                                       =>  'Please enter vendor commission',
    'payment_options'                                         =>  'Please select vendor payment withdraw options',
    'package_type'                                            =>  'Please select package type',
    'vendor_custom_expired_date'                              =>  'Please enter custom expired date',
    'vendor_package_type_unique_msg'                          =>  'Your given package type has already been taken.',
    'select_vendor_payment_type_msg'                          =>  'Select payment type',
    'select_vendor_payment_method_msg'                        =>  'Select payment method',
    'enter_single_payment_custom_value'                       =>  'Please enter single payment custom value'
];
