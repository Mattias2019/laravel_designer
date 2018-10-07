var shopist = shopist || {};

var clickTrackForDesignerUploader = '';
var attrUpdateId = '';
var productBar, reportProductTitleDataTable;
var adminLocalizationString;
var currentFrontendAddTextOnImageId;
var $headerTextSize, $sidebarTitleTextSize, $sidebarContentTextSize, $productBoxContentTextSize;

shopist.pageLoad =
{
  elementLoad:function()
  {
    if($('#admin_all_msg_with_localization').length>0){
      adminLocalizationString = JSON.parse( $('#admin_all_msg_with_localization').val() );
    }
    
    if($('.dynamic-editor').length>0 || $('.dynamic-editor-slider-text').length>0 || $('.dynamic-editor-slider-advanced-css').length>0){
      $('.dynamic-editor, .dynamic-editor-slider-text, .dynamic-editor-slider-advanced-css').summernote({ 
        height: 250,                
        minHeight: null,             
        maxHeight: null,             
        focus: false,
        placeholder: 'Content here...'
      });
    }
    		
    $('.shopist-iCheck').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%'
    });
    
    if($('.permissions-file').length>0){
      var numberOfChecked = $('.permissions-file input:checkbox:checked').length;
      var numberOfCheckbox = $('.permissions-file input:checkbox').length;
      
      if((numberOfChecked == numberOfCheckbox) || (numberOfChecked == (numberOfCheckbox -1))){
        $('#allow_permissions_all').prop('checked', true);
      }
      else{
        $('#allow_permissions_all').prop('checked', false);
      }
    }
    
    //category search for vendor
    if($('.vendor-parents-cat').length>0){
      var vendorCatTags = $(".vendor-parents-cat").tagsManager();
      
      $(".vendor-parent-cat-typeahead").typeahead({
        source: function(query, process) {
            $.ajax({
                url: $('#hf_base_url').val() + '/ajax/get_categories_for_vendor',
                data: { query: query },
                headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
                success: function (data) {
                  data = $.parseJSON(data);
                  return process(data);
                }
            });
        },
        afterSelect :function (item){
          vendorCatTags.tagsManager("pushTag", item.name + ' #' + item.id );

          var selected_vendor_cat  =  [];
          if($('#selected_vendor_categories').val().length > 0){
            var parse1 = JSON.parse($('#selected_vendor_categories').val());

            if($.inArray(item.name + ' #' + item.id, parse1) == -1){
              parse1.push(item.name + ' #' + item.id);
              $('#selected_vendor_categories').val(JSON.stringify(parse1));
            }
          }
          else{
            selected_vendor_cat.push(item.name + ' #' + item.id);
            $('#selected_vendor_categories').val(JSON.stringify(selected_vendor_cat));
          }
        }
      });
      
      $('.vendor-parent-cat-typeahead').on('tm:spliced tm:popped', function (event, tag) {
        if($('#selected_vendor_categories').val().length > 0){
          var parse1 = JSON.parse($('#selected_vendor_categories').val());
          var newArray = $.grep(parse1, function(value) {
            return value != tag;
          });
          
          $('#selected_vendor_categories').val(JSON.stringify(newArray));
        }
		  });
      
      if($('#selected_vendor_categories').val().length>0){
        var cat_parse = JSON.parse($('#selected_vendor_categories').val());
        for(var cat_i = 0; cat_i < cat_parse.length; cat_i++){
          vendorCatTags.tagsManager("pushTag", cat_parse[cat_i] );
        }
      }
    }
		
    
    //upsells and crosssells search
		if($('.upsells-input').length>0 || $('.crosssells-input').length>0){
			var link_type_name = '';
      var product_id  = 0;
			var upsellsTags = $(".upsells-input").tagsManager();
			var crosssellsTags = $(".crosssells-input").tagsManager();
			
      if($('#product_id').length>0 && $('#product_id').val() != '' && $('#product_id').val().length>0){
        product_id = $('#product_id').val();
      }
      
      $(".products-typeahead").typeahead({
        source: function(query, process) {
            $.ajax({
                url: $('#hf_base_url').val() + '/ajax/get_products_for_linked_type',
                data: {
                  query: query, product_id: product_id
                },
                headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
                success: function (data) {
                  data = $.parseJSON(data);
                  return process(data);
                }
            });
        },
        afterSelect :function (item){
					if(link_type_name !='' && link_type_name == 'upsell'){
						upsellsTags.tagsManager("pushTag", item.name + ' #' + item.id );
            
            var selected_upsell_data  =  [];
            if($('#selected_upsell_products').val().length > 0){
              var parse1 = JSON.parse($('#selected_upsell_products').val());
              
              if($.inArray(item.name + ' #' + item.id, parse1) == -1){
                parse1.push(item.name + ' #' + item.id);
                $('#selected_upsell_products').val(JSON.stringify(parse1));
              }
            }
            else{
              selected_upsell_data.push(item.name + ' #' + item.id);
              $('#selected_upsell_products').val(JSON.stringify(selected_upsell_data));
            }
					}
					else if(link_type_name !='' && link_type_name == 'crosssell'){
						crosssellsTags.tagsManager("pushTag", item.name + ' #' + item.id );
            
            var selected_crosssell_data  =  [];
            if($('#selected_crosssell_products').val().length > 0){
              var parse2 = JSON.parse($('#selected_crosssell_products').val());
              
              if($.inArray(item.name + ' #' + item.id, parse2) == -1){
                parse2.push(item.name + ' #' + item.id);
                $('#selected_crosssell_products').val(JSON.stringify(parse2));
              }
            }
            else{
              selected_crosssell_data.push(item.name + ' #' + item.id);
              $('#selected_crosssell_products').val(JSON.stringify(selected_crosssell_data));
            }
					}
        }
      });
			
			$('.upsells-input, .crosssells-input').on('click', function(){
				link_type_name = $(this).data('target');
			});
      
      $('.upsells-input').on('tm:spliced tm:popped', function (event, tag) {
        if($('#selected_upsell_products').val().length > 0){
          var parse1 = JSON.parse($('#selected_upsell_products').val());
          var newArray = $.grep(parse1, function(value) {
            return value != tag;
          });
          
          $('#selected_upsell_products').val(JSON.stringify(newArray));
        }
		  });
      
      $('.crosssells-input').on('tm:spliced tm:popped', function (event, tag) {
        if($('#selected_crosssell_products').val().length > 0){
          var parse2 = JSON.parse($('#selected_crosssell_products').val());
          var newArray = $.grep(parse2, function(value) {
            return value != tag;
          });
          
          $('#selected_crosssell_products').val(JSON.stringify(newArray));
        }
		  });
      
      if($('#selected_upsell_products').val().length>0){
        var upsell_parse = JSON.parse($('#selected_upsell_products').val());
        for(var u_i = 0; u_i < upsell_parse.length; u_i++){
          upsellsTags.tagsManager("pushTag", upsell_parse[u_i] );
        }
      }
      
      if($('#selected_crosssell_products').val().length>0){
        var crosssell_parse = JSON.parse($('#selected_crosssell_products').val());
        for(var c_i = 0; c_i < crosssell_parse.length; c_i++){
          crosssellsTags.tagsManager("pushTag", crosssell_parse[c_i] );
        }
      }
		}
    
    if($('#send_announcement').length>0){
      $('#send_announcement').select2().on('change', function() {
        if($(this).val() == 'selected_vendor'){
          $('#send_selected_vendor').show();
        }
        else{
          $('#send_selected_vendor').hide();
          $('#selected_vendors').val('');
        }
      });
      
      //search
      var vendorList = $(".vendor-lists-input").tagsManager();
      $(".vendor-lists-typeahead").typeahead({
        source: function(query, process) {
            $.ajax({
                url: $('#hf_base_url').val() + '/ajax/get_all_vendor',
                data: {
                  query: query
                },
                headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
                success: function (data) {
                  data = $.parseJSON(data);
                  return process(data);
                }
            });
        },
        afterSelect :function (item){
					vendorList.tagsManager("pushTag", item.name + ' #' + item.id );
            
          var selected_vendor_data  =  [];
          if($('#selected_vendors').val().length > 0){
            var parse1 = JSON.parse($('#selected_vendors').val());

            if($.inArray(item.name + ' #' + item.id, parse1) == -1){
              parse1.push(item.name + ' #' + item.id);
              $('#selected_vendors').val(JSON.stringify(parse1));
            }
          }
          else{
            selected_vendor_data.push(item.name + ' #' + item.id);
            $('#selected_vendors').val(JSON.stringify(selected_vendor_data));
          }
        }
      });
      
      //remove from list
      $('.vendor-lists-input').on('tm:spliced tm:popped', function (event, tag) {
        if($('#selected_vendors').val().length > 0){
          var parse1 = JSON.parse($('#selected_vendors').val());
          var newArray = $.grep(parse1, function(value) {
            return value != tag;
          });
          
          $('#selected_vendors').val(JSON.stringify(newArray));
        }
		  });
      
      //add vendors after save
      if($('#selected_vendors').val().length>0){
        var vendor_parse = JSON.parse($('#selected_vendors').val());
        for(var v_i = 0; v_i < vendor_parse.length; v_i++){
          vendorList.tagsManager("pushTag", vendor_parse[v_i] );
        }
      }
    }
    
    if($('#inputSalePriceStartDate').length>0 || $('#inputSalePriceEndDate').length>0 || $('#inputVariationSalePriceStartDate').length>0 || $('#inputVariationSalePriceEndDate').length>0 || $('#filter_start_date').length>0 || $('#filter_end_date').length>0 || $('#inputUsageStartDate').length>0 || $('#inputUsageEndDate').length>0 || $('#download_expiry').length>0 || $('#inputExpiredDate').length>0){
      $('#inputSalePriceStartDate,#inputSalePriceEndDate,#inputVariationSalePriceStartDate,#inputVariationSalePriceEndDate,#filter_start_date,#filter_end_date,#inputUsageStartDate,#inputUsageEndDate, #download_expiry, #inputExpiredDate').datepicker({ format: 'yyyy-mm-dd'});
    }
    
    reportProductTitleDataTable = $('#table_for_report_product_title').dataTable();
    
    if($('.select2').length>0 || $('#change_order_status').length>0 || $('#change_conditions_type').length>0 ||$('#user_role_usage_restriction').length>0 || $('.vendors-list').length>0 )
    {
      $(".select2, #change_order_status, #change_conditions_type, #user_role_usage_restriction, .vendors-list").select2();
    }
    
    $('#addDynamicCategories').on('hidden.bs.modal', function () 
    {
      shopist.pageLoad.cat_popup_element_clear();
    });
    
    $('#addDynamicTags').on('hidden.bs.modal', function () 
    {
      shopist.pageLoad.tag_popup_element_clear();
    });
    
    $('#addDynamicVariations').on('hidden.bs.modal', function () 
    {
      shopist.pageLoad.variation_popup_element_clear();
    });
    
    $('#addDynamicTextOnImage').on('hidden.bs.modal', function () 
    {
      $('#advanced_custom_css').val(null);
      $("#add_text_on_image_editor").val(null);
    });
    
    if($('#inputVariationRegularPrice').length>0)
    {
      $('#inputVariationRegularPrice, #inputVariationSalePrice, #inputVariationStockQty, .pricing-textbox, .variation-download-limit').keyup(function () 
      {
        shopist.normalFunction.numberValidation(this);
      });
    }
    
    if($('#accordion').length>0)
    {
      $('.collapse').on('shown.bs.collapse', function(){
      $(this).parent().find(".glyphicon-plus").removeClass("glyphicon-plus").addClass("glyphicon-minus");
      }).on('hidden.bs.collapse', function(){
      $(this).parent().find(".glyphicon-minus").removeClass("glyphicon-minus").addClass("glyphicon-plus");
      });
    }
    
    if($('.product-tab-content').length>0)
    {
      $('.product-tab-content').on( 'shown.bs.tab', 'a[data-toggle="tab"]', function (e) {
        if($(e.target).attr('href') == '#tab_variations')
        {
          $('.btn-create-variation').hide();
          $('.btn-check-available-attribute').show();
          $('.variations-panel .attributes-lists').html('');
          $('.variations-panel .attributes-lists').hide();
        }
      })
    }
    
    if($('.view-customize-images').length>0)
    {
      $('.view-customize-images').on('click', function(e)
      {
        e.preventDefault();
        var images = $(this).data('images');
        var html = '';
        
        if(images.length > 0)
        {
          for(var count = 0; count< images.length; count ++)
          {
            html += '<img src= "'+ $('#hf_base_url').val() +'/public/uploads/'+ images[count] +'">';
          }
        }
        
        $('#customizeImages .modal-body').html( html );
        $('#customizeImages').modal('show'); 
      });
    }
    
    if($('.remove-profile-picture').length>0)
    {
      $('.remove-profile-picture').on('click', function()
      {
        $('.no-profile-picture').show();
        $('.profile-picture').hide();
        $('#hf_profile_picture').val('');
      });
    } 
		
    if($('.remove-logo-image').length>0)
    {
      $('.remove-logo-image').on('click', function()
      {
        $('.no-logo-image').show();
        $('.site-logo-container').hide();
        $('#hf_site_picture').val('');
      });
    }
    
    if($('.remove-vendor-cover-image').length>0)
    {
      $('.remove-vendor-cover-image').on('click', function()
      {
        $('.no-cover-image').show();
        $('.vendor-cover-image-container').hide();
        $('#hf_vendor_cover_picture').val('');
      });
    }
		
    if($('#product-title-bar-chart').length>0)
    {
      productBar = new Morris.Bar({
        element: 'product-title-bar-chart',
        resize: true,
        barColors: ['#3C8DBC'],
        xkey: 'y',
        ykeys: 'a',
        labels: [ adminLocalizationString.total + '(' + $('#currency_symbol').val() +')'],
        hideHover: 'auto'
      });
    }
		
    if($('#hf_report_data').length>0 && $('#hf_report_data').val())
    {
      var data = [];
      var parse_product_title_data = JSON.parse($('#hf_report_data').val());

      if($('#report_name').val() == 'sales_by_product_title')
      {
        if(parse_product_title_data.gross_sales_by_product_title)
        {
          $.each(parse_product_title_data.gross_sales_by_product_title, function(key, val){
            data.push({ y: val.product_title, a: val.gross_sales });
          });
        }
      }
      else if($('#report_name').val() == 'sales_by_last_7_days')
      {
        if(parse_product_title_data.sales_order_by_last_7_days.report_data)
        {
          $.each(parse_product_title_data.sales_order_by_last_7_days.report_data, function(key, val){
            data.push({ y: val.day, a: val.gross_sales });
          });
        }
      }
      else if($('#report_name').val() == 'sales_by_custom_days')
      {
        if(parse_product_title_data.sales_order_by_custom_days.report_data)
        {
          $.each(parse_product_title_data.sales_order_by_custom_days.report_data, function(key, val){
            data.push({ y: val.day, a: val.gross_sales });
          });
        }
      }
      else if($('#report_name').val() == 'sales_by_month')
      {
        if(parse_product_title_data.gross_sales_by_month)
        {
          $.each(parse_product_title_data.gross_sales_by_month, function(key, val){
            data.push({ y: val.month.split(',')[0], a: val.gross_sales });
          });
        }
      }
      else if($('#report_name').val() == 'sales_by_payment_method')
      {
        if(parse_product_title_data.gross_sales_by_payment_method)
        {
          $.each(parse_product_title_data.gross_sales_by_payment_method, function(key, val){
            data.push({ y: val.method, a: val.gross_sales });
          });
        }
      }
			
      if($('#product-title-bar-chart').length>0)
      {
        productBar.setData(data);
      }
      
      $('.currency_symbol').html( ' (' + $('#currency_symbol').val() + ')' );
    }
    
    
    if($('#allow_permissions_all').length>0){
      $("#allow_permissions_all").click(function(){
        $('.file-name').not(this).prop('checked', this.checked);      
      });
      
      $(".file-name").click(function(){
        if($('.file-name:checked').length == $('.file-name').length){
          $('#allow_permissions_all').prop('checked',true);
        }
        else{
              $('#allow_permissions_all').prop('checked',false);
        }
      });
    }
    
    if($('.switching-for-default').length>0)
    {
      $(".switching-for-default").change(function(){
        if($(this).is(':checked'))
        {
          $('.switching-for-default').prop('checked', false);
          $(this).prop('checked', true);
          $(this).prop('disabled', false);

        }
        else
        {
          $('.switching-for-default').prop('checked', false);
        }
      });
    }
    
    if($('#appearance_menu_list').length>0){
      $('#appearance_menu_list ul li').on('click', function(e){
          e.preventDefault();
          $('#appearance_menu_list ul li.active').removeClass('active');
          $(this).addClass('active');
          
          $('#appearance_menu_list_content').find('.list-content').hide();
          $('#appearance_menu_list_content_for_' + $(this).data('target')).show();
      });
    }
    
    if($('#_current_tab').length>0 && $('#_current_tab').val().length>0){
      $('#appearance_menu_list ul li.active').removeClass('active');
      $('#appearance_menu_list ul [data-target="'+ $('#_current_tab').val() +'"]').addClass('active');
      
      $('#appearance_menu_list_content').find('.list-content').hide();
      $('#appearance_menu_list_content_for_' + $('#_current_tab').val()).show();
    }
		
    if($('#change_header_text_size').length>0)
    {
      var header_text_size = $("#change_header_text_size");
      header_text_size.ionRangeSlider({
        min: 10,
        max: 30,
        type: 'single',
        step: 1,
        postfix: "",
        prettify: false,
        hasGrid: false,
        onChange:function(obj)
        {
          $('#header_text_size').val( obj.from );
        }
      });
      
      $headerTextSize = header_text_size.data("ionRangeSlider");
    }
    
    if($('#change_sidebar_title_text_size').length>0)
    {
      var sidebar_title_text_size = $("#change_sidebar_title_text_size");
      sidebar_title_text_size.ionRangeSlider({
        min: 10,
        max: 30,
        type: 'single',
        step: 1,
        postfix: "",
        prettify: false,
        hasGrid: false,
        onChange:function(obj)
        {
          $('#sidebar_panel_title_text_size').val( obj.from );
        }
      });
      
      $sidebarTitleTextSize = sidebar_title_text_size.data("ionRangeSlider");
    }
    
    if($('#change_sidebar_content_text_size').length>0)
    {
      var sidebar_content_text_size = $("#change_sidebar_content_text_size");
      sidebar_content_text_size.ionRangeSlider({
        min: 10,
        max: 30,
        type: 'single',
        step: 1,
        postfix: "",
        prettify: false,
        hasGrid: false,
        onChange:function(obj)
        {
          $('#sidebar_panel_content_text_size').val( obj.from );
        }
      });
      
      $sidebarContentTextSize = sidebar_content_text_size.data("ionRangeSlider");
    }
    
    if($('#change_product_box_content_text_size').length>0)
    {
      var product_box_content_text_size = $("#change_product_box_content_text_size");
      product_box_content_text_size.ionRangeSlider({
        min: 10,
        max: 30,
        type: 'single',
        step: 1,
        postfix: "",
        prettify: false,
        hasGrid: false,
        onChange:function(obj)
        {
          $('#product_box_content_text_size').val( obj.from );
        }
      });
      
      $productBoxContentTextSize = product_box_content_text_size.data("ionRangeSlider");
    }
		
    if($('#header_text_size').length>0 && $('#header_text_size').val().length>0){
      $headerTextSize.update({ from: $('#header_text_size').val() });
    }
    
    if($('#sidebar_panel_title_text_size').length>0 && $('#sidebar_panel_title_text_size').val().length>0){
      $sidebarTitleTextSize.update({ from: $('#sidebar_panel_title_text_size').val() });
    }
    
    if($('#sidebar_panel_content_text_size').length>0 && $('#sidebar_panel_content_text_size').val().length>0){
      $sidebarContentTextSize.update({ from: $('#sidebar_panel_content_text_size').val() });
    }
    
    if($('#product_box_content_text_size').length>0 && $('#product_box_content_text_size').val().length>0){
      $productBoxContentTextSize.update({ from: $('#product_box_content_text_size').val() });
    }
		
    
    if($('#inputHeaderCustomCSS').length>0){
      $('#inputHeaderCustomCSS').on('ifChecked', function (event){
        $('.header-custom-css').show();
      });
      $('#inputHeaderCustomCSS').on('ifUnchecked', function (event) {
        $('.header-custom-css').hide();
      });
    }
    
    if($('#inputGeneralCustomCSS').length>0){
      $('#inputGeneralCustomCSS').on('ifChecked', function (event){
        $('.general-custom-css-panel').show();
      });
      $('#inputGeneralCustomCSS').on('ifUnchecked', function (event) {
        $('.general-custom-css-panel').hide();
      });
    } 
    
    if($('#seo_title').length>0){
      $('#seo_title').keyup(function(){
				if($(this).val().length>0){
					$('.seo-preview-content h3').html($(this).val());
				}
        else{
					$('.seo-preview-content h3').html('Page Title');
				}
      });
    }
    
    if($('#seo_description').length>0){
      $('#seo_description').keyup(function(){
				if($(this).val().length>0){
					$('.seo-preview-content .description').html($(this).val());
				}
				else{
					$('.seo-preview-content .description').html( 'Enter your meta tag description.' );
				}
      });
    }
		
		if($('#seo_url_format').length>0){
      $('#seo_url_format').keyup(function(){
				if($(this).val().length>0){
					$('.seo-preview-content .link span').html( shopist.normalFunction.slugify( $(this).val() ));
				}
				else{
					$('.seo-preview-content .link span').html( shopist.normalFunction.slugify('Page Title') );
				}
      });
    }
    
   
    if($('.add_more_downloadable_file').length>0){
      shopist.event.add_downloadable_product_files_dynamically();
    }
		
    $('#productImport').modal({
                        backdrop: 'static',
                        keyboard: false, 
                        show: false
                }); 
                
		$("#product_csv_import").on("submit", function(e){
			e.preventDefault();
      var obj = $(this);
			
      if($('#csvFileImport').val().length>0){
        $(obj).find('.modal-footer .upload-btn-action, .close').prop('disabled', true);
        $(obj).find('.modal-footer .upload-btn-action:first').before('<div class="admin-action-loader"></div>');
        
        $.ajax({
          url: $('#hf_base_url').val() + '/ajax/import_product_file',
          method: "POST",
          data: new FormData(this),
          contentType: false,            
          cache: false,                
          processData: false,
          headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
          success:function(response){ 
            $(obj).find('.modal-footer .upload-btn-action, .close').prop('disabled', false);
            $(obj).find('.admin-action-loader').remove();
        
            if(response.status == 'error' && response.type == 'wrong_extension'){
              swal("" , adminLocalizationString.csv_extension_error_label);
            }
            else if(response.status == 'error' && response.type == 'header_format_mismatch'){
              swal("" , adminLocalizationString.csv_header_error_label);
            }
            else if(response.status == 'error' && response.type == 'not_more_hundred'){
              swal("" , adminLocalizationString.exceed_hundred_products);
            }
            else if(response.status == 'notice' && response.type == 'exceed_product'){
              swal("" , adminLocalizationString.exceed_product_add);
            }
            else if(response.status == 'success' && response.type == 'saved'){
              swal("" , adminLocalizationString.csv_saved_label);
              $('#productImport').modal('hide');
              setTimeout(function(){ window.location.href = window.location.href;  }, 500);
            }
          }
        });
      } 
      else{
        swal("" , adminLocalizationString.choose_csv_file_label);
      }  
    });
    
    $("#downloadableproduct_file_submit").on("submit", function(e){
			e.preventDefault();
			
      if($('#uploadDownloadableProductFile').val().length>0){
        $.ajax({
          url: $('#hf_base_url').val() + '/upload/upload-downloadable-file',
          method: "POST",
          data: new FormData(this),
          contentType: false,            
          cache: false,                
          processData: false,
          headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
          success:function( response ){ 

            if(response.status == 'success'){
              $('#downloadable_file_uploaded_url_' + $('#hf_downloadable_product_file_url_track').val()).val($('#hf_base_url').val() + '/public/uploads/' + response.filename);
            }
            else if(response.status == 'error'){
              swal("" , adminLocalizationString.unknown_msg_label);
            }

            $('#downloadable_file_upload').modal('hide');
          }
        });
      }
      else{
        swal("" , adminLocalizationString.downloadable_choose_file_label);
      }
    });
    
    $("#variableDownloadableproduct_file_submit").on("submit", function(e){
			e.preventDefault();
			
      if($('#uploadDownloadableVariableProductFile').val().length>0){
        $.ajax({
          url: $('#hf_base_url').val() + '/upload/upload-downloadable-file',
          method: "POST",
          data: new FormData(this),
          contentType: false,            
          cache: false,                
          processData: false,
          headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
          success:function( response ){ 

            if(response.status == 'success'){
              $('#variable_downloadable_file_uploaded_url_' + $('#hf_variable_product_downloadable_file_url_track').val()).val($('#hf_base_url').val() + '/public/uploads/' + response.filename);
            }
            else if(response.status == 'error'){
              swal("" , adminLocalizationString.unknown_msg_label);
            }

            $('[data-popup="variableProductDownloadableFileUpload"]').fadeOut(350);
          }
        });
      }
      else{
        swal("" , adminLocalizationString.downloadable_choose_file_label);
      }
    });
       
    if($('.vendors-profile').length>0){
      $('.vendors-profile').on('click', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        $('#vendors_profile .modal-body .eb-overlay-loader').show();
        
        $.ajax({
          url: $('#hf_base_url').val() + '/ajax/get_vendor_profile_by_id',
          type: 'POST',
          cache: false,
          data: {id:id},
          dataType: 'json',
          headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
          success:function(response){ 
            if(response.status == 'success' && response.type == 'vendor_profile'){
              $('#vendors_profile .modal-body').html( response.html );
            }
          }
        });
      });
    }
    
    if($('.vendor-status-change').length>0){
      $('.vendor-status-change').on('click', function (e) {
        e.preventDefault();
        var msg = '';
        var statusChangeMsg = '';
        var responseMsg = '';
        var id = $(this).data('id');
        var target = $(this).data('target');
        var status = '';
        
        if(target == 'enable'){
          msg = adminLocalizationString.you_want_to_enable_vendor_this_item;
          statusChangeMsg = adminLocalizationString.yes_enable_it;
          responseMsg = adminLocalizationString.vendor_enable_update_label;
          status = 1;
        }
        else{
          msg = adminLocalizationString.you_want_to_disable_vendor_this_item;
          statusChangeMsg = adminLocalizationString.yes_disable_it;
          responseMsg = adminLocalizationString.vendor_disable_update_label;
          status = 0;
        }
        
        swal({
          title: adminLocalizationString.are_you_sure,
          text:  msg,
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: statusChangeMsg,
          closeOnConfirm: false
        },
        function(isConfirm){
          if(isConfirm){
            $.ajax({
                  url: $('#hf_base_url').val() + '/ajax/vendor-status-change',
                  type: 'POST',
                  cache: false,
                  datatype: 'json',
                  data: {id:id, status:status},
                  headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
                  success: function(data){
                    if(data.status == 'success' && data.type == 'vendor_status_updated'){
                      swal(adminLocalizationString.updated_label, responseMsg, "success");
                      window.location.href = window.location.href; 
                    }
                  },
                  error:function(){}
            });
          }
        });
      });
    }

    if($('.upload-for-downloadable-product').length>0){
      $('.upload-for-downloadable-product').on('click', function(){
        $('#hf_downloadable_product_file_url_track').val( $(this).data('id') );
        $('#uploadDownloadableProductFile').val( null );
      });
    }
    
    if($('.variable-upload-for-downloadable-product').length>0){
      $('.variable-upload-for-downloadable-product').on('click', function(){
        $('#hf_variable_product_downloadable_file_url_track').val( $(this).data('id') );
        $('#uploadDownloadableVariableProductFile').val( null );
      });
    }
    
    shopist.event.remove_downloadablefile();
    
    $('[data-toggle="popover"]').popover({
        trigger : 'hover'
    });
    
    if($('#inputCustomDateVendor').length>0){
      $('#inputCustomDateVendor').on('ifChanged', function(event){
        if(event.currentTarget.checked) {
          $('.allow-expired-date-picker').show();
        } 
        else if(!event.currentTarget.checked){
          $('.allow-expired-date-picker').hide();
        }
      });
    }
    
    if($('.vendor-package-details').length>0){
      $('.vendor-package-details').on('click', function(e) {
        e.preventDefault();
        var get_package_data = $(this).data('package_details');
        var get_title = $(this).data('title');
        var str = '';
        
        str += '<table>';
        str += '<tr>';
        str += '<td>'+ adminLocalizationString.vendor_package_title_label +'</td>';
        str += '<td>'+ get_title +'</td>';
        str += '</tr>';
        
        str += '<tr>';
        str += '<td>'+ adminLocalizationString.vendor_max_products_label +'</td>';
        str += '<td>'+ get_package_data.max_number_product +'</td>';
        str += '</tr>';
        
        str += '<tr>';
        str += '<td>'+ adminLocalizationString.vendor_show_map_on_store_page_label +'</td>';
        if(get_package_data.show_map_on_store_page == true){
          str += '<td>'+ adminLocalizationString.yes_label +'</td>';
        }else{
          str += '<td>'+ adminLocalizationString.no_label +'</td>';
        }
        str += '</tr>';
        
        str += '<tr>';
        str += '<td>'+ adminLocalizationString.vendor_show_follow_btn_on_store_page_label +'</td>';
        if(get_package_data.show_social_media_follow_btn_on_store_page == true){
          str += '<td>'+ adminLocalizationString.yes_label +'</td>';
        }else{
          str += '<td>'+ adminLocalizationString.no_label +'</td>';
        }
        str += '</tr>';
        
        str += '<tr>';
        str += '<td>'+ adminLocalizationString.vendor_show_share_btn_on_store_page_label +'</td>';
        if(get_package_data.show_social_media_share_btn_on_store_page == true){
          str += '<td>'+ adminLocalizationString.yes_label +'</td>';
        }else{
          str += '<td>'+ adminLocalizationString.no_label +'</td>';
        }
        str += '</tr>';
        
        str += '<tr>';
        str += '<td>'+ adminLocalizationString.vendor_show_contact_form_on_store_page_label +'</td>';
        if(get_package_data.show_contact_form_on_store_page == true){
          str += '<td>'+ adminLocalizationString.yes_label +'</td>';
        }else{
          str += '<td>'+ adminLocalizationString.no_label +'</td>';
        }
        str += '</tr>';
        
        str += '<tr>';
        str += '<td>'+ adminLocalizationString.vendor_expired_type_label +'</td>';
        
        if(get_package_data.vendor_expired_date_type == 'custom_date'){
          str += '<td>'+ adminLocalizationString.custom_date_label +'</td>';
        }
        else if(get_package_data.vendor_expired_date_type == 'lifetime'){
          str += '<td>'+ adminLocalizationString.lifetime_label +'</td>';
        }
        str += '</tr>';
        
        if(get_package_data.vendor_custom_expired_date){
          str += '<tr>';
          str += '<td>'+ adminLocalizationString.vendor_expired_date_label +'</td>';
          str += '<td>'+ get_package_data.vendor_custom_expired_date +'</td>';
          str += '</tr>';
        }
        
        str += '<tr>';
        str += '<td>'+ adminLocalizationString.vendor_commission_label +'</td>';
        str += '<td>'+ get_package_data.vendor_commission +'</td>';
        str += '</tr>';
        
        str += '<tr>';
        str += '<td>'+ adminLocalizationString.min_withdraw_amount_label +'</td>';
        str += '<td>'+ get_package_data.min_withdraw_amount +'</td>';
        str += '</tr>';
        
        str += '</table>';
        
        if(str){
          $('#vendorPackageDetails').find('.modal-body').html( str );
          $('#vendorPackageDetails').modal('show');
        }
      })
    }
    
    if($('.withdraw-requests-data-view').length>0){
      $('.withdraw-requests-data-view').on('click', function(e){
        e.preventDefault();
        var id = $(this).data('requested_id');
        $('#vendors_withdraw_view .modal-body .eb-overlay-loader').show();
        
        $.ajax({
          url: $('#hf_base_url').val() + '/ajax/get_vendor_withdraw_requested_data_by_id',
          type: 'POST',
          cache: false,
          data: {id:id},
          dataType: 'json',
          headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
          success:function(response){ 
            if(response.status == 'success' && response.type == 'vendor_withdraw_request_data'){
              $('#vendors_withdraw_view .modal-body').html( response.html );
            }
          }
        });
      });
    }
    
    if($('.requested-withdraw-status-change').length>0){
      $('.requested-withdraw-status-change').on('click', function(e){
        e.preventDefault();
        var id = $(this).data('requested_id');
        var target = $(this).data('target');
        
        if(target == 'completed'){
          msg = adminLocalizationString.withdrawal_successfully_completed;
          statusChangeMsg = adminLocalizationString.completed_it_label;
          responseMsg = adminLocalizationString.request_completed_msg;
        }
        else{
          msg = adminLocalizationString.withdrawal_successfully_cancelled;
          statusChangeMsg = adminLocalizationString.cancelled_it_label;
          responseMsg = adminLocalizationString.request_cancelled_msg;
        }
        
        swal({
          title: adminLocalizationString.are_you_sure,
          text:  msg,
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: statusChangeMsg,
          closeOnConfirm: false
        },
        function(isConfirm){
          if(isConfirm){
            $.ajax({
                  url: $('#hf_base_url').val() + '/ajax/requested_withdraw_status_change',
                  type: 'POST',
                  cache: false,
                  datatype: 'json',
                  data: {id: id, target:target},
                  headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
                  success: function(response){
                    if(response.status == 'success' && response.type == 'vendor_status_updated'){
                      swal(adminLocalizationString.updated_label, responseMsg, "success");
                      window.location.href = window.location.href; 
                    }
                  },
                  error:function(){}
            });
          }
        });
      });
    }
    
    if($('#settings_tab').length>0){
      $('#settings_tab ul li').on('click', function(){
        $('#hf_settings_target_tab').val( $(this).data('target') );
      });
    }
    
    if($('#withdraw_request_tab').length>0){
      $('#withdraw_request_tab ul li').on('click', function(){
        $('#hf_withdraw_request_target_tab').val( $(this).data('target') );
      });
    }
    
    if($('.show-sub-orders').length>0 && $('.hide-sub-orders').length>0){
     $('.show-sub-orders').on('click', function(e){
       e.preventDefault();
       $('.sub-order-' + $(this).data('order_id')).show();
       $(this).hide();
       $(this).parents('.sub-order-visibility').find('.hide-sub-orders').show();
     });
     
     $('.hide-sub-orders').on('click', function(e){
       e.preventDefault();
       $('.sub-order-' + $(this).data('order_id')).hide();
       $(this).hide();
       $(this).parents('.sub-order-visibility').find('.show-sub-orders').show();
     });
    }
    
    if($('#inputShapeContent').length>0){
      $('#inputShapeContent').on('keyup', function(){
        $('.svg-display').html('');
        $('.svg-display').append($(this).val());
      });
    }
  },
  
  cat_popup_element_clear:function()
  {
    $('#inputCatName, #inputCatSlug, #inputCatDescription').val('');
    $('.cat-img img').attr('src', '');
    $('.cat-img').hide();
    $('.cat-sample-img').show();
    $('.cat-img-upload-btn').hide();
    
    $("#cat_parent option").each(function(){
      if($(this).attr('disabled'))
      {
        $(this).removeAttr('disabled');
      }
    });

    $('#cat_parent').select2();
                
    $('#cat_parent').select2('val', 0);
    $('#cat_status').select2('val', 1);
    $('#inputCatName').css({'border':'1px solid #d2d6de'});
    $('#inputCatSlug').css({'border':'1px solid #d2d6de'});
  },
  
  tag_popup_element_clear:function()
  {
    $('#inputTagName, #inputTagSlug, #inputTagDescription').val('');
    $('#tag_status').select2('val', 1);
    $('#inputTagName').css({'border':'1px solid #d2d6de'});
    $('#inputTagSlug').css({'border':'1px solid #d2d6de'});
  },
  
  variation_popup_element_clear:function()
  {
    $('.variation-img img').attr('src', '');
    $('.variation-img').hide();
    $('.variation-sample-img').show();
    $('.variation-img-upload-btn').hide();
    
    $('#inputVariationEnable, #inputManageVariationStock, #inputEnableTaxesForVariation').iCheck('uncheck');
    $('#inputVariationSKU, #inputVariationRegularPrice, #inputVariationSalePrice, #inputVariationSalePriceStartDate, #inputVariationSalePriceEndDate, #variation_description').val('');
    $('#inputVariationStockQty').val(0);
    $('#variation_backorders_status').select2('val', 'variation_not_allow');
    $('#variation_stock_status').select2('val', 'variation_in_stock');
    
    $('.variation_sale_start_date, .variation_sale_end_date').hide();
    $('.create_variation_sale_schedule').show();
  }
};

