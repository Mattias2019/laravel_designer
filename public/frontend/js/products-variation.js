var get_products_img, frontendLocalizationString;
$(document).ready(function() {
	if($('#frontend_all_msg_with_localization').length>0){
		frontendLocalizationString = JSON.parse( $('#frontend_all_msg_with_localization').val() );
	}
  /**
     * Variations data handling
     */
  
  //change event   
  $('.variations-content-main').on('change', '.variation-options-lists input:radio', function(){
    var all_set             = false;
    var any_set             = false;
    var current_settings_ary = [];
    
    //count checked radio
    $('.variations-content-main').find('.variation-options-lists input:radio:checked').each( function() {
      var current_settings    = {};
      // Encode entities
      value = $(this).val()
          .replace(/&/g, '&')
          .replace(/"/g, '"')
          .replace(/'/g, "'")
          .replace(/</g, '<')
          .replace(/>/g, '>');
     
      current_settings['attr_name']  = $(this).attr('name');
      current_settings['attr_val']   = value;
      
      current_settings_ary.push( current_settings );
    });
     
    //send selected variations data
    if($('.variations-content-main').find('.variation-options-lists input:radio:checked').length == $('.variations-content-main').find('.variations-line').length){
      all_set = true;
    }
    else{
      any_set = true;
    }
    
    if(all_set && !any_set){
      find_matching_variations( current_settings_ary );
    }
  });
});

//find matching variations
function find_matching_variations( settings ){
  var no_match_value = false;
  var variations = $('.variations-content-main').data('variations_details');
  
  if(variations.length > 0){
    for(var count = 0; count < variations.length; count++){
      if(variations[count].status == 1){
        if(variations_match( variations[count]._variation_array_data, settings)){
          
          //img settings
          if(!get_products_img){
            get_products_img = $('#product_single_page .product-main-image img').attr('src');
          }
          
          
          if(variations[count]._variation_post_img_url){
            $('#product_single_page .selected-variation-product img').attr('src', $('#hf_base_url').val() + variations[count]._variation_post_img_url);
            $('#product_single_page .selected-variation-product').show();
            $('#product_single_page .product-main-content').hide();
          }
          else{
            $('#product_single_page .selected-variation-product').show();
            $('#product_single_page .selected-variation-product img').attr('src', $('#hf_base_url').val() + '/public/images/no-image.png');
            $('#product_single_page .product-main-content').hide();
          }
          
          
          //price settings
          var price_html = '';
//          
					if($('.variations-content-main').length>0 && $('.variations-content-main').data('is_login') == 'yes' && $('.variations-content-main').data('login_user_slug') !== '' && variations[count]._is_role_based_pricing_enable == 1){
						var data = variations[count]._role_based_pricing_array; 
						
						if(Object.keys(data).length > 0){
							$.each( data, function( key, value ) {
								if(key == $('.variations-content-main').data('login_user_slug')){
									var regular_price = value.regular_price;
									var sales_price = value.sale_price;
                  
									if( parseFloat(regular_price) && parseFloat(sales_price) && parseFloat(regular_price) > parseFloat(sales_price)){
										price_html += '<span class="offer-price">'+ $('#currency_symbol').val() + parseFloat($('.variations-content-main').data('current_currency_value') * regular_price) +'</span>';
										price_html += '<span class="solid-price">'+ $('#currency_symbol').val() + parseFloat($('.variations-content-main').data('current_currency_value') * sales_price) +'</span>';
									}
									else if(parseFloat(regular_price) && parseFloat(regular_price) !=''){
										price_html += '<span class="solid-price">'+ $('#currency_symbol').val() + parseFloat($('.variations-content-main').data('current_currency_value') * regular_price) +'</span>';
									}
								}
							});
						}
					}
					else{
						if( variations[count]._variation_post_regular_price && variations[count]._variation_post_regular_price > 0 && variations[count]._variation_post_sale_price && variations[count]._variation_post_sale_price > 0 && parseFloat(variations[count]._variation_post_regular_price) >  parseFloat(variations[count]._variation_post_sale_price) ){
							price_html += '<span class="offer-price">'+ $('#currency_symbol').val() + parseFloat($('.variations-content-main').data('current_currency_value') * variations[count]._variation_post_regular_price)  +'</span>';
						}
							price_html += '<span class="solid-price">'+ $('#currency_symbol').val() +  parseFloat($('.variations-content-main').data('current_currency_value') * variations[count]._variation_post_price)  +'</span>';
					}
          
          $('.variation-price-label').html( price_html );
          
          
          //offer price message
          var price_msg_html = ''; 
          if( variations[count]._variation_post_regular_price && variations[count]._variation_post_sale_price && parseFloat(variations[count]._variation_post_regular_price) >  parseFloat(variations[count]._variation_post_sale_price) && variations[count]._variation_post_sale_price_start_date && variations[count]._variation_post_sale_price_end_date){
            price_msg_html = '<div class="offer-message-container"><p class="offer-message-label">&#10148; '+ frontendLocalizationString.offer_msg + ' <i>' + variations[count]._variation_post_sale_price_start_date +' ' + frontendLocalizationString.offer_msg + ' ' + variations[count]._variation_post_sale_price_end_date +'</i></p><br></div>';
            
            $('.variation-price-label').after( price_msg_html );
          }
          
          
          //stock message
          var stock_message = '';
          if((variations[count]._variation_post_manage_stock == 1 && variations[count]._variation_post_manage_stock_qty > 0 && variations[count]._variation_post_stock_availability == 'variation_in_stock') && (variations[count]._variation_post_back_to_order == 'variation_allow_notify_customer' || variations[count]._variation_post_back_to_order == 'variation_only_allow')){
            if(variations[count]._variation_post_back_to_order == 'variation_allow_notify_customer'){
              stock_message = '<div class="stock-message"><p>&#10148; '+ frontendLocalizationString.stock_available +'</p></div>';
              $('.add-to-cart-content').append( stock_message );
            }
            
            $('#selected_variation_id').val( variations[count].id );
          
            if($('.no-product-available-msg').length>0){
              $('.no-product-available-msg').remove();
            }
            $('.add-to-cart-content').fadeIn();
          }
          else if(variations[count]._variation_post_manage_stock == 1 && variations[count]._variation_post_manage_stock_qty == 0 || variations[count]._variation_post_manage_stock == 1 && variations[count]._variation_post_back_to_order == 'variation_not_allow' || variations[count]._variation_post_manage_stock == 1 && variations[count]._variation_post_stock_availability == 'variation_out_of_stock'){
            if($('.stock-message-error').length>0){
              $('.stock-message-error').remove();
            }
            stock_message = '<div class="stock-message-error"><p>&#10148; '+ frontendLocalizationString.out_of_stock +'</p></div>';
            $('.variations-data').after( stock_message );
          }
          else if(variations[count]._variation_post_manage_stock == 0 && variations[count]._variation_post_stock_availability == 'variation_in_stock'){
            $('#selected_variation_id').val( variations[count].id );
            
            if($('.no-product-available-msg').length>0){
              $('.no-product-available-msg').remove();
            }
            $('.add-to-cart-content').fadeIn();
          }
          else if(variations[count]._variation_post_manage_stock == 0 && variations[count]._variation_post_stock_availability == 'variation_out_of_stock'){
            if($('.stock-message-error').length>0){
              $('.stock-message-error').remove();
            }
            stock_message = '<div class="stock-message-error"><p>&#10148; '+ frontendLocalizationString.out_of_stock +'</p></div>';
            $('.variations-data').after( stock_message );
          }
            
          //
          no_match_value = false;
          return true;
        }
        else{
          no_match_value = true;
        }
      }
    }
    
    if(no_match_value){
      //change default settings
      
      $('#product_single_page .selected-variation-product').hide();
      $('#product_single_page .selected-variation-product img').attr('src', '');
      $('#product_single_page .product-main-content').show();
      
      if($('.offer-message-container').length>0){
        $('.offer-message-container').remove();
      }
      
      if($('.stock-message').length>0){
        $('.stock-message').remove();
      }
      
      $('#selected_variation_id').val( '' );
      
      $('.add-to-cart-content').fadeOut();
      
      if($('.variations-data').length > 0){
        $('.variations-data').after('<div class="no-product-available-msg" style="padding-top:10px;color:#FF0000; font-weight:bold;">'+ frontendLocalizationString.no_product_available_label +'</div>');
      }
    }
  }
}

//check variations match
function variations_match( attr1, attr2 ){
  var variations_settings = {};
  var remove_attr_name = '';
  var selected_variations = {};
  
  if(attr1.length > 0){
    for(var count1 = 0; count1<attr1.length; count1++){
      if(attr1[count1].attr_val !== 'all'){
        variations_settings[ stringResize(attr1[count1].attr_name) ] = stringResize(attr1[count1].attr_val);
      }
      else if(attr1[count1].attr_val === 'all'){
        remove_attr_name = stringResize(attr1[count1].attr_name);
      }
    }
  }
  
  if(attr2.length > 0){
    for(var count2 = 0; count2 < attr2.length; count2++){
      if(attr2[ count2 ].attr_name !== remove_attr_name){
        selected_variations[ attr2[ count2 ].attr_name ] = attr2[ count2 ].attr_val;
      }
    }
  }  
  
  
  if( JSON.stringify(variations_settings) === JSON.stringify(selected_variations) ){
    return true;
  }
}

function stringResize(requestStr){
  var Str = requestStr;
  Str = String(Str).toLowerCase();
  Str = Str.replace(/\s+/g, "-");
  
  return Str;
}