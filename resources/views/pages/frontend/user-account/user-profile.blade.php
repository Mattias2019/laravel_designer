<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
  <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
  <div class="row">
    <div class="col-md-12">
      
      <h4><label>{{ trans('frontend.update_profile') }}</label></h4><hr>

      @include('pages-message.notify-msg-success')
      @include('pages-message.form-submit')
      @include('pages-message.notify-msg-error')
      
      <div class="form-group">
        <div class="col-sm-4">
          <label class="control-label" for="inputDisplayName">{{ ucfirst( trans('admin.display_name') ) }}</label>
        </div>
        <div class="col-sm-8">
          <input type="text" placeholder="{{ trans('admin.display_name') }}" class="form-control" value="{{ $user_details['user_display_name'] }}" id="display_name" name="display_name">
        </div>
      </div>

      <div class="form-group">
        <div class="col-sm-4">
          <label class="control-label" for="inputUserName">{{ trans('admin.user_name') }}</label>
        </div>
        <div class="col-sm-8">
          <input type="text" placeholder="{{ trans('admin.user_name') }}" class="form-control" value="{{ $user_details['user_name'] }}" id="user_name" name="user_name">
        </div>
      </div> 

      <div class="form-group">
        <div class="col-sm-4">
          <label class="control-label" for="inputEmail">{{ trans('admin.email') }}</label>
        </div>
        <div class="col-sm-8">
          <input type="text" placeholder="{{ trans('admin.email') }}" class="form-control" value="{{ $user_details['user_email'] }}" id="email_id" name="email_id">
        </div>
      </div> 
      
      <div class="form-group">
        <div class="col-sm-4">
          <label class="control-label" for="inputNewPassword">{{ trans('admin.new_password') }}</label>
        </div>
        <div class="col-sm-8">
           <input type="password" placeholder="{{ trans('admin.new_password') }}" class="form-control" value="" id="password" name="password">
        </div>
      </div>
      
      <div class="form-group">
        <div class="col-sm-4">
          <label class="control-label" for="inputProfilePicture">{{ trans('admin.profile_picture') }}</label>
        </div>
        <div class="col-sm-8 profile-picture-content">
           @if($user_details['user_photo_url'])
            <div class="profile-picture">
              <div class="img-div"><img src="{{ get_image_url($user_details['user_photo_url']) }}" class="user-image" alt=""/></div><br>
              <div class="btn-div"><button type="button" class="btn btn-default btn-sm remove-frontend-profile-picture">{{ trans('admin.remove_image') }}</button></div>
            </div>
            <div class="no-profile-picture" style="display:none;">
              <div class="img-div"><img src="{{ default_avatar_img_src() }}" class="user-image" alt=""/></div><br>
              <div class="btn-div"><button data-toggle="modal" data-target="#frontendUserUploadProfilePicture" type="button" class="btn btn-default btn-sm profile-picture-uploader">{{ trans('admin.upload_image') }}</button></div>
            </div>
           @else
           <div class="profile-picture" style="display:none;">
              <div class="img-div"><img src="" class="user-image" alt=""/></div><br>
              <div class="btn-div"><button type="button" class="btn btn-default btn-sm remove-frontend-profile-picture">{{ trans('admin.remove_image') }}</button></div>
            </div>
           <div class="no-profile-picture">
              <div class="img-div"><img src="{{ default_avatar_img_src() }}" class="user-image" alt=""/></div><br>
              <div class="btn-div"><button data-toggle="modal" data-target="#frontendUserUploadProfilePicture" type="button" class="btn btn-default btn-sm profile-picture-uploader">{{ trans('admin.upload_image') }}</button></div>
           </div>
           @endif
        </div>
      </div>  

      <div class="modal fade" id="frontendUserUploadProfilePicture" tabindex="-1" role="dialog" aria-labelledby="updater" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">✕</button>
              <br>
              <i class="icon-credit-card icon-7x"></i>
              <p class="no-margin">{{ trans('admin.you_can_upload_1_image') }}</p>
            </div>
            <div class="modal-body">             
              <div class="uploadform dropzone no-margin dz-clickable frontend-user-profile-picture-uploader" id="frontend_user_profile_picture_uploader" name="frontend_user_profile_picture_uploader">
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
      <input type="hidden" name="hf_frontend_profile_picture" id="hf_frontend_profile_picture" value="">

    </div>
  </div>
  
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
      <div class="text-right">
          <button type="submit" class="btn btn-primary btn-sm">{{ trans('frontend.update_profile') }}</button>
      </div>
    </div>
  </div>
</form>