shopist.event = 
{
	add_new_fields_for_compare:function(){
		if($('#add_compare_fields').length>0){
			$('#add_compare_fields').on('click', function(){
				shopist.normalFunction.add_compare_fields();
			});
		}
	},
  add_new_fields_for_color_filter:function(){
    if($('#add_filter_colors').length>0){
			$('#add_filter_colors').on('click', function(){
				shopist.normalFunction.add_color_filter_fields();
			});
		}
  },
	remove_product_compare_field:function(){
		if($('#remove_product_compare_fields').length>0){
			$('.remove-product-compare-fields').off('click').on('click', function(){		
				$(this).parents('.product-compare-field-title').remove();
			});
		}
	},
  remove_product_color_filter_field:function(){
    if($('#remove_product_filter_color_field').length>0){
			$('.remove-product-filter-color-field').off('click').on('click', function(){
				$(this).parents('.product-filter-color-title').remove();
			});
		}
  },
  removeProductImage:function()
  {
    if($('.remove-img-link').length>0)
    {
      $('.remove-img-link button').click(function()
      {
        if($(this).data('target') == 'product_image'){
          shopist.normalFunction.remove_product_related_img_from_json_data({source:'product_image'});
          $(this).parents('.uploaded-product-image').find('.product-uploaded-image img').attr('src', '');
          $(this).parents('.uploaded-product-image').find('.product-uploaded-image').hide();
          $(this).parents('.uploaded-product-image').find('.product-sample-img').show();
        }
        else if($(this).data('target') == 'testimonial_image'){
          if($('#image_url').length>0){
            $('#image_url').val('');
          }

          $(this).parents('.uploaded-testimonial-image').find('.testimonial-uploaded-image img').attr('src', '');
          $(this).parents('.uploaded-testimonial-image').find('.testimonial-uploaded-image').hide();
          $(this).parents('.uploaded-testimonial-image').find('.testimonial-sample-img').show();
        }
        else if($(this).data('target') == 'featured_image'){
          if($('#image_url').length>0){
            $('#image_url').val('');
          }

          $(this).parents('.uploaded-featured-image').find('.featured-uploaded-image img').attr('src', '');
          $(this).parents('.uploaded-featured-image').find('.featured-uploaded-image').hide();
          $(this).parents('.uploaded-featured-image').find('.featured-sample-img').show();
        }
      });
    }
  },
  
  adminGalleryImageRemoveBtnDisplay:function()
  {
    if($('.gallery-image-single-container').length>0)
    {
      $('.gallery-image-single-container').hover(			
        function () {
          $(this).find('.remove-gallery-img-link').show();
        }, 

        function () {
          $(this).find('.remove-gallery-img-link').hide();
        }
      );
    }
    
    if($('.art-image-single-container').length>0)
    {
      $('.art-image-single-container').hover(			
        function () {
          $(this).find('.remove-art-img-link').show();
        }, 

        function () {
          $(this).find('.remove-art-img-link').hide();
        }
      );    
    }
    
    if($('.gallery-image-single-container').length>0 || $('.art-image-single-container').length>0)
    {
      shopist.event.adminGalleryImageRemove();  
    }
  },
  
  frontendAllImageRemoveBtnDisplay:function()
  {
    if($('.header-slider-image-single-container').length>0)
    {
      $('.header-slider-image-single-container').hover(			
        function () {
          $(this).find('.remove-frontend-img-link').show();
        }, 

        function () {
          $(this).find('.remove-frontend-img-link').hide();
        }
      );
    }
    
    if($('.header-slider-image-single-container').length>0)
    {
      shopist.event.frontendImageRemove();  
    }
  },
  
  addTextAndCustomCssOnImageDynamically:function(){
    if($('.add-text-and-custom-css-btn').length>0){
      $('.add-text-and-custom-css-btn').on('click', function(){
        currentFrontendAddTextOnImageId = $(this).data('id');
        var getTextForImage = shopist.normalFunction.getSelectedImageText( 'header_slider_images', currentFrontendAddTextOnImageId);
        
        if(getTextForImage.length > 0){
          $(".dynamic-editor-slider-text").summernote('code', getTextForImage[0].html_code);
          $('.dynamic-editor-slider-advanced-css').summernote('code', getTextForImage[0].advanced_css);
        }else{
          $(".dynamic-editor-slider-text").summernote('code', null);
          $('.dynamic-editor-slider-advanced-css').summernote('code', null);
        }
        
        $('#addDynamicTextOnImage').modal('show');
      });
    }
    
    shopist.event.addTextAndCustomAdvancedCssOnImage();
  },
  
  adminGalleryImageRemove:function()
  {
    if($('.remove-gallery-img-link').length>0)
    {
      $('.remove-gallery-img-link').click(function()
      {
        shopist.normalFunction.remove_product_related_img_from_json_data({source:'product_gallery_images', id:$(this).data('id')});
        $(this).parent('.gallery-image-single-container').remove();
        if($('.gallery-image-single-container').length == 0)
        {
          $('.product-uploaded-gallery-image').hide();
          $('.product-gallery-sample-img').show();
        }
      });
    }
    
    if($('.remove-art-img-link').length>0)
    {
      $('.remove-art-img-link').click(function()
      {
        var img_array = [];
        
        if($('#ht_art_all_uploaded_images').val() != '')
        {
          var get_img_url = JSON.parse( $('#ht_art_all_uploaded_images').val() );
          
          for(var i = 0; i<get_img_url.length; i++)
          {
            if(get_img_url[i].id != $(this).data('id'))
            {
              img_array.push({ id:get_img_url[i].id, url:get_img_url[i].url });
            }
          }
        }
        
        $('#ht_art_all_uploaded_images').val(JSON.stringify(img_array));
        $(this).parent('.art-image-single-container').remove();
      });
    }
  },
  
  frontendImageRemove:function()
  {
    if($('.remove-frontend-img-link').length>0)
    {
      $('.remove-frontend-img-link').click(function()
      {
        shopist.normalFunction.remove_frontend_img_from_json_data({source:'header_slider_images', id:$(this).data('id')});
        $(this).parent('.header-slider-image-single-container').remove();
        if($('.header-slider-image-single-container').length == 0)
        {
          $('.uploaded-header-slider-images .uploaded-slider-images').hide();
          $('.uploaded-header-slider-images .sample-img').show();
        }
      });
    }
  },
  
  addTextAndCustomAdvancedCssOnImage:function(){
    if($('.btn-add-text-on-image').length>0){
      $('.btn-add-text-on-image').off('click').on('click', function(){
        if($('#add_text_on_image_editor').val().length>0){
          
          var getTextForImage = shopist.normalFunction.getSelectedImageText( 'header_slider_images', currentFrontendAddTextOnImageId);
          
          if(getTextForImage.length>0){
            shopist.normalFunction.updateJsonDataForAllFrontendImageText('header_slider_images', {id:currentFrontendAddTextOnImageId, html_code:$("#add_text_on_image_editor").val() , advanced_css:$('#advanced_custom_css').val() }, currentFrontendAddTextOnImageId);
          }else{
            shopist.normalFunction.createJsonDataForAllFrontendImageText('header_slider_images', {id:currentFrontendAddTextOnImageId, html_code:$("#add_text_on_image_editor").val(), advanced_css: $('#advanced_custom_css').val() });
          }
        
          $('#addDynamicTextOnImage').modal('hide');
          swal("" , adminLocalizationString.html_code_added_msg);
        }
        else{
          swal("" , adminLocalizationString.html_code_required_msg);
        }
      });
    }
  },
  
  removeCatThumbnailImage:function()
  {
    if($('.remove-cat-img').length>0)
    {
      $('.remove-cat-img').click(function()
      {
        $('.cat-img img').attr('src', '');
        $('.cat-img img').removeAttr('data-img_url');
        $('.cat-img').hide();
        $('.cat-sample-img').show();
        $('.cat-img-upload-btn').hide();
      });
    }
  },
  
  removeManufacturersImage:function()
  {
    if($('.remove-manufacturers-img').length>0)
    {
      $('.remove-manufacturers-img').click(function()
      {
        $('.manufacturers-img img').attr('src', '');
        $('.manufacturers-img').hide();
        $('.manufacturers-sample-img').show();
        $('.manufacturers-img-remove-btn').hide();
        $('#logo_img').val('');
      });
    }
  },
  
  removeVariationImage:function()
  {
    if($('.remove-variation-img').length>0)
    {
      $('.remove-variation-img').click(function()
      {
        $('.variation-img img').attr('src', '');
        $('.variation-img').hide();
        $('.variation-sample-img').show();
        $('.variation-img-upload-btn').hide();
        //$('#logo_img').val('');
      });
    }
  },
  
  removeBannerImage:function()
  {
    if($('.banner-img-remove').length>0)
    {
      $('.banner-img-remove button').click(function()
      {
        shopist.normalFunction.remove_product_related_img_from_json_data({source:'shop_banner_image'});
        $(this).parents('.uploaded-banner-image').find('.banner-uploaded-image img').attr('src', '');
        $(this).parents('.uploaded-banner-image').find('.banner-uploaded-image').hide();
        $(this).parents('.uploaded-banner-image').find('.banner-sample-img').show();
      });
    }
  },
  
  removeDesignerRelatedImage:function()
  {
    if($('.remove-design-img').length>0 || $('.remove-design-title-img').length>0)
    {
      $('.remove-design-img, .remove-design-title-img').click(function()
      {
        if($(this).data('name') == 'design_img')
        {
          shopist.normalFunction.removeDesignImageFromJsonData('design_img', $(this).data('id'));
          $(this).parents('.design-img-content').find('.design-img img').attr('src', '');
          $(this).parents('.design-img-content').find('.design-img').hide();
          $(this).parents('.design-img-content').find('.design-sample-img').show();
          $(this).hide();
        }
	else if($(this).data('name') == 'trans_design_img')
        {
          shopist.normalFunction.removeDesignImageFromJsonData('trans_design_img', $(this).data('id'));
          $(this).parents('.design-img-content').find('.trans-design-img img').attr('src', '');
          $(this).parents('.design-img-content').find('.trans-design-img').hide();
          $(this).parents('.design-img-content').find('.trans-design-sample-img').show();
          $(this).hide();
        }
        else if($(this).data('name') == 'design_title_img')
        {
          shopist.normalFunction.removeDesignImageFromJsonData('design_title_img', $(this).data('id'));
          $(this).parents('.design-title-img-content').find('.design-title-img img').attr('src', '');
          $(this).parents('.design-title-img-content').find('.design-title-img').hide();
          $(this).parents('.design-title-img-content').find('.design-title-sample-img').show();
          $(this).hide();
        }
      });
    }
  },
  
  removeElementPanel:function()
  {
    if($('.remove-panel').length>0)
    {
      $('.remove-panel').click(function(e)
      {
        e.preventDefault();
        var get_parse_data = [];
        var obj = $(this);
        
        if($('#hf_custom_designer_data').val())
        {
          get_parse_data = JSON.parse($('#hf_custom_designer_data').val());
        
          var get_data = get_parse_data
          .filter(function (el) {
            return el.id !== obj.parent().data('id');
          });

          $('#hf_custom_designer_data').val(JSON.stringify(get_data));
        }
        
        $(this).parents('.element-accordion').remove();
      });
    }
  },
	
  createCat:function()
  {
    if($('.create-cat').length>0)
    {
      $('.create-cat').click(function()
      {               
        if($('#inputCatName').val() == '' || $('#inputCatName').val() == null || $('#inputCatName').val().length == 0)
        {
          $('#inputCatName').css({'border':'2px solid #dc3232'});
        }
        else if($('#inputCatName').val() != '' || $('#inputCatName').val() != null || $('#inputCatName').val().length != 0)
        {
          $('#inputCatName').css({'border':'2px solid #d2d6de'});
        }
        
        if($('#inputCatSlug').val() == '' || $('#inputCatSlug').val() == null || $('#inputCatSlug').val().length == 0)
        {
          $('#inputCatSlug').css({'border':'2px solid #dc3232'});
        }
        else if($('#inputCatSlug').val() != '' || $('#inputCatSlug').val() != null || $('#inputCatSlug').val().length != 0)
        {
          $('#inputCatSlug').css({'border':'2px solid #d2d6de'});
        }

       
        
        if(($('#inputCatName').val() != '' && $('#inputCatSlug').val() != '' && $('#inputCatName').val().length != 0 && $('#inputCatSlug').val().length != 0 ) || ($('#inputCatName').val() != null && $('#inputCatSlug').val() != null && $('#inputCatName').val().length != 0 && $('#inputCatSlug').val().length != 0))
        {
          shopist.ajaxRequest.add_new_cat();
        }
      });
    }
  },
  
  createTag:function(){
    if($('.create-tag').length>0){
      $('.create-tag').click(function(){               
        if($('#inputTagName').val() == '' || $('#inputTagName').val() == null || $('#inputTagName').val().length == 0){
          $('#inputTagName').css({'border':'2px solid #dc3232'});
        }
        else if($('#inputTagName').val() != '' || $('#inputTagName').val() != null || $('#inputTagName').val().length != 0){
          $('#inputTagName').css({'border':'2px solid #d2d6de'});
        }
        
        if( ( $('#inputTagName').val() != '' && $('#inputTagName').val().length != 0 ) || ( $('#inputTagName').val() != null  && $('#inputTagName').val().length != 0 ) ){
          shopist.ajaxRequest.add_new_tag();
        }
      });
    }
  },
  
  createAttributes:function(){
    if($('.create-attrs').length>0){
      $('.create-attrs').click(function(){               
        if($('#inputAttrName').val() == '' || $('#inputAttrName').val() == null || $('#inputAttrName').val().length == 0){
          $('#inputAttrName').css({'border':'2px solid #dc3232'});
        }
        else if($('#inputAttrName').val() != '' || $('#inputAttrName').val() != null || $('#inputAttrName').val().length != 0){
          $('#inputAttrName').css({'border':'2px solid #d2d6de'});
        }
        
        if($('#inputAttrValues').val() == '' || $('#inputAttrValues').val() == null || $('#inputAttrValues').val().length == 0){
          $('#inputAttrValues').css({'border':'2px solid #dc3232'});
        }
        else if($('#inputAttrValues').val() != '' || $('#inputAttrValues').val() != null || $('#inputAttrValues').val().length != 0){
          $('#inputAttrValues').css({'border':'2px solid #d2d6de'});
        }
        
        if( (( $('#inputAttrName').val() != '' && $('#inputAttrName').val().length != 0 ) || ( $('#inputAttrName').val() != null  && $('#inputAttrName').val().length != 0 ) ) && ( ( $('#inputAttrValues').val() != '' && $('#inputAttrValues').val().length != 0 ) || ( $('#inputAttrValues').val() != null  && $('#inputAttrValues').val().length != 0 ) )){
          shopist.ajaxRequest.add_new_attributes();
        }
      });
    }
  },
  
  createColors:function(){
    if($('.create-color').length>0){
      $('.create-color').click(function(){               
        if($('#inputColorName').val() == '' || $('#inputColorName').val() == null || $('#inputColorName').val().length == 0){
          $('#inputColorName').css({'border':'2px solid #dc3232'});
        }
        else if($('#inputColorName').val() != '' || $('#inputColorName').val() != null || $('#inputColorName').val().length != 0){
          $('#inputColorName').css({'border':'2px solid #d2d6de'});
        }
        
        if( (( $('#inputColorName').val() != '' && $('#inputColorName').val().length != 0 ) || ( $('#inputColorName').val() != null  && $('#inputColorName').val().length != 0 ) ) ){
          shopist.ajaxRequest.add_new_color();
        }
      });
    }
  },
  
  createSizes:function(){
    if($('.create-size').length>0){
      $('.create-size').click(function(){               
        if($('#inputSizeName').val() == '' || $('#inputSizeName').val() == null || $('#inputSizeName').val().length == 0){
          $('#inputSizeName').css({'border':'2px solid #dc3232'});
        }
        else if($('#inputSizeName').val() != '' || $('#inputSizeName').val() != null || $('#inputSizeName').val().length != 0){
          $('#inputSizeName').css({'border':'2px solid #d2d6de'});
        }
        
        if( (( $('#inputSizeName').val() != '' && $('#inputSizeName').val().length != 0 ) || ( $('#inputSizeName').val() != null  && $('#inputSizeName').val().length != 0 ) )){
          shopist.ajaxRequest.add_new_sizes();
        }
      });
    }
  },
  
  createVariation:function()
  {
    if($('.create-new-variations').length>0)
    {
      $('.create-new-variations').click(function()
      {
        if($('#inputVariationSKU').val() == '' || $('#inputVariationSKU').val() == null || $('#inputVariationSKU').val().length == 0)
        {
          $('#inputVariationSKU').css({'border':'2px solid #dc3232'});
        }
        else if($('#inputVariationSKU').val() != '' || $('#inputVariationSKU').val() != null || $('#inputVariationSKU').val().length != 0)
        {
          $('#inputVariationSKU').css({'border':'1px solid #d2d6de'});
        }
        
        if($('#inputVariationSKU').val().length != 0)
        {
          var is_combination_exists   =  false;
          var jsonDataParse           =  '';
          
          if($('#hf_variation_data').val())
          {
            jsonDataParse           =  JSON.parse($('#hf_variation_data').val());
          }
          
          var attr_ary               =  [];
        
          if($('#addDynamicVariations .attributes-lists').length>0)
          { 
            $('#addDynamicVariations .attributes-lists select  > option:selected').each(function() 
            {
              attr_ary.push({
                              attr_name: $(this).parents('select').data('attr_name'),
                              attr_val:  $(this).val()
              });
            });
          }
          
          if(jsonDataParse.length > 0 && attr_ary.length>0)
          {
            for(var i=0; i<jsonDataParse.length; i++)
            {
              if(jsonDataParse[i].meta_value == JSON.stringify(attr_ary))
              {
                is_combination_exists = true;
                break;
              }
            }
          }
          
          if($('#selected_variation_id').val())
          {
            if(is_combination_exists && JSON.stringify(attr_ary) != $('#variation_json_before_edit').val())
            {
              swal("" , adminLocalizationString.variations_exists_msg);
            }
            else
            {
              shopist.ajaxRequest.add_new_variation();
            }
          }
          else
          {
            shopist.ajaxRequest.add_new_variation();
          }
        }
      });
    }
  },
  
  edit_panel_display:function()
  {
    if($('.edit-data').length>0)
    {
      $('.edit-data').click(function(e)
      {
        e.preventDefault();
        $('#selected_variation_id').val($(this).data('id'));
        shopist.ajaxRequest.get_edit_data( $(this).data('id'), $(this).data('track_name') );
      });
    }
  },
  
  edit_attribute_panel_display:function()
  {
    if($('.edit-attribute-data').length>0 && $('.attr-lists-content').length>0)
    {
      $('.edit-attribute-data').on("click", function(e)
      {
        e.preventDefault();
        
        $('.attr-lists-content #editAttrNameByProduct').val( $(this).data('line_variation_json').attr_name );
        $('.attr-lists-content #editAttrValuesByProduct').val( $(this).data('line_variation_json').attr_val );
        attrUpdateId = $(this).data('line_variation_json').id;
      });
    }
  },
  
  model_event:function()
  {
    if($('.custom-event').length>0)
    {
      $('.custom-event').click(function()
      {
        $('#hf_from_model').val('for_add');
        $('#hf_update_id').val('');
        $('#addDynamicCategories .top-title').html( adminLocalizationString.create_new_category );
        $('#addDynamicCategories .create-cat').html( adminLocalizationString.create_category );
      });
    }  
  },
  
  model_event_tag:function()
  {
    if($('.custom-event-tags').length>0)
    {
      $('.custom-event-tags').click(function()
      {
        $('#hf_from_model').val('for_add');
        $('#hf_update_id').val('');
        $('#addDynamicTags .top-title-tag').html( adminLocalizationString.create_new_product_tag );
        $('#addDynamicTags .create-tag').html( adminLocalizationString.create_tag );
      });
    }  
  },
  
  custom_event_attrs:function(){
    if($('.custom-event-attrs').length>0){
      $('.custom-event-attrs').click(function(){
        $('#hf_from_model').val('for_add');
        $('#hf_update_id').val('');
        $('#addDynamicAttributes .top-title-attrs').html( adminLocalizationString.create_new_product_attrs );
        $('#addDynamicAttributes .create-attrs').html( adminLocalizationString.create_attr );
      });
    }  
  },
  
  custom_event_colors:function(){
    if($('.custom-event-colors').length>0){
      $('.custom-event-colors').click(function(){
        $('#hf_from_model').val('for_add');
        $('#hf_update_id').val('');
        $('#addDynamicColors .top-title-color').html( adminLocalizationString.create_new_product_color );
        $('#addDynamicColors .create-color').html( adminLocalizationString.create_color );
      });
    }  
  },
  
  custom_event_size:function(){
    if($('.custom-event-sizes').length>0){
      $('.custom-event-sizes').click(function(){
        $('#hf_from_model').val('for_add');
        $('#hf_update_id').val('');
        $('#addDynamicSizes .top-title-size').html( adminLocalizationString.create_new_product_size );
        $('#addDynamicSizes .create-size').html( adminLocalizationString.create_size );
      });
    }  
  },
  
  item_delete_from_list:function()
  {
   if($('.remove-selected-data-from-list').length>0)
   {
     $('.remove-selected-data-from-list').on("click", function(e)
     {
      e.preventDefault();
      var item_id = null;
      
      if (typeof $(this).data('item_id') !== 'undefined')
      {
        item_id = $(this).data('item_id');
      }

       shopist.warningMessage.deleteConfirmation( $(this).data('id'), item_id, $(this).data('track_name') );
     });
   }
  },
  
  item_status_change_from_comments_list:function()
  {
    if($('.comments-status-change').length>0 || $('.reviews-status-change').length>0){
      $('.comments-status-change, .reviews-status-change').on("click", function(e){
        e.preventDefault();
        var item_id = null;
        var status  = null;
        var target  = null;

        if (typeof $(this).data('id') !== 'undefined'){
          item_id = $(this).data('id');
        }
        
        if (typeof $(this).data('target') !== 'undefined')
        {
          target = $(this).data('target');
        }
        
        if (typeof $(this).data('status') !== 'undefined')
        {
          status = $(this).data('status');
        }
        
        shopist.warningMessage.commentsStatusChangeConfirmation( item_id, status, target );
      });
    }
  },
  
  view_variation_by_id:function()
  {
   if($('.variation-list .view-data').length>0)
   {
     $('.variation-list .view-data').click(function(e)
     {
       e.preventDefault();
       shopist.ajaxRequest.get_variation_view_data( $(this).data('id') );
     });
   }
  },
  
  change_product_type:function(){
    if($('#change_product_type').length>0){
      $('#change_product_type').select2().on('change', function() {
        if($(this).val() == 'simple_product'){
          $('.product-tab-content ul.nav-tabs .attribute, .variations,.custom-design, .custom-design-layout, .manage-download-files').hide();
          $('.product-tab-content ul.nav-tabs .general, .inventory, .features, .advanced').show();
          $('.product-tab-content ul.nav-tabs').find('.active').removeClass('active');
          $('.product-tab-content ul.nav-tabs .general').addClass('active');
          $('.product-tab-content .tab-content').find('.active').removeClass('active');
          $('.product-tab-content .tab-content').find('.tab-general').addClass('active');
          $('.taxes-option').show();
          $('.enable-custom-design').hide();
        }
        else if($(this).val() == 'configurable_product'){
          $('.product-tab-content ul.nav-tabs .attribute, .variations,.features,.advanced').show();
          $('.product-tab-content ul.nav-tabs .general, .inventory, .custom-design, .custom-design-layout, .manage-download-files').hide();
          $('.product-tab-content ul.nav-tabs').find('.active').removeClass('active');
          $('.product-tab-content ul.nav-tabs .features').addClass('active');
          $('.product-tab-content .tab-content').find('.active').removeClass('active');
          $('.product-tab-content .tab-content').find('.tab-features').addClass('active');
          $('.taxes-option').hide();
          $('.enable-custom-design').hide();
        }
        else if($(this).val() == 'customizable_product'){
          $('.product-tab-content ul.nav-tabs .general, .inventory, .features, .advanced, .attribute, .variations, .custom-design, .custom-design-layout').show();
					$('.product-tab-content ul.nav-tabs .manage-download-files').hide();
          $('.product-tab-content ul.nav-tabs').find('.active').removeClass('active');
          $('.product-tab-content ul.nav-tabs .general').addClass('active');
          $('.product-tab-content .tab-content').find('.active').removeClass('active');
          $('.product-tab-content .tab-content').find('.tab-general').addClass('active');
          $('.taxes-option').show();
          //$('.enable-custom-design').show();
        }
				else if($(this).val() == 'downloadable_product'){
					$('.product-tab-content ul.nav-tabs .general, .inventory, .features, .advanced, .attribute, .variations, .manage-download-files').show();
					$('.product-tab-content ul.nav-tabs .custom-design, .custom-design-layout').hide();
					$('.product-tab-content ul.nav-tabs').find('.active').removeClass('active');
          $('.product-tab-content ul.nav-tabs .general').addClass('active');
          $('.product-tab-content .tab-content').find('.active').removeClass('active');
          $('.product-tab-content .tab-content').find('.tab-general').addClass('active');
          $('.taxes-option').show();
          $('.enable-custom-design').hide();
				}
      });
    }
  },
  
  add_new_design_element:function()
  {
    if ($('.add-design-element-panel').length>0)
    {
      $('.add-design-element-panel').click(function()
      {
        if($('#design_title_name').val().length>0)
        {
          var count_id    =   shopist.normalFunction.make_random_id();
          var data_arry   =   [];
          var title_label =   $('#design_title_name').val();
          
          $('#design_title_name').css({'border':'2px solid #d2d6de'});
          
          var htmlOutput = shopist.normalFunction.add_design_element_html( count_id,  title_label);
          
          if($('.design-element-main-container').length>0)
          {
            if($('.design-element-main-container').find('.element-accordion').length>0)
            {
              $('.design-element-main-container .element-accordion:last').after( htmlOutput );
            }
            else
            {
               $('.design-element-main-container').html( htmlOutput );
            }
            
            $('#design_title_name').val('');
            $('#element_title_name').modal('hide');
            
            if($('#accordion').length>0)
            {
              $('.collapse').on('shown.bs.collapse', function(){
              $(this).parent().find(".glyphicon-plus").removeClass("glyphicon-plus").addClass("glyphicon-minus");
              }).on('hidden.bs.collapse', function(){
              $(this).parent().find(".glyphicon-minus").removeClass("glyphicon-minus").addClass("glyphicon-plus");
              });
            }
            
            shopist.event.open_model_for_designer_img_upload();
            shopist.event.removeDesignerRelatedImage();
            shopist.event.removeElementPanel();
            
            if($('#hf_custom_designer_data').length>0)
            {
              if($('#hf_custom_designer_data').val() != '' || $('#hf_custom_designer_data').val().length>0)
              {
                data_arry = JSON.parse( $('#hf_custom_designer_data').val() );
                data_arry.push({id:count_id, title_label:title_label, design_img_url:'/public/images/no-image.png', design_trans_img_url:'', design_title_icon:'/public/images/no-image.png'});
              }
              else
              {
                data_arry.push({id:count_id, title_label:title_label, design_img_url:'/public/images/no-image.png', design_trans_img_url:'', design_title_icon:'/public/images/no-image.png'});
              }
               
              $('#hf_custom_designer_data').val(JSON.stringify(data_arry));
            }
          }
        }
        else
        {
          $('#design_title_name').css({'border':'2px solid #dc3232'});
        }
      });
    }
  },
 
  init_dropzone:function()
  {
    var baseUrl = $('#hf_base_url').val();
    var token   = $('meta[name="csrf-token"]').attr('content');
    Dropzone.autoDiscover = false;
       
    if($('.product-uploader').length>0 && $('.product-gallery-uploader').length>0 && $('.shop-banner-uploader').length>0)
    {
      new customDropZone( {base_url:baseUrl, url:baseUrl + "/upload/product-related-image", token:token, uploader:'eb_dropzone_file_upload', paramName:'product_image', acceptedFiles: "image/*", uploadMultiple:false, maxFiles:1} );
      
      new customDropZone( {base_url:baseUrl, url:baseUrl + "/upload/product-gallery-images", token:token, uploader:'eb_dropzone_gallery_image_file_upload', paramName:'product_gallery_images', acceptedFiles: "image/*", uploadMultiple:true, maxFiles:10} );
      
      new customDropZone( {base_url:baseUrl, url:baseUrl + "/upload/product-related-image", token:token, uploader:'eb_dropzone_banner_file_upload', paramName:'shop_banner_image', acceptedFiles: "image/*", uploadMultiple:false, maxFiles:1} );
    }
		
    if($('.testimonial_dropzone_file_upload').length>0)
    {
      new customDropZone( {base_url:baseUrl, url:baseUrl + "/upload/product-related-image", token:token, uploader:'testimonial_dropzone_file_upload', paramName:'testimonial_image', acceptedFiles: "image/*", uploadMultiple:false, maxFiles:1} );
    }
    
    if($('.featured_dropzone_file_upload').length>0)
    {
      new customDropZone( {base_url:baseUrl, url:baseUrl + "/upload/product-related-image", token:token, uploader:'featured_dropzone_file_upload', paramName:'featured_image', acceptedFiles: "image/*", uploadMultiple:false, maxFiles:1} );
    }
    
    if($('.frontend_images_file_upload').length>0){
      new customDropZone( {base_url:baseUrl, url:baseUrl + "/upload/frontend-images", token:token, uploader:'frontend_images_file_upload', paramName:'frontend_all_images', acceptedFiles: "image/*", uploadMultiple:true, maxFiles:10} );
    }
    
    if($('.upload-cat-img').length>0)
    {
      new customDropZone( {base_url:baseUrl, url:baseUrl + "/upload/product-related-image", token:token, uploader:'upload-cat-img', paramName:'cat_thumbnail_image', acceptedFiles: "image/*", uploadMultiple:false, maxFiles:1} );
    }
    
    if($('.upload-manufacturers-logo').length>0)
    {
      new customDropZone( {base_url:baseUrl, url:baseUrl + "/upload/product-related-image", token:token, uploader:'upload-manufacturers-logo', paramName:'manufacturers_logo', acceptedFiles: "image/*", uploadMultiple:false, maxFiles:1} );
    }
    
    if($('.upload-variation-img').length>0)
    {
      new customDropZone( {base_url:baseUrl, url:baseUrl + "/upload/product-related-image", token:token, uploader:'upload-variation-img', paramName:'variation_img', acceptedFiles: "image/*", uploadMultiple:false, maxFiles:1} );
    }
    
    if($('.designer-dropzone-file-upload').length>0)
    {
      new customDropZone( {base_url:baseUrl, url:baseUrl + "/upload/product-related-image", token:token, uploader:'designer-dropzone-file-upload', paramName:'designer_img', acceptedFiles: "image/*", uploadMultiple:false, maxFiles:1} );
    }
    
    if($('.art-dropzone-file-upload').length>0)
    {
      new customDropZone( {base_url:baseUrl, url:baseUrl + "/upload/art-all-images", token:token, uploader:'art-dropzone-file-upload', paramName:'art_imges', acceptedFiles: "image/*", uploadMultiple:true, maxFiles:10} );
    }
    
    if($('.update-art-dropzone-file-upload').length>0)
    {
      new customDropZone( {base_url:baseUrl, url:baseUrl + "/upload/product-related-image", token:token, uploader:'update-art-dropzone-file-upload', paramName:'update_art_imges', acceptedFiles: "image/*", uploadMultiple:false, maxFiles:1} );
    }
    
    if($('.profile-picture-uploader').length>0)
    {
      new customDropZone( {base_url:baseUrl, url:baseUrl + "/upload/product-related-image", token:token, uploader:'profile-picture-uploader', paramName:'profile_picture', acceptedFiles: "image/*", uploadMultiple:false, maxFiles:1} );
    }
    
    if($('.site-picture-uploader').length>0)
    {
      new customDropZone( {base_url:baseUrl, url:baseUrl + "/upload/product-related-image", token:token, uploader:'site-picture-uploader', paramName:'site_picture', acceptedFiles: "image/*", uploadMultiple:false, maxFiles:1} );
    }
    
    if($('.vendor-cover-picture-uploader').length>0)
    {
      new customDropZone( {base_url:baseUrl, url:baseUrl + "/upload/product-related-image", token:token, uploader:'vendor-cover-picture-uploader', paramName:'vendor_cover_picture', acceptedFiles: "image/*", uploadMultiple:false, maxFiles:1} );
    }
  },
  
  create_sale_schedule:function()
  {
    if($('.create_sale_schedule').length>0)
    {
      $('.create_sale_schedule').click(function(e)
      {
        e.preventDefault();
        $('.sale_start_date, .sale_end_date').show();
        $(this).hide();
      });
    }
  },
  
  create_sale_variation_schedule:function()
  {
    if($('.create_variation_sale_schedule').length>0)
    {
      $('.create_variation_sale_schedule').click(function(e)
      {
        e.preventDefault();
        $('.variation_sale_start_date, .variation_sale_end_date').show();
        $(this).hide();
      });
    }
  },
  
  cancel_sale_schedule:function()
  {
    if($('.cancel_schedule').length>0)
    {
      $('.cancel_schedule').click(function(e)
      {
        e.preventDefault();
        $('.sale_start_date, .sale_end_date').hide();
        //$(this).hide();
        $('.create_sale_schedule').show();
        $('#inputSalePriceStartDate, #inputSalePriceEndDate').val('');
      });
    }
  },
  
  cancel_sale_variation_schedule:function()
  {
    if($('.cancel_variation_schedule').length>0)
    {
      $('.cancel_variation_schedule').click(function(e)
      {
        e.preventDefault();
        $('.variation_sale_start_date, .variation_sale_end_date').hide();
        //$(this).hide();
        $('.create_variation_sale_schedule').show();
        $('#inputVariationSalePriceStartDate, #inputVariationSalePriceEndDate').val('');
      });
    }
  },
  
  manage_stock:function()
  {
    if($('#manage_stock').length>0)
    {
      $('#manage_stock').on('ifChanged', function(event)
      {
        if(event.currentTarget.checked) 
        {
          $('.stock-qty, .back-to-order-page').show();
        } 
        else if(!event.currentTarget.checked) 
        {
          $('.stock-qty, .back-to-order-page').hide();
        }
      });
    }
  },
  
  manage_variation_stock:function()
  {
    if($('#inputManageVariationStock').length>0)
    {
      $('#inputManageVariationStock').on('ifChanged', function(event)
      {
        if(event.currentTarget.checked) 
        {
          $('.variation-stock-qty, .variation-back-to-order-page').show();
        } 
        else if(!event.currentTarget.checked) 
        {
          $('.variation-stock-qty, .variation-back-to-order-page').hide();
        }
      });
    }
  },
  
  create_variation:function(){
    if($('.create-variations').length>0){
      $('.create-variations').click(function(){
        var is_selected_all = 'yes';
        $('#selected_variation_id').val('');
        
        if($('#is_product_save').length>0 && $('#is_product_save').val() && $('#is_product_save').val() == 'yes'){
          var is_combination_exists   =  false;
          var jsonDataParse           =  '';
          
          if($('#hf_variation_data').val()){ 
            jsonDataParse   =  JSON.parse($('#hf_variation_data').val());
          }
          
          var attr_ary  =  [];
        
          if($('.variations-panel .attributes-lists').length>0){ 
            $('.variations-panel .attributes-lists select  > option:selected').each(function(){
              attr_ary.push({
                  attr_name: $(this).parents('select').data('attr_name'),
                  attr_val:  $(this).val()
              });
            });
          }
          
          if(attr_ary.length>0){
            for (var count = 0; count<attr_ary.length; count++){
              if(attr_ary[count].attr_val == 'all'){
                is_selected_all = 'no';
              }
            }
          }
        
          if(is_selected_all == 'yes'){  
            if(jsonDataParse.length > 0 && attr_ary.length>0){
              for(var i=0; i<jsonDataParse.length; i++){
                if(jsonDataParse[i].key_value == JSON.stringify(attr_ary)){
                  is_combination_exists = true;
                  break;
                }
              }
            }

            if(is_combination_exists){
              swal("" ,adminLocalizationString.variations_exists_msg);
            }
            else{
              $('#addDynamicVariations .modal-body .content-for-variation-add').show();
              $('#addDynamicVariations .top-title').html( adminLocalizationString.create_new_product_variation );
              $('#addDynamicVariations .modal-footer .create-new-variations').html( adminLocalizationString.add_variation );
              $('#addDynamicVariations .modal-body .content-for-variation-view').hide();
              $('#addDynamicVariations .modal-footer .create-new-variations').show();
              $('#addDynamicVariations .modal-body .content-for-variation-add .attributes-lists').hide();

              //role based pricing 
              $('#enable_disable_role_based_pricing').iCheck('uncheck'); 
              $('.pricing-textbox').val('');
              $('#hf_selected_variation_attr').val(JSON.stringify(attr_ary));
              $('#addDynamicVariations .manage-download-files .files-manage-option table tbody').html('');
              $('#addDynamicVariations').modal('show');
            }
          }
          else{
            swal("" , adminLocalizationString.select_attr_values );
          }
        }
        else{
          swal("" , adminLocalizationString.work_at_edit_page );
        }
      });
    }
  },
  
  create_attribute:function()
  {
    if($('.add-new-attribute').length>0 || $('.update-attribute').length>0)
    {
      $('.add-new-attribute, .update-attribute').on("click", function(e)
      {
        e.preventDefault();
        if($('#is_product_save').length>0 && $('#is_product_save').val() && $('#is_product_save').val() == 'yes')
        {
          var id        = '';
          var attr_name = '';
          var attr_val  = '';
          var action    = ''; 
          
          if($(this).hasClass('add-new-attribute'))
          {
            if($('#attrNameByProduct').val().length == 0)
            {
              $('#attrNameByProduct').css('border', '1px solid #FF0000');
            }
            else
            {
              $('#attrNameByProduct').css('border', '1px solid #d2d6de');
            }

            if($('#attrValuesByProduct').val().length == 0)
            {
              $('#attrValuesByProduct').css('border', '1px solid #FF0000');
            }
            else
            {
              $('#attrValuesByProduct').css('border', '1px solid #d2d6de');
            }
            
            id          =   shopist.normalFunction.make_random_id();
            attr_name   =   $('#attrNameByProduct').val();
            attr_val    =   $('#attrValuesByProduct').val();
            action      =   'save';
            
            
            
          }
          else if($(this).hasClass('update-attribute'))
          {
            if($('#editAttrNameByProduct').val().length == 0)
            {
              $('#editAttrNameByProduct').css('border', '1px solid #FF0000');
            }
            else
            {
              $('#editAttrNameByProduct').css('border', '1px solid #d2d6de');
            }

            if($('#editAttrValuesByProduct').val().length == 0)
            {
              $('#editAttrValuesByProduct').css('border', '1px solid #FF0000');
            }
            else
            {
              $('#editAttrValuesByProduct').css('border', '1px solid #d2d6de');
            }
            
            id          =     attrUpdateId;
            attr_name   =     $('#editAttrNameByProduct').val();
            attr_val    =     $('#editAttrValuesByProduct').val();
            action      =     'update';
          }
          
          
          if( attr_name.length>0 && attr_val.length>0)
          {
            
            var new_array = [];
            new_array.push({
                          id        :  id,
                          attr_name :  attr_name,
                          attr_val  :  attr_val
            });
            
            shopist.ajaxRequest.add_attribute_by_product(jQuery('#product_id').val(), JSON.stringify(new_array), action, function(success){
              if( success == 'updated' )
              {
                $('#edit_attributes').modal('hide');
              }
            });
          }
        }
        else
        {
          swal("" ,adminLocalizationString.work_at_edit_page);
        }
      });
    }
  },
  
  open_model_for_designer_img_upload:function()
  {
    if($('.upload-design-img').length>0 || $('.upload-design-title-img').length>0)
    {
      $('.upload-design-img, .upload-design-title-img').click(function()
      {
        clickTrackForDesignerUploader = $(this).data('name') + ',' + $(this).parents('.panel-collapse').data('id');
        
        $('#designerImageUploader').modal('show');
      });
    }
  },
	
  open_product_video_upload_model:function()
  {
    if($('.upload-product-video').length>0)
    {
      $('.upload-product-video').click(function()
      {
        $('#productVideoUploader').modal('show');
      });
    }
  },
  
  check_available_attributes:function()
  {
    if($('.check-available-attributes').length>0)
    {
      $('.check-available-attributes').on("click", function(){
        
        shopist.ajaxRequest.get_available_attributes_with_html();
      });
    }
  },
  
  restricted_area_checkbox_action:function()
  {
    if($('#inputRestrictedCenterPosition').length>0 || $('#globalInputRestrictedCenterPosition').length>0)
    {
      $('#inputRestrictedCenterPosition, #globalInputRestrictedCenterPosition').on('ifChanged', function(event)
      {
        if(event.currentTarget.checked) 
        {
          $('#restricted_area_position_left, #global_restricted_area_position_left').val('');
          $('#restricted_area_position_top, #global_restricted_area_position_top').val('');
          $('#restricted_area_position_left, #global_restricted_area_position_left').prop('disabled', true);
          $('#restricted_area_position_top, #global_restricted_area_position_top').prop('disabled', true);
        } 
        else if(!event.currentTarget.checked) 
        {
          $('#restricted_area_position_left, #global_restricted_area_position_left').prop('disabled', false);
          $('#restricted_area_position_top, #global_restricted_area_position_top').prop('disabled', false);
        }
      });
    }
  },
  
  global_settings_enable_checkbox_action:function()
  {
    if($('#inputEnableGlobalSettings').length>0)
    {
      $('#inputEnableGlobalSettings').on('ifChanged', function(event)
      {
        if(event.currentTarget.checked) 
        {
          $('#specific_canvas_small_devices_width, #specific_canvas_small_devices_height, #specific_canvas_medium_devices_width, #specific_canvas_medium_devices_height, #specific_canvas_large_devices_width, #specific_canvas_large_devices_height').val('');
          $('#specific_canvas_small_devices_width, #specific_canvas_small_devices_height, #specific_canvas_medium_devices_width, #specific_canvas_medium_devices_height, #specific_canvas_large_devices_width, #specific_canvas_large_devices_height').prop('disabled', true);
        } 
        else if(!event.currentTarget.checked) 
        {
          $('#specific_canvas_small_devices_width, #specific_canvas_small_devices_height, #specific_canvas_medium_devices_width, #specific_canvas_medium_devices_height, #specific_canvas_large_devices_width, #specific_canvas_large_devices_height').prop('disabled', false);
        }
      });
    }
  },
  
  manageFrontendTemplates:function()
  {
    if($('.activate-templates').length>0)
    {
      $('.activate-templates').on('click', function(e)
      {
        e.preventDefault();
        var obj = $(this);
        var formData = new FormData();
        
        formData.append('tab_name', $(this).data('tab_name'));
        formData.append('template_name', $(this).data('template_name'));
        
        obj.parents('.manage-template').after('<div class="template_activate_loader"><img src="'+ $('#hf_base_url').val() +'/public/images/ajax-loader_001.gif" alt="ajax-loader"></div>');
        var xhrForm = new XMLHttpRequest();
        xhrForm.open("POST", $('#hf_base_url').val() + "/ajax/appearance_data_manage");
        xhrForm.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
        xhrForm.send(formData);
        
        xhrForm.onreadystatechange = function () 
        {
          if (xhrForm.readyState === 4 && xhrForm.status == 200) 
          {
            var parseResponse = $.parseJSON(xhrForm.responseText);
            
            if(parseResponse.status == 'success')
            {
              obj.parents('.sample-img-content').find('.template_activate_loader').remove();
              window.location.href = window.location.href;
            }
          }
        };
      });
    }
  },
  
  remove_downloadablefile(){
    if($('.remove-downloadable-file').length>0){
      $('.remove-downloadable-file').on('click', function(e){
        e.preventDefault();
        $(this).parents('.file-inline').remove();
      });
    }
  },
  
  add_downloadable_product_files_dynamically(){
    $('.add_more_downloadable_file, .add_variable_products_more_downloadable_file').on('click', function(){
      var target = $(this).data('target');
      var count_id  = shopist.normalFunction.make_random_id();
      
      var html_simple = '<tr class="file-inline"><td><input type="text" class="form-control" id="downloadable_file_name_'+ count_id +'" placeholder="'+ adminLocalizationString.downloadable_placeholder_file_name +'" name="downloadable_file_name['+ count_id +']"></td><td><div class="upload-downloadable-file"><div class="file-label">'+ adminLocalizationString.downloadable_file_label +'</div><div class="file-url-textbox"><input type="text" class="form-control" id="downloadable_file_uploaded_url_'+ count_id +'" name="downloadable_uploaded_file_url['+ count_id +']" readonly="true" placeholder="'+ adminLocalizationString.downloadable_uploaded_file_url_placeholder +'"></div><div class="file-upload-btn"> &nbsp;&nbsp;<button data-id="'+ count_id +'" data-toggle="modal" data-target="#downloadable_file_upload" type="button" class="btn btn-default upload-for-downloadable-product">'+ adminLocalizationString.downloadable_choose_file_label +'</button></div></div><div class="url-downloadable-file" style="display:none;"><div class="file-label">'+ adminLocalizationString.downloadable_url_label +'</div><div class="file-url-textbox"><input type="text" class="form-control" id="downloadable_file_url_'+ count_id +'" placeholder="'+ adminLocalizationString.downloadable_online_file_url_placeholder +'" name="downloadable_online_file_url['+ count_id +']"></div></div><a href="" class="btn btn-sm btn-default remove-downloadable-file">'+ adminLocalizationString.remove_text +'</a></td></tr>';
      
      var html_variable = '<tr class="file-inline"><td><input type="text" class="form-control" id="variable_downloadable_file_name_'+ count_id +'" placeholder="'+ adminLocalizationString.downloadable_placeholder_file_name +'" name="variable_downloadable_file_name['+ count_id +']"></td><td><div class="upload-downloadable-file"><div class="file-label">'+ adminLocalizationString.downloadable_file_label +'</div><div class="file-url-textbox"><input type="text" class="form-control" id="variable_downloadable_file_uploaded_url_'+ count_id +'" name="variable_downloadable_uploaded_file_url['+ count_id +']" readonly="true" placeholder="'+ adminLocalizationString.downloadable_uploaded_file_url_placeholder +'"></div><div class="file-upload-btn"> &nbsp;&nbsp;<button data-id="'+ count_id +'" data-popup-open="variableProductDownloadableFileUpload" type="button" class="btn btn-default variable-upload-for-downloadable-product">'+ adminLocalizationString.downloadable_choose_file_label +'</button></div></div><div class="url-downloadable-file" style="display:none;"><div class="file-label">'+ adminLocalizationString.downloadable_url_label +'</div><div class="file-url-textbox"><input type="text" class="form-control" id="variable_downloadable_file_url_'+ count_id +'" placeholder="'+ adminLocalizationString.downloadable_online_file_url_placeholder +'" name="variable_downloadable_online_file_url['+ count_id +']"></div></div><a href="" class="btn btn-sm btn-default remove-downloadable-file">'+ adminLocalizationString.remove_text +'</a></td></tr>';
      
      
      if(target == 'simple'){
        if($('#tab_manage_download_files .files-manage-option table tbody tr').length == 0){
          $('#tab_manage_download_files .files-manage-option table tbody').append( html_simple );
        }
        else{
          $('#tab_manage_download_files .files-manage-option table tbody tr:last').after( html_simple );
        }

        if($('.upload-for-downloadable-product').length>0){
          $('.upload-for-downloadable-product').on('click', function(){
            $('#hf_downloadable_product_file_url_track').val( $(this).data('id') );
            $('#uploadDownloadableProductFile').val( null );
          });
        }
      }
      else if(target == 'variable'){
        if($('#tab_variations .files-manage-option table tbody tr').length == 0){
          $('#tab_variations .files-manage-option table tbody').append( html_variable );
        }
        else{
          $('#tab_variations .files-manage-option table tbody tr:last').after( html_variable );
        }
        
        if($('.variable-upload-for-downloadable-product').length>0){
          $('.variable-upload-for-downloadable-product').on('click', function(){
            $('#hf_variable_product_downloadable_file_url_track').val( $(this).data('id') );
            $('#uploadDownloadableVariableProductFile').val( null );
            
            var targeted_popup_class = $(this).attr('data-popup-open');
            $('[data-popup="' + targeted_popup_class + '"]').fadeIn(350);
          });
        }
        
        $('[data-popup-close]').on('click', function(e)  {
            var targeted_popup_class = $(this).attr('data-popup-close');
            $('[data-popup="' + targeted_popup_class + '"]').fadeOut(350);

            e.preventDefault();
        });
      }
      
      shopist.event.remove_downloadablefile();
    });
  }
};

shopist.ajaxRequest = 
{
  add_new_cat:function(){
    $('.ajax-overlay').show();
    var name         = '';
    var slug         = '';
    var parent       = 0;
    var fb           = 0;
    var description  = '';
    var cat_for      = '';
    var status       = '';
    var img_url      = '';
    var dataObj      = {};
    
    if($('#inputCatName').val().length >0){
      name  =   $('#inputCatName').val();
    }
    
    if($('#inputCatSlug').val().length>0){
      slug  =   $('#inputCatSlug').val();
    }
    if ($('#inputCatFb').val().length > 0) {
      fb = $('#inputCatFb').val();
    }
    
		if($('#cat_parent :selected').val().length > 0 && $('#cat_parent :selected').val() > 0){
			parent =   $('#cat_parent :selected').val();
		}
    
    if($('#inputCatDescription').val().length>0){
      description    =   $('#inputCatDescription').val();
    }
    
    status   =   $('#cat_status :selected').val();
    
    if($('.cat-img img').attr('src').length>0){
      img_url  =   $('.cat-img img').data('img_url');
    }
    
    if($('#hf_cat_post_for').val().length>0){
      cat_for = $('#hf_cat_post_for').val();
    }
    dataObj.fb            =   fb;
    dataObj.name          =   name;
    dataObj.slug          =   slug;
    dataObj.parent        =   parent;
    dataObj.description   =   description;
    dataObj.cat_for       =   cat_for;
    dataObj.status        =   status;
    dataObj.img_url       =   img_url;
    dataObj.click_source  =   $('#hf_from_model').val();
    dataObj.id            =   $('#hf_update_id').val();
    
    
    $.ajax({
          url: $('#hf_base_url').val() + '/ajax/add-cat',
          type: 'POST',
          cache: false,
          dataType: 'json',
          data: {data:dataObj},
          headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') }, 
          success: function(data){
            if(data.error_no_entered == false){
              swal("" , adminLocalizationString.name_slug_field_are_required);
            }
            else if(data.error_duplicate_slug == false){
              swal("" , adminLocalizationString.slug_already_exists);         
            }
            else if(data.success == true){      
              $('#addDynamicCategories').modal('hide'); 
              window.location.href = window.location.href;
              shopist.normalFunction.successMsg();
            }
						
            $('.ajax-overlay').hide();
          },
          error:function(){}
    });
  },
  
  add_new_tag:function(){
    $('.ajax-overlay').show();
    var name         = '';
    var description  = '';
    var status       = '';
    var dataObj      = {};
    var fb           = 0;
    
    if($('#inputTagName').val().length >0){
      name   =   $('#inputTagName').val();
    }
    
    if($('#inputTagDescription').val().length>0){
      description    =   $('#inputTagDescription').val();
    }
    if ($('#inputTagFb').val().length > 0) {
          fb = $('#inputTagFb').val();
       }
   
    status           =   $('#tag_status :selected').val();
    
    dataObj.name          =   name;
    dataObj.description   =   description;
    dataObj.status        =   status;
    dataObj.fb            =   fb;
    dataObj.click_source  =   $('#hf_from_model').val();
    dataObj.id            =   $('#hf_update_id').val();
    
    
    $.ajax({
          url: $('#hf_base_url').val() + '/ajax/add-tag',
          type: 'POST',
          cache: false,
          datatype: 'json',
          data: {data:dataObj},
          headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
          success: function(data){
            if(data.error_no_entered == false){
              swal("" , adminLocalizationString.name_slug_field_are_required);
            }
            else if(data.error_duplicate_slug == false){
              swal("" , adminLocalizationString.slug_already_exists);         
            }
            else if(data.success == true){      
              $('#addDynamicTags').modal('hide'); 
              window.location.href = window.location.href;
              shopist.normalFunction.successMsg();
            }
            $('.ajax-overlay').hide();
          },
          error:function(){}
    });
  },
  
  add_new_attributes:function(){
    $('.ajax-overlay').show();
    var attrName     = '';
    var attrVal      = '';
    var status       = '';
    var dataObj      = {};
    
    if($('#inputAttrName').val().length >0){
      attrName   =   $('#inputAttrName').val();
    }
    
    if($('#inputAttrValues').val().length >0){
      attrVal   =   $('#inputAttrValues').val();
    }
    
    status   =   $('#attrs_status :selected').val();
    
    dataObj.attrName      =   attrName;
    dataObj.attrVal       =   attrVal;
    dataObj.status        =   status;
    dataObj.click_source  =   $('#hf_from_model').val();
    dataObj.id            =   $('#hf_update_id').val();
    
    
    $.ajax({
          url: $('#hf_base_url').val() + '/ajax/add-attribute',
          type: 'POST',
          cache: false,
          datatype: 'json',
          data: {data:dataObj},
          headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
          success: function(data){
            if(data.error_no_entered == false){
              swal("" , adminLocalizationString.attr_name_values_are_required);
            }
            else if(data.success == true){      
              $('#addDynamicAttributes').modal('hide'); 
              window.location.href = window.location.href;
              shopist.normalFunction.successMsg();
            }
            $('.ajax-overlay').hide();
          },
          error:function(){}
    });
  },
  
  add_new_color:function(){
    $('.ajax-overlay').show();
    var colorName     = '';
    var colorCode     = '';
    var status        = '';
    var dataObj       = {};
    
    if($('#inputColorName').val().length >0){
      colorName   =   $('#inputColorName').val();
    }
    
    if($('#inputSelectColor').val().length >0){
      colorCode   =   $('#inputSelectColor').val();
    }
    
    status   =   $('#color_status :selected').val();
    
    dataObj.colorName      =   colorName;
    dataObj.colorCode      =   colorCode;
    dataObj.status         =   status;
    dataObj.click_source   =   $('#hf_from_model').val();
    dataObj.id             =   $('#hf_update_id').val();
    
    
    $.ajax({
          url: $('#hf_base_url').val() + '/ajax/add-color',
          type: 'POST',
          cache: false,
          datatype: 'json',
          data: {data:dataObj},
          headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
          success: function(data){
            if(data.error_no_entered == false){
              swal("" , adminLocalizationString.colors_are_required);
            }
            else if(data.success == true){      
              $('#addDynamicColors').modal('hide'); 
              window.location.href = window.location.href;
              shopist.normalFunction.successMsg();
            }
            $('.ajax-overlay').hide();
          },
          error:function(){}
    });
  },
  
  add_new_sizes:function(){
    $('.ajax-overlay').show();
    var sizeName     = '';
    var status       = '';
    var dataObj      = {};
    
    if($('#inputSizeName').val().length >0){
      sizeName   =   $('#inputSizeName').val();
    }
    
    status   =   $('#size_status :selected').val();
    
    dataObj.sizeName       =   sizeName;
    dataObj.status         =   status;
    dataObj.click_source   =   $('#hf_from_model').val();
    dataObj.id             =   $('#hf_update_id').val();
    
    
    $.ajax({
          url: $('#hf_base_url').val() + '/ajax/add-size',
          type: 'POST',
          cache: false,
          datatype: 'json',
          data: {data:dataObj},
          headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
          success: function(data){
            if(data.error_no_entered == false){
              swal("" , adminLocalizationString.sizes_are_required);
            }
            else if(data.success == true){      
              $('#addDynamicSizes').modal('hide'); 
              window.location.href = window.location.href;
              shopist.normalFunction.successMsg();
            }
            $('.ajax-overlay').hide();
          },
          error:function(){}
    });
  },
  
  add_new_variation:function()
  {
    $('.ajax-overlay').show();
    var dataObj                 =   {};
    var img_url                 =   '';
    var enable_variation        =   '';
    var sku                     =   '';
    var regular_price           =   0;
    var sale_price              =   0;
    var sale_price_start_date   =   '';
    var sale_price_end_date     =   '';
    var enable_stock_management =   '';
    var stock_qty               =   0;
    var back_order              =   '';
    var stock_status            =   '';
    var enable_tax              =   0;
    var pfb                     =   0;
    var variation_description   =   '';
    var variation_json_data     =   '';
    var roles_pricing = [];
    var is_enable_role_based_pricing =   '';
    var get_roles = null;
    var downloadable_data = [];
    
    
    if($('.variation-img img').attr('src')){
      img_url = $('.variation-img img').attr('src').replace($('#hf_base_url').val(), "");
    }
    
    if ($('#inputVariationEnable').is(':checked')){
      enable_variation = 1;
    }
    else{
      enable_variation = 0;
    }
   
    if($('#inputVariationSKU').val().length >0){
      sku  =   $('#inputVariationSKU').val();
    }
    
    if($('#inputVariationRegularPrice').val().length >0){
      regular_price  =   $('#inputVariationRegularPrice').val();
    }
    
    if($('#inputVariationPfb').val().length >0){
      pfb  =   $('#inputVariationPfb').val();
    }
    if ($('#inputVariationSalePrice').val().length > 0) {
      sale_price = $('#inputVariationSalePrice').val();
    }
    
    if($('#inputVariationSalePriceStartDate').val().length >0){
      sale_price_start_date  =   $('#inputVariationSalePriceStartDate').val();
    }
    
    if($('#inputVariationSalePriceEndDate').val().length >0){
      sale_price_end_date  =   $('#inputVariationSalePriceEndDate').val();
    }
    
    if ($('#inputManageVariationStock').is(':checked')) {
      enable_stock_management = 1;
    }
    else{
      enable_stock_management = 0;
    }
    
    if($('#inputVariationStockQty').val().length >0){
      stock_qty  =   $('#inputVariationStockQty').val();
    }
    
    back_order = $('#variation_backorders_status :selected').val();
    stock_status = $('#variation_stock_status :selected').val();
    
    if($('#variation_description').val().length >0){
      variation_description   =   $('#variation_description').val();
    }
    
    if($('#hf_selected_variation_attr').val().length >0){
      variation_json_data  =   $('#hf_selected_variation_attr').val();
    }
    
    if($('#inputEnableTaxesForVariation').length>0){
      if ($('#inputEnableTaxesForVariation').is(':checked')){
        enable_tax = 1;
      }
      else{
        enable_tax = 0;
      }
    }
		
    
    //role based pricing
    if ($('#enable_disable_role_based_pricing').is(':checked')){
      is_enable_role_based_pricing = 1;
    }
    else{
      is_enable_role_based_pricing = 0;
    }
    
		if($('#hf_available_user_roles').length>0 && $('#hf_available_user_roles').val().length >0){
      get_roles = JSON.parse($('#hf_available_user_roles').val());
    }
    
    if(get_roles && get_roles.length > 0){
      for(var i = 0; i<get_roles.length; i++){
        roles_pricing.push({role_name: get_roles[i].slug, regular_price: $('#' + get_roles[i].slug + '_role_regular_pricing').val(), sale_price: $('#' + get_roles[i].slug + '_role_sale_pricing').val()});
      }
    }
    
    //downloadable product data
    if($('#tab_variations .variable-upload-for-downloadable-product').length>0){
      $('#tab_variations .variable-upload-for-downloadable-product').each( function(){
        downloadable_data.push({ id: $(this).data('id'), file_name: $('#variable_downloadable_file_name_' + $(this).data('id')).val(), uploaded_file_url: $('#variable_downloadable_file_uploaded_url_' + $(this).data('id')).val(), online_file_url:  $('#variable_downloadable_file_url_' + $(this).data('id')).val() });
      });
    }
    
    var download_limit = '';
    var download_expiry = '';
    
    if($('#tab_variations #download_limit').val().length>0){
      download_limit = $('#tab_variations #download_limit').val();
    }
    
    if($('#tab_variations #download_expiry').val().length>0){
      download_expiry = $('#tab_variations #download_expiry').val();
    }
		
    
    dataObj.url                     =   img_url;
    dataObj.variation_enable_status =   enable_variation;
    dataObj.variation_sku           =   sku;
    dataObj.regular_price           =   regular_price;
    dataObj.sale_price              =   sale_price;
    dataObj.pfb                     =   pfb;
    dataObj.sale_price_start_date   =   sale_price_start_date;
    dataObj.sale_price_end_date     =   sale_price_end_date;
    dataObj.manage_stock            =   enable_stock_management;
    dataObj.stock_qty               =   stock_qty;
    dataObj.back_order              =   back_order;
    dataObj.stock_status            =   stock_status;
    dataObj.tax                     =   enable_tax;
    dataObj.variation_description   =   variation_description;
    dataObj.product_id              =   $('#product_id').val();
    
    if($('#selected_variation_id').val())
    {
      var new_array = [];

      if($('#addDynamicVariations .attributes-lists').length>0)
      { 
        $('#addDynamicVariations .attributes-lists select  > option:selected').each(function() 
        {
          new_array.push({
            attr_name: $(this).parents('select').data('attr_name'),
            attr_val:  $(this).val()
          });
        });
      }
					
      dataObj.post_type             =   'update_post';
      dataObj.variation_id          =   $('#selected_variation_id').val();
      dataObj.variation_json        =   JSON.stringify(new_array);
    }
    else
    {
      dataObj.post_type             =   'add_post';
      dataObj.variation_id          =   ''
      dataObj.variation_json        =   variation_json_data;
    }
    
    dataObj.role_based_pricing = roles_pricing;
    dataObj.role_based_pricing_status = is_enable_role_based_pricing;
    
    dataObj.downloadable_data = downloadable_data;
    dataObj.download_limit = download_limit;
    dataObj.download_expiry = download_expiry;
    
    $.ajax({
          url: $('#hf_base_url').val() + '/ajax/add-variation',
          type: 'POST',
          cache: false,
          datatype: 'json',
          headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
          data: {data:dataObj},
          success: function(data)
          {
            if(data.error_no_sku_entered == false)
            {
              swal("" , adminLocalizationString.sku_field_require);
            }
            else if(data.error_sku_exists == false)
            {
              swal("" , adminLocalizationString.sku_already_exists);
            }
            else if(data.success == true && data.variation_data && data.variation_html)
            {      
              $('#addDynamicVariations').modal('hide'); 
              $('#hf_variation_data').val(data.variation_data);
              $('.variation-list').html('');
              $('.variation-list').html( data.variation_html );
              $("#variation_list").DataTable();
              
              shopist.event.view_variation_by_id();
              shopist.event.edit_panel_display();
              shopist.event.item_delete_from_list();
            }
            $('.ajax-overlay').hide();
          },
          error:function(){}
    });
  },
  
  get_edit_data:function(id, track){
    $('.eb-overlay').show();
    $('.eb-overlay-loader').show();
    var base_url = $('#hf_base_url').val();
    var get_roles;
    
    if($('#hf_available_user_roles').length>0 && $('#hf_available_user_roles').val().length >0){
      get_roles = JSON.parse($('#hf_available_user_roles').val());
    }
    
    var dataObj    = {};
    dataObj.id     =  id;
    dataObj.track  =  track;
    
    $.ajax({
          url: $('#hf_base_url').val() + '/ajax/edit-data',
          type: 'POST',
          cache: false,
          datatype: 'json',
          data: {data:dataObj},
          headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
          success: function(data){
            if(data.success == true){
              if( track == 'cat_list' ){
                $('#inputCatName').val( data.name );
                $('#inputCatSlug').val( data.slug );
                
                $("#cat_parent option").each(function(){
                  if($(this).attr('disabled'))
                  {
                    $(this).removeAttr('disabled');
                  }
                });
                
                $('#cat_parent').select2();
                
                $("#cat_parent option[value='"+ id +"']").attr('disabled','disabled');
                $('#cat_parent').select2('val', data.parent_id);
                $('#inputCatDescription').val( data.description );
                $('#cat_status').select2('val', data.status);

                if(data.img_url)
                {
                  $('.cat-img img').attr('src', base_url + data.img_url);
                  $('.cat-img img').attr('data-img_url', data.img_url);
                  $('.cat-img-upload-btn').show();
                  $('.cat-sample-img').hide();
                  $('.cat-img').show();
                }
                else
                {
                  $('.cat-img img').attr('src', '');
                  $('.cat-img').hide();
                  $('.cat-sample-img').show();
                  $('.cat-img-upload-btn').hide();
                }    

                $('#addDynamicCategories .top-title').html( adminLocalizationString.update_product_category );
                $('#addDynamicCategories .create-cat').html( adminLocalizationString.update_category );
                $('#hf_update_id').val( id );
                $('#hf_from_model').val('for_update');
                $('#addDynamicCategories').modal('show');
              }
              else if( track == 'tag_list' ){
                $('#inputTagName').val( data.name );
                $('#inputTagSlug').val( data.slug );
                $('#inputTagDescription').val( data.description );
                $('#tag_status').select2('val', data.status);
                
                $('#addDynamicTags .top-title-tag').html( adminLocalizationString.update_product_tag );
                $('#addDynamicTags .create-tag').html( adminLocalizationString.update_tag );
                $('#hf_update_id').val( id );
                $('#hf_from_model').val('for_update');
                $('#addDynamicTags').modal('show');
              }
              else if( track == 'attr_list' ){
                $('#inputAttrName').val( data.attrName );
                $('#inputAttrValues').val( data.attrVal );
                $('#attrs_status').select2('val', data.status);
                
                $('#addDynamicAttributes .top-title-attrs').html( adminLocalizationString.update_product_attr );
                $('#addDynamicAttributes .create-attrs').html( adminLocalizationString.update_attr );
                $('#hf_update_id').val( id );
                $('#hf_from_model').val('for_update');
                $('#addDynamicAttributes').modal('show');
              }
              else if( track == 'color_list' ){
                $('#inputColorName').val( data.colorName );
                $('#inputSelectColor').val( data.colorCode );
                $('#color_status').select2('val', data.status);
                
                $('#addDynamicColors .top-title-color').html( adminLocalizationString.update_product_color );
                $('#addDynamicColors .create-color').html( adminLocalizationString.update_color );
                $('#hf_update_id').val( id );
                $('#hf_from_model').val('for_update');
                $('#addDynamicColors').modal('show');
              }
              else if( track == 'size_list' ){
                $('#inputSizeName').val( data.sizeName );
                $('#size_status').select2('val', data.status);
                
                $('#addDynamicSizes .top-title-size').html( adminLocalizationString.update_product_size );
                $('#addDynamicSizes .create-size').html( adminLocalizationString.update_size );
                $('#hf_update_id').val( id );
                $('#hf_from_model').val('for_update');
                $('#addDynamicSizes').modal('show');
              }
              else if( track == 'variation_data_list' ){
                var parseData = JSON.parse(data.edit_data);
                var parseVariation =  JSON.parse(parseData._variation_post_data);

                if($('#addDynamicVariations .attributes-lists').length>0)
                { 
                  $('#addDynamicVariations .attributes-lists select').each(function() 
                  {
                    for(var i=0; i<parseVariation.length; i++ )
                    {
                      if(parseVariation[i].attr_name == $(this).data('attr_name'))
                      {
                        $(this).select2('val', parseVariation[i].attr_val);
                      }
                    }
                  });
                }

                $('#variation_json_before_edit').val(parseData._variation_post_data);
								
                if(parseData._variation_post_img_url)
                {
                  $('.variation-img img').attr('src', base_url + parseData._variation_post_img_url);
                  $('.variation-img-upload-btn').show();
                  $('.variation-sample-img').hide();
                  $('.variation-img').show();
                }
                else
                {
                  $('.variation-img img').attr('src', '');
                  $('.variation-img').hide();
                  $('.variation-sample-img').show();
                  $('.variation-img-upload-btn').hide();
                }
                
                if(parseData.post_status == 1)
                {
                 $('#inputVariationEnable').iCheck('check');
                }
                else
                {
                  $('#inputVariationEnable').iCheck('uncheck');
                }
                
                $('#inputVariationSKU').val(parseData._variation_post_sku);
                $('#inputVariationRegularPrice').val(parseData._variation_post_regular_price);
                $('#inputVariationSalePrice').val(parseData._variation_post_sale_price);
                
                if(parseData._variation_post_sale_price_start_date && parseData._variation_post_sale_price_end_date)
                {
                  $('#inputVariationSalePriceStartDate').val(parseData._variation_post_sale_price_start_date);
                  $('#inputVariationSalePriceEndDate').val(parseData._variation_post_sale_price_end_date);
                  $('.variation_sale_start_date, .variation_sale_end_date').show();
                  $('.create_variation_sale_schedule').hide();
                }
                else
                {
                  $('#inputVariationSalePriceStartDate').val('');
                  $('#inputVariationSalePriceEndDate').val('');
                  $('.variation_sale_start_date, .variation_sale_end_date').hide();
                  $('.create_variation_sale_schedule').show();
                }
                
                if(parseData._variation_post_manage_stock == 1)
                {
                  $('#inputManageVariationStock').iCheck('check');
                  $('#inputVariationStockQty').val(parseData._variation_post_manage_stock_qty);
                  $('#variation_backorders_status').select2('val', parseData._variation_post_back_to_order);
                  $('.variation-stock-qty,.variation-back-to-order-page').show();
                }
                else
                {
                  $('#inputManageVariationStock').iCheck('uncheck');
                  $('#inputVariationStockQty').val(0);
                  $('#variation_backorders_status').select2('val', 'variation_not_allow');
                  $('.variation-stock-qty,.variation-back-to-order-page').hide();
                }
                
                $('#variation_stock_status').select2('val', parseData._variation_post_stock_availability);
                
                if($('#inputEnableTaxesForVariation').length>0)
                {
                  if(parseData._variation_post_enable_tax == 1 )
                  {
                    $('#inputEnableTaxesForVariation').iCheck('check');
                  }
                  else
                  {
                    $('#inputEnableTaxesForVariation').iCheck('uncheck');
                  }
                }
                
                $('#variation_description').val(parseData.post_content);
                
                $('#addDynamicVariations .top-title').html( adminLocalizationString.update_product_variation );
                $('#addDynamicVariations .modal-footer .create-new-variations').html( adminLocalizationString.update_variation_data );
                $('#addDynamicVariations .modal-body .content-for-variation-add').show();
                $('#addDynamicVariations .modal-footer .create-new-variations').show();
                $('#addDynamicVariations .modal-body .content-for-variation-view').hide();
                $('#addDynamicVariations .modal-body .content-for-variation-add .attributes-lists').show();
                
                
                //role based pricing
                if($('#enable_disable_role_based_pricing').length>0){
                  if(parseData._is_role_based_pricing_enable == 1 )
                  {
                    $('#enable_disable_role_based_pricing').iCheck('check');
                  }
                  else
                  {
                    $('#enable_disable_role_based_pricing').iCheck('uncheck');
                  }
                }
                
                var pricing = parseData._role_based_pricing;

                if(Object.keys(pricing).length > 0){
                  $.each( pricing, function( key, value ) {
                    $('#' + key + '_role_regular_pricing').val( value.regular_price);
                    $('#' + key + '_role_sale_pricing').val( value.sale_price);
                  });
                }
                
                //downloadable product
                var html_variable = null;
                var downloadable_data = parseData._downloadable_product_data;
                
                if(Object.keys(downloadable_data).length > 0){
                  $.each( downloadable_data, function( key, value ) {
                    var url = base_url + value.uploaded_file_url;
                    
                    html_variable += '<tr class="file-inline"><td><input type="text" class="form-control" id="variable_downloadable_file_name_'+ key +'" placeholder="'+ adminLocalizationString.downloadable_placeholder_file_name +'" name="variable_downloadable_file_name['+ key +']" value="'+ value.file_name +'"></td><td><div class="upload-downloadable-file"><div class="file-label">'+ adminLocalizationString.downloadable_file_label +'</div><div class="file-url-textbox"><input type="text" class="form-control" id="variable_downloadable_file_uploaded_url_'+ key +'" name="variable_downloadable_uploaded_file_url['+ key +']" readonly="true" placeholder="'+ adminLocalizationString.downloadable_uploaded_file_url_placeholder +'" value="'+ url +'"></div><div class="file-upload-btn"> &nbsp;&nbsp;<button data-id="'+ key +'" data-popup-open="variableProductDownloadableFileUpload" type="button" class="btn btn-default variable-upload-for-downloadable-product">'+ adminLocalizationString.downloadable_choose_file_label +'</button></div></div><div class="url-downloadable-file" style="display:none;"><div class="file-label">'+ adminLocalizationString.downloadable_url_label +'</div><div class="file-url-textbox"><input type="text" class="form-control" id="variable_downloadable_file_url_'+ key +'" placeholder="'+ adminLocalizationString.downloadable_online_file_url_placeholder +'" name="variable_downloadable_online_file_url['+ key +']" value="'+ value.online_file_url +'"></div></div><a href="" class="btn btn-sm btn-default remove-downloadable-file">'+ adminLocalizationString.remove_text +'</a></td></tr>';
                  });
                }
                
                if(html_variable && html_variable != null){
                  $('#tab_variations .files-manage-option table tbody').html('');
                  $('#tab_variations .files-manage-option table tbody').append( html_variable );
                  
                  if($('.variable-upload-for-downloadable-product').length>0){
                    $('.variable-upload-for-downloadable-product').on('click', function(){
                      $('#hf_variable_product_downloadable_file_url_track').val( $(this).data('id') );
                      $('#uploadDownloadableVariableProductFile').val( null );

                      var targeted_popup_class = $(this).attr('data-popup-open');
                      $('[data-popup="' + targeted_popup_class + '"]').fadeIn(350);
                    });
                  }

                  $('[data-popup-close]').on('click', function(e)  {
                      var targeted_popup_class = $(this).attr('data-popup-close');
                      $('[data-popup="' + targeted_popup_class + '"]').fadeOut(350);

                      e.preventDefault();
                  });
                  
                  shopist.event.remove_downloadablefile();
                }
                
                $('#tab_variations #download_limit').val(parseData._downloadable_limit);
                $('#tab_variations #download_expiry').val(parseData._download_expiry);
                
                $('#addDynamicVariations').modal('show');
              }
              
              $('.eb-overlay').hide();
              $('.eb-overlay-loader').hide();
            }
          },
          error:function(){}
    });
  },
  
  get_variation_view_data:function(id)
  {
    if(id)
    {
      $.ajax({
          url: $('#hf_base_url').val() + '/ajax/get-variation-view-data',
          type: 'POST',
          cache: false,
          datatype: 'json',
          headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
          data: {id:id},
          
          success: function(data)
          {
            if(data.success == true && data.html)
            {
              $('#addDynamicVariations .modal-body .content-for-variation-add').hide();
              $('#addDynamicVariations .top-title').html('');
              $('#addDynamicVariations .modal-footer .create-new-variations').hide();
              $('#addDynamicVariations .modal-body .content-for-variation-view').html( data.html );
              $('#addDynamicVariations .modal-body .content-for-variation-view').show();
              $('#addDynamicVariations').modal('show');
            }
          },
          
          error:function(){}
      });
    }
  },
  
  add_attribute_by_product:function(id, attributes, action, callback)
  {
    if(id && attributes && action)
    {
      $.ajax({
          url: $('#hf_base_url').val() + '/ajax/add-attributes-by-product',
          type: 'POST',
          cache: false,
          headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') }, 
          data: {id:id, action:action, data:attributes},
          
          success: function(data)
          {
            if(data)
            {
              $('#attrNameByProduct').val('');
              $('#attrValuesByProduct').val('');
              
              $('.attr-list').html('');
              $('.attr-list').html( data );
              $(".attr-list #attr_list").DataTable();

              $( ".add-new-attribute, .update-attribute").unbind( "click" );
              $( ".edit-attribute-data").unbind( "click" );
              $( ".remove-selected-data-from-list").unbind( "click" );

              shopist.event.edit_attribute_panel_display();
              shopist.event.item_delete_from_list();
              shopist.event.create_attribute();
              
              if(action == 'update')
              {
                callback( 'updated' );
              }
            }
          },
          
          error:function(){}
      });
    }
  },
  
  get_available_attributes_with_html:function()
  {
    $('.btn-check-available-attribute').attr("disabled", true);
    $.ajax({
          url: $('#hf_base_url').val() + '/ajax/get-available-attributes-with-html',
          type: 'POST',
          cache: false,
          headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
          data: {post_id : jQuery('#product_id').val()},
          
          success: function(data)
          {
            if(data.success == true)
            {
              $('.variations-panel .attributes-lists').html( '' );
              $('#addDynamicVariations .attributes-lists').html( '' );
              
              if(data.html)
              {
                $('.variations-panel .attributes-lists').html( data.html );
                $('#addDynamicVariations .attributes-lists').html( data.html );
                
                if($('.select2').length>0)
                {
                  $(".select2").select2();
                }
                
                $('.btn-check-available-attribute').removeAttr("disabled");
                $('.btn-check-available-attribute').hide();
                $('.btn-create-variation').show();
              }
              else
              {
                $('.variations-panel .attributes-lists').html( adminLocalizationString.no_attributes_available );
              }
              
              $('.variations-panel .attributes-lists').show();
            }
          },
          error:function(){}
    });
  }
};

