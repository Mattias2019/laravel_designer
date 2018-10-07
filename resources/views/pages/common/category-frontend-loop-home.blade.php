@if(isset($cat_sub['children']) && count($cat_sub['children']) > 0)
  @foreach($cat_sub['children'] as $cat_sub)
    <li class="product-sub-cat"><a href="{{ route('categories-page', $cat_sub['slug']) }}">{!! $cat_sub['name'] !!}</a></li>
    @if(isset($cat_sub['children']) && count($cat_sub['children']) > 0)
      @include('pages.common.category-frontend-loop-home', $cat_sub)
    @endif
  @endforeach
@endif