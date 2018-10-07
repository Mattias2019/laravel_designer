<?php $__env->startSection('title', trans('admin.reports') .' < '. get_site_title()); ?>

<?php $__env->startSection('content'); ?>
<section class="content reports-content">
  <div class="row">
    <div class="box box-solid">
      <div class="box-header">
        <div class="col-lg-8 col-xs-12">
          <ul class="breadcrumb">
            <li><a href="<?php echo e(route('admin.reports_list')); ?>"><?php echo e(trans('admin.reports')); ?></a></li>
            <?php if(Request::is('admin/reports/sales-by-product-title')): ?>
              <li class="sales-cat"><?php echo e(trans('admin.products_sales')); ?></li>
              <li><?php echo e(trans('admin.gross_sales_by_product_title')); ?></li>
            <?php elseif(Request::is('admin/reports/sales-by-last-7-days')): ?>  
              <li class="sales-cat"><?php echo e(trans('admin.orders_sales')); ?></li>
              <li><?php echo e(trans('admin.sales_by_last_7_days')); ?></li>
            <?php elseif(Request::is('admin/reports/sales-by-custom-days')): ?>  
              <li class="sales-cat"><?php echo e(trans('admin.orders_sales')); ?></li>
              <li><?php echo e(trans('admin.sales_by_custom_days')); ?></li> 
            <?php elseif(Request::is('admin/reports/sales-by-month')): ?> 
              <li class="sales-cat"><?php echo e(trans('admin.orders_sales')); ?></li>
              <li><?php echo e(trans('admin.sales_by_month')); ?></li>
            <?php elseif(Request::is('admin/reports/sales-by-payment-method')): ?>  
              <li class="sales-cat"><?php echo e(trans('admin.payment_sales')); ?></li>
              <li><?php echo e(trans('admin.sales_by_payment_method')); ?></li>     
            <?php endif; ?>
          </ul>
        </div>
        <div class="col-lg-4 col-xs-12">
          <span class="report-date"><?php echo $report_data['report_date']; ?></span>
        </div>
      </div>
    </div>
  </div>
  <?php if(Request::is('admin/reports/sales-by-product-title') || Request::is('admin/reports/sales-by-custom-days') || Request::is('admin/reports/sales-by-payment-method')): ?>
  <br>
  <div class="row">
    <div class="box box-solid">
      <div class="box-header">
        <div class="col-lg-5 col-xs-12">
          <div class="input-group">
            <div class="input-group-addon">
              <i class="fa fa-calendar"></i>
            </div>
            <input type="text" class="form-control" name="filter_start_date" id="filter_start_date" placeholder="<?php echo e(trans('admin.start_date_format')); ?>">
          </div>
        </div>
        <div class="col-lg-5 col-xs-12">
          <div class="input-group">
            <div class="input-group-addon">
              <i class="fa fa-calendar"></i>
            </div>
            <input type="text" class="form-control" name="filter_end_date" id="filter_end_date" placeholder="<?php echo e(trans('admin.end_date_format')); ?>">
          </div>
        </div>
        <div class="col-lg-2 col-xs-12">
          <button class="btn btn-block btn-default btn-color report-filter-by-date-range"><?php echo e(trans('admin.filter')); ?></button>
        </div>
      </div>
    </div>
  </div>
  <?php endif; ?>
  <br>
  <div class="row">
    <div class="box box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><?php echo e(trans('admin.chart')); ?></h3>
      </div>
      <?php if(Request::is('admin/reports/sales-by-product-title')): ?>
      <div class="box-body chart-responsive" style="position: relative">
        <?php if(count($report_data['report_details']['gross_sales_by_product_title'])>0): ?>
        <div class="chart-y-axis-label"><?php echo e(trans('admin.gross_sales')); ?> <span class="currency_symbol"></span></div>
        <div class="chart" id="product-title-bar-chart" style="height: 300px;"></div>
        <?php else: ?>
        <div class="chart-y-axis-label" style="display:none;"><?php echo e(trans('admin.gross_sales')); ?> <span class="currency_symbol"></span></div>
        <div class="chart" id="product-title-bar-chart" style="height: 300px;display:none;"></div>
        <p class="no-data-found"><?php echo e(trans('admin.no_result_found')); ?></p>
        <?php endif; ?>
      </div>
      <?php elseif(Request::is('admin/reports/sales-by-last-7-days')): ?>
      <div class="box-body chart-responsive" style="position: relative">
        <?php if(count($report_data['report_details']['sales_order_by_last_7_days']['report_data'])>0): ?>
        <div class="chart-y-axis-label"><?php echo e(trans('admin.totals')); ?> <span class="currency_symbol"></span></div>
        <div class="chart" id="product-title-bar-chart" style="height: 300px;"></div>
        <?php else: ?>
        <p><?php echo e(trans('admin.no_result_found')); ?></p>
        <?php endif; ?>
      </div>
      <?php elseif(Request::is('admin/reports/sales-by-custom-days')): ?>
      <div class="box-body chart-responsive" style="position: relative">
        <?php if(count($report_data['report_details']['sales_order_by_custom_days']['report_data'])>0): ?>
        <div class="chart-y-axis-label"><?php echo e(trans('admin.totals')); ?> <span class="currency_symbol"></span></div>
        <div class="chart" id="product-title-bar-chart" style="height: 300px;"></div>
        <?php else: ?>
        <div class="chart-y-axis-label" style="display:none;"><?php echo e(trans('admin.totals')); ?> <span class="currency_symbol"></span></div>
        <div class="chart" id="product-title-bar-chart" style="height: 300px;display:none;"></div>
        <p class="no-data-found"><?php echo e(trans('admin.no_result_found')); ?></p>
        <?php endif; ?>
      </div>
      <?php elseif(Request::is('admin/reports/sales-by-month')): ?>
      <div class="box-body chart-responsive" style="position: relative">
        <?php if(count($report_data['report_details']['gross_sales_by_month'])>0): ?>
        <div class="chart-y-axis-label"><?php echo e(trans('admin.totals')); ?> <span class="currency_symbol"></span></div>
        <div class="chart" id="product-title-bar-chart" style="height: 300px;"></div>
        <?php else: ?>
        <p><?php echo e(trans('admin.no_result_found')); ?></p>
        <?php endif; ?>
      </div>
      <?php elseif(Request::is('admin/reports/sales-by-payment-method')): ?>
      <div class="box-body chart-responsive" style="position: relative">
        <?php if(count($report_data['report_details']['gross_sales_by_payment_method'])>0): ?>
        <div class="chart-y-axis-label"><?php echo e(trans('admin.totals')); ?> <span class="currency_symbol"></span></div>
        <div class="chart" id="product-title-bar-chart" style="height: 300px;"></div>
        <?php else: ?>
        <div class="chart-y-axis-label" style="display:none;"><?php echo e(trans('admin.totals')); ?> <span class="currency_symbol"></span></div>
        <div class="chart" id="product-title-bar-chart" style="height: 300px;display:none;"></div>
        <p class="no-data-found"><?php echo e(trans('admin.no_result_found')); ?></p>
        <?php endif; ?>
      </div>
      <?php endif; ?>
    </div>
  </div>
  <br>
  <div class="row">
    <div class="box box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><?php echo e(trans('admin.details')); ?></h3>
      </div>
      <div class="box-body">
        <?php if(Request::is('admin/reports/sales-by-product-title')): ?>
          <table class="table table-bordered table-striped admin-data-table">
            <thead>
              <tr>
                <th><?php echo e(trans('admin.product_title')); ?></th>
                <th><?php echo e(trans('admin.units_sold')); ?></th>
                <th><?php echo e(trans('admin.gross_sales')); ?></th>
              </tr>
            </thead>
            <tbody>
              <?php if(isset($report_data['report_details']['gross_sales_by_product_title']) && count($report_data['report_details']['gross_sales_by_product_title']) > 0): ?>
                <?php $__currentLoopData = $report_data['report_details']['gross_sales_by_product_title']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo $row['product_title']; ?></td>
                    <td><?php echo $row['units_sold']; ?></td>
                    <td><?php echo price_html( $row['gross_sales'] ); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              <?php endif; ?>
            </tbody>
            <tfoot>
              <tr>
                <th><?php echo e(trans('admin.product_title')); ?></th>
                <th><?php echo e(trans('admin.units_sold')); ?></th>
                <th><?php echo e(trans('admin.gross_sales')); ?></th>
              </tr>
            </tfoot>
          </table>
        <?php elseif(Request::is('admin/reports/sales-by-last-7-days')): ?>
          <table id="table_for_report_product_title" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th><?php echo e(trans('admin.order_id')); ?></th>
                <th><?php echo e(trans('admin.order_date')); ?></th>
                <th><?php echo e(trans('admin.order_status')); ?></th>
                <th><?php echo e(trans('admin.order_totals')); ?></th>
              </tr>
            </thead>
            <tbody>
              <?php if(isset($report_data['report_details']['sales_order_by_last_7_days']['table_data']) && count($report_data['report_details']['sales_order_by_last_7_days']['table_data']) > 0): ?>
                <?php $__currentLoopData = $report_data['report_details']['sales_order_by_last_7_days']['table_data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo $row['order_id']; ?></td>
                    <td><?php echo $row['order_date']; ?></td>
                    <td><?php echo $row['order_status']; ?></td>
                    <td><?php echo price_html( $row['order_totals'] ); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              <?php endif; ?>
            </tbody>
            <tfoot>
              <tr>
                <th><?php echo e(trans('admin.order_id')); ?></th>
                <th><?php echo e(trans('admin.order_date')); ?></th>
                <th><?php echo e(trans('admin.order_status')); ?></th>
                <th><?php echo e(trans('admin.order_totals')); ?></th>
              </tr>
            </tfoot>
          </table>
        <?php elseif(Request::is('admin/reports/sales-by-custom-days')): ?>
          <table id="table_for_report_product_title" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th><?php echo e(trans('admin.order_id')); ?></th>
                <th><?php echo e(trans('admin.order_date')); ?></th>
                <th><?php echo e(trans('admin.order_status')); ?></th>
                <th><?php echo e(trans('admin.order_totals')); ?></th>
              </tr>
            </thead>
            <tbody>
              <?php if(isset($report_data['report_details']['sales_order_by_custom_days']['table_data']) && count($report_data['report_details']['sales_order_by_custom_days']['table_data']) > 0): ?>
                <?php $__currentLoopData = $report_data['report_details']['sales_order_by_custom_days']['table_data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo $row['order_id']; ?></td>
                    <td><?php echo $row['order_date']; ?></td>
                    <td><?php echo $row['order_status']; ?></td>
                    <td><?php echo price_html( $row['order_totals'] ); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              <?php endif; ?>
            </tbody>
            <tfoot>
              <tr>
                <th><?php echo e(trans('admin.order_id')); ?></th>
                <th><?php echo e(trans('admin.order_date')); ?></th>
                <th><?php echo e(trans('admin.order_status')); ?></th>
                <th><?php echo e(trans('admin.order_totals')); ?></th>
              </tr>
            </tfoot>
          </table>
        <?php elseif(Request::is('admin/reports/sales-by-month')): ?>
          <table id="table_for_report_product_title" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th><?php echo e(trans('admin.month')); ?></th>
                <th><?php echo e(trans('admin.totals')); ?></th>
              </tr>
            </thead>
            <tbody>
              <?php if(isset($report_data['report_details']['gross_sales_by_month']) && count($report_data['report_details']['gross_sales_by_month']) > 0): ?>
                <?php $__currentLoopData = $report_data['report_details']['gross_sales_by_month']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo $row['month']; ?></td>
                    <td><?php echo price_html( $row['gross_sales'] ); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              <?php endif; ?>
            </tbody>
            <tfoot>
              <tr>
                <th><?php echo e(trans('admin.month')); ?></th>
                <th><?php echo e(trans('admin.totals')); ?></th>
              </tr>
            </tfoot>
          </table>
        <?php elseif(Request::is('admin/reports/sales-by-payment-method')): ?>
          <table id="table_for_report_product_title" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th><?php echo e(trans('admin.method_name')); ?></th>
                <th><?php echo e(trans('admin.totals')); ?></th>
              </tr>
            </thead>
            <tbody>
              <?php if(isset($report_data['report_details']['gross_sales_by_payment_method']) && count($report_data['report_details']['gross_sales_by_payment_method']) > 0): ?>
                <?php $__currentLoopData = $report_data['report_details']['gross_sales_by_payment_method']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo $row['method']; ?></td>
                    <td><?php echo price_html( $row['gross_sales'] ); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              <?php endif; ?>
            </tbody>
            <tfoot>
              <tr>
                <th><?php echo e(trans('admin.method_name')); ?></th>
                <th><?php echo e(trans('admin.totals')); ?></th>
              </tr>
            </tfoot>
          </table>
        <?php endif; ?>
      </div>
    </div>
  </div>
  
  <input type="hidden" name="hf_report_data" id="hf_report_data" value="<?php echo e(json_encode($report_data['report_details'])); ?>">
  <input type="hidden" name="currency_symbol" id="currency_symbol" value="<?php echo e($report_data['report_currency_symbol']); ?>">
  <input type="hidden" name="report_name" id="report_name" value="<?php echo e($report_data['report_name']); ?>">
  <input type="hidden" name="_token" id="_token" value="<?php echo e(csrf_token()); ?>">
  <div class="eb-overlay"></div>
  <div class="eb-overlay-loader"></div>
</section>  
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>