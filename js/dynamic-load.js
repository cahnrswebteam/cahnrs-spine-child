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
	this.act_win = $(document);
	this.act_win_frm = false;
	s = this;
	
	s.set_frm_hght = function( frm ){
		var hgt = frm.contents().find('body').innerHeight();
		hgt = hgt + 50;
		frm.height( hgt+'px' );
	}
	
	s.add_dyn_pg = function(){
		/*if( s.pgld_obj ){ // Check if pageload object exists
			$.each( s.pgld_obj , function( index, value ){
				//console.log( value.active );
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
		}*/
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
	
	/*s.gt_pg_brk = function( index , value ){
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
	}*/
	
	/** Check if load array exists and has stuff in it **/
	if( 0 < s.act_win.find('article.dynamic-iframe-page.inactive').length ){
		//s.pgld_obj = cahnrs_load_json; // Set pgld_ogj
		//var dy_frm = $('.cahnrs-dynamic-frame');
		/*if( !$('.pagebuilder-layout').parent().hasClass( 'cahnrs-dynamic-frame ') ) {
				$('.pagebuilder-layout').wrap('<div class="cahnrs-dynamic-frame"></div>"');
		}*/
		//alert( cahnrs_load_json.length );
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
		//$('body').on( 'ready' , 'iframe.pagebuilder-layout', function(){ alert('ready') } )
	}
	
	s.chg_pg_sec = function( c , bid , i ){
		cs = $( '.cahnrs-page-slide.currentslide').first();
		ns = $('#'+bid );
		nsbg = $('.cahnrs-page-slide-bg.'+ bid );
		csbg = $('.currentslide-bg.cahnrs-page-slide-bg');
		//alert( bid );
		if( cs.length > 0 && cs.attr('id') != ns.attr('id') ){
			nsbg
			c_i = s.gbl_nav.find('.nav-item.selected').index();
			var di = ( c.parent('li').index() > c_i )? 1 : -1;
			ns.addClass('nextslide');
			c.parent('li').addClass('selected').siblings().removeClass('selected');
			//i = c.parent('li').index();
			nsbg.show().addClass('currentslide-bg');
			csbg.hide().removeClass('currentslide-bg');
			var clft = {'left': (150 * di  * -1) + '%' };
			ns.css('left', (150 * di ) + '%' );

			cs.animate( clft , 'slow' );
			ns.animate( { left:'0px' } , 'slow',function(){
				cs.removeClass('currentslide selected');
				ns.removeClass('nextslide').addClass('currentslide selected');
				s.act_win = ns.find('iframe').contents();
				s.act_win_frm = ns.find('iframe');
				});
		}
	}
	
	s.hdl_gbl_nav = function(){ 
		if( typeof api_globalheader !== 'undefined' ){
			var sw = $( 'main');
			sw.wrapInner('<div  class="cahnrs-page-slide currentslide" ></div>');
			for( var i = 0; i < api_globalheader.length; i++ ){
				var slide = '<iframe class="cahnrs-page-frame" src="about:blank" data-src="'+api_globalheader[i].url+'" style="width: 100%;height: 800px;" /></iframe>';
				var slide = '<div id="frame-'+api_globalheader[i].id+'" class="custom-frame cahnrs-page-slide frame-'+api_globalheader[i].id+'" >'+slide+'</div>';
				$('.cahnrs-page-slide').last().after( slide );
				var slidebg = '<div class="cahnrs-page-slide-bg frame-'+api_globalheader[i].id+'" style="background-image: url('+api_globalheader[i].data.background+');" ></div>';
				$('body').append( slidebg  );
			}
			
		}
		$(window).load( function(){
			$('.cahnrs-page-slide iframe.cahnrs-page-frame').each( function( index ){
				cs = $(this);
				cs.attr('src', cs.data('src')+'?frame=true&scroll=true' );
			});
			s.gbl_nav_itm.children('a').on('click',function( event , index ){ 
				event.preventDefault(); 
				//alert('fire');
				s.chg_pg_sec( $(this) , $(this).data('base') , index ); 
				});
		});	
		$('body iframe').on('load',function(){ s.set_frm_hght( $(this) ) });
	}
	
	if( s.gbl_nav.length > 0 ) s.hdl_gbl_nav();
}