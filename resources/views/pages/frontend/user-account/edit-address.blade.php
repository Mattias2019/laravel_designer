<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
  <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
  <input type="hidden" name="_account_post_type" value="address">
  
  <div class="row">
    <div class="col-md-12">
      @include('pages-message.form-submit')
    </div>
  </div>  
  
  <div class="row">
    <div class="col-md-12">
      <h4><label>{{ trans('frontend.billing_address') }}</label></h4><hr>
      <div class="form-group">
        <div class="col-sm-4">
          <label class="control-label" for="inputAccountTitle">{{ trans('frontend.account_title') }}</label>
        </div>
        <div class="col-sm-8">
          <input type="text" class="form-control" placeholder="{{ trans('frontend.title') }}" name="account_bill_title" id="account_bill_title" value="{{ $frontend_account_details->address_details->account_bill_title }}">
        </div>
      </div>

      <div class="form-group">
        <div class="col-sm-4">
          <label class="control-label" for="inputAccountCompanyName">{{ trans('frontend.account_company_name') }}</label>
        </div>
        <div class="col-sm-8">
          <input type="text" class="form-control" placeholder="{{ trans('frontend.company_name') }}" name="account_bill_company_name" id="account_bill_company_name" value="{{ $frontend_account_details->address_details->account_bill_company_name }}">
        </div>
      </div>
      
      <div class="form-group required">
        <div class="col-sm-4">
          <label class="control-label" for="inputAccountFirstName">{{ trans('frontend.account_first_name') }}</label>
        </div>
        <div class="col-sm-8">
          <input type="text" class="form-control" placeholder="{{ trans('frontend.first_name') }}" name="account_bill_first_name" id="account_bill_first_name" value="{{ $frontend_account_details->address_details->account_bill_first_name }}">
        </div>
      </div>
      
      <div class="form-group required">
        <div class="col-sm-4">
          <label class="control-label" for="inputAccountLastName">{{ trans('frontend.account_last_name') }}</label>
        </div>
        <div class="col-sm-8">
          <input type="text" class="form-control" placeholder="{{ trans('frontend.last_name') }}" name="account_bill_last_name" id="account_bill_last_name" value="{{ $frontend_account_details->address_details->account_bill_last_name }}">
        </div>
      </div>
      
      <div class="form-group required">
        <div class="col-sm-4">
          <label class="control-label" for="inputAccountEmailAddress">{{ trans('frontend.account_email') }}</label>
        </div>
        <div class="col-sm-8">
          <input type="email" class="form-control" placeholder="{{ trans('frontend.email') }}" name="account_bill_email_address" id="account_bill_email_address" value="{{ $frontend_account_details->address_details->account_bill_email_address }}">
        </div>
      </div>
      
      <div class="form-group">
        <div class="col-sm-4">
          <label class="control-label" for="inputAccountPhoneNumber">{{ trans('frontend.account_phone_number') }}</label>
        </div>
        <div class="col-sm-8">
          <input type="number" class="form-control" placeholder="{{ trans('frontend.phone') }}" name="account_bill_phone_number" id="account_bill_phone_number" value="{{ $frontend_account_details->address_details->account_bill_phone_number }}">
        </div>
      </div>
      
      <div class="form-group required">
        <div class="col-sm-4">
          <label class="control-label" for="inputAccountSelectCountry">{{ trans('frontend.account_select_country') }}</label>
        </div>
        <div class="col-sm-8">
          <select class="form-control" id="account_bill_select_country" name="account_bill_select_country">
            <option value=""> {{ trans('frontend.select_country') }} </option>
            @foreach(get_country_list() as $key => $val)
              @if($frontend_account_details->address_details->account_bill_select_country == $key)
                <option selected value="{{ $key }}"> {!! $val !!}</option>
              @else
                <option value="{{ $key }}"> {!! $val !!}</option>
              @endif
            @endforeach
           </select>
        </div>
      </div>
      
      <div class="form-group required">
        <div class="col-sm-4">
          <label class="control-label" for="inputAccountAddressLine1">{{ trans('frontend.account_address_line_1') }}</label>
        </div>
        <div class="col-sm-8">
          <textarea class="form-control" id="account_bill_adddress_line_1" name="account_bill_adddress_line_1" placeholder="{{ trans('frontend.address_line_1') }}"> {{ $frontend_account_details->address_details->account_bill_adddress_line_1 }} </textarea>
        </div>
      </div>
      
      <div class="form-group">
        <div class="col-sm-4">
          <label class="control-label" for="inputAccountAddressLine2">{{ trans('frontend.account_address_line_2') }}</label>
        </div>
        <div class="col-sm-8">
          <textarea class="form-control" id="account_bill_adddress_line_2" name="account_bill_adddress_line_2" placeholder="{{ trans('frontend.address_line_2') }}"> {{ $frontend_account_details->address_details->account_bill_adddress_line_2 }} </textarea>
        </div>
      </div>
      
      <div class="form-group required">
        <div class="col-sm-4">
          <label class="control-label" for="inputAccountTownCity">{{ trans('frontend.account_address_town_city') }}</label>
        </div>
        <div class="col-sm-8">
          <input type="text" class="form-control" placeholder="{{ trans('frontend.town_city') }}" name="account_bill_town_or_city" id="account_bill_town_or_city" value="{{ $frontend_account_details->address_details->account_bill_town_or_city }}">
        </div>
      </div>
      
      <div class="form-group required">
        <div class="col-sm-4">
          <label class="control-label" for="inputAccountZipPostalCode">{{ trans('frontend.account_address_zip_postal_code') }}</label>
        </div>
        <div class="col-sm-8">
          <input type="number" class="form-control" placeholder="{{ trans('frontend.zip_postal_code') }}" name="account_bill_zip_or_postal_code" id="account_bill_zip_or_postal_code" value="{{ $frontend_account_details->address_details->account_bill_zip_or_postal_code }}">
        </div>
      </div>
      
      <div class="form-group">
        <div class="col-sm-4">
          <label class="control-label" for="inputAccountFaxNumber">{{ trans('frontend.account_fax_number') }}</label>
        </div>
        <div class="col-sm-8">
          <input type="number" class="form-control" placeholder="{{ trans('frontend.fax') }}" name="account_bill_fax_number" id="account_bill_fax_number" value="{{ $frontend_account_details->address_details->account_bill_fax_number }}">
        </div>
      </div>
      
    </div>
  </div>
  
  <br>
  
  <div class="row">
    <div class="col-md-12">
      <h4><label>{{ trans('frontend.shipping_address') }}</label></h4><hr>
      <div class="form-group">
        <div class="col-sm-4">
          <label class="control-label" for="inputAccountTitle">{{ trans('frontend.account_title') }}</label>
        </div>
        <div class="col-sm-8">
          <input type="text" class="form-control" placeholder="{{ trans('frontend.title') }}" name="account_shipping_title" id="account_shipping_title" value="{{ $frontend_account_details->address_details->account_shipping_title }}">
        </div>
      </div>

      <div class="form-group">
        <div class="col-sm-4">
          <label class="control-label" for="inputAccountCompanyName">{{ trans('frontend.account_company_name') }}</label>
        </div>
        <div class="col-sm-8">
          <input type="text" class="form-control" placeholder="{{ trans('frontend.company_name') }}" name="account_shipping_company_name" id="account_shipping_company_name" value="{{ $frontend_account_details->address_details->account_shipping_company_name }}">
        </div>
      </div>
      
      <div class="form-group required">
        <div class="col-sm-4">
          <label class="control-label" for="inputAccountFirstName">{{ trans('frontend.account_first_name') }}</label>
        </div>
        <div class="col-sm-8">
          <input type="text" class="form-control" placeholder="{{ trans('frontend.first_name') }}" name="account_shipping_first_name" id="account_shipping_first_name" value="{{ $frontend_account_details->address_details->account_shipping_first_name }}">
        </div>
      </div>
      
      <div class="form-group required">
        <div class="col-sm-4">
          <label class="control-label" for="inputAccountLastName">{{ trans('frontend.account_last_name') }}</label>
        </div>
        <div class="col-sm-8">
          <input type="text" class="form-control" placeholder="{{ trans('frontend.last_name') }}" name="account_shipping_last_name" id="account_shipping_last_name" value="{{ $frontend_account_details->address_details->account_shipping_last_name }}">
        </div>
      </div>
      
      <div class="form-group required">
        <div class="col-sm-4">
          <label class="control-label" for="inputAccountEmailAddress">{{ trans('frontend.account_email') }}</label>
        </div>
        <div class="col-sm-8">
          <input type="email" class="form-control" placeholder="{{ trans('frontend.email') }}" name="account_shipping_email_address" id="account_shipping_email_address" value="{{ $frontend_account_details->address_details->account_shipping_email_address }}">
        </div>
      </div>
      
      <div class="form-group">
        <div class="col-sm-4">
          <label class="control-label" for="inputAccountPhoneNumber">{{ trans('frontend.account_phone_number') }}</label>
        </div>
        <div class="col-sm-8">
          <input type="number" class="form-control" placeholder="{{ trans('frontend.phone') }}" name="account_shipping_phone_number" id="account_shipping_phone_number" value="{{ $frontend_account_details->address_details->account_shipping_phone_number }}">
        </div>
      </div>
      
      <div class="form-group required">
        <div class="col-sm-4">
          <label class="control-label" for="inputAccountSelectCountry">{{ trans('frontend.account_select_country') }}</label>
        </div>
        <div class="col-sm-8">
          <select class="form-control" id="account_shipping_select_country" name="account_shipping_select_country">
            <option value=""> {{ trans('frontend.select_country') }} </option>
            @foreach(get_country_list() as $key => $val)
              @if($frontend_account_details->address_details->account_shipping_select_country == $key)
                <option selected value="{{ $key }}"> {!! $val !!}</option>
              @else
                <option value="{{ $key }}"> {!! $val !!}</option>
              @endif
            @endforeach
           </select>
        </div>
      </div>
      
      <div class="form-group required">
        <div class="col-sm-4">
          <label class="control-label" for="inputAccountAddressLine1">{{ trans('frontend.account_address_line_1') }}</label>
        </div>
        <div class="col-sm-8">
          <textarea class="form-control" id="account_shipping_adddress_line_1" name="account_shipping_adddress_line_1" placeholder="{{ trans('frontend.address_line_1') }}">{{ $frontend_account_details->address_details->account_shipping_adddress_line_1 }}</textarea>
        </div>
      </div>
      
      <div class="form-group">
        <div class="col-sm-4">
          <label class="control-label" for="inputAccountAddressLine2">{{ trans('frontend.account_address_line_2') }}</label>
        </div>
        <div class="col-sm-8">
          <textarea class="form-control" id="account_shipping_adddress_line_2" name="account_shipping_adddress_line_2" placeholder="{{ trans('frontend.address_line_2') }}">{{ $frontend_account_details->address_details->account_shipping_adddress_line_2 }}</textarea>
        </div>
      </div>
      
      <div class="form-group required">
        <div class="col-sm-4">
          <label class="control-label" for="inputAccountTownCity">{{ trans('frontend.account_address_town_city') }}</label>
        </div>
        <div class="col-sm-8">
          <input type="text" class="form-control" placeholder="{{ trans('frontend.town_city') }}" name="account_shipping_town_or_city" id="account_shipping_town_or_city" value="{{ $frontend_account_details->address_details->account_shipping_town_or_city }}">
        </div>
      </div>
      
      <div class="form-group required">
        <div class="col-sm-4">
          <label class="control-label" for="inputAccountZipPostalCode">{{ trans('frontend.account_address_zip_postal_code') }}</label>
        </div>
        <div class="col-sm-8">
          <input type="number" class="form-control" placeholder="{{ trans('frontend.zip_postal_code') }}" name="account_shipping_zip_or_postal_code" id="account_shipping_zip_or_postal_code" value="{{ $frontend_account_details->address_details->account_shipping_zip_or_postal_code }}">
        </div>
      </div>
      
      <div class="form-group">
        <div class="col-sm-4">
          <label class="control-label" for="inputAccountFaxNumber">{{ trans('frontend.account_fax_number') }}</label>
        </div>
        <div class="col-sm-8">
          <input type="number" class="form-control" placeholder="{{ trans('frontend.fax') }}" name="account_shipping_fax_number" id="account_shipping_fax_number" value="{{ $frontend_account_details->address_details->account_shipping_fax_number }}">
        </div>
      </div>
      
    </div>
  </div>
  
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
      <div class="text-right">
          <button type="submit" class="btn btn-primary btn-sm">{{ trans('frontend.update_address') }}</button>
      </div>
    </div>
  </div>
 
</form>