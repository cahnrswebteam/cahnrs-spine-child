<?php get_header(); ?>

<?php if ( have_posts() ) : ?>

<?php get_template_part('parts/headers'); ?>

<main class="spine-archive-template">

	<section class="row sidebar">

		<header class="archive-header">
			<h1 class="archive-title"><?php
      	
				if ( is_day() ) :
					echo get_the_date() . ' Archives';

				elseif ( is_month() ) :
					echo get_the_date( 'F Y' ) . ' Archives';

				elseif ( is_year() ) :
					echo get_the_date( 'Y' ) . ' Archives';

				else :
					echo 'Archives';

				endif;
			
			?></h1>
		</header>

		<div class="column one">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'articles/post', get_post_format() ); ?>

			<?php endwhile; ?>

		</div><!--/column-->

		<div class="column two">

			<?php get_sidebar(); ?>

		</div><!--/column two-->

	</section>

	<?php cahnrs_paging_nav(); ?>

</main>

<?php endif; ?>

<?php get_footer(); ?>