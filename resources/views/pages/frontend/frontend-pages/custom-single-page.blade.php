@extends('layouts.frontend.master')
@section('title', $page_data->post_title .' < '. get_site_title())

@section('content')
<div id="custom_single_page">
  <div class="container">
    {!! string_decode($page_data->post_content) !!}
  </div>
</div>
@endsection