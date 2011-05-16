<div id="secondary">

<div id="sidebar-1" class="sidebar">

<!--
	<div id="rss-links" class="rss">
		<p><a href="<?php bloginfo('rss2_url'); ?>" title="Subscribe to this Feed via RSS">RSS</a> <a  title="title="Subscribe to comment Feed via RSS" href="<?php bloginfo('comments_rss2_url'); ?>">Comments</a></p>
	</div>
-->
	<ul class="xoxo">

	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar(1) ) : ?><!--sidebar-1 widgets start-->

	<li id="recent-posts" class="widget">
			<h2><?php _e('Recent Posts'); ?></h2>
			<ul>
				<?php wp_get_archives('type=postbypost&limit=10'); ?>
			</ul>
	</li>

	<li id="archives" class="widget">
			<h2><?php _e('Archives'); ?></h2>
			<ul>
				<?php wp_get_archives('type=monthly'); ?>
			</ul>
	</li>


	<?php endif; ?><!--sidebar-1 widgets end-->
	</ul>
</div><!--#sidebar-1-->

<!--
<div id="sidebar-2" class="sidebar">
	<?php if ( get_option('twit') ) : ?>
	<div id="rss-links" class="twitter">
		<p><a href="http://twitter.com/<?php echo get_option('twit');?>" title="follow me">Follow me</a></p>
	</div>
	<?php endif; ?>

	<ul class="xoxo">
	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar(2) ) : ?>

		<?php wp_list_pages('title_li=<h2>Pages</h2>' ); ?>

		<?php wp_list_bookmarks('class=widget'); ?>

		<li id="meta" class="widget">
			<h2><?php _e('Meta') ?></h2>
			<ul>
			<?php wp_register(); ?>
			<li><?php wp_loginout(); ?></li>
			<?php wp_meta(); ?>
			</ul>
		</li>
	<?php endif; ?>
	</ul>
</div>
-->
</div><!--#secondary-->