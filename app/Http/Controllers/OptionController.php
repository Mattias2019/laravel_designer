<?php
namespace shopist\Http\Controllers;

use shopist\Http\Controllers\Controller;
use shopist\Models\Option;


class OptionController extends Controller
{
  /**
   * 
   * Get shipping
   *
   * @param null
   * @return array
   */
  public function getShippingMethodData(){
    $get_shipping = null;
    $get_shipping_option = $this->getOptionData('_shipping_method_data');
    
    if(!empty($get_shipping_option)){
      $get_shipping = unserialize($get_shipping_option->option_value);
    }
    
    return $get_shipping;
  }
  
  /**
   * 
   * Get settings
   *
   * @param null
   * @return array
   */
  public function getSettingsData(){
    $get_settings = null;
    $get_settings_option = $this->getOptionData('_settings_data');
    
    if(!empty($get_settings_option)){
      $get_settings = unserialize($get_settings_option->option_value);
    }
    
    return $get_settings;
  }
  
  /**
   * 
   * Get custom designer settings
   *
   * @param null
   * @return array
   */
  public function getCustomDesignerSettingsData(){
    $get_custom_designer_settings = null;
    $get_custom_designer_settings_option = $this->getOptionData('_custom_designer_settings_data');
    
    if(!empty($get_custom_designer_settings_option)){
      $get_custom_designer_settings = unserialize($get_custom_designer_settings_option->option_value);
    }
    
    return $get_custom_designer_settings;
  }
  
  /**
   * 
   * Get payment 
   *
   * @param null
   * @return array
   */
  public function getPaymentMethodData(){
    $get_payment = null;
    $get_payment_option = $this->getOptionData('_payment_method_data');
    
    if(!empty($get_payment_option)){
      $get_payment = unserialize($get_payment_option->option_value);
    }
    
    return $get_payment;
  }
  
  /**
   * 
   * Get appearance
   *
   * @param null
   * @return array
   */
  public function getAppearanceData(){
    $get_appearance = null;
    $get_appearance_option = $this->getOptionData('_appearance_tab_data');
    
    if(!empty($get_appearance_option)){
      $get_appearance = unserialize($get_appearance_option->option_value);
    }
    
    return $get_appearance;
  }
  
  /**
   * 
   * Get permissions list
   *
   * @param null
   * @return array
   */
  public function getPermissionsFilesList(){
    $get_permissions_list = null;
    $get_permissions_list_option = $this->getOptionData('_permissions_files_list');
    
    if(!empty($get_permissions_list_option)){
      $get_permissions_list = unserialize($get_permissions_list_option->option_value);
    }
    
    return $get_permissions_list;
  }
  
  /**
   * 
   * Get SEO data
   *
   * @param null
   * @return array
   */
  public function getSEOData(){
    $get_seo = null;
    $get_seo_option = $this->getOptionData('_seo_data');
    
    if(!empty($get_seo_option)){
      $get_seo = unserialize($get_seo_option->option_value);
    }
    
    return $get_seo;
  }
  
  /**
   * 
   * Get subscription data
   *
   * @param null
   * @return array
   */
  public function getSubscriptionData(){
    $get_subscription = null;
    $get_subscription_option = $this->getOptionData('_subscription_data');
    
    if(!empty($get_subscription_option)){
      $get_subscription = unserialize($get_subscription_option->option_value);
    }
    
    return $get_subscription;
  }
  
  /**
   * 
   * Get subscription settings data
   *
   * @param null
   * @return array
   */
  public function getSubscriptionSettingsData(){
    $get_subscription_settings = null;
    $get_subscription_settings_option = $this->getOptionData('_subscription_settings_data');
    
    if(!empty($get_subscription_settings_option)){
      $get_subscription_settings = unserialize($get_subscription_settings_option->option_value);
    }
    
    return $get_subscription_settings;
  }
  
  /**
   * 
   * Get product compare data
   *
   * @param null
   * @return object
   */
  public function getProductCompareData(){
    $get_product_compare = null;
    $get_product_compare_option = $this->getOptionData('_product_compare_more_fields_name');
    
    if(!empty($get_product_compare_option)){
      $get_product_compare = json_decode($get_product_compare_option->option_value);
    }
    
    return $get_product_compare;
  }
  
  /**
   * 
   * Get compare option exist
   *
   * @param null
   * @return object
   */
  public function getCompareOption(){
    $get_product_compare_option = null;
    $get_product_compare_option = $this->getOptionData('_product_compare_more_fields_name');
    
    return $get_product_compare_option;
  }
  
  /**
   * 
   * Get vendor settings option data
   *
   * @param null
   * @return object
   */
  public function getVendorSettingsData(){
    $get_option = null;
    $get_option_vendor_settings = $this->getOptionData('_vendor_settings_data');
    
    if(!empty($get_option_vendor_settings)){
      $get_option = unserialize($get_option_vendor_settings->option_value);
    }
    
    return $get_option;
  }
		
		/**
   * 
   * Get emails notifications save data
   *
   * @param null
   * @return object
   */
  public function getEmailsNotificationsData (){
    $get_option = null;
    $get_option_emails_data = $this->getOptionData('_emails_notification_data');
    
    if(!empty($get_option_emails_data)){
      $get_option = unserialize($get_option_emails_data->option_value);
    }
    
    return $get_option;
  }
  
  /**
   * 
   * Get option data dynamically 
   *
   * @param option name
   * @return object
   */
  public function getOptionData($option_name){
    $get_option = null;
    $get_option_data = Option :: where('option_name', $option_name)->first();
    
    if(!empty($get_option_data)){
      $get_option = $get_option_data;
    }
    
    return $get_option;
  }
}