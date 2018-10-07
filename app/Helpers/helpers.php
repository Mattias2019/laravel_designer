<?php
use shopist\Library\GetFunction;

/**
 * Get function for product title
 *
 * @param product id
 * @return string 
 */
function get_product_title($product_id = '')
{
  return GetFunction::title($product_id);
}

/**
 * Get function for product slug
 *
 * @param product id
 * @return string 
 */
function get_product_slug($product_id = '')
{
  return GetFunction::product_slug($product_id);
}

/**
 * Get function for products image
 *
 * @param product id
 * @return json obj
 */

// 900
function get_product_image($product_id = '')
{
  return GetFunction::product_img($product_id);
}

/**
 * Get function for products price
 *
 * @param product id
 * @return double or integer number
 */
function get_product_price($product_id)
{
  return GetFunction::product_price($product_id);
}

/**
 * Get function for products brands list
 *
 * @param product id
 * @return obj
 */
function get_product_brands_lists($product_id)
{
  return GetFunction::product_brands_lists($product_id);
}

/**
 * Brands list using comma separator for product single page 
 * @param brands list {array}
 * @return string
 */
function get_single_page_product_brands_lists($brand_list)
{
  return GetFunction::single_page_product_brands_lists($brand_list);
}

/**
 * Tags list using comma separator for product single page 
 * @param tags list {array}
 * @return string
 */
function get_single_page_product_tags_lists($tags_list)
{
  return GetFunction::single_page_product_tags_lists($tags_list);
}

/**
 * Categories list using comma separator for product single page 
 * @param product id
 * @return string
 */
function get_single_page_product_categories_lists($product_id)
{
  return GetFunction::single_page_product_categories_lists($product_id);
}

/**
 * Get function for extension
 *
 * @param url
 * @return string
 */
function get_extension($url = '')
{
  return GetFunction::check_extension($url);
}

/**
 * Get function for products categories
 *
 * @param cat data
 * @return obj
 */
function get_product_categories_lists($cat_array)
{
  return GetFunction::product_categories_lists($cat_array);
}

/**
 * Get function for products parent categories list
 *
 * @param null
 * @return array
 */
function get_product_parent_categories()
{
  return GetFunction::product_parent_categories();
}

/**
 * Get function for products tags
 *
 * @param tag data
 * @return obj
 */
function get_product_tags_lists( $product_id )
{
  return GetFunction::product_tags_lists( $product_id );
}

/**
 * Get function for products using tag slug
 *
 * @param tag slug
 * @return array
 */
function get_products_by_product_tag_slug( $slug )
{
  return GetFunction::products_by_product_tag_slug( $slug );
} 

/**
 * Get function for products type
 *
 * @param Product id
 * @return string
 */
function get_product_type($product_id = '')
{
  return GetFunction::product_type($product_id);
}

/**
 * Get function for products variation
 *
 * @param Product id
 * @return array
 */
function get_product_variations($product_id = '')
{
  return GetFunction::product_variations($product_id);
}

/**
 * Get function for products variation with data
 *
 * @param Product id
 * @return array
 */
function get_product_variations_with_data($product_id = '')
{
  return GetFunction::product_variations_with_data($product_id);
}

/**
 * Get function for min to max price
 *
 * @param Currency symbol, product id
 * @return string
 */
function get_product_variations_min_to_max_price_html($currency, $product_id = '')
{
  return GetFunction::product_variations_min_to_max_price_html($currency, $product_id);
}

/**
 * Get function for current currency symbol
 *
 * @param null
 * @return html code
 */
function get_current_currency_symbol()
{
  return GetFunction::current_currency_symbol();
}

/**
 * Get function for currency symbol by code
 *
 * @param currency code
 * @return html code
 */
function get_currency_symbol_by_code($code)
{
  return GetFunction::currency_symbol_by_code($code);
}

/**
 * Get function for current currency name
 *
 * @param null
 * @return string
 */
function get_current_currency_name()
{
  return GetFunction::current_currency_name();
}

/**
 * Get function for country list
 *
 * @param null
 * @return array
 */
function get_country_list()
{
  return GetFunction::get_all_countries();
}

/**
 * Get function for country 
 *
 * @param Country code
 * @return string
 */
function get_country_by_code($code = '')
{
  return GetFunction::get_country_name_by_code( $code );
}

/**
 * Get function for designer uploaded recent image
 *
 * @param null
 * @return array
 */
function get_recent_uploaded_images_for_designer()
{
  return GetFunction::recent_uploaded_images_for_designer();
}

/**
 * Get function for designer image by token
 *
 * @param token id
 * @return array
 */
