<?php $__env->startSection('title', trans('admin.dashboard') .' < '. get_site_title()); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
  <div class="col-lg-3 col-xs-12">
    <div class="small-box bg-gray">
      <div class="inner">
        <h3><?php echo price_html( $dashboard_data['today_totals_sales'] ); ?></h3>
        <p><?php echo e(trans('admin.today_total_sales')); ?></p>
      </div>
      <div class="icon">
        <i class="fa fa-shopping-cart"></i>
      </div>
      <a href="<?php echo e(route('admin.shop_current_date_orders_list')); ?>" class="small-box-footer"><?php echo e(trans('admin.more_info')); ?> <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <div class="col-lg-3 col-xs-12">
    <div class="small-box bg-aqua">
      <div class="inner">
        <h3><?php echo $dashboard_data['total_products']; ?></h3>
        <p><?php echo e(trans('admin.total_products')); ?></p>
      </div>
      <div class="icon">
        <i class="fa fa-shopping-cart"></i>
      </div>
      <a href="<?php echo e(route('admin.product_list', 'all')); ?>" class="small-box-footer"><?php echo e(trans('admin.more_info')); ?> <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <div class="col-lg-3 col-xs-12">
    <div class="small-box bg-green">
      <div class="inner">
        <h3><?php echo $dashboard_data['today_orders']; ?></h3>
        <p><?php echo e(trans('admin.today_orders')); ?></p>
      </div>
      <div class="icon">
        <i class="fa fa-area-chart"></i>
      </div>
      <a href="<?php echo e(route('admin.shop_current_date_orders_list')); ?>" class="small-box-footer"><?php echo e(trans('admin.more_info')); ?> <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <div class="col-lg-3 col-xs-12">
    <div class="small-box bg-yellow">
      <div class="inner">
        <h3><?php echo $dashboard_data['total_orders']; ?></h3>
        <p><?php echo e(trans('admin.total_orders')); ?></p>
      </div>
      <div class="icon">
        <i class="fa fa-area-chart"></i>
      </div>
      <a href="<?php echo e(route('admin.shop_orders_list')); ?>" class="small-box-footer"><?php echo e(trans('admin.more_info')); ?> <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
</div>

<?php if(is_admin_login() && count($dashboard_data['overview_reports']) > 0): ?>
<div class="row">
  <div class="col-md-12">
    <div class="box box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-bar-chart dashbord-icon-color" aria-hidden="true"></i> &nbsp; <?php echo e(trans('admin.overview_label')); ?></h3>
      </div>
      <div class="box-body">
        <div id="chart"></div>
      </div>  
    </div>
  </div>    
</div>
<?php endif; ?>

