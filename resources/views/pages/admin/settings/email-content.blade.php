@extends('layouts.admin.master')
@section('title', trans('admin.email_content_label') .' < '. get_site_title())

@section('content')
<div id="email_details_content">
  @if(Request::is('admin/settings/emails/details/new-order'))
    @include('pages.admin.settings.email-new-order-content')
  @elseif(Request::is('admin/settings/emails/details/cancelled-order'))
    @include('pages.admin.settings.email-order-cancelled-content')
  @elseif(Request::is('admin/settings/emails/details/processing-order'))
    @include('pages.admin.settings.email-order-processing-content')
  @elseif(Request::is('admin/settings/emails/details/completed-order'))
    @include('pages.admin.settings.email-order-completed-content')
  @elseif(Request::is('admin/settings/emails/details/user-new-account'))
    @include('pages.admin.settings.email-new-user-account-content')
  @elseif(Request::is('admin/settings/emails/details/vendor-new-account'))
    @include('pages.admin.settings.email-vendor-new-account-content')  
  @elseif(Request::is('admin/settings/emails/details/vendor-activation'))
    @include('pages.admin.settings.email-vendor-account-activation-content')   
  @elseif(Request::is('admin/settings/emails/details/withdraw-request'))
    @include('pages.admin.settings.email-withdraw-request-content')
  @elseif(Request::is('admin/settings/emails/details/withdraw-cancelled'))
    @include('pages.admin.settings.email-withdraw-request-cancelled-content')  
  @elseif(Request::is('admin/settings/emails/details/withdraw-completed'))
    @include('pages.admin.settings.email-withdraw-request-completed-content')  
  @endif
</div>
@endsection