function get_customize_images_by_access_token($access_token)
{
  return GetFunction::customize_images_by_access_token($access_token);
}

/**
 * Get function for designer image by token at admin
 *
 * @param product id, order id, token id
 * @return array
 */
function get_admin_customize_images_by_access_token($product_id, $order_id, $access_token)
{
  return GetFunction::admin_customize_images_by_access_token($product_id, $order_id, $access_token);
}

/**
 * Get function for payment method title
 *
 * @param payment method code
 * @return string
 */
function get_payment_method_title($payment_method)
{
  return GetFunction::payment_method_title($payment_method);
}

/**
 * Get function for current user data
 *
 * @param null
 * @return array
 */
function get_current_admin_user_info()
{
  return GetFunction::current_admin_user_info();
}

/**
 * Get function for current frontend user data
 *
 * @param null
 * @return array
 */
function get_current_frontend_user_info()
{
  return GetFunction::current_frontend_user_info();
}

/**
 * Get function for current frontend vendor data
 *
 * @param null
 * @return array
 */
function get_current_vendor_user_info()
{
  return GetFunction::current_vendor_user_info();
}

/**
 * Check vendor login
 *
 * @param null
 * @return boolean
 */
function is_vendor_login()
{
  return GetFunction::check_vendor_login();
}

/**
 * Check admin login
 *
 * @param null
 * @return boolean
 */
function is_admin_login()
{
  return GetFunction::check_admin_login();
}

/**
 * String parse like url format
 *
 * @param any string
 * @return string
 */
function string_slug_format($str)
{
  return GetFunction::create_slug_format($str);
}

/**
 * Check product is enable for customize design
 *
 * @param product id
 * @return boolean
 */
function is_design_enable_for_this_product($product_id)
{
  return GetFunction::check_design_enable_by_product_id($product_id);
}

/**
 * Get function for product review
 *
 * @param product id
 * @return array
 */
function get_product_review($product_id)
{
  return GetFunction::product_review($product_id);
}

/**
 * Create price view using selected options
 *
 * @param price value, currency_code no required
 * @return html 
 */
function price_html($price, $currency_code = null)
{
  return GetFunction::create_price_view($price, $currency_code);
}

/**
 * Get user details
 *
 * @param user id
 * @return array
 */
function get_user_details( $user_id )
{
  return GetFunction::get_user_all_details( $user_id );
}

/**
 * Get frontend user account details
 *
 * @param user id
 * @return array
 */
function get_user_account_details_by_user_id( $user_id )
{
  return GetFunction::get_user_account_details( $user_id );
}

/**
 * Get product availability
 *
 * @param product id
 * @return string
 */
function get_product_availability( $product_id )
{
  return GetFunction::product_availability( $product_id );
}

/**
 * Get available currency name
 *
 * @param null
 * @return array
 */
function get_available_currency_name()
{
  return GetFunction::available_currency_name();
}

/**
 * Get currency convert price, if user changed the currency for the convert price, otherwise return default price 
 *
 * @param amount
 * @return string
 */
function get_product_price_html_by_filter($amount)
{
  return GetFunction::product_price_by_filter($amount);
}

/**
 * Get running appearance settings for frontend 
 *
 * @param null
 * @return string
 */
function current_appearance_settings()
{
  return GetFunction::frontend_current_appearance_settings();
}

/**
 * Get header slider data
 *
 * @param null
 * @return array
 */
function get_appearance_header_settings_data()
{
  return GetFunction::appearance_header_settings_data();
}

/**
 * Get available languages data
 *
 * @param null
 * @return array
 */
function get_available_languages_data()
{
  return GetFunction::available_languages_data();
}

/**
 * Get available languages data for frontend
 *
 * @param null
 * @return array
 */
function get_available_languages_data_frontend()
{
  return GetFunction::available_languages_data_frontend();
}

/**
 * Get default language
 *
 * @param null
 * @return array
 */
function get_default_languages_data()
{
  return GetFunction::default_languages_data();
}

/**
 * Frontend selected language by user
 *
 * @param null
 * @return array
 */
function get_frontend_selected_languages_data()
{
  return GetFunction::frontend_selected_languages_data();
}

/**
 * Frontend selected currency
 *
 * @param null
 * @return array
 */
function get_frontend_selected_currency_data()
{
  return GetFunction::frontend_selected_currency_data();
}

/**
 * Frontend selected currency by user
 *
 * @param null
 * @return string
 */
function get_frontend_selected_currency()
{
  return GetFunction::frontend_selected_currency();
}

