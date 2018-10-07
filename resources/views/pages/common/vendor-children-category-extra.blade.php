<li><a href="{{ route('store-products-cat-page-content', array($data['slug'], $user_name)) }}"> {!! $data['name'] !!} </a></li>

@foreach($data['children'] as $data)  
  @include('pages.common.product-children-category-extra', $data)
@endforeach