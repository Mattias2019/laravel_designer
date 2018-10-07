@if (Session::has('success-message'))
  <div class="alert alert-success">
    {{ Session::get('success-message') }}
  </div>
@endif