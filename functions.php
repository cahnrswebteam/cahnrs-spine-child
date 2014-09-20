<?php
class cahnrs_spine_child {
	public $site_menu = array();
	public $global_obj= false;
	
	public function __construct() {
		/**************************** 
		** DEFINE DIRECTORY, URI, AND OTHER THEME CONSTANTS - DB **
		***************************/
		$this->define_constants();

		// Includes - PC
		$this->init_includes();

		/**************************** 
		** OVERRIDE CSS AND SCRIPT FILES WITH LOCAL COPIES FOR NOW - DB **
		***************************/
		add_action( 'wp_enqueue_scripts', array( $this, 'local_file_override' ), 90 ); 
		
		/**************************** 
		** ADD CHILD THEME CSS AND SCRIPTS - DB **
		***************************/
		add_action( 'wp_enqueue_scripts', array( $this, 'cahnrs_scripts' ), 20 );
		
		/**************************** 
		** IFRAME TEMPLATE - DB ********
		*****************************/
		if( isset( $_GET['frame'] ) || isset( $_GET['site-json'] ) || isset( $_GET['json'] ) || $_GET['page-ajax'] ) 
			add_filter( 'template_include', array( $this, 'render_as_frame' ), 99 );

		/**************************** 
		** ADD THEME SCROLL SETTINGS TO SETTINGS->READING - DB **
		*****************************/
		add_action( 'admin_init', array( $this, 'reading_settings_api_init' ) );

		/**************************** 
		** ADD CUSTOM IMAGE SIZES **
		*****************************/
		add_action( 'init', array( $this, 'add_image_sizes' ) );
		add_filter( 'image_size_names_choose', array( $this, 'add_custom_image_sizes' ) );
		
		// Register Horizontal menu - PC
		// Made this generic so we can use it with other menus - DB
		add_action( 'init', array( $this, 'cahnrs_menu' ) );

		// Override theme style - PC (not sure how to actually use this yet)
		//add_filter( 'spine_option', array( $this, 'cahnrs_spine_option_defaults' ) );

		// Allow some HTML in taxonomy item descriptions
		remove_filter( 'pre_term_description', 'wp_filter_kses' );
		add_filter( 'pre_term_description', array( $this, 'cahnrs_item_description_kses' ) );

		/*************************************
		** Testing **************************/
		if( isset( $_GET[ 'front'] ) ){
			add_action( 'wp_enqueue_scripts', array( $this , 'check_scripts' ) , 9999 ); 
		}
	}
	/*************************************
		** Testing **************************/
	public function check_scripts(){
		$page_json = file_get_contents( 'http://api.wpdev.cahnrs.wsu.edu/cache/globalpage/globalpage.json' );
		$pages = json_decode( $page_json );
		foreach( $pages as $page ){
			$scripts = $page->data->scripts;
			$styles = $page->data->styles;
			foreach( $scripts as $script ){
				if( !wp_script_is( $script->id, 'enqueued' ) ){
					\wp_enqueue_script( $script->id, CAHNRS2014URI . $script->src, array(), '1.0.0', false );
					//echo 'true'.$script->id;
				} // end if
			} // end foreach
			foreach( $styles as $style ){
				if( !wp_script_is( $style->id, 'enqueued' ) ){
					\wp_enqueue_style( $style->id, CAHNRS2014URI . $style->src, array(), '1.0.0', false ); //echo 'true'.$script->id;
				} // end if
			} // end foreach
		}
	}
	
	
	private function define_constants() {
		define( 'CAHNRS2014DIR', get_stylesheet_directory() ); // CONSTANT FOR THEME DIRECTORY - DB
		define( 'CAHNRS2014URI', get_stylesheet_directory_uri() ); // CONSTANT FOR THEM URI - DB
	}

	private function init_includes() {
		require get_stylesheet_directory() . '/inc/template-tags.php';
	}
	
	public function cahnrs_scripts() {
		wp_enqueue_script( 'wsu-cahnrs-js', CAHNRS2014URI . '/js/cahnrs.js' , array(), '1.1.0', false );
		if ( get_option( 'cahnrs_setting_global_nav' ) || has_nav_menu( 'cahnrs_horizontal' ) )
			wp_enqueue_style( 'wsu-cahnrs-header', CAHNRS2014URI . '/css/header.css', array(), '1.1.0' );
		wp_enqueue_script( 'history-js', CAHNRS2014URI . '/js/history.adapter.jquery.js' , array(), '1.1.0', false );
		wp_enqueue_script( 'history-jquery-js', CAHNRS2014URI . '/js/history.html4.js' , array(), '1.1.0', false );
		wp_enqueue_script( 'history-html4-js', CAHNRS2014URI . '/js/history.js' , array(), '1.1.0', false );
	}
	
