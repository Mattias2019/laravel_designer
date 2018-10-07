@section('brands-content')
<hr>
<div class="brands_products">
  <h2>{{ trans('frontend.brands') }}</h2>
  @if(count($brands_data)>0)
  <div class="brands-name">
    <ul class="nav nav-pills nav-stacked">
      @foreach($brands_data as $row)
        @if(count($row['brands_details'])>0)
          <li>
            <a href="">
              <span>
                @if($row['brands_details']['logo_url'])
                  <img class="img-responsive" src="{{ get_image_url($row['brands_details']['logo_url']) }}" alt="">
                @else
                  <img class="img-responsive" src="{{ default_placeholder_img_src() }}" alt="">
                @endif
              </span>
              <span class="brands-label">{!! $row['brands_details']['name'] !!} &nbsp;&nbsp;( {!! count($row['products_details']) !!} )</span>
            </a>
          </li>
        @endif
      @endforeach
    </ul>
  </div>
  @else
    <h5>{{ trans('frontend.no_brands_yet') }}</h5>
  @endif
</div>
@endsection