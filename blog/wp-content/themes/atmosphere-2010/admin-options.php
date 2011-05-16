<?php
if (!is_admin()) return;

global $themename;
$shortname = "drcms";

$icons = list_images( TEMPLATEPATH. '/images/icons/24X24/');
array_unshift($icons, "");

$adminOptions = array (
 
	array( 
		"name"	=> $themename ." Theme Options",
		"type"	=> "title"),
	
	array( 
		"name"	=> "General Options",
		"type"	=> "section"),

	array( "type"	=> "open"),

	array( 
		"name"	=> "Hide header titles",
		"desc"	=> "Hide the themes header title text",
		"id"	=> $shortname."_hide_titles",
		"type"	=> "checkbox",
		"std"	=> false),

	array( 
		"name"	=> "Hide top menu",
		"desc"	=> "Hide the themes header top menu bar",
		"id"	=> $shortname."_hide_top_menu",
		"type"	=> "checkbox",
		"std"	=> false),

	array( 
		"name"	=> "Hide main menu",
		"desc"	=> "Hide the themes main menu bar",
		"id"	=> $shortname."_hide_lower_menu",
		"type"	=> "checkbox",
		"std"	=> false),
	
	array( 
		"name"	=> "Hide Side Icons",
		"desc"	=> "Hide the right vertical social icons",
		"id"	=> $shortname."_hide_vertical_icons",
		"type"	=> "checkbox",
		"std"	=> false),

	array( 
		"name"	=> "Hide Footer Icons",
		"desc"	=> "Hide the horizontal footer social icons",
		"id"	=> $shortname."_hide_footer_icons",
		"type"	=> "checkbox",
		"std"	=> false),

	array( "type" => "close"),

	array( 
		"name"	=> "Sidebar Widgets",
		"type"	=> "section"),
		
	array( "type"	=> "open"),
		
	array( 
		"name"	=> "Hide Page Menu",
		"desc"	=> "Hide the sidebar page menu section",
		"id"	=> $shortname."_hide_menu",
		"type"	=> "checkbox",
		"std"	=> false),
		
	array( 
		"name"	=> "Hide Categories",
		"desc"	=> "Hide the sidebar categories section",
		"id"	=> $shortname."_hide_categories",
		"type"	=> "checkbox",
		"std"	=> false),

	array( 
		"name"	=> "Hide Archives",
		"desc"	=> "Hide the sidebar archive section",
		"id"	=> $shortname."_hide_archives",
		"type"	=> "checkbox",
		"std"	=> false),

	array( 
		"name"	=> "Hide Calendar",
		"desc"	=> "Hide the sidebar calendar section",
		"id"	=> $shortname."_hide_calendar",
		"type"	=> "checkbox",
		"std"	=> false),

	array( 
		"name"	=> "Hide Links",
		"desc"	=> "Hide the sidebar links section",
		"id"	=> $shortname."_hide_links",
		"type"	=> "checkbox",
		"std"	=> false),

	array( 
		"name"	=> "Hide Meta",
		"desc"	=> "Hide the sidebar meta section",
		"id"	=> $shortname."_hide_meta",
		"type"	=> "checkbox",
		"std"	=> false),

	array( 
		"name"	=> "Hide Search",
		"desc"	=> "Hide the sidebar search section",
		"id"	=> $shortname."_hide_search",
		"type"	=> "checkbox",
		"std"	=> false),

	array( "type" => "close"),

	array( 
		"name"	=> "Footer",
		"type"	=> "section"),
		
	array( "type" => "open"),

	array( 
		"name"	=> "Footer Text",
		"desc"	=> "Company Footer Text",
		"id"	=> $shortname."_footer_text",
		"type"	=> "textarea",
		"std"	=> ""),

	array( "type" => "close"),

	array( 
		"name"	=> "Social Icons",
		"type"	=> "section"),
		
	array( "type" => "open"),
	
	array( 
		"name"	=> "RSS Icon",
		"desc"	=> "Option: select a different the rss icon",
		"id"	=> $shortname."_rss_icon",
		"type"	=> "select",
		"options" => $icons,
		"std"	=> ""),

	array( 
		"name"	=> "Social Media Icon",
		"desc"	=> "Option: select a social media icon",
		"id"	=> $shortname."_icon_1",
		"type"	=> "select",
		"options" => $icons,
		"std"	=> ""),

	array( 
		"name"	=> "Social Media Link",
		"desc"	=> "URL to your social media, starting http:// or mailto:",
		"id"	=> $shortname."_icon_1_url",
		"type"	=> "text",
		"std"	=> ""),

	array( 
		"name"	=> "Social Media Alt Text",
		"desc"	=> "Enter alternate text for social the media icon",
		"id"	=> $shortname."_icon_1_alt",
		"type"	=> "text",
		"std"	=> ""),

	array( 
		"name"	=> "Social Media Icon",
		"desc"	=> "Option: select a social media icon",
		"id"	=> $shortname."_icon_2",
		"type"	=> "select",
		"options" => $icons,
		"std"	=> ""),

	array( 
		"name"	=> "Social Media Link",
		"desc"	=> "URL to your social media, starting http:// or mailto:",
		"id"	=> $shortname."_icon_2_url",
		"type"	=> "text",
		"std"	=> ""),

	array( 
		"name"	=> "Social Media Alt Text",
		"desc"	=> "Enter alternate text for social the media icon",
		"id"	=> $shortname."_icon_2_alt",
		"type"	=> "text",
		"std"	=> ""),

	array( 
		"name"	=> "Social Media Icon",
		"desc"	=> "Option: select a social media icon",
		"id"	=> $shortname."_icon_3",
		"type"	=> "select",
		"options" => $icons,
		"std"	=> ""),

	array( 
		"name"	=> "Social Media Link",
		"desc"	=> "URL to your social media, starting http:// or mailto:",
		"id"	=> $shortname."_icon_3_url",
		"type"	=> "text",
		"std"	=> ""),

	array( 
		"name"	=> "Social Media Alt Text",
		"desc"	=> "Enter alternate text for the media icon",
		"id"	=> $shortname."_icon_3_alt",
		"type"	=> "text",
		"std"	=> ""),

	array( 
		"name"	=> "Social Media Icon",
		"desc"	=> "Option: select a social media icon",
		"id"	=> $shortname."_icon_4",
		"type"	=> "select",
		"options" => $icons,
		"std"	=> ""),

	array( 
		"name"	=> "Social Media Link",
		"desc"	=> "URL to your social media, starting http:// or mailto:",
		"id"	=> $shortname."_icon_4_url",
		"type"	=> "text",
		"std"	=> ""),

	array( 
		"name"	=> "Social Media Alt Text",
		"desc"	=> "Enter alternate text for the media icon",
		"id"	=> $shortname."_icon_4_alt",
		"type"	=> "text",
		"std"	=> ""),

	array( 
		"name"	=> "Social Media Icon",
		"desc"	=> "Option: select a social media icon",
		"id"	=> $shortname."_icon_5",
		"type"	=> "select",
		"options" => $icons,
		"std"	=> ""),

	array( 
		"name"	=> "Social Media Link",
		"desc"	=> "URL to your social media, starting http:// or mailto:",
		"id"	=> $shortname."_icon_5_url",
		"type"	=> "text",
		"std"	=> ""),

	array( 
		"name"	=> "Social Media Alt Text",
		"desc"	=> "Enter alternate text for the media icon",
		"id"	=> $shortname."_icon_5_alt",
		"type"	=> "text",
		"std"	=> ""),

	array( "type" => "close"),

);

