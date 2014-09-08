<?php get_header(); ?>

<?php if ( have_posts() ) : ?>

<?php get_template_part('parts/headers'); ?>

<main class="spine-archive-template">

	<section class="row sidebar">
	
		<div class="column one">
		
			<?php while ( have_posts() ) : the_post(); ?>
					
				<?php get_template_part( 'articles/post', get_post_format() ); ?>
	
			<?php endwhile; ?>
			
		</div><!--/column-->
	
		<div class="column two">
			
			<?php get_sidebar(); ?>
			
		</div><!--/column two-->
	
	</section>

</main>

<?php endif; ?>

<?php get_footer(); ?>