shopist.warningMessage =
{
  deleteConfirmation:function( id, item_id, track )
  {
    var dataObj    = {};
    dataObj.id     =  id;
    dataObj.track  =  track;
    
    if( item_id != null)
    {
      dataObj.item_id     =  item_id;
    }
     
    swal({
      title: adminLocalizationString.are_you_sure,
      text:  adminLocalizationString.you_want_to_delete_this_item,
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: adminLocalizationString.yes_delete_it,
      closeOnConfirm: false
    },
    function(isConfirm)
    {
      if(isConfirm)
      {
        $.ajax({
              url: $('#hf_base_url').val() + '/ajax/delete-item',
              type: 'POST',
              cache: false,
              datatype: 'json',
              data: {data:dataObj},
              headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
              success: function(data)
              {
                if(data.delete == true)
                {
                  swal(adminLocalizationString.deleted, adminLocalizationString.your_selected_item_deleted, "success");
                  
                  $( ".edit-attribute-data").unbind( "click" );
                  $( ".remove-selected-data-from-list").unbind( "click" );
                  
                  if(track == 'variation_data_list')
                  {
                    $('#hf_variation_data').val(data.variation_json);
                    $('.variation-list').html('');
                    $('.variation-list').html( data.variation_new_html );
                    $("#variation_list").DataTable();

                    shopist.event.view_variation_by_id();
                    shopist.event.edit_panel_display();
                    shopist.event.item_delete_from_list();

                    swal(adminLocalizationString.good_job, adminLocalizationString.selected_item_successfully_deleted, "success");
                  }
                  else if(track == 'attr_data_list')
                  {
                    $('.attr-list').html('');
                    $('.attr-list').html( data.attr_new_html );
                    $(".attr-list #attr_list").DataTable();
                    
                    $( ".add-new-attribute, .update-attribute").unbind( "click" );
                    $( ".edit-attribute-data").unbind( "click" );
                    $( ".remove-selected-data-from-list").unbind( "click" );

                    shopist.event.edit_attribute_panel_display();
                    shopist.event.item_delete_from_list();
                    shopist.event.create_attribute();
                    
                    swal(adminLocalizationString.good_job, adminLocalizationString.selected_item_successfully_deleted, "success");
                  }
                  else
                  {
                    window.location.href = window.location.href;
                  }
                }
              },
              
              error:function(){}
        });
      }
    });
  },
  
  commentsStatusChangeConfirmation:function( item_id, status, target ){
    var dataObj    = {};
    dataObj.id      =  item_id;
    dataObj.status  =  status;
    dataObj.target  =  target;
    
    var status_msg      = '';
    var status_btn_msg  = '';
    var status_done_msg = '';
    var modal_top_msg   = '';
    
    if(status && status != '' && status == 'enable'){
      status_msg       =  adminLocalizationString.comment_enable_msg;
      status_btn_msg   =  adminLocalizationString.comment_btn_enable_msg;
      status_done_msg  =  adminLocalizationString.comment_enable_done_msg;
      modal_top_msg    =  adminLocalizationString.enabled_label;
    }
    else if(status && status != '' && status == 'disable'){
      status_msg       =  adminLocalizationString.comment_disable_msg;
      status_btn_msg   =  adminLocalizationString.comment_btn_disable_msg;
      status_done_msg  =  adminLocalizationString.comment_disable_done_msg;
      modal_top_msg    =  adminLocalizationString.disabled_label;
    }
    
    
    swal({
      title: adminLocalizationString.are_you_sure,
      text:  status_msg,
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: status_btn_msg,
      closeOnConfirm: false
    },
    function(isConfirm)
    {
      if(isConfirm){
        $.ajax({
              url: $('#hf_base_url').val() + '/ajax/comments-status-change',
              type: 'POST',
              cache: false,
              datatype: 'json',
              data: {data:dataObj},
              headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
              success: function(data){
                if(data.status_change == true){
                  swal(modal_top_msg, status_done_msg, "success");
                  window.location.href = window.location.href;
                }
              },
              error:function(){}
        });
      }
    });
  }
};

