@extends('layouts.admin.master')
@section('title', trans('admin.orders_details') .' < '. get_site_title())

@section('content')
<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
  <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
  <div class="box box-solid">
    <div class="box-body">
      <div class="row">
        <div class="col-md-12">
          <h4>{{ trans('admin.change_order_status') }}</h4><hr>
          <div class="form-group">
            <div class="col-sm-3">
              <select id="change_order_status" name="change_order_status" style="width:100%;">
                @if($order_data_by_id['_order_status'] == 'pending')
                  <option selected value="pending">{{ trans('admin.pending_payment') }}</option>
                @else 
                  <option value="pending">{{ trans('admin.pending_payment') }}</option>
                @endif

                @if($order_data_by_id['_order_status'] == 'processing')
                  <option selected value="processing">{{ trans('admin.processing') }}</option>
                @else 
                  <option value="processing">{{ trans('admin.processing') }}</option>
                @endif

                @if($order_data_by_id['_order_status'] == 'on-hold')
                  <option selected value="on-hold">{{ trans('admin.on_hold') }}</option>
                @else 
                  <option value="on-hold">{{ trans('admin.on_hold') }}</option>
                @endif

                @if($order_data_by_id['_order_status'] == 'completed')
                  <option selected value="completed">{{ trans('admin.completed') }}</option>
                @else 
                  <option value="completed">{{ trans('admin.completed') }}</option>
                @endif

                @if($order_data_by_id['_order_status'] == 'cancelled')
                  <option selected value="cancelled">{{ trans('admin.cancelled') }}</option>
                @else 
                  <option value="cancelled">{{ trans('admin.cancelled') }}</option>
                @endif

                @if($order_data_by_id['_order_status'] == 'refunded')
                  <option selected value="refunded">{{ trans('admin.refunded') }}</option>
                @else 
                  <option value="refunded">{{ trans('admin.refunded') }}</option>
                @endif

                @if($order_data_by_id['_order_status'] == 'shipping')
                  <option selected value="shipping">{{ trans('admin.shipping') }}</option>
                @else 
                  <option value="shipping">{{ trans('admin.shipping') }}</option>
                @endif
              </select>
            </div>
            <div class="col-sm-9">
              <button class="btn btn-primary" type="submit">{!! trans('admin.save_change') !!}</button>
              <a class="btn btn-primary" href="{{ route('admin.order_invoice', $order_data_by_id['_order_id']) }}" target="_blank">{!! trans('admin.print_invoice_label') !!}</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>  
