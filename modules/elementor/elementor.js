// Local js script
function wpcc_clear_elementor_cache($this){
  jQuery.ajax({
	  type: 'post',
	  dataType: 'json',
	  url: wpcc.ajaxurl,
	  data: {
		  'action': 'wpcc_clear_cache',
		  '_wpnonce': jQuery($this).find('span').data('wpnonce')
	  },
	  success: function (response) {
		  if (response.success) {
			  let successData = response.data;
			  let messageHTML = '<p class="wpcc_success" style="display:none;">' + successData + '</p>';
			  if (jQuery('body #page-container').length > 0) {
				  jQuery('body #wpadminbar').prepend(messageHTML);
			  } else {
				  jQuery('body #wpbody-content').prepend(messageHTML);
			  }
			  jQuery(".wpcc_success").fadeIn(1500);
			  setTimeout(function () {
				  jQuery(".wpcc_success").fadeOut(1000);
			  }, 2500);
			  setTimeout(function () {
				  jQuery(".wpcc_success").remove();
			  }, 3500);
		  }
	  },
  });	
}