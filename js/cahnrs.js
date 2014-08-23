jQuery( document ).ready( function(jQuery){
	//if( jQuery('body').find('#cahnrs-global-header').length > 0 ) var init_cahnrs_header = new global_header();
	//if( jQuery('main').hasClass('active_autoload') ) var init_cahnrs_inf_load = new cahnrs_inf_load();
	//var init_cahnrs_responsive_videos = new cahnrs_responsive_videos();
	if( jQuery('main').hasClass('active_autoload') ) var init_cahnrs_spine = new cahnrs_spine();
});

var cahnrs_spine = function(){
	var $ = jQuery;
	this.pgld_obj = false
	s = this;
	
	s.set_frm_hght = function( frm ){
		var hgt = frm.contents().find('body').innerHeight();
		hgt = hgt + 50;
		frm.height( hgt+'px' );
		console.log( hgt );
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
					$( 'main').append( html );
					//$('iframe#frame-'+value.menu_id ).ready( function(){ s.set_frm_hght( $(this) ) } );
					$('iframe#frame-'+value.menu_id ).load( function(){ s.set_frm_hght( $(this) )  } );
					s.pgld_obj[ index ].rendered = true;
					return false;
				}
			})
		}
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
			if( $(window).scrollTop() + $(window).height() > $('main .active_autoload' ).height() - 200){
				s.add_dyn_pg();
			}
		});
		//$('body').on( 'ready' , 'iframe.pagebuilder-layout', function(){ alert('ready') } )
	}
}