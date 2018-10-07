<!DOCTYPE html>
<html>
    <head>
        <title>{!! trans('admin.vendor_expired_date_title') !!}</title>

        <link href="//fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                color:darkgray;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 52px;
                margin-top: 40px;
            }
        </style>
    </head>
    <body>
      <div class="container">
        <div class="content">
          <div class="title">{!! trans('admin.vendor_expired_date_over_error_msg') !!}</div>
        </div>
      </div>
    </body>
</html>