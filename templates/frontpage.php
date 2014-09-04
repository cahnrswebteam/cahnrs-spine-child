<?php if( isset( $_GET['json'] ) ) {
	ob_start();
	$page_data = array();
}?>
<?php get_header(); ?>
<?php get_template_part('parts/headers'); ?>
<main class="spine-page-default active_autoload">
	

	
	<!--<section id="primary-section"> -->
<!--<div class="cahnrs-dynamic-frame"> -->
		<!--<div id="nav-section-default" class="cahnrs-dynamic-window active"> -->
		<?php while ( have_posts() ) : the_post(); ?>
	
			<?php get_template_part('parts/single'); ?>
		
		<?php endwhile;?>
        <?php if( get_option( 'cahnrs_setting_dynamic_load' ) ):?>
        	<?php get_template_part('parts/dynamic_load');?>
        <?php endif;?>
        <?php 
			$page_json = file_get_contents( 'http://api.wpdev.cahnrs.wsu.edu/cache/globalpage/globalpage.json' );
			$pages = json_decode( $page_json );
			foreach( $pages as $page ){
				echo '<div class="cahnrs-inview-slide">';
				$html = $page->data->html;
				echo $html;
				echo '</div>';
			}// end foreach
		?>
           <!-- </div> -->
<!--</div> -->
	<!--</section> -->
</main>

<?php get_footer(); ?>
<?php if( isset( $_GET['json'] ) ) {
	$html = ob_get_clean();
	$html = preg_split( '/<main[^>]+\>/i', $html );
	$html = explode( '</main>', $html[1] );
	$html = $html[0];
	$page_data['html'] = $html;
	//echo json_encode( $page_data['html'] );
	$page_data['scripts'] = array();
	$page_data['styles'] = array();
	global $wp_scripts, $wp_styles;
	foreach( $wp_scripts->done as $script ){
		$cs = $wp_scripts->registered[ $script ];
		$page_data['scripts'][] = array( 'id' => $script, 'link' => $cs->src );
	}
	foreach( $wp_styles->done as $style ){
		$cs = $wp_styles->registered[ $style ];
		$page_data['styles'][] = array( 'id' => $style, 'link' => $cs->src );
	}
	echo json_encode( $page_data );
}?>
