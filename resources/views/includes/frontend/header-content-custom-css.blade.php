@if(count($appearance_all_data)>0 && $appearance_all_data['header_details']['custom_css'] == true)
<style type="text/css">
  header .header-background{
    background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#{{ $appearance_all_data['header_details']['header_top_gradient_start_color'] }}), to(#{{ $appearance_all_data['header_details']['header_top_gradient_end_color'] }})); /* Safari 5.1, Chrome 10+ */ background: -webkit-linear-gradient(top, #{{ $appearance_all_data['header_details']['header_top_gradient_start_color'] }}, #{{ $appearance_all_data['header_details']['header_top_gradient_end_color'] }}); /* Firefox 3.6+ */ background: -moz-linear-gradient(top, #{{ $appearance_all_data['header_details']['header_top_gradient_start_color'] }}, #{{ $appearance_all_data['header_details']['header_top_gradient_end_color'] }}); /* IE 10 */ background: -ms-linear-gradient(top, #{{ $appearance_all_data['header_details']['header_top_gradient_start_color'] }}, #{{ $appearance_all_data['header_details']['header_top_gradient_end_color'] }}); /* Opera 11.10+ */ background: -o-linear-gradient(top, #{{ $appearance_all_data['header_details']['header_top_gradient_start_color'] }}, #{{ $appearance_all_data['header_details']['header_top_gradient_end_color'] }});
  }
  
  header .change-multi-currency a, header .language-list a, header .top-right-menu a, header .btn-compare, header .all-menu a{
    color:#{{ $appearance_all_data['header_details']['header_text_color'] }} !important;  
  }
  
  header .change-multi-currency a:hover, header .language-list a:hover, header .top-right-menu a:hover, header .btn-compare:hover, header #header_content ul.all-menu li a:hover{
    color:#{{ $appearance_all_data['header_details']['header_text_hover_color'] }} !important;  
  }
		
  header .change-multi-currency a, header .language-list a, header .top-right-menu a, header .btn-compare, header .all-menu a{
      font-size: {{ $appearance_all_data['header_details']['header_text_size'] }}px !important;
  }

  header ul.all-menu li .selected{
      background-color: #{{ $appearance_all_data['header_details']['header_selected_menu_bg_color'] }} !important;
      color:#{{ $appearance_all_data['header_details']['header_selected_menu_text_color'] }} !important;
  }
</style>
@endif