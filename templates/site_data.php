<?php
class cahnrs_json_site_data {
	public $site_data = array();
	
	public function __construct(){
		$site_data['menu'] = $this->get_menu();
		$site_data['page'] = $this->get_page();
		print_r( $site_data );
	}
	
	public function get_menu(){
		$menu = '';
		if( \has_nav_menu( 'site' ) ){
			ob_start();
			\wp_nav_menu( array( 'theme_location'  => 'site' ) );
			$menu = ob_get_clean();
		}
		return $menu;
	}
	
	public function get_page(){
		$page = '';
		if( \has_nav_menu( 'site' ) ){
			ob_start();
			include 'm1.wpdev.cahnrs.wsu.edu';
			$page = ob_get_clean();
		}
		return $page;
	}
}
$init_cahnrs_json_site_data = new cahnrs_json_site_data();
?>