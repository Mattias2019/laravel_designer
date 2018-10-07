@extends('layouts.admin.master')
@section('title', trans('admin.reports') .' < '. get_site_title())

@section('content')
<section class="content reports-content">
  <div class="row">
    <div class="box box-solid">
      <div class="box-header">
        <div class="col-lg-8 col-xs-12">
          <ul class="breadcrumb">
            <li><a href="{{ route('admin.reports_list') }}">{{ trans('admin.reports') }}</a></li>
            @if(Request::is('admin/reports/sales-by-product-title'))
              <li class="sales-cat">{{ trans('admin.products_sales') }}</li>
              <li>{{ trans('admin.gross_sales_by_product_title') }}</li>
            @elseif(Request::is('admin/reports/sales-by-last-7-days'))  
              <li class="sales-cat">{{ trans('admin.orders_sales') }}</li>
              <li>{{ trans('admin.sales_by_last_7_days') }}</li>
            @elseif(Request::is('admin/reports/sales-by-custom-days'))  
              <li class="sales-cat">{{ trans('admin.orders_sales') }}</li>
              <li>{{ trans('admin.sales_by_custom_days') }}</li> 
            @elseif(Request::is('admin/reports/sales-by-month')) 
              <li class="sales-cat">{{ trans('admin.orders_sales') }}</li>
              <li>{{ trans('admin.sales_by_month') }}</li>
            @elseif(Request::is('admin/reports/sales-by-payment-method'))  
              <li class="sales-cat">{{ trans('admin.payment_sales') }}</li>
              <li>{{ trans('admin.sales_by_payment_method') }}</li>     
            @endif
          </ul>
        </div>
        <div class="col-lg-4 col-xs-12">
          <span class="report-date">{!! $report_data['report_date'] !!}</span>
        </div>
      </div>
    </div>
  </div>
  @if(Request::is('admin/reports/sales-by-product-title') || Request::is('admin/reports/sales-by-custom-days') || Request::is('admin/reports/sales-by-payment-method'))
  <br>
  <div class="row">
    <div class="box box-solid">
      <div class="box-header">
        <div class="col-lg-5 col-xs-12">
          <div class="input-group">
            <div class="input-group-addon">
              <i class="fa fa-calendar"></i>
            </div>
            <input type="text" class="form-control" name="filter_start_date" id="filter_start_date" placeholder="{{ trans('admin.start_date_format') }}">
          </div>
        </div>
        <div class="col-lg-5 col-xs-12">
          <div class="input-group">
            <div class="input-group-addon">
              <i class="fa fa-calendar"></i>
            </div>
            <input type="text" class="form-control" name="filter_end_date" id="filter_end_date" placeholder="{{ trans('admin.end_date_format') }}">
          </div>
        </div>
        <div class="col-lg-2 col-xs-12">
          <button class="btn btn-block btn-default btn-color report-filter-by-date-range">{{ trans('admin.filter') }}</button>
        </div>
      </div>
    </div>
  </div>
  @endif
  <br>
  <div class="row">
    <div class="box box-solid">
      <div class="box-header with-border">
        <h3 class="box-title">{{ trans('admin.chart') }}</h3>
      </div>
      @if(Request::is('admin/reports/sales-by-product-title'))
      <div class="box-body chart-responsive" style="position: relative">
        @if(count($report_data['report_details']['gross_sales_by_product_title'])>0)
        <div class="chart-y-axis-label">{{ trans('admin.gross_sales') }} <span class="currency_symbol"></span></div>
        <div class="chart" id="product-title-bar-chart" style="height: 300px;"></div>
        @else
        <div class="chart-y-axis-label" style="display:none;">{{ trans('admin.gross_sales') }} <span class="currency_symbol"></span></div>
        <div class="chart" id="product-title-bar-chart" style="height: 300px;display:none;"></div>
        <p class="no-data-found">{{ trans('admin.no_result_found') }}</p>
        @endif
      </div>
      @elseif(Request::is('admin/reports/sales-by-last-7-days'))
      <div class="box-body chart-responsive" style="position: relative">
        @if(count($report_data['report_details']['sales_order_by_last_7_days']['report_data'])>0)
        <div class="chart-y-axis-label">{{ trans('admin.totals') }} <span class="currency_symbol"></span></div>
        <div class="chart" id="product-title-bar-chart" style="height: 300px;"></div>
        @else
        <p>{{ trans('admin.no_result_found') }}</p>
        @endif
      </div>
      @elseif(Request::is('admin/reports/sales-by-custom-days'))
      <div class="box-body chart-responsive" style="position: relative">
        @if(count($report_data['report_details']['sales_order_by_custom_days']['report_data'])>0)
        <div class="chart-y-axis-label">{{ trans('admin.totals') }} <span class="currency_symbol"></span></div>
        <div class="chart" id="product-title-bar-chart" style="height: 300px;"></div>
        @else
        <div class="chart-y-axis-label" style="display:none;">{{ trans('admin.totals') }} <span class="currency_symbol"></span></div>
        <div class="chart" id="product-title-bar-chart" style="height: 300px;display:none;"></div>
        <p class="no-data-found">{{ trans('admin.no_result_found') }}</p>
        @endif
      </div>
      @elseif(Request::is('admin/reports/sales-by-month'))
      <div class="box-body chart-responsive" style="position: relative">
        @if(count($report_data['report_details']['gross_sales_by_month'])>0)
        <div class="chart-y-axis-label">{{ trans('admin.totals') }} <span class="currency_symbol"></span></div>
        <div class="chart" id="product-title-bar-chart" style="height: 300px;"></div>
        @else
        <p>{{ trans('admin.no_result_found') }}</p>
        @endif
      </div>
      @elseif(Request::is('admin/reports/sales-by-payment-method'))
      <div class="box-body chart-responsive" style="position: relative">
        @if(count($report_data['report_details']['gross_sales_by_payment_method'])>0)
        <div class="chart-y-axis-label">{{ trans('admin.totals') }} <span class="currency_symbol"></span></div>
        <div class="chart" id="product-title-bar-chart" style="height: 300px;"></div>
        @else
        <div class="chart-y-axis-label" style="display:none;">{{ trans('admin.totals') }} <span class="currency_symbol"></span></div>
        <div class="chart" id="product-title-bar-chart" style="height: 300px;display:none;"></div>
        <p class="no-data-found">{{ trans('admin.no_result_found') }}</p>
        @endif
      </div>
      @endif
    </div>
  </div>
  <br>
  <div class="row">
    <div class="box box-solid">
      <div class="box-header with-border">
        <h3 class="box-title">{{ trans('admin.details') }}</h3>
      </div>
      <div class="box-body">
        @if(Request::is('admin/reports/sales-by-product-title'))
          <table class="table table-bordered table-striped admin-data-table">
            <thead>
              <tr>
                <th>{{ trans('admin.product_title') }}</th>
                <th>{{ trans('admin.units_sold') }}</th>
                <th>{{ trans('admin.gross_sales') }}</th>
              </tr>
            </thead>
            <tbody>
              @if(isset($report_data['report_details']['gross_sales_by_product_title']) && count($report_data['report_details']['gross_sales_by_product_title']) > 0)
                @foreach($report_data['report_details']['gross_sales_by_product_title'] as $row)
                <tr>
                    <td>{!! $row['product_title'] !!}</td>
                    <td>{!! $row['units_sold'] !!}</td>
                    <td>{!! price_html( $row['gross_sales'] ) !!}</td>
                </tr>
                @endforeach
              @endif
            </tbody>
            <tfoot>
              <tr>
                <th>{{ trans('admin.product_title') }}</th>
                <th>{{ trans('admin.units_sold') }}</th>
                <th>{{ trans('admin.gross_sales') }}</th>
              </tr>
            </tfoot>
          </table>
        @elseif(Request::is('admin/reports/sales-by-last-7-days'))
          <table id="table_for_report_product_title" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>{{ trans('admin.order_id') }}</th>
                <th>{{ trans('admin.order_date') }}</th>
                <th>{{ trans('admin.order_status') }}</th>
                <th>{{ trans('admin.order_totals') }}</th>
              </tr>
            </thead>
            <tbody>
              @if(isset($report_data['report_details']['sales_order_by_last_7_days']['table_data']) && count($report_data['report_details']['sales_order_by_last_7_days']['table_data']) > 0)
                @foreach($report_data['report_details']['sales_order_by_last_7_days']['table_data'] as $row)
                <tr>
                    <td>{!! $row['order_id'] !!}</td>
                    <td>{!! $row['order_date'] !!}</td>
                    <td>{!! $row['order_status'] !!}</td>
                    <td>{!! price_html( $row['order_totals'] ) !!}</td>
                </tr>
                @endforeach
              @endif
            </tbody>
            <tfoot>
              <tr>
                <th>{{ trans('admin.order_id') }}</th>
                <th>{{ trans('admin.order_date') }}</th>
                <th>{{ trans('admin.order_status') }}</th>
                <th>{{ trans('admin.order_totals') }}</th>
              </tr>
            </tfoot>
          </table>
        @elseif(Request::is('admin/reports/sales-by-custom-days'))
          <table id="table_for_report_product_title" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>{{ trans('admin.order_id') }}</th>
                <th>{{ trans('admin.order_date') }}</th>
                <th>{{ trans('admin.order_status') }}</th>
                <th>{{ trans('admin.order_totals') }}</th>
              </tr>
            </thead>
            <tbody>
              @if(isset($report_data['report_details']['sales_order_by_custom_days']['table_data']) && count($report_data['report_details']['sales_order_by_custom_days']['table_data']) > 0)
                @foreach($report_data['report_details']['sales_order_by_custom_days']['table_data'] as $row)
                <tr>
                    <td>{!! $row['order_id'] !!}</td>
                    <td>{!! $row['order_date'] !!}</td>
                    <td>{!! $row['order_status'] !!}</td>
                    <td>{!! price_html( $row['order_totals'] ) !!}</td>
                </tr>
                @endforeach
              @endif
            </tbody>
            <tfoot>
              <tr>
                <th>{{ trans('admin.order_id') }}</th>
                <th>{{ trans('admin.order_date') }}</th>
                <th>{{ trans('admin.order_status') }}</th>
                <th>{{ trans('admin.order_totals') }}</th>
              </tr>
            </tfoot>
          </table>
        @elseif(Request::is('admin/reports/sales-by-month'))
          <table id="table_for_report_product_title" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>{{ trans('admin.month') }}</th>
                <th>{{ trans('admin.totals') }}</th>
              </tr>
            </thead>
            <tbody>
              @if(isset($report_data['report_details']['gross_sales_by_month']) && count($report_data['report_details']['gross_sales_by_month']) > 0)
                @foreach($report_data['report_details']['gross_sales_by_month'] as $row)
                <tr>
                    <td>{!! $row['month'] !!}</td>
                    <td>{!! price_html( $row['gross_sales'] ) !!}</td>
                </tr>
                @endforeach
              @endif
            </tbody>
            <tfoot>
              <tr>
                <th>{{ trans('admin.month') }}</th>
                <th>{{ trans('admin.totals') }}</th>
              </tr>
            </tfoot>
          </table>
        @elseif(Request::is('admin/reports/sales-by-payment-method'))
          <table id="table_for_report_product_title" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>{{ trans('admin.method_name') }}</th>
                <th>{{ trans('admin.totals') }}</th>
              </tr>
            </thead>
            <tbody>
              @if(isset($report_data['report_details']['gross_sales_by_payment_method']) && count($report_data['report_details']['gross_sales_by_payment_method']) > 0)
                @foreach($report_data['report_details']['gross_sales_by_payment_method'] as $row)
                <tr>
                    <td>{!! $row['method'] !!}</td>
                    <td>{!! price_html( $row['gross_sales'] ) !!}</td>
                </tr>
                @endforeach
              @endif
            </tbody>
            <tfoot>
              <tr>
                <th>{{ trans('admin.method_name') }}</th>
                <th>{{ trans('admin.totals') }}</th>
              </tr>
            </tfoot>
          </table>
        @endif
      </div>
    </div>
  </div>
  
  <input type="hidden" name="hf_report_data" id="hf_report_data" value="{{ json_encode($report_data['report_details']) }}">
  <input type="hidden" name="currency_symbol" id="currency_symbol" value="{{ $report_data['report_currency_symbol'] }}">
  <input type="hidden" name="report_name" id="report_name" value="{{ $report_data['report_name'] }}">
  <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
  <div class="eb-overlay"></div>
  <div class="eb-overlay-loader"></div>
</section>  
@endsection