@section('vendors-reviews-page-content')
<div id="vendor-reviews">
  <div class="product-reviews-content">
    <div class="rating-box clearfix">
      <div class="score-box">
        <div class="score">{{ $comments_rating_details['average'] }}</div>
        <div class="star-rating"><span style="width:{{ $comments_rating_details['percentage'] }}%"></span></div>
        <div class="total-users"><i class="fa fa-user"></i>&nbsp;<span class="total">{{ $comments_rating_details['total'] }}</span>&nbsp;{{ trans('frontend.totals_label') }}</div>
      </div>
      <div class="individual-score-graph">
        <ul>
          <li>
            <div class="rating-progress-content clearfix">
              <div class="individual-rating-score">
                <span><i class="fa fa-star"></i> 5</span>
              </div>
              <div class="individual-rating-progress">
                <div class="progress">
                  <div class="progress-bar progress-bar-five" role="progressbar" aria-valuenow="{{ $comments_rating_details[5] }}" aria-valuemin="0" aria-valuemax="100" style="width:{{ $comments_rating_details[5] }}%">
                      {!! $comments_rating_details[5] !!}%
                  </div>
                </div>
              </div>
            </div>
          </li>
          <li>
          <div class="rating-progress-content clearfix">
            <div class="individual-rating-score">
              <span><i class="fa fa-star"></i> 4</span>
            </div>
            <div class="individual-rating-progress">
              <div class="progress">
                <div class="progress-bar progress-bar-four" role="progressbar" aria-valuenow="{{ $comments_rating_details[4] }}" aria-valuemin="0" aria-valuemax="100" style="width:{{ $comments_rating_details[4] }}%">
                    {!! $comments_rating_details[4] !!}%
                </div>
              </div>
            </div>
          </div>
          </li>
          <li>
          <div class="rating-progress-content clearfix">
            <div class="individual-rating-score">
              <span><i class="fa fa-star"></i> 3</span>
            </div>
            <div class="individual-rating-progress">
              <div class="progress">
                <div class="progress-bar progress-bar-three" role="progressbar" aria-valuenow="{{ $comments_rating_details[3] }}" aria-valuemin="0" aria-valuemax="100" style="width:{{ $comments_rating_details[3] }}%">
                    {!! $comments_rating_details[3] !!}%
                </div>
              </div>
            </div>
          </div>
          </li>
          <li>
          <div class="rating-progress-content clearfix">
            <div class="individual-rating-score">
              <span><i class="fa fa-star"></i> 2</span>
            </div>
            <div class="individual-rating-progress">
              <div class="progress">
                <div class="progress-bar progress-bar-two" role="progressbar" aria-valuenow="{{ $comments_rating_details[2] }}" aria-valuemin="0" aria-valuemax="100" style="width:{{ $comments_rating_details[2] }}%">
                    {!! $comments_rating_details[2] !!}%
                </div>
              </div>
            </div>
          </div>
          </li>
          <li>
          <div class="rating-progress-content clearfix">
            <div class="individual-rating-score">
              <span><i class="fa fa-star"></i> 1</span>
            </div>
            <div class="individual-rating-progress">
              <div class="progress">
                <div class="progress-bar progress-bar-one" role="progressbar" aria-valuenow="{{ $comments_rating_details[1] }}" aria-valuemin="0" aria-valuemax="100" style="width:{{ $comments_rating_details[1] }}%">
                    {!! $comments_rating_details[1] !!}%
                </div>
              </div>
            </div>
          </div>
          </li>
        </ul>
      </div>
    </div>
    <div class="user-reviews-content">
        <h2 class="user-reviews-title">{{ $comments_rating_details['total'] }} {{ trans('frontend.reviews_for_label') }} <i><span>{!! $user_name !!}</span></i></h2>
        @if(count($comments_details) > 0)
        <ol class="commentlist">
            @foreach($comments_details as $comment) 
            <li class="comment">
              <div class="comment-container clearfix">
                <div class="user-img">
                  @if(!empty($comment->user_photo_url))
                  <img alt="" src="{{ get_image_url( $comment->user_photo_url ) }}" class="avatar photo" width="60" height="60">
                  @else
                  <img alt="" src="{{ default_avatar_img_src() }}" class="avatar photo" width="60" height="60">
                  @endif
                </div>
                <div class="comment-text">
                  <div class="star-rating">
                    <span style="width:{{ $comment->percentage }}%"><strong itemprop="ratingValue"></strong></span>
                  </div>
                  <p class="meta">
                    <span class="comment-date">{{ Carbon\Carbon::parse(  $comment->created_at )->format('F d, Y') }}</span> &nbsp; - <span class="comment-user-role"><strong >{{ trans('frontend.by_label') }} {{ $comment->display_name }}</strong></span>
                  </p><hr>
                  <div class="description">
                    <p>{{ $comment->content }}</p>
                  </div>
                </div>
              </div>
            </li>
            @endforeach
        </ol>
        @else
        <p>{{ trans('frontend.no_review_label') }}</p>
        @endif
    </div>

    <br>

    @include('pages-message.notify-msg-success')
    @include('pages-message.notify-msg-error')
    @include('pages-message.form-submit')

    <form id="new_comment_form" method="post" action="" enctype="multipart/form-data">
      <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
      <input type="hidden" name="comments_target" id="comments_target" value="vendor">
      <input type="hidden" name="selected_rating_value" id="selected_rating_value" value="">

      <div class="add-user-review">
        <h2 class="add-reviews-title">{{ trans('frontend.add_a_review_label') }}</h2>
        <hr>
        <h2 class="rating-title">{{ trans('frontend.select_your_rating_label') }}</h2>
        <div class="rating-select">
            <div class="btn btn-default btn-sm" data-rating_value="1"><span class="glyphicon glyphicon-star-empty"></span></div>
            <div class="btn btn-default btn-sm" data-rating_value="2"><span class="glyphicon glyphicon-star-empty"></span></div>
            <div class="btn btn-default btn-sm" data-rating_value="3"><span class="glyphicon glyphicon-star-empty"></span></div>
            <div class="btn btn-default btn-sm" data-rating_value="4"><span class="glyphicon glyphicon-star-empty"></span></div>
            <div class="btn btn-default btn-sm" data-rating_value="5"><span class="glyphicon glyphicon-star-empty"></span></div>
        </div>
        <br>
        <div class="review-content">
            <fieldset>
                <legend>{{ trans('frontend.write_your_review_label') }}</legend>
                <p><textarea name="product_review_content" id="product_review_content"></textarea></p>
            </fieldset>
        </div>
        <br>
        <div class="review-submit">
            <input name="review_submit" id="review_submit" class="btn btn-sm btn-style" value="{{ trans('frontend.submit_label') }}" type="submit">
        </div>
      </div>
    </form>
  </div>
</div>
@endsection 