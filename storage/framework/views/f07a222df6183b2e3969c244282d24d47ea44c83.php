<?php $__env->startSection('title', trans('admin.products_list') .' < '. get_site_title()); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
  <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
    <h4><?php echo trans('admin.products_list'); ?></h4>
  </div>
  <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
    <div class="pull-right">
      <a href="<?php echo e(route('admin.add_product')); ?>" class="btn btn-primary pull-right"><?php echo trans('admin.add_new_product'); ?></a>
    </div>  
  </div>
</div>

<div class="row">
  <div class="col-xs-12">
				<div class="clearfix">
						<div class="products-export-import-options pull-right">
								<ul>
										<li><div data-toggle="modal" data-target="#productImport"><i class="glyphicon glyphicon-import"></i> <?php echo trans('admin.import_label'); ?></div></li>
										<li><div data-toggle="modal" data-target="#productExport"><i class="glyphicon glyphicon-export"></i> <?php echo trans('admin.export_label'); ?></div></li>
								</ul>
						</div>
						
						<div class="modal fade" id="productImport" tabindex="-1" role="dialog" aria-labelledby="updater" aria-hidden="true">
								<div class="modal-dialog">
										<form enctype="multipart/form-data" id="product_csv_import" method="POST">
												<div class="modal-content">
														<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal" aria-hidden="true">✕</button>
																<br>
																<i class="icon-credit-card icon-7x"></i>
																<p class="no-margin"><?php echo trans('admin.import_title_label'); ?></p>
														</div>
														<div class="modal-body">   
                                <input type="file" name="csvFileImport" id="csvFileImport" /><br>
                              <div class="sample-csv-download"><a href="<?php echo e(url('/'). '/public/extra-files/products_import.csv'); ?>" download="">[ <?php echo trans('admin.sample_csv_file_label'); ?> ]</a></div>
														</div>
                            <div class="modal-footer" style="position:relative;">
																<input type="submit" name="upload_product_file" id="upload_product_file" value="<?php echo e(trans('admin.upload_lang_zip_file')); ?>" class="btn btn-default attachtopost upload-btn-action" /> 
																<button  type="button" class="btn btn-default attachtopost upload-btn-action" data-dismiss="modal"><?php echo trans('admin.close'); ?></button>
														</div>
												</div>
										</form>		
								</div>
						</div>
				
						<div class="modal fade" id="productExport" tabindex="-1" role="dialog" aria-labelledby="updater" aria-hidden="true">
								<div class="modal-dialog">
										<div class="modal-content">
												<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-hidden="true">✕</button>
														<br>
														<i class="icon-credit-card icon-7x"></i>
														<p class="no-margin"><?php echo trans('admin.export_title_label'); ?></p>
												</div>
												<div class="modal-body">     
                          <a href="<?php echo e(route('export-products')); ?>" class="btn btn-default export-csv-file"><?php echo trans('admin.export_csv_file_label'); ?></a>
												</div>
												<div class="modal-footer">
														<button type="button" class="btn btn-default attachtopost" data-dismiss="modal"><?php echo trans('admin.close'); ?></button>
												</div>
										</div>
								</div>
						</div>
				</div>		
				
    <div class="box">
      <div class="box-body">
        <div id="table_search_option">
          <form action="<?php echo e(route('admin.product_list', 'all')); ?>" method="GET"> 
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="input-group">
                  <input type="text" name="term_product" class="search-query form-control" placeholder="Enter product name to search" value="<?php echo e($search_value); ?>" />
                  <div class="input-group-btn">
                    <button class="btn btn-primary" type="submit">
                      <span class="glyphicon glyphicon-search"></span>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </form>  
        </div>      
        <table class="table table-bordered table-striped admin-data-table">
          <thead>
            <tr>
              <th><?php echo trans('admin.product_image'); ?></th>
              <th><?php echo trans('admin.product_name'); ?></th>
              <th><?php echo trans('admin.product_sku'); ?></th> 
              <th><?php echo trans('admin.product_type'); ?></th>
              <th><?php echo trans('admin.product_price'); ?></th>
              <th><?php echo trans('admin.product_status'); ?></th>
              <th><?php echo trans('admin.vendor_name_label'); ?></th> 
               <th><?php echo trans('Front-Back'); ?></th>
              <th><?php echo trans('admin.action'); ?></th>
            </tr>
          </thead>
          <tbody>
            <?php if($product_all_data->count() > 0): ?>  
              <?php $__currentLoopData = $product_all_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <tr>
                <?php if(!empty($row->image_url)): ?>
                  <td><img src="<?php echo e(get_image_url($row->image_url)); ?>" alt="<?php echo e(basename ($row->image_url)); ?>"></td>
                <?php else: ?>
                  <td><img src="<?php echo e(default_placeholder_img_src()); ?>" alt=""></td>
                <?php endif; ?>

                <td><?php echo $row->title; ?></td>

                <td><?php echo $row->sku; ?></td>

                <?php if($row->type == 'simple_product'): ?>
                  <td><?php echo trans('admin.simple_product'); ?></td>
                <?php elseif($row->type == 'configurable_product'): ?>
                  <td><?php echo trans('admin.configurable_product'); ?></td>
                <?php elseif($row->type == 'downloadable_product'): ?>  
                  <td><?php echo trans('admin.downloadable_product'); ?></td>
                <?php else: ?>
                  <td><?php echo trans('admin.customizable_product'); ?></td>
                <?php endif; ?>

                <td><?php echo price_html( $row->price ); ?></td>

                <?php if($row->status == 1): ?>
                <td><?php echo trans('admin.enable'); ?></td>
                <?php else: ?>
                <td><?php echo trans('admin.disable'); ?></td>
                <?php endif; ?>
                
                <td><?php echo get_vendor_name( $row->author_id ); ?></td>
