jQuery( document ).ready( function(jQuery){
	if( s.gbl_nav.length > 0 ) var init_cahnrs_global = new cahnrs_global();
});

var cahnrs_global = function(){
	var s = this;
	
	s.mod_page = function(){
		jQuery('main').hide();
	}
	
	s.mod_page();
}