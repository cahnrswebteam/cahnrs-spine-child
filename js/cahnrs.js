var init_cahnrs_header = false;
var init_cahnrs_inf_load = false;

jQuery( document ).ready( function(jQuery){
	if( jQuery('body').find('#cahnrs-global-header').length > 0 ) init_cahnrs_header = new global_header();
	if( jQuery('main').hasClass('active_autoload') ) init_cahnrs_inf_load = new cahnrs_inf_load();
});


var global_header = function(){
	this.h = jQuery('#cahnrs-global-header'); // GLOBAL HEADER - DB
	this.dy_w = jQuery('.cahnrs-dynamic-frame');
	this.n_i = this.h.find('.nav-item'); // HEADER NAV ITEMS - DB
	this.n_s_s = this.h.find('.nav-sub-section'); // NAV SUB SECTIONS - DB
	this.nav_model = new Array();
	var s = this; // ASSIGN THIS TO S VAR - DB
	
	s.bld_sec_ary = function(){
		s.nav_model['active'] = false;
		i = 0;
		s.h.find('.nav-wrapper > li').each( function(){
			var a_lk = jQuery(this).children('a');
			var id = a_lk.data('base');
			var url = a_lk.attr('href');
			var is_selected = jQuery(this).hasClass('selected');
			//var active = ( is_selected )? true : false;
			var pobj = ( is_selected )? jQuery('#nav-section-default') :false;
			s.nav_model[ id ] = { 'index': i,'id': id , 'url': url,'pobj': pobj, 'nobj': jQuery(this) }
			i = i+1;
			if( is_selected ) s.nav_model['active'] = id; 
			/*a_lk.click( function( event ){ event.preventDefault(); s.hdl_chg_sec( id ) });*/
		});
	}
	
	s.b_e = function(){// BIND EVENTS - DB
		s.n_i.hover(
			function(){ s.h_s_l( jQuery(this) ) },
			function(){ s.h_h_l( jQuery(this) ) }
		);
	}
	s.hdl_chg_sec = function( sec_id ){
		if( sec_id == s.nav_model[ 'active' ] ) return false;
		
		var sec = s.nav_model[ sec_id ];
		if( !sec['pobj'] ){ // SECTION DOES NOT EXIST
			s.hdl_ld_sec( sec );
		} 
		s.chg_sec( sec_id );
		s.chg_glb_sel( sec );
	}
	s.chg_glb_sel = function( sec ){
		if( s.nav_model[ 'active' ] != sec['id'] ){
			s.nav_model[ sec['id'] ]['nobj'].addClass('selected').siblings().removeClass('selected');
			s.nav_model[ 'active' ] = sec['id'];
		}
	}
	s.chg_sec = function( sec_id ){ 
		var sec = s.nav_model[ sec_id ];
		var c_sec = s.nav_model[ s.nav_model[ 'active' ] ];
		var dir = ( sec['index'] > c_sec['index'] )? 1 : -1;
		var c_left = 150 * dir * -1;
		var n_left = 150 * dir;
		//s.nav_model[ s.nav_model[ 'active' ] ]['pobj'].removeClass('active');
		sec['pobj'].css('left', n_left+'%');
		sec['pobj'].addClass('cahnrs-page-next-slide-state');
		c_sec['pobj'].delay( 1000 ).animate({'left':c_left+'%'},1000);
		sec['pobj'].delay( 1000 ).animate({'left':'0%'},1000 , function(){
			c_sec['pobj'].removeClass('active');
			sec['pobj'].removeClass('cahnrs-page-next-slide-state').addClass('active');
			});
	}
	
	s.h_s_l = function( i_h ){ // HANDLE SHOW LINKS HOVER - DB
		i_h.addClass('active');
		setTimeout( function(){ s.s_l( i_h ) }, 150 );
	}
	s.h_h_l = function( i_h ){ // HANDLE HIDE LINKS HOVER - DB
		i_h.removeClass('active');
		s.h_l();
		
	}
	s.s_l = function( i_h ){ // SHOW LINKS - DB
		if( i_h.hasClass('active') ){
			i_h.find('.nav-sub-section').slideDown( 200 );
		}
	}
	s.h_l = function(){ // HIDE LINKS - DB
		s.n_s_s.slideUp( 150 );
	}
	s.hdl_ld_sec = function( sec ){ // HANDLE LOAD SECTION
		var id = 'nav-section-'+sec['id'];
		var w = '<div id="'+id+'" class="cahnrs-dynamic-window active iframe-window">';
		var i_f = '<iframe onload="init_cahnrs_header.set_frm_ht()" class="cahnrs_dynamic_frame" src="'+ sec['url'] +'?frame=true" frameborder="0" style="width: 100%; height: 4000px;" >';
		s.dy_w.append( w+i_f+'</iframe></div>' );
		s.nav_model[ sec['id']]['pobj'] = jQuery( '#'+id );
		console.log( s.nav_model );
	}
	
	s.set_frm_ht = function() {
		var frms = jQuery('.cahnrs-dynamic-window iframe');
		frms.each( function(){
			var c_frm = jQuery(this);
			var h = c_frm.contents().find('body').height() + 100;
			c_frm.height( h );
		})
		//alert( 'test fire');
	}
	
	s.bld_sec_ary();
	s.b_e();
}



/***********************************************************
** THIS IS ABOUT TO GET CRAZY **
** HANDLE INFINITE PAGE SCOLL AND ALOW FOR PLUGINS **
** AND ANYTHING ELSE THAT MIGHT GET THROW IN THERE - DB**
************************************************************/
var cahnrs_inf_load = function(){
	this.c_scroll = jQuery(window).scrollTop(); // Shouldn't be here - current scroll position 
	//this.c_nav = 0;
	//this.s_nav = false;
	//this.sp_n = jQuery('.spine-sitenav > ul > li');
	//this.nav_m = new Array(); // NAV MODEL - DB
	var s = this;
	
	s.b_e = function(){ // BIND EVENTS -- DB
		jQuery( window ).scroll( function(){ s.h_p_s( jQuery(this) ) } ).trigger('scroll');
	}
	
	s.h_p_s = function( c_s ){// HANDLE PAGE SCROLL CHECK
		var dw = jQuery('.cahnrs-dynamic-window.active'); // CURRENT DYNAMIC WINDOW
		if( dw.hasClass('iframe-window') ){ // If is an Iframe
			//var na_p = dw.find('iframe').contents().find('.cahrns-dynamic-page-load-wrapper.inactive'); // Find inactive items 
		} else { // Not an Iframe
			//var na_p = dw.find('.cahrns-dynamic-page-load-wrapper.inactive');
		}
		var dw_t = dw.offset().top; // DYNAMIC WINDOW TOP
		s.c_scroll = jQuery(window).scrollTop(); // Current scroll position 
		//alert( w );
		var n_s = jQuery(window).scrollTop(); // WINDOW SCROLL HEIGHT
		var w_h = jQuery(window).height(); // WINDOW HEIGHT
		//var w_h_50 = n_s + ( w_h * 0.5 ); // MID WINDOW - USED FOR NAV CHECK
		var d_h = dw.height() - 0 + dw_t; // CURRENT DYNAMIC WINDOW HEIGHT
		if( d_h < n_s + w_h )  s.h_d_p( dw ); // IF AT BOTTOM OF CURRENT DYNAMIC WINDOW LOAD NEXT SECTION
		//s.c_a_p( w_h_50 ); // CHECK NAV
		//s.c_scroll = n_s; // SET NEW SCROLL HEIGHT
	}
	s.h_d_p = function( dw ){ // HANDLE DISPLAY PAGE / Current Window - DB
		if( dw.hasClass('iframe-window') ){ // If is an Iframe
			var na_p = dw.find('iframe').contents().find('.cahrns-dynamic-page-load-wrapper.inactive'); // Find inactive items 
		} else { // Not an Iframe
			var na_p = dw.find('.cahrns-dynamic-page-load-wrapper.inactive');
		} 
		if( na_p.length > 0 ){
			var np = na_p.first();
			s.h_d_i( np );
			np.slideDown('slow' , function(){
				jQuery( this ).removeClass('inactive');
				});
			
		}
		//if( !jQuery('.cahnrs-dynamic-window.active').hasClass('iframe-window') ){ // If not Iframe
			//var ldr = jQuery('.cahnrs-postload-loader.active').last();
			//'var n_ldr = jQuery('.cahrns-dynamic-page-load-wrapper.inactive').first(); // Get first inactive
		//} else {
			//var fr = jQuery('.cahnrs-dynamic-window.active').find('iframe');
			//var frm_c = fr.contents();
			//var ldr = frm_c.find('.cahnrs-postload-loader.active').last();
			//var n_ldr = frm_c.find('.cahnrs-postload-loader.inactive').first();
			//fr.height( fr.height() + 4000 );
		//}
		//if( !ldr.hasClass('cahnrs-loading') ){
			//ldr.addClass('cahnrs-loading');
			//var n_p = ldr.next('.cahnrs-postload-page');
			//n_p.addClass('active').removeClass('inactive');
			//s.h_d_i( n_p );
			//ldr.delay(400).slideUp('medium', function(){
			//});
			//n_p.delay(400).fadeIn('slow' , function(){
				//ldr.removeClass('active');
				//n_ldr.addClass('active').removeClass('inactive');
				//if (typeof init_cahnrs_header !== typeof undefined && init_cahnrs_header !== false) {
					///init_cahnrs_header.set_frm_ht();
				//}
				//});
			
		//}
	}
	
	s.h_d_i = function( page ){ // HANDLE DISPLAY IMAGES - DB
		var n_p_i = page.find('img');
			n_p_i.each( function(){
				var d_s = jQuery( this ).data('src');
				if (typeof d_s !== typeof undefined && d_s !== false) {
					jQuery(this).attr('src',d_s);
				}
			});
	}
	
	s.c_a_p = function( w_b ){
		//var p = jQuery('.cahnrs-postload-page.active');
		//var c_m = s.sp_n.first();
		//p.each( function( index ){
			//var o_t = jQuery(this).offset().top;
			//var o_b = o_t + jQuery(this).height();
			//c1 = ( o_t < w_b )? true : false;
			//c2 = ( o_b > w_b )? true : false;
			//if( o_t < w_b && o_b > w_b ) {
				//var m = jQuery(this).data('menu');
				//if (typeof m !== typeof undefined && m !== false) {
					//c_m = jQuery('#'+m);
				//}
				//return false;
			//}
		//});
		//c_m.addClass('current dogeared active').siblings().removeClass('current dogeared active');
		//c_m.find('.overview').addClass('current dogeared active');
		//c_m.siblings().find('.overview').removeClass('current dogeared active');
	}
			
	s.b_e(); // BIND EVENTS
}



