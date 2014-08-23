<?php 
if( get_option( 'cahnrs_setting_dynamic_load' ) ){
	global $post;
	/*************************************************
	** Step 1, build an array of all menu items based **
	** on level - (1,2). Include menu_id, post_id , **
	** 'type' and 'link' **
	***************************************************/ 
	$menu_loc = 'site'; // TO DO: MAKE THIS A DROPDOWN IN THEME OPTIONS
	$nav_array = array(); // I'll poplulate this later 
	$locations = \get_nav_menu_locations(); // Get defined locations
	if ( $locations  && isset( $locations[ $menu_loc ] ) ) { // Check if menu exists
		$menu = wp_get_nav_menu_object( $locations[ $menu_loc ] ); // GET THE MENU OBJECT FROM LOCATION
		$menu_items = wp_get_nav_menu_items( $menu->term_id ); // GET MENU ITEMS FROM OBJECT ID
		foreach( $menu_items as $key => $menu ){ // Loop through all menu items
			$status = ( $post->ID == $menu->object_id )? true : false; // Check if is current page
			$nav_array[] = array( // Populate menu array
				'menu_id'  => $menu->ID, // menu id not the post id
				'post_id' => $menu->object_id, // post id
				'type' => $menu->type, // type ( page, taxonomy, custom )
				'url' =>  $menu->url, // 3 Guesses what this is
				'title' => $menu->title, // This sets the title - go figure
				'rendered' => $status, // Has it been rendered - mod with JS
				'is_current' => $status, // Is it the current page 
				'active' => $status, // Is it active - mod with JS
				);
		}
	} // end if
	/******************************************
	** Conver to JSON and encode on the page **
	*******************************************/
	echo '<script>';
	echo 'var cahnrs_load_json = '.json_encode( $nav_array );
	echo '</script>';
	
	/*echo '<div id="cahnrs-dynamic-page-load">';
	global $post;
	$current_page = $post->ID;
	$top_nav = array();
	$menu_loc = 'site'; // TO DO: MAKE THIS A DROPDOWN IN THEME OPTIONS
	$menu_name = $menu_loc; // LOCATION TO LOOK FOR
	if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_name ] ) ) { // CHECK IF 
		$menu = wp_get_nav_menu_object( $locations[ $menu_name ] ); // GET THE MENU OBJECT FROM LOCATION
		$menu_items = wp_get_nav_menu_items( $menu->term_id ); // GET MENU ITEMS FROM OBJECT ID
		foreach( $menu_items as $key => $menu ){ // LOOP THROUGH MENU ITEMS - DB
			if( !$menu->menu_item_parent && $menu->object_id != $current_page ){ // IF TOP LEVEL NAV
				$top_nav[] = $menu; // ADD TO TOP LE
			} // End if
		} // END FOREACHLOCATION IS SET
	};
	if( $top_nav ){ // Top nav exists
		foreach( $top_nav as $nav_item ){
			echo '<div class="cahrns-dynamic-page-load-wrapper inactive" data-menu="'.$nav_item->ID.'" >';
			if( 'post_type' == $nav_item->type && $nav_item->object_id != $current_page ){ // Is page/post/custom type 
			
				$the_query = new WP_Query(array('p' => $nav_item->object_id , 'post_type' => 'any' ) );
				if ( $the_query->have_posts() ) {
					while ( $the_query->have_posts() ) {
						$the_query->the_post();
						echo '<h2>';
						the_title();
						echo '</h2>';
						ob_start();
						the_content();
						echo service_filter_images( ob_get_clean());
					}
				}
				\wp_reset_postdata(); // RESET ORIGINAL QUERY - IT NEVER HAPPEND, YOU DIDN'T SEE ANYTHING
			} 
			else if('custom' == $nav_item->type ){ // Is link
			}
			else if('taxonomy' == $nav_item->type ){ // Is taxonomy
			}
			echo '</div>';
		}
	} // End if
	echo '</div>';

};

function service_filter_images( $content ) {
	$content = preg_replace_callback( "/<img[^>]+\>/i", 'service_replace_src', $content );
	return $content; 
}


function service_replace_src( $matches ) {
	$new_src ='';
	if ( $matches[0] ) {
		$new_src = preg_replace_callback( 
			"/src=\"[^>]+\"/i", 
			function( $mat ) { 
				return 'src="' . CAHNRS2014URI . '/images/place_holder.gif" data-src=' . str_replace( 'src=', '', $mat[0] );
			}, 
		$matches[0] );
	}
	return $new_src;*/
}

?>
