@section('embedded-content')
  @if(!empty($single_product_details['_product_video_feature_source_embedded_code']))
    @if($single_product_details['_product_video_feature_display_mode'] == 'popup')
      <div class="embed-responsive embed-responsive-16by9">
        <iframe id="product_youtube_video" class="embed-responsive-item" src=""></iframe>
      </div>
      <input type="hidden" name="product_youtube_video_url" id="product_youtube_video_url" value="{{ $single_product_details['_product_video_feature_source_embedded_code'] }}">
    @else
      <div class="embed-responsive embed-responsive-16by9">
        <iframe id="product_youtube_video" class="embed-responsive-item" src="{{ $single_product_details['_product_video_feature_source_embedded_code'] }}"></iframe>
      </div>
    @endif
  @else
    <p>{!! trans('frontend.product_video_no_content_msg') !!}</p>
  @endif
@endsection