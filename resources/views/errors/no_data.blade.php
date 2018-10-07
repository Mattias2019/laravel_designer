<!DOCTYPE html>
<html>
  <head>
    <title>{!! trans('frontend.no_data_page_title') !!}</title>

    <link href="//fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ URL::asset('public/frontend/css/bootstrap.min.css') }}" />
    <script type="text/javascript" src="{{ URL::asset('public/jquery/jquery-1.10.2.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('public/frontend/js/bootstrap.min.js') }}"></script>
    <style>
      body{
        #CDD6DF
      }
      .title {
        background: #fff none repeat scroll 0 0;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.13);
        color: #444;
        margin: 50px auto;
        padding: 1em 2em;
        width: 40%;
      }
      .title p{
        font-size: 14px;
        line-height: 1.5;
        margin: 25px 0 20px;
      }
    </style>
  </head>
  <body>
    <br>
    <div class="container">
      <div class="content">
        <div class="alert alert-danger">
          <p>{!! trans('frontend.no_data_available') !!}</p>
        </div>
      </div>
    </div>
  </body>
</html>