shopist.normalFunction=
{
  successMsg:function()
  {
    swal(adminLocalizationString.good_job, adminLocalizationString.selected_item_successfully_saved, "success");
  },
  
  updateMsg:function()
  {
    swal(adminLocalizationString.good_job, adminLocalizationString.selected_item_successfully_updated, "success");
  },
  
  numberValidation:function(obj)
  {
    obj.value = obj.value.replace(/[^0-9\.]/g,'');
  },
  
  add_design_element_html:function(count, val)
  {
    var baseUrl = $('#hf_base_url').val();
    var str = '';
    
    str += '<div class="panel-group element-accordion" id="accordion">';
    str += '<div class="panel panel-default">';
    str += '<div class="panel-heading"><h4 class="panel-title"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse_'+ count +'"><span class="glyphicon glyphicon-minus"></span>&nbsp;&nbsp;<span>'+ val +'</span></a><a data-id="'+ count +'" class="pull-right" href=""><span class="glyphicon glyphicon-remove remove-panel"></span></a></h4></div>';
    str += '<div id="collapse_'+ count +'" data-id="'+ count +'" class="panel-collapse collapse in collapse-' + count +'">';
    str += '<div class="panel-body">';
    str += '<div class="form-group"><div class="col-sm-6"><div class="design-img-content"><div class="design-sample-img"><img class="img-responsive" src="'+ baseUrl +'/public/images/upload.png" alt="no_img"></div><div class="design-img"><img class="img-responsive" src="" alt=""></div><br><div class="design-img-upload-btn"><div><button type="button" data-name="only_design_img" class="btn btn-default attachtopost upload-design-img">'+  adminLocalizationString.upload_design_image +'</button></div><div><button type="button" data-name="design_img" data-id="solid-'+ count +'" class="btn btn-default attachtopost remove-design-img">'+ adminLocalizationString.remove_image +'</button></div></div></div></div><div class="col-sm-6"><div class="design-img-content"><div class="trans-design-sample-img"><img class="img-responsive" src="'+ baseUrl +'/public/images/upload.png" alt="no_img"></div><div class="trans-design-img"><img class="img-responsive" src="" alt=""></div><br><div class="trans-design-img-upload-btn"><div><button type="button" data-name="only_trans_design_img" class="btn btn-default attachtopost upload-design-img">'+ adminLocalizationString.upload_design_transparent_image +'</button></div><div><button type="button" data-name="trans_design_img" data-id="trans-'+ count +'" class="btn btn-default attachtopost remove-design-img">'+ adminLocalizationString.remove_image +'</button></div></div></div></div></div><hr>';
    str += '<div class="form-group"><div class="col-sm-12"><div class="design-title-img-content"><div class="design-title-sample-img"><img class="img-responsive" src="'+ baseUrl +'/public/images/upload.png" alt="no_img"></div><div class="design-title-img"><img class="img-responsive" src="" alt=""></div><br><div class="design-title-img-upload-btn"><div><button type="button" data-name="only_design_title_img" class="btn btn-default attachtopost upload-design-title-img">'+ adminLocalizationString.upload_design_title_icon +'</button></div><div><button type="button" data-name="design_title_img" data-id="'+ count +'" class="btn btn-default attachtopost remove-design-title-img">'+ adminLocalizationString.remove_image +'</button></div></div></div></div></div></div></div></div></div>';
    
    return str;
  },
  
  make_random_id:function()
  {
    var d = new Date().getTime();
    var uuid = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g,function(c) {
        var r = (d + Math.random()*16)%16 | 0;
        d = Math.floor(d/16);
        return (c=='x' ? r : (r&0x7|0x8)).toString(16);
    });
    return uuid.toUpperCase();
  },
  
  htmlEncode:function (value)
  {
    //return $('<div/>').text(value).html();
    return String(value).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
  },
  
  htmlDecode:function (value){
    return $('<div/>').html(value).text();
  },
  
  createJsonDataForAllProductImage:function(source_name, url)
  {
    if($('#hf_uploaded_all_images').val())
    {
      var parseJson = JSON.parse($('#hf_uploaded_all_images').val());
      
      if(source_name == 'product_image')
      {
        parseJson.product_image  =  url;
      }
      else if(source_name == 'product_gallery_images')
      {
        parseJson.product_gallery_images.push(url);
      }
      else if(source_name == 'shop_banner_image')
      {
        parseJson.shop_banner_image   =  url;
      }
      
      $('#hf_uploaded_all_images').val(JSON.stringify(parseJson));
    }
  },
  
  createJsonDataForAllFrontendImage:function(source_name, url)
  {
    if($('#_frontend_images_json').val())
    {
      var parseJson = JSON.parse($('#_frontend_images_json').val());
      
      if(source_name == 'header_slider_images')
      {
        parseJson.header_slider_images_and_text.slider_images.push(url);
      }
      
      $('#_frontend_images_json').val(JSON.stringify(parseJson));
    }
  },
  
  createJsonDataForAllFrontendImageText:function(source_name, data)
  {
    if($('#_frontend_images_json').val())
    {
      var parseJson = JSON.parse($('#_frontend_images_json').val());
      
      if(source_name == 'header_slider_images')
      {
        parseJson.header_slider_images_and_text.slider_text.push(data);
      }
      
      $('#_frontend_images_json').val(JSON.stringify(parseJson));
    }
  },
  
  updateJsonDataForAllFrontendImageText:function(source_name, data, id)
  {
    if($('#_frontend_images_json').val())
    {
      var parseJson = JSON.parse($('#_frontend_images_json').val());
      
      if(source_name == 'header_slider_images')
      {
        var getText = parseJson.header_slider_images_and_text.slider_text
        .filter(function (el) {
          return el.id !== id;
        });
        
        parseJson.header_slider_images_and_text.slider_text     =  getText;
        parseJson.header_slider_images_and_text.slider_text.push(data);
      }
      
      $('#_frontend_images_json').val(JSON.stringify(parseJson));
    }
  },
  
  getSelectedImageText:function(source_name, id)
  {
    if($('#_frontend_images_json').val())
    {
      var parseJson = JSON.parse($('#_frontend_images_json').val());
      
      if(source_name == 'header_slider_images')
      {
        var getText = parseJson.header_slider_images_and_text.slider_text
        .filter(function (el) {
          return el.id == id;
        });
        
        return getText;
      }
    }
  },
  
  remove_product_related_img_from_json_data:function(source_data)
  {
    if($('#hf_uploaded_all_images').length>0 && $('#hf_uploaded_all_images').val())
    {
      var parseJson = JSON.parse($('#hf_uploaded_all_images').val());
      
      if(source_data.source && source_data.source == 'product_image')
      {
        parseJson.product_image     =  '';
      }
      else if(source_data.source && source_data.source == 'product_gallery_images')
      {
        get_data = parseJson.product_gallery_images
        .filter(function (el) {
          return el.id !== source_data.id;
        });
        parseJson.product_gallery_images     =  get_data;
      }
      if(source_data.source && source_data.source == 'shop_banner_image')
      {
        parseJson.shop_banner_image     =  '';
      }
      
      $('#hf_uploaded_all_images').val(JSON.stringify(parseJson));
    }
  },
  
  remove_frontend_img_from_json_data:function(source_data)
  {
    if($('#_frontend_images_json').length>0 && $('#_frontend_images_json').val())
    {
      var parseJson = JSON.parse($('#_frontend_images_json').val());
      
      if(source_data.source && source_data.source == 'header_slider_images')
      {
        var get_data = parseJson.header_slider_images_and_text.slider_images
        .filter(function (el) {
          return el.id !== source_data.id;
        });
        parseJson.header_slider_images_and_text.slider_images     =  get_data;
        
        var get_text_data = parseJson.header_slider_images_and_text.slider_text
        .filter(function (el) {
          return el.id !== source_data.id;
        });
        parseJson.header_slider_images_and_text.slider_text     =  get_text_data;
      }
     
      $('#_frontend_images_json').val(JSON.stringify(parseJson));
    }
  },
  
  createJsonDataForAllDesignerImage:function(source, id, url)
  {
    if($('#hf_custom_designer_data').length>0 && $('#hf_custom_designer_data').val())
    {
       var parseJson = JSON.parse($('#hf_custom_designer_data').val());
       
       if(source == 'only_design_img')
       {
         for(var i = 0; i<parseJson.length; i++)
         {
           if(parseJson[i].id == id)
           {
             parseJson[i].design_img_url = url;
             break;
           }
         }
       }
       else if(source == 'only_trans_design_img')
       {
         for(var i = 0; i<parseJson.length; i++)
         {
           if(parseJson[i].id == id)
           {
             parseJson[i].design_trans_img_url = url;
             break;
           }
         }
       }
       else if(source == 'only_design_title_img')
       {
         for(var j = 0; j<parseJson.length; j++)
         {
           if(parseJson[j].id == id)
           {
             parseJson[j].design_title_icon = url;
             break;
           }
         }
       }
       $('#hf_custom_designer_data').val(JSON.stringify(parseJson));
    }
  },
  
  removeDesignImageFromJsonData:function(source, id)
  {
    if($('#hf_custom_designer_data').length>0 && $('#hf_custom_designer_data').val())
    {
      var parseJson = JSON.parse($('#hf_custom_designer_data').val());
      
       if(source == 'design_img')
       {
         for(var i = 0; i<parseJson.length; i++)
         {
           if('solid-' + parseJson[i].id == id)
           {
             parseJson[i].design_img_url = '/public/images/upload.png';
             break;
           }
         }
       }
       else if(source == 'trans_design_img')
       {
         for(var i = 0; i<parseJson.length; i++)
         {
           if('trans-' + parseJson[i].id == id)
           {
             parseJson[i].design_trans_img_url = '';
             break;
           }
         }
       }
       else if(source == 'design_title_img')
       {
         for(var j = 0; j<parseJson.length; j++)
         {
           if(parseJson[j].id == id)
           {
             parseJson[j].design_title_icon = '/public/images/upload.png';
             break;
           }
         }
       }
       $('#hf_custom_designer_data').val(JSON.stringify(parseJson));
    }
  },
	
	slugify:function(string) {
		return string
			.toString()
			.trim()
			.toLowerCase()
			.replace(/\s+/g, "-")
			.replace(/[^\w\-]+/g, "")
			.replace(/\-\-+/g, "-")
			.replace(/^-+/, "")
			.replace(/-+$/, "");
	},
	
	add_compare_fields:function(){
		if($('.add-compare-fields-content').length>0){
			if($('.add-compare-fields-content').find('.product-compare-field-title').length>0){
				$('.add-compare-fields-content').find('.product-compare-field-title:last').after('<div id="'+ shopist.normalFunction.make_random_id() +'" class="product-compare-field-title clearfix"><div class="col-md-10"><input placeholder="'+ adminLocalizationString.more_compare_field_placeholder +'" name="product_compare_field_title['+ shopist.normalFunction.make_random_id() +']" class="form-control" type="text"></div><div class="col-md-2"><button id="remove_product_compare_fields" class="btn btn-default remove-product-compare-fields" type="button"><i class="fa fa-remove"></i> '+ adminLocalizationString.remove_text +'</button></div></div>');
			}
			else{
        $('.add-compare-fields-content').append('<div id="'+ shopist.normalFunction.make_random_id() +'" class="product-compare-field-title clearfix"><div class="col-md-10"><input placeholder="'+ adminLocalizationString.more_compare_field_placeholder +'" name="product_compare_field_title['+ shopist.normalFunction.make_random_id() +']" class="form-control" type="text"></div><div class="col-md-2"><button id="remove_product_compare_fields" class="btn btn-default remove-product-compare-fields" type="button"><i class="fa fa-remove"></i> '+ adminLocalizationString.remove_text +'</button></div></div>');
			}
			
			shopist.event.remove_product_compare_field();
		}
	},
  
  add_color_filter_fields:function(){
		if($('.add-filter-colors-content').length>0){
      var uid = shopist.normalFunction.make_random_id();
			if($('.add-filter-colors-content').find('.product-filter-color-title').length>0){
				$('.add-filter-colors-content').find('.product-filter-color-title:last').after('<div id="'+ uid +'" class="product-filter-color-title clearfix"><div class="col-md-5"><input placeholder="'+ adminLocalizationString.color_filter_color_name_placeholder +'" name="product_filter_color_name['+ uid +']" class="form-control" type="text"></div><div class="col-md-5"><input name="product_filter_color['+ uid +']" class="form-control color" type="text"></div><div class="col-md-2"><button id="remove_product_filter_color_field" class="btn btn-default remove-product-filter-color-field" type="button"><i class="fa fa-remove"></i> '+ adminLocalizationString.remove_text +'</button></div></div>');
			}
			else{
        $('.add-filter-colors-content').append('<div id="'+ uid +'" class="product-filter-color-title clearfix"><div class="col-md-5"><input placeholder="'+ adminLocalizationString.color_filter_color_name_placeholder +'" name="product_filter_color_name['+ uid +']" class="form-control" type="text"></div><div class="col-md-5"><input name="product_filter_color['+ uid +']" class="form-control color" type="text"></div><div class="col-md-2"><button id="remove_product_filter_color_field" class="btn btn-default remove-product-filter-color-field" type="button"><i class="fa fa-remove"></i> '+ adminLocalizationString.remove_text +'</button></div></div>');
			}
			
			shopist.event.remove_product_color_filter_field();
		}
	}
};

