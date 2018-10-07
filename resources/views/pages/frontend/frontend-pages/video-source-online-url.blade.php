@section('online-url-content')
  @if(!empty($single_product_details['_product_video_feature_source_online_url']))
    @if($single_product_details['_product_video_feature_display_mode'] == 'popup')
      <div class="embed-responsive embed-responsive-16by9">
        <video id="product_video" controls class="embed-responsive-item"></video>
      </div> 
      <input type="hidden" name="product_video_url" id="product_video_url" value="{{ $single_product_details['_product_video_feature_source_online_url'] }}">

      @if(get_extension($single_product_details['_product_video_feature_source_online_url']) == 'mp4')
        <input type="hidden" name="product_video_extension" id="product_video_extension" value="mp4">
      @elseif(get_extension($single_product_details['_product_video_feature_source_online_url']) == 'ogv')  
        <input type="hidden" name="product_video_extension" id="product_video_extension" value="ogv">
      @endif 
    @else
      <div class="embed-responsive embed-responsive-16by9">
        <video id="product_video" controls class="embed-responsive-item">
          @if(get_extension($single_product_details['_product_video_feature_source_online_url']) == 'mp4')
            <source src="{{ $single_product_details['_product_video_feature_source_online_url'] }}" type="video/mp4"></source>
          @elseif(get_extension($single_product_details['_product_video_feature_source_online_url']) == 'ogv')           
             <source src="{{ $single_product_details['_product_video_feature_source_online_url'] }}" type="video/ogg"></source>
          @endif 
        </video>
      </div>
    @endif
  @else
    <p>{!! trans('frontend.product_video_no_content_msg') !!}</p>
  @endif
@endsection 