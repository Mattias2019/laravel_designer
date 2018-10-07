<li>
  <a href="{{ route('categories-page', $data['slug']) }}">
    <i class="fa fa-angle-right"></i> &nbsp; 
    <?php if(in_array($data['id'], $product_by_cat_id['selected_cat'])){?>
    <span class="active">{!! $data['name'] !!}</span>
    <?php } else {?>
    <span>{!! $data['name'] !!}</span>
    <?php }?>
  </a>
</li>
@foreach($data['children'] as $data)
    @include('pages.common.category-frontend-loop-extra', $data)
@endforeach