@section('vendors-profile-page-content')
<div id="vendor_profile">
  <div class="box box-solid">
    <div class="row">
      <div class="col-md-12">
        <div class="box-body">
          <div class="form-group">
            <label class="col-sm-4 control-label" for="inputDisplayName">{{ trans('admin.display_name') }}</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="inputDisplayName" name="inputDisplayName" value="{{ $user_details->user_display_name }}" placeholder="{{ trans('admin.display_name') }}"/>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-4 control-label" for="inputUserName">{{ trans('admin.user_name') }}</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="inputUserName" name="inputUserName" value="{{ $user_details->user_name }}" placeholder="{{ trans('admin.user_name') }}"/>
            </div>
          </div>

           <div class="form-group">
            <label class="col-sm-4 control-label" for="inputEmail">{{ trans('admin.email') }}</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="inputEmail" name="inputEmail" value="{{ $user_details->user_email }}" placeholder="{{ trans('admin.email') }}"/>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-4 control-label" for="inputNewPassword">{{ trans('admin.new_password') }}</label>
            <div class="col-sm-8">
              <input type="password" class="form-control" id="inputNewPassword" name="inputNewPassword" placeholder="{{ trans('admin.new_password') }}"/>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-4 control-label" for="inputStoreName">{{ trans('admin.vendors_table_header_shop_name') }}</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="inputStoreName" name="inputStoreName" value="{{ $vendors_settings->profile_details->store_name }}" placeholder="{{ trans('admin.vendors_table_header_shop_name') }}"/>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-4 control-label" for="inputAddress1">{{ trans('admin.address_1') }}</label>
            <div class="col-sm-8">
              <textarea class="form-control" name="inputAddress1" id="inputAddress1" placeholder="{{ trans('admin.address_1') }}">{!! $vendors_settings->profile_details->address_line_1 !!}</textarea>
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-4 control-label" for="inputAddress2">{{ trans('admin.address_2') }}</label>
            <div class="col-sm-8">
              <textarea class="form-control" name="inputAddress2" id="inputAddress2" placeholder="{{ trans('admin.address_2') }}">{!! $vendors_settings->profile_details->address_line_2 !!}</textarea>
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-4 control-label" for="inputCity">{{ trans('admin.city') }}</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="inputCity" name="inputCity" value="{{ $vendors_settings->profile_details->city }}" placeholder="{{ trans('admin.city') }}"/>
            </div>
          </div>  
          
          <div class="form-group">
            <label class="col-sm-4 control-label" for="inputState">{{ trans('admin.vendor_state_label') }}</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="inputState" name="inputState" value="{{ $vendors_settings->profile_details->state }}" placeholder="{{ trans('admin.vendor_state_label') }}"/>
            </div>
          </div>
            
          <div class="form-group">
            <label class="col-sm-4 control-label" for="inputCountry">{{ trans('admin.country') }}</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="inputCountry" name="inputCountry" value="{{ $vendors_settings->profile_details->country }}" placeholder="{{ trans('admin.country') }}"/>
            </div>
          </div> 
          
          <div class="form-group">
            <label class="col-sm-4 control-label" for="inputZipPostalCode">{{ trans('admin.vendor_zip_postal_label') }}</label>
            <div class="col-sm-8">
              <input type="number" class="form-control" id="inputZipPostalCode" name="inputZipPostalCode" value="{{ $vendors_settings->profile_details->zip_postal_code }}" placeholder="{{ trans('admin.vendor_zip_postal_label') }}"/>
            </div>
          </div>   
            
          <div class="form-group">
            <label class="col-sm-4 control-label" for="inputPhoneNumber">{{ trans('admin.vendors_table_header_phone_number') }}</label>
            <div class="col-sm-8">
              <input type="number" class="form-control" id="inputPhoneNumber" name="inputPhoneNumber" value="{{ $vendors_settings->profile_details->phone }}" placeholder="{{ trans('admin.vendors_table_header_phone_number') }}"/>
            </div>
          </div> 
            
          <div class="form-group">
            <div class="col-sm-4">
              <label class="control-label" for="inputProfilePicture">{{ trans('admin.profile_picture') }}</label>
            </div>
            <div class="col-sm-8 profile-picture-content">
               @if(!empty($user_details->user_photo_url))
                <div class="profile-picture">
                  <div class="img-div"><img src="{{ get_image_url($user_details->user_photo_url) }}" class="user-image" alt=""/></div><br>
                  <div class="btn-div"><button type="button" class="btn btn-default btn-sm remove-profile-picture">{{ trans('admin.remove_image') }}</button></div>
                </div>
                <div class="no-profile-picture" style="display:none;">
                  <div class="img-div"><img src="{{ default_upload_sample_img_src() }}" class="user-image" alt=""/></div><br>
                  <div class="btn-div"><button data-toggle="modal" data-target="#uploadprofilepicture" type="button" class="btn btn-default btn-sm profile-picture-uploader">{{ trans('admin.upload_image') }}</button></div>
                </div>
               @else
               <div class="profile-picture" style="display:none;">
                  <div class="img-div"><img src="" class="user-image" alt=""/></div><br>
                  <div class="btn-div"><button type="button" class="btn btn-default btn-sm remove-profile-picture">{{ trans('admin.remove_image') }}</button></div>
                </div>
               <div class="no-profile-picture">
                  <div class="img-div"><img src="{{ default_upload_sample_img_src() }}" class="user-image" alt=""/></div><br>
                  <div class="btn-div"><button data-toggle="modal" data-target="#uploadprofilepicture" type="button" class="btn btn-default btn-sm profile-picture-uploader">{{ trans('admin.upload_image') }}</button></div>
               </div>
               @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>    
<div class="modal fade" id="uploadprofilepicture" tabindex="-1" role="dialog" aria-labelledby="updater" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">✕</button>
        <br>
        <i class="icon-credit-card icon-7x"></i>
        <p class="no-margin">{{ trans('admin.you_can_upload_1_image') }}</p>
      </div>
      <div class="modal-body">             
        <div class="uploadform dropzone no-margin dz-clickable profile-picture-uploader" id="profile-picture-uploader" name="profile-picture-uploader">
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
<input type="hidden" name="hf_profile_picture" id="hf_profile_picture" value="{{ $user_details->user_photo_url }}">
<input type="hidden" name="hf_update_vendor_profile" id="hf_update_vendor_profile" value="update_vendor_profile">
@endsection