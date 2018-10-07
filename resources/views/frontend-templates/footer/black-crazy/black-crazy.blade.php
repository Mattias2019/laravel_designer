<div class="footer-top full-width">
  <div class="footer-top-background">
    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-4">
          <h3 class="widget-title">{!! trans('frontend.footer_about_us') !!}</h3>
          <div class="is-divider small"></div>
          <p>{!! $appearance_all_data['footer_details']['footer_about_us_description'] !!}</p>
         
          <h3 class="widget-title">{!! trans('frontend.footer_follow_us') !!}</h3>
          <div class="is-divider small"></div>
          <ul class="social-media">
            <li><a class="facebook" href="//{{ $appearance_all_data['footer_details']['follow_us_url']['fb'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.fb_tooltip_msg') }}"><i class="fa fa-facebook"></i></a></li>
            <li><a class="twitter" href="//{{ $appearance_all_data['footer_details']['follow_us_url']['twitter'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.twitter_tooltip_msg') }}"><i class="fa fa-twitter"></i></a></li>
            <li><a class="linkedin" href="//{{ $appearance_all_data['footer_details']['follow_us_url']['linkedin'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.linkedin_tooltip_msg') }}"><i class="fa fa-linkedin"></i></a></li>
            <li><a class="dribbble" href="//{{ $appearance_all_data['footer_details']['follow_us_url']['dribbble'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.dribbble_tooltip_msg') }}"><i class="fa fa-dribbble"></i></a></li>
            <li><a class="google-plus" href="//{{ $appearance_all_data['footer_details']['follow_us_url']['google_plus'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.google_plus_tooltip_msg') }}"><i class="fa fa-google-plus"></i></a></li>
            <li><a class="instagram" href="//{{ $appearance_all_data['footer_details']['follow_us_url']['instagram'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.instagram_tooltip_msg') }}"><i class="fa fa-instagram"></i></a></li>
            <li><a class="youtube-play" href="//{{ $appearance_all_data['footer_details']['follow_us_url']['youtube'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.youtube_play_tooltip_msg') }}"><i class="fa fa-youtube-play"></i></a></li>
          </ul>
        </div>
        
        <div class="col-xs-12 col-sm-12 col-md-4">
          <h3 class="widget-title">{!! trans('frontend.latest_news_label') !!}</h3>
          <div class="is-divider small"></div>
          <div class="latest-footer-blogs">
            @if(count($blogs_data) > 0)
            <ul>
              @foreach($blogs_data as $rows)
              <li>
                <div class="footer-latest-blog-row">
                  <div class="footer-blogs-widget-title footer-blogs-left-boxs"><span>{{ Carbon\Carbon::parse($rows['created_at'])->format('d') }}</span><br><span>{{ Carbon\Carbon::parse($rows['created_at'])->format('M') }}</span></div>
                  <div class="footer-blogs-widget-title footer-blogs-right-text"><a href="{{ route('blog-single-page', $rows['post_slug']) }}">{{ $rows['post_title'] }}</a> <br><span><a href="{{ route('blog-single-page', $rows['post_slug']) }}"><strong>{!! $rows['comments_details']['total'] !!}</strong>&nbsp;{!! trans('frontend.comments_label') !!}</a></span></div>
                </div>
              </li>
              @endforeach
            </ul>
            @else
            <p class="not-available">{!! trans('frontend.no_latest_news_label') !!}</p>
            @endif
          </div>
        </div>
        
        <div class="col-xs-12 col-sm-12 col-md-4">
          <h3 class="widget-title">{!! trans('frontend.footer_tags_label') !!}</h3>
          <div class="is-divider small"></div>
          <div class="footer-tags-list">
            @if(count($popular_tags_list) > 0)
              @foreach($popular_tags_list as $tags)
                <a href="{{ route('tag-single-page', $tags['slug'])}}">{!! $tags['name'] !!}</a>
              @endforeach
            @else
            <p class="not-available">{!! trans('frontend.footer_no_tags_label') !!}</p>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="footer-copyright full-width">
  <div class="footer-copyright-background">
    <div class="container">
      <div class="row">
        <div class="col-md-12 footer-text">
          <div class="text-center">{!! trans('frontend.footer_msg', ['title' => get_site_title()]) !!}</div>
          <div class="text-center">{!! trans('frontend.footer_powered_by') !!} <strong>{!! get_site_title() !!}</strong></div>
        </div>
      </div>
    </div>
  </div>  
</div>