<?php if ( true == spine_get_option( 'crop' ) && is_front_page() ) {
		$cropping = ' cropped';
	} else {
		$cropping = '';
	}
?>

<div id="spine" class="spine-column <?php echo esc_attr( spine_get_option( 'spine_color' ) ); echo $cropping; echo esc_attr( spine_get_option( 'bleed' ) ); ?> shelved<?php if ( get_option( 'cahnrs_setting_global_nav' ) ) echo ' vellum-10'; /* Added - PC */ ?>">
<div id="glue" class="spine-glue">

<?php get_template_part('spine/header'); ?>

<section id="spine-navigation" class="spine-navigation">

	<?php if ( get_option( 'cahnrs_setting_global_nav' ) ) : ?>
  <?php /* need a means by which to determine/declare "current-site" class, JS click instead of hover for disclosure */ ?>
	<nav id="cahnrs-spine-mobile">
		<ul>
			<li><a href="http://stage.wpdev.cahnrs.wsu.edu/">Home</a></li>
			<li><a href="http://stage.wpdev.cahnrs.wsu.edu/academics/">Students</a></li>
			<li><a href="http://stage.wpdev.cahnrs.wsu.edu/research/">Research</a></li>
			<li class="current-site"><a href="http://stage.wpdev.cahnrs.wsu.edu/extension/">Extension</a></li>
			<li><a href="http://stage.wpdev.cahnrs.wsu.edu/alumni/">Alumni &amp; Friends</a></li>
			<li><a href="http://stage.wpdev.cahnrs.wsu.edu/fs/">Faculty &amp; Staff</a></li>
		</ul>
	</nav>
	<?php endif; ?>

	<nav id="spine-sitenav" class="spine-sitenav">
	<?php
	$site = array(
		'theme_location'  => 'site',
		'menu'            => 'site',
		'container'       => false,
		'container_class' => false,
		'container_id'    => false,
		'menu_class'      => null,
		'menu_id'         => null,
		'echo'            => true,
		'fallback_cb'     => 'wp_page_menu',
		'items_wrap'      => '<ul>%3$s</ul>',
		'depth'           => 2,// Changed to 2 - PC
		'walker'          => ''
		);
	wp_nav_menu( $site );
	?>
	</nav>
	
	<nav id="spine-offsitenav" class="spine-offsitenav">
	<?php
	$offsite = array(
		'theme_location'  => 'offsite',
		'menu'            => 'offsite',
		'container'       => false,
		'container_class' => false,
		'container_id'    => false,
		'menu_class'      => null,
		'menu_id'         => null,
		'echo'            => true,
		'fallback_cb'     => false,
		'items_wrap'      => '<ul>%3$s</ul>',
		'depth'           => 1, // Changed to 1 - PC
		'walker'          => '' // Should implement one which limits output to only the top item
	);
	wp_nav_menu( $offsite );
	?>
	</nav>
	
</section>
		
<?php get_template_part('spine/footer'); ?>

</div><!--/glue-->
</div><!--/spine-->