<li>
  <input type="checkbox" class="shopist-iCheck" name="inputCategoriesName[]" id="inputCategoriesName-{{ $data['name'] }}" value="{{ $data['id'] }}">
  &nbsp;&nbsp;{{ $data['name'] }}
</li>
@if (count($data['children']) > 0)
  <ul>
  @foreach($data['children'] as $data)
      @include('pages.common.customcategory-list', $data)
  @endforeach
  </ul>
@endif