<li>
  <a href="{{ route('store-products-cat-page-content', array($data['slug'], $vendor_info->name)) }}">
    <i class="fa fa-angle-right"></i> &nbsp; 
    <?php if(in_array($data['id'], $vendor_products['selected_cat'])){?>
    <span class="active">{!! $data['name'] !!}</span>
    <?php } else {?>
    <span>{!! $data['name'] !!}</span>
    <?php }?>
  </a>
</li>
@foreach($data['children'] as $data)
    @include('pages.common.vendor-category-frontend-loop-extra', $data)
@endforeach