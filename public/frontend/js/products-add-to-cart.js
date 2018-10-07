var frontendLocalizationString;
$(document).ready(function() 
{
	if($('#frontend_all_msg_with_localization').length>0){
		frontendLocalizationString = JSON.parse( $('#frontend_all_msg_with_localization').val() );
	}
  /**
	 * product add to cart
	 */

  //ajax request for add to cart
  if($('.add-to-cart-bg').length>0 || $('.single-page-add-to-cart').length>0){
    dynamicAddToCart();
  }
});

var dynamicAddToCart= function(){
  $('.add-to-cart-bg, .single-page-add-to-cart').on('click', function(e){
    e.preventDefault();
    var dataObj = {};
    //var target  = null;
    
    //var attr = $(this).attr('data-target');
    
//    if (typeof attr !== typeof undefined && attr !== false) {
//      attr = $(this).data('target');
//    }
    
    dataObj['product_id'] = $(this).data('id');

    if($('#quantity').length>0){
      dataObj['qty'] = parseInt( $('#quantity').val() );
    }
    else{
      dataObj['qty'] = 1;
    }

    if($('#selected_variation_id').length>0 && $('#selected_variation_id').val()){
      dataObj['variation_id'] = parseInt( $('#selected_variation_id').val() );
    }
   
    
    $('#shadow-layer, .add-to-cart-loader').show();
    $.ajax({
        url: $('#hf_base_url').val() + '/ajax/add-to-cart',
        type: 'POST',
        cache: false,
        datatype: 'json',
        headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
        data: dataObj,

        success: function(data){
          if(data && data == 'zero_price'){
            $('#shadow-layer, .add-to-cart-loader').hide();
            swal("" , frontendLocalizationString.price_can_not_be_zero );
          }
          else if(data && data == 'out_of_stock'){
            $('#shadow-layer, .add-to-cart-loader').hide();
            swal("" , frontendLocalizationString.product_out_of_stock );
          }
          else if(data && data == 'vendor_not_same'){
            $('#shadow-layer, .add-to-cart-loader').hide();
            swal("" , frontendLocalizationString.vendor_not_same_msg );
          }
          else if(data && data == 'item_added'){
            $.ajax({
                url: $('#hf_base_url').val() + '/ajax/get-mini-cart-data',
                type: 'POST',
                cache: false,
                datatype: 'json',
                headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },

                success: function(data){
                  if(data.status && data.status == 'success' && data.type == 'mini_cart_data' && data.html){

                    $('.mini-cart-content').html( data.html );
                    $('#shadow-layer, .add-to-cart-loader').hide();

                    if($('.show-mini-cart').length>0){
                      $('.show-mini-cart').off('click').on('click', function(e){
                        e.preventDefault();
                        e.stopPropagation();

                        $('#list_popover').fadeToggle();return false;
                      });
                    }

                    $('#list_popover').fadeIn();
                    $("html, body").animate({ scrollTop: 0 }, "slow");
                    return false;
                  }
                },
                error:function(){}
            });
          }
        },
        error:function(){}
    });
  });
}