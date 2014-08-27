<?php
class cahnrs_json_site_data {
	public $site_data = array();
	
	public function __construct(){
		$this->site_data['menu'] = $this->get_menu();
		$this->site_data['page'] = $this->get_page();
		$this->site_data['background'] = $this->get_background();
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
			include( get_stylesheet_directory().'/front-page.php');
			$page = ob_get_clean();
		}
		return $page;
	}
	
	public function get_background(){
		return 'http://stage.wpdev.cahnrs.wsu.edu/research/wp-content/uploads/sites/9/2014/08/DSC_9724.jpg';
	}
	public function get_json() {
		echo json_encode( $this->site_data );
	}
}
$init_cahnrs_json_site_data = new cahnrs_json_site_data();
$init_cahnrs_json_site_data->get_json();
?>