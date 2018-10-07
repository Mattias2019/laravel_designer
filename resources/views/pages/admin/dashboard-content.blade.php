@extends('layouts.admin.master')
@section('title', trans('admin.dashboard') .' < '. get_site_title())

@section('content')
<div class="row">
  <div class="col-lg-3 col-xs-12">
    <div class="small-box bg-gray">
      <div class="inner">
        <h3>{!! price_html( $dashboard_data['today_totals_sales'] ) !!}</h3>
        <p>{{ trans('admin.today_total_sales') }}</p>
      </div>
      <div class="icon">
        <i class="fa fa-shopping-cart"></i>
      </div>
      <a href="{{ route('admin.shop_current_date_orders_list')}}" class="small-box-footer">{{ trans('admin.more_info') }} <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <div class="col-lg-3 col-xs-12">
    <div class="small-box bg-aqua">
      <div class="inner">
        <h3>{!! $dashboard_data['total_products']!!}</h3>
        <p>{{ trans('admin.total_products') }}</p>
      </div>
      <div class="icon">
        <i class="fa fa-shopping-cart"></i>
      </div>
      <a href="{{ route('admin.product_list', 'all')}}" class="small-box-footer">{{ trans('admin.more_info') }} <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <div class="col-lg-3 col-xs-12">
    <div class="small-box bg-green">
      <div class="inner">
        <h3>{!! $dashboard_data['today_orders']!!}</h3>
        <p>{{ trans('admin.today_orders') }}</p>
      </div>
      <div class="icon">
        <i class="fa fa-area-chart"></i>
      </div>
      <a href="{{ route('admin.shop_current_date_orders_list') }}" class="small-box-footer">{{ trans('admin.more_info') }} <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <div class="col-lg-3 col-xs-12">
    <div class="small-box bg-yellow">
      <div class="inner">
        <h3>{!! $dashboard_data['total_orders']!!}</h3>
        <p>{{ trans('admin.total_orders') }}</p>
      </div>
      <div class="icon">
        <i class="fa fa-area-chart"></i>
      </div>
      <a href="{{ route('admin.shop_orders_list') }}" class="small-box-footer">{{ trans('admin.more_info') }} <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
</div>

@if(is_admin_login() && count($dashboard_data['overview_reports']) > 0)
<div class="row">
  <div class="col-md-12">
    <div class="box box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-bar-chart dashbord-icon-color" aria-hidden="true"></i> &nbsp; {{ trans('admin.overview_label') }}</h3>
      </div>
      <div class="box-body">
        <div id="chart"></div>
      </div>  
    </div>
  </div>    
</div>
@endif

