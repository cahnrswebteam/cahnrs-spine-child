<?php get_header(); ?>
<?php get_template_part('parts/headers'); ?> 
<main class="spine-page-default">
<!--<div class="cahnrs-dynamic-frame"> -->
	
		<?php while ( have_posts() ) : the_post(); ?>
	
			<?php get_template_part('parts/single'); ?>
		
		<?php endwhile; ?>
<!--</div>-->
</main>

<?php get_footer(); ?>