	public function local_file_override() {
		/** HANDLE SPINE SCRIPT ******************/
		wp_deregister_script( 'wsu-spine' ); // DEREGISTER REMOTE COPY - DB
		if( !isset( $_GET['frame'] ) ) wp_enqueue_script( 'wsu-spine', CAHNRS2014URI . '/js/spine.min.js', array( 'wsu-jquery-ui-full' ), '1.0.0', false );
		/** HANDLE SPINE STYLE ******************/
		wp_deregister_style( 'wsu-spine' ); // DEREGISTER REMOTE COPY - DB
		wp_enqueue_style( 'wsu-spine', CAHNRS2014URI . '/css/spine.min.css', array(), '1.0.0' );
		/***************************/		
	}
	
	public function render_as_frame( $template ) {
		if( isset( $_GET['frame'] ) ){
			return CAHNRS2014DIR . '/templates/embed.php';
		}
		else if( isset( $_GET['site-json'] ) ){
			return CAHNRS2014DIR . '/templates/site_json.php';
		}
		else if( isset( $_GET['json'] ) ){
			return CAHNRS2014DIR . '/templates/json.php';
		}
		else if( isset( $_GET['page-ajax'] ) ){
			return CAHNRS2014DIR . '/templates/page-ajax.php';
		}
		return $template;
	}
	
	public function reading_settings_api_init() {
		// Add the section to reading settings so we can add our
		// fields to it
		add_settings_section(
			'cahnrs_reading_setting_section',
			'Dynamic Page Load & Slide Settings',
			array( $this , 'eg_setting_section_callback_function' ),
			'reading'
		);
		
		// Add the field with the names and function to use for our new
		// settings, put it in our new section
		add_settings_field(
			'cahnrs_setting_dynamic_load',
			'Activate Dynamic Page Load',
			array( $this , 'cahnrs_load_setting_callback_function' ),
			'reading',
			'cahnrs_reading_setting_section'
		);
		/* PC - Subverting this one
		add_settings_field(
			'cahnrs_setting_dynamic_slide',
			'Use CAHNRS Global Navigation',
			array( $this , 'cahnrs_slide_setting_callback_function' ),
			'reading',
			'cahnrs_reading_setting_section'
		);
		*/
		add_settings_field(
			'cahnrs_setting_global_nav',
			'Use CAHNRS Global Navigation',
			array( $this , 'cahnrs_nav_setting_callback_function' ),
			'reading',
			'cahnrs_reading_setting_section'
		);
		
		// Register our setting so that $_POST handling is done for us and
		// our callback function just has to echo the <input>
		register_setting( 'reading', 'cahnrs_setting_dynamic_load' );
		register_setting( 'reading', 'cahnrs_setting_global_nav' );
	}

	public function eg_setting_section_callback_function() {
		echo '<p>Settings to turn on or off dynamic page loading.</p>';
	}

	public function cahnrs_load_setting_callback_function() {
		echo '<input name="cahnrs_setting_dynamic_load" type="checkbox" value="1" class="code" ' . checked( 1, get_option( 'cahnrs_setting_dynamic_load' ), false ) . ' />';
	}

	public function cahnrs_nav_setting_callback_function() {
		echo '<input name="cahnrs_setting_global_nav" type="checkbox" value="1" class="code" ' . checked( 1, get_option( 'cahnrs_setting_global_nav' ), false ) . ' />';
	}

	public function add_image_sizes() {
		 add_image_size( '4x3-medium', 400, 300, true );
		 add_image_size( '3x4-medium', 300, 400, true );
		 add_image_size( '16x9-medium', 400, 225, true );
		 add_image_size( '16x9-large', 800, 450, true );
	}

	public function add_custom_image_sizes( $sizes ) {
		return array_merge( $sizes, array(
			'4x3-medium' => '4x3-medium',
			'3x4-medium' => '3x4-medium',
			'16x9-medium' => '16x9-medium',
			'16x9-large' => '16x9-large',
		) );
	}

	public function cahnrs_menu() {
		register_nav_menu( 'cahnrs_horizontal', 'Horizontal' );
		register_nav_menu( 'cahnrs_deeplinks', 'Site Deeplinks' );
	}

	public function cahnrs_spine_option_defaults() {
		$spine_options[ 'theme_style' ] = 'skeleton';
		return $spine_options[ 'theme_style' ];
	}

	// I bet there's a better/safer way to do this
	public function cahnrs_item_description_kses( $text ) {
		return strip_tags( $text, '<a><br><h1><h2><h3><h4><h5><h6><img><p><em><span>' );
	}

	/**************************** 
	** START SERVICES SECTION - DB **
	***************************/
	
	public function service_get_global_obj(){
		if( $this->global_obj ) return $this->global_obj; // If already set use existing
		$url = 'http://api.wpdev.cahnrs.wsu.edu/cache/globalpage/globalpage.json'; // Url for JSON
		try { // Just in case of error
			$json = file_get_contents( $url ); // Get the Json
		} catch ( Exception $e ) { // No file found
			$json = false;  // Write a blank array - TO Do: add local backup;
		}; // end try/catch
		$obj = ( $json )? json_decode( $json ) : array();
		$this->global_obj = $obj; // Set class property for later use
		return $obj; // Return the object
	}
	
	/*public function service_check_selected_nav( $url ) { // TO-DO CRATE THIS FOR REAL - DB
		$site_url = rtrim( \home_url(), '/' );
		if( $url ==	$site_url) {
			return ' selected';
		} else {
			return $site_url;
		}
	}*/
	
	/*public function service_get_global_menu_obj() {
		if( !$this->site_menu ) {
			$global_nav_json = file_get_contents( 'http://api.wpdev.cahnrs.wsu.edu/?service=globalnav' );
			$global_nav = json_decode( $global_nav_json, true );
			if( $global_nav ) { 
				$this->site_menu = $global_nav;
				return $global_nav; 
			} else {
				return $this->site_menu;
			}
		} else {
			return $this->site_menu;
		}
	}*/
	
	/*public function service_get_global_menu_obj2() {
		if( !$this->site_menu ) {
			$page_json = file_get_contents( 'http://api.wpdev.cahnrs.wsu.edu/cache/globalheader/global-header.json' );
			$page = json_decode( $page_json, true );
			if( $page ) { 
				$this->site_menu = $page;
				return $page; 
			} else {
				return $this->site_menu;
			}
		} else {
			return $this->site_menu;
		}
	}*/
	
	/*public function service_get_nav_blog_ids() {
		$site_menu = $this->service_get_global_menu_obj();
		$blog_ids = array();
		foreach( $site_menu['nav_items'] as $n_s ) {
			$blog_ids[] = $n_s['blog-id'];
		}
		return $blog_ids;
	}*/
	
	/*public function service_get_top_menu_pages() {
		$menu_ids = $this->service_get_post_from_nav( 'site' );
		$args = array();
		$args['post__in'] = $menu_ids['id_set'];
		$args['post_type'] = 'any';
		$args['orderby'] = 'post__in';
		$the_query = new WP_Query( $args );
		$is_first = true;
		if ( $the_query->have_posts() ) {
			ob_start();
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				$active = 'inactive';
				if( $is_first ) { $is_first = false; $active = 'active'; };
				echo '<div class="cahnrs-postload-loader '.$active.'">Loading '.get_the_title().' ...</div>';
				echo '<div class="cahnrs-postload-page inactive" data-menu="menu-item-'.$menu_ids[$the_query->post->ID].'" style="display: none;">';
				get_template_part('articles/article');
				echo '</div>';
			}
			echo $this->service_filter_images( ob_get_clean() ); 
		} else {
		}
		wp_reset_postdata();
	}*/
	
	/*public function service_filter_images( $content ) {
		 $content = preg_replace_callback( "/<img[^>]+\>/i", array( $this, 'service_replace_src' ), $content );
		 return $content; 
	}*/
	
	/*private function service_replace_src( $matches ) {
		$new_src ='';
		if ( $matches[0] ) {
			$new_src = preg_replace_callback( 
				"/src=\"[^>]+\"/i", 
				function( $mat ) { 
					return 'src="' . CAHNRS2014URI . '/images/place_holder.gif" data-src=' . str_replace( 'src=', '', $mat[0] );
				}, 
			$matches[0] );
		}
		return $new_src;
	}*/
	
}

$wsu_cahnrs_spine = new cahnrs_spine_child();
?>