<!--                 
                <?php if($row['fb'] == 0): ?>
                <td><?php echo trans('Front End'); ?></td>
                <?php else: ?>
                <td><?php echo trans('Back End'); ?></td>
                <?php endif; ?> -->

                <?php if($row['pfb'] ==1): ?>
                <td><?php echo trans('Backend Product'); ?></td>
                <?php else: ?>
                <td><?php echo trans('Frontend Product'); ?></td>
                <?php endif; ?>
                <td>
                  <div class="btn-group">
                    <button class="btn btn-success btn-flat" type="button"><?php echo trans('admin.action'); ?></button>
                    <button data-toggle="dropdown" class="btn btn-success btn-flat dropdown-toggle" type="button">
                      <span class="caret"></span>
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul role="menu" class="dropdown-menu">
                      <li><a target="_blank" href="<?php echo e(route( 'details-page', $row->slug )); ?>"><i class="fa fa-edit"></i><?php echo trans('admin.view'); ?></a></li>
                      <?php if(in_array('add_edit_delete_product', $user_permission_list)): ?> 
                        <li><a href="<?php echo e(route('admin.update_product', $row->slug)); ?>"><i class="fa fa-edit"></i><?php echo trans('admin.edit'); ?></a></li>
                      <?php endif; ?>
                      <?php if(in_array('add_edit_delete_product', $user_permission_list)): ?> 
                        <li><a class="remove-selected-data-from-list" data-track_name="product_list" data-id="<?php echo e($row->id); ?>" href="#"><i class="fa fa-remove"></i><?php echo trans('admin.delete'); ?></a></li>
                      <?php endif; ?>
                    </ul>
                  </div>
                </td>
              </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
              <tr><td colspan="8"><i class="fa fa-exclamation-triangle"></i> <?php echo trans('admin.no_data_found_label'); ?></td></tr>
            <?php endif; ?>
          </tbody>
          <tfoot>
            <tr>
              <th><?php echo trans('admin.product_image'); ?></th>
              <th><?php echo trans('admin.product_name'); ?></th>
              <th><?php echo trans('admin.product_sku'); ?></th>
              <th><?php echo trans('admin.product_type'); ?></th>
              <th><?php echo trans('admin.product_price'); ?></th>
              <th><?php echo trans('admin.product_status'); ?></th>
              <th><?php echo trans('admin.vendor_name_label'); ?></th>
              <th><?php echo trans('Front-Back'); ?></th>
              <th><?php echo trans('admin.action'); ?></th>
            </tr>
          </tfoot>
        </table>
        <div class="products-pagination"><?php echo $product_all_data->appends(Request::capture()->except('page'))->render(); ?></div>  
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>