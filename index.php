<?php get_header(); ?>

<?php get_template_part('parts/headers'); ?> 

<main class="spine-main-index">

	<section class="row side-right">

		<div class="column one">

			<?php // Introductory Article
			if ( ( get_post_status('1') == 'publish' ) && ( get_the_title('1') == 'Hello world!') ) { get_template_part( 'includes/startup/welcome' ); }	?>

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part('articles/post'); ?>

			<?php endwhile; // end of the loop. ?>

		</div><!--/column-->

		<div class="column two">

			<?php get_sidebar(); ?>

		</div><!--/column two-->

	</section>

  <?php cahnrs_paging_nav(); ?>

</main>

<?php get_footer(); ?>