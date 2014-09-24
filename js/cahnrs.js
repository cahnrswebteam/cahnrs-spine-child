var init_cahnrs_pageslide;
var init_cahnrs_pagescroll;

jQuery( document ).ready( function(jQuery){
	
	var init_cahnrs_js = new cahnrs_js();

});

var cahnrs_js= function(){
	this.glb_nav = jQuery('#cahnrs-global-header');
	this.glb_nav_itms = this.glb_nav.find('.nav-item');
	this.slds = jQuery('.cahnrs-inview-slide');
	this.ex_state_chg = true;
	this.stp_state = false;
	//this.sld_c = this.slds.filter('.activeslide');
	this.mens = jQuery('#spine-sitenav > ul');
	this.mens_off =jQuery('#spine-offsitenav > ul');
	this.pg_itms = new Object();
	this.pg_itms.page = this.slds.filter('.activeslide');
	this.pg_itms.menu = this.mens.first();
	this.pg_itms.menu_offsite = this.mens_off.first();
	var s = this;
	
	s.init_sld = function(){
		s.glb_nav_itms.on('click','a.nav-link', function(event){ 
			event.preventDefault(); 
			s.chg_sec( jQuery( this) );
			});
	}
	
	s.chg_sec = function ( ic ){
		var sl_nav = ic.parent('li');
		s.init_gbl_hdr.clk_hv_drp( sl_nav );
		if( s.glb_nav_itms.find('.inslide').length > 0 ) return false;
		var c_sl_nav = s.glb_nav_itms.filter('.selected');
		var c_nav_inx = ( c_sl_nav.length > 0 )? c_sl_nav.index() : 0;
		var sl_nav_i = sl_nav.index();
		if( c_nav_inx == sl_nav_i ) return false; 
		if( typeof s.init_hstry.chg !== 'undefined'){ 
			s.init_hstry.chg( ic.attr('href') , sl_nav.attr('name') ) 
			};
		s.stp_state = false;
		ic.addClass('inslide');
		var dir = ( c_nav_inx > sl_nav_i )? -1 : 1;
		var a_lft = {'left': ( 150 * dir * -1 )+'%' }; 
		var sld_n = s.slds.eq( sl_nav_i + 1 );
		var mens_n = s.mens.eq( sl_nav_i + 1 );
		var mens_off_n = s.mens_off.eq( sl_nav_i + 1 );
		var bg_n = sld_n.find('.cahnrs-bg-slide');
		//alert( dir );
		sl_nav.addClass('selected').siblings().removeClass('selected');
		sld_n.css('left', (150 * dir )+'%');
		sld_n.css('top', s.pg_itms.page.position().top + 'px');
		mens_n.css('left', (150 * dir )+'%' );
		bg_n.css('left', (150 * dir )+'%' );
		s.pg_itms.menu_offsite.hide();
		s.pg_itms.page.animate( a_lft , 'slow' );
		bg_n.animate({'left':'0px'}, 'slow' , function(){
			if( s.pg_itms.bg ) s.pg_itms.bg.css('left','-9999px');
			s.pg_itms.bg = bg_n;
			});
		sld_n.animate({'left':'0px'}, 'slow' , function(){
			s.pg_itms.page .removeClass('activeslide');
			sld_n.addClass('activeslide');
			sld_n.css('top', '0');
			s.pg_itms.page = sld_n;
			
			s.pg_itms.menu.animate( a_lft , 'medium' );
			mens_n.animate({'left':'0px'}, 'medium' , function(){
				mens_n.removeClass('inactive');
				s.pg_itms.menu.addClass('inactive');
				s.pg_itms.menu = mens_n;
				jQuery(window).trigger('scroll');
				ic.removeClass('inslide');
				s.pg_itms.menu_offsite.addClass('inactive');
				mens_off_n.hide();
				mens_off_n.removeClass('inactive');
				mens_off_n.slideDown('fast');
				s.pg_itms.menu_offsite = mens_off_n;
				});
			});
	}
	
	s.init_scrl = function(){
		jQuery(window).scroll(function() { 
			s.chk_hgt();
			s.hdl_mnu_scr(); 
			});
	}
	
	s.chk_hgt = function(){
		if( jQuery(window).scrollTop() + jQuery(window).height() > s.pg_itms.page.height() - 1000) {
			   s.ld_scrl_sec();
		   }
	}
	
	s.ld_scrl_sec = function(){
		var n_pg = s.pg_itms.page.find('.cahnrs-page-splitter.inactive').first();
		if( n_pg.length > 0 ){
			var url = n_pg.data('url');
			var url = '/?page-ajax=true&page='+encodeURIComponent(url);
			n_pg.find('.chanrs-load-page').load( url , function(){
				jQuery( this ).parent('.cahnrs-page-splitter').show();
				n_pg.removeClass('inactive');
				jQuery(window).trigger('scroll');
				});
		}
	}
	
	s.hdl_mnu_scr = function(){
		var c_mnu = false;
		var c_url = false;
		var hlf_win = jQuery(window).scrollTop() + ( jQuery(window).height() * 0.50 );
		var art = s.pg_itms.page.find('.cahnrs-page-splitter').not('.inactive');
		art.each(function( index ){
			if( jQuery(this).offset().top > hlf_win ) return false;
			//console.log( jQuery(this).offset().top > hlf_win );
			c_mnu = jQuery(this).data('menuid');
			c_nm = jQuery(this).attr('name');
			c_url = jQuery(this).data('url');
		});
		if( c_mnu ){
			var n_mnu_itm = s.pg_itms.menu.find( '#'+c_mnu );
			if( n_mnu_itm.children('ul').children('.overview').length > 0 ){
				n_mnu_itm = n_mnu_itm.children('ul').children('.overview');
			}
			if( !n_mnu_itm.hasClass('current') || ( n_mnu_itm.hasClass('current') && n_mnu_itm.hasClass('parent') ) ){
				if( typeof s.init_hstry.chg !== 'undefined'){ s.init_hstry.chg( c_url , c_nm ) };
				n_mnu_itm.addClass('current active dogeared').siblings().removeClass('current active dogeared');
				n_mnu_itm.parents('li').addClass('current parent active dogeared').siblings().removeClass('current parent active dogeared');
			}
		} else {
			var n_mnu_itm = s.pg_itms.menu.children('li').filter(':first');
			if( !n_mnu_itm.hasClass('current') || ( n_mnu_itm.hasClass('current') && n_mnu_itm.hasClass('parent') ) ){
				if( typeof s.init_hstry.chg !== 'undefined'){ s.init_hstry.chg( n_mnu_itm.children('a').attr('href') , n_mnu_itm.children('a').text() ) };
				n_mnu_itm.addClass('current active dogeared').siblings().removeClass('current active dogeared');
				n_mnu_itm.parents('li').addClass('current parent active dogeared').siblings().removeClass('current parent active dogeared');
			}
		}
	}
	
	s.init_hstry = function(){
		var History = window.History;
		
		History.Adapter.bind(window,'statechange',function() { // Note: We are using statechange instead of popstate
			var State = History.getState();
			if( s.ex_state_chg ) {
				var nurl = State.url;
				s.glb_nav_itms.children('a').each( function(){
					var turl = jQuery(this).attr('href');
					if( nurl == turl || nurl == turl+'/' ){
						s.stp_state = true;
						s.chg_sec( jQuery( this) );
						jQuery('html, body').animate({ scrollTop: '0px' }, 'medium');
						}
					});
				var splt = s.pg_itms.page.find('.cahnrs-page-splitter');
				if( splt.length > 0 ){
					splt.each( function(){
						var turl = jQuery(this).data('url');
						if( nurl == turl || nurl == turl+'/' ) { 
							var hgt = jQuery( this ).offset().top;
							s.stp_state = true;
							 jQuery('html, body').animate({ scrollTop: hgt+'px' }, 'medium', function(){ s.stp_state = false; });
							};
					});
					
				}
			}
			s.ex_state_chg = true;
			//jQuery('#content').load(State.url);
			/* Instead of the line above, you could run the code below if the url returns the whole page instead of just the content (assuming it has a `#content`):
			$.get(State.url, function(response) {
				$('#content').html($(response).find('#content').html()); });
			*/
        });
		s.init_hstry.chg = function( url , name ){
			if( s.stp_state ) return false;
			s.ex_state_chg = false;
			History.pushState(null, name , url );
		}		
	}
	
	s.init_gbl_hdr = function(){
		s.glb_nav_itms.hover(
			function(){ s.init_gbl_hdr.hv_drp( jQuery( this ) ) },
			function(){ s.init_gbl_hdr.out_hv_drp( jQuery( this ) ) }
		);
		
		s.init_gbl_hdr.hv_drp = function( ih ){
			ih.addClass('active');
			setTimeout( function(){ s.init_gbl_hdr.shw_drp( ih ) }, 150 );
		}
		
		s.init_gbl_hdr.out_hv_drp = function( ih ){
			ih.removeClass('active');
			ih.find('.nav-sub-section').slideUp( 200 );
		}
		s.init_gbl_hdr.clk_hv_drp = function( ih ){
			ih.removeClass('active');
			ih.find('.nav-sub-section').hide();
		}
		
		s.init_gbl_hdr.shw_drp = function( ih ){
			if( ih.hasClass('active') ){
				ih.find('.nav-sub-section').slideDown( 200 );
			}
		}
		
	};
	
	if( s.glb_nav.length > 0 ) s.init_gbl_hdr();
	if( jQuery('.cahnrs-inview-slide').length > 0 ) s.init_sld();
	if( typeof s.pg_itms.page !== 'undefined' && s.pg_itms.page.find('.cahnrs-page-splitter').length > 0 ) { s.init_scrl();}
	s.init_hstry();
	
}