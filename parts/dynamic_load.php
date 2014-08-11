<?php 
if( get_option( 'cahnrs_setting_dynamic_load' ) ){
	global $wsu_cahnrs_spine;
	if( $wsu_cahnrs_spine && method_exists ( $wsu_cahnrs_spine , 'service_get_top_menu_pages' ) ){
		$wsu_cahnrs_spine->service_get_top_menu_pages();
	} 
};?>