@section('vendors-general-settings-page-content')
<div id="vendor_general_settings">
  <div class="box box-solid">
    <div class="row">
      <div class="col-md-12">
        <div class="box-body">
          <div class="form-group">
              <label class="col-sm-4 control-label" for="inputCoverImage">{{ trans('admin.cover_image_label') }} <i class="fa fa-question-circle" data-container="body" data-toggle="popover" data-placement="right" data-content="{{ trans('popover.vendor_cover_image') }}"></i></label>
            <div class="col-sm-8">
              @if(!empty($vendors_settings->general_details->cover_img))
              <div class="vendor-cover-image-container">
                <div class="img-div"><img src="{{ get_image_url( $vendors_settings->general_details->cover_img ) }}" class="vendor-cover-image" alt=""/></div><br>
                <div class="btn-div"><button type="button" class="btn btn-default btn-sm remove-vendor-cover-image">{{ trans('admin.remove_image') }}</button></div>
              </div>
              <div class="no-cover-image" style="display:none;">
                <div class="img-div"><img src="{{ default_upload_sample_img_src() }}" class="vendor-cover-image" alt=""/></div><br>
                <div class="btn-div"><button data-toggle="modal" data-target="#uploadVendorCoverImage" type="button" class="btn btn-default btn-sm vendor-cover-image-uploader">{{ trans('admin.upload_image') }}</button></div>
              </div>
              @else
              <div class="vendor-cover-image-container" style="display:none;">
                <div class="img-div"><img src="" class="vendor-cover-image" alt=""/></div><br>
                <div class="btn-div"><button type="button" class="btn btn-default btn-sm remove-vendor-cover-image">{{ trans('admin.remove_image') }}</button></div>
              </div>
              <div class="no-cover-image">
                <div class="img-div"><img src="{{ default_upload_sample_img_src() }}" class="vendor-cover-image" alt=""/></div><br>
                <div class="btn-div"><button data-toggle="modal" data-target="#uploadVendorCoverImage" type="button" class="btn btn-default btn-sm vendor-cover-image-uploader">{{ trans('admin.upload_image') }}</button></div>
              </div>
              @endif

              <div class="modal fade" id="uploadVendorCoverImage" tabindex="-1" role="dialog" aria-labelledby="updater" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">✕</button>
                      <br>
                      <i class="icon-credit-card icon-7x"></i>
                      <p class="no-margin">{{ trans('admin.you_can_upload_1_image') }}</p>
                    </div>
                    <div class="modal-body">             
                      <div class="uploadform dropzone no-margin dz-clickable vendor-cover-picture-uploader" id="vendor_cover_picture_uploader" name="vendor_cover_picture_uploader">
                        <div class="dz-default dz-message">
                          <span>{{ trans('admin.drop_your_cover_picture_here') }}</span>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default attachtopost" data-dismiss="modal">{{ trans('admin.close') }}</button>
                    </div>
                  </div>
                </div>
              </div> 
              <input type="hidden" name="hf_vendor_cover_picture" id="hf_vendor_cover_picture" value="{{ $vendors_settings->general_details->cover_img }}">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label" for="inputAddCat">{{ trans('admin.select_cat_label') }} <i class="fa fa-question-circle" data-container="body" data-toggle="popover" data-placement="right" data-content="{{ trans('popover.vendor_cat_add') }}"></i></label>
            <div class="col-sm-8">
              <input type="text" name="parent_categories" placeholder="{{ trans('admin.search_cat_label') }}" class="typeahead vendor-parents-cat vendor-parent-cat-typeahead tm-input form-control tm-input-info"/>
            </div>
          </div> 
          <br>
          <h4><i><strong>{{ trans('admin.google_map_details_label') }}</strong></i></h4><hr>
          
          <div class="form-group">
            <label class="col-sm-4 control-label" for="inputGoogleMapAPIKey">{{ trans('admin.google_map_api_key_label') }}</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" name="google_map_api_key" id="google_map_api_key" value="{{ $vendors_settings->general_details->google_map_app_key }}">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label" for="inputLatitude">{{ trans('admin.google_map_latitude_label') }}</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" name="google_map_latitude" id="google_map_latitude" value="{{ $vendors_settings->general_details->latitude }}">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label" for="inputLongitude">{{ trans('admin.google_map_longitude_label') }}</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" name="google_map_longitude" id="google_map_longitude" value="{{ $vendors_settings->general_details->longitude }}">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
    <input type="hidden" name="selected_vendor_categories" id="selected_vendor_categories" value="{{ $vendors_settings->general_details->vendor_home_page_cats }}">  
</div>
<input type="hidden" name="hf_update_vendor_general_settings" id="hf_update_vendor_general_settings" value="update_vendor_general_settings">
@endsection