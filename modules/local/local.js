// Local js script
function wpcc_clear_local_cache($this){
	let msgText = 'The local storage has been cleared!';
	window.localStorage.clear();
	let messageHTML = '<p class="wpcc_success" style="display:none;">' + msgText + '</p>';
	if (jQuery('body .wrap h1').length > 0) {
		jQuery('body .wrap h1').after(messageHTML);
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
