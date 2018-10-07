<?php $data = get_emails_option_data();?>
<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
  <div marginheight="0" marginwidth="0">
    <div style="background-color:#{!! $data['new_customer_account']['body_bg_color'] !!};margin:0;padding:70px 0 70px 0;width:100%" dir="ltr">
      <div style="color:#ffffff; font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif; font-size:30px; font-weight:300; line-height:150%; margin:0; text-align:center;padding:10px 0px;"></div>
      <p>{!! trans('admin.new_account_mail_notice') !!}</p>
    </div>
  </div>
</body>
</html>