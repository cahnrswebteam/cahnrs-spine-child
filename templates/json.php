<?php
	$page_data = array();
	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();
			ob_start(); 
			get_template_part('parts/single');
			$page_data['post-'.$post->ID ]['html'] = ob_get_clean();
			$page_data['post-'.$post->ID ]['content'] = $post->post_content;
			$page_data['post-'.$post->ID ]['title'] = $post->post_title;
		} // end while
	} // end if
	echo json_encode( $page_data )
?>
	