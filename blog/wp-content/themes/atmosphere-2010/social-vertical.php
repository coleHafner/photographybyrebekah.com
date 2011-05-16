<?php $shortname = 'drcms'; ?>
<?php if( !get_option($shortname. '_hide_vertical_icons') ) : ?>
	<div id="vsocial-bar">
		<div class="vsocial-item"><a href="#">
			<img src="<?php echo get_template_directory_uri(); ?>/images/icons/24x24/topofpage.png" style="width:24px; height:24px;" alt="Top of Page" />
		</a></div>
		<?php if(get_option($shortname .'_icon_1') && get_option($shortname .'_icon_1_url')): ?>
		<div class="vsocial_item"><a href="<?php echo get_option($shortname .'_icon_1_url'); ?>" target="_blank">
			<img src="<?php echo get_template_directory_uri(); ?>/images/icons/24x24/<?php echo get_option($shortname .'_icon_1'); ?>" style="width:24px; height:24px;" alt="<?php echo get_option($shortname .'_icon_1_alt'); ?>" /></a></div>
		<?php endif; ?>
		<?php if(get_option($shortname .'_icon_2') && get_option($shortname .'_icon_2_url')): ?>
		<div class="vsocial_item"><a href="<?php echo get_option($shortname .'_icon_2_url'); ?>" target="_blank">
			<img src="<?php echo get_template_directory_uri(); ?>/images/icons/24x24/<?php echo get_option($shortname .'_icon_2'); ?>" style="width:24px; height:24px;" alt="<?php echo get_option($shortname .'_icon_2_alt'); ?>" /></a></div>
		<?php endif; ?>
		<?php if(get_option($shortname .'_icon_3') && get_option($shortname .'_icon_3_url')): ?>
		<div class="vsocial_item"><a href="<?php echo get_option($shortname .'_icon_3_url'); ?>" target="_blank">
			<img src="<?php echo get_template_directory_uri(); ?>/images/icons/24x24/<?php echo get_option($shortname .'_icon_3'); ?>" style="width:24px; height:24px;" alt="<?php echo get_option($shortname .'_icon_3_alt'); ?>" /></a></div>
		<?php endif; ?>
		<?php if(get_option($shortname .'_icon_4') && get_option($shortname .'_icon_4_url')): ?>
		<div class="vsocial_item"><a href="<?php echo get_option($shortname .'_icon_4_url'); ?>" target="_blank">
			<img src="<?php echo get_template_directory_uri(); ?>/images/icons/24x24/<?php echo get_option($shortname .'_icon_4'); ?>" style="width:24px; height:24px;" alt="<?php echo get_option($shortname .'_icon_4_alt'); ?>" /></a></div>
		<?php endif; ?>
		<?php if(get_option($shortname .'_icon_5') && get_option($shortname .'_icon_5_url')): ?>
		<div class="vsocial_item"><a href="<?php echo get_option($shortname .'_icon_5_url'); ?>" target="_blank">
			<img src="<?php echo get_template_directory_uri(); ?>/images/icons/24x24/<?php echo get_option($shortname .'_icon_5'); ?>" style="width:24px; height:24px;" alt="<?php echo get_option($shortname .'_icon_5_alt'); ?>" /></a></div>
		<?php endif; ?>
		<?php if(get_option($shortname .'_rss_icon')) :?>
		<div class="vsocial_item"><a href="<?php bloginfo('rss2_url'); ?>" target="_blank">
			<img src="<?php echo get_template_directory_uri(); ?>/images/icons/24x24/<?php echo get_option($shortname .'_rss_icon'); ?>" style="width:24px; height:24px;" alt="RSS" /></a></div>
		<?php endif; ?>
	</div>
<?php endif; ?>