@if(count($data['children'])>0)
<div class="panel panel-default">
  <div class="panel-heading">
    <h4 class="panel-title">
      <a data-toggle="collapse" data-parent="#accordian" href="#{{ str_replace(' ', '-', $data['slug']) }}">
        <span class="pull-right">
          <?php if( (in_array($data['id'], $vendor_products['selected_cat'])) || ($data['id'] == $vendor_products['parent_id'])){?>
          <i class="fa fa-minus"></i>
          <?php } else {?>
          <i class="fa fa-plus"></i>
          <?php }?>
        </span>
        <i class="fa fa-angle-double-right"></i> &nbsp; 
        <?php if(in_array($data['id'], $vendor_products['selected_cat'])){?>
        <span class="active">{!! $data['name'] !!}</span>
         <?php } else {?>
        <span>{!! $data['name'] !!}</span>
         <?php }?>
      </a>
    </h4>
  </div>
  
 <?php if( (in_array($data['id'], $vendor_products['selected_cat'])) || ($data['id'] == $vendor_products['parent_id'])){?>
  <div id="{{ str_replace(' ', '-', $data['slug']) }}" class="panel-collapse in">
  <?php } else {?>
  <div id="{{ str_replace(' ', '-', $data['slug']) }}" class="panel-collapse collapse">
  <?php }?>
    <div class="panel-body">
        @if(count($data['children'])>0)
        <ul>
          @foreach($data['children'] as $data)
            @include('pages.common.vendor-category-frontend-loop-extra', $data)
          @endforeach
        </ul>  
        @endif
    </div>
  </div>
</div>  
@else
<div class="panel panel-default">
  <div class="panel-heading">
    <h4 class="panel-title">
      <a href="{{ route('store-products-cat-page-content', array($data['slug'], $vendor_info->name)) }}">
        <i class="fa fa-angle-double-right"></i> &nbsp; 
        <?php if(in_array($data['id'], $vendor_products['selected_cat'])){?>
        <span class="active">{!! $data['name'] !!}</span>
        <?php } else {?>
        <span>{!! $data['name'] !!}</span>
        <?php }?>
      </a>
    </h4>
  </div>
</div>
@endif
