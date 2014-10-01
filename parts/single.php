<?php // Just a stub for now 
global $post;
$subhead = false;
if( is_front_page()){
	$meta = get_post_meta( $post->ID , '_post_subtitle', true );
	if( $meta ) $subhead = $meta;
}
?>		
<article id="post-<?php the_ID(); ?>" class="post-<?php the_ID(); ?> primary-article" <?php /* post_class();*/ ?> >
	<header class="article-header">
    <h1 class="article-title"><?php the_title(); ?></h1>
    <?php if( $subhead ):?> 
    <div class="article-subtitle"><?php echo $subhead;?></div>
    <?php endif;?>
	</header>
	<?php the_content(); ?>
</article>