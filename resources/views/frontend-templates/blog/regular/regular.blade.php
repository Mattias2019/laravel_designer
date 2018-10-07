<div class="blog-content-main">
  <div class="row">
    <div class="col-md-3">
      @include('includes.frontend.blog-categories')
      @yield('blog-categories-content')
      
      @if(count($advanced_data['best_items']) > 0)  
      <div class="best-blog">
        <div class="content-title">
          <h2 class="text-center title-under">{!! trans('frontend.best_from_the_blog_title') !!}</h2>
        </div>
        <div class="best-blog-content">
          <div class="row">
            @foreach($advanced_data['best_items'] as $items)
              <div class="col-md-12 blog-box extra-padding">
                <a href="{{ route('blog-single-page', $items['post_slug'])}}">
                  @if(!empty($items['blog_image']))  
                    <img class="img-responsive" src="{{ get_image_url($items['blog_image']) }}"  alt="{{ basename($items['blog_image']) }}">          
                  @else
                    <img class="img-responsive" src="{{ default_placeholder_img_src() }}"  alt="">         
                  @endif
                  <div class="blog-bottom-text">
                    <p class="blog-title">{!! $items['post_title'] !!}</p>
                    <p><span class="blog-date"><i class="fa fa-calendar"></i>&nbsp; {{ Carbon\Carbon::parse($items['created_at'])->format('d F, Y') }}</span>&nbsp;&nbsp;<span class="blog-comments"> <i class="fa fa-comment"></i>&nbsp; {!! $items['comments_details']['total'] !!} {!! trans('frontend.comments_label') !!}</span></p>
                  </div>
                </a>
              </div>
            @endforeach
          </div>
        </div>
      </div>
      @endif
    </div>
    <div class="col-md-9">
      @foreach($blogs_all_data as $row)
      <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 extra-padding">
        <div class="blog-content-elements-main">
          <div class="blog-media">
            @if(!empty($row['featured_image']))
              <img class="img-responsive" src="{{ get_image_url($row['featured_image']) }}" alt="{{ basename($row['featured_image']) }}">
            @else
              <img class="img-responsive" src="{{ default_placeholder_img_src() }}" alt="media">
            @endif
          </div>
          <div class="blog-text">
            <p>
              <span class="blog-date"><i class="fa fa-calendar"></i>&nbsp;{{ Carbon\Carbon::parse($row['created_at'])->format('d F, Y') }}</span> &nbsp;&nbsp;
              <span class="blog-comments"> <i class="fa fa-comment"></i>&nbsp; {!! $row['comments_details']['total'] !!} {!! trans('frontend.comments_label') !!}</span>
            </p>
            <p class="blog-title">{!! $row['post_title'] !!}</p>
            <p class="blog-description">
              {!! get_limit_string(string_decode($row['post_content']), $row['allow_max_number_characters_at_frontend']) !!}
            </p>
            <br>
            <div class="btn-content"><a class="btn btn-block btn-default" href="{{ route('blog-single-page', $row['post_slug']) }}">{!! trans('frontend.read_more_label') !!}</a></div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</div> 