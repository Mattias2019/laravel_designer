@section('vendors-social-media-settings-page-content')
<div id="vendor_social_media_settings">
  <div class="box box-solid">
    <div class="row">
      <div class="col-md-12">
        <div class="box-body">
          <h4>{{ trans('admin.social_media_follow_us_url') }}</h4><hr>  
          <div class="form-group">
              <label class="col-sm-4 control-label" for="inputFbUrl"><i class="fa fa-facebook"></i> {{ trans('admin.fb_title') }}</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="fb_follow_us_url" name="fb_follow_us_url" value="{{ $vendors_settings->social_media->fb_follow_us_url }}" placeholder="{{ trans('admin.url_prefix_label') }}"/>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-4 control-label" for="inputTwitterUrl"><i class="fa fa-twitter"></i> {{ trans('admin.twitter_title') }}</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="twitter_follow_us_url" name="twitter_follow_us_url" value="{{ $vendors_settings->social_media->twitter_follow_us_url }}" placeholder="{{ trans('admin.url_prefix_label') }}"/>
            </div>
          </div>

           <div class="form-group">
            <label class="col-sm-4 control-label" for="inputLinkedinUrl"><i class="fa fa-linkedin"></i> {{ trans('admin.linkedin_title') }}</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="linkedin_follow_us_url" name="linkedin_follow_us_url" value="{{ $vendors_settings->social_media->linkedin_follow_us_url }}" placeholder="{{ trans('admin.url_prefix_label') }}"/>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-4 control-label" for="inputDribbbleUrl"><i class="fa fa-dribbble"></i> {{ trans('admin.dribbble_title') }}</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="dribbble_follow_us_url" name="dribbble_follow_us_url" value="{{ $vendors_settings->social_media->dribbble_follow_us_url }}" placeholder="{{ trans('admin.url_prefix_label') }}"/>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-4 control-label" for="inputGooglePlusUrl"><i class="fa fa-google-plus"></i> {{ trans('admin.google_plus_title') }}</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="google_plus_follow_us_url" name="google_plus_follow_us_url" value="{{ $vendors_settings->social_media->google_plus_follow_us_url }}" placeholder="{{ trans('admin.url_prefix_label') }}"/>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-4 control-label" for="inputInstagramUrl"><i class="fa fa-instagram"></i> {{ trans('admin.instagram_title') }}</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="instagram_follow_us_url" name="instagram_follow_us_url" value="{{ $vendors_settings->social_media->instagram_follow_us_url }}" placeholder="{{ trans('admin.url_prefix_label') }}"/>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-4 control-label" for="inputYoutubeUrl"><i class="fa fa-youtube"></i> {{ trans('admin.youtube_title') }}</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="youtube_follow_us_url" name="youtube_follow_us_url" value="{{ $vendors_settings->social_media->youtube_follow_us_url }}" placeholder="{{ trans('admin.url_prefix_label') }}"/>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div> 
<input type="hidden" name="hf_update_vendor_social_media" id="hf_update_vendor_social_media" value="update_vendor_social_media">
@endsection