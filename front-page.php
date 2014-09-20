<?php 
$has_pageslide = ( get_option( 'cahnrs_setting_dynamic_load' ) && !isset( $_GET['json'] ) )? true : false ;
get_header();
 
?>
<main class="spine-page-default active_autoload">
	<?php get_template_part('parts/headers');?>
	<?php 
    if( $has_pageslide ) echo '<div class="cahnrs-inview-slide activeslide">'; 
    if ( have_posts() ) {
        while ( have_posts() ) {
            the_post(); 
            get_template_part('parts/single');
        } // end while
    } // end if
	if( $has_pageslide ) get_template_part('parts/dynamic_scroll');
    if( $has_pageslide ) echo '</div>'; 
    if( $has_pageslide ) get_template_part('parts/dynamic_load'); ?>
</main>
<?php get_footer(); ?>