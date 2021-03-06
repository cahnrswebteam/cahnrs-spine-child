<?php get_header(); ?>



<main class="spine-category-template">
<?php get_template_part('parts/headers'); ?> 
	<section class="row sidebar side-right">

		<header class="archive-header">
			<h1 class="archive-title"><?php single_cat_title(); ?> Archive</h1>
		</header>

		<div class="column one">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'articles/post', get_post_format() ); ?>

			<?php endwhile; ?>

		</div><!--/column-->

		<div class="column two">

			<?php
			if ( category_description() ) :
				echo '<div class="pagebuilder-item">';
				echo wp_kses_post( category_description() );
				echo '<br style="clear:both;">';
				echo '</div>';
			endif;
			?>

			<?php get_sidebar(); ?>

		</div><!--/column two-->

		<?php cahnrs_paging_nav(); ?>

	</section>

<?php /*
global $wp_query;

$big = 99164; // need an unlikely integer
$args = array(
	'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
	'format'			 => 'page/%#%',
	// 'total'				=> 5,
	// 'current'			=> 0,
	'show_all'		 => False,
	// 'end_size'		 => 3,
	// 'mid_size'		 => 4,
	'prev_next'		=> True,
	'prev_text'		=> __('« Previous'),
	'next_text'		=> __('Next »'),
	// 'type'				 => 'plain',
	'add_args'		 => False,
	'add_fragment' => ''
); ?>

<?php echo paginate_links( $args ); */ ?>

</main>

<?php get_footer(); ?>