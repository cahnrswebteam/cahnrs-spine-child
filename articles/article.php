<?php // Just a stub for now ?>
		
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
    // if ( ! is_front_page() ) the_title( '<header class="article-header"><h1 class="article-title">', '</h1></header>' );
		// Well, shucks... doesn't work because they could technically all be the front page
		// Would also be too inclusive
	?>
	<header class="article-header">
    <h1 class="article-title"><?php the_title(); ?></h1>
	</header>
	<?php the_content(); ?>
</article>