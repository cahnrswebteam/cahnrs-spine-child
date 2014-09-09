<?php if ( true == spine_get_option( 'crop' ) && is_front_page() ) {
		$cropping = ' cropped';
	} else {
		$cropping = '';
	}
?>

<div id="spine" class="spine-column <?php echo esc_attr( spine_get_option( 'spine_color' ) ); echo $cropping; echo esc_attr( spine_get_option( 'bleed' ) ); ?> shelved <?php if ( get_option( 'cahnrs_setting_global_nav' ) ) echo 'vellum-10'; ?>">
<div id="glue" class="spine-glue">

<?php get_template_part('spine/header'); ?>

<section id="spine-navigation" class="spine-navigation">

	<?php if ( get_option( 'cahnrs_setting_global_nav' ) ) : ?>
	<nav id="cahnrs-spine-mobile">
		<ul>
			<li>
			<?php // Probably a really silly way to do it...
			global $wsu_cahnrs_spine;
			$header_data = $wsu_cahnrs_spine->service_get_global_obj();
			foreach( $header_data as $site ) :
				if ( $site->data->home == get_home_url() ) echo '<a href="' . $site->url . '">' . $site->title .'</a>';
			endforeach;
			echo '<ul>';
			foreach( $header_data as $site ) :
				$selected_class = ( $site->data->home == get_home_url() ) ? ' class="selected"' : '';
				echo '<li ' . $selected_class . '><a href="' . $site->url . '">' . $site->title .'</a></li>';
			endforeach;
			echo '</ul>';
			?>
      </li>
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
	\wp_nav_menu( $site ); 
	?>
	<?php 
	$page_json = file_get_contents( 'http://api.wpdev.cahnrs.wsu.edu/cache/globalpage/globalpage.json' );
	$pages = json_decode( $page_json );
 	foreach( $pages as $page ){
		echo $page->data->menu;
	}// end foreach
	?>
	</nav>
	
	<nav id="spine-offsitenav" class="spine-offsitenav">
	<?php
	/*
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
	*/
	// One (maybe heavy-handed) way to limit the number of offsite links
	if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ 'offsite' ] ) ) :
		$menu       = wp_get_nav_menu_object( $locations[ 'offsite' ] );
		$menu_items = wp_get_nav_menu_items( $menu->term_id );
		$link_url   = $menu_items[0]->url;
		$link_name  = $menu_items[0]->title;
		echo '<ul><li><a href="' . $link_url . '">' . $link_name . '</a></li></ul>';
	endif;
	?>
	</nav>
	
</section>
		
<?php get_template_part('spine/footer'); ?>

</div><!--/glue-->
</div><!--/spine-->