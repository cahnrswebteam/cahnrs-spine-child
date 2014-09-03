jQuery(document).bind('scroll', function(ev){
    //try { 
		var scr = jQuery(window).scrollTop();
		parent.childScrollHandler( scr ); 
		//}
	//catch( err ) {};
});