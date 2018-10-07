<li><a href="{{ route('categories-page', $data['slug']) }}"> {!! $data['name'] !!} </a></li>

@foreach($data['children'] as $data)  
  @include('pages.common.product-children-category-extra', $data)
@endforeach