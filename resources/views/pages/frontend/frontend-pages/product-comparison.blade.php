@extends('layouts.frontend.master')
@section('title', trans('frontend.product_comparison_title_label') .' < '. get_site_title())

@section('content')
<div class="container">
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="span12 product-comparison-list">
        <div class="page-header cm14"><h2>{!! trans('frontend.product_comparison_title_label') !!}</h2></div>
        <div class="cm14">
          @if(count($compare_product_data) > 0)
          <h4 class="cm14">{!! trans('frontend.product_comparison_details_title_label') !!}</h4>
          <table class="table table-hover table-bordered table-condensed">
            <tbody>
              @foreach($compare_product_label as $key => $label)
              <tr>
                <td>{!! $label !!}</td>
                @foreach($compare_product_data as $products)
                  @if($label == 'Image')
                  <td><img src="{{ get_image_url( get_product_image( $products['id'] )) }}" alt="{{ basename( get_image_url( get_product_image( $products['id'] )) ) }}"></td>
                  @endif

                  @if($label == 'Product')
                  <td><a href="{{ route('details-page', $products['post_slug']) }}" target="_blank">{!! get_product_title( $products['id'] ) !!}</a></td>
                  @endif

                  @if($label == 'Price')
                  <td>{!! price_html( get_product_price($products['id']), get_frontend_selected_currency() ) !!}</td>
                  @endif

                  @if(($label !== 'Image' && $label !== 'Product' && $label !== 'Price') && !empty($products['_product_compare_data']))
                  <td>{!! $products['_product_compare_data'][$key] !!}</td>
                  @endif
                @endforeach
              </tr>
              @endforeach

              <tr>
                <td></td>
                @foreach($compare_product_data as $products)
                <td class="text-center"><a class="btn btn-danger" href="{{ route('remove-compare-product-from-list', $products['id']) }}"><i class="icon-white icon-trash"></i><span class="hidden-phone"> {!! trans('frontend.remove') !!}</span></a></td>
                @endforeach
              </tr>
            </tbody>
          </table>
          @else
          <div class="no-comparison-label">{!! trans('frontend.product_comparison_no_label') !!}</div>
          @endif
        </div>
      </div>
    </div>      
	</div>
</div>
@endsection