function mytheme_style_init() {
	global $shortname;
	$file_dir=get_bloginfo('template_directory');
	wp_enqueue_style("theme_functions", $file_dir."/admin.css", false, "1.0", "all");
}

function mytheme_add_admin() {
 
global $themename, $shortname, $adminOptions, $selectedPageID;
 
if ( isset( $_GET['page'] ) && $_GET['page'] == basename(__file__) ) {
 
	if (  isset( $_REQUEST['action'] ) && 'save' == $_REQUEST['action'] ) {

		foreach ($adminOptions as $value) {
				update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }
		
		foreach ($adminOptions as $value) {
			if( isset( $_REQUEST[ $value['id'] ] ) ) { 
				update_option( $value['id'], $_REQUEST[ $value['id'] ] );
			} else { 
				delete_option( $value['id'] ); 
			} 
		}				 
		header("Location: themes.php?page=admin-options.php&saved=true");
		die;
	} 
	else if( isset( $_REQUEST['action'] ) && 'reset' == $_REQUEST['action'] ) {
 
		foreach ($adminOptions as $value) {
			delete_option( $value['id'] ); 
		}
		header("Location: themes.php?page=admin-options.php&reset=true");
		die;
	}
}

add_theme_page("Theme Options", "Theme Options", 'edit_themes', basename(__FILE__), 'mytheme_admin');
}

