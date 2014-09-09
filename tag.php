<?php get_header(); ?>

<?php get_template_part('parts/headers'); ?> 

<main>

	<section class="row sidebar">

		<header class="archive-header">
			<h1 class="archive-title"><?php single_tag_title(); ?> Archive</h1>
		</header>

		<div class="column one">

			<?php while ( have_posts() ) : the_post(); ?>
	
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="entry-header">
					<h1 class="entry-title"><?php the_title(); ?></h1>
				</header>
				<?php the_content(); ?>
			</article>

			<?php endwhile; // end of the loop. ?>

		</div><!--/column-->

		<div class="column two">

			<?php get_sidebar(); ?>

		</div><!--/column two-->

	</section>

</main>

<?php get_footer(); ?>