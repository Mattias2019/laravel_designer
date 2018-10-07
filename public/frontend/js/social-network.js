$(document).ready(function(){
	$('.product-share-content ul li a, .vendor-share-list ul li a').on('click', function(e){
		e.preventDefault();
		var share_url = null;
		var window_url = null;
    var product_url = null;
		
    product_url = window.location.href;
    
		if($(this).data('name') == 'fb'){
			share_url = '//www.facebook.com/sharer.php?u=';
		}
		else if($(this).data('name') == 'tweet'){
			share_url = '//twitter.com/share?text=' + encodeURI($('#product_title').val()) + '&url=';
		}
    else if($(this).data('name') == 'gplus'){
			share_url = '//plus.google.com/share?url=';
		}
    else if($(this).data('name') == 'pi'){
			share_url = '//pinterest.com/pin/create/button/?media=' + $('#product_img').val() + '&description=' + encodeURI($('#product_title').val()) + '&url=';
		}
    else if($(this).data('name') == 'lin'){
			share_url = '//www.linkedin.com/shareArticle?mini=true&url=';
		}

    if($(this).data('name') == 'fb' || $(this).data('name') == 'tweet' || $(this).data('name') == 'gplus' || $(this).data('name') == 'pi' || $(this).data('name') == 'lin'){
      window_url = share_url + product_url;
      window.open(window_url, "_blank", "scrollbars=yes, resizable=yes, toolbar=yes, top=50, left=50, width=500, height=500");
    }
    else if($(this).data('name') == 'print'){
      window.print();
    }
	});
})