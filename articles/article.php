<?php // Just a stub for now ?>
		
<article id="post-<?php the_ID(); ?>" class="post-<?php the_ID(); ?> active_autoload" <?php /* post_class();*/ ?> >
	<header class="article-header">
    <h1 class="article-title"><?php the_title(); ?></h1>
	</header>
	<?php the_content(); ?>
</article>