shopist.manageReportsData =
{
  reportsFiltersByDateRange:function ()
  {
    if($('.report-filter-by-date-range').length>0)
    {
      $('.report-filter-by-date-range').on('click', function()
      {
        
        if(!$('#filter_start_date').val())
        {
          $('#filter_start_date').css({'border': '1px solid #FF0000'});
          return false;
        }
        else
        {
          $('#filter_start_date').css({'border': '1px solid #d2d6de'});
        }
        
        if(!$('#filter_end_date').val())
        {
          $('#filter_end_date').css({'border': '1px solid #FF0000'});
          return false;
        }
        else
        {
          $('#filter_end_date').css({'border': '1px solid #d2d6de'});
        }
        
        
        if($('#filter_start_date').val() && $('#filter_end_date').val())
        {
          var dataObj = {};
          dataObj._report_name            = $('#report_name').val();
          dataObj._date_range_start_date  = $('#filter_start_date').val();
          dataObj._date_range_end_date    = $('#filter_end_date').val();

          $('.reports-content .eb-overlay-loader, .reports-content .eb-overlay').show();
          
          $.ajax({
            url: $('#hf_base_url').val() + '/ajax/report_data_by_filter',
            type: 'POST',
            cache: false,
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
            data: {dataObj:dataObj},
            
            success: function(data)
            {
              if(data.status == 'no_data')
              {
                if($('.reports-content .chart-responsive').find('.no-data-found').length == 0)
                {
                  $('.reports-content .chart-responsive').append('<p class="no-data-found">'+ adminLocalizationString.no_result_found +'</p>');
                }
                
                $('.reports-content .chart-responsive #product-title-bar-chart, .reports-content .chart-responsive .chart-y-axis-label').hide();
                reportProductTitleDataTable.fnClearTable();
              }
              else
              {
                var chartData = [];
                var dataTableData = [];

                if($('#report_name').val() == 'sales_by_product_title')
                {
                  $.each(data.data.report_details, function(key, val){
                    var ary = [];
                    chartData.push({ y: val.product_title, a: val.gross_sales });
                    ary.push(val.product_title, val.units_sold, val.gross_sales_with_currency);
                    dataTableData.push(ary);
                  });
                }
                else if($('#report_name').val() == 'sales_by_custom_days')
                {
                  $.each(data.data.report_details.sales_order_by_custom_days.report_data, function(key, val){
                    chartData.push({ y: val.day, a: val.gross_sales });
                  });

                  $.each(data.data.report_details.sales_order_by_custom_days.table_data, function(key, val){
                    var ary = [];
                    ary.push(val.order_id, val.order_date, val.order_status, val.order_totals_with_currency);
                    dataTableData.push(ary);
                  });
                }
                else if($('#report_name').val() == 'sales_by_payment_method')
                {
                  $.each(data.data.report_details.gross_sales_by_payment_method, function(key, val){
                    var ary = [];
                    chartData.push({ y: val.method, a: val.gross_sales });
                    ary.push(val.method, val.gross_sales_with_currency);
                    dataTableData.push(ary);
                  });
                }

                if(chartData.length > 0)
                {
                  productBar.setData( chartData );
                  $('.reports-content .chart-responsive #product-title-bar-chart, .reports-content .chart-responsive .chart-y-axis-label').show();
                }

                reportProductTitleDataTable.fnClearTable();

                if(dataTableData.length>0)
                {
                  reportProductTitleDataTable.fnAddData(dataTableData);
                }
                
                if($('.reports-content .chart-responsive').find('.no-data-found').length > 0)
                {
                  $('.reports-content .chart-responsive').find('.no-data-found').remove();
                }
              }
              
              $('.report-date').html(data.data.report_date);
              $('#filter_start_date, #filter_end_date').val('');
              $('.reports-content .eb-overlay-loader, .reports-content .eb-overlay').hide();
            },
            
            error:function(){}
          });
        }
      });
    }
  }
};

