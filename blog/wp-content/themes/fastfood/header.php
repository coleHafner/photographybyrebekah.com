<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

	<head profile="http://gmpg.org/xfn/11">
		<meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo( 'charset' ); ?>" />

		<title>
			<?php
			if ( is_front_page() ) {
				bloginfo( 'name' ); ?> - <?php bloginfo( 'description' );
			} else {
				wp_title( '&laquo;', true, 'right' );
				bloginfo( 'name' );
			}
			?>
		</title>

		<?php
			global $fastfood_opt;
		?>

		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		<?php wp_get_archives( 'type=monthly&format=link' ); ?>
		<?php wp_head(); ?>

	</head>

	<body <?php body_class(); ?> style="background-image:url( '../www/images/bg_nature.jpg' );background-position:top left;">
		<div id="ff_background">
			<div id="ff_body" class="pad_bg">
				<div id="ff_body_overlay"></div>
			</div>
		</div>
		<div id="main">

		<div id="content">

			<div id="head">
				<h1><a href="<?php echo home_url(); ?>/"><?php bloginfo( 'name' ); ?></a></h1>
				<div class="description"><?php bloginfo( 'description' ); ?></div>
			</div>

			<div id="pages">
				<div style="margin-left:10px;">
					<a href="http://local.blog.photographybyrebekah.com">
						Home
					</a>
				</div>
				<!-- 
				<div id="rss_imglink"><a href="<?php bloginfo( 'rss2_url' ); ?>" title="<?php _e( 'Syndicate this site using RSS 2.0' ); ?>"><img alt="rsslink" src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/rss.png" /></a></div>
				<?php wp_nav_menu( array( 'menu_id' => 'mainmenu', 'fallback_cb' => 'fastfood_pages_menu', 'theme_location' => 'primary' ) ); ?>
				<div class="fixfloat"></div>
				-->
			</div>
			
			<?php get_sidebar( 'header' ); // show header widgets area ?>
			<?php
				$postswidth = 'class="posts_narrow"';
				if ( ( is_page() && ( $fastfood_opt['fastfood_rsidebpages'] == 0 ) ) || ( is_single() && ( $fastfood_opt['fastfood_rsidebposts'] == 0 ) ) || is_attachment() ) {
					$postswidth = 'class="posts_wide"';
				}else if ( ( is_page() && ( $fastfood_opt['fastfood_rsidebpages'] == 1 ) ) || ( is_single() && ( $fastfood_opt['fastfood_rsidebposts'] == 1 ) ) ) {
					$postswidth = 'class="posts_narrow" style="padding-bottom: 310px;"';
				}
			?>
			<div id="posts_content" <?php echo $postswidth; ?>>