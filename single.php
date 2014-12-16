<?php $has_pageslide = ( get_option( 'cahnrs_setting_dynamic_load' ) && !isset( $_GET['json'] ) )? true : false ;?>
<?php get_header(); ?>

<main class="spine-page-default"> 
<?php get_template_part('parts/headers'); ?>
<!--<div class="cahnrs-dynamic-frame"> -->
	<?php if( $has_pageslide ) echo '<div class="cahnrs-inview-slide activeslide">';?>
		<?php while ( have_posts() ) : the_post(); ?>
	
			<?php get_template_part( 'parts/single' ); ?>

			<?php if ( comments_open() ) { comments_template(); } ?>

		<?php endwhile; ?>
<!--</div>-->
	<?php if( $has_pageslide ) echo '</div>';?>
    <?php if( $has_pageslide ) get_template_part('parts/dynamic_load'); ?>
</main>

<?php get_footer(); ?>