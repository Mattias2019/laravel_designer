<li>
  @if(in_array($data['id'], $selected_cat['term_id']))
  <input type="checkbox" checked="checked" class="shopist-iCheck" name="inputCategoriesName[]" id="inputCategoriesName-{{ $data['name'] }}" value="{{ $data['id'] }}">
  @else
  <input type="checkbox" class="shopist-iCheck" name="inputCategoriesName[]" id="inputCategoriesName-{{ $data['name'] }}" value="{{ $data['id'] }}">
  @endif
  &nbsp;&nbsp;{{ $data['name'] }}
</li>
@if (count($data['children']) > 0)
  <ul>
  @foreach($data['children'] as $data)
      @include('pages.common.update-category-list', $data)
  @endforeach
  </ul>
@endif