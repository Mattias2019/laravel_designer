<?php $data = get_emails_option_data();?>
<!DOCTYPE html>
<html lang="en-US">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
    <div marginheight="0" marginwidth="0">
        <div style="margin:0;padding:60px 0 60px 0;width:100%;background-color:#{!! $data['new_order']['body_bg_color'] !!};" dir="ltr">
            <table style="width:100%;height:100%;" cellspacing="0" cellpadding="0" border="0">
                <tbody>
                    <tr>
                        <td valign="top" align="center">
                            <table cellspacing="0" cellpadding="0" border="0" width="650" style="background-color:#fdfdfd;border:1px solid #dcdcdc;border-radius:10px!important">
                                <tbody>
                                    <tr>
                                        <td valign="top" align="center">
                                            <img style="padding:20px 0px; height:30px;" src="{{ $_logo }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top" align="center">
                                            <table width="650" cellspacing="0" cellpadding="0" border="0" style="background-color:#DC143C; color:#ffffff;font-weight:bold;line-height:100%;vertical-align:middle;font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif">
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <div style="text-align:center; padding: 15px 0px;"><h2 style="color:#ffffff;font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif;font-size:30px;font-weight:300;line-height:150%;margin:0;">{!! $data['new_order']['email_heading'] !!}</h2></div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr style="display:none;">
                                        <td valign="top" align="center">
                                            <table width="100%" cellspacing="0" cellpadding="0" border="0" style="padding:10px 0px;background-color:#eeeeee;color:#ffffff;font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif">
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <ul style="list-style:none;display:block;text-align:center; margin: 0px;padding:0px;">
                                                                <li style="display:inline-block;"><a href=""><img src="{{ $_logo }}" width="24" height="24"></a></li>
                                                                <li style="display:inline-block;"><a href=""><img src="{{ $_logo }}" width="24" height="24"></a></li>
                                                                <li style="display:inline-block;"><a href=""><img src="{{ $_logo }}" width="24" height="24"></a></li>
                                                                <li style="display:inline-block;"><a href=""><img src="{{ $_logo }}" width="24" height="24"></a></li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif;font-size:14px;text-align:left;padding:20px 30px;">
                                        @if($_payment_method == 'bacs' || $_payment_method == 'paypal')
                                        <p style="margin:0 0 16px">{!! trans('email.msg_bacs_paypal') !!}:</p>
                                        @elseif($_payment_method == 'cod')
                                          <p style="margin:0 0 16px">{!! trans('email.msg_cod') !!}:</p>
                                        @endif

                                        @if($_payment_method == 'bacs' || $_payment_method == 'cod')
                                          <p style="margin:0 0 16px">{!! $_payment_method_details['method_instructions']!!}</p>
                                        @endif

                                        @if($_payment_method == 'bacs')
                                        <h2 style="color:#3c8dbc;display:block;font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif;font-size:18px;font-weight:bold;line-height:130%;margin:16px 0 8px;text-align:left">{!! trans('email.our_bank_details') !!}</h2>
                                        <h3 style="color:#3c8dbc;display:block;font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif;font-size:16px;font-weight:bold;line-height:130%;margin:16px 0 8px;text-align:left">{!! $_payment_method_details['account_details']['account_name']!!} - {!! $_payment_method_details['account_details']['bank_name'] !!}</h3>
                                        <ul>
                                          <li>{{ trans('email.account_number') }}:
                                            <strong>{!! $_payment_method_details['account_details']['account_number']!!}</strong>
                                          </li>
                                          <li>{!! trans('email.sort_code') !!}: <strong>{!! $_payment_method_details['account_details']['short_code']!!}</strong>
                                          </li>
                                        </ul>
                                        @endif       
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif;font-size:14px;text-align:left;padding:0px 30px 0px 30px;">
                                            <h2 style="color:#25003E;display:block;font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif;font-size:18px;font-weight:bold;line-height:130%;margin:16px 0 8px;text-align:left">{!! trans('email.order') !!} #{!! $_order_id !!} ({!! $_order_date !!})</h2>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top" align="center" style="padding:0px 30px;">
                                            <table width="100%" cellspacing="0" cellpadding="0" border="0" style="font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif;border:3px solid #DC143C;">
                                                <thead>
                                                    <tr>
                                                        <th style="text-align:left;color:#FFFFFF;background-color:#DC143C;padding:5px 0px 5px 10px;" scope="col">{!! trans('email.product') !!}</th>
                                                        <th style="text-align:center;color:#FFFFFF;background-color:#DC143C;padding:5px 0px;" scope="col">{!! trans('email.quantity') !!}</th>
                                                        <th style="text-align:center;color:#FFFFFF;background-color:#DC143C;padding:5px 0px;" scope="col">{!! trans('email.price') !!}</th>
                                                        <th style="text-align:center;color:#FFFFFF;background-color:#444444;padding:5px 0px;" scope="col">{!! trans('email.total') !!}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $subTotal = 0;?> 
                                                    @foreach($_order_items as $items) 
                                                    <?php $subTotal += $items->quantity * $items->price; ?>
                                                    <tr>
                                                        <td style="text-align:left; padding:10px 0px 10px 10px;width:45%;border-bottom:1px solid #e1e1e1;">
                                                            <div style="display:inline-block;vertical-align:middle;background-color:#eeeeee;padding:5px;">@if($items->img_src)<img src="{{ get_image_url( $items->img_src ) }}" width="30" height="30"> @else <img src="{{ default_placeholder_img_src() }}" width="30" height="30">@endif</div> <div style="display:inline-block;vertical-align:middle;">{!! $items->name !!}</div>
                                                        </td>
                                                        <td style="text-align:center;padding:10px 0px 10px 0px;width:15%;border-bottom:1px solid #e1e1e1;">{!! $items->quantity !!}</td>
                                                        <td style="text-align:center;padding:10px 0px 10px 0px;width:15%;border-bottom:1px solid #e1e1e1;">{!! price_html( get_product_price_html_by_filter($items->price) ) !!}</td>
                                                        <td style="background-color:#eeeeee;text-align:center;padding:10px 0px 10px 0px;width:25%;border-bottom:1px solid #e1e1e1;">{!! price_html( get_product_price_html_by_filter($items->quantity * $items->price) ) !!}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top" align="right" style="padding:30px 30px;">
                                            <table cellspacing="0" cellpadding="0" border="0" style="font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif;border:3px solid #DC143C;width:60%;">
                                                <tr>
                                                    <td style="width:58%;text-transform:uppercase;padding:10px 0px 10px 10px;border-bottom:1px solid #e1e1e1;">{!! trans('email.subtotal') !!}</td>
                                                    <td style="width:42%;text-align:center;background-color:#eeeeee;padding:10px 0px 10px 0px;border-bottom:3px solid #e1e1e1;">{!! price_html( get_product_price_html_by_filter($subTotal) ) !!}</td>
                                                </tr>
                                                <tr>
                                                    <td style="width:58%;text-transform:uppercase;padding:10px 0px 10px 10px;border-bottom:1px solid #e1e1e1;">{!! trans('email.shipping_cost') !!}</td>
                                                    @if($_order_shipping_cost && $_order_shipping_cost == 0)
                                                    <td style="width:42%;text-align:center;background-color:#eeeeee;padding:10px 0px 10px 0px;border-bottom:3px solid #e1e1e1;">{!! trans('email.free') !!}</td>
                                                    @else
                                                    <td style="width:42%;text-align:center;background-color:#eeeeee;padding:10px 0px 10px 0px;border-bottom:3px solid #e1e1e1;">{!! price_html( get_product_price_html_by_filter($_order_shipping_cost) ) !!}</td>
                                                    @endif
                                                </tr>
                                                <tr>
                                                    <td style="width:58%;text-transform:uppercase;padding:10px 0px 10px 10px;border-bottom:1px solid #e1e1e1;">{!! trans('email.tax') !!}</td>
                                                    <td style="width:42%;text-align:center;background-color:#eeeeee;padding:10px 0px 10px 0px;border-bottom:3px solid #e1e1e1;">{!! price_html( get_product_price_html_by_filter($_order_tax) ) !!}</td>
                                                </tr>
                                                <tr>
                                                    <td style="width:58%;text-transform:uppercase;padding:10px 0px 10px 10px;border-bottom:1px solid #e1e1e1;">{!! trans('email.payment_method') !!}</td>
                                                    <td style="width:42%;text-align:center;background-color:#eeeeee;padding:10px 0px 10px 0px;border-bottom:3px solid #e1e1e1;text-transform:uppercase;">{!! get_payment_method_title($_payment_method) !!}</td>
                                                </tr>
                                                <tr>
                                                    <td style="width:58%;text-transform:uppercase;padding:10px 0px 10px 10px; color: #25003E; font-weight: bold;border-bottom:1px solid #e1e1e1;">{!! trans('email.total') !!}</td>
                                                    <td style="width:42%;text-align:center;background-color:#eeeeee;padding:10px 0px 10px 0px;background-color: #DC143C; color: #FFFFFF;border-bottom:3px solid #e1e1e1;">{!! price_html( get_product_price_html_by_filter($_order_total) ) !!}</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top" align="center" style="padding:10px 10px;background-color: #DC143C;-webkit-border-bottom-left-radius: 10px;-webkit-border-bottom-right-radius: 10px;-moz-border-radius-bottomleft:10px;-moz-border-radius-bottomright: 10px;border-bottom-right-radius:10px;border-bottom-left-radius:10px;color:#FFF;">
                                            <p>{!! trans('email.powered_by') !!} {!! $_site_title !!}</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>