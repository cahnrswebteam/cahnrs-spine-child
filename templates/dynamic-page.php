<?php if( isset( $_GET['json'] ) ) ob_start();?>
<?php get_header(); ?>
<?php get_template_part('parts/headers'); ?>
<main class="spine-page-default active_autoload">
	

	
	<!--<section id="primary-section"> -->
<!--<div class="cahnrs-dynamic-frame"> -->
		<!--<div id="nav-section-default" class="cahnrs-dynamic-window active"> -->
		<?php while ( have_posts() ) : the_post(); ?>
	
			<?php get_template_part('parts/single'); ?>
		
		<?php endwhile; ?>
        <?php get_template_part('parts/dynamic_load');?>
           <!-- </div> -->
<!--</div> -->
	<!--</section> -->
</main>

<?php get_footer(); ?>
<?php if( isset( $_GET['json'] ) ) echo json_encode( ob_get_clean() );?>