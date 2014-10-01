<?php get_template_part( 'spine' ); ?>

<?php get_template_part( 'parts/after-main' ); ?>
</div><!--/binder-->
<?php get_template_part( 'parts/after-binder' ); ?>
</div><!--/jacket-->
<?php get_template_part( 'parts/after-jacket' ); ?>

<?php get_template_part( 'parts/contact' ); ?>

<?php
	//if ( true == spine_get_option( 'crop' ) && is_front_page() ) get_template_part( 'spine/footer' );
	if ( true == spine_get_option( 'crop' ) && is_front_page() ) {
		$looseleaf = true; // Only apply the looseleaf class when the template is included here... not sure if this is the best way
		include( locate_template( 'spine/footer.php' ) );
	}
?>

<?php wp_footer(); ?>

</body>
</html>