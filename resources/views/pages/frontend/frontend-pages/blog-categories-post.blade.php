@extends('layouts.frontend.master')
@section('title',  trans('frontend.cat_post_label') .' < '. get_site_title() )

@section('content')
<br>
<div class="container new-container">
  <div id="blog-cat-content-main">  
  <?php if(isset($blogs_cat_post['breadcrumb_html'])){?>
  <div id="blog-category-breadcrumb">
    {!! $blogs_cat_post['breadcrumb_html'] !!}
  </div>
  <?php }?>

    <div class="row">
      <div class="col-md-9">
        @if(count($blogs_cat_post['posts']) > 0)  
          @foreach($blogs_cat_post['posts'] as $row)
          <?php $total = get_comments_rating_details($row->id, 'blog');?>
          <div class="blog-content-elements-main">
            <div class="row">
              <div class="col-md-6">
                <div class="blog-media">
                  @if(get_blog_postmeta_data($row->id, 'featured_image'))
                  <img class="img-responsive" src="{{ get_image_url(get_blog_postmeta_data($row->id, 'featured_image')) }}" alt="{{ basename(get_blog_postmeta_data($row->id, 'featured_image')) }}">
                  @else
                  <img class="img-responsive" src="{{ default_placeholder_img_src() }}"  alt=""> 
                  @endif
                </div>
              </div>

              <div class="col-md-6">
                <div class="blog-text">
                  <p>
                    <span class="blog-date"><i class="fa fa-calendar"></i>&nbsp;{{ Carbon\Carbon::parse($row->created_at)->format('d F, Y') }}</span> &nbsp;&nbsp;
                    <span class="blog-comments"> <i class="fa fa-comment"></i>&nbsp; {!! $total['total'] !!} {!! trans('frontend.comments_label') !!}</span>
                  </p>
                  <p class="blog-title">{!! $row->post_title !!}</p>
                  <p class="blog-description">
                    {!! get_limit_string(string_decode($row->post_content), get_blog_postmeta_data($row->id, 'allow_max_number_characters_at_frontend')) !!}
                  </p>
                  <div class="btn-read-more"><a class="btn btn-block btn-default" href="{{ route('blog-single-page', $row->post_slug)}}">{!! trans('frontend.read_more_label') !!}</a></div>
                </div>
              </div>
            </div>
          </div>
          @endforeach
        @else
          <p>{!! trans('frontend.no_post_blog_cat_yet_label') !!}</p>
        @endif
      </div>

      <div class="col-md-3">
        @include('includes.frontend.blog-categories-page')
        @yield('blog-categories-page-content')
        <div class="best-blog">
          <div class="content-title">
            <h2 class="text-center title-under">{!! trans('frontend.best_from_the_blog_title') !!}</h2>
          </div>
          <div class="best-blog-content">
            <div class="row">
              @if(count($advanced_data['best_items']) > 0)  
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
              @else
              <p>{!! trans('frontend.no_blogs_data_label') !!}</p>
              @endif
            </div>
          </div>
        </div>
      </div>
      <div class="products-pagination">{!! $blogs_cat_post['posts']->appends(Request::capture()->except('page'))->render() !!}</div>  
    </div>
  </div>  
</div>    
@endsection