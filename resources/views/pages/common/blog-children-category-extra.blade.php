<li><a href="{{ route('blog-cat-page', $data['slug']) }}"> {!! $data['name'] !!} </a></li>

@foreach($data['children'] as $data)  
  @include('pages.common.blog-children-category-extra', $data)
@endforeach