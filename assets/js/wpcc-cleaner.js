// Cache cleaner
jQuery(document).ready( function() {

   jQuery(".dropdown").click( function(e) {
      var id = jQuery(this).data("id")
      var nonce = jQuery(this).data("nonce")
	  var option = jQuery(this).is(":checked") ? '1' : '0';
	  wpcc_dropdown(id, nonce, option);
   })
   jQuery(".apply-bulk").click( function(e) {
	   var c_action = jQuery(this).data("action");
	   var selected = jQuery("#bulk-action-selector-"+c_action).val();
	   var nonce = jQuery(this).data("nonce");
	   var counter = 0;
	   jQuery('.wpcc-checkeddropdown .dropdown').each(function(){
		   if( selected == 'dm-add'){
			   if(!jQuery(this).is(":checked")){
				   var id = jQuery(this).data("id");
				   wpcc_dropdown(id, nonce, 1, this);
				   counter++;
			   }
		   }
		   if( selected == 'dm-remove'){
			   if(jQuery(this).is(":checked")){
				   var id = jQuery(this).data("id")
				   wpcc_dropdown(id, nonce, 0, this);
			   }
		   }
		   jQuery("#dropdownmenu .count").text('('+counter+')');
      })
   })
   function wpcc_dropdown(id, nonce, option, $this){
	  var count = jQuery("#dropdownmenu .count").text();
	  count = count.replace('(', '');
	  count = count.replace(')', '');
      jQuery.ajax({
         type : "post",
         dataType : "json",
         url : wpcc.ajaxurl,
         data : {action: "wpcc_option", id : id, option : option, nonce: nonce},
         success: function(response) {
            if(response) {
				if(option == '1'){
					if (jQuery("#wp-admin-bar-wpcc-spacer").length <= 0){
					  jQuery("#wp-admin-bar-wpcc-top-menu-default").append('<li id="wp-admin-bar-wpcc-spacer"><div class="ab-item ab-empty-item">-------------------</div></li>');
					}
					jQuery("#wp-admin-bar-wpcc-top-menu-default").append(response.add);
					if(typeof $this != 'undefined'){
						jQuery($this).prop('checked', true);
					}else{
						count = parseInt(count)+1;
						jQuery("#dropdownmenu .count").text('('+count+')');
					}
				}else{
					jQuery("#wp-toolbar #wp-admin-bar-"+id).remove();
					if(typeof $this != 'undefined'){
						jQuery($this).prop('checked', false);
					}else{
						count = parseInt(count)-1;
						jQuery("#dropdownmenu .count").text('('+count+')');
					}	
					if(response.remove && jQuery(".menu_cust_child").length <= 0) jQuery("#wp-admin-bar-wpcc-spacer").remove();
				}
            }
         }
      })      
   }
})