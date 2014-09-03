var cahnrs_global = [
	'http://m1.wpdev.cahnrs.wsu.edu/?pageslide=true',
	'http://m1.wpdev.cahnrs.wsu.edu/academics/?pageslide=true',
	'http://m1.wpdev.cahnrs.wsu.edu/research/?pageslide=true',
	'http://m1.wpdev.cahnrs.wsu.edu/fs/?pageslide=true'
	];

jQuery( document ).ready(function(){
	for( var i = 0; i < cahnrs_global.length; i++ ){
		var clss = ( 0 == i )? ' selected currentslide' : '';
		var frame = '<iframe class="new-page-slide'+clss+'" src="'+cahnrs_global[i]+'"></iframe>';
		jQuery('#jacket').after( frame );
	}
	/**********************/
	var test_scroll = '<div id="test-scroll" style="position: absolute; overflow: scroll; width: 100px; height: 100px; top: -2000px;" ><div style="heigh:200px;"></div></div>';
	jQuery('#jacket').after( test_scroll );
	var scr = get_scroll();
	jQuery('#jacket').css({ left: '0px',right: scr+'px',width: 'auto' });
	
	function get_scroll(){
		var test_scroll = '<div id="test-scroll" style="position: absolute; overflow: scroll; width: 100px; height: 100px" ><div style="heigh:200px;"></div></div>';
		jQuery('#jacket').after( test_scroll );
		var scr = jQuery('#test-scroll').width() - jQuery('#test-scroll div').width();
		jQuery('#test-scroll').remove();
		return scr;
	}
	/********************/
	jQuery( '#cahnrs-global-header .nav-item a').click( function(event){
		event.preventDefault();
		var inx = jQuery(this).parent('li').index();
		jQuery(this).parent('li').addClass('selected');
		var cs = jQuery('body > iframe.currentslide');
		var ns = jQuery('body > iframe').eq( inx );
		var dir = ( cs.index() > inx )? 1 : -1;
		var clft = {'left': (100 * dir  * -1) + '%' };
		ns.addClass('next-slide');
		cs.contents().find('body').css('overflow','hidden');
		cs.animate( clft , 'slow' );
		ns.animate( { left:'0px' } , 'slow',function(){
			jQuery('#spine').hide();
			ns.contents().find('#spine').show();
			});
		}) 
});
	var childScrollHandler = function ( hgt ) {
		if( hgt < 90 ){
			jQuery( '#cahnrs-global-header').css('top', ( hgt * -1 ) +'px' ); 
		} else {
			jQuery( '#cahnrs-global-header').css('top', '-90px' );
		}
   console.log( hgt );
}
