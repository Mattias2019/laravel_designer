<!doctype html>
<html>
<head>
  <title><?php echo trans('admin.order_invoice_label'); ?></title>  
  <link rel="stylesheet" href="<?php echo e(URL::asset('public/bootstrap/css/bootstrap.min.css')); ?>" />
  <script type="text/javascript" src="<?php echo e(URL::asset('public/bootstrap/js/bootstrap.min.js')); ?>"></script>
  <script type="text/javascript" src="<?php echo e(URL::asset('public/jquery/jquery-1.10.2.js')); ?>"></script>
  
  <style>
    .invoice-title h2, .invoice-title h3 {
      display: inline-block;
    }

    .table > tbody > tr > .no-line {
        border-top: none;
    }

    .table > thead > tr > .no-line {
        border-bottom: none;
    }

    .table > tbody > tr > .thick-line {
        border-top: 4px solid #e1e1e1;
    }
    
    #order_invoice hr{ border-bottom:4px solid #e1e1e1;}
</style>
</head>
<body id="order_invoice" onload="window.print(); window.close();">
  <div class="container">
  <div class="row">
      <div class="col-xs-12">
      <div class="invoice-title">
        <h2><?php echo trans('admin.invoice_label'); ?></h2><h3 class="pull-right"><?php echo trans('admin.order'); ?> # <?php echo $order_data_by_id['_order_id']; ?></h3>
      </div>
      <hr>
      <div class="row">
        <div class="col-xs-6">
          <address>
          <strong><?php echo trans('admin.billed_to_label'); ?>:</strong><br>
            <?php echo $order_data_by_id['_billing_first_name'].' '. $order_data_by_id['_billing_last_name']; ?><br>
            <?php echo $order_data_by_id['_billing_address_1']; ?><br>
            
            <?php if($order_data_by_id['_billing_address_2']): ?>
            <?php echo $order_data_by_id['_billing_address_2']; ?><br>
            <?php endif; ?>
            
            <?php echo $order_data_by_id['_billing_city']; ?>, <?php echo $order_data_by_id['_billing_postcode']; ?><br>
            <?php echo $order_data_by_id['_billing_phone']; ?><br>
            <?php echo get_country_by_code( $order_data_by_id['_billing_country'] ); ?><br>
            <?php echo $order_data_by_id['_billing_email']; ?>

          </address>
        </div>
        <div class="col-xs-6 text-right">
          <address>
            <strong><?php echo trans('admin.shipped_to_label'); ?>:</strong><br>
            <?php echo $order_data_by_id['_shipping_first_name'].' '. $order_data_by_id['_shipping_last_name']; ?><br>
            <?php echo $order_data_by_id['_shipping_address_1']; ?><br>
            
            <?php if($order_data_by_id['_shipping_address_2']): ?>
            <?php echo $order_data_by_id['_shipping_address_2']; ?><br>
            <?php endif; ?>
            
            <?php echo $order_data_by_id['_shipping_city']; ?>, <?php echo $order_data_by_id['_shipping_postcode']; ?><br>
            <?php echo $order_data_by_id['_shipping_phone']; ?><br>
            <?php echo get_country_by_code( $order_data_by_id['_shipping_country'] ); ?><br>
            <?php echo $order_data_by_id['_shipping_email']; ?>

          </address>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-6">
          <address>
            <strong><?php echo trans('admin.payment_method_label'); ?>:</strong><br>
            <?php echo get_payment_method_title( $order_data_by_id['_payment_method_title'] ); ?>

          </address>
        </div>
        <div class="col-xs-6 text-right">
          <address>
            <strong><?php echo trans('admin.order_date'); ?>:</strong><br>
            <?php echo $order_data_by_id['_order_date']; ?><br><br>
          </address>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title"><strong><?php echo trans('admin.order_summary_label'); ?></strong></h3>
        </div>
        <div class="panel-body">
          <div class="table-responsive">
            <table class="table table-condensed">
              <thead>
                <tr>
                  <td><strong><?php echo trans('admin.item'); ?></strong></td>
                  <td class="text-center"><strong><?php echo trans('admin.price'); ?></strong></td>
                  <td class="text-center"><strong><?php echo trans('admin.quantity'); ?></strong></td>
                  <td class="text-right"><strong><?php echo trans('admin.totals'); ?></strong></td>
                </tr>
              </thead>
              <tbody>
                <?php $subtotal = 0;?>  
                <?php if(count($order_data_by_id['_ordered_items']) > 0): ?>  
                  <?php $__currentLoopData = $order_data_by_id['_ordered_items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <tr>
                    <td>
                    <h5><?php echo $items['name']; ?></h5>
                    <?php $count = 1; ?>
                    <?php if(count($items['options']) > 0): ?>
                    <p>
                      <?php $__currentLoopData = $items['options']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($count == count($items['options'])): ?>
                          <?php echo $key .' &#8658; '. $val; ?>

                        <?php else: ?>
                          <?php echo $key .' &#8658; '. $val. ' , '; ?>

                        <?php endif; ?>
                        <?php $count ++ ; ?>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </p>
                    <?php endif; ?>
                    </td>
                    <td class="text-center"><?php echo price_html( $items['order_price'], $order_data_by_id['_order_currency'] ); ?></td>
                    <td class="text-center"><?php echo $items['quantity']; ?></td>
                    <td class="text-right"><?php echo price_html( ($items['quantity']*$items['order_price']), $order_data_by_id['_order_currency'] ); ?></td>
                  </tr>
                  <?php $subtotal += $items['order_price'];?>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
                              
                <tr>
                  <td class="thick-line"></td>
                  <td class="thick-line"></td>
                  <td class="thick-line text-center"><strong><?php echo trans('admin.subtotal_label'); ?></strong></td>
                  <td class="thick-line text-right"><?php echo price_html( $subtotal, $order_data_by_id['_order_currency'] ); ?></td>
                </tr>
                <tr>
                  <td class="no-line"></td>
                  <td class="no-line"></td>
                  <td class="no-line text-center"><strong><?php echo trans('admin.tax'); ?></strong></td>
                  <td class="no-line text-right"><?php echo price_html( $order_data_by_id['_final_order_tax'], $order_data_by_id['_order_currency'] ); ?></td>
                </tr>
                <tr>
                  <td class="no-line"></td>
                  <td class="no-line"></td>
                  <td class="no-line text-center"><strong><?php echo trans('admin.shipping_cost'); ?></strong></td>
                  <td class="no-line text-right"><?php echo price_html( $order_data_by_id['_final_order_shipping_cost'], $order_data_by_id['_order_currency'] ); ?></td>
                </tr>
                <tr>
                  <td class="no-line"></td>
                  <td class="no-line"></td>
                  <td class="no-line text-center" style="color:#FF0000;"><strong><?php echo trans('admin.coupon_discount_label'); ?></strong></td>
                  <td class="no-line text-right" style="color:#FF0000;"> - <?php echo price_html( $order_data_by_id['_final_order_discount'], $order_data_by_id['_order_currency'] ); ?></td>
                </tr>
                <tr>
                  <td class="no-line"></td>
                  <td class="no-line"></td>
                  <td class="no-line text-center"><strong><?php echo trans('admin.order_total'); ?></strong></td>
                  <td class="no-line text-right"><?php echo price_html( $order_data_by_id['_final_order_total'], $order_data_by_id['_order_currency'] ); ?></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div style="text-align: center;padding-bottom: 50px;margin-top:30px;">
        <div class="site-logo"><img style="margin:0px auto;" class="img-responsive" src="<?php echo e(get_site_logo_image()); ?>"></div>
        <div class="site-title" style="padding-top: 10px;"><strong><?php echo trans('admin.powered_by'); ?> <?php echo get_site_title(); ?></strong></div>
      </div>
    </div>
  </div>
</div>
</body>
</html>