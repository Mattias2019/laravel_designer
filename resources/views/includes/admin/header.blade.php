<header class="main-header">
  <div class="logo">
    <a target="_blank" title="{{ trans('admin.view_online_store') }}" href="{{ route('home-page') }}"><i class="fa fa-shopping-cart" aria-hidden="true"></i> {!! trans('admin.view_online_store') !!}</a>
  </div>
                            
  <nav class="navbar navbar-static-top" role="navigation">
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            @if(!empty($user_data['user_photo_url']))
              <img src="{{ get_image_url($user_data['user_photo_url']) }}" class="user-image" alt=""/>
            @else
              <img src="{{ default_avatar_img_src() }}" class="user-image" alt=""/>
            @endif
            <span class="hidden-xs">{!! $user_data['user_display_name'] !!}</span>
          </a>
          <ul class="dropdown-menu">
            <li class="user-header">
              @if(!empty($user_data['user_photo_url']))
                <img src="{{ get_image_url($user_data['user_photo_url']) }}" class="user-image" alt=""/>
              @else
                <img src="{{ default_avatar_img_src() }}" class="user-image" alt=""/>
              @endif
              <p>
                {!! $user_data['user_display_name'] !!}
                <small>{!! $user_data['user_role'] !!}</small>
              </p>
            </li>

            <li class="user-footer">
              @if(isset($user_data['user_role_slug']) && $user_data['user_role_slug'] == 'administrator')  
                <div class="pull-left">
                  <a href="{{ route('admin.user_profile') }}" class="btn btn-default btn-flat">{{ trans('admin.profile') }}</a>
                </div>
              @endif
              <form method="post" action="{{ route('admin.logout') }}" enctype="multipart/form-data">
                <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                <div class="pull-right">
                  <button type="submit" class="btn btn-default btn-flat">{!! trans('admin.sign_out') !!}</button>
                </div>
              </form>    
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
</header>