</form>  
<br>
<div class="box">
  <div class="box-body">
    <div class="row">
      <div class="col-md-4">
        <h4>{{ trans('admin.order_details') }}</h4><hr>
        <br>
        <p><strong>{{ trans('admin.order') }} #:</strong> {!! $order_data_by_id['_order_id'] !!}
        <p><strong>{{ trans('admin.order_date') }}:</strong> {!! $order_data_by_id['_order_date'] !!}
        <p><strong>{{ trans('admin.payment_method') }}:</strong> {!! get_payment_method_title( $order_data_by_id['_payment_method_title'] ) !!} 
        <p><strong>{{ trans('admin.shipping_method') }}:</strong> {!! $order_data_by_id['_order_shipping_method'] !!}   
        <p><strong>{{ trans('admin.member') }}:</strong> 
            @if(!empty($order_data_by_id['_member']['url'])) 
            <img src="{{ get_image_url($order_data_by_id['_member']['url']) }}" style="width: 32px;margin-left: 10px;">
            @else 
            <img src="{{ default_avatar_img_src() }}" style="width: 32px;margin-left: 10px;">
            @endif
            <b><i>{!! $order_data_by_id['_member']['name'] !!}</i></b>
        </p>  
        <p><strong>{{ trans('admin.customer_ip') }}:</strong> {!! $order_data_by_id['_customer_ip_address'] !!}</p>
        <p><strong>{{ trans('admin.order_currency') }}:</strong> {!! get_currency_name_by_code($order_data_by_id['_order_currency']) !!}</p>
      </div>
      <div class="col-md-4">
          
        <h4>{{ trans('admin.billing_address') }}</h4><hr>
        <br>
        <p>{!! $order_data_by_id['_billing_first_name'].' '. $order_data_by_id['_billing_last_name']!!}</p>
        @if($order_data_by_id['_billing_company'])
          <p><strong>{{ trans('admin.company') }}:</strong> {!! $order_data_by_id['_billing_company'] !!}</p>
        @endif
        <p><strong>{{ trans('admin.address_1') }}:</strong> {!! $order_data_by_id['_billing_address_1'] !!}</p>
        @if($order_data_by_id['_billing_address_2'])
          <p><strong>{{ trans('admin.address_2') }}:</strong> {!! $order_data_by_id['_billing_address_2'] !!}</p>
        @endif
        <p><strong>{{ trans('admin.city') }}:</strong> {!! $order_data_by_id['_billing_city'] !!}</p>
        <p><strong>{{ trans('admin.postCode') }}:</strong> {!! $order_data_by_id['_billing_postcode'] !!}</p>
        <p><strong>{{ trans('admin.country') }}:</strong> {!! get_country_by_code( $order_data_by_id['_billing_country'] ) !!}</p>
        
        
        <br>
        
        <p><strong>{{ trans('admin.phone') }}:</strong> {!! $order_data_by_id['_billing_phone'] !!}</p>
        
        @if($order_data_by_id['_billing_fax'])
          <p><strong>{{ trans('admin.fax') }}:</strong> {!! $order_data_by_id['_billing_fax'] !!}</p>
        @endif
        <p><strong>{{ trans('admin.email') }}:</strong> {!! $order_data_by_id['_billing_email'] !!}</p>
        
      </div>
      <div class="col-md-4">
          
        <h4>{{ trans('admin.shipping_address') }}</h4><hr>
        <br>
        <p>{!! $order_data_by_id['_shipping_first_name'].' '. $order_data_by_id['_shipping_last_name']!!}</p>
        @if($order_data_by_id['_shipping_company'])
          <p><strong>{{ trans('admin.company') }}:</strong> {!! $order_data_by_id['_shipping_company'] !!}</p>
        @endif
        <p><strong>{{ trans('admin.address_1') }}:</strong> {!! $order_data_by_id['_shipping_address_1'] !!}</p>
        @if($order_data_by_id['_shipping_address_2'])
          <p><strong>{{ trans('admin.address_2') }}:</strong> {!! $order_data_by_id['_shipping_address_2'] !!}</p>
        @endif
        <p><strong>{{ trans('admin.city') }}:</strong> {!! $order_data_by_id['_shipping_city'] !!}</p>
        <p><strong>{{ trans('admin.postCode') }}:</strong> {!! $order_data_by_id['_shipping_postcode'] !!}</p>
        <p><strong>{{ trans('admin.country') }}:</strong> {!! get_country_by_code( $order_data_by_id['_shipping_country'] ) !!}</p>
        
       
        <br>
        
        <p><strong>{{ trans('admin.phone') }}:</strong> {!! $order_data_by_id['_shipping_phone'] !!}</p>
        
        @if($order_data_by_id['_shipping_fax'])
          <p><strong>{{ trans('admin.fax') }}:</strong> {!! $order_data_by_id['_shipping_fax'] !!}</p>
        @endif
        <p><strong>{{ trans('admin.email') }}:</strong> {!! $order_data_by_id['_shipping_email'] !!}</p>
        
      </div>
    </div>
  </div>
