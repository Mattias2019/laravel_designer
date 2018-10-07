<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-12">
    @include('pages-message.notify-msg-success')
    
    <div class="text-right">
      @if(!empty($frontend_account_details) && !empty($frontend_account_details->address_details))
        <a href="{{ route('my-address-edit-page') }}" class="btn btn-primary btn-sm">{{ trans('frontend.edit_address') }}</a>
      @else
        <a href="{{ route('my-address-add-page') }}" class="btn btn-primary btn-sm">{{ trans('frontend.add_address') }}</a>
      @endif
    </div>
    
  </div>
</div><br>

<div class="row">
  <div class="col-xs-12 col-sm-6 col-md-6">
    <h4><label>{{ trans('frontend.billing_address') }}</label></h4><hr>
    
    <br>
    @if(!empty($frontend_account_details) && !empty($frontend_account_details->address_details))
      <p>{!! $frontend_account_details->address_details->account_bill_first_name .' '. $frontend_account_details->address_details->account_bill_last_name !!}</p>

      @if($frontend_account_details->address_details->account_bill_company_name)
        <p><strong>{{ trans('admin.company') }}:</strong> {!! $frontend_account_details->address_details->account_bill_company_name !!}</p>
      @endif

      <p><strong>{{ trans('admin.address_1') }}:</strong> {!! $frontend_account_details->address_details->account_bill_adddress_line_1 !!}</p>

      @if($frontend_account_details->address_details->account_bill_adddress_line_2)
        <p><strong>{{ trans('admin.address_2') }}:</strong> {!! $frontend_account_details->address_details->account_bill_adddress_line_2 !!}</p>
      @endif

      <p><strong>{{ trans('admin.city') }}:</strong> {!! $frontend_account_details->address_details->account_bill_town_or_city !!}</p>

      <p><strong>{{ trans('admin.postCode') }}:</strong> {!! $frontend_account_details->address_details->account_bill_zip_or_postal_code !!}</p>
      <p><strong>{{ trans('admin.country') }}:</strong> {!! get_country_by_code( $frontend_account_details->address_details->account_bill_select_country ) !!}</p>

      <br>

      @if($frontend_account_details->address_details->account_bill_phone_number)
        <p><strong>{{ trans('admin.phone') }}:</strong> {!! $frontend_account_details->address_details->account_bill_phone_number !!}</p>
      @endif


      @if($frontend_account_details->address_details->account_bill_fax_number)
        <p><strong>{{ trans('admin.fax') }}:</strong> {!! $frontend_account_details->address_details->account_bill_fax_number !!}</p>
      @endif

      <p><strong>{{ trans('admin.email') }}:</strong> {!! $frontend_account_details->address_details->account_bill_email_address !!}</p>
    
    @else
      <p>{{ trans('admin.billing_address_not_available') }}</p>
    @endif
        
  </div>
  <div class="col-xs-12 col-sm-6 col-md-6">
    <h4><label>{{ trans('frontend.shipping_address') }}</label></h4><hr>
    
    <br>
    @if(!empty($frontend_account_details) && !empty($frontend_account_details->address_details))
      <p>{!! $frontend_account_details->address_details->account_shipping_first_name .' '. $frontend_account_details->address_details->account_shipping_last_name !!}</p>

      @if($frontend_account_details->address_details->account_shipping_company_name)
        <p><strong>{{ trans('admin.company') }}:</strong> {!! $frontend_account_details->address_details->account_shipping_company_name !!}</p>
      @endif

      <p><strong>{{ trans('admin.address_1') }}:</strong> {!! $frontend_account_details->address_details->account_shipping_adddress_line_1 !!}</p>

      @if($frontend_account_details->address_details->account_shipping_adddress_line_2)
        <p><strong>{{ trans('admin.address_2') }}:</strong> {!! $frontend_account_details->address_details->account_shipping_adddress_line_2 !!}</p>
      @endif

      <p><strong>{{ trans('admin.city') }}:</strong> {!! $frontend_account_details->address_details->account_shipping_town_or_city !!}</p>

      <p><strong>{{ trans('admin.postCode') }}:</strong> {!! $frontend_account_details->address_details->account_shipping_zip_or_postal_code !!}</p>
      <p><strong>{{ trans('admin.country') }}:</strong> {!! get_country_by_code( $frontend_account_details->address_details->account_shipping_select_country ) !!}</p>

      <br>

      @if($frontend_account_details->address_details->account_shipping_phone_number)
        <p><strong>{{ trans('admin.phone') }}:</strong> {!! $frontend_account_details->address_details->account_shipping_phone_number !!}</p>
      @endif


      @if($frontend_account_details->address_details->account_shipping_fax_number)
        <p><strong>{{ trans('admin.fax') }}:</strong> {!! $frontend_account_details->address_details->account_shipping_fax_number !!}</p>
      @endif

      <p><strong>{{ trans('admin.email') }}:</strong> {!! $frontend_account_details->address_details->account_shipping_email_address !!}</p>
    
    @else
      <p>{{ trans('admin.shipping_address_not_available') }}</p>
    @endif
  </div>
</div>