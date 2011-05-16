<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">

	<title>
	<?php if ( is_home() ) { ?>
		<?php bloginfo('description'); ?> <?php bloginfo('name'); ?>
	<?php } else { ?>
		<?php wp_title(''); ?> - <?php bloginfo('name'); ?>
	<?php } ?>
	</title>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
	<!--[if lte IE 7]>
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/css/ie7.css" />
	<style type="text/css">#gradient{visibility:hidden;}</style>
	<![endif]-->
	<!--[if lt IE 6]>
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/css/ie6-.css" />
	<style type="text/css">#gradient{visibility:hidden;}</style>
	<![endif]-->

	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
	<link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<script type="text/javascript">
	var simpleGallery_navpanel={
		panel: {height:'45px', opacity:0.5, paddingTop:'5px', fontStyle:'bold 11px Verdana'},
		images: [ '<?php echo get_bloginfo('template_directory'); ?>/images/left.png', '<?php echo get_bloginfo('template_directory'); ?>/images/play.gif', '<?php echo get_bloginfo('template_directory'); ?>/images/right.png', '<?php echo get_bloginfo('template_directory'); ?>/images/pause.gif'],
		imageSpacing: {offsetTop:[-4, 99, -4], spacing:20},
		slideduration: 100
	}
	</script>

	<script type="text/javascript" src="<?php echo get_bloginfo('template_directory');?>/jquery-pack.js?<?php echo time(); ?>"></script>
	<?php
		wp_enqueue_script( 'gallery', get_bloginfo('template_directory').'/simplegallery.js', array( 'jquery' ) );
		if ( is_singular() )
			wp_enqueue_script( 'comment-reply' );
	?>

<?php wp_head(); ?>
<?php if ( get_bloginfo('language') == 'zh' ) { ?>
<style type="text/css">
.entry-content { font-size: 1.5em;color:#777; font-family: georgia, arial;}
.wp-caption p.wp-caption-text {font-size: 1em;}
</style>
<?php } ?>

</head>
<body>
<div id="page" class="hfeed">

	<div id="header">
		<div class="search">
		<form method="get" id="searchform" action="<?php bloginfo('home'); ?>">
			<input type="text" onfocus="if (this.value == 'Search this blog') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Search this blog';}" value="Search this blog" name="s" />
		</form>
		</div>

		<div id="branding">
			<?php if (is_home()) { ?>
			<h1 class="homelink"><a href="<?php bloginfo('url'); ?>" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a></h1>
			<p class="description"><?php bloginfo('description'); ?></p>
			<?php } else { ?>	
			<div class="homelink"><a href="<?php bloginfo('url'); ?>" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a></div>
			<p class="description"><?php bloginfo('description'); ?></p>
			<?php } ?>
		</div>
		
		<div id="skip"><a title="Skip to content" href="#content" accesskey="S">Skip to Content &darr;</a></div>
		
	</div><!--#header-->
<div id="container">
	
	<div id="rotating">
		<div id="gradient">
			<ul class="menu">
				<li class="<?php if ( is_home() or is_archive() or is_single() or is_paged() or is_search() or (function_exists('is_tag') and is_tag()) ) { ?>current_page_item<?php } else { ?>page_item<?php } ?>"><a title="<?php bloginfo('name'); ?>" href="<?php bloginfo('url'); ?>">Blog</a></li>
				<?php wp_list_pages( 'title_li=' ); ?>
			</ul>
			<div id="note">
				<div id="simplegallery"></div>
			</div>
		</div>
	</div>