/**
 * Get permissions files list
 *
 * @param null
 * @return array
 */
function get_permissions_files_list()
{
  return GetFunction::permissions_files_list();
}

/**
 * Get roles details by role slug
 *
 * @param role_slug
 * @return array
 */
function get_roles_details_by_role_slug($role_slug)
{
  return GetFunction::roles_details_by_role_slug( $role_slug );
}

/**
 * Get role name by role slug
 *
 * @param role_slug
 * @return string
 */
function get_role_name_by_role_slug($role_slug)
{
  return GetFunction::role_name_by_role_slug( $role_slug );
}

/**
 * Get roles details by role id
 *
 * @param role_id
 * @return array
 */
function get_roles_details_by_role_id($role_id)
{
  return GetFunction::roles_details_by_role_id( $role_id );
}

/**
 * Get available roles
 *
 * @param null
 * @return array
 */
function get_available_user_roles()
{
  return GetFunction::available_user_role();
}

/**
 * Get currency name by code
 *
 * @param currency code
 * @return string
 */
function get_currency_name_by_code( $code )
{
  return GetFunction::currency_name_by_code( $code );
}

/**
 * Get site logo image
 *
 * @param null
 * @return string
 */
function get_site_logo_image()
{
  return GetFunction::site_logo_image();
}

/**
 * Get site title
 *
 * @param null
 * @return string
 */
function get_site_title()
{
  return GetFunction::site_title();
}

/**
 * Get appearance settings 
 *
 * @param null
 * @return array
 */
function get_appearance_settings()
{
  return GetFunction::appearance_settings();
}

/**
 * Get testimonial data by slug
 *
 * @param testimonial slug
 * @return array
 */
function get_testimonial_data_by_slug($slug)
{
  return GetFunction::testimonial_data_by_slug($slug);
}

/**
 * Get all testimonial data
 *
 * @param testimonial status (optional), ex: 1 for active, 0 for inactive
 * @return array
 */
function get_all_testimonial_data()
{
  return GetFunction::all_testimonial_data();
}

/**
 * Limit the string output
 *
 * @param string, number
 * @return string
 */
function get_limit_string($str,$val)
{
  return GetFunction::limit_string($str,$val);
}

/**
 * Get all blogs data
 *
 * @param blogs status (optional), ex: 1 for active, 0 for inactive
 * @return array
 */
function get_all_blogs_data($status = null)
{
  return GetFunction::all_blogs_data($status);
}

/**
 * Get blog postmeta data by post id and meta key
 *
 * @param post id, meta key 
 * @return string
 */
function get_blog_postmeta_data($post_id, $metakey)
{
  return GetFunction::blog_postmeta_data($post_id, $metakey);
}

/**
 * Check array key, value 
 *
 * @param array, key, value
 * @return boolean
 */
function is_key_value_exists($array, $key, $value)
{
  return GetFunction::key_value_exists($array, $key, $value);
}

/**
 * Get global SEO data
 *
 * @param null
 * @return array
 */
function get_seo_data()
{
  return GetFunction::seo_data();
}

/**
 * Get Subscription data
 *
 * @param null
 * @return array
 */
function get_subscription_data()
{
  return GetFunction::subscription_data();
}

/**
 * Get subscription settings data
 *
 * @param null
 * @return array
 */
function get_subscription_settings_data()
{
  return GetFunction::subscription_settings_data();
}

/**
 * Get comments by object id and target name
 *
 * @param object id, target name
 * @return array
 */
function get_comments_data_by_object_id($object_id, $target)
{
  return GetFunction::comments_data_by_object_id($object_id, $target);
}

/**
 * Get total comments for per object 
 *
 * @param object id, target name
 * @return number
 */
function get_comments_rating_details($object_id, $target)
{
  return GetFunction::comments_rating_details($object_id, $target);
}

/**
 * Get reviews settings data by product id
 *
 * @param product id
 * @return number
 */
function get_reviews_settings_data($product_id)
{
  return GetFunction::reviews_settings_data($product_id);
}

/**
 * Get current page
 *
 * @param null
 * @return string
 */
function get_current_page_name()
{
  return GetFunction::current_page_name();
}

/**
 * Get customer order billing and shipping information
 *
 * @param order_id
 * @return array
 */
function get_customer_order_billing_shipping_info($order_id)
{
  return GetFunction::customer_order_billing_shipping_info($order_id);
}

/**
 * Check permission for admin url
 *
 * @param null
 * @return boolean
 */
function is_sufficient_permission()
{
  return GetFunction::check_sufficient_permission();
}

