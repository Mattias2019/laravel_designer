@extends('layouts.frontend.master')
@section('title', trans('frontend.testimonials_details_page_title') .' < '. get_site_title() )

@section('content')
<div id="testimonial_details" class="container new-container">
  <div class="row">
    <div class="col-md-12">
      <div class="testimonials-list testimonials-design">
        <div class="quote first last ">
          <div class="testimonial-left">
            <div class="avatar-image">
              @if(!empty($testimonials_data_by_slug['testimonial_image_url']))
              <img src="{{ get_image_url($testimonials_data_by_slug['testimonial_image_url']) }}" class="circle" alt="" width="61" height="80">
              @else
              <img src="{{ default_placeholder_img_src() }}" class="circle" alt="" width="61" height="80">
              @endif
            </div>
          </div>
          <div class="testimonial-content">
            <i class="fa fa-quote-left"></i>
            @if(!empty($testimonials_data_by_slug['post_title']))
            <h4>{!! $testimonials_data_by_slug['post_title'] !!}</h4>
            @endif
            
            <div class="testimonials-text">
            @if(!empty($testimonials_data_by_slug['post_content']))   
            <div class="testimonials-desc">{!! string_decode($testimonials_data_by_slug['post_content']) !!}</div>
            @endif
            </div>
          </div>
          @if(!empty($testimonials_data_by_slug['testimonial_client_name']))  
          <div class="testimonial-author"><strong>{!! $testimonials_data_by_slug['testimonial_client_name'] !!}</strong></div>
          @endif
          
          @if(!empty($testimonials_data_by_slug['testimonial_job_title']) && !empty($testimonials_data_by_slug['testimonial_company_name']) )
          <div class="testimonial-job">{!! $testimonials_data_by_slug['testimonial_job_title'] !!} / <a href="//{{ $testimonials_data_by_slug['testimonial_url'] }}" target="_blank">{!! $testimonials_data_by_slug['testimonial_company_name'] !!}</a></div>
          @endif
        </div> 
      </div>
    </div>
    
    @if(count($testimonials_data) > 0)
    <div class="col-md-12">
      <div class="testimonials-slider">
        <div class="content-title">
          <h2 class="text-center title-under">{!! trans('frontend.testimonials_more_title') !!}</h2>
        </div>

        <div id="slider-carousel-testimonials" class="carousel slide" data-ride="carousel">
          <?php $numb = 1; ?>
          <div class="carousel-inner">
          @foreach($testimonials_data as $row)
            @if($numb == 1)
              <div class="item active">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="col-xs-12 col-sm-2 col-sm-offset-3">
                      <div class="testimonials-img text-right">
                        @if($row['testimonial_image_url'])
                        <img src="{{ get_image_url($row['testimonial_image_url']) }}" alt="" width="170" height="169">
                        @else
                        <img src="{{ default_placeholder_img_src() }}" alt="" width="170" height="169">
                        @endif
                      </div>
                    </div>
                    <div class="col-xs-12 col-sm-5">
                      <div class="testimonials-text">
                        <h2>{!! $row['post_title'] !!}</h2>
                        <p>{!! get_limit_string(string_decode($row['post_content']), 200) !!}</p>
                        <a href="{{ route('testimonial-single-page', $row['post_slug'])}}" class="btn btn-sm testimonials-read">{!! trans('frontend.read_more_label') !!}</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            @else
              <div class="item">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="col-xs-12 col-sm-2 col-sm-offset-3">
                      <div class="testimonials-img text-right">
                        @if($row['testimonial_image_url'])
                        <img src="{{ get_image_url($row['testimonial_image_url']) }}" alt="" width="170" height="169">
                        @else
                        <img src="{{ default_placeholder_img_src() }}" alt="" width="170" height="169">
                        @endif
                      </div>
                    </div>
                    <div class="col-xs-12 col-sm-5">
                      <div class="testimonials-text">
                        <h2>{!! $row['post_title'] !!}</h2>
                        <p>{!! get_limit_string(string_decode($row['post_content']), 200) !!}</p>
                        <a href="{{ route('testimonial-single-page', $row['post_slug'])}}" class="btn btn-sm testimonials-read">{!! trans('frontend.read_more_label') !!}</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            @endif
            <?php $numb++ ; ?>
          @endforeach
          </div>
          
          @if(count($testimonials_data) > 1)
          <div class="slider-control-main text-center">
            <div class="prev-btn">
              <a href="#slider-carousel-testimonials" class="control-carousel" data-slide="prev">
                <i class="fa fa-angle-left"></i>
              </a>
            </div>

            <div class="next-btn">
              <a href="#slider-carousel-testimonials" class="control-carousel" data-slide="next">
                <i class="fa fa-angle-right"></i>
              </a>
            </div>
          </div>
          @endif
        </div>
      </div>
    </div>
    @endif
  </div>
</div>
@endsection  