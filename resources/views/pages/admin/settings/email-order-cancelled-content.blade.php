<h3>{!! trans('admin.emails_notifications_cancelled_order_label') !!}</h3><hr>
<p>{!! trans('admin.email_cancelled_order_label') !!}</p>
@include('pages-message.notify-msg-success')

<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
  <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
  <input type="hidden" name="email_type" value="cancelled_order">
  
  <div class="box box-solid">
    <div class="box-body">
      <div class="form-group">
        <label class="col-sm-4 control-label" for="inputEnableDisable">{{ trans('admin.email_enable_disable_label') }}</label>
        <div class="col-sm-8">
          @if($emails_notification_data['cancelled_order']['enable_disable'] == true)
            <input type="checkbox" checked="checked" name="cancelled_order_enable_disable" class="shopist-iCheck"> &nbsp;{!! trans('admin.enable_notify_msg_label') !!}
          @else
            <input type="checkbox" name="cancelled_order_enable_disable" class="shopist-iCheck"> &nbsp;{!! trans('admin.enable_notify_msg_label') !!}
          @endif
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-4 control-label" for="inputSubject">{{ trans('admin.subject') }}</label>
        <div class="col-sm-8">
          <input type="text" name="cancelled_order_subject" class="form-control" value="{{ $emails_notification_data['cancelled_order']['subject'] }}">
        </div>
      </div> 
      <div class="form-group">
        <label class="col-sm-4 control-label" for="inputEmailHeading">{{ trans('admin.email_heading_label') }}</label>
        <div class="col-sm-8">
          <input type="text" name="cancelled_order_email_heading" class="form-control" value="{{ $emails_notification_data['cancelled_order']['email_heading'] }}">
        </div>
      </div> 
      <div class="form-group">
        <label class="col-sm-4 control-label" for="inputBodyBGColor">{{ trans('admin.body_bg_color_label') }}</label>
        <div class="col-sm-8">
          <input type="text" name="cancelled_order_body_bg_color" class="form-control color" value="{{ $emails_notification_data['cancelled_order']['body_bg_color'] }}">
        </div>
      </div> 
    </div>
    <div class="clearfix">
      <div class="pull-right">
        <button style="margin:0px 15px 15px 0px;" class="btn btn-primary pull-right" type="submit">{{ trans('admin.save') }}</button>
      </div>
    </div>
  </div>		
</form>    