/**
 * Check frontend user is logged in  
 *
 * @param null
 * @return boolean
 */
function is_frontend_user_logged_in()
{
  return GetFunction::frontend_user_logged_in();
}

/**
 * Get stripe API data
 *
 * @param null
 * @return array
 */
function get_stripe_api_key()
{
  return GetFunction::stripe_api_key();
}

/**
 * Get 2checkout API data
 *
 * @param null
 * @return array
 */
function get_twocheckout_api_data()
{
  return GetFunction::twocheckout_api_data();
}

/**
 * Get recaptcha data 
 *
 * @param null
 * @return array
 */
function get_recaptcha_data ()
{
  return GetFunction::recaptcha_data();
}

/**
 * Get nexmo data 
 *
 * @param null
 * @return array
 */
function get_nexmo_data ()
{
  return GetFunction::nexmo_data();
}

/**
 * String encode 
 *
 * @param string
 * @return encode string
 */
function string_encode ($str)
{
  return GetFunction::create_string_encode($str);
}

/**
 * String decode 
 *
 * @param string
 * @return decode string
 */
function string_decode ($str)
{
  return GetFunction::create_string_decode($str);
}

/**
 * Default placeholder image src
 *
 * @param null
 * @return string
 */
function default_placeholder_img_src ()
{
  return GetFunction::placeholder_img_src();
}

/**
 * Default avatar image src
 *
 * @param null
 * @return string
 */
function default_avatar_img_src ()
{
  return GetFunction::avatar_img_src();
}

/**
 * Default upload sample image src
 *
 * @param null
 * @return string
 */
function default_upload_sample_img_src ()
{
  return GetFunction::upload_sample_img_src();
}

/**
 * Default vendor cover image src
 *
 * @param null
 * @return string
 */
function default_vendor_cover_img_src ()
{
  return GetFunction::vendor_cover_img_src();
}

/**
 * Get role based pricing data
 *
 * @param product id
 * @return array
 */
function get_role_based_pricing_by_product_id ($product_id)
{
  return GetFunction::role_based_pricing_by_product_id($product_id);
}

/**
 * Get role based pricing data for variable product
 *
 * @param product id
 * @return array
 */
function get_variable_product_role_based_pricing_by_product_id ($product_id)
{
  return GetFunction::variable_product_role_based_pricing_by_product_id($product_id);
}

/**
 * Get price checked by user role
 *
 * @param product id, price
 * @return integer
 */
function get_role_based_price_by_product_id ($product_id, $price)
{
  return GetFunction::role_based_price_by_product_id($product_id, $price);
}

/**
 * Get currency convert value
 *
 * @param product currency from, currency to, amount
 * @return double
 */
function get_currency_convert_value ($from, $to, $amount)
{
  return GetFunction::currency_convert_value($from, $to, $amount);
}

/**
 * Get download files
 *
 * @param post_id
 * @return array
 */
function get_download_files ( $post_id )
{
  return GetFunction::download_files( $post_id );
}

/**
 * create downloadable file html
 *
 * @param array, order_id
 * @return string
 */
function download_file_html ( $post_id, $data = array(), $order_id )
{
  return GetFunction::create_download_files_html( $post_id, $data, $order_id);
}


/**
 * Get IP address
 *
 * @param null
 * @return string
 */
function get_ip_address ()
{
  return GetFunction::ip_address();
}

/**
 * Get image url
 *
 * @param img relative path
 * @return img url
 */
function get_image_url ($img_path)
{
  return GetFunction::create_image_url($img_path);
}

/**
 * Get upsell products
 *
 * @param product_id
 * @return array
 */
function get_upsell_products ($product_id)
{
  return GetFunction::upsell_products($product_id);
}

/**
 * Get crosssell products
 *
 * @param product_id
 * @return array
 */
function get_crosssell_products ($product_id)
{
  return GetFunction::crosssell_products($product_id);
}

/**
 * Get users by role id
 *
 * @param role_id, extra search term
 * @return array
 */
function get_users_by_role_id($role_id, $extra_search_term = null, $flag = null)
{
  return GetFunction::users_by_role_id($role_id, $extra_search_term, $flag);
}

/**
 * Get vendor details by product id
 *
 * @param product_id
 * @return array
 */
function get_vendor_details_by_product_id($product_id)
{
  return GetFunction::vendor_details_by_product_id($product_id);
}

/**
 * Get vendor name by product id
 *
 * @param product_id
 * @return string
 */
function get_vendor_name_by_product_id($product_id)
{
  return GetFunction::vendor_name_by_product_id($product_id);
}

