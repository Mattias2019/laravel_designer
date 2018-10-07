@section('blog-categories-page-content')

<div class="blog-categories-accordian">
  <h2>{{ trans('frontend.category_label') }} <span class="responsive-accordian"></span></h2>
  @if (count($categoriesTree) > 0)
  <div class="panel-group category-accordian" id="accordian">
    @foreach ($categoriesTree as $data)
        @include('pages.common.blog-category-frontend-loop', $data)
    @endforeach
  </div>
  @else
  <h5>{{ trans('frontend.no_categories_yet') }}</h5>
  @endif
</div>

@endsection 