$(document).ready(function()
{
  shopist.pageLoad.elementLoad();
  shopist.event.removeProductImage();
  shopist.event.removeCatThumbnailImage();
  shopist.event.removeManufacturersImage();
  shopist.event.removeBannerImage();
  shopist.event.removeVariationImage();
  shopist.event.createCat();
  shopist.event.createTag();
  shopist.event.createAttributes();
  shopist.event.createColors();
  shopist.event.createSizes();
  shopist.event.createVariation();
  shopist.event.edit_panel_display();
  shopist.event.edit_attribute_panel_display();
  shopist.event.init_dropzone();
  shopist.event.model_event();
  shopist.event.model_event_tag();
  shopist.event.custom_event_attrs();
  shopist.event.custom_event_colors();
  shopist.event.custom_event_size();
  shopist.event.item_delete_from_list();
  shopist.event.item_status_change_from_comments_list();
  shopist.event.create_sale_schedule();
  shopist.event.cancel_sale_schedule();
  shopist.event.create_sale_variation_schedule();
  shopist.event.cancel_sale_variation_schedule();
  shopist.event.manage_stock();
  shopist.event.manage_variation_stock();
  shopist.event.create_variation();
  shopist.event.create_attribute();
  shopist.event.view_variation_by_id();
  shopist.event.change_product_type();
  shopist.event.add_new_design_element();
  shopist.event.open_product_video_upload_model();
  shopist.event.adminGalleryImageRemoveBtnDisplay();
  shopist.event.open_model_for_designer_img_upload();
  shopist.event.removeDesignerRelatedImage();
  shopist.event.removeElementPanel();
  shopist.event.check_available_attributes();
  shopist.event.restricted_area_checkbox_action();
  shopist.event.global_settings_enable_checkbox_action()
  shopist.manageReportsData.reportsFiltersByDateRange();
  shopist.event.manageFrontendTemplates();
  shopist.event.frontendAllImageRemoveBtnDisplay();
  shopist.event.addTextAndCustomCssOnImageDynamically();
	shopist.event.add_new_fields_for_compare();
	shopist.event.remove_product_compare_field();
  shopist.event.add_new_fields_for_color_filter();
  shopist.event.remove_product_color_filter_field();
});

