@extends('layouts.admin.master')
@section('title', trans('admin.vendors_package_list_label') .' < '. get_site_title())

@section('content')
<div class="row">
  <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
    <h4>{!! trans('admin.vendors_package_list_label') !!}</h4>
  </div>
  <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
    <div class="pull-right">
      <a href="{{ route('admin.vendors_packages_create_content') }}" class="btn btn-primary pull-right">{!! trans('admin.create_vendors_package_label') !!}</a>
    </div>  
  </div>
</div>

<div class="row">
  <div class="col-xs-12">
    <div class="box box-solid">
      <div class="box-body">
        <table id="table_for_products_list" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>{!! trans('admin.vendor_package_title_label') !!}</th>
              <th>{!! trans('admin.created_date_label') !!}</th>
              <th>{!! trans('admin.action') !!}</th>
            </tr>
          </thead>
          <tbody>
            @if(count($vendors_packages) > 0)  
              @foreach($vendors_packages as $row)
              <tr>
                <td>{!! $row['package_type'] !!}</td>
                <td>{{ Carbon\Carbon::parse(  $row['created_at'] )->format('d, M Y') }}</td>
                <td>
                  <div class="btn-group">
                    <button class="btn btn-success btn-flat" type="button">{!! trans('admin.action') !!}</button>
                    <button data-toggle="dropdown" class="btn btn-success btn-flat dropdown-toggle" type="button">
                      <span class="caret"></span>
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul role="menu" class="dropdown-menu">
                      <li><a data-title="{{ $row['package_type'] }}" data-package_details="{{ $row['options'] }}" class="vendor-package-details" href="#"><i class="fa fa-eye"></i>{!! trans('admin.view') !!}</a></li>
                      <li><a href="{{ route('admin.vendors_packages_update_content', $row['id']) }}"><i class="fa fa-edit"></i>{!! trans('admin.edit') !!}</a></li>
                      <li><a class="remove-selected-data-from-list" data-track_name="vendor_packages_list" data-id="{{ $row['id'] }}" href="#"><i class="fa fa-remove"></i>{!! trans('admin.delete') !!}</a></li>
                    </ul>
                  </div>
                </td>
              </tr>
              @endforeach
            @else
            <tr><td colspan="3"><i class="fa fa-exclamation-triangle"></i> {!! trans('admin.no_data_found_label') !!}</td></tr>  
            @endif
          </tbody>
          <tfoot>
            <tr>
              <th>{!! trans('admin.vendor_package_title_label') !!}</th>
              <th>{!! trans('admin.created_date_label') !!}</th>
              <th>{!! trans('admin.action') !!}</th>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="vendorPackageDetails" tabindex="-1" role="dialog" aria-labelledby="updater" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">✕</button>
        <br>
        <i class="icon-credit-card icon-7x"></i>
        <h3 class="no-margin">{!! trans('admin.vendor_package_details_label') !!}</h3>
      </div>
      <div class="modal-body">             
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default attachtopost" data-dismiss="modal">{!! trans('admin.close') !!}</button>
      </div>
    </div>
  </div>
</div>
@endsection