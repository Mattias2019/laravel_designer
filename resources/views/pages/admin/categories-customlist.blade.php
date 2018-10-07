@extends('layouts.admin.master')
@if(Request::is('admin/product/categories/customlist'))
  @section('title', trans('admin.product_categories_list') .' < '. get_site_title())
@elseif(Request::is('admin/blog/categories/list'))
  @section('title', trans('admin.blog_categories_list') .' < '. get_site_title())
@endif

@section('content')
<div class="row">
  <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
    <h4>{!! trans('Categories List') !!}</h4>
  </div>
  <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
    <div class="pull-right">
      <button data-toggle="modal" data-target="#addDynamicCategories" class="btn btn-primary custom-event" type="button">{!! trans('Add New CustomCategory') !!}</button>
    </div>  
  </div>
</div>

<div class="modal fade" id="addDynamicCategories" tabindex="-1" role="dialog" aria-labelledby="updater" aria-hidden="true">
  <div class="modal-dialog add-cat-dialog">
    <div class="ajax-overlay"></div>
    
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">✕</button>
        <br>
        <i class="icon-credit-card icon-7x"></i>
        <p class="no-margin"><b>{!! trans('Add New CustomCategory') !!}</b></p>
      </div>
      <div class="modal-body">
        <div class="custom-model-row">
          <div class="custom-input-group">
            <div class="custom-input-label"><label for="inputCatName">{!! trans('admin.name') !!}</label></div>
            <div class="custom-input-element"><input type="text" placeholder="{{ trans('admin.category_name') }}" id="inputCatName" name="inputCatName" class="form-control"></div>
          </div>

          <div class="custom-input-group">
            <div class="custom-input-label"><label for="inputCatSlug">{!! trans('admin.slug') !!}</label></div>
            <div class="custom-input-element"><input type="text" placeholder="{{ trans('admin.enter_unique_slug_name') }}" id="inputCatSlug" name="inputCatSlug" class="form-control">
            </div>
          </div>

          <!-- 900 -->
          <div class="custom-input-element"><input type="hidden" name="inputCatFb" id="inputCatFb" value="1"></div>
          <div class="custom-input-group">
            <div class="custom-input-label"><label for="inputCatParent">{!! trans('admin.parent') !!}</label></div>
            <div class="custom-input-element">
              <select name="cat_parent" id="cat_parent" class="form-control select2" style="width: 100%;">
                <option value="0">{!! trans('admin.none') !!}</option>
                @if(count($only_cat_name)>0)
                  @foreach($only_cat_name as $row)
                    <option value="{{ $row['id'] }}"> {!! $row['name'] !!} </option>
                  @endforeach
                @endif
              </select>
            </div>
          </div>
          <div class="custom-input-group">
            <div class="custom-input-label"><label for="inputCatDescription">{!! trans('admin.description') !!}</label></div>
            <div class="custom-input-element">
              <textarea class="form-control" name="inputCatDescription" id="inputCatDescription" placeholder="{{ trans('admin.description') }}"></textarea>
            </div>
          </div>
          <div class="custom-input-group">
            <div class="custom-input-label"><label for="inputCatStatus">{!! trans('admin.status') !!}</label></div>
            <div class="custom-input-element">
              <select name="cat_status" id="cat_status" class="form-control select2" style="width: 100%;">
                <option value="1">{!! trans('admin.enable') !!}</option>
                <option value="0">{!! trans('admin.disable') !!}</option>
              </select>
            </div>
          </div>
          <div class="custom-input-group">
            <div class="custom-input-label"><label for="inputCatThumbnail">{!! trans('admin.thumbnail') !!}</label></div>
            <div class="custom-input-element">
              <div class="uploadform dropzone no-margin dz-clickable upload-cat-img" id="upload_cat_img" name="upload_cat_img">
                <div class="dz-default dz-message">
                  <span>{!! trans('admin.drop_your_cover_picture_here') !!}</span>
                </div>
              </div>
              <br>
              <div class="cat-img-content">
                <div class="cat-sample-img"><img class="img-responsive" src="{{ default_upload_sample_img_src() }}" alt=""></div>
                <div class="cat-img"><img class="img-responsive" src="" alt=""></div>
                <br>
                <div class="cat-img-upload-btn">
                  <button type="button" class="btn btn-default attachtopost remove-cat-img">{!! trans('admin.remove_image') !!}</button>
                </div>
              </div>
            </div>
          </div>
        </div>     
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger attachtopost create-cat">{!! trans('Create CustomCategory') !!}</button>
        <button type="button" class="btn btn-danger attachtopost" data-dismiss="modal">{!! trans('admin.close') !!}</button>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-body">
        <div id="table_search_option">
          <form action="{{ $action }}" method="GET"> 
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="input-group">
                  <input type="text" name="term_cat" class="search-query form-control" placeholder="{{ trans('admin.cat_search_placeholder') }}" value="{{ $search_value }}" />
                  <div class="input-group-btn">
                    <button class="btn btn-primary" type="submit">
                      <span class="glyphicon glyphicon-search"></span>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </form>  
        </div>  
        <table class="table table-striped table-bordered dt-responsive nowrap admin-data-table" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th>{!! trans('admin.image') !!}</th>
              <th>{!! trans('admin.name') !!}</th>
              <th>{!! trans('admin.category_type') !!}</th>
              <th>{!! trans('admin.status') !!}</th>
              <th>{!! trans('Front-Back') !!}</th>
              <th>{!! trans('admin.action') !!}</th>
            </tr>
          </thead>
          <tbody>
            @if(count($cat_list_data)>0)
              @foreach($cat_list_data as $row)
              <tr>
                @if(!empty($row['category_img_url']))
                <td><img src="{{ get_image_url( $row['category_img_url'] ) }}" alt="{{ basename ($row['category_img_url']) }}"></td>
                @else
                <td><img src="{{ default_placeholder_img_src() }}" alt=""></td>
                @endif

                <td>{!! $row['name'] !!}</td>

                @if($row['parent'] == 0)
                <td>{!! trans('admin.parent_category') !!}</td>
                @else
                <td>{!! trans('admin.sub_category') !!}</td>
                @endif

                @if($row['status'] == 1)
                <td>{!! trans('admin.enable') !!}</td>
                @else
                <td>{!! trans('admin.disable') !!}</td>
                @endif
                
                @if($row['fb'] == 0)
                <td>{!! trans('Front End') !!}</td>
                @else
                <td>{!! trans('Back End') !!}</td>
                @endif

                <td>
                  <div class="btn-group">
                    <button class="btn btn-success btn-flat" type="button">{!! trans('admin.action') !!}</button>
                    <button data-toggle="dropdown" class="btn btn-success btn-flat dropdown-toggle" type="button">
                      <span class="caret"></span>
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul role="menu" class="dropdown-menu">
                      <li><a href="#" class="edit-data" data-track_name="cat_list" data-id="{{ $row['term_id'] }}"><i class="fa fa-edit"></i>{!! trans('admin.edit') !!}</a></li>
                      <li><a class="remove-selected-data-from-list" data-track_name="cat_list" data-id="{{ $row['term_id'] }}" href="#"><i class="fa fa-remove"></i>{!! trans('admin.delete') !!}</a></li>
                    </ul>
                  </div>
                </td>
              </tr>
              @endforeach
            @else
            <tr><td colspan="5"><i class="fa fa-exclamation-triangle"></i> {!! trans('admin.no_data_found_label') !!}</td></tr>
            @endif
          </tbody>
          <tfoot>
            <tr>
              <th>{!! trans('admin.image') !!}</th>
              <th>{!! trans('admin.name') !!}</th>
              <th>{!! trans('admin.category_type') !!}</th>
              <th>{!! trans('admin.status') !!}</th>
              <th>{!! trans('Front-Back') !!}</th>
              <th>{!! trans('admin.action') !!}</th>
            </tr>
          </tfoot>
        </table>
        <div class="products-pagination">{!! $cat_list_data->appends(Request::capture()->except('page'))->render() !!}</div>
      </div>
    </div>
  </div>
</div>

<div class="eb-overlay"></div>
<div class="eb-overlay-loader"></div>

<input type="hidden" name="hf_from_model" id="hf_from_model" value="">
<input type="hidden" name="hf_update_id" id="hf_update_id" value="">

@if(Request::is('admin/product/categories/customlist'))
<input type="hidden" name="hf_cat_post_for" id="hf_cat_post_for" value="product_cat">
@elseif(Request::is('admin/blog/categories/list'))
<input type="hidden" name="hf_cat_post_for" id="hf_cat_post_for" value="blog_cat">
@endif

@endsection