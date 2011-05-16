	//this file is for javascript specific to the site. For all other JS, see halfnerd.jquery.js
$(document).ready( function(){
	
	//preload content
	//check to see if content has already been preloaded
	if( getSessionVar( 'preload' ) == "0" ) 
	{
		//set loader content and show loader
		$( "#loader" ).css( "display", "block" );
		
		//update loader message
		$( "#loader_message" ).html( "Preloading images..." );
		
		//put image in cache
		var bg_img = new Image();
		var little_loader = new Image();
		
		//load background image and loader gif
		$( little_loader ).load( function(){ $( "#preloader" ).append( little_loader ); } ).attr( 'src', "/images/loader_small.gif" );
		$( bg_img ).load( function(){ $( "#preloader" ).append( bg_img ); }).attr( 'src', '/images/bg_nature.jpg' );
		
		$.ajax({
			type: 'post',
			url: '/ajax/pbr_helper.php?task=file&process=site_images_feed',
			success: function( photo_string ) {
				
				//split string into array
				var photos = photo_string.split( "^" );
				
				for( var i = 0; i < photos.length; i++ )
				{
					var img = new Image();
					$( img ).load( function(){ $( "#preloader" ).append( img ); } ).attr( 'src', photos[i] );
				}
				
				
				//hide loader div, fade in page
				$( "#loader" ).hide();
				$( ".page" ).fadeIn( 3000 );
				
				//record preload
				setSessionVar( 'preload', '1' );
				
				//capture anchor
				captureAnchor();
			}
		});
		
		/*
		//load picasa webalbum pics
		$.ajax({
			type:'post',
			url:'/ajax/pbr_helper.php?task=picasa&process=all_pics_feed',
			success:function( photo_string ){
				
				//split string into array
				var photos = photo_string.split( "^" );
				
				//update loader message
				$( "#loader_message" ).html( 'Loading Picasa Web Album Photos...' );
				
				//loop through photos and load into cache
				for( var i = 0; i < photos.length; i++ )
				{
					var img = new Image();
					img.src = photos[i];
					
				}
			}
		});
		*/
	}
	else
	{
		//show page
		$( ".page" ).css( "display", "block" );
		
		//capture anchor
		captureAnchor();
	}
	
	//init slideshow
	$( window ).load( function(){ $( "#slider" ).nivoSlider(); } );
	
	//main menu hover
	$( ".nav_item" )
		.live( "mouseenter", function(){
			
			if( $( this ).find( ".nav_sub" ).length > 0 ) {
				$( this ).find( ".nav_sub" ).slideDown( 500 );
			}
		})
	
		.live( "mouseleave", function(){
			
			if( $( this ).find( ".nav_sub" ).length > 0 ) {
				$( this ).find( ".nav_sub" ).slideUp( 700 );
			}
		});
	
	//portfolio img hover
	$( ".thumb_holder" )
		.live( "mouseenter", function(){
			$( this ).css( "cursor", "pointer" );
			$( this ).find( "img" ).removeClass( "thumb_dimmed" );
			$( this ).find( "img" ).addClass( "thumb_bright" );
		})
		
		.live( "mouseleave", function(){
			$( this ).css( "cursor", "default" );
			$( this ).find( "img" ).removeClass( "thumb_bright" );
			$( this ).find( "img" ).addClass( "thumb_dimmed" );
		})
	
		.live( "click", function( event ) {
			
			var orientation = $( this ).find( "img" ).attr( "orientation" );
			var full_src = $( this ).find( "img" ).attr( "full_src" );
			var main_content = $( "#main_content_container" );
			var use_jquery = $( this ).attr( "use_jquery" );
			
			if( use_jquery == "1" )
			{
				var img = new Image();
				
				//show loader
				$( ".full_img" ).append( '<div id="thumb_loader" class="thumb_loader loading"></div>' );
				
				//set img src ( see closing tag )
				$( img ).load( function(){
					
					//change canvas size
					if( orientation == "landscape" )
					{
						if( main_content.hasClass( "portrait_height" ) )
						{
							main_content.removeClass( "portrait_height" );
							main_content.addClass( "landscape_height" );
						}
								
					}
					else if( orientation == "portrait" )
					{
						if( main_content.hasClass( "landscape_height" ) )
						{
							main_content.removeClass( "landscape_height" );
							main_content.addClass( "portrait_height" );
						}
					}
					
					//clear canvas and remove classes
					$( ".full_img" ).html( "" );
					$( ".full_img" ).removeClass( "loading" );
					
					//add image to canvas
					$( ".full_img" ).append( img );
					
				}).attr( 'src', full_src );
								
			}//use jquery
			
			
		});
	
	$( ".featured_thumb_holder" )
		.live( "mouseenter", function(){
			//show message
			showHoverMessage( "Click To See Full Size", $( this ) );
		})
		
		.live( "mouseleave", function(){
			hideHoverMessage( $( this ) );
		})
	
		.live( "click", function(){
			$.imgbox( $( this ).find( "a" ) );
		});
	
	$( ".album_paginator" )
		.live( "click", function(){
			
			var current_page = $( "#current_page" );
			var page_num = $( this ).attr( "page_num" );
			var page_holder = $( "#thumb_menu_inner" );
			var page_height = parseInt( $( "#page_height" ).val() );
			
			if( page_num != current_page.val() )
			{
				var top_margin = ( ( page_num * page_height ) - page_height ) * -1;
				page_holder.css( "margin-top", top_margin );
				current_page.val( page_num );
				
				//reset links
				$( ".album_paginator" ).removeClass( "selected" );
				$( this ).addClass( "selected" );
				
			}
			
		});
	
	$( ".album_link" )
		.live( "click", function( event ){
			
			//get num
			var album_num = $( this ).attr( "album_num" );
			
			//show loader
			$( "#album_loader_" + album_num ).addClass( "loading" );
		});
	
	$( "a" )
		.live( "click", function(){
			$( this ).blur();
		});
	
	 
    //validate and send mail
	$( "#send_message" )
		.click( function(){
			$.ajax({
				type: 'post',
				url: "ajax/halfnerd_helper.php?task=mail&process=validate",
				data: $( "#message_form" ).serialize( true ),
				success: function( reply ){
				
					//get vars
					var reply_split = reply.split( "^" );
					
					var result =  reply_split[0];
					var message = reply_split[1];  
					
					//clear form
					if( result == 1 )
					{
						//send email
						$.ajax({
							type: 'post',
							url: "ajax/halfnerd_helper.php?task=mail&process=send",
							data: $( "#message_form" ).serialize( true ),
							success: function( reply ){
								
								//show hover message
								showFullHoverMessage( "Email Sent", $( ".contact_email" ) );
								
								//clear form and remove message
								setTimeout( 'window.location.reload();', 2000 );
							}
						});
						
					}
					else
					{
						$( "#result" ).removeClass( "color_accent" ).addClass( "form_error" ).html( message );
					}
					
				}
			});
		});
	
//admin-------------------------------------------------------------------------------------------------------------------------
	
	if( userHasValidLogin() == "1" )
	{
		$( ".article_body" )
			.live( "click", function(){
				
				var article_id = extractArticleId( $( this ).attr( 'id' ) );
				var height = 310;
				var width = parseInt( $( this ).css( "width" ) );
				
				if( typeof( $( this ).attr( "has_been_clicked" ) ) == "undefined" )
				{
					//show edit mode
					$( this ).attr( "has_been_clicked", "1" );
					var current_el = $( this );
					
					//format text
					var formatted_text = $.ajax({
						type: 'post',
						url: '/ajax/halfnerd_helper.php?task=article&process=format_body_for_text_box&article_id=' + article_id,
						success:function( formatted_text ){
						
							current_el.html( '<textarea class="normal_font input" style="height:' + height + 'px;width:' + width + 'px;" id="article_body_text_' + article_id + '">' + formatted_text + '</textarea>' );
							toggleControls( article_id, "body", "show" );
							
						}  
					});
				}	
			})
		
			.live( "mouseenter", function(){
				showHoverMessage( "Click To Edit.", $( this ) );
			})
		
			.live( "mouseleave", function(){
				hideHoverMessage( $( this ) );
			});
		
		$( ".article_body_cancel" )
			.live( "click", function(){
				
				var article_id = $( this ).attr( 'article_id' );
				articleBodyRevert( article_id );
			});
		
		$( ".article_body_save" )
			.live( "click", function(){
				
				var article_id = $( this ).attr( 'article_id' );
				
				if( userHasValidLogin() == "1" )
				{
					var new_body = $( "#article_body_text_" + article_id ).val();
					
					//save
					$.ajax({
						type: 'post',
						url: '/ajax/halfnerd_helper.php?task=article&process=save_body&article_id=' + article_id,
						data: { body: new_body },  
						success: function( reply ){
							articleBodyRevert( article_id );
						}
					});
				}
				else
				{
					showAccessDenied( $( this ) );
					articleBodyRevert( article_id );
				}
			});
		
		$( ".article_title" )
			.live( "click", function(){
			
				//remove div
				hideHoverMessage( $( this ) );
				
				//get article_id
				var article_id = extractArticleId( $( this ).attr( 'id' ) );
				
				var width = parseInt( $( this ).css( "width" ) );
				var html = $.trim( $( this ).html() );
				var link_style = 'font-family:arial;font-size:12px;font-weight:normal;letter-spacing:0em;';
				
				if( typeof( $( this ).attr( "has_been_clicked" ) ) == "undefined" )
				{
					//show edit mode
					$( this ).attr( "has_been_clicked", "1" );
					$( this ).html( '<input class="input text_input normal_font center" type="text" style="width:' + width +'px;" value="' + html + '" id="article_title_text_' + article_id + '" />' );
					
					toggleControls( article_id, "title", "show" );
				}	
			})
		
			.live( "mouseenter", function(){
				showHoverMessage( "Click To Edit.", $( this ) );
			})
		
			.live( "mouseleave", function(){
				hideHoverMessage( $( this ) );
			});
		
		$( ".article_title_cancel" )
		.live( "click", function(){
			
			var article_id = $( this ).attr( 'article_id' );
			var html = $( "#article_title_text_" + article_id ).val();
			
			//reset text
			articleTitleRevert( article_id, html );
			
		});
		
		$( ".article_title_save" )
		.live( "click", function(){
			
			var article_id = $( this ).attr( 'article_id' );
			var new_title = $( "#article_title_text_" + article_id ).val();
			
			if( userHasValidLogin() == "1" )
			{
				var el_title = "#article_title_" + article_id;
				
				//save title
				$.ajax({
					type: 'post',
					url: '/ajax/halfnerd_helper.php?task=article&process=save_title&article_id=' + article_id,
					data: { title: new_title },
					success: function( reply_title ){
						articleTitleRevert( article_id, reply_title );
					}
				});
			}
			else
			{
				showAccessDenied( $( this ) );
				articleTitleRevert( article_id, "%original%" );
			}
			
		});
		
		$( ".file_edit" )
			.live( "mouseenter", function(){
				showHoverMessage( "Click To Change Image.", $( this ) );
			})
			
			.live( "mouseleave", function(){
				hideHoverMessage( $( this ) );  
			})
		
			.live( "click", function(){
				var file_id = $( this ).attr( 'file_id' );
				var article_id = $( this ).attr( 'article_id' );
				
				$.colorbox({ href: '/ajax/halfnerd_helper.php?task=file&process=show_file_edit&file_id=' + file_id + '&active_id=' + article_id + '&file_type_title=image&link_to=article'  });
				
			});
		
		$( "#show_image_library" )
			.live( "click", function(){
				$( "#file_upload_container" ).fadeOut( 500, function(){
					$( "#image_library_container" ).fadeIn( 500 );
				})
			} );
		
		$( "#show_file_upload" )
			.live( "click", function(){
				
				$( "#image_library_container" ).fadeOut( 500, function(){
					$( "#file_upload_container" ).fadeIn( 500 );
				});
			} );
		
		$( ".img_library_image" )
			.live( "mouseenter", function() {
				showHoverMessage( "Click To Select.", $( this ) );
			})
		
			.live( "mouseleave", function() {
				
				if( typeof( $( this ).attr( "has_been_clicked" ) ) == "undefined" )
				{
					hideHoverMessage( $( this ) );
				}
			})
			
			.live( "click", function(){
				var article_id = $( this ).attr( "article_id" );
				var file_id = $( this ).attr( "file_id" );
				
				//record click
				$( this ).attr( "has_been_clicked", "1" );
				
				//hide hover message
				hideHoverMessage( $( this ) );
				
				//show loader
				$( this ).append( '<div class="thumb_loader loading"></div>' );
				
				//update 
				$.ajax({
					type: 'post',
					url: '/ajax/halfnerd_helper.php?task=article&process=update_file&article_id=' + article_id,
					data:{ file_id: file_id },
					success: function(){
						window.location.reload();
					}
				});
				
				
			});
		
		$( ".contact_email" )
			.live( "mouseenter", function(){
				showFullHoverMessage( "Click to change email address.", $( this ) );
			})
			
			.live( "mouseleave", function(){
				hideHoverMessage( $( this ) );
			})
			
			.live( "click", function(){
				$.colorbox( { href: '/ajax/halfnerd_helper.php?task=env_var&process=show_mod_form&env_var_title=mail_to'} );
			});
		
		$( ".contact_studio" )
			.live( "mouseenter", function(){
				showHoverMessage( "Click to change studio address.", $( this ) );
			})
			
			.live( "mouseleave", function(){
				hideHoverMessage( $( this ) );
			})
			
			.live( "click", function(){
				$.colorbox( { href: '/ajax/halfnerd_helper.php?task=env_var&process=show_mod_form&env_var_title=mail_to'} );
		});
		
		
			
		
	}//if user has valid login
});

function clearForm( form_id )
{
	//clear form
	$( ":input", form_id )
		.not( ":button, :submit, :hidden, :reset" )
		.val( "" );
}

function showAccessDenied( el )
{
	alert( "You must login to edit content." );
}

function hideHoverMessage( el )
{
	el.find( "#thumb_loader" ).remove()
}//hideHoverMessage()

function showHoverMessage( message, el )
{
	if( typeof( el.attr( "has_been_clicked" ) ) == "undefined" ||
		el.attr( "has_been_clicked" ) == "ignore" )
	{
		var top = parseInt( el.css( "height" ) )/2 - 10;
		var left = parseInt( el.css( "width" ) )/2 - 60;
		var html = '<div id="thumb_loader" class="thumb_loader"><div class="paginator_style featured_thumb_message color_accent" style="top:' + top + 'px;left:' + left + 'px;font-size:12px;font-weight:normal;letter-spacing:0em;">' + message + '</div></div>';
		el.append( html );
	}
	
}//showHoverMessage()

function showFullHoverMessage( message, el )
{
	
	var top = parseInt( el.css( "height" ) )/2 - 10;
	var left = parseInt( el.css( "width" ) )/2 - 60;
	var html = '<div id="thumb_loader" class="thumb_loader" style="background-color:#FFF;opacity:.5;"><div class="paginator_style featured_thumb_message color_accent" style="top:' + top + 'px;left:' + left + 'px;font-size:12px;font-weight:normal;letter-spacing:0em;">' + message + '</div></div>';
	el.append( html );
	
}//showFullHoverMessage()

