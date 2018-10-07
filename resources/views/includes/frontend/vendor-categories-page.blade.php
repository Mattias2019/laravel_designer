@section('vendor-categories-page-content')

<div class="product-categories-accordian">
  <h2><span>{{ trans('frontend.category_label') }}</span></h2>
  @if (count($productCategoriesTree) > 0)
  <div class="panel-group category-accordian" id="accordian">
    @foreach ($productCategoriesTree as $data)
						@if(in_array($data['id'], $vendor_selected_cats_id))
								@include('pages.common.vendor-category-frontend-loop', $data)
						@endif
    @endforeach
  </div>
  @else
  <h5>{{ trans('frontend.no_categories_yet') }}</h5>
  @endif
</div>

@endsection 