<div class="row">
  <div class="col-md-7">
    <?php if(is_admin_login()): ?>  
    <div class="box box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-users dashbord-icon-color" aria-hidden="true"></i> &nbsp; <?php echo e(trans('admin.vendors_info_label')); ?></h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-6">
            <h4><?php echo trans('admin.admin_menu_vendors_label'); ?></h4><hr>
            <div class="vendor-info-count">
              <ul>
                <li><i class="fa fa-users"></i>&nbsp;&nbsp; <a  href="<?php echo e(route('admin.vendors_list_content')); ?>"><?php echo $dashboard_data['total_vendors']; ?> &nbsp;&nbsp;<?php echo trans('admin.total_vendors_label'); ?></a></li>
                <li><i class="fa fa-check"></i>&nbsp;&nbsp; <a href="<?php echo e(route('admin.vendors_list_with_status', 'active')); ?>"><?php echo $dashboard_data['active_vendors']; ?> &nbsp;&nbsp;<?php echo trans('admin.active_vendors_label'); ?></a></li>
                <li><i class="fa fa-close"></i>&nbsp;&nbsp; <a href="<?php echo e(route('admin.vendors_list_with_status', 'pending')); ?>"><?php echo $dashboard_data['pending_vendors']; ?> &nbsp;&nbsp;<?php echo trans('admin.pending_vendors_label'); ?></a></li>
              </ul>
            </div>
          </div>
          <div class="col-md-6">
            <h4><?php echo trans('admin.withdraw_label'); ?></h4><hr>
            <div class="vendor-withdraw-count">
              <ul>
                <li><i class="fa fa-eye"></i>&nbsp;&nbsp; <a href="<?php echo e(route('admin.withdraws_status_change', 'pending')); ?>"><?php echo $dashboard_data['total_pending']; ?> &nbsp;&nbsp;<?php echo trans('admin.pending_withdraw_label'); ?></a></li>
                <li><i class="fa fa-check"></i>&nbsp;&nbsp; <a href="<?php echo e(route('admin.withdraws_status_change', 'completed')); ?>"><?php echo $dashboard_data['total_completed']; ?> &nbsp;&nbsp;<?php echo trans('admin.completed_withdraw_label'); ?></a></li>
                <li><i class="fa fa-close"></i>&nbsp;&nbsp; <a href="<?php echo e(route('admin.withdraws_status_change', 'cancelled')); ?>"><?php echo $dashboard_data['total_cancelled']; ?> &nbsp;&nbsp;<?php echo trans('admin.cancelled_withdraw_label'); ?></a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php endif; ?>
      
    <div class="box box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-file-text-o dashbord-icon-color" aria-hidden="true"></i> &nbsp; <?php echo e(trans('admin.latest_orders')); ?></h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <div class="box-body">
        <div class="table-responsive">
          <table class="table no-margin latest-orders">
            <thead>
              <tr>
                <th><?php echo e(trans('admin.order_id')); ?></th>
                <th><?php echo e(trans('admin.date')); ?></th>
                <th><?php echo e(trans('admin.status')); ?></th>
                <th><?php echo e(trans('admin.order_totals')); ?></th>
              </tr>
            </thead>
            <tbody>
              <?php if(count($dashboard_data['latest_orders'])>0): ?>
                <?php $__currentLoopData = $dashboard_data['latest_orders']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vals): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <tr>
                    <td><a href="<?php echo e(route('admin.view_order_details', $vals['order_id'])); ?>">#<?php echo $vals['order_id']; ?></a></td>
                    <td><?php echo $vals['order_date']; ?></td>
                    <td>
                      <?php if($vals['order_status'] == 'on-hold'): ?><span class="on-hold-label"><?php echo e(trans('admin.on_hold')); ?></span><?php elseif($vals['order_status'] == 'refunded'): ?> <span class="refunded-label"><?php echo e(trans('admin.refunded')); ?></span><?php elseif($vals['order_status'] == 'cancelled'): ?> <span class="cancelled-label"><?php echo e(trans('admin.cancelled')); ?></span> <?php elseif($vals['order_status'] == 'pending'): ?> <span class="pending-label"><?php echo e(trans('admin.pending')); ?></span> <?php elseif($vals['order_status'] == 'processing'): ?> <span class="processing-label"><?php echo e(trans('admin.processing')); ?></span> <?php elseif($vals['order_status'] == 'completed'): ?> <span class="completed-label"><?php echo e(trans('admin.completed')); ?></span> <?php elseif($vals['order_status'] == 'shipping'): ?> <span class="shipping-label"><?php echo e(trans('admin.shipping')); ?></span> <?php endif; ?>
                    </td>
                    <td><?php echo price_html( $vals['order_totals'],  $vals['order_currency']); ?></td>
                  </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
              <?php else: ?>
              <tr>
                <td rowspan="4"><?php echo e(trans('admin.no_latest_order_yet')); ?></td>
              </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
      <div class="box-footer clearfix">
        <a href="<?php echo e(route('admin.shop_orders_list')); ?>" class="btn btn-sm btn-default btn-flat pull-right"><?php echo e(trans('admin.view_all_orders')); ?></a>
      </div>
    </div>
      
    <div class="box box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-shopping-cart dashbord-icon-color" aria-hidden="true"></i> &nbsp; <?php echo e(trans('admin.recently_added_products')); ?></h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <div class="box-body">
        <ul class="products-list product-list-in-box">
          <?php if(count($dashboard_data['latest_products'])>0): ?>
            <?php $__currentLoopData = $dashboard_data['latest_products']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vals): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <li class="item">
                <div class="product-img">
                  <?php if(get_product_image($vals['id'])): ?>
                    <img src="<?php echo e(get_image_url($vals['img_url'])); ?>" alt="">
                  <?php else: ?>
                    <img src="<?php echo e(default_placeholder_img_src()); ?>" alt="">
                  <?php endif; ?>
                </div>
                <div class="products-info">
                  <a target="_blank" href="<?php echo e(route('details-page', $vals['id'] .'-'. string_slug_format(get_product_title($vals['id'])))); ?>" class="product-title"><?php echo $vals['title']; ?> <span class="label label-warning pull-right"><?php echo $vals['price']; ?></span></a>
                  <span class="product-description">
                    <?php echo get_limit_string(string_decode($vals['description']), 100); ?>

                  </span>
                </div>
              </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          <?php else: ?>
            <li class="item"><?php echo e(trans('admin.no_recent_products_added')); ?></li>
          <?php endif; ?> 
        </ul>
      </div>
      <div class="box-footer clearfix">
        <a href="<?php echo e(route('admin.product_list', 'all')); ?>" class="btn btn-sm btn-default btn-flat pull-right"><?php echo e(trans('admin.view_all_products')); ?></a>
      </div>
    </div>  
  </div>
  <div class="col-md-5">
    <?php if(is_vendor_login()): ?>  
    <div class="box box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-bullhorn dashbord-icon-color" aria-hidden="true"></i> &nbsp;<?php echo e(trans('admin.vendors_announcement_label')); ?></h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <div class="box-body">
        <div class="dashboard-announcement-content-main">
          <?php if(count($dashboard_data['dashbord_announcement']) > 0): ?>  
          <div class="clearfix">
            <div class="pull-right"><a class="notice-all" href="<?php echo e(route('admin.vendor_notice_board_content')); ?>"><?php echo trans('admin.all_notice_label'); ?></a></div>
          </div>
          <br>
          <div class="list-content">
            <table style="width:100%;">
              <?php $__currentLoopData = $dashboard_data['dashbord_announcement']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <tr>
                <td class="announce-content-panel">
                  <div class="dashboard-announcement-content">
                    <div class="announce-title"><a class="single-notice-title" href=""><?php echo $notice->post_title; ?></a></div>
                    <div class="announce-details"><?php echo get_limit_string(string_decode($notice->post_content), 100); ?></div>
                  </div>
                </td>
                <td class="announce-date-panel">
                  <div class="dashboard-announcement-date">
                    <div class="announce-day"><?php echo Carbon\Carbon::parse(  $notice->created_at )->format('d'); ?></div>
                    <div class="announce-month"><?php echo Carbon\Carbon::parse(  $notice->created_at )->format('F'); ?></div>
                    <div class="announce-year"><?php echo Carbon\Carbon::parse(  $notice->created_at )->format('Y'); ?></div>
                  </div>
                </td>
              </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </table>
          </div>  
          <?php else: ?>
          <p><?php echo trans('admin.no_notice_label'); ?></p>
          <?php endif; ?>
        </div>
      </div>  
    </div> 
    <?php endif; ?>
    
    <div class="box box-solid">  
      <form  method="post" action="" enctype="multipart/form-data"> 
        <input type="hidden" name="_token" id="_token" value="<?php echo e(csrf_token()); ?>">
        <div class="box-header with-border">
          <i class="fa fa-envelope dashbord-icon-color"></i>
          <h3 class="box-title"><?php echo e(trans('admin.quick_email')); ?></h3>
          <div class="pull-right box-tools">
            <button class="btn btn-default btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div>
        </div>
        <div class="box-body">
          <?php echo $__env->make('pages-message.form-submit', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
          <?php echo $__env->make('pages-message.notify-msg-success', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
          <div class="form-group">
              <input type="email" class="form-control" name="quickemailto" placeholder="<?php echo e(trans('admin.email_to')); ?>"/>
          </div>
          <div class="form-group">
              <input type="text" class="form-control" name="quickmailsubject" placeholder="<?php echo e(trans('admin.subject')); ?>"/>
          </div>
          <div>
            <textarea id="quickmailbody" name="quickmailbody" placeholder="<?php echo e(trans('admin.message')); ?>......." style="width: 100%; height: 125px;font-size: 14px;border: 1px solid #dddddd; padding: 10px;"></textarea>
          </div>
        </div>
        <div class="box-footer clearfix">
          <button class="pull-right btn btn-default" type="submit" id="sendQuickEmail" name="sendQuickEmail"><?php echo e(trans('admin.send')); ?> <i class="fa fa-arrow-circle-right"></i></button>
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
    data:<?php echo json_encode($dashboard_data['overview_reports']); ?>,
    lineColors: ['#819C79', '#fc8710', '#FF6541'],
    xkey: 'dates',
    ykeys: ['total_order','order_total_amount','commision'],
    labels: ['Number of Order', 'Order Totals (<?php echo get_current_currency_symbol(); ?>)', 'Commision (<?php echo get_current_currency_symbol(); ?>)'],
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>