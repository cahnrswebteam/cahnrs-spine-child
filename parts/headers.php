<?php

/**
 * Retrieve an array of values to be used in the header.
 *
 * site_name
 * site_tagline
 * page_title
 * post_title
 * section_title
 * subsection_title
 * posts_page_title
 * sup_header_default
 * sub_header_default
 * sup_header_alternate
 * sub_header_alternate
 */

$spine_main_header_values = spine_get_main_header();
global $wsu_cahnrs_spine;
$uses_global = get_option( 'cahnrs_setting_global_nav' );
$has_horiz_nav = has_nav_menu( 'cahnrs_horizontal' );
$data = array();
$data[] = 'data-sitename="'.$spine_main_header_values['site_name'].'"';
$data[] = 'data-pagetitle="'.$spine_main_header_values['page_title'].'"';
$data[] = 'data-posttitle="'.$spine_main_header_values['post_title'].'"';
$data[] = 'data-default="'.esc_html($spine_main_header_values['sub_header_default']).'"';
$data[] = 'data-alternate="'.esc_html($spine_main_header_values['sub_header_alternate']).'"';

?>
<header id="cahnrs-global-header" class="main-header">

	<div class="header-group hgroup">
    	<?php if ( !$uses_global && ! $has_horiz_nav ) get_template_part('parts/header','default'); ?>
		<sub class="sub-header" <?php echo implode( ' ', $data );?>>
        	<span class="sub-header-default">
				<?php 
				/* echo strip_tags( $spine_main_header_values['sub_header_default'], '<a>' ); */ 
				if ( $uses_global ) { 
					echo 'College of Agricultural, Human, and Natural Resource Sciences'; 
				} else {
					 bloginfo( 'name' ); 
					 /* making this a little more predictable - PC */ 
				};?>
            </span>
        </sub>	
	</div>

	<?php // The site is using the CAHNRS Global Nav or has a horizontal nav of its own
  	if ( $uses_global || $has_horiz_nav ) {
  		echo '<nav id="cahnrs-global-nav">';
    	if ( $uses_global ) {
			get_template_part('parts/header','cahnrs');
		} else {
			wp_nav_menu( array(
				'theme_location' => 'cahnrs_horizontal',
				'container'      => false,
				'menu_class'     => 'nav-wrapper',
				'fallback_cb'    => 'featured_nav_fallback',
				'depth'          => 1
			) );
		};
	echo '</nav>';
	};?>
</header>