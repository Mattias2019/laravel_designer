<div class="product-designer-content clearfix">
  <div class="product-designer-top-menu">
    <div class="clearfix">
      <ul class="pull-left">
       <li><a id="downloadImgLink" href="#" download="product.png"><span class="fa fa-search-plus icon-span"></span><span class="text-span"> Zoom </span></a></li>
       <li class="icon-img-pdf"><span class="fa fa-object-group icon-span"></span><span class="text-span">Magnify</span></li>
       <li class="icon-img-print"><span class="fa fa-share icon-span"></span><span class="text-span">Reset</span></li>
     </ul>
      <ul class="pull-right">
        <li><a id="downloadImgLink" href="#" download="product.png"><span class="fa fa-download icon-span"></span><span class="text-span">{!! trans('designer.download_label') !!}</span></a></li>
        <li class="icon-img-pdf"><span class="fa fa-print icon-span"></span><span class="text-span">{!! trans('designer.pdf_label') !!}</span></li>
        <li class="icon-img-print"><span class="fa fa-print icon-span"></span><span class="text-span">{!! trans('designer.print_label') !!}</span></li>
      </ul>
    </div>  
  </div>
  
  <div class="product-designer-canvas-content-main">
    <div class="product-designer-left-menu">
      <ul>
        <li class="add-text" data-tab_name="text"><span class="fa fa-text-width icon-span"></span><span class="text-span">{!! trans('designer.add_text_label') !!}</span></li>
        <li class="images-gallery" data-tab_name="clipart"><span class="fa fa-picture-o icon-span"></span><span class="text-span">{!! trans('designer.images_gallery_label') !!}</span></li>
        <li class="upload-images" data-tab_name="image_upload"><span class="fa fa-upload icon-span"></span><span class="text-span">{!! trans('designer.upload_images_label') !!}</span></li>
        <li class="add-shape" data-tab_name="shape_add"><span class="fa fa-square icon-span"></span><span class="text-span">{!! trans('designer.shapes_label') !!}</span></li>
        <li class="manage-layer" data-tab_name="manage_layer"><span class="fa fa-window-restore icon-span"></span><span class="text-span">{!! trans('designer.manage_layers_label') !!}</span></li>
      </ul>
    </div>
    <div class="product-designer-canvas-content">
      <div class="canvas-design-panel">
        <canvas id="designer_canvas"></canvas>
      </div>
    </div>
    <div class="product-designer-swap-content">
      <ul>
        <?php $count = 0;?>
        @foreach($designer_img_elments as $row)
        
        <li <?php if($count == 0) {?> class="selected-swap"<?php }?> data-id="{{ $row->id }}" data-design_img_url="{{ get_image_url($row->design_img_url) }}" data-design_trans_img_url="{{ get_image_url($row->design_trans_img_url) }}"><img src="{{ get_image_url($row->design_title_icon) }}"><span>{!! $row->title_label !!}</span></li>
        <input type="hidden" name="hf_design_save_json_data_{{$row->id}}" id="hf_design_save_json_data_{{$row->id}}" value="{{ $design_save_data }}">
        <?php $count ++;?>
        @endforeach
        @if(isset($designer_img_elmentsback))
        @if(count($designer_img_elmentsback)>0 )
        @foreach($designer_img_elmentsback as $row)
        
        <li <?php if($count == 0) {?> class="selected-swap"<?php }?> data-id="{{ $row->id }}" data-design_img_url="{{ get_image_url($row->design_img_url) }}" data-design_trans_img_url="{{ get_image_url($row->design_trans_img_url) }}"><img src="{{ get_image_url($row->design_title_icon) }}"><span>{!! $row->title_label !!}</span></li>
        <input type="hidden" name="hf_design_save_json_data_{{$row->id}}" id="hf_design_save_json_data_{{$row->id}}" value="{{ $design_save_databackside }}">
        <?php $count ++;?>
        @endforeach    
        @endif 
        @endif
       </ul>
    </div>
    <div style="clear:both;"></div>
  </div>
  
  <div class="designer-text-control panel panel-default">
    <div class="panel-heading" id="draggable-handle">
      {{ trans('frontend.rearrange_your_text') }}
      <i class="fa fa-close pull-right close-design-control-modal" data-name="text"></i>
    </div>

    <div class="panel-body">
      <p><i>{{ trans('frontend.edit_your_text') }}</i></p>
      <div class="dynamic-change-text"><textarea name="change_dynamic_text" id="change_dynamic_text"></textarea></div>
      <div class="remove-selected-object" data-toggle="tooltip" data-placement="left" title="{{ trans('frontend.text_remove') }}"></div>
      <hr>
      <p><i>{{ trans('frontend.enable_curved_text') }}</i></p>
      <div class="enable-curve-text">
        <input type="checkbox" value="None" id="enableCurvedText" name="enableCurvedText" />
        <label for="enableCurvedText"></label>
      </div>
      <div class="curved-text-elements">
        <p><i>{{ trans('frontend.change_radius') }}</i></p>
        <div class="change-radius"><input id="change_radius" type="text" name="change_radius" data-name="radius" value=""></div>
        <p><i>{{ trans('frontend.change_spacing') }}</i></p>
        <div class="change-spacing"><input id="change_spacing" type="text" name="change_spacing" data-name="spacing" value=""></div>
        <p><i>{{ trans('frontend.reverse') }}</i></p>
        <div class="enable-reverse">
          <input type="checkbox" value="None" data-name="reverse" id="enableCurvedTextReverse" name="enableCurvedTextReverse" />
          <label for="enableCurvedTextReverse"></label>
        </div>
      </div>
      <p><i>{{ trans('frontend.change_font_family') }}</i></p>
      <div class="dynamic-fonts-change">
        <select id="change_fonts" name="change_fonts" class="change-text-attribute" data-name="fontFamily">
          <option value="-1">{{ trans('frontend.select_font') }}</option>
          <option value="arial">arial</option>

          @if(count($fonts_list) > 0)
            @foreach($fonts_list as $font)
            <option value="{{ $font['post_slug'] }}" style="font-family:{{ $font['post_slug'] }}">{!! $font['post_title'] !!}</option>
            @endforeach
          @endif
        </select>
      </div>
      <p><i>{{ trans('frontend.change_line_height') }}</i></p>
      <div class="dynamic-line-height">
          <input id="text_line_height" type="text" name="text_line_height" data-name="lineHeight" value="">
      </div>
      <p><i>{{ trans('frontend.change_text_color') }}</i></p>
      <div class="dynamic-color-change">
          <input class="color change-text-attribute" data-name="fill" type="text" id="change_text_color" name="change_text_color">
      </div>
      <p><i>{{ trans('frontend.change_text_alignment') }}</i></p>
      <div class="dynamic-text-alignment">
          <ul class="text-align">
            <li class="align-left" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.align_left') }}"><span class="icon-img-left-alignment"></span></li>
            <li class="align-center" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.align_center') }}"><span class="icon-img-center-alignment"></span></li>
            <li class="align-right" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.align_right') }}"><span class="icon-img-right-alignment"></span></li>
          </ul>
      </div>
      <p><i>{{ trans('frontend.change_text_style') }}</i></p>
      <div class="dynamic-text-font-weight">
          <ul class="text-font-weight">
            <li class="normal" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.normal_style') }}"><span class="icon-img-font-weight-normal"></span></li>
            <li class="bold" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.text_bold') }}"><span class="icon-img-font-weight-bold"></span></li>
            <li class="italic" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.text_italic') }}"><span class="icon-img-font-weight-italic"></span></li>
          </ul>
      </div>
      <p><i>{{ trans('frontend.change_text_decoration') }}</i></p>
      <div class="dynamic-text-decoration">
          <ul class="textDecoration">
            <li class="none" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.normal_decoration') }}"><span class="icon-img-decoration-normal"></span></li>
            <li class="underline" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.text_underline') }}"><span class="icon-img-decoration-underline"></span></li>
            <li class="line-through" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.text_line_through') }}"><span class="icon-img-decoration-line-through"></span></li>
            <li class="overline" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.text_overline') }}"><span class="icon-img-decoration-overline"></span></li>
          </ul>
      </div>
      <p><i>{{ trans('frontend.change_text_opacity') }}</i></p>
      <div class="dynamic-text-opacity">
        <input type="text" id="change_text_opacity" name="change_text_opacity">
      </div>
      <p><i>{{ trans('frontend.change_text_shadow_color') }}</i></p>
      <div class="dynamic-text-shadow-color"> 
        <div class="shadow-color"><input class="color change-text-shadow" data-name="color" type="text" id="change_text_shadow_color" name="change_text_shadow_color"></div>
      </div>
      <p><i>{{ trans('frontend.change_text_shadow_offset_x') }}</i></p>
      <div class="shadow-offset-x"><input type="text" id="change_text_x_shadow" data-name="offset_x" name="change_text_x_shadow"></div>
      <p><i>{{ trans('frontend.change_text_shadow_offset_y') }}</i></p>
      <div class="shadow-offset-y"><input type="text" id="change_text_y_shadow" data-name="offset_y" name="change_text_y_shadow"></div>
      <p><i>{{ trans('frontend.change_text_shadow_blur') }}</i></p>
      <div class="shadow-blur"><input type="text" id="change_text_blur_shadow" data-name="blur" name="change_text_blur_shadow"></div>
      <p><i>{{ trans('frontend.change_more_option') }}</i></p>
      <div class="dynamic-text-more-option">
          <ul>
            <li class="object-flip-x" data-name="flip-x" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.flip_x') }}"><span class="icon-object-flip-x"></span></li>
            <li class="object-flip-y" data-name="flip-y" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.flip_y') }}"><span class="icon-object-flip-y"></span></li>
            <li class="object-move-front" data-name="move-front" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.move_to_front') }}"><span class="icon-object-move-front"></span></li>
            <li class="object-move-back" data-name="move-back" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.send_to_back') }}"><span class="icon-object-move-back"></span></li>
            @if(!Request::is('product/customize/*'))
            <li class="object-lock" data-name="lock" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.lock_unlock') }}"><span class="icon-object-lock"></span></li>
            @endif
          </ul>
      </div>
    </div>
  </div>
  
  <div class="designer-image-gallery panel panel-default">
    <div class="panel-heading" id="draggable-handle">
      {{ trans('frontend.image_gallery') }}
      <i class="fa fa-close pull-right close-design-control-modal" data-name="gallery"></i>
    </div>
    <div class="panel-body">
      @if(count($art_cat_lists_data) >0)
        <div class="gallery-image-categories-list">
          @foreach($art_cat_lists_data as $atr_cat_row)
            @if($atr_cat_row['status'] == 1)
            <div data-cat_id="{{ $atr_cat_row['term_id'] }}" class="gallery-items"><span>{!! $atr_cat_row['name'] !!}</span></div>
            @endif
          @endforeach
          <div class="clear_both"></div>
        </div>
      @else 
        <div class="no-available-msg">{{ trans('frontend.no_clipart_categories_yet') }}</div>
      @endif
    </div>
  </div>
  
  <div class="designer-image-edit-panel panel panel-default">
    <div class="panel-heading" id="draggable-handle">
        {{ trans('frontend.rearrange_your_added_images') }}
        <i class="fa fa-close pull-right close-design-control-modal" data-name="image"></i>
    </div>
    <div class="panel-body">
      <p><i>{{ trans('frontend.change_image_color') }}</i></p>
      <div class="dynamic-color-change">
          <input class="color" data-name="fill" data-type="image" type="text" id="change_img_color" name="change_img_color">
      </div>
      <div class="image-opacity-option">
        <p><i>{{ trans('frontend.change_image_opacity') }}</i></p>
        <div class="dynamic-img-opacity">
          <input type="text" id="change_img_opacity" name="change_img_opacity">
        </div>
      </div>
      <p><i>{{ trans('frontend.change_more_option') }}</i></p>
      <div class="dynamic-img-more-option">
          <ul>
            <li class="object-flip-x" data-name="flip-x" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.flip_x') }}"><span class="icon-object-flip-x"></span></li>
            <li class="object-flip-y" data-name="flip-y" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.flip_y') }}"><span class="icon-object-flip-y"></span></li>
            <li class="object-move-front" data-name="move-front" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.move_to_front') }}"><span class="icon-object-move-front"></span></li>
            <li class="object-move-back" data-name="move-back" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.send_to_back') }}"><span class="icon-object-move-back"></span></li>
            @if(!Request::is('product/customize/*'))
            <li class="object-lock" data-name="lock" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.lock_unlock') }}"><span class="icon-object-lock"></span></li>
            @endif
            <li class="object-remove" data-name="remove" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.remove') }}"><span class="remove-selected-object"></span></li>
          </ul>
      </div>
    </div>
  </div>
  
  <div class="designer-upload-image panel panel-default">
    <div class="panel-heading" id="draggable-handle">
      {{ trans('frontend.upload_your_images') }}
      <i class="fa fa-close pull-right close-design-control-modal" data-name="upload"></i>
    </div>
    <div class="panel-body">
      <p class="no-margin">{{ trans('frontend.you_can_upload_1_image') }}</p>
      <div class="dropzone dz-clickable" id="file_upload_for_designer" name="file_upload_for_designer">
        <div class="dz-default dz-message">
          <span>{{ trans('frontend.drop_your_cover_picture_here') }}</span>
        </div>
      </div>
      <div class="recently-uploaded-images">
        <br>
        @if( count(get_recent_uploaded_images_for_designer())>0 )
          @foreach(get_recent_uploaded_images_for_designer() as $data)
            <div class="recent-images-items"><img src="{{ url('/') }}/public/uploads/{{ $data }}"></div>
          @endforeach
          <div class="clear_both"></div>
        @else
          <div class="no-available-msg">{{ trans('frontend.no_recently_uploaded_images_yet') }}</div>
        @endif
      </div>
    </div>
  </div>
  
  <div class="modal fade" id="designPreview" tabindex="-1" role="dialog" aria-labelledby="updater" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">✕</button>
          <br>
          <i class="icon-credit-card icon-7x"></i>
          <p class="no-margin">{{ trans('frontend.design_preview') }}</p>
        </div>
        <div class="modal-body" style="text-align:center;overflow:auto;"><img src=""></div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default attachtopost" data-dismiss="modal">{{ trans('frontend.close') }}</button>
        </div>
      </div>
    </div>
  </div>
  
  <div class="designer-shape-gallery panel panel-default">
    <div class="panel-heading" id="draggable-handle">
      {{ trans('frontend.shape_label') }}
      <i class="fa fa-close pull-right close-design-control-modal" data-name="shape"></i>
    </div>
    <div class="panel-body">
      @if(count($shape_list) >0)
        <div class="shape-list">
          <ul>
            @foreach($shape_list as $shape)
            <li data-shape="{{ $shape['post_content'] }}">{!! base64_decode($shape['post_content']) !!}</li>
            @endforeach
          </ul>
        </div>
      @else 
        <div class="no-available-msg">{{ trans('frontend.no_shape_yet') }}</div>
      @endif
    </div>
  </div>
  
  <div class="designer-layer-content panel panel-default">
    <div class="panel-heading" id="draggable-handle">
      {{ trans('designer.manage_layers_top_label') }}
      <i class="fa fa-close pull-right close-design-control-modal" data-name="layer"></i>
    </div>
    <div class="panel-body"></div>
  </div>
  <div id="designer-shadow-layer">
    <div class="designer-add-to-cart-loader">
      <img src="/images/ajax-loader.gif" id="img-load">
    </div>
  </div>
</div>
<input type="hidden" name="hf_designer_settings_json" id="hf_designer_settings_json" value="{{ json_encode($designer_hf_data) }}">
<input type="hidden" name="track_is_loaded_first" id="track_is_loaded_first" value="{{ get_image_url($designer_img_elments[0]->design_img_url) }}">
<input type="hidden" name="track_is_trans_loaded_first" id="track_is_trans_loaded_first" value="{{ get_image_url($designer_img_elments[0]->design_trans_img_url) }}">
<input type="hidden" name="hf_design_save_json_data" id="hf_design_save_json_data" value="{{ $design_save_data }}">

<style type="text/css">
  .select2-drop {
    z-index: 99999;
}

.select2-results {
    z-index: 99999;
}

.select2-result {
    z-index: 99999;
}

@if(count($designer_img_elments)>1)
  .design-title-items
  {
    width: calc(50% - 5px) !important;
  }
@else
  width: calc(100% - 5px) !important;
@endif
</style>