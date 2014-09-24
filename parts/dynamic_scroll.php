<?php
$c_parent = false;
$menu_loc = 'site'; // TO DO: MAKE THIS A DROPDOWN IN THEME OPTIONS
$nav_array = array(); // I'll poplulate this later 
$locations = \get_nav_menu_locations(); // Get defined locations
if ( $locations  && isset( $locations[ $menu_loc ] ) ) { // Check if menu exists
	$menu = wp_get_nav_menu_object( $locations[ $menu_loc ] ); // GET THE MENU OBJECT FROM LOCATION
	$menu_items = wp_get_nav_menu_items( $menu->term_id ); // GET MENU ITEMS FROM OBJECT ID
	foreach( $menu_items as $key => $menu ){ // Loop through all menu items
		$status = ( $post->ID == $menu->object_id )? true : false; // Check if is current page
		if( $menu->menu_item_parent ) {
			if( $c_parent && $menu->menu_item_parent == $c_parent ) {
				continue;
			} else {
				$c_parent = $menu->ID;
			}
		}
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
		if( $post->ID != $menu->object_id && 'custom' != $menu->type && !$menu->menu_item_parent ) {
			
			$splitter = '<article class="cahnrs-page-splitter inactive" data-menuid="menu-item-'.$menu->ID.'" data-url="'.$menu->url.'" name="'.htmlspecialchars( $menu->title ).'">';
			$splitter .= '<div class="cahnrs-page-break"><hr><a href="#" ></a></div><div class="chanrs-load-page"></div></article>';
			echo $splitter;
		}
	}
} // end if
?>