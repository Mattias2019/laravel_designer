@section('categories-page-content')

<div class="product-categories-accordian">
  <h2>{{ trans('frontend.category_label') }} <span class="responsive-accordian"></span></h2>
  @if (count($productCategoriesTree) > 0)
  <div class="panel-group category-accordian" id="accordian">
    @foreach ($productCategoriesTree as $data)
        @include('pages.common.category-frontend-loop', $data)
    @endforeach
  </div>
  @else
  <h5>{{ trans('frontend.no_categories_yet') }}</h5>
  @endif
</div>

@endsection 