<div class="row">
  <div class="col-md-7">
    @if(is_admin_login())  
    <div class="box box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-users dashbord-icon-color" aria-hidden="true"></i> &nbsp; {{ trans('admin.vendors_info_label') }}</h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-6">
            <h4>{!! trans('admin.admin_menu_vendors_label') !!}</h4><hr>
            <div class="vendor-info-count">
              <ul>
                <li><i class="fa fa-users"></i>&nbsp;&nbsp; <a  href="{{ route('admin.vendors_list_content') }}">{!! $dashboard_data['total_vendors'] !!} &nbsp;&nbsp;{!! trans('admin.total_vendors_label') !!}</a></li>
                <li><i class="fa fa-check"></i>&nbsp;&nbsp; <a href="{{ route('admin.vendors_list_with_status', 'active') }}">{!! $dashboard_data['active_vendors'] !!} &nbsp;&nbsp;{!! trans('admin.active_vendors_label') !!}</a></li>
                <li><i class="fa fa-close"></i>&nbsp;&nbsp; <a href="{{ route('admin.vendors_list_with_status', 'pending') }}">{!! $dashboard_data['pending_vendors'] !!} &nbsp;&nbsp;{!! trans('admin.pending_vendors_label') !!}</a></li>
              </ul>
            </div>
          </div>
          <div class="col-md-6">
            <h4>{!! trans('admin.withdraw_label') !!}</h4><hr>
            <div class="vendor-withdraw-count">
              <ul>
                <li><i class="fa fa-eye"></i>&nbsp;&nbsp; <a href="{{ route('admin.withdraws_status_change', 'pending') }}">{!! $dashboard_data['total_pending'] !!} &nbsp;&nbsp;{!! trans('admin.pending_withdraw_label') !!}</a></li>
                <li><i class="fa fa-check"></i>&nbsp;&nbsp; <a href="{{ route('admin.withdraws_status_change', 'completed') }}">{!! $dashboard_data['total_completed'] !!} &nbsp;&nbsp;{!! trans('admin.completed_withdraw_label') !!}</a></li>
                <li><i class="fa fa-close"></i>&nbsp;&nbsp; <a href="{{ route('admin.withdraws_status_change', 'cancelled') }}">{!! $dashboard_data['total_cancelled'] !!} &nbsp;&nbsp;{!! trans('admin.cancelled_withdraw_label') !!}</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endif
      
    <div class="box box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-file-text-o dashbord-icon-color" aria-hidden="true"></i> &nbsp; {{ trans('admin.latest_orders') }}</h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <div class="box-body">
        <div class="table-responsive">
          <table class="table no-margin latest-orders">
            <thead>
              <tr>
                <th>{{ trans('admin.order_id') }}</th>
                <th>{{ trans('admin.date') }}</th>
                <th>{{ trans('admin.status') }}</th>
                <th>{{ trans('admin.order_totals') }}</th>
              </tr>
            </thead>
            <tbody>
              @if(count($dashboard_data['latest_orders'])>0)
                @foreach($dashboard_data['latest_orders'] as $vals)
                  <tr>
                    <td><a href="{{ route('admin.view_order_details', $vals['order_id']) }}">#{!! $vals['order_id'] !!}</a></td>
                    <td>{!! $vals['order_date'] !!}</td>
                    <td>
                      @if($vals['order_status'] == 'on-hold')<span class="on-hold-label">{{ trans('admin.on_hold') }}</span>@elseif($vals['order_status'] == 'refunded') <span class="refunded-label">{{ trans('admin.refunded') }}</span>@elseif($vals['order_status'] == 'cancelled') <span class="cancelled-label">{{ trans('admin.cancelled') }}</span> @elseif($vals['order_status'] == 'pending') <span class="pending-label">{{ trans('admin.pending') }}</span> @elseif($vals['order_status'] == 'processing') <span class="processing-label">{{ trans('admin.processing') }}</span> @elseif($vals['order_status'] == 'completed') <span class="completed-label">{{ trans('admin.completed') }}</span> @elseif($vals['order_status'] == 'shipping') <span class="shipping-label">{{ trans('admin.shipping') }}</span> @endif
                    </td>
                    <td>{!! price_html( $vals['order_totals'],  $vals['order_currency']) !!}</td>
                  </tr>
                @endforeach  
              @else
              <tr>
                <td rowspan="4">{{ trans('admin.no_latest_order_yet') }}</td>
              </tr>
              @endif
            </tbody>
          </table>
        </div>
      </div>
      <div class="box-footer clearfix">
        <a href="{{ route('admin.shop_orders_list') }}" class="btn btn-sm btn-default btn-flat pull-right">{{ trans('admin.view_all_orders') }}</a>
      </div>
    </div>
      
    <div class="box box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-shopping-cart dashbord-icon-color" aria-hidden="true"></i> &nbsp; {{ trans('admin.recently_added_products') }}</h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <div class="box-body">
        <ul class="products-list product-list-in-box">
          @if(count($dashboard_data['latest_products'])>0)
            @foreach($dashboard_data['latest_products'] as $vals)
              <li class="item">
                <div class="product-img">
                  @if(get_product_image($vals['id']))
                    <img src="{{ get_image_url($vals['img_url']) }}" alt="">
                  @else
                    <img src="{{ default_placeholder_img_src() }}" alt="">
                  @endif
                </div>
                <div class="products-info">
                  <a target="_blank" href="{{ route('details-page', $vals['id'] .'-'. string_slug_format(get_product_title($vals['id']))) }}" class="product-title">{!! $vals['title'] !!} <span class="label label-warning pull-right">{!! $vals['price'] !!}</span></a>
                  <span class="product-description">
                    {!! get_limit_string(string_decode($vals['description']), 100) !!}
                  </span>
                </div>
              </li>
            @endforeach
          @else
            <li class="item">{{ trans('admin.no_recent_products_added') }}</li>
          @endif 
        </ul>
      </div>
      <div class="box-footer clearfix">
        <a href="{{ route('admin.product_list', 'all') }}" class="btn btn-sm btn-default btn-flat pull-right">{{ trans('admin.view_all_products') }}</a>
      </div>
    </div>  
  </div>
  <div class="col-md-5">
    @if(is_vendor_login())  
    <div class="box box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-bullhorn dashbord-icon-color" aria-hidden="true"></i> &nbsp;{{ trans('admin.vendors_announcement_label') }}</h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <div class="box-body">
        <div class="dashboard-announcement-content-main">
          @if(count($dashboard_data['dashbord_announcement']) > 0)  
          <div class="clearfix">
            <div class="pull-right"><a class="notice-all" href="{{ route('admin.vendor_notice_board_content') }}">{!! trans('admin.all_notice_label') !!}</a></div>
          </div>
          <br>
          <div class="list-content">
            <table style="width:100%;">
              @foreach($dashboard_data['dashbord_announcement'] as $notice)
              <tr>
                <td class="announce-content-panel">
                  <div class="dashboard-announcement-content">
                    <div class="announce-title"><a class="single-notice-title" href="">{!! $notice->post_title !!}</a></div>
                    <div class="announce-details">{!! get_limit_string(string_decode($notice->post_content), 100) !!}</div>
                  </div>
                </td>
                <td class="announce-date-panel">
                  <div class="dashboard-announcement-date">
                    <div class="announce-day">{!! Carbon\Carbon::parse(  $notice->created_at )->format('d') !!}</div>
                    <div class="announce-month">{!! Carbon\Carbon::parse(  $notice->created_at )->format('F') !!}</div>
                    <div class="announce-year">{!! Carbon\Carbon::parse(  $notice->created_at )->format('Y') !!}</div>
                  </div>
                </td>
              </tr>
              @endforeach
            </table>
          </div>  
          @else
          <p>{!! trans('admin.no_notice_label') !!}</p>
          @endif
        </div>
      </div>  
    </div> 
    @endif
    
    <div class="box box-solid">  
      <form  method="post" action="" enctype="multipart/form-data"> 
        <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
        <div class="box-header with-border">
          <i class="fa fa-envelope dashbord-icon-color"></i>
          <h3 class="box-title">{{ trans('admin.quick_email') }}</h3>
          <div class="pull-right box-tools">
            <button class="btn btn-default btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div>
        </div>
        <div class="box-body">
          @include('pages-message.form-submit')
          @include('pages-message.notify-msg-success')
          <div class="form-group">
              <input type="email" class="form-control" name="quickemailto" placeholder="{{ trans('admin.email_to') }}"/>
          </div>
          <div class="form-group">
              <input type="text" class="form-control" name="quickmailsubject" placeholder="{{ trans('admin.subject') }}"/>
          </div>
          <div>
            <textarea id="quickmailbody" name="quickmailbody" placeholder="{{ trans('admin.message') }}......." style="width: 100%; height: 125px;font-size: 14px;border: 1px solid #dddddd; padding: 10px;"></textarea>
          </div>
        </div>
        <div class="box-footer clearfix">
          <button class="pull-right btn btn-default" type="submit" id="sendQuickEmail" name="sendQuickEmail">{{ trans('admin.send') }} <i class="fa fa-arrow-circle-right"></i></button>
        </div>
      </form>   
    </div> 
    <div class="box box-solid">
      <div class="box-header with-border">
        <i class="fa fa-info dashbord-icon-color"></i>
        <h3 class="box-title">Founder'sCaffe</h3>
      </div>
      <div class="box-body">
        <div><i class="fa fa-check"></i> &nbsp; Founder'sCaffe Version : 2.4.5 </div>
      </div>  
    </div>
  </div>
</div>
<script type="text/javascript">
  Morris.Line({
    element: 'chart',
    data:{!! json_encode($dashboard_data['overview_reports']) !!},
    lineColors: ['#819C79', '#fc8710', '#FF6541'],
    xkey: 'dates',
    ykeys: ['total_order','order_total_amount','commision'],
    labels: ['Number of Order', 'Order Totals ({!! get_current_currency_symbol() !!})', 'Commision ({!! get_current_currency_symbol() !!})'],
    xLabels: 'day',
    xLabelAngle: 45,
    hideHover:true,
    xLabelFormat: function (d) {
      var weekdays = new Array(7);
      weekdays[0] = "SUN";
      weekdays[1] = "MON";
      weekdays[2] = "TUE";
      weekdays[3] = "WED";
      weekdays[4] = "THU";
      weekdays[5] = "FRI";
      weekdays[6] = "SAT";

      return weekdays[d.getDay()] + '-' + 
             ("0" + (d.getMonth() + 1)).slice(-2) + '-' + 
             ("0" + (d.getDate())).slice(-2);
    },
    resize: true
  });
</script>
@endsection