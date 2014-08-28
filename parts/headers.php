<?php

/**
 * Retrieve an array of values to be used in the header.
 *
 * site_name
 * site_tagline
 * page_title
 * post_title
 * section_title
 * subsection_title
 * posts_page_title
 * sup_header_default
 * sub_header_default
 * sup_header_alternate
 * sub_header_alternate
 */

$spine_main_header_values = spine_get_main_header();
global $wsu_cahnrs_spine;

?>
<header id="cahnrs-global-header" class="main-header">

	<div class="header-group hgroup">
		<!-- Removed sup since we aren't using it -->
    <!-- Added back for sites that don't want to use CAHNRS header stuff -->
    <?php if ( ! get_option( 'cahnrs_setting_global_nav' ) && ! has_nav_menu( 'cahnrs_horizontal' ) ) : ?>
    <sup class="sup-header" data-section="<?php echo $spine_main_header_values['section_title']; ?>" data-pagetitle="<?php echo $spine_main_header_values['page_title']; ?>" data-posttitle="<?php echo $spine_main_header_values['post_title']; ?>" data-default="<?php echo esc_html($spine_main_header_values['sup_header_default']); ?>" data-alternate="<?php echo esc_html($spine_main_header_values['sup_header_alternate']); ?>"><span class="sup-header-default"><?php echo strip_tags( $spine_main_header_values['sup_header_default'], '<a>' ); ?></span></sup>
    <?php endif; ?>
		<sub class="sub-header" data-sitename="<?php echo $spine_main_header_values['site_name']; ?>" data-pagetitle="<?php echo $spine_main_header_values['page_title']; ?>" data-posttitle="<?php echo $spine_main_header_values['post_title']; ?>" data-default="<?php echo esc_html($spine_main_header_values['sub_header_default']); ?>" data-alternate="<?php echo esc_html($spine_main_header_values['sub_header_alternate']); ?>"><span class="sub-header-default"><?php /* echo strip_tags( $spine_main_header_values['sub_header_default'], '<a>' ); */ if ( get_option( 'cahnrs_setting_global_nav' ) ) echo 'College of Agricultural, Human, and Natural Resource Sciences'; else bloginfo( 'name' ); /* making this a little more predictable - PC */ ?></span></sub>
        	
	</div>

	<?php // The site is using the CAHNRS Global Nav or has a horizontal nav of its own
  if ( get_option( 'cahnrs_setting_global_nav' ) || has_nav_menu( 'cahnrs_horizontal' ) ) : ?>
  <nav id="cahnrs-global-nav">
		<?php // For the CAHNRS Global Nav, build from JSON
    if ( get_option( 'cahnrs_setting_global_nav' ) ) : ?>
		<ul class="nav-wrapper">
			<?php
			//$global_nav = $wsu_cahnrs_spine->service_get_global_menu_obj();
			$page_data = $wsu_cahnrs_spine->service_get_global_menu_obj2();
			
			
			
			foreach( $page_data as $n_s ) :
				$selected_class = '' //$wsu_cahnrs_spine->service_check_selected_nav( $n_s['url'] );
			?><li class="nav-item <?php echo $selected_class; ?>">
				<a class="nav-link" href="<?php echo $n_s['url']; ?>" data-base="frame-<?php echo $n_s['id']; ?>"><?php echo $n_s['title']; ?></a>
        <?php // Deep links (if not mobile)
		
		
		
		
        if ( wp_is_mobile() == false && isset($n_s['deeplinks']) ) : ?>
				<!-- START SUB SECTION LINKS -->
				<div class="nav-sub-section frame-<?php echo $n_s['id']; ?>">
					<div class="section-links">
					<?php foreach( $n_s['sub_sections'] as $s_s ) :
						?><ul class="link-list">
							<li class="section-title"><a href="<?php echo $s_s['url']; ?>"><?php echo $s_s['title']; ?></a></li>
              <?php foreach( $s_s['section_items'] as $s_l ) : ?>
              <li class="section-item"><a href="<?php echo $s_l['url']; ?>"><?php echo $s_l['title']; ?></a></li>
              <?php endforeach; ?>
						</ul><?php 
					endforeach; ?>
					</div><div class="news-promo">
					<img src="<?php echo $n_s['news-image'];?>" />
					<div class="news-tag"><?php echo $n_s['news-tag'];?></div>
          <!--<span class="news-title"><a href="<?php// echo $s_l['news-url']; ?>"><?php// echo $n_s['news-title'];?></a></span>-->
					<a href="<?php echo $s_l['news-url']; ?>"><span class="news-title"><?php echo $n_s['news-title'];?></span></a>
					</div>
				</div>
				<!-- END SUB SECTION LINKS -->
        <?php endif; // wp_is_mobile()
				?>
                
                
                
			</li><?php 
			endforeach; ?>
		</ul>
    <?php // Otherwise, here's the WP menu - maybe implement a walker to limit the number of items (5 or 6 total)
    else :
			wp_nav_menu( array(
				'theme_location' => 'cahnrs_horizontal',
				'container'      => false,
				'menu_class'     => 'nav-wrapper',
				'fallback_cb'    => 'featured_nav_fallback',
				'depth'          => 1
			) );
		endif; // CAHNRS Global Navigation setting selected or not
		?>
	</nav>
	<?php endif; // CAHNRS Global Nav or Horizontal Nav
	?>
<!--
	<nav id="cahnrs-global-nav">
    <ul class="nav-wrapper">
    <?php /*
		$global_nav = $wsu_cahnrs_spine->service_get_global_menu_obj();
		foreach( $global_nav['nav_items'] as $n_s ):
			$selected_class = $wsu_cahnrs_spine->service_check_selected_nav( $n_s['url'] );
			?><li class="nav-item <?php echo $selected_class;?>">
				<a class="nav-link" href="<?php echo $n_s['url'];?>" data-base="<?php echo $n_s['base-id'];?>">
					<?php echo $n_s['title'];?>
                </a>
                <!-- START SUB SECTION LINKS -->
                <div class="nav-sub-section <?php echo $n_s['base-id'];?>">
                    <div class="section-links">
                    <?php foreach( $n_s['sub_sections'] as $s_s ):
                    ?><ul class="link-list">
                        <li class="section-title">
                                <a href="<?php echo $s_s['url'];?>"><?php echo $s_s['title'];?></a>
                            </li>
                        <?php foreach( $s_s['section_items'] as $s_l ):?>
                            <li class="section-item">
                                <a href="<?php echo $s_l['url'];?>"><?php echo $s_l['title'];?></a>
                            </li>
                        <?php endforeach;?>
                        </ul><?php 
                    endforeach;?>
                    </div><div class="news-promo">
                    	<img src="<?php echo $n_s['news-image'];?>" />
                    	<div class="news-title"><?php echo $n_s['news-title'];?></div>
                    	<a href="#"></a>
                    </div>
                </div>
                <!-- END SUB SECTION LINKS -->
			</li><?php 
			endforeach; */?>
        </ul>
    </nav>
-->
</header>