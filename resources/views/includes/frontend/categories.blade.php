@section('categories-content')

<div class="product-categories-accordian">
  <h2>{{ trans('frontend.category_label') }} <span class="responsive-accordian"></span></h2>
  
  @if (count($productCategoriesTree) > 0)
  <div class="category">
    <ul class="products-categories list-unstyled">
      @foreach ($productCategoriesTree as $data)
        <li class="product-parent-categories">
          @if(count($data['children'])>0)
          <?php $img = $data['img_url'];?>
          <div class="dropdown">
            <a class="btn btn-default dropdown-toggle hidden-xs" id="dropdownMenu2" href="{{ route('categories-page', $data['slug']) }}"> {!! $data['name'] !!} <span class="caret pull-right"></span></a>
            <button class="btn btn-default dropdown-toggle hidden-sm hidden-md hidden-lg" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{!! $data['name'] !!}<span class="caret pull-right"></span></button>
            
            <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
              <div class="cat-list-area col-sm-9">
                @foreach($data['children'] as $data)
                  @include('pages.common.product-children-category', $data)
                @endforeach
              </div> 
              <div class="product-cat-img-area col-sm-3">
                @if(!empty($img))
                <img class="img-responsive" src="{{ get_image_url($img) }}" alt="cat-img">
                @else
                <img class="img-responsive" src="{{ default_placeholder_img_src() }}" alt="cat-img">
                @endif
              </div>
              <div class="clearfix"></div>  
            </div>
          </div>
          @else
          <a href="{{ route('categories-page', $data['slug']) }}"> {!! $data['name'] !!} </a>
          @endif
        </li>
      @endforeach
    </ul>  
  </div>    
  @else
  <h5>{{ trans('frontend.no_categories_yet') }}</h5>
  @endif
</div>

@endsection 