/**
 * Get vendor id by product id
 *
 * @param product_id
 * @return integer
 */
function get_vendor_id_by_product_id($product_id)
{
  return GetFunction::vendor_id_by_product_id($product_id);
}

/**
 * Get total products for specific author
 *
 * @param author_id
 * @return integer
 */
function get_author_total_products($author_id)
{
  return GetFunction::author_total_products($author_id);
}

/**
 * Get vendor name
 *
 * @param author_id
 * @return string
 */
function get_vendor_name($author_id)
{
  return GetFunction::vendor_name($author_id);
}

/**
 * Check vendor product exist
 *
 * @param cart object
 * @return boolean
 */
function vendor_product_exist_in_cart_object( $cart_object )
{
  return GetFunction::check_vendor_product_exist_in_cart_object( $cart_object );
}

/**
 * Get sub order by original order id
 *
 * @param order_id
 * @return array
 */

function get_sub_order_by_order_id($order_id){
  return GetFunction::sub_order_by_order_id( $order_id );
}

/**
 * Get sub order total by sub order id
 *
 * @param sub_order_id
 * @return number
 */

function get_sub_order_total_by_order_id($order_id){
  return GetFunction::sub_order_total_by_order_id( $order_id );
}

/**
 * Get sub order process key by sub order id
 *
 * @param sub_order_id
 * @return number
 */

function get_sub_order_process_key_by_order_id($order_id){
  return GetFunction::sub_order_process_key_by_order_id( $order_id );
}

/**
 * Get vendor name by order id
 *
 * @param order_id
 * @return string
 */

function get_vendor_name_by_order_id($order_id){
  return GetFunction::vendor_name_by_order_id( $order_id );
}

/**
 * Get vendor sub orders by order id
 *
 * @param order_id
 * @return array
 */

function get_vendor_sub_order_by_order_id($order_id){
  return GetFunction::vendor_sub_order_by_order_id( $order_id );
}

/**
 * Get vendor withdraw by user id and status
 *
 * @param user_id, status
 * @return object
 */

function get_vendor_withdraw_by_user_and_status($user_id, $status){
  return GetFunction::vendor_withdraw_by_user_and_status( $user_id, $status );
}

/**
 * Get author id by product id
 *
 * @param product_id
 * @return integer number
 */

function get_author_id_by_product_id($product_id){
  return GetFunction::author_id_by_product_id( $product_id );
}

/**
 * Get package details for vendor
 *
 * @param vendor_id
 * @return array
 */

function get_package_details_by_vendor_id( $vendor_id ){
  return GetFunction::package_details_by_vendor_id( $vendor_id );
}

/**
 * Check is vendor expired
 *
 * @param vendor_id
 * @return boolean
 */

function is_vendor_expired( $vendor_id ){
  return GetFunction::check_is_vendor_expired( $vendor_id );
}

/**
 * Get payment details by vendor id
 *
 * @param vendor_id
 * @return array
 */

function get_payment_details_by_vendor_id( $vendor_id ){
  return GetFunction::payment_details_by_vendor_id( $vendor_id );
}


/**
 * Get user name
 *
 * @param user_id
 * @return string
 */

function get_user_name_by_user_id( $user_id ){
  return GetFunction::user_name_by_user_id( $user_id );
}

/**
 * Get vendor settings
 *
 * @param null
 * @return array
 */

function get_vendor_settings_data(){
  return GetFunction::vendor_settings_data();
}

/**
 * Get emails option
 *
 * @param null
 * @return array
 */

function get_emails_option_data(){
  return GetFunction::emails_option_data();
}

/**
 * Check is variation exist to variation combination 
 *
 * @param product_id, array
 * @return boolean
 */

function is_variation_exist_in_combination($product_id, $combination = array()){
  return GetFunction::variation_exist_in_combination($product_id, $combination);
}

/**
 * Get settings data
 *
 * @param null
 * @return array
 */

function global_settings_data(){
  return GetFunction::settings_data();
}

/**
 * Get post extra
 *
 * @param post_id, key_name
 * @return string
 */
function get_post_extra($post_id, $key_name){
  return GetFunction::post_extra($post_id, $key_name);
}

/**
 * Check permission for menu heading
 *
 * @param menu heading slug
 * @return boolean
 */
function check_permission_menu_heading($heading_slug){
  return GetFunction::permission_menu_heading($heading_slug);
}

/**
 * Get vendors order details by order id
 *
 * @param order_id
 * @return integer
 */
function get_vendor_id_by_order_id( $order_id ){
  return GetFunction::vendor_id_by_order_id( $order_id );
}


