@extends('layouts.admin.master')
@section('title', trans('admin.notice_details_label') .' < '. get_site_title())

@section('content')
<div id="vendor_single_notice_details">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-solid">
        <div class="box-body">
          <h3>{!! $vendor_single_details->post_title !!}</h3>
          <p class="announce-date">{!! Carbon\Carbon::parse( $vendor_single_details->created_at )->format('d, F Y') !!}</p>
          <div class="announce-content">
            {!! string_decode($vendor_single_details->post_content) !!}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection