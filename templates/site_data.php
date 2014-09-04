<?php
class cahnrs_json_site_data {
	public $site_data = array();
	
	public function __construct(){
		//$this->site_data['menu'] = $this->get_menu();
		//$this->site_data['scripts'] = $this->get_scripts();
		$this->site_data['page'] = $this->get_page();
		$this->site_data['background'] = $this->get_background();
		$this->site_data['home'] = $this->get_home();
		
		//\add_action( 'wp_print_scripts', array( $this , 'inspect_scripts' ) );
	}
	
	public function get_home(){
		return \get_home_url();
	}
	
	public function inspect_scripts(){
		global $wp_styles;
		var_dump( $wp_styles );
		echo 'test';
	}
	
	/*public function get_menu(){
		$menu = '';
		if( \has_nav_menu( 'site' ) ){
			ob_start();
			\wp_nav_menu( array( 'theme_location'  => 'site' ) );
			$menu = ob_get_clean();
		}
		return $menu;
	}*/
	
	/*public function get_scripts(){
		$page = '';
		ob_start();
		include( get_stylesheet_directory().'/front-page.php');
		$page_all = ob_get_clean();
		
		$head = explode('<head', $page_all );
		$head = '<head'.$head[1];
		$head = explode( '</head', $head );
		$head = $head[0].'</head>';
		
		return $head;
	}*/
	
	public function get_page(){
		ob_start();
		get_header();
		if ( have_posts() ) {
			while ( have_posts() ) {
				the_post(); 
				
				the_content();
				//
				// Post Content here
				//
			} // end while
		} // end if
		get_footer();
		$test = ob_get_clean();
		global $wp_scripts;
		foreach( $wp_scripts as $script ){
			echo $script->
		}
		var_dump( $wp_scripts );
		
		//$json = file_get_contents( 'http://m1.wpdev.cahnrs.wsu.edu?json=true');
		//if( $json ){
			//return json_decode( $json );
		//}
		//$page = '';
		//ob_start();
		//get_header();
        //get_footer();
		
		//include( get_stylesheet_directory().'/front-page.php');
		//$page_all = ob_get_clean();
		
		//$body = explode('<body', $page_all );
		//$body = $body[0];
		//$body = $page_all;
		//$body = '<body'.$body[1];
		//$body = explode( '</body', $body );
		//$body = $body[0].'</body>';
		
		return '';
	}
	
	public function get_background(){
		$args = array( 'posts_per_page' => 1, 'post_type' => 'easter-egg' );

		$easter_egg = get_posts( $args );
		foreach ( $easter_egg as $post ) { 
			setup_postdata( $post );
			$thumbnail = $url = wp_get_attachment_url( get_post_thumbnail_id( $post->ID) );
		}
		wp_reset_postdata();
		if( $thumbnail ){
			return $thumbnail;
		}else {
			return 'none';
		}
	}
	
	public function get_json() {
		echo json_encode( $this->site_data );
	}
}
$init_cahnrs_json_site_data = new cahnrs_json_site_data();
$init_cahnrs_json_site_data->get_json();
?>