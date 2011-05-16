<?php /*
	Template Name: Allow Comments
*/ ?>

<?php get_header(); ?>
	
	<div id="content" class="page">
		
		<?php if(have_posts()) : ?>
		
		<?php while(have_posts()) : the_post(); ?>
		
		<div class="entry" id="post-<?php the_ID(); ?>">
			
			<h1 class="entry-title"><?php the_title(); ?></h1>
			
			<div class="entry-byline">
				<?php edit_post_link('Edit', '[', ']'); ?>
			</div>
			
			<div class="entry-content">
				<?php the_content(); ?>
				<?php wp_link_pages('before=<p><strong>' . __('Pages:') . '</strong>&after=</p>'); ?>
			<div class="clear"></div>
			</div>
			
		</div><!--.entry-->
		<?php comments_template(); ?>
		<?php endwhile; ?>
		<?php endif; ?>	

	</div><!--#content-->
	
<?php get_sidebar(); ?>

<?php get_footer(); ?>