function mytheme_admin() {
 
global $themename, $shortname, $adminOptions, $selectedPageID, $mypagename;
$i=0;
 
if ( isset( $_REQUEST['saved'] ) && $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename. ' '.$mypagename .' page settings saved.</strong></p></div>';
if ( isset( $_REQUEST['reset'] ) && $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' '.$mypagename .' page settings reset.</strong></p></div>';
 
?>
<div class="wrap rm_wrap">
<h2><?php echo $themename. ' '.$mypagename; ?> Theme Settings</h2>
 
<div class="rm_opts">
<form method="post">
<?php foreach ($adminOptions as $value) {
switch ( $value['type'] ) {
 
case "open":
?>
 
<?php break;
 
case "close":
?>
 
</div>
</div>
<br />
 
<?php break;
 
case "title":
?>
 
<?php break;
 
case 'colorbox':
?>
<div class="rm_input rm_text">
	<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?> #</label>
 	<?php if ($selectedPageID): ?>
		<input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="text" value="<?php if ( get_post_meta( $selectedPageID ,$value['id'], true) != "") 
			{ echo htmlspecialchars( get_post_meta( $selectedPageID ,$value['id'], true) ); } else { echo $value['std']; } ?>" />
		<input style="width: 115px; style=text-align: left; border: solid 1px #DDDDDD; editable: false; background: #<?php echo get_post_meta( $selectedPageID ,$value['id'], true); ?>" />
	<?php else : ?>
			<input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="text" value="<?php if ( get_option( $value['id'] ) != "") 
			{ echo stripslashes(get_option($value['id']) ); } else { echo $value['std']; } ?>" />
		<input style="width: 115px; style=text-align: left; border: solid 1px #DDDDDD; editable: false; background: #<?php echo get_option( $value['id'] ); ?>" />
    <?php endif; ?>
	<small><?php echo $value['desc']; ?></small><div class="clearfix"></div>
 </div>
<?php
break;

case 'text':
?>

<div class="rm_input rm_text">
	<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
	<?php if ($selectedPageID): ?>
		<input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_post_meta( $selectedPageID ,$value['id'], true) != "") 
			{ echo htmlspecialchars(get_post_meta( $selectedPageID ,$value['id'], true) ); } else { echo $value['std']; } ?>" />
	<?php else : ?>
 		<input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_option( $value['id'] ) != "") 
		{ echo stripslashes(get_option( $value['id'])  ); } else { echo $value['std']; } ?>" />
    <?php endif; ?> 
	<small><?php echo $value['desc']; ?></small><div class="clearfix"></div>
 </div>
<?php
break;

case 'textarea':
?>

<div class="rm_input rm_textarea">
	<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
	<?php if ($selectedPageID): ?>
		<textarea name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" cols="1" rows="1"><?php if ( get_post_meta( $selectedPageID ,$value['id'], true) != "") 
		{ echo htmlspecialchars(get_post_meta( $selectedPageID ,$value['id']) ); } else { echo $value['std']; } ?></textarea>
 	<?php else : ?>
		<textarea name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" cols="1" rows="1"><?php if ( get_option( $value['id'] ) != "") 
		{ echo stripslashes(get_option( $value['id']) ); } else { echo $value['std']; } ?></textarea> 	
	<?php endif; ?>
	<small><?php echo $value['desc']; ?></small><div class="clearfix"></div>
 </div>
  
<?php
break;
 
case 'select':
?>

<div class="rm_input rm_select">
	<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>	
<select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
<?php foreach ($value['options'] as $option) { ?>
	<?php if ($selectedPageID): ?>
		<option <?php if (get_post_meta( $selectedPageID ,$value['id'],true) == $option) { echo 'selected="selected"'; } ?>><?php echo $option; ?></option>
	<?php else : ?>
		<option <?php if (get_option( $value['id'] ) == $option) { echo 'selected="selected"'; } ?>><?php echo $option; ?></option>
	<?php endif; ?>
	<?php } ?>
	</select>
	<small><?php echo $value['desc']; ?></small><div class="clearfix"></div>
</div>
<?php
break;

case 'pages':
?>

<div class="rm_input rm_select">
	<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>	
	<select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
	<?php foreach ($value['options'] as $option) { ?>
		<option <?php if (get_option( $value['id'] ) == $option) { echo 'selected="selected"'; } ?>><?php echo $option; ?></option><?php } ?>
	</select>
	<small><?php echo $value['desc']; ?></small><div class="clearfix"></div>
</div>
<?php
break;
 
case "checkbox":
?>

<div class="rm_input rm_checkbox">
	<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
	<?php if ($selectedPageID): ?>
		<?php if(get_post_meta( $selectedPageID ,$value['id'], true)){ $checked = "checked=\"checked\""; }else{ $checked = "";} ?>
	<?php else : ?>
		<?php if(get_option($value['id'])){ $checked = "checked=\"checked\""; }else{ $checked = "";} ?>
	<?php endif ?>
	<input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> />
	<small><?php echo $value['desc']; ?></small><div class="clearfix"></div>
 </div>
<?php break;

case "section":

$i++;

?>

<div class="rm_section">
<div class="rm_title"><h3><?php echo $value['name']; ?></h3><span class="submit"><input name="save<?php echo $i; ?>" type="submit" value="Save changes" />
</span><div class="clearfix"></div></div>
<div class="rm_options">

 
<?php break;
 
}
}
?>
 
<input type="hidden" name="action" value="save" />
</form>
<form method="post">
WARNING: Reset will clear all the values!
<p class="submit">
<input name="reset" type="submit" value="Reset" />
<input type="hidden" name="action" value="reset" />
</p>
</form>
</div> 

</div>

<?php
}
?>
<?php
add_action('admin_menu', 'mytheme_add_admin');
add_action('admin_init', 'mytheme_style_init');
?>