@if (Session::has('error-message'))
  <div class="alert alert-danger">
    {{ Session::get('error-message') }}
  </div>
@endif