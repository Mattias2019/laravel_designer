@section('vendors-products-page-content')
<style type="text/css">
  #store_details .dropdown-menu{
    height: 220px !important;
    background-color: #F9F9FA !important;
  }
</style>
<div id="vendor_products_content">
  <div class="row">
    <div class="products-list-top clearfix">
      <div class="col-xs-12 col-md-12">
        <div class="product-views pull-left">
          @if($vendor_products['selected_view'] == 'grid')
              <a class="active" href="{{ $vendor_products['action_url_grid_view'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.grid_label') }}"><i class="fa fa-th"></i></a> 
          @else  
              <a href="{{ $vendor_products['action_url_grid_view'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.grid_label') }}"><i class="fa fa-th"></i></a> 
          @endif

          @if($vendor_products['selected_view'] == 'list')
              <a class="active" href="{{ $vendor_products['action_url_list_view'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.list_label') }}"><i class="fa fa-th-list"></i></a>
          @else  
              <a href="{{ $vendor_products['action_url_list_view'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.list_label') }}"><i class="fa fa-th-list"></i></a>
          @endif
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="products-list">
      <br>  
      @include('includes.frontend.vendor-products')
      @yield('vendor-products-content')
    </div>
  </div>      
</div>
@endsection 