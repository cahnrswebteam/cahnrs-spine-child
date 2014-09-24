<?php 
global $wsu_cahnrs_spine;
if( get_option( 'cahnrs_setting_dynamic_load' ) && !isset($_GET['slide'] ) ){
	//$page_json = file_get_contents( 'http://api.wpdev.cahnrs.wsu.edu/cache/globalpage/globalpage.json' );
	$pages = $header_data = $wsu_cahnrs_spine->service_get_global_obj();
	foreach( $pages as $page ){
		
		echo '<div class="cahnrs-inview-slide" name="'.$page->data->name.'">';
		echo '<div class="cahnrs-bg-slide" style="background-image: url('.$page->data->bg.')"></div>';
		//$easteregg = ( isset( $page->data->easteregg ) )? $page->data->easteregg : '';
		//echo $easteregg;
		$html = $page->data->html;
		echo $html;
		echo '</div>';
	}// end foreach
} // end if
?>
