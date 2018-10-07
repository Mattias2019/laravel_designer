@section('vendors-comments-list-content')
<div class="box box-info">
  <div class="box-header">
    <h3 class="box-title">{!! trans('admin.comments_list') !!}</h3>
  </div>
</div>

<div class="row">
  <div class="col-xs-12">
    <div class="box box-solid">
      <div class="box-body">
        <table id="table_for_products_list" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>{!! trans('admin.user_image') !!}</th>
              <th>{!! trans('admin.user_display_name') !!}</th>
              <th>{!! trans('admin.vendor_name_label') !!}</th>
              <th>{!! trans('admin.user_contents') !!}</th>
              <th>{!! trans('admin.user_rating_val') !!}</th>
              <th>{!! trans('admin.comment_status') !!}</th>
              <th>{!! trans('admin.comment_added') !!}</th>
              <th>{!! trans('admin.action') !!}</th>
            </tr>
          </thead>
          <tbody>
            @if(count($vendor_comments) > 0)  
              @foreach($vendor_comments as $row)
              <tr>
                @if($row->user_photo_url)
                  <td><img src="{{ get_image_url($row->user_photo_url) }}" alt="{{ $row->user_photo_url }}"></td>
                @else
                  <td><img src="{{ default_placeholder_img_src() }}" alt=""></td>
                @endif

                <td>{!! $row->display_name !!}</td>
                <td>{!! $vendor_name !!}</td>
                <td>{!! $row->content !!}</td>
                <td>{!! $row->rating !!}</td>

                @if($row->status == 1)
                  <td>{!! trans('admin.enable') !!}</td>
                @else
                  <td>{!! trans('admin.disable') !!}</td>
                @endif

                <td>{{ Carbon\Carbon::parse(  $row->created_at )->format('d, M Y') }}</td>

                <td>
                  <div class="btn-group">
                    <button class="btn btn-success btn-flat" type="button">{!! trans('admin.action') !!}</button>
                    <button data-toggle="dropdown" class="btn btn-success btn-flat dropdown-toggle" type="button">
                      <span class="caret"></span>
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul role="menu" class="dropdown-menu">
                      @if($row->status == 1)
                        <li><a href="" class="comments-status-change" data-target="vendor" data-id="{{ $row->id }}" data-status="disable"><i class="fa fa-close"></i>{!! trans('admin.disable') !!}</a></li>
                      @else
                        <li><a href="" class="comments-status-change" data-target="vendor" data-id="{{ $row->id }}" data-status="enable"><i class="fa fa-check-circle"></i>{!! trans('admin.enable') !!}</a></li>
                      @endif
                      <li><a target="_blank" href="{{ route('store-reviews-page-content', $vendor_name) }}"><i class="fa fa-eye"></i>{!! trans('admin.view') !!}</a></li>
                      <li><a class="remove-selected-data-from-list" data-track_name="product_comments_list" data-id="{{ $row->id }}" href="#"><i class="fa fa-remove"></i>{!! trans('admin.delete') !!}</a></li>
                    </ul>
                  </div>
                </td>
              </tr>
              @endforeach
            @else
              <tr><td colspan="8"><i class="fa fa-exclamation-triangle"></i> {!! trans('admin.no_data_found_label') !!}</td></tr>  
            @endif
          </tbody>
          <tfoot>
            <tr>
              <th>{!! trans('admin.user_image') !!}</th>
              <th>{!! trans('admin.user_display_name') !!}</th>
              <th>{!! trans('admin.vendor_name_label') !!}</th>
              <th>{!! trans('admin.user_contents') !!}</th>
              <th>{!! trans('admin.user_rating_val') !!}</th>
              <th>{!! trans('admin.comment_status') !!}</th>
              <th>{!! trans('admin.comment_added') !!}</th>
              <th>{!! trans('admin.action') !!}</th>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection