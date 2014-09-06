<?php if( get_option( 'cahnrs_setting_dynamic_load' ) ) {
		$page_json = file_get_contents( 'http://api.wpdev.cahnrs.wsu.edu/cache/globalpage/globalpage.json' );
		$pages = json_decode( $page_json );
		foreach( $pages as $page ){
			echo '<div class="cahnrs-inview-slide">';
			echo '<div class="cahnrs-bg-slide" style="background-image: url('.$page->data->bg.')"></div>';
			$html = $page->data->html;
			echo $html;
			echo '</div>';
		}// end foreach
	} // end if
?>
