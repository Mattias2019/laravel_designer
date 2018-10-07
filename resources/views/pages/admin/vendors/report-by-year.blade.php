<form class="form-horizontal" method="get" action="{{ $action_url }}" enctype="multipart/form-data">
  <div class="row">
    <div class="col-md-12">
      <div class="filter-elements">
        <div class="filter-label">{!! trans('admin.only_year_label') !!}:</div>
        <div class="filter-input">
          <select name="filter_year" id="filter_year" class="select2" style="width:250px;">
            @foreach($year as $count)
              @if($count == $filter_year)
              <option selected="selected" value="{{ $count }}">{!! $count !!}</option>
              @else
              <option value="{{ $count }}">{!! $count !!}</option>
              @endif
            @endforeach
          </select>  
        </div>
      </div>&nbsp;&nbsp;
      
      <div class="filter-elements"><button class="btn btn-primary" type="submit">{!! trans('admin.only_show_label') !!}</button></div>
    </div>
  </div>
</form>
<br><br>

<div class="row">
  <div class="col-md-3">
    <div class="reports-left-sidebar">
      <div class="box box-solid">
        <ul class="chart-legend">
          <li><strong>{!! price_html($vendor_reports_total_details['total_earning']) !!}</strong>{!! trans('admin.total_earning_label') !!}</li>
          <li><strong>{!! price_html($vendor_reports_total_details['order_total']) !!}</strong> {!! trans('admin.order_total_label') !!}</li>
          <li><strong>{!! $vendor_reports_total_details['number_of_order'] !!}</strong>{!! trans('admin.order_placed_label') !!}</li>
        </ul>
      </div>
    </div>
  </div>
    
  <div class="col-md-9">
    <div class="reports-chart-container">
    <div class="box box-solid">
      <div id="chart"></div>
      </div>
    </div>
  </div>
</div>
<br><br>

<div class="row">
  <div class="col-xs-12">
    <h4>{!! trans('admin.filter_data') !!}</h4>  
    <div class="box">
      <div class="box-body">
        <table id="table_for_manufacturers_list" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>{{ trans('admin.order_id') }}</th>
              <th>{{ trans('admin.vendor_name_label') }}</th>
              <th>{{ trans('admin.order_total') }}</th>
              <th>{{ trans('admin.vendor_earning_label') }}</th>
              <th>{{ trans('admin.commision_label') }}</th>
              <th>{{ trans('admin.created_date_label') }}</th>
              <th>{{ trans('admin.status') }}</th>
            </tr>
          </thead>
          <tbody>
            @if(!empty($vendor_reports_log) && $vendor_reports_log->count() > 0)
              @foreach($vendor_reports_log as $row)
              <tr>
                <td>#{!! $row->order_id !!}</td>
                <td>{!! get_user_name_by_user_id($row->vendor_id) !!}</td>
                <td>{!! price_html($row->order_total) !!}</td>
                <td>{!! price_html( (float)$row->order_total - (float)$row->net_amount) !!}</td>
                <td>{!! price_html($row->net_amount) !!}</td>
                <td>{!! Carbon\Carbon::parse(  $row->created_at )->format('F d, Y') !!}</td>
                <td>{!! $row->order_status !!}</td>
              </tr>
              @endforeach
            @else
              <tr><td colspan="7"><i class="fa fa-exclamation-triangle"></i> {!! trans('admin.no_data_found_label') !!}</td></tr>
            @endif
          </tbody>
          <tfoot>
            <th>{{ trans('admin.order_id') }}</th>
            <th>{{ trans('admin.vendor_name_label') }}</th>
            <th>{{ trans('admin.order_total') }}</th>
            <th>{{ trans('admin.vendor_earning_label') }}</th>
            <th>{{ trans('admin.commision_label') }}</th>
            <th>{{ trans('admin.created_date_label') }}</th>
            <th>{{ trans('admin.status') }}</th>
          </tfoot>
        </table>
        <div class="products-pagination">{!! $vendor_reports_log->appends(Request::capture()->except('page'))->render() !!}</div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
  $('.select2').select2();
});

var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
Morris.Line({
  element: 'chart',
  data:{!! json_encode($vendor_reports) !!},
  lineColors: ['#819C79', '#fc8710', '#FF6541'],
  xkey: 'date',
  ykeys: ['total_order','order_total_amount','commision'],
  labels: ['Number of Order', 'Order Totals', 'Commision'],
  xLabels: 'month',
  xLabelAngle: 45,
  hideHover:true,
  xLabelFormat: function (x) { return months[x.getMonth()]; },
  resize: true
});
</script>