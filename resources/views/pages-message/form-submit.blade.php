@if (count($errors) > 0)
  <div class="alert alert-danger">
    <strong>{{ trans('validation.whoops') }} </strong> {{ trans('validation.input_error') }}<br /><br />
    <ul>
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif