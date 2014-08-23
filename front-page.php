<?php get_header(); ?>

<main class="spine-page-default active_autoload">
	

	<?php get_template_part('parts/headers'); ?>
	<section id="primary-section">
<!--<div class="cahnrs-dynamic-frame"> -->
		<!--<div id="nav-section-default" class="cahnrs-dynamic-window active"> -->
		<?php while ( have_posts() ) : the_post(); ?>
	
			<?php get_template_part('parts/single'); ?>
		
		<?php endwhile; ?>
        <?php get_template_part('parts/dynamic_load');?>
           <!-- </div> -->
<!--</div> -->
	</section>
</main>

<?php get_footer(); ?>