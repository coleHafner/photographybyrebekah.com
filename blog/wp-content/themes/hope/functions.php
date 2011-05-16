<?php 
	if ( function_exists('register_sidebar') )
		register_sidebars(2);

// No CSS, just IMG call

define('HEADER_TEXTCOLOR', '');
define('HEADER_IMAGE', '%s/images/default.jpg'); // %s is theme dir uri
define('HEADER_IMAGE_WIDTH', 500);
define('HEADER_IMAGE_HEIGHT', 310);
define('NO_HEADER_TEXT', true );

function hope_admin_header_style() {
?>
<style type="text/css">
#headimg{background: url(<?php header_image() ?>) no-repeat;background-repeat: no-repeat;height: <?php echo HEADER_IMAGE_HEIGHT; ?>px;width:<?php echo HEADER_IMAGE_WIDTH; ?>px;}
#headimg h1, #headimg #desc {display: none;}
</style>
<?php
}

function header_style() {
?>
<style type="text/css">#rotating {background: url(<?php header_image() ?>)  top left no-repeat;}</style>
<?php
}

add_custom_image_header('header_style', 'hope_admin_header_style');

function hope_admin_menu(){
	add_submenu_page('themes.php', 'Theme Settings', 'Theme Settings', 8, 'theme-setting', 'hope_admin');
}

function hope_flickr() {
	if( file_exists( ABSPATH . WPINC . '/rss.php') ) {
		require_once(ABSPATH . WPINC . '/rss.php');
	} else {
		require_once(ABSPATH . WPINC . '/rss-functions.php');
	}

	$items = get_option( 'rssnum' );
	if ( empty($items) || $items < 1 || $items > 100 )
		$items = 20;

	$flickr = get_option( 'flickr' );

	if ( empty( $flickr ) ){
		$flickr = "http://api.flickr.com/services/feeds/photos_public.gne?id=90827185@N00&lang=en-us&format=rss_200";
	}

	$rss = fetch_rss( $flickr );
	if( is_array( $rss->items ) ) {
		$out = '';
		$items = array_slice( $rss->items, 0, $items );
		while( list( $key, $photo ) = each( $items ) ) {
			preg_match_all("/<IMG.+?SRC=[\"']([^\"']+)/si",$photo[ 'description' ],$sub,PREG_SET_ORDER);
			$photo_url = str_replace( "_m.jpg", "_m.jpg", $sub[0][1] );

			if (strlen($out)>0)
				$out .= ",\n";

			$out .= '["' . $photo_url . '", "' . $photo['link'] . '", "_new", "'. wp_specialchars( $photo[ 'title' ], true ). '"]';
		}
	}
	?>

<script type="text/javascript">
var mygallery=new simpleGallery({
wrapperid: "simplegallery",
dimensions: [402, 285],
imagearray: [
<?php echo $out; ?>
],
autoplay: [false, 2500, 2],
persist: true,
fadeduration: 500,
oninit:function(){
//Keyword "this": references current gallery instance (ie: try this.navigate("play/pause"))
},
onslide:function(curslide, i){
//Keyword "this": references current gallery instance
//curslide: returns DOM reference to current slide's DIV (ie: try alert(curslide.innerHTML)
//i: integer reflecting current image within collection being shown (0=1st image, 1=2nd etc)
}
})
</script>
<?php
}

function hope_admin(){
	$twit	= wp_specialchars( get_option('twit') );
	$flickr	= wp_specialchars( get_option('flickr') );
	$items	= wp_specialchars( get_option( 'rssnum' ) );
	if ( empty($items) || $items < 1 ) $items = 5;

	if ( $_POST['update'] ) {
		if ( isset($_POST['twit']) ) {
			$twit = strip_tags(stripslashes($_POST["twit"]));
				update_option( 'twit', $twit );

		}

		if ( isset($_POST['flickr']) ) {
			$flickr = strip_tags(stripslashes($_POST["flickr"]));
			$items = strip_tags(stripslashes($_POST["rssnum"]));
				update_option( 'flickr', $flickr );
				update_option( 'rssnum', $items );
		}

		echo '<div id="message" class="updated fade"><p>Options saved successfully.</p></div>';
	}

?>
<div class="wrap">
<div id="icon-themes" class="icon32"><br /></div>
<h2><?php _e('hoPE Theme Settings')?></h2>

<div style='float:right;background: #ffc; border: 1px solid #333; margin: 2px; padding: 5px;width:200px;'>
<h3 align='center'>Support The Theme</h3>
<p>"I hope to buy a notebook for my love, please feel happy to make a donation to make my dream true, thank you very much." - Patrick</p>
<div align='center'>
	<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=mypatricks@gmail.com&item_name=Donate%20to%20HoPE%20Theme&item_number=1244379463&amount=10.00&no_shipping=0&no_note=1&tax=0&currency_code=USD&bn=PP%2dDonationsBF&charset=UTF%2d8&return=http://patrick.bloggles.info"><img src="https://www.paypal.com/en_GB/i/btn/btn_donate_SM.gif" /></a>
</div>
<p>Add my <a href="http://facebook.com/patrickchia">facebook</a> or follow me at <a href="http://twitter.com/mypatricks">twitter</a>. Thank you.</p>
</div>

<p><strong><?php _e('These are general extras that you can enable for your entire blog themes.')?></strong></p>

<form action="" method="post">

<table class="form-table">

<tbody><tr>
	<th><label for="twitter"><?php _e('Twitter Username');?></label></th>
	<td><input name="twit" id="twit" value="<?php echo get_option('twit');?>" size="45" type="text" class="regular-text" /></td>
</tr>

<tr>
	<th><label for="flickr"><?php _e('flickr/PicasaWeb RSS');?></label></th>
	<td><input name="flickr" id="flickr" value="<?php echo get_option('flickr');?>" size="45" type="text" class="regular-text" /></td>
</tr>

<tr>
	<th><label for="rssnum"><?php _e('Number Photos'); ?></th>
	<td><select id="rssnum" name="rssnum"><?php for ( $i = 5; $i <= 100; ++$i ) echo "<option value='$i' ".($items==$i ? "selected='selected'" : '').">$i</option>"; ?></select></td>
</tr>
<tr>	<th><label for="help"><?php _e('Themes Help'); ?></th>
	<td><p>Note: Your RSS feed can be found on your Flickr homepage or your PicasaWeb RSS. Scroll down to the bottom of the page until you see the <em>Feed</em> link or <em>RSS</em> link and copy that into the box above.<br /></p>

<p><strong>flickr Feed Link:</strong><br />
<code>http://api.flickr.com/services/feeds/photos_public.gne?tags=rose&amp;lang=en-us&amp;format=rss_200</code><br />
<strong>Picasa RSS Link:</strong><br />
<code>http://picasaweb.google.com/data/feed/base/user/wael.tabba?alt=rss&amp;kind=album&amp;hl=en_US&amp;access=public</code>
</p>

<p class="submit">
	<input value="Save Theme Setting" type="submit" />
	<input name="update" value="true" type="hidden" /></p>
</td>
</tr>

</tbody>
</table>
</form>
</div>
<?php
}

if ( !get_option('flickr') && !isset($_POST['update']) ) {
	function hope_tips() {
		echo "<div id='hope-tips' class='updated fade'><p>".__('Tips: You may custom your blog theme header and gallery with your flickr.') ."</p><p>". sprintf(__('You must <a href="%1$s">enter</a> the flickr/PicasWeb feed url for it to work.'), "themes.php?page=theme-setting")."</p></div>";
	}
	add_action('admin_notices', 'hope_tips');
}

add_action( 'admin_menu', 'hope_admin_menu' );
add_action( 'wp_footer', 'hope_flickr' );

?>