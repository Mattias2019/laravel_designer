<div class="col-sm-4">
  <div class="sub-cat">
    @if(count($data['children'])>0)
    <h3><a href="{{ route('blog-cat-page', $data['slug']) }}"> {!! $data['name'] !!} <span class="pull-right"><i class="fa fa-chevron-right"></i></span></a></h3>
    <ul class="list-unstyled child-cat-list">
      @foreach($data['children'] as $data)  
        @include('pages.common.blog-children-category-extra', $data)
      @endforeach
    </ul>
    @else
    <h3><a href="{{ route('blog-cat-page', $data['slug']) }}"> {!! $data['name'] !!} </a></h3>
    @endif
  </div>
</div>