<?php get_header(); ?>

<main class="spine-page-default">

<?php get_template_part('parts/headers'); ?> 
<!--<div class="cahnrs-dynamic-frame"> -->
	
		<?php while ( have_posts() ) : the_post(); ?>
	
			<?php get_template_part('articles/article'); ?>
		
		<?php endwhile; ?>
<!--</div>-->
</main>

<?php get_footer(); ?>