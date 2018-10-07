<?php $data = get_emails_option_data();?>
<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
  <div marginheight="0" marginwidth="0">
    <div style="background-color:#{!! $data['vendor_withdraw_request']['body_bg_color'] !!};margin:0;padding:30px;width:100%" dir="ltr">
      @if($_target == 'add')
      <p>{!! trans('admin.vendor_withdraw_request_add', ['earning' => $_value, 'payment_method' => $_payment_method]) !!}</p>
      @else
      <p>{!! trans('admin.vendor_withdraw_request_update', ['earning' => $_value, 'payment_method' => $_payment_method]) !!}</p>
      @endif
    </div>
  </div>
</body>
</html>