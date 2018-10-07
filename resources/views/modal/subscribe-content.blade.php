<div class="svgs" style="display: none;">
  <svg xmlns="http://www.w3.org/2000/svg">
    <symbol id="icon-close" viewBox="0 0 16.196 16.197">
      <title>Close</title>
      <path d="M15.615,3.07c0.619-0.62,0.77-1.618,0.258-2.329c-0.652-0.906-1.924-0.981-2.679-0.226L8.627,5.084 c-0.292,0.292-0.765,0.292-1.057,0L3.069,0.582c-0.62-0.62-1.617-0.771-2.328-0.258C-0.165,0.976-0.24,2.248,0.516,3.003 l4.567,4.569c0.292,0.292,0.292,0.765,0,1.057l-4.501,4.503c-0.619,0.619-0.771,1.617-0.259,2.328 c0.652,0.902,1.924,0.976,2.679,0.226l4.568-4.569c0.291-0.291,0.765-0.291,1.057,0l4.501,4.503 c0.619,0.626,1.616,0.772,2.327,0.259c0.906-0.652,0.981-1.924,0.227-2.68l-4.568-4.569c-0.291-.292-0.291-0.765,0-1.057 L15.615,3.07z"></path>
    </symbol>
  </svg>
</div>

<div class="shopist-modal" id="subscriptions_modal" style="width:100px;">
  <div class="modal__window">
    <button class="modal__close-btn" type="button" data-close-modal>
      <svg class="modal__close-icon">
        <use xlink:href="#icon-close"></use>
      </svg>
    </button>
      
    <div class="modal__content">
      <div class="subscribe-content">{!! string_decode($subscriptions_data['popup_content']) !!}</div>
      <div class="subscribe-options">
        @if($subscriptions_data['subscribe_options'] == 'email')
          <input type="text" id="subscribe_options_email"  placeholder="{{ trans('frontend.enter_email_label') }}" />
        @endif
        
        @if($subscriptions_data['subscribe_options'] == 'name_email')
          <input type="text" id="subscribe_options_name"  placeholder="{{ trans('frontend.enter_name_label') }}" />
          <input type="text" id="subscribe_options_email"  placeholder="{{ trans('frontend.enter_email_label') }}" />
        @endif
        
        <button type="button" id="subscribtion_submit">{!! $subscriptions_data['subscribe_btn_text'] !!}</button>
      </div>
      
      @if($subscriptions_data['subscribe_popup_cookie_set_visibility'] == true)
        <div class="popup-cookie-set">
          <a href="#" class="set-popup-cookie">{!! $subscriptions_data['subscribe_popup_cookie_set_text'] !!}</a>
        </div>
      @endif
    </div>
  </div>
</div>