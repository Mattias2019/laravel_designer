<li>
  <a href="{{ route('blog-cat-page', $data['slug']) }}">
    <i class="fa fa-angle-right"></i> &nbsp; 
    <?php if(in_array($data['id'], $blogs_cat_post['selected_cat'])){?>
    <span class="active">{!! $data['name'] !!}</span>
    <?php }else {?>
    <span>{!! $data['name'] !!}</span>
    <?php }?>
  </a>
</li>
@foreach($data['children'] as $data)
    @include('pages.common.blog-category-frontend-loop-extra', $data)
@endforeach