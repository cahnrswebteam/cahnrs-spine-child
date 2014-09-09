<?php 
global $wsu_cahnrs_spine;
$header_data = $wsu_cahnrs_spine->service_get_global_obj();
?>
<ul class="nav-wrapper">
	<?php
	foreach( $header_data as $site ) :
	$selected_class = ( $site->data->home == get_home_url())? ' selected' : '';
	$data = array();
	?><li class="nav-item <?php echo $selected_class; ?>" >
		<a class="nav-link" href="<?php echo $site->url; ?>" data-base="frame-<?php echo $site->id; ?>">
			<?php echo $site->title;?>
		</a>
		<?php // Deep links (if not mobile)
		if ( wp_is_mobile() == false && isset( $site->data->deeplinks ) && $site->data->deeplinks ) : ?>
			<!-- START SUB SECTION LINKS -->
			<div class="nav-sub-section frame-<?php echo $site->id; ?>">
            	<?php echo $site->data->deeplinks;?>
			</div>
			<!-- END SUB SECTION LINKS -->
		<?php endif; // wp_is_mobile() ?>
	</li><?php endforeach; ?>
</ul>