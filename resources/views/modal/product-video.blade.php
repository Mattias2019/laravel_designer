<div class="svgs" style="display: none;">
  <svg xmlns="http://www.w3.org/2000/svg">
    <symbol id="icon-close" viewBox="0 0 16.196 16.197">
      <title>Close</title>
      <path d="M15.615,3.07c0.619-0.62,0.77-1.618,0.258-2.329c-0.652-0.906-1.924-0.981-2.679-0.226L8.627,5.084 c-0.292,0.292-0.765,0.292-1.057,0L3.069,0.582c-0.62-0.62-1.617-0.771-2.328-0.258C-0.165,0.976-0.24,2.248,0.516,3.003 l4.567,4.569c0.292,0.292,0.292,0.765,0,1.057l-4.501,4.503c-0.619,0.619-0.771,1.617-0.259,2.328 c0.652,0.902,1.924,0.976,2.679,0.226l4.568-4.569c0.291-0.291,0.765-0.291,1.057,0l4.501,4.503 c0.619,0.626,1.616,0.772,2.327,0.259c0.906-0.652,0.981-1.924,0.227-2.68l-4.568-4.569c-0.291-.292-0.291-0.765,0-1.057 L15.615,3.07z"></path>
    </symbol>
  </svg>
</div>

<div class="shopist-modal" id="product_video_modal" style="width:100px;">
  <div class="modal__window">
    <button class="modal__close-btn" type="button" data-close-modal>
      <svg class="modal__close-icon">
        <use xlink:href="#icon-close"></use>
      </svg>
    </button>
    
    @if(!empty($single_product_details['_product_video_feature_title']))  
    <div class="modal__header">
      <h2 class="modal__title">{!! $single_product_details['_product_video_feature_title'] !!}</h2>
    </div>  
    @endif
      
    <div class="modal__content">
      @if(!empty($single_product_details['_product_video_feature_source']))  
        @if($single_product_details['_product_video_feature_source'] == 'embedded_code')
          @include('pages.frontend.frontend-pages.video-source-embedded-url')
          @yield('embedded-content')
        @elseif($single_product_details['_product_video_feature_source'] == 'online_url')
          @include('pages.frontend.frontend-pages.video-source-online-url')
          @yield('online-url-content')
        @endif
      @else
      <p>{!! trans('frontend.product_video_no_content_msg') !!}</p>
      @endif  
    </div>
  </div>
</div>