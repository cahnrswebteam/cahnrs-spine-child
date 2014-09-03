var init_cahnrs_pageslide;
var init_cahnrs_pagescroll;

jQuery( document ).ready( function(jQuery){
	
	var init_cahnrs_js = new cahnrs_js();
	
	if( jQuery('body').hasClass('dynamic-page-slide') && !jQuery('body').hasClass('no-dynamic-page-slide') ){ 
		init_cahnrs_pageslide = new cahnrs_pageslide();
	};
	if( jQuery('body').hasClass('dynamic-page-scroll') ){ 
		init_cahnrs_pagescroll = new cahnrs_pagescroll();
	};
});

var cahnrs_js = function(){
	var s = this;
	
	s.check_scr = function(){
		jQuery(document).bind('scroll', function(ev){
			try { 
				var scr = jQuery(window).scrollTop();
				parent.childScrollHandler( scr ); 
				}
			catch( err ) {};
		});
	}
	
	s.check_scr();
}

var cahnrs_pageslide = function(){
	this.scr = 0;
	this.glb_nav = jQuery('#cahnrs-global-header');
	this.glb_nav_itms = this.glb_nav.find('.nav-item');
	this.jack = jQuery('#jacket');
	this.li = 0;
	this.is_lded = false;
	var s = this;
	
	s.mod_page = function(){
		jQuery('body').addClass('cahnrs-pageslider');
		s.jack.css({ left: '0px',right: s.scr+'px',width: 'auto' });
	}
	
	s.tst_scr = function(){
		var test_scroll = '<div id="test-scroll" style="position: absolute; overflow: scroll; width: 100px; height: 100px" ><div style="heigh:200px;"></div></div>';
		s.jack.after( test_scroll );
		var scr = jQuery('#test-scroll').width() - jQuery('#test-scroll div').width();
		jQuery('#test-scroll').remove();
		return scr;
	}
	s.chg_sec = function( ind ){
		var cnv = s.glb_nav_itms.filter('.selected') // Currently selected nav item
		s.glb_nav_itms.eq( ind ).addClass('selected').siblings().removeClass('selected');
		var cs_ind = ( cnv.length > 0 )? cnv.index() : 0; // Get index if exists else index = 0
		var cs = jQuery('.cahnrs-pageframe.selected');
		var ns = jQuery('.cahnrs-pageframe').eq( ind );
		var comb = jQuery('.cahnrs-pageframe').filter('.selected, :eq('+ind+')');
		var ns_c = ns.contents();
		var cs_c = cs.contents();
		var dir = ( cs_ind < ind )? 1 : -1;
		var clft = {'left': (100 * dir  * -1) + '%' };
		/*****************************************
		** Prep slides for transition **
		******************************************/
		var comb_bdy = comb.contents().find('body');
		var comb_spn = comb.contents().find('#spine');
		ns.addClass('next-slide');
		ns.css('left', (100 * dir ) + '%' );
		comb_bdy.css( {'overflow':'hidden', 'margin-right': s.scr+'px'}); // Remove scrollbar for slide
		comb_spn.css('left','-9999px');
		s.jack.find('#spine').css('left','auto');
		/*****************************************
		** Start transition **
		******************************************/
		cs.animate( clft , 'slow' );
		ns.animate( { left:'0px' } , 'slow',function(){
			cs.removeClass('selected');
			ns.removeClass('next-slide').addClass('selected');
			s.jack.find('#spine').css('left','-9999px');
			comb_spn.css('left','auto');; // Activate Scrollbar
			comb_bdy.css( {'overflow':'auto', 'margin-right': '0px'}); // Remove scrollbar for slide
			});
	};
	
	s.ld_frms = function(){
		s.glb_nav_itms.each( function( index ){
			var href = jQuery(this).children('a').attr('href');
			var bg = jQuery(this).data('bg');
			s.jack.before( s.bld_frm( '' , 'about:blank' , href , bg  ) );
			jQuery(this).on('click','a',function( event){
				event.preventDefault(  );
				//jQuery(this).parent('li').addClass('selected').siblings().removeClass('selected');
				s.chg_sec( index );
				});
		});
		
		var pathname = window.location.pathname;
		s.jack.before( s.bld_frm( ' selected' , pathname+'?no-slide=true&dynamic-page-scroll=true&dynamic-page=true' , pathname , ''  )   );
	}
	
	s.bld_frm = function( is_active , src , data , bg ){
		var frm = '<iframe class="cahnrs-pageframe'+is_active+'" src="'+src+'" data-src="'+data+'?no-slide=true&slide-frame=true&dynamic-page-scroll=true&dynamic-page=true"  style="background-image: url('+bg+')"/></iframe>';
		return frm;
	}
	
	s.rnd_frms = function(){
		jQuery('.cahnrs-pageframe').not('.selected').each( function(){
			if( 'about:blank' == jQuery( this ).attr('src') ){
				jQuery( this ).attr('src', jQuery(this).data('src') );
			}
			});
	}
	
	s.chk_ld = function(){
		if( s.is_lded ) return true;
		if( 'complete' == document.readyState || s.li > 100 ){
			s.rnd_frms();
		} else {
			s.li++;
			setTimeout( function(){s.chk_ld() }, 100);
		}
	}
	
	s.hdl_scr = function(){
		alert('fire');
	}
	
	s.scr = s.tst_scr();
	s.mod_page();
	s.ld_frms();
	s.chk_ld();
	//jQuery('body').attr('onload','init_cahnrs_pageslide.rnd_frms()');
	//window.onload = function(){ s.rnd_frms() };
	jQuery(window).load( function(){ s.is_lded = true; s.rnd_frms(); } )
}

var childScrollHandler = function ( hgt ) {
		if( hgt < 93 ){
			jQuery( '#cahnrs-global-header').css('top', ( hgt * -1 ) +'px' ); 
		} else {
			jQuery( '#cahnrs-global-header').css('top', '-93px' );
		}
}

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