</div>
<br>
<div class="box">
  <div class="box-body">
    <div class="row">
      <div class="col-md-12">
          <h4>{{ trans('admin.ordered_items') }}</h4><hr>
          <div class="table-responsive order_info">
            <table class="table table-condensed">
              <thead>
                <tr class="order_menu">
                  <td class="image">{{ trans('admin.item') }}</td>
                  <td class="description">{{ trans('admin.description') }}</td>
                  <td class="price">{{ trans('admin.price') }}</td>
                  <td class="quantity">{{ trans('admin.quantity') }}</td>
                  <td class="total">{{ trans('admin.totals') }}</td>
                  <td></td>
                </tr>
              </thead>
              <tbody>
                @foreach($order_data_by_id['_ordered_items'] as $items)
                <tr>
                  <td class="order_product">
                    <img src="{{ get_image_url($items['img_src']) }}" alt="{{basename( $items['img_src'] )}}">
                  </td>
                  <td class="order_description">
                    <h5>{!! $items['name'] !!}</h5>
                    <?php $count = 1; ?>
                    @if(count($items['options']) > 0)
                    <p>
                      @foreach($items['options'] as $key => $val)
                        @if($count == count($items['options']))
                          {!! $key .' &#8658; '. $val !!}
                        @else
                          {!! $key .' &#8658; '. $val. ' , ' !!}
                        @endif
                        <?php $count ++ ; ?>
                      @endforeach
                    </p>
                    @endif
                    
                    @if(get_product_type($items['id']) === 'customizable_product')
                      @if($items['acces_token'])
                        @if(count(get_admin_customize_images_by_access_token($items['id'], $order_data_by_id['_order_id'], $items['acces_token']))>0)
                          <button class="btn btn-block btn-info view-customize-images" data-images="{{ json_encode( get_admin_customize_images_by_access_token($items['id'], $order_data_by_id['_order_id'], $items['acces_token']) ) }}">{{ trans('admin.design_images') }}</button>
                        @endif
                      @endif
                    @endif
                    
                  </td>
                  <td class="order_price">
                    <p> {!! price_html( $items['order_price'], $order_data_by_id['_order_currency'] ) !!} </p>
                  </td>
                  <td class="order_quantity">
                      <p> {!! $items['quantity'] !!} </p>
                  </td>
                  <td class="order_line_total">
                    <p>{!! price_html( ($items['quantity']*$items['order_price']), $order_data_by_id['_order_currency'] ) !!}</p>
                  </td>
                </tr>
                @endforeach
                <tr>
                  <td colspan="5" class="order-total">
                    <p><strong>{{ trans('admin.tax') }}</strong> &nbsp;&nbsp;{!! price_html( $order_data_by_id['_final_order_tax'], $order_data_by_id['_order_currency'] ) !!}</p>
                    
                    <p><strong>{{ trans('admin.shipping_cost') }}</strong> &nbsp;&nbsp;{!! price_html( $order_data_by_id['_final_order_shipping_cost'], $order_data_by_id['_order_currency'] ) !!}</p>
                    
                    <p class="discount"><strong>{{ trans('admin.coupon_discount_label') }}</strong> &nbsp;&nbsp; <span> - </span>{!! price_html( $order_data_by_id['_final_order_discount'], $order_data_by_id['_order_currency'] ) !!}</p>
                    
                    <p><span><strong>{{ trans('admin.order_total') }}</strong> &nbsp;&nbsp;{!! price_html( $order_data_by_id['_final_order_total'], $order_data_by_id['_order_currency'] ) !!}</span></p>
                  </td>
                </tr>

              </tbody>
            </table>
          </div>
      </div>
    </div>
  </div>
</div>

<br>
<div class="box">
  <div class="box-body">
    <div class="row">
      <div class="col-md-12">
        <h4>{{ trans('admin.ordered_notes') }}</h4><hr>
        <p>{!! $order_data_by_id['_order_notes'] !!}</p>
      </div>
    </div>
  </div>
</div>

@if(count($order_data_by_id['_order_history']) > 0)
<br>
<div class="box">
  <div class="box-body">
    <div class="row">
      <div class="col-md-12">
        <h4>{{ trans('admin.ordered_download_history') }}</h4><hr>
        @foreach($order_data_by_id['_order_history'] as $data)
        <div class="download-history">
            <div class="downloaded-file-name">{{ trans('admin.downloaded_file_name_label') }} : <a download="" href="{{ url('/public/uploads'). $data->file_url }}">{{ $data->file_name }}</a></div>
          <div class="total-download">{{ trans('admin.total_download_label') }} : {{ $data->total }}</div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</div>
@endif

<div class="modal fade" id="customizeImages" tabindex="-1" role="dialog" aria-labelledby="updater" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">✕</button>
        <br>
        <i class="icon-credit-card icon-7x"></i>
        <p class="no-margin">{{ trans('admin.all_design_images') }}</p>
      </div>
      <div class="modal-body" style="text-align: center;"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default attachtopost" data-dismiss="modal">{{ trans('admin.close') }}</button>
      </div>
    </div>
  </div>
</div>
@endsection