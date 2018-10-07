@section('vendor-withdraw-content')
<style type="text/css">
 @media (min-width: 768px) {
  .sidebar-nav .navbar .navbar-collapse {
    padding: 0;
    max-height: none;
  }
  .sidebar-nav .navbar ul {
    float: none;
  }
  .sidebar-nav .navbar ul:not {
    display: block;
  }
  .sidebar-nav .navbar li {
    float: none;
    display: block;
  }
  .sidebar-nav .navbar li a {
    padding-top: 12px;
    padding-bottom: 12px;
  }
}

.sidebar-nav .navbar li.active{
    border-left:3px solid #333; 
}
</style>
<div id="vendor_withdraw_content">
  <div class="row">
    <div class="col-md-12">
      <div class="vendor-total-earnings">
        <p><span>{!! trans('admin.total_earnings_label') !!}:</span> <span>{!! price_html($withdraw_total) !!}</span></p>
        <p><span>{!! trans('admin.min_withdraw_amount_label') !!}:</span> <span>{!! price_html( $vendor_packages_data->min_withdraw_amount) !!}</span></p>
      </div>
    </div>
  </div> 
  @include('pages-message.notify-msg-success')
  @include('pages-message.form-submit') 
  @include('pages-message.notify-msg-error')  
  <div class="row">
    <div class="col-md-3">
      <div class="sidebar-nav">
        <div class="navbar navbar-default" role="navigation">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <span class="visible-xs navbar-brand">{!! trans('admin.sidebar_menu_label') !!}</span>
          </div>
          <div id="withdraw_request_tab" class="navbar-collapse collapse sidebar-navbar-collapse">
            <ul class="nav navbar-nav">
              <li @if (Session::has('withdraw_request_update_target') && Session::get('withdraw_request_update_target') == 'default_withdrawal_account_label')class="active" @endif data-target="default_withdrawal_account_label"><a href="#default_withdrawal_account_label" data-toggle="tab">{!! trans('admin.default_withdrawal_account_label') !!}</a></li>  
              <li @if (Session::has('withdraw_request_update_target') && Session::get('withdraw_request_update_target') == 'withdraw_request_label')class="active" @endif data-target="withdraw_request_label"><a href="#withdraw_request_label" data-toggle="tab">{!! trans('admin.withdraw_request_label') !!}</a></li>
              <li @if (Session::has('withdraw_request_update_target') && Session::get('withdraw_request_update_target') == 'withdraw_history_label')class="active" @endif data-target="withdraw_history_label"><a href="#withdraw_history_label" data-toggle="tab">{!! trans('admin.withdraw_history_label') !!}</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-9">
      <div class="tab-content">
        <div class="tab-pane @if (Session::has('withdraw_request_update_target') && Session::get('withdraw_request_update_target') == 'default_withdrawal_account_label')active @endif" id="default_withdrawal_account_label">
          @include('pages.admin.vendors.withdrawal-default-content')
          @yield('vendor-withdrawal-account-page-content')
        </div>   
        <div class="tab-pane @if (Session::has('withdraw_request_update_target') && Session::get('withdraw_request_update_target') == 'withdraw_request_label')active @endif" id="withdraw_request_label">
          @include('pages.admin.vendors.withdraw-request-content')
          @yield('vendor-withdraw-request-page-content')
        </div>
        <div class="tab-pane @if (Session::has('withdraw_request_update_target') && Session::get('withdraw_request_update_target') == 'withdraw_history_label')active @endif" id="withdraw_history_label">
          @include('pages.admin.vendors.withdraw-history-content')
          @yield('vendor-withdraw-history-page-content')
        </div>   
      </div>
    </div>  
  </div>
</div>
@endsection