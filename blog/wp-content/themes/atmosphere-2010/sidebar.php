<div id="sidebar-menu"><!-- Container Div -->
	
	<div id="primary" class="widget-area" role="complementary">
		<ul class="xoxo">

		<?php if ( ! dynamic_sidebar( 'primary-widget-area' ) ) : ?>
		
			<?php if( !get_option('drcms_hide_search') ) :  ?>	
				<li><div class="widget-title" style="margin-bottom: 5px;"><?php _e('Search'); ?></div></li>
				<li id="search">
					<div>
						<form id="searchform" method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
							<input type="text" id="s" name="s" class="searchbox" /><input type="submit" value="Go" class="searchbutton" />
						</form>
					</div>
				</li>
			<?php endif; ?>
			
			<?php if( !get_option('drcms_hide_categories') ) :  ?>
				<li><div class="widget-title"><?php _e('Categories'); ?></div></li>
				<?php wp_list_categories('title_li='); ?>
			<?php endif; ?>
			
			<!--
			
			<?php if( !get_option('drcms_hide_menu') ) :  ?>
				<li><div class="widget-title"><?php _e('Pages'); ?></div></li>
				<li><a href="<?php echo home_url(); ?>">Home</a></li>
				<?php wp_list_pages('sort_column=menu_order&depth=1&title_li='); ?>
			<?php endif; ?>
			 
			<?php if( !get_option('drcms_hide_archive') ) : ?>
				<li><div class="widget-title"><?php _e('Archives'); ?></div></li>
				<?php wp_get_archives('type=monthly'); ?>
			<?php endif; ?>

			<?php if( !get_option('drcms_hide_calendar') ) :  ?>
				 <li><div class="widget-title"><?php _e('Calendar'); ?></div></li>
				  <li><?php get_calendar(); ?></li>
			<?php endif; ?>

			<?php if( !get_option('drcms_hide_links') ) : ?>
				<li><div class="widget-title"><?php _e('Links'); ?></div></li>
				 <?php wp_list_bookmarks('title_li=&categorize=0'); ?>
			<?php endif; ?>
			-->

		<?php endif; // end primary widget area ?>
		</ul> <!-- xoxo -->
	</div><!-- #primary .widget-area -->

	<?php
		if ( is_active_sidebar( 'secondary-widget-area' ) ) : ?>
			
			<div id="secondary" class="widget-area" role="complementary">
				<ul class="xoxo">
					<?php dynamic_sidebar( 'secondary-widget-area' ); ?>
				</ul>
			</div><!-- #secondary .widget-area -->
	<?php endif; ?>
	
	<!-- 
	<div id="tertiary" class="widget-area" role="complementary">
		<ul class="xoxo">
		
		<?php if ( ! dynamic_sidebar( 'tertiary-widget-area' ) ) : ?>
			
			<?php if( !get_option('drcms_hide_meta') ) :  ?>
				<li><div class="widget-title"><?php _e('Meta'); ?></div></li>
				<?php wp_register(); ?>
				<li><?php wp_loginout(); ?></li>
				<li><a href="<?php bloginfo('rss2_url'); ?>" title="<?php _e('Syndicate this site using RSS'); ?>"><?php _e('<abbr title="Really Simple Syndication">RSS</abbr>'); ?></a></li>
				<li><a href="<?php bloginfo('comments_rss2_url'); ?>" title="<?php _e('The latest comments to all posts in RSS'); ?>"><?php _e('Comments <abbr title="Really Simple Syndication">RSS</abbr>'); ?></a></li>
				<?php wp_meta(); ?>
			<?php endif; ?>
		<?php endif; ?>
		</ul>
	</div>
	-->
	
 </div> <!-- Sidebar Menu -->