function hideFullHoverMessage( el_name )
{
	$( el_name ).find( "#thumb_loader" ).remove();
}//hideFullHoverMessage()

function articleTitleRevert( article_id, text )
{
	var el_title = "#article_title_" + article_id;
	
	if( text == "%original%" )
	{
		$.ajax({
			type:'post',
			url: '/ajax/halfnerd_helper.php?task=article&process=get_title&article_id=' + article_id,
			success:function( original_title ){
			
				$( el_title ).html( original_title );
				$( el_title ).removeAttr( "has_been_clicked" );
				toggleControls( article_id, "title", "hide" );
			}
		});
	}
	else
	{
		$( el_title ).html( text );
		$( el_title ).removeAttr( "has_been_clicked" );
		toggleControls( article_id, "title", "hide" );
	}
	
}//articleTitleRevert()

function articleBodyRevert( article_id )
{
	var el_title = "#article_body_" + article_id;
	
	//reformat text
	$.ajax({
		type: 'post',
		url: '/ajax/halfnerd_helper.php?task=article&process=format_body&article_id=' + article_id,
		success: function( text ){
		
			$( el_title ).html( text );
			$( el_title ).removeAttr( "has_been_clicked" );
			toggleControls( article_id, "body", "hide" );
		}
	});
	
}//articleBodyRevert()

function toggleControls( article_id, type, show_hide )
{
	if( show_hide == "show" )
	{
		//show controls
		$( "#" + type + "_control_" + article_id ).show();
	}
	else
	{
		//hide controls
		$( "#" + type + "_control_" + article_id ).hide();
	}
	
}//toggleControls()

function extractArticleId( el_id )
{
	var id_split = el_id.split( "_" );
	var key = id_split.length - 1;
	return id_split[key];
}//extractArticleId()

function captureAnchor()
{
	var return_bool = false;
	
	//store current anchor
	if( window.location.href.indexOf( "#" ) != -1 )
	{
		return_bool = true;
		var url_split = window.location.href.split( "#" );
		
		//store anchor in session
		setSessionVar( 'anchor', url_split[1] );
	}
	
	/*
	if( return_bool )
	{
		var reloaded = getSessionVar( 'has_been_reloaded' );
		
		if( reloaded == "0" )
		{
			//reload page so the controller can get another look at the session vars
			window.location.reload();
			setSessionVar( 'has_been_reloaded', 1 );
		}
	}
	*/
	return return_bool;
	
}//captureAnchor()