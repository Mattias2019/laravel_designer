<!doctype html>
<html>
<head>
    @include('includes.admin.head')
</head>
<body id="admin_panel" class="skin-blue sidebar-mini wysihtml5-supported">
  <div class="wrapper">
    @include('includes.admin.header')
    @include('includes.admin.sidebar')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content-header">
        @yield('content-header')
      </section>
      <section class="content">
        @yield('content')
      </section>
    </div><!-- /.content-wrapper -->
    <input type="hidden" name="hf_base_url" id="hf_base_url" value="{{ url('/') }}">
    <input type="hidden" name="admin_all_msg_with_localization" id="admin_all_msg_with_localization" value="{{  $admin_js_localization  }}">
  </div><!-- ./wrapper -->
</body>
</html>