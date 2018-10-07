@extends('layouts.admin.master')
@section('title', trans('admin.compare_products_page_title') .' < '. get_site_title())

@section('content')
<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
  <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
		
		<div class="box box-info">
    <div class="box-header">
      <h3 class="box-title">{!! trans('admin.more_features_add_compare_fields_label') !!}</h3>
      <div class="box-tools pull-right">
        <button class="btn btn-primary pull-right" type="submit">{!! trans('admin.save') !!}</button>
      </div>
    </div>
  </div>
		
		<div class="box box-solid">
				<div class="row">
						<div class="col-md-12">
								<div class="box-body">
										<div class="add-compare-fields-main clearfix">
												<button id="add_compare_fields" class="btn btn-primary pull-right" type="button"><i class="fa fa-plus"></i> {!! trans('admin.more_features_add_compare_more_fields_label') !!}</button>
										</div> <br>
										<div class="add-compare-fields-content">
                      @if(!empty($fields_name))
                        @foreach($fields_name as $key => $val)
                        <div id="{{ $key }}" class="product-compare-field-title clearfix"><div class="col-md-10"><input placeholder="{{ trans('admin.more_compare_field_placeholder') }}" name="product_compare_field_title[<?php echo $key;?>]" class="form-control" type="text" value="{{ $val }}"></div><div class="col-md-2"><button id="remove_product_compare_fields" class="btn btn-default remove-product-compare-fields" type="button"><i class="fa fa-remove"></i> {!! trans('admin.remove_label') !!}</button></div></div>
                        @endforeach
                      @endif
										</div>		
								</div>
						</div>
				</div>
		</div>		
</form>		
@endsection