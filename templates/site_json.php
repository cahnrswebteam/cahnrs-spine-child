<?php 
class cahnrs_site_json  {
	
	public $page_data = array();
	
	public function get_data(){
		ob_start();
		wp_head();
		wp_footer();
		$head = ob_get_clean();
		$this->page_data['html'] = $this->get_page();
		$this->page_data['scripts'] = $this->get_resources( 'scripts');
		$this->page_data['styles'] = $this->get_resources( 'styles');
		$this->page_data['menu'] = $this->get_menu('site');
		$this->page_data['offsitemenu'] = $this->get_menu('offsite');
		$this->page_data['home'] = get_home_url();
		$this->page_data['bg'] = $this->get_bg();
		$this->page_data['easteregg'] = $this->get_easteregg();
		$this->page_data['deeplinks'] = $this->get_deeplinks();
		echo json_encode( $this->page_data );
		//var_dump( $page_data['bg'] );
		//global $post;
		//$nav_array = array(); // I'll poplulate this later 
		
	}
	
	private function get_page(){
		ob_start();
		if ( have_posts() ) {
			while ( have_posts() ) {
				the_post();
				$this->page_data['name'] =  htmlspecialchars( get_the_title() );
				get_template_part('parts/single');
				get_template_part('parts/dynamic_scroll');
			} // end while
		} // end if
		return ob_get_clean();
	}
	
	private function get_resources( $source ){
		$temp_array = array();
		global $wp_scripts, $wp_styles;
		$source = ( 'scripts' == $source )? $wp_scripts : $wp_styles;
		foreach( $source->done as $script ){
			$cs = $source->registered[ $script ];
			$temp_array[] = array( 'id' => $script, 'link' => $cs->src );
		}
		return $temp_array;
	}
	
	private function get_menu( $menu ){
		if( !has_nav_menu( $menu ) ) return '<ul class="inactive"></ul>';
		ob_start();
		$site = array(
			'theme_location'  => $menu,
			'menu'            => $menu,
			'container'       => false,
			'container_class' => false,
			'container_id'    => false,
			'menu_class'      => null,
			'menu_id'         => null,
			'echo'            => true,
			'fallback_cb'     => 'wp_page_menu',
			'items_wrap'      => '<ul class="inactive">%3$s</ul>',
			'depth'           => 2,// Changed to 2 - PC
			'walker'          => ''
			);
		\wp_nav_menu( $site );
		return ob_get_clean();
	}
	
	private function get_deeplinks(){
		if ( has_nav_menu( 'cahnrs_deeplinks' ) ){
			ob_start();
			$deeplinks = array(
				'theme_location'  => 'cahnrs_deeplinks',
				'container'       => false,
				'container_class' => false,
				'container_id'    => false,
				'menu_class'      => null,
				'menu_id'         => null,
				'echo'            => true,
				'fallback_cb'     => false,
				'items_wrap'      => '<ul class="cahnrs-deeplinks">%3$s</ul>',
				'depth'           => 2,// Changed to 2 - PC
				'walker'          => ''
				);
			\wp_nav_menu( $deeplinks );
			return ob_get_clean();
		} else {
			return '';
		}
		
	}

	
	private function get_bg(){
		$args = array( 'posts_per_page' => 1, 'post_type' => 'easter-egg' );
		$easter_egg = get_posts( $args );
		if( $easter_egg ){
			setup_postdata( $easter_egg[0] );
			$thumbnail = wp_get_attachment_url( get_post_thumbnail_id( $easter_egg[0]->ID) );
			$thumbnail =  ( $thumbnail )? $thumbnail : '';
		}
		wp_reset_postdata();
		return $thumbnail;
	}
	
	private function get_easteregg(){
		ob_start();
		wp_footer();
		$footer = ob_get_clean();
		if( strpos( $footer , '<!-- easteregg -->' ) !== false ){
			$footer = explode( '<!-- easteregg -->' , $footer );
			return $footer[1];
		} else {
			return false;
		}
	}
	
	/*private function get_menus( $post ){
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
	}*/
}
$init_cahnrs_site_json = new cahnrs_site_json();
$init_cahnrs_site_json->get_data();