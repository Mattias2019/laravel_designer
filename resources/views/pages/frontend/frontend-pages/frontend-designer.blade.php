@extends('layouts.frontend.master')
@section('title',  trans('frontend.shopist_customize_page') .' < '. get_site_title() )

@section('content')
<div id="product_designer" class="container new-container">
  @if(count($designer_hf_data)>0 && count($single_product_details['_product_custom_designer_data'])>0)  
  <br>
  <div class="row">
    <div class="col-sm-12">
      @if(isset($designer_hf_databackside))
      @include('pages.frontend.frontend-pages.frontend-designer-html', array('designer_hf_data' => $designer_hf_data,'designer_hf_databackside'=> $designer_hf_databackside, 'designer_img_elments' => $single_product_details['_product_custom_designer_data'],'designer_img_elmentsback' => $single_product_detailsbackside['_product_custom_designer_data'], 'design_save_data' => $design_json_data,'design_save_databackside' => $design_json_databackside))
      @else
      @include('pages.frontend.frontend-pages.frontend-designer-html', array('designer_hf_data' => $designer_hf_data, 'designer_img_elments' => $single_product_details['_product_custom_designer_data'], 'design_save_data' => $design_json_data))
      @endif
    </div>
  </div>
  <br>
  <div class="row"> 
    <div class="col-sm-12">
      <h1 class="product-title">{{  $single_product_details['post_title'] }}</h1>
      @if(count($attr_lists) >0 && count(get_product_variations_with_data($single_product_details['id']))>0)
      <div class="product-pricing"><span class="solid-price">{!! get_product_variations_min_to_max_price_html($currency_symbol, $single_product_details['id']) !!} </span></div><hr>
        @include('includes.frontend.variations-html', array('attr_lists' => $attr_lists, 'single_product_details' => $single_product_details))
      @else
      <div class="clearfix">
        <div class="product-pricing">
          @if(get_product_type($single_product_details['id']) == 'customizable_product' && count(get_product_variations($single_product_details['id'])) == 0 )
            @if(!is_null($single_product_details['offer_price']))
            <span class="offer-price">{!! price_html( $single_product_details['offer_price'] ) !!}</span>
            @endif

            <span class="solid-price">{!! price_html( $single_product_details['solid_price'] ) !!}</span>
          @endif
        </div> 
        <hr>  
        <button class="btn btn-sm btn-style cart customize-page-add-to-cart" type="button" data-id="{{ $single_product_details['id'] }}">
          <i class="fa fa-shopping-cart"></i>
          {{ trans('frontend.add_to_cart') }}
        </button>
      </div>
      @endif
    </div>  
  </div>
  <input type="hidden" name="hf_custom_designer_data" id="hf_custom_designer_data" value="{{ $single_product_details['product_custom_designer_json'] }}">
  <br>
  @else
  <br>
  <div class="row">
    <div class="col-sm-12">
      <h5>{{ trans('frontend.no_content_yet') }}</h5>
    </div>
  </div>
  @endif
</div>
	
@endsection  