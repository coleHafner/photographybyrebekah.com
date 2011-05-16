<?php get_header(); ?>

	<div id="content" class="single">

		<?php if(have_posts()) : ?>

		<?php while(have_posts()) : the_post(); ?>

		<div class="entry hentry" id="post-<?php the_ID(); ?>">

			<span class="entry-date"><abbr class="updated" title="<?php the_time('Y-m-d\TH:i:sO'); ?>"><?php the_time('M d'); ?></abbr></span>
			<h1 class="entry-title"><?php the_title(); ?></h1>

			<div class="entry-byline">
				<!--<address class="author vcard"><?php _e('by '); ?><a class="url fn" href="<?php the_author_url(); ?>"><?php the_author(); ?></a>. </address>-->
				<?php edit_post_link('Edit', '[', ']'); ?>

			</div>

			<div class="entry-content">
				<?php the_content('[Continue reading &#8658;]'); ?>
				<?php wp_link_pages('before=<p><strong>' . __('Pages:') . '</strong>&after=</p>'); ?>
			<div class="clear"></div>
			</div>

			<p class="entry-meta"><span class="entry-categories"><?php _e('Posted in: '); ?><?php the_category(', '); ?>.</span><br />
			<?php if(function_exists('the_tags')) { ?>
				<span class="entry-tags"><?php the_tags('Tagged: ',' &middot; ','<br />'); ?></span>
			<?php } ?>
			</p>

				<p class="entry-meta">
						This entry was posted
						<?php /* This is commented, because it requires a little adjusting sometimes.
							You'll need to download this plugin, and follow the instructions:
							http://binarybonsai.com/archives/2004/08/17/time-since-plugin/ */
							/* $entry_datetime = abs(strtotime($post->post_date) - (60*120)); echo time_since($entry_datetime); echo ' ago'; */ ?>
						on <?php the_time('l, F jS, Y') ?> at <?php the_time() ?>
						and is filed under <?php the_category(', ') ?>.
						You can follow any responses to this entry through the <?php post_comments_feed_link('RSS 2.0'); ?> feed.

						<?php if (('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
							// Both Comments and Pings are open ?>
							You can <a href="#respond">leave a response</a>, or <a href="<?php trackback_url(); ?>" rel="trackback">trackback</a> from your own site.

						<?php } elseif (!('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
							// Only Pings are Open ?>
							Responses are currently closed, but you can <a href="<?php trackback_url(); ?> " rel="trackback">trackback</a> from your own site.

						<?php } elseif (('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
							// Comments are open, Pings are not ?>
							You can skip to the end and leave a response. Pinging is currently not allowed.

						<?php } elseif (!('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
							// Neither Comments, nor Pings are open ?>
							Both comments and pings are currently closed.

						<?php } edit_post_link('Edit this entry','','.'); ?>

				</p>


			
		</div><!--.entry-->

		<?php include (TEMPLATEPATH . '/navigation.php'); ?>

		<?php comments_template(); ?>

		<?php endwhile; ?>

		<?php else : ?>

		<div class="entry">
			<h2 class="entry-title"><?php _e('Not Found'); ?></h2>
			<div class="entry-content">
			<p>Sorry, what you are looking for isn't here.</p>
			<?php include (TEMPLATEPATH . "/searchform.php"); ?>
			</div>
		</div>

		<?php endif; ?>
<?php
$this_post = $post;
$category = get_the_category(); $category = $category[0]; $category = $category->cat_ID;
$posts = get_posts('numberposts=6&offset=0&orderby=post_date&order=DESC&category='.$category);
$count = 0;
foreach ( $posts as $post ) {
	if ( $post->ID == $this_post->ID || $count == 5) {
		unset($posts[$count]);
	} else {
		$count ++;
	}
}
?>
<?php if ( $posts ) { ?>
<div class="entry-content">
<p><?php _e('See also:')?></p>
<ul>
<?php foreach ( $posts as $post ) : ?>
<li><?php the_time('d/m/Y') ?> - <a rel="nofollow" href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php if ( get_the_title() ){ the_title(); }else{ echo "Untitled"; } ?></a></li>
<?php endforeach // $posts as $post ?>
</ul>
	</div>
<?php } // $posts ?>

	</div><!--#content-->

<?php get_sidebar(); ?>

<?php get_footer(); ?>