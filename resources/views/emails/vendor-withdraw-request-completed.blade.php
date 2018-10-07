<?php $data = get_emails_option_data();?>
<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
  <div marginheight="0" marginwidth="0">
    <div style="background-color:#{!! $data['vendor_withdraw_request_completed']['body_bg_color'] !!};margin:0;padding:30px;width:100%" dir="ltr">
      <p>{!! trans('admin.vendor_withdraw_request_completed_msg_mail') !!}</p>
    </div>
  </div>
</body>
</html>