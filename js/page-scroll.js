jQuery( document ).ready( function(jQuery){
	if( jQuery('main').hasClass('active_autoload') ) var init_cahnrs_pagescroll = new cahnrs_pagescroll();
});
var cahnrs_pagescroll = function(){
	var $ = jQuery;
	this.pgld_obj = false;
	this.gbl_nav = $( '#cahnrs-global-nav');
	this.gbl_nav_itm = this.gbl_nav.find('.nav-item');
	this.act_win = $(document);
	this.act_win_frm = false;
	s = this;
	
	s.set_frm_hght = function( frm ){
		var hgt = frm.contents().find('body').innerHeight();
		hgt = hgt + 50;
		frm.height( hgt+'px' );
	}
	
	s.add_dyn_pg = function(){
	}
	
	s.hdl_mnu_scr = function( c_hght ){
		var c_mnu = false;
		var hlf_win = c_hght - ( $(window).height() * 0.50 );
		var spl = $('.cahnrs-page-splitter');
		var art = $('article.dynamic-iframe-page').not('.inactive').find('.cahnrs-page-splitter');
		art.each(function(){
			console.log( $(this).offset().top+' '+hlf_win );
			//alert();
			if( $(this).offset().top > hlf_win ) return false;
			c_mnu = $(this).data('menuid');
		});
		if( c_mnu ){
			var n_mnu_itm = $('#spine-sitenav #'+c_mnu );
			if( n_mnu_itm.children('ul').children('.overview').length > 0 ){
				n_mnu_itm = n_mnu_itm.children('ul').children('.overview');
			}
		} else {
			var n_mnu_itm = $('#spine-sitenav > ul > li').filter(':first');
		}
		n_mnu_itm.addClass('current active dogeared').siblings().removeClass('current active dogeared');
		n_mnu_itm.parents('li').addClass('current parent active dogeared').siblings().removeClass('current parent active dogeared');
	}
	
	/** Check if load array exists and has stuff in it **/
	if( 0 < s.act_win.find('article.dynamic-iframe-page.inactive').length ){
		/**************************************************
		** Bind on scroll event to window and run it once**
		**************************************************/
		$(window).scroll( function() {
			var c_hght = $(window).scrollTop() + $(window).height();
			if( c_hght > s.act_win.height() - 200){
				var nf = s.act_win.find('article.dynamic-iframe-page.inactive').first();
				//nf.show();
				
				nf.removeClass('inactive');
				var frm = nf.find('iframe');
				if( 0 < frm.length ){
					if( s.act_win_frm ) s.act_win_frm.height( s.act_win_frm.height() + 4000 );
					frm.attr('src', frm.data('src') );
					frm.on('load', function(){ 
						s.set_frm_hght( frm );
						if( s.act_win_frm ) s.set_frm_hght( s.act_win_frm );
						} );
				}
				//alert('fire');
				console.log('fire');
				//s.add_dyn_pg();
			}
			s.hdl_mnu_scr( c_hght );
		}).trigger('scroll');
		
		$(window).resize(function(){
			$('article.dynamic-iframe iframe').each(function(){ s.set_frm_hght( $(this) ); });
			});
	}
	

}