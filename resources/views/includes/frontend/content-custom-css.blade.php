<style type="text/css">
  body{
    background-color: #{{ get_appearance_settings()['general']['body_bg_color'] }};
  }
  
  .product-categories-accordian,.blog-categories-accordian, .price-filter, .tags-product-list, .brands-list, .advertisement, .best-seller, .colors-filter, .size-filter{
    background-color: #{{ get_appearance_settings()['general']['sidebar_panel_bg_color'] }} !important;
  }
  
  .product-categories-accordian h2, .blog-categories-accordian h2, .price-filter h2, .tags-product-list h2, .brands-list h2, .advertisement h2, .best-seller h2, .colors-filter h2, .size-filter h2{
    color: #{{ get_appearance_settings()['general']['sidebar_panel_title_text_color'] }} !important;
    font-size: {{ get_appearance_settings()['general']['sidebar_panel_title_text_font_size'] }}px !important;
  }
  
  .product-categories-accordian h2::after, .blog-categories-accordian h2::after, .price-filter h2::after, .tags-product-list h2::after, .brands-list h2::after, .advertisement h2::after, .best-seller h2::after, .colors-filter h2::after, .size-filter h2::after{
    background: #{{ get_appearance_settings()['general']['sidebar_panel_title_text_bottom_border_color'] }} !important;
  }
  
  .product-categories-accordian a, .blog-categories-accordian a, .price-slider-option, .tags-product-list ul li a, .colors-filter-option .filter-terms .filter-terms-name, .size-filter .filter-terms .filter-terms-name, #productRightColumn .best-seller .product-details p a{
    color: #{{ get_appearance_settings()['general']['sidebar_panel_content_text_color'] }} !important;
    font-size: {{ get_appearance_settings()['general']['sidebar_panel_content_text_font_size'] }}px !important;
  }
  
  .hover-product, .categories-products-list .box, #home_page .slider-with-best-sale-and-latest .hover-product, #home_page .featured-products-list .hover-product, #shop_page .products-list .box, .products-list .product-content .comments-advices ul li a{
    background-color: #{{ get_appearance_settings()['general']['product_box_bg_color'] }} !important;
    border: 1px solid #{{ get_appearance_settings()['general']['product_box_border_color'] }} !important;
    color: #{{ get_appearance_settings()['general']['product_box_text_color'] }} !important;
  }
  
  .categories-products-list .box p.reviews a, #shop_page .box p.reviews a{
    color: #{{ get_appearance_settings()['general']['product_box_text_color'] }} !important;
  }
  
  .categories-products-list .single-product-bottom-section h3, .categories-products-list .single-product-bottom-section p, .categories-products-list .box h3, .categories-products-list .box p, .hover-product p, .hover-product h3, #shop_page .products-list .list-view-box .single-product-bottom-section p, #shop_page .products-list .list-view-box h3, #shop_page .products-list .list-view-box p, .products-list .product-content .comments-advices ul li a{
    font-size: {{ get_appearance_settings()['general']['product_box_text_font_size'] }}px !important;
  }
  
  .price-slider-option .slider-selection, .btn-price-filter button, .categories-products-list .add-to-cart-bg, .categories-products-list .select-options-bg, .categories-products-list .product-customize-bg, #home_page .add-to-cart-bg, #home_page .select-options-bg, #home_page .product-customize-bg, #shop_page .add-to-cart-bg, #shop_page .select-options-bg, #shop_page .product-customize-bg, #blogs_main .blog-content-elements-main .btn, #blog_single_page_main .review-submit .btn, #blogs_main .blog-content-elements-main .btn, #blog-cat-content-main .blog-content-elements-main .btn, #product_single_page .request-product{
    background-color: #{{ get_appearance_settings()['general']['product_box_btn_bg_color'] }} !important;
    color: #{{ get_appearance_settings()['general']['btn_text_color'] }} !important;
  }
  
  .btn-price-filter button:hover, .categories-products-list .add-to-cart-bg:hover, .categories-products-list .select-options-bg:hover, .categories-products-list .product-customize-bg:hover, #home_page .add-to-cart-bg:hover, #home_page .select-options-bg:hover, #home_page .product-customize-bg:hover, #shop_page .add-to-cart-bg:hover, #shop_page .select-options-bg:hover, #shop_page .product-customize-bg:hover, #blogs_main .blog-content-elements-main .btn:hover, #blog_single_page_main .review-submit .btn:hover, #blogs_main .blog-content-elements-main .btn:hover, #blog-cat-content-main .blog-content-elements-main .btn:hover, #product_single_page .request-product:hover{
    background-color: #{{ get_appearance_settings()['general']['product_box_btn_hover_color'] }} !important;
    color: #{{ get_appearance_settings()['general']['btn_hover_text_color'] }} !important;
  }
  
  .categories-products-list a.product-wishlist, .categories-products-list a.product-details-view, #home_page a.product-wishlist, #home_page a.product-details-view, #shop_page a.product-wishlist, #shop_page a.product-details-view{
    color: #{{ get_appearance_settings()['general']['product_box_btn_bg_color'] }} !important;
    border:2px solid #{{ get_appearance_settings()['general']['product_box_btn_bg_color'] }} !important;
  }
  
  .categories-products-list a.product-wishlist:hover, .categories-products-list a.product-details-view:hover, #home_page a.product-wishlist:hover, #home_page a.product-details-view:hover, #shop_page a.product-wishlist:hover, #shop_page a.product-details-view:hover{
    color: #{{ get_appearance_settings()['general']['btn_hover_text_color'] }} !important;
    border:2px solid #{{ get_appearance_settings()['general']['product_box_btn_hover_color'] }} !important;
  }
  
  #product-category .products-list-top .btn-default, #shop_page #productCenterColumn .navbar-form .input-group-btn .btn-default, #product-category .products-list-top .product-views a:hover, .products-list-top .active, #shop_page .navbar-form .input-group-btn .btn-default{
    background-color: #{{ get_appearance_settings()['general']['product_box_btn_bg_color'] }} !important;
    color: #{{ get_appearance_settings()['general']['btn_text_color'] }} !important;
  }
  
  #product-category .products-list-top .btn-default:hover, #shop_page #productCenterColumn .navbar-form .input-group-btn .btn-default:hover{
    background-color: #{{ get_appearance_settings()['general']['product_box_btn_hover_color'] }} !important;
    color: #{{ get_appearance_settings()['general']['btn_hover_text_color'] }} !important;
  }
  
  header #bottom_bar ul.right-menu li .selected{
    border-bottom: 4px solid #{{ get_appearance_settings()['general']['selected_menu_border_color'] }} !important;
  }
  
  header #cd-cart .cd-item-remove:hover{
    background-color: #{{ get_appearance_settings()['general']['product_box_btn_hover_color'] }} !important;
  }
  
  header #cd-cart .checkout-btn, #home_page .products-categories-list .image-holder a.category-details, #home_page .testimonials-read, #home_page #page_content .advanced-products-tab .nav-tabs li.active a, #home_page #page_content .advanced-products-tab .nav-tabs li.active a:hover, #home_page #page_content .advanced-products-tab .nav-tabs li.active a:focus {
    background: #{{ get_appearance_settings()['general']['product_box_btn_bg_color'] }} !important;
    color: #{{ get_appearance_settings()['general']['btn_text_color'] }} !important;
  }

  header #cd-cart .checkout-btn:hover, #home_page .testimonials-read:hover {
    background: #{{ get_appearance_settings()['general']['product_box_btn_hover_color'] }} !important;
    color: #{{ get_appearance_settings()['general']['btn_hover_text_color'] }} !important;
  }
  
  #home_page .products-categories-list .image-holder a.category-details:hover{
    background: #{{ get_appearance_settings()['general']['product_box_btn_hover_color'] }} !important;
    color: #{{ get_appearance_settings()['general']['product_box_btn_bg_color'] }} !important;
  }
  
  #home_page .slider-with-best-sale-and-latest h2::after, #home_page .featured-products-list .content-title h2::after, #home_page .testimonials-slider .content-title h2::after, #home_page .recent-blog .content-title h2::after, #home_page .products-brands-list .content-title h2::after{
    background: #{{ get_appearance_settings()['general']['pages_content_title_border_color'] }} !important;
  }
  
  #home_page .slider-control-main .prev-btn a:hover, #home_page .slider-control-main .next-btn a:hover, #shop_page .tags-product-list ul li a:hover{
    background: #{{ get_appearance_settings()['general']['product_box_btn_bg_color'] }} !important;
    color: #{{ get_appearance_settings()['general']['btn_text_color'] }} !important;
  }
  
  #home_page .testimonials-img::after{
    color: #{{ get_appearance_settings()['general']['product_box_btn_bg_color'] }} !important;
  }
  
  #home_page .products-brands-list .control-carousel:hover{
    color: #{{ get_appearance_settings()['general']['product_box_btn_bg_color'] }} !important;
  } 
  
  footer .footer-top .container .footer-tags-list a:hover{
    background: #{{ get_appearance_settings()['general']['product_box_btn_bg_color'] }} !important;
    border-color: #{{ get_appearance_settings()['general']['product_box_btn_bg_color'] }} !important;
    color: #{{ get_appearance_settings()['general']['btn_text_color'] }} !important;
  }
</style>