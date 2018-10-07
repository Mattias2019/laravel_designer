@extends('layouts.frontend.master')
@section('title', trans('frontend.vendor_list_title_label') .' < '. get_site_title())

@section('content')
<div class="container">
  <div id="vendors_list">
    <div class="row">
      @if(count($vendors_list) > 0)
        @foreach($vendors_list as $vendor)
          @if($vendor->user_status == 1 && !is_vendor_expired($vendor->id))
            <?php $details = json_decode($vendor->details);?>
            <div class="col-xs-12 col-sm-6 col-md-4">
              <div class="vendors-list-content">
                <div class="vendors-list-header"></div>
                <div class="vendors-list-profile-image">
                  @if(!empty($vendor->user_photo_url))
                    <img src="{{ get_image_url($vendor->user_photo_url) }}">
                  @else
                    <img src="{{ default_placeholder_img_src() }}">
                  @endif
                </div>
                <div class="vendors-list-profile-details">
                  <div class="vendor-name"><h3><a href="{{ route('store-details-page-content', $vendor->name) }}">{!! $details->profile_details->store_name !!}</a></h3></div>
                  <div class="vendor-address">{!! $details->profile_details->address_line_1 !!}</div>
                  <div class="vendor-email"><strong>{!! trans('frontend.email_label') !!}:</strong> {!! $vendor->email !!}</div>
                  <div class="vendor-phone"><strong>{!! trans('frontend.phone') !!}:</strong> {!! $details->profile_details->phone !!}</div>
                  <div class="vendor-created"><strong>{!! trans('frontend.member_since_label') !!}:</strong> {!! Carbon\Carbon::parse(  $vendor->created_at )->format('F d, Y') !!}</div>
                </div>
                <div class="vendors-list-footer"><a href="{{ route('store-details-page-content', $vendor->name) }}">{!! trans('frontend.view_details') !!}</a></div>
              </div>
            </div>
          @endif
        @endforeach
      @else
      <br>
      <p>{!! trans('admin.no_store_label') !!}</p>
      @endif
    </div>
  </div>    
</div>    
@endsection 