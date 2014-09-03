jQuery( document ).ready( function(jQuery){
	
	if( jQuery('body').hasClass('dynamic-page-slide') && !jQuery('body').hasClass('no-dynamic-page-slide') ){ 
		var init_cahnrs_pageslide = new cahnrs_pageslide();
	};
});


var cahnrs_pageslide = function(){
	this.scr = 0;
	this.glb_nav = jQuery('#cahnrs-global-header');
	this.glb_nav_itms = this.glb_nav.find('.nav-item');
	this.jack = jQuery('#jacket');
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
		s.jack.before( s.bld_frm( ' selected' , pathname+'?no-slide=true&dynamic-page=true&slide-frame=true&dynamic-page-slide=true' , pathname , ''  )   );
		jQuery(window).load(function(){
			jQuery('.cahnrs-pageframe').not('.selected').each( function(){
				jQuery( this ).attr('src', jQuery(this).data('src') );
				});
			})
		
	}
	
	s.bld_frm = function( is_active , src , data , bg ){
		var frm = '<iframe class="cahnrs-pageframe'+is_active+'" src="'+src+'" data-src="'+data+'?no-slide=true&slide-frame=true&dynamic-page=true&dynamic-page-slide=true"  style="background-image: url('+bg+')"/></iframe>';
		return frm;
	}
	
	s.hdl_scr = function(){
		alert('fire');
	}
	
	s.scr = s.tst_scr();
	s.mod_page();
	s.ld_frms();
}

var childScrollHandler = function ( hgt ) {
		if( hgt < 93 ){
			jQuery( '#cahnrs-global-header').css('top', ( hgt * -1 ) +'px' ); 
		} else {
			jQuery( '#cahnrs-global-header').css('top', '-93px' );
		}
}
