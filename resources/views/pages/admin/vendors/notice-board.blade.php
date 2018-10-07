@extends('layouts.admin.master')
@section('title', trans('admin.notice_board_label') .' < '. get_site_title())

@section('content')
<div id="vendor_notice_board">
  <h4><i class="fa fa-bullhorn"></i> &nbsp;{!! trans('admin.all_notice_label') !!}</h4><hr class="title-separator">
  <div class="vendor-notice-board-content">
    @if(!empty($vendor_all_notice) && $vendor_all_notice->count() > 0) 
      @foreach($vendor_all_notice as $notice)
      <div class="row">
        <div class="col-sm-12 col-md-12">
          <div class="alert alert-success fade in alert-dismissable" style="margin-top:18px;">
            <div class="close" data-dismiss="alert" aria-label="close" title="close"><i class="fa fa-close"></i></div>
            <div class="announce-content">
              <div class="clearfix">
                <div class="announce-date-content">
                  <div class="announce-day">{!! Carbon\Carbon::parse(  $notice->created_at )->format('d') !!}</div>
                  <div class="announce-month">{!! Carbon\Carbon::parse(  $notice->created_at )->format('F') !!}</div>
                  <div class="announce-year">{!! Carbon\Carbon::parse(  $notice->created_at )->format('Y') !!}</div>
                </div>
                <div class="announce-single-content">
                  <div class="single-title">{!! $notice->post_title !!}</div>
                  <div class="single-content">{!! get_limit_string(string_decode($notice->post_content), 200) !!}</div>
                </div>
                <div class="clearfix">
                  <div class="pull-right"><a class="notice-read-more-label btn btn-default btn-sm" href="{{ route('admin.vendor_notice_board_single_content_details', $notice->post_slug) }}">{!! trans('admin.read_more_label') !!}</a></div>
                </div>  
              </div>  
            </div>
          </div>
        </div>
      </div>
      @endforeach
      <div class="products-pagination">{!! $vendor_all_notice->appends(Request::capture()->except('page'))->render() !!}</div>
    @else
    <p>{!! trans('admin.no_notice_label') !!}</p>
    @endif
  </div>
</div>
@endsection