jQuery( document ).ready( function(jQuery){
	//if( jQuery('body').find('#cahnrs-global-header').length > 0 ) var init_cahnrs_header = new global_header();
	//if( jQuery('main').hasClass('active_autoload') ) var init_cahnrs_inf_load = new cahnrs_inf_load();
	//var init_cahnrs_responsive_videos = new cahnrs_responsive_videos();
	if( jQuery('main').hasClass('active_autoload') ) var init_cahnrs_spine = new cahnrs_spine();
});

var cahnrs_spine = function(){
	var $ = jQuery;
	this.pgld_obj = false;
	this.gbl_nav = $( '#cahnrs-global-nav');
	this.gbl_nav_itm = this.gbl_nav.find('.nav-item');
	s = this;
	
	s.set_frm_hght = function( frm ){
		var hgt = frm.contents().find('body').innerHeight();
		hgt = hgt + 50;
		frm.height( hgt+'px' );
	}
	
	s.add_dyn_pg = function(){
		if( s.pgld_obj ){ // Check if pageload object exists
			$.each( s.pgld_obj , function( index, value ){
				console.log( value.active );
				if( !value.rendered && '#' != value.url ){
					switch ( value.type ){
						case 'post_type':
						case 'taxonomy':
							var html = s.gt_pg( index, value );
							break;
						default:
							var html = s.gt_lk( index, value );
							break;
					}
					html = s.gt_pg_brk( index , value )+ html;
					$( 'main').append( html );
					//$('iframe#frame-'+value.menu_id ).ready( function(){ s.set_frm_hght( $(this) ) } );
					$('iframe#frame-'+value.menu_id ).load( function(){ s.set_frm_hght( $(this) )  } );
					s.pgld_obj[ index ].rendered = true;
					return false;
				}
			})
		}
	}
	
	s.hdl_mnu_scr = function( c_hght ){
		var c_mnu = false;
		var hlf_win = c_hght - ( $(window).height() * 0.50 );
		var spl = $('.cahnrs-page-splitter');
		spl.each(function(){
			if( $(this).offset().top > hlf_win ) return false;
			c_mnu = $(this).data('menuid');
			console.log( $(this).data('menuid') );
			console.log( c_hght );
			console.log( hlf_win );
			console.log( $(this).offset().top );
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
	
	s.gt_pg_brk = function( index , value ){
		var plnk = '<div>'+value.title +' - <a href="#">Back to Top</a></div>';
		return '<div class="cahnrs-page-splitter" data-menuid="menu-item-'+value.menu_id+'"><hr />'+plnk+'</div>'
	}
	
	s.gt_pg = function( index , value ){
		var str = '<article id="post-'+value.post_id+'" class="post-'+value.post_id+' dynamic-iframe"><iframe id="frame-'+value.menu_id+'" style="width: 100%; height: 1400px;" class="dpl-menu-link-page" src="'+value.url+'?frame=true">';
		var str = str + '</iframe></article>';
		return str;
	}
	s.gt_lk = function( index , value ){
		var str = '<div class="dynamic-iframe dynamic-menu-custom">';
		str = str + '<a href="'+value.url+'" >';
		str = str + 'Visit: '+ value.title;
		str = str + '</a></section>';
		return str;
	}
	
	/** Check if load array exists and has stuff in it **/
	if( typeof cahnrs_load_json !== 'undefined' && 0 < cahnrs_load_json.length ){
		s.pgld_obj = cahnrs_load_json; // Set pgld_ogj
		var dy_frm = $('.cahnrs-dynamic-frame');
		/*if( !$('.pagebuilder-layout').parent().hasClass( 'cahnrs-dynamic-frame ') ) {
				$('.pagebuilder-layout').wrap('<div class="cahnrs-dynamic-frame"></div>"');
		}*/
		//alert( cahnrs_load_json.length );
		/**************************************************
		** Bind on scroll event to window and run it once**
		**************************************************/
		$(window).scroll( function() {
			var c_hght = $(window).scrollTop() + $(window).height();
			if( c_hght > $('main.active_autoload' ).height() - 200){
				s.add_dyn_pg();
			}
			s.hdl_mnu_scr( c_hght );
		});
		$(window).resize(function(){
			$('article.dynamic-iframe iframe').each(function(){ s.set_frm_hght( $(this) ); });
			});
		//$('body').on( 'ready' , 'iframe.pagebuilder-layout', function(){ alert('ready') } )
	}
	
	s.chg_pg_sec = function( c , bid , i ){
		cs = $( '.cahnrs-page-slide.currentslide').first();
		ns = $('#'+bid );
		if( cs.length > 0 && cs.attr('id') != ns.attr('id') ){
			ns.addClass('nextslide');
			c.addClass('selected').siblings().removeClass('selected');
			var di = ( c.index() > i )? 1 : -1;
			var clft = {'left': (150 * di ) + '%' };
			ns.css('left', (150 * di * -1 ) + '%' );
			cs.animate( clft , 'slow' );
			ns.animate( { left:'0px' } , 'slow',function(){
				cs.removeClass('currentslide selected');
				ns.removeClass('nextslide').addClass('currentslide selected');
				});
		}
	}
	
	s.hdl_gbl_nav = function(){
		$('main').wrapInner('<div  class="cahnrs-page-slide currentslide" ></div>');
		//$( '#cahnrs-pageslide').children().addClass('cahnrs-dynamic-slide');
		$(window).load(function(){
			var nav_itms = s.gbl_nav.find('.nav-item');
			nav_itms.each(function( index ){
				var cn = $(this);
				var baseid = cn.children('a').data('base');
				cn.on('click',function( event ){ 
					event.preventDefault();
					s.chg_pg_sec( $(this) , baseid , index );
				});
				html = '<div id="'+baseid+'" class="cahnrs-page-slide"><iframe src="'+cn.children('a').attr('href')+'?frame=true" style="position: relative; width: 100%; height: 8000px;" title="'+cn.children('a').text()+'"></iframe></div>';
				$('main').append( html );
			});
			//$('#jacket').css( { 'position':'absolute','width':'100%','height':'100%','top':0,'left':0});
			//$('#cahnrs-global-header').css( { 'position':'fixed','width':'100%','top':0,'left':0, 'z-index': 1000 });
			//jQuery('#cahnrs-pageslide').cycle({
				//fx: 'scrollHorz',
				//timeout: 0, 
				//next:   '#slide-next', 
				//prev:   '#slide-prev',
				//pager: '#page-slide-nav .sdc-content-wrap',
				//pager: '#cahnrs-global-nav ul',
				
				 // callback fn that creates a thumbnail to use as pager anchor 
				//pagerAnchorBuilder: function(idx, slide) { 
					//console.log( slide );
					//return '<li class="nav-item" ><a href="#">'+slide.title+'</a></li>'; 
				//} 
			//});
		});
		
		
		/*nav_itms.on('click', function( event ) {
			event.preventDefault();
			var html = '<iframe src="http://m1.wpdev.cahnrs.wsu.edu/?style=page-slide" style="position: absolute; width: 100%; height: 100%; top: 0; left: 0; "></iframe>';
			$('#jacket').after( html );
			});*/
	}
	
	if( s.gbl_nav.length > 0 ) s.hdl_gbl_nav();
}