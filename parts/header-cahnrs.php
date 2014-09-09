<?php global $wsu_cahnrs_spine;?>
<ul class="nav-wrapper">
			<?php
			//$global_nav = $wsu_cahnrs_spine->service_get_global_menu_obj();
			$page_data = $wsu_cahnrs_spine->service_get_global_menu_obj2();
			
			
			
			foreach( $page_data as $n_s ) :
				$selected_class = ( $n_s['data']['home'] == get_home_url())? ' selected' : ''; //$wsu_cahnrs_spine->service_check_selected_nav( $n_s['url'] );
			?><li class="nav-item <?php echo $selected_class; ?> <?php echo $n_s['data']['home']; ?>" data-bg="<?php echo $n_s['data']['background']; ?>">
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