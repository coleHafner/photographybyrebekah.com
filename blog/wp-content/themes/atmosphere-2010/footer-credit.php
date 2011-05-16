<?php /* Start add our footer credits */ ?>
<?php $shortname = 'drcms'; ?>
	<?php if(get_option($shortname .'_footer_text')) : ?>
		<div id="footer-credit">
			<?php echo stripslashes(get_option($shortname .'_footer_text')); ?>
		</div>
	<?php endif; ?>
<?php /* End footer credit */ ?>
