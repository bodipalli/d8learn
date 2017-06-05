// Can also be used with $(document).ready()
jQuery(window).load(function() {
  jQuery('.flexslider').flexslider({
    animation: "slide"
  });

  
  jQuery( ".remove-resource-button" ).click(function(){
    var tagging =  jQuery(this).attr('id');
	var taggingarr = tagging.split("-");
    var blank_res = taggingarr[0];
	var taggingid = taggingarr[1];
    
    if (blank_res != 'blank') {
        var request=jQuery.ajax({
            url: "/rmp_resource_mapping_form/getdata/" + taggingid,
        });

        request.done(function(msg) {
            //alert(msg);
			jQuery( "#id-resource-data-" + tagging ).remove();
        });
    } else {
		jQuery( "#id-resource-data-" + tagging ).remove();
		
	}
	
	
  });  
  

});