//call dropzone multiple times 
var customDropZone = (function() {
  
  function customDropZone( options ){
    this.opts = options || {};
    for ( var prop in customDropZone.defaults ) {
       if (prop in this.opts) { continue; }
       this.opts[prop] = customDropZone.defaults[prop];
    }
    
    this.initializeDropZone();
  }
  
  customDropZone.prototype.initializeDropZone = function() {
    var name          =   this.opts.paramName;
    var base_url      =   this.opts.base_url;
    var maxSize       =   this.opts.maxFiles;
    var art_img_array =   [];
    
    $("div." + this.opts.uploader).dropzone({	
        url:                this.opts.url,
        params: {
        _token:             this.opts.token
        },
        paramName:          this.opts.paramName,
        acceptedFiles:      this.opts.acceptedFiles,
        autoProcessQueue:   this.opts.autoProcessQueue,
        uploadMultiple:     this.opts.uploadMultiple,
        parallelUploads:    this.opts.parallelUploads,
        addRemoveLinks:     this.opts.addRemoveLinks,
        maxFiles:           this.opts.maxFiles,
        maxFilesize:        this.opts.maxFilesize,
        headers:            { 'X-CSRF-TOKEN' :  this.opts.token},
        dataType:           'json',
        init: function() 
        {
          this.on("maxfilesexceeded", function(file)
          {
            swal("" , adminLocalizationString.dropzone_file_exceeded_msg_1 + ' '+ maxSize + ' '+ adminLocalizationString.dropzone_file_exceeded_msg_2 +' '+ maxSize + ' '+ adminLocalizationString.dropzone_file_exceeded_msg_3);
          });
          this.on("error", function(file, message)
          {
            if((!file.type.match('image.*'))) {
              swal("" , adminLocalizationString.please_upload_only_image_file);
              this.removeFile(file)
              return false;
            }
          });
          //this.on("addedfile", function(file) { swal("Good job!", "Successfully uploaded your image!", "success") });
          this.on("success", function(file, response) 
          {
            if(response.status === 'success')
            {  
              swal(adminLocalizationString.good_job, adminLocalizationString.successfully_uploaded_your_image, "success");
              if(name == 'product_image')
              {
                $('.product-uploaded-image img').attr('src', base_url + '/public/uploads/' + response.name);
                $('#productUploader').modal('hide');
                $('.product-sample-img').hide();
                $('.product-uploaded-image').show();

                if($('#hf_uploaded_all_images').length>0)
                {
                  shopist.normalFunction.createJsonDataForAllProductImage('product_image', '/public/uploads/' + response.name);
                }
              }
              else if(name == 'testimonial_image'){
                $('.testimonial-content .testimonial-uploaded-image img').attr('src', base_url + '/public/uploads/' + response.name);
                $('#testimonialUploader').modal('hide');
                $('.testimonial-content .testimonial-sample-img').hide();
                $('.testimonial-content .testimonial-uploaded-image').show();

                if($('#image_url').length>0){
                  $('#image_url').val( '/public/uploads/' + response.name );
		}
              }
              else if(name == 'featured_image'){
                $('.featured-img-content .featured-uploaded-image img').attr('src', base_url + '/public/uploads/' + response.name);
                $('#featuredUploader').modal('hide');
                $('.featured-img-content .featured-sample-img').hide();
                $('.featured-img-content .featured-uploaded-image').show();

                if($('#image_url').length>0){
                  $('#image_url').val( '/public/uploads/' + response.name );
		}
              }
              else if(name == 'product_gallery_images')
              {
                var parseResponse = $.parseJSON(response.name);
                
                if(parseResponse.length>0)
                {
                  for(var count = 0; count < parseResponse.length; count ++)
                  {
                    var id = shopist.normalFunction.make_random_id();
                    var strReplace = parseResponse[count].replace(/\.[^/.]+$/, "");
                    var addExtraId = strReplace;
                    
                    if($('.product-uploaded-gallery-image').find('.' + addExtraId).length == 0)
                    {
                      if($('.gallery-image-single-container').length>0)
                      {
                        $('.gallery-image-single-container:last').after('<div class="gallery-image-single-container '+ addExtraId +'"><img class="img-responsive" src="'+ base_url +'/public/uploads/'+ parseResponse[count] +'"><div data-id="'+ id +'" class="remove-gallery-img-link"></div></div>');
                      }
                      else
                      {
                        $('.product-uploaded-gallery-image').append('<div class="gallery-image-single-container '+ addExtraId +'"><img class="img-responsive" src="'+ base_url +'/public/uploads/'+ parseResponse[count] +'"><div data-id="'+ id +'" class="remove-gallery-img-link"></div></div>');
                      }

                      $('#productGalleryUploader').modal('hide');
                      $('.product-gallery-sample-img').hide();
                      $('.product-uploaded-gallery-image').show();
                      shopist.event.adminGalleryImageRemoveBtnDisplay();

                      if($('#hf_uploaded_all_images').length>0)
                      {
                        shopist.normalFunction.createJsonDataForAllProductImage('product_gallery_images', {id:id, url:'/public/uploads/' + parseResponse[count]});
                      }
                    }
                  }
                }
              }
              else if(name == 'shop_banner_image')
              {
                $('.banner-uploaded-image img').attr('src', base_url + '/public/uploads/' + response.name);
                $('#shopbannerUploader').modal('hide');
                $('.banner-sample-img').hide();
                $('.banner-uploaded-image').show();

                if($('#hf_uploaded_all_images').length>0)
                {
                  shopist.normalFunction.createJsonDataForAllProductImage('shop_banner_image', '/public/uploads/' + response.name);
                }
              }
              else if(name == 'cat_thumbnail_image')
              {
                $('.cat-img img').attr('src', base_url + '/public/uploads/' + response.name);
                $('.cat-img img').attr('data-img_url', '/public/uploads/' + response.name);
                $('.cat-img-upload-btn').show();
                $('.cat-sample-img').hide();
                $('.cat-img').show();
              }
              else if(name == 'manufacturers_logo')
              {
                $('.manufacturers-img img').attr('src', base_url + '/public/uploads/' + response.name);
                $('.manufacturers-img-remove-btn').show();
                $('.manufacturers-sample-img').hide();
                $('.manufacturers-img').show();
                $('#logo_img').val('/public/uploads/' + response.name);
              }
              else if(name == 'variation_img')
              {
                $('.variation-img img').attr('src', base_url + '/public/uploads/' + response.name);
                $('.variation-img-upload-btn').show();
                $('.variation-sample-img').hide();
                $('.variation-img').show();
              }
              else if(name == 'designer_img')
              {
                if(clickTrackForDesignerUploader && clickTrackForDesignerUploader.split(',')[0] == 'only_design_img')
                {
                  $('.collapse-' + clickTrackForDesignerUploader.split(',')[1]).find('.design-img img').attr('src', base_url + '/public/uploads/' + response.name);
                  $('.collapse-' + clickTrackForDesignerUploader.split(',')[1]).find('.design-img-upload-btn .remove-design-img').show();
                  $('.collapse-' + clickTrackForDesignerUploader.split(',')[1]).find('.design-sample-img').hide();
                  $('.collapse-' + clickTrackForDesignerUploader.split(',')[1]).find('.design-img').show();

                  shopist.normalFunction.createJsonDataForAllDesignerImage('only_design_img', clickTrackForDesignerUploader.split(',')[1], '/public/uploads/' + response.name);
                }
                else if(clickTrackForDesignerUploader && clickTrackForDesignerUploader.split(',')[0] == 'only_trans_design_img')
                {
                  $('.collapse-' + clickTrackForDesignerUploader.split(',')[1]).find('.trans-design-img img').attr('src', base_url + '/public/uploads/' + response.name);
                  $('.collapse-' + clickTrackForDesignerUploader.split(',')[1]).find('.trans-design-img-upload-btn .remove-design-img').show();
                  $('.collapse-' + clickTrackForDesignerUploader.split(',')[1]).find('.trans-design-sample-img').hide();
                  $('.collapse-' + clickTrackForDesignerUploader.split(',')[1]).find('.trans-design-img').show();

                  shopist.normalFunction.createJsonDataForAllDesignerImage('only_trans_design_img', clickTrackForDesignerUploader.split(',')[1], '/public/uploads/' + response.name);
                }
                else if(clickTrackForDesignerUploader && clickTrackForDesignerUploader.split(',')[0] == 'only_design_title_img')
                {
                  $('.collapse-' + clickTrackForDesignerUploader.split(',')[1]).find('.design-title-img img').attr('src', base_url + '/public/uploads/' + response.name);
                  $('.collapse-' + clickTrackForDesignerUploader.split(',')[1]).find('.design-title-img-upload-btn .remove-design-title-img').show();
                  $('.collapse-' + clickTrackForDesignerUploader.split(',')[1]).find('.design-title-sample-img').hide();
                  $('.collapse-' + clickTrackForDesignerUploader.split(',')[1]).find('.design-title-img').show();

                  shopist.normalFunction.createJsonDataForAllDesignerImage('only_design_title_img', clickTrackForDesignerUploader.split(',')[1], '/public/uploads/' + response.name);
                }

                $('#designerImageUploader').modal('hide');
              }
              else if(name == 'art_imges')
              {
                var parseResponse = $.parseJSON(response.name);
                
                if(parseResponse.length>0)
                {
                  for(var count = 0; count < parseResponse.length; count ++)
                  {
                    var id = shopist.normalFunction.make_random_id();
                    var strReplace = parseResponse[count].replace(/\.[^/.]+$/, "");
                    var addExtraId = strReplace;
                    
                    if($('.uploaded-all-art-images').find('.' + addExtraId).length == 0)
                    {
                      if($('#ht_art_upload_status').length>0 && $('#ht_art_upload_status').val() == 'new_add')
                      {
                        if($('#ht_art_all_uploaded_images').length>0)
                        {
                          if($('#ht_art_all_uploaded_images').val() == '' || $('#ht_art_all_uploaded_images').val().length == 0)
                          {
                            art_img_array.push({ id:id, url:base_url +'/public/uploads/'+ parseResponse[count]});
                            $('#ht_art_all_uploaded_images').val( JSON.stringify(art_img_array) );
                          }
                          else
                          {
                            art_img_array = JSON.parse($('#ht_art_all_uploaded_images').val());
                            art_img_array.push({ id:id, url:base_url +'/public/uploads/'+ parseResponse[count]});
                            $('#ht_art_all_uploaded_images').val( JSON.stringify(art_img_array) );
                          }
                        }

                        if($('.uploaded-all-art-images .art-image-single-container').length>0)
                        {
                          $('.uploaded-all-art-images .art-image-single-container:last').after('<div class="art-image-single-container '+ addExtraId +'"><img class="img-responsive" src="'+ base_url +'/public/uploads/'+ parseResponse[count] +'"><div data-id="'+ id +'" class="remove-art-img-link"></div></div>');
                        }
                        else
                        {
                          $('.uploaded-all-art-images').append('<div class="art-image-single-container '+ addExtraId +'"><img class="img-responsive" src="'+ base_url +'/public/uploads/'+ parseResponse[count] +'"><div data-id="'+ id +'" class="remove-art-img-link"></div></div>');
                        }
                      }

                      shopist.event.adminGalleryImageRemoveBtnDisplay();
                    }
                  }
                }
              }
              else if(name == 'update_art_imges')
              {
                if(response.name)
                {
                  var id = shopist.normalFunction.make_random_id();

                  if($('#ht_art_upload_status').length>0 && $('#ht_art_upload_status').val() == 'update')
                  {
                    var update_art_img_array =   [];

                    if($('#ht_art_all_uploaded_images').length>0)
                    {
                      update_art_img_array.push({ id:id, url:base_url +'/public/uploads/'+ response.name});
                      $('#ht_art_all_uploaded_images').val( JSON.stringify(update_art_img_array) );
                    }

                    if($('.uploaded-all-art-images .art-image-single-container').length>0)
                    {
                      $('.uploaded-all-art-images .art-image-single-container').remove();
                    }

                    $('.uploaded-all-art-images').append('<div class="art-image-single-container"><img class="img-responsive" src="'+ base_url +'/public/uploads/'+ response.name +'"><div data-id="'+ id +'" class="remove-art-img-link"></div></div>');
                  }

                  shopist.event.adminGalleryImageRemoveBtnDisplay();
                }
              }
              else if(name == 'profile_picture')
              {
                $('.profile-picture').find('img').attr('src', base_url + '/public/uploads/'+ response.name);
                $('.profile-picture').show();
                $('.no-profile-picture').hide();
                $('#uploadprofilepicture').modal('hide');
                $('#hf_profile_picture').val( '/public/uploads/' + response.name );
              }
              else if(name == 'site_picture')
              {
                $('.site-logo-container').find('img').attr('src', base_url + '/public/uploads/'+ response.name);
                $('.site-logo-container').show();
                $('.no-logo-image').hide();
                $('#uploadSiteLogo').modal('hide');
                $('#hf_site_picture').val( '/public/uploads/'+ response.name );
              }
              else if(name == 'vendor_cover_picture')
              {
                $('.vendor-cover-image-container').find('img').attr('src', base_url + '/public/uploads/'+ response.name);
                $('.vendor-cover-image-container').show();
                $('.no-cover-image').hide();
                $('#uploadVendorCoverImage').modal('hide');
                $('#hf_vendor_cover_picture').val( '/public/uploads/'+ response.name );
              }
              else if(name == 'frontend_all_images')
              {
                var parseResponse = $.parseJSON(response.name);
                
                if(parseResponse.length>0)
                {
                  for(var count = 0; count < parseResponse.length; count ++)
                  {
                    var id = shopist.normalFunction.make_random_id();
                    var strReplace = parseResponse[count].replace(/\.[^/.]+$/, "");
                    var addExtraId = strReplace;
                    
                    if($('.uploaded-header-slider-images .uploaded-slider-images').find('.' + addExtraId).length == 0)
                    {
                      if($('.header-slider-image-single-container').length>0)
                      {
                        $('.header-slider-image-single-container:last').after('<div class="header-slider-image-single-container '+ addExtraId +'"><img class="img-responsive" src="'+ base_url +'/public/uploads/'+ parseResponse[count] +'"><div data-id="'+ id +'" class="remove-frontend-img-link"></div><div class="header-slider-image-add-text-btn"><button type="button" data-id="'+ id +'" class="btn btn-default btn-sm add-text-and-custom-css-btn">'+ adminLocalizationString.text_add_btn_label +'</button></div></div>');
                      }
                      else
                      {
                        $('.uploaded-header-slider-images .uploaded-slider-images').append('<div class="header-slider-image-single-container '+ addExtraId +'"><img class="img-responsive" src="'+ base_url +'/public/uploads/'+ parseResponse[count] +'"><div data-id="'+ id +'" class="remove-frontend-img-link"></div><div class="header-slider-image-add-text-btn"><button type="button" data-id="'+ id +'" class="btn btn-default btn-sm add-text-and-custom-css-btn">'+ adminLocalizationString.text_add_btn_label +'</button></div></div>');
                      }
                      
                      shopist.event.frontendAllImageRemoveBtnDisplay();
                      shopist.event.addTextAndCustomCssOnImageDynamically();
                      
                      if($('#_frontend_images_json').length>0)
                      {
                        shopist.normalFunction.createJsonDataForAllFrontendImage('header_slider_images', {id:id, url:'/public/uploads/' + parseResponse[count]});
                      }
                      
                      $('#frontendImageUploader').modal('hide');
                      $('.uploaded-header-slider-images .sample-img').hide();
                      $('.uploaded-header-slider-images .uploaded-slider-images').show();
                    }
                  }
                }
              }
              this.removeAllFiles();
            }  
          });
        }
    });
  };
  
  customDropZone.defaults = {
      base_url:'default',
      url:'default',
      token:'default',
      uploader: "default",
      paramName: "default",
      acceptedFiles: "default",
      autoProcessQueue: true,
      uploadMultiple: false,
      parallelUploads: 100,
      addRemoveLinks: true,
      maxFilesize: 256,
      maxFiles: 1,
    };

  return customDropZone;
})();