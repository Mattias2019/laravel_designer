<?php $data = get_emails_option_data();?>
<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
  <div marginheight="0" marginwidth="0">
    <div style="background-color:#{!! $data['vendor_account_activation']['body_bg_color'] !!};margin:0;padding:70px 0 70px 0;width:100%" dir="ltr">
      <div style="color:#ffffff; font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif; font-size:30px; font-weight:300; line-height:150%; margin:0; text-align:center;padding:10px 0px;"></div>
      @if($_status == 1)
      <p>{!! trans('admin.vendor_activation_msg_1') !!}</p>
      @else
      <p>{!! trans('admin.vendor_activation_msg_2') !!}</p>
      @endif
    </div>
  </div>
</body>
</html>