@section('color-filter-content')
<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
  <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
		
		<div class="box box-info">
      <div class="box-header">
        <h3 class="box-title">{!! trans('admin.more_add_filter_color_label') !!}</h3>
        <div class="box-tools pull-right">
          <button class="btn btn-primary pull-right" type="submit">{!! trans('admin.save') !!}</button>
        </div>
      </div>
    </div>
		
		<div class="box box-solid">
      <div class="row">
        <div class="col-md-12">
          <div class="box-body">
            <div class="add-filter-colors-main clearfix">
                <button id="add_filter_colors" class="btn btn-primary pull-right" type="button"><i class="fa fa-plus"></i> {!! trans('admin.add_new_filter_color_label') !!}</button>
            </div> <br>
            <div class="add-filter-colors-content">
              @if(!empty($filter_colors_name) && count($filter_colors_name) > 0)
                @foreach($filter_colors_name as $val)
                <div id="{{ $val->key }}}" class="product-filter-color-title clearfix"><div class="col-md-5"><input placeholder="{{ trans('admin.color_filter_color_name_placeholder') }}" name="product_filter_color_name[<?php echo $val->key;?>]" class="form-control" type="text" value="{{ $val->color_name }}"></div><div class="col-md-5"><input name="product_filter_color[<?php echo $val->key;?>]" class="form-control color" type="text" value="{{ $val->color_code }}"></div><div class="col-md-2"><button id="remove_product_filter_color_field" class="btn btn-default remove-product-filter-color-field" type="button"><i class="fa fa-remove"></i> {!! trans('admin.remove_label') !!}</button></div></div>
                @endforeach
              @endif  
            </div>		
          </div>
        </div>
      </div>
		</div>		
</form>		
@endsection