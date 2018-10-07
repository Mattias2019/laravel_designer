var designerControl = designerControl || {};
var localizationString;
designerControl.onPageLoad = 
{
  _init:function()
  {
    designerControl.event._dynamic_tab_event();
    designer.event._chnage_dynamic_text();
    designer.event._chnage_dynamic_text_fonts();
    designer.event._chnage_dynamic_color();
    designer.event._chnage_dynamic_text_align();
    designer.event._chnage_dynamic_text_fontWeight();
    designer.event._chnage_dynamic_text_decoration();
    designer.event._chnage_dynamic_text_shadow();
    designer.event._chnage_dynamic_more_options();
    designer.event._enable_curved_text();
    designer.event._remove_selected_object();
    designer.event._curved_text_reverse_change();
    designer.event._remove_design_modal();
    designerControl.event._gallery_img_show();
    designerControl.event._swap_panel();
    designerControl.event._design_images_switching();
    designer.event._save_custom_design();
    designer.event._add_restricted_area();
    designer.event._remove_custom_design();
    designerControl.event._gallery_img_add_at_canvas();
    designerControl.event._shape_add_at_canvas();
    designer.event._add_to_cart_process();
    
    if($('#admin_all_msg_with_localization').length>0)
    {
      localizationString = JSON.parse( $('#admin_all_msg_with_localization').val() );
    }
    else if($('#frontend_all_msg_with_localization').length>0)
    {
      localizationString = JSON.parse( $('#frontend_all_msg_with_localization').val() );
    }
    
    
    $('[data-toggle="tooltip"]').tooltip();
    
    //upload image
    if($('#file_upload_for_designer').length>0)
    {
      Dropzone.autoDiscover = false;
      $("#file_upload_for_designer").dropzone({ 
        url: $('#hf_base_url').val() + "/upload/designer-images",
        paramName: "designer_upload_images", 
        acceptedFiles:  "image/*", 
        uploadMultiple:false, 
        maxFiles:1, 
        autoProcessQueue: true, 
        parallelUploads: 100, 
        addRemoveLinks: true, 
        maxFilesize: 1,
        headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
        init: function() 
        {
          this.on("maxfilesexceeded", function(file){
              swal("" , localizationString.maxfilesexceeded_msg);
          });
          this.on("error", function(file, message){
            if (file.size > 1*1024*1024) 
            {
              swal("" , localizationString.file_larger);
              this.removeFile(file)
               return false;
            }
            if(!file.type.match('image.*')) {
              swal("" , localizationString.image_file_validation);
              this.removeFile(file)
              return false;
            }
          });
          //this.on("addedfile", function(file) { swal("Good job!", "Successfully uploaded your image!", "success") });
          this.on("success", function(file, responseText) 
          {
            if(responseText.status === 'success')
            {
              swal(localizationString.good_job, localizationString.image_upload_success, "success");
              
              if($('.recently-uploaded-images').find('.recent-images-items').length>0){
                $('.recently-uploaded-images').find('.recent-images-items:last').after('<div class="recent-images-items"><img src="'+ $('#hf_base_url').val() +'/public/uploads/'+ responseText.img_name +'"></div>');
              }
              else{
                if($('.no-available-msg').length>0){
                  $('.no-available-msg').remove();
                }
                
                $('.recently-uploaded-images').append('<div class="recent-images-items"><img src="'+ $('#hf_base_url').val() +'/public/uploads/'+ responseText.img_name +'"></div><div class="clear_both"></div>');
              }
              
              designerControl.event._gallery_img_add_at_canvas();

              this.removeAllFiles();
            }
          });
        }
      });
    }
    
    if($('#designPreview').length>0){
      $('#designPreview').on('hidden.bs.modal', function () {
        $('#designPreview .modal-body img').attr('src', '');
      });
    }
  }
};

designerControl.event = 
{
  _dynamic_tab_event:function(){
    if($('.nav-design-element').length>0 || $('.product-designer-left-menu').length>0){
      $('.nav-design-element li, .product-designer-left-menu ul li').click(function(){
        allPanelHide();
        
        if($('.product-designer-left-menu').length>0){
          $(this).parents('.product-designer-left-menu').find('.selected-left-menu').removeClass('selected-left-menu');
          $(this).addClass('selected-left-menu');
        }
        
        if($(this).data('tab_name') === 'text'){
          designer.function._add_dynamic_text_to_design();
        }
        else if($(this).data('tab_name') === 'clipart'){
          designer.function._image_gallery();
        }
        else if($(this).data('tab_name') === 'image_upload'){
          designer.function._image_upload_option();
        }
        else if($(this).data('tab_name') === 'shape_add'){
          designer.function._shape_object();
        }
        else if($(this).data('tab_name') === 'manage_layer'){
          designer.function._manage_layer();
        }
        else if($(this).data('tab_name') === 'preview'){
          designer.function._img_preview();
        }
      });
    }
  },
  
  _gallery_img_show:function()
  {
    if($( '.designer-image-gallery .gallery-items' ).length>0){
      $( '.designer-image-gallery .gallery-items' ).on('click', function(){
        var obj = $(this);
        obj.append('<div class="art-cat-img-loader"></div>');
        
        $.ajax({
            url: $('#hf_base_url').val() + '/ajax/get-clipart-categories-images-with-html',
            type: 'POST',
            cache: false,
            headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') }, 
            data: {id:$(this).data('cat_id')},

            success: function(data){
              if(data && data != ''){
                obj.parents('.designer-image-gallery').find('.art-cat-img-loader').remove();
                $('.designer-image-gallery .panel-body .gallery-image-categories-list').after( data );
                $('.designer-image-gallery .panel-body .gallery-image-categories-list').hide();
                show_gallery_image_cat_list_event();
                designerControl.event._gallery_img_add_at_canvas();
              }
            },

            error:function(){}
        });
      });
    }
  },
  
  _gallery_img_add_at_canvas:function()
  {
    if($('.categories-images-items').length>0 || $('.recent-images-items').length>0)
    {
      $('.categories-images-items, .recent-images-items').on('click', function()
      {
        if($(this).hasClass('categories-images-items'))
        {
          designer.function._dynamic_image_add_at_design( 'gallery_img', $(this).find('img').attr('src') );
        }
        else if($(this).hasClass('recent-images-items'))
        {
          designer.function._dynamic_image_add_at_design( 'upload_image', $(this).find('img').attr('src') );
        }
      });
    }
  },
  
  _shape_add_at_canvas:function(){
    if($('.designer-shape-gallery ul li').length>0){
      $('.designer-shape-gallery ul li').on('click', function(){
        var shape = Base64.decode($(this).data('shape'));
        designer.function._add_shape_to_canvas( shape );
      });
    }
  },
  
  _swap_panel:function(){
    if($('.icon-img-swap').length>0 && $('#swap-popover-content')){
      var placement = 'bottom';
      
      if($('#is_product_save').length>0){
        placement = 'bottom';
      }
      
      $(".icon-img-swap").popover({
      placement : placement,
      html: true, 
          content: function() {
            return $('#swap-popover-content').html();
          }
      }).parent().on('click', '.design-title-items', function(){
        designer.function._manage_swap_content($(this));
      })
    }
  },
  
  _design_images_switching:function(){
    if($('.product-designer-swap-content').length>0){
      $('.product-designer-swap-content ul li').on('click', function(){
        $(this).parents('.product-designer-swap-content').find('.selected-swap').removeClass('selected-swap');
        $(this).addClass('selected-swap');
        designer.function._manage_swap_content($(this));
      })
    }
  }
};

var show_gallery_image_cat_list_event = function()
{
  if($('.categories-images-list .show-categories-list').length>0)
  {
    $('.categories-images-list .show-categories-list').on('click', function(e)
    {
      e.preventDefault();
      show_gallery_image_cat_list();
    });
  }
}

var show_gallery_image_cat_list = function()
{
  if($('.gallery-image-categories-list').length>0)
  {
    $('.gallery-image-categories-list').show();
  }
  if($('.categories-images-list').length>0)
  {
    $('.categories-images-list').remove();
  }
}

var _makeid = function()
{
  var text = "";
  var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

  for( var i=0; i < 5; i++ )
      text += possible.charAt(Math.floor(Math.random() * possible.length));

  return text;
}

var _scaleImageSize = function(maxW, maxH, currW, currH)
{
  var ratio = currH / currW;
  if(currW >= maxW && ratio <= 1)
  {
    currW = maxW;
    currH = currW * ratio;
  } 
  else if(currH >= maxH)
  {
    currH = maxH;
    currW = currH / ratio;
  }
  return [currW, currH];
}

var allPanelHide = function(){
  canvasDeactivateAll();
  if($('.designer-text-control').css('display') === 'block'){
    $('.designer-text-control').hide();
  }
  
  if($('.designer-image-gallery').css('display') === 'block'){
    $('.designer-image-gallery').hide();
  }
  
  if($('.designer-image-edit-panel').css('display') === 'block'){
    $('.designer-image-edit-panel').hide();
  }
  
  if($('.designer-upload-image').css('display') === 'block'){
    $('.designer-upload-image').hide();
  }
  
  if($('.designer-shape-gallery').css('display') === 'block'){
    $('.designer-shape-gallery').hide();
  }
  
  if($('.designer-layer-content').css('display') === 'block'){
    $('.designer-layer-content').hide();
  }
  
  if($('.icon-img-swap').hasClass('in')){
    $('.icon-img-swap').popover('hide');
  }
  
}

var createBlob = function( canvastoDataURL )
{
  var blobBin = atob(canvastoDataURL.split(',')[1]);
  var array = [];
  for(var i = 0; i < blobBin.length; i++) {
      array.push(blobBin.charCodeAt(i));
  }
  var file = new Blob([new Uint8Array(array)], {type: 'image/png'});

  return file;
}

$(document).ready(function(){
  designerControl.onPageLoad._init();
});