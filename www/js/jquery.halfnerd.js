
//start event listeners--------------------------------------------------------------------------------------------------------

$(document).ready(function(){
	
	//imgbox settins are set within jquery.imgbox.js
	
	//colorbox settings
    $.fn.colorbox.settings.transition = "fade";
    $.fn.colorbox.settings.bgOpacity = "0.7";
    $.fn.colorbox.settings.contentCurrent = "({current}/{total})";
    $.fn.colorbox.settings.current = "Member {current} of {total}";
    
    //datepicker init
    $.datepicker.setDefaults( {
		dateFormat: "mm-dd-yy",
		buttonImageOnly:false
	});
    
    //init pickers
    initDatepickers();
    //initTimepickers();
    
    //colorbox close
    $( "#close_colorbox" ).live( "click", function() {
    	$.colorbox.close();
    });
    
    //onload, populate featured section with video content
    $( window ).load( function(){
		if( $( "#featured_content" ).length > 0 )
		{
			showLoader( "#" + target, 'style="position:absolute;margin:auto;top:150px;left:47%;"' );
		}	
	});
	
	//kill session
	$( "#kill_session" ).click( function(){
		$.ajax({
			type: "POST",
			url: "ajax/halfnerd_helper.php?task=session&process=kill",
			data: "",
			success: function( reply ){
				//alert( "reply: " + reply );return false;
				window.location.reload();
			}
		});
	});
	
	$( "#kill_login" ).click( function(){
		$.ajax({
			type: "POST",
			url: "ajax/halfnerd_helper.php?task=session&process=kill_login",
			data: "",
			success: function( reply ) {
				window.location.reload();
			}
		});
	});
	
	 //login form via colorbox
    $( "#colorbox_login" )
    	.live( "click", function(){
    		
    		if( userHasValidLogin() == "0" )
    		{
    			$.colorbox({ href: '/ajax/halfnerd_helper.php?task=authentication&process=show_login_form' });
    		}
    		else
    		{
    			alert( "You must first logout to login..." );  
    		}
    	});
    
    $( "#colorbox_change_pass" )
    	.live( "click", function(){
    		$.colorbox({ href: '/ajax/halfnerd_helper.php?task=authentication&process=show_password_form' });
    	});
    
  //submit input
    $( ".input_clear" )
    	.live( "click", function(){
	    	var clear_if = $( this ).attr( "clear_if" ).toLowerCase();
	    	var cur_val = $( this ).val().toLowerCase();
	    	
	    	if( clear_if == cur_val )
	    	{
	    		$( this ).val( "" );
	    	}
	    })
    
    	.live( "blur", function(){
    		if( $( this ).val() == "" )
        	{
        		var clear_if = $( this ).attr( "clear_if" );
        		$( this ).val( clear_if );
        	}
    	});
    
    //auth login
    $( "#auth_login" ).live( "click", function(){
    	
    	$.ajax({
			type:"POST",
			url:"ajax/halfnerd_helper.php?task=session&process=validate_login",
			data: $( "#auth_login_form" ).serialize( true ),
			success: function( reply ){
    			
	    		//get result
				var reply_split = reply.split( "^" );
				var result =  reply_split[0];
				var message = reply_split[1];
				
				if( result == 1 )
				{
					//store login vars into session and reload page
					$.ajax({
						type:"POST",
						url:"ajax/halfnerd_helper.php?task=session&process=store_login",
						data: $( "#auth_login_form" ).serialize( true ),
						success: function( reply ){
							
							window.location.reload();
						}
					});
				}
				else
				{
					styleResult( 0 );
					showMessage( message );
				}
			}
		});
    });
    
    $( "#auth_change_pass" )
    	.live( "click", function(){
    		
    		$.ajax({
    			type:"post",
    			url:"ajax/halfnerd_helper.php?task=authentication&process=validate_change_password",
    			data: $( "#auth_password_form" ).serialize( true ),
    			success: function( reply ){
    			
    	    		//get result
    				var reply_split = reply.split( "^" );
    				var result =  reply_split[0];
    				var message = reply_split[1];
    				
    				if( result == 1 )
    				{
    					//store login vars into session and reload page
    					$.ajax({
    						type:"POST",
    						url:"ajax/halfnerd_helper.php?task=authentication&process=change_password",
    						data: $( "#auth_password_form" ).serialize( true ),
    						success: function( reply ){
    						
	    						$( "#result" ).removeClass( "form_error" ).addClass( "color_accent" ).html( message );
	    						
	    						//logout
	    						$.ajax({
	    							type: "POST",
	    							url: "ajax/halfnerd_helper.php?task=session&process=kill_login",
	    							data: "",
	    							success: function( reply ) {
	    								setTimeout( 'window.location.reload();', 1000 );
	    							}
	    						});
    						}
    					});
    				}
    				else
    				{
    					$( "#result" ).removeClass( "selected" ).addClass( "form_error" ).html( message );
    				}
    			}
    		});
    	});
    	
    
    $( "#authentication" ).live( "click", function(){
    	
    	var contact_id = $( this ).attr( "contact_id" );
    	var action = $( this ).attr( "action" ).toLowerCase();
    	var authentication_id = $( this ).attr( "authentication_id" );
    	//alert( "C: " + contact_id + " act: " + action + " auth: " + authentication_id );
    	
    	if( action == "add" || action == "modify" )
    	{
			$.ajax({
				type: 'post',
				url: 'ajax/halfnerd_helper.php?task=authentication&process=validate&authentication_id=' + authentication_id,
				data: $( "#auth_add_mod_form" ).serialize( true ),
				success: function( reply ){
				
    				//get vars
    				var reply_split = reply.split( "^" );
    				var result =  reply_split[0];
    				var message = reply_split[1];  
    				
    				//clear form
    				if( result == 1 )
    				{
    					//save record
    					$.ajax({
    						type: 'post',
    						url: "ajax/halfnerd_helper.php?task=authentication&process=" + action + "&authentication_id=" + authentication_id,
    						data: $( "#auth_add_mod_form" ).serialize( true ),
    						success: function( auth_id ){
    							
    							//link record to contact
    							$.ajax({
    								type: 'post',
    								url: 'ajax/halfnerd_helper.php?task=contact&process=link_auth&contact_id=' + contact_id + '&action=' + action,
    								data: { authentication_id: auth_id },
    								success: function( reply ){
    									alert( "this is reply: " + reply );
    									closeColorbox(1);
    								}
    							});
    						}
    					});
    				}
    				else
    				{
    					styleResult( 0 );
    				}
    				
    				showMessage( message );
				}
			});
    	}
    });
    	
   //add/modify/delete article
	$( "#article" ).live( "click", function( event ){
		
		//cancel event
		event.preventDefault();
		
		var action = $( this ).attr( "action" ).toLowerCase();
		var article_id = $( this ).attr( "article_id" );
		var view_title = $( this ).attr( "view" );
		var section_title = $( this ).attr( "section" );
		var video_id = ( $( this ).attr( "video_id" ) ) ? '&video_id=' + $( this ).attr( "video_id" ) : '';
		
		if( action == "modify" || action == "add" )
		{
			var from_add = ( action == "add" ) ? 1 : 0;
			
			$.ajax({
				type: 'post',
				url: "ajax/halfnerd_helper.php?task=article&process=validate",
				data: $( "#article_form" ).serialize( true ),
				success: function( reply ) {
				
					if( showErrorMessage( reply ) == false )
					{
						//get vars
						var reply_split = reply.split( "^" );
						var result =  reply_split[0];
						var message = reply_split[1];
						
						//clear form
						if( result == 1 )
						{
							//add or modify article
							$.ajax({
								type: 'post',
								url: "ajax/halfnerd_helper.php?task=article&process=" + action + '&article_id=' + article_id + '&from_add=' + from_add,
								data: $( "#article_form" ).serialize( true ),
								success: function( reply ){
								
										styleResult( 1 );
										closeColorbox( 0 );
								}
							});
						}
						else
						{
							styleResult( 0 );
						}
						
						showMessage( message );
					}
				}
			});
		}
		else if( action == "delete" )
		{
			$.ajax({
				type:'post',
				url: "ajax/halfnerd_helper.php?task=article&process=" + action + '&article_id=' + article_id + '&video_id=' + video_id,
				data: "",
				success: function( reply ){
					closeColorbox( "1" );
				}
			});
		}
		else
		{
			$.colorbox({ href:"ajax/halfnerd_helper.php?task=article&process=" + action + '&article_id=' + article_id + '&view_title=' + view_title + '&section_title=' + section_title + video_id });
		}
	});
	
	//envvars
	$( "#env_var" ).live( "click", function( event ){
		
		//cancel event
		event.preventDefault();
		
		//set vars
		var action = $( this ).attr( "action" ).toLowerCase();
		var env_var_id = $( this ).attr( "env_var_id" );
		
		if( action == "modify" || action == "add" )
		{
			var from_add = ( action == "add" ) ? 1 : 0;
			
			$.ajax({
				type: 'post',
				url: "ajax/halfnerd_helper.php?task=env_var&process=validate",
				data: $( "#env_var_form" ).serialize( true ),
				success: function( reply ) {
					if( showErrorMessage( reply ) == false )
					{
						//get vars
						var reply_split = reply.split( "^" );
						var result =  reply_split[0];
						var message = reply_split[1];
						
						//clear form
						if( result == 1 )
						{
							//add or modify article
							$.ajax({
								type: 'post',
								url: "ajax/halfnerd_helper.php?task=env_var&process=" + action + '&env_var_id=' + env_var_id + '&from_add=' + from_add,
								data: $( "#env_var_form" ).serialize( true ),
								success: function( reply ){
									showMessageNew( result, message );
									closeColorbox( '0' );
								}
							});
						}
						else
						{
							showMessageNew( result, message );
						}
					}
				}
			});
		}
	});
	
	$( "#upload_file" ).live( "click", function( event ){
			
		 //validate file list
		var validation_result = validateFileUploadForm();
		var active_event_id = $( "#active-event-id" ).attr( 'value' );
		
		if( validation_result != false )
		{
			styleResult( "0" );
			$( "#result" ).html( validation_result );
		}
		else
		{
			//upload file
			$( "#file_upload_form" ).submit();
			
			//show success message
			$( "#result" ).delay( 1000 ).html( "File uploaded successfully." );
			
			setTimeout( 'castingCallUpdateContent( "4",' +  active_event_id + ' );', 1000 );
			
		}
	});
	
	$( "#upload_image" ).live( "click", function( event ){
		
		//set vars
		var file = $( "#file_to_upload" ).attr( "value" );
		
		//show loader
		$( "#result" ).removeAttr( "style" );
		$( "#result" ).addClass( "normal_font" )
		$( "#result" ).html( '<img src="/images/loader_small.gif" />&nbsp;Uploading...' );
		
		$.ajax({
			type:'post',
			url: 'ajax/halfnerd_helper.php?task=file&process=validate',
			data: { file_path_and_name: file, is_image: "1" },
			success: function( validation_result ){
				
				validation_result = $.trim( validation_result );
				
				if( validation_result != "0" )
				{
					styleResult( "0" );
					$( "#result" ).html( validation_result );
				}
				else
				{
					//upload file
					$( "#file_upload_form" ).submit();
					
					setTimeout( 'window.location.reload();', 7000 );
				}
			}
		});
		
	});
	
	//add/modify/delete casting call
	$( "#contact" ).live( "click", function(){
		
		var action = $( this ).attr( "action" ).toLowerCase();
		
		if( $( this ).attr( "contact_id" ) )
		{
			var contact_id =  $( this ).attr( "contact_id" );
		}
		else
		{
			var contact_id = $( "#active_contact_id" ).val();
			
			if( contact_id == 0 )
			{
				alert( "Please select a crew member by clicking on their image." );
				return false;
			}
		}
		
		if( action == "modify" || action == "add" )
		{
			var from_add = ( action == "add" ) ? 1 : 0;
			
			$.ajax({
				type: 'post',
				url: "ajax/halfnerd_helper.php?task=contact&process=validate&from_add=" + from_add,
				data: $( "#contact_details_form" ).serialize( true ),
				success: function( reply ) {
					
					if( showErrorMessage( reply ) == false )
					{
						//get vars
						var reply_split = reply.split( "^" );
						var result =  reply_split[0];
						var message = reply_split[1];
						
						//clear form
						if( result == 1 )
						{	
							//add or modify contact
							$.ajax({
								type: 'post',
								url: "ajax/halfnerd_helper.php?task=contact&process=" + action + '&contact_id=' + contact_id + '&from_add=' + from_add,
								data: $( "#contact_details_form" ).serialize( true ),
								success: function( reply ){
									
									var contact_id = $.trim( reply );
									
									//update active event id
									$( "#active-contact-id" ).attr( 'value', contact_id );
									
									//update dom to inidicate step completion
									$( "#step-is-complete" ).attr( 'value', '1' );
									
								}
							});
						}
						else
						{
							styleResult( 0 );
						}
						
						showMessage( message );
					}
				}
			});
		}
		else if( action == "delete" )
		{
			$.ajax({
				type:'post',
				url: "ajax/halfnerd_helper.php?task=contact&process=" + action + '&contact_id=' + contact_id,
				data: "",
				success: function( reply ){
					alert( "this is reply: " + reply );
					//closeColorbox( 1 );
					//window.location.reload();
				}
			});
		}
		else
		{
			//open colorbox for editing
			var url = "ajax/halfnerd_helper.php?task=contact&process=" + action + "&contact_id=" + contact_id;
			$.colorbox({ href: url } );
		}
	});
	
	//add/modify/delete casting call
	$( "#contact_type" ).live( "click", function(){
		
		var action = $( this ).attr( "action" ).toLowerCase();
		var contact_type_id = $( this ).attr( "contact_type_id" );
		 
		switch( action )
		{
			case "show-add":
				$.colorbox({ href: "ajax/halfnerd_helper.php?task=contact_type&process=show-add&contact_type_id=" + contact_type_id } );
				break;
				
			case "show-mod":
				$.ajax({
					type: 'post',
					url: 'ajax/halfnerd_helper.php?task=contact_type&process=show-mod&contact_type_id=' + contact_type_id,
					data: {},
					success: function( mod_html ) {
						
						var html_split = mod_html.split( "^" );
						var mod_form = html_split[0];
						var save_buttons = html_split[1];
						var html = mod_form + "&nbsp;&nbsp;" + save_buttons;
						
						$( "#ct_title_" + contact_type_id ).html( mod_form );
						$( "#ct_edit_" + contact_type_id ).html( save_buttons );
					}
					
				});
				break;
				
			case "hide-mod":
				contactType( "hide-mod", new Array( contact_type_id ) );
				break;

			case "delete":
				$.ajax({
					type: 'post',
					url: 'ajax/halfnerd_helper.php?task=contact_type&process=delete&contact_type_id=' + contact_type_id,
					data: {},
					success: function( reply ) {
						
						 //fade out row
						$( "#ct_row_" + contact_type_id ).fadeOut( 1000, function(){
							
							//check count. If count == 0, refresh page to show message.
							$.ajax({
								type: 'post',
								url: 'ajax/halfnerd_helper.php?task=contact_type&process=get-count&contact_type_id=' + contact_type_id,
								data: {},
								success: function( ct_count ){
									
									if( $.trim( ct_count ) == "0" )
									{
										window.location.reload();
									}
								}
								
							}); 
						});	
					}
				});
				break;
				
			default:
				
				//handle add/mod
				if( action == "add" || action == "modify" )
				{
					var from_add = ( action == "add" ) ? 1 : 0;
					
					$.ajax({
						type: 'post',
						url: "ajax/halfnerd_helper.php?task=contact_type&process=validate&contact_type_id=" + contact_type_id + "&from_add=" + from_add,
						data: $( "#contact_type_form_" + contact_type_id ).serialize( true ),
						success: function( reply ) {
						
							if( showErrorMessage( reply ) == false )
							{
								//get vars
								var reply_split = reply.split( "^" );
								var result =  reply_split[0];
								var message = reply_split[1];
								
								//clear form
								if( $.trim( result ) == "1" )
								{
									//add or modify article
									$.ajax({
										type: 'post',
										url: "ajax/halfnerd_helper.php?task=contact_type&process=" + action + '&contact_type_id=' + contact_type_id + '&from_add=' + from_add,
										data: $( "#contact_type_form_" + contact_type_id ).serialize( true ),
										success: function( reply ){
											if( action == "modify" )
											{
												styleResult( 1 );
											}
											else
											{
												$( "#result_contact_type_add" ).css( "color", "#8c42ae" );
											}
											
											if( action == "modify" )
											{
												contactType( "hide-mod", new Array( contact_type_id ) );
											}
											else
											{
												closeColorbox( 1 );
											}
										}
									});
								}
								else
								{
									if( action == "modify" )
									{
										styleResult( 0 );
									}
									else
									{
										$( "#result_contact_type_add" ).css( "color", "#FF0000" );
									}
								}
								
								if( action == "modify" )
								{
									showMessage( message );
								}
								else
								{
									$( "#result_contact_type_add" ).html( message );
								}
							}
						}
					});
				}
				break;
				
		}//end switch
		
	});
});
	
//start functions-------------------------------------------------------------------------------------------------------------------

function styleResult( success )
{
	if( success == "1" )
	{
		$( "#result" ).css( "color", "#8c42ae" );
	}
	else
	{
		$( "#result" ).css( "color", "#FF0000" );
	}
}//styleResult()

function showMessage( message )
{
	//display message
	$( "#result" ).html( message );
	
}//showMessage()

function showMessageNew( result, message)
{
	var class_to_remove = ( result == 1 ) ? "form_error" : "normal_font";
	var class_to_add = ( result == 1 ) ? "normal_font" : "form_error";
	
	$( "#result" ).removeClass( class_to_remove ).addClass( class_to_add ).html( message );
}//showMessageNew()

function closeColorbox( reload )
{
	var reload_cmd = "";
	if( reload == "1" )
	{
		reload_cmd = 'window.location.reload();';
	}
	
	setTimeout( '$.colorbox.close();' + reload_cmd, 500 );
	
}//closeColorbox()

function showErrorMessage( reply )
{
	return_bool = false;
	
	if( reply.length > 0 && reply.indexOf( "^" ) == -1 )
	{
		alert( "Uh oh, something went wrong! Helper file said '" + reply + "'" );
		return_bool = true; 
	}
	
	return return_bool;
	
}//showErrorMessage()

function trimLastCharFromString( string )
{
	//set vars
	var second_to_last_char = string.length - 1;
	var return_string = string.substr( 0, second_to_last_char );
	
	return return_string;
	
}//trimLastCharFromString()

function countString( string, delim )
{
	//set vars
	var string_array = string.split( delim );
	var return_value = string_array.length;
	
	return return_value;
	
}//countString()

function showLoader( element, style )
{
	var loader_html = '<div class="loader_div"' + style + '><img src="/images/ajax-loader.gif" /></div>';
	
	$( element ).html( loader_html );
	
}//showLoader()

function validateFileUploadForm()
{
	//set vars
	var return_value = false;
	
	//check strlen
	if( $( "#file_to_upload" ).attr( "value" ).length == 0 )
	{
		return_value = "You must select a file.";
	}
	
	return return_value;
	
}//validateFileUploadForm()

function validateImageUploadForm()
{
	//set vars
	var return_value = false;
	var valid_extensions = [ "png", "gif", "jpg", "jpeg" ];
	var file = $( "#file_to_upload" ).attr( "value" );
	
	//check strlen
	if( file.length == 0 )
	{
		return_value = "You must select a file.";
	}
	
	if( return_value == false )
	{
		var val_split = file.split( "." );
		var last_element = val_split.length - 1;
		var extension = val_split[last_element];
		
		if( $.inArray( extension.toLowerCase(), valid_extensions ) == -1 )
		{
			return_value = "File must be an image.";
		}
	}
	
	if( return_value == false )
	{
		checkDuplicateFile( file );
		
		//check unique flag ( controlled by checkDuplicateFile() )
		var file_is_unique = $( "#file_is_unique" ).val();
		if( file_is_unique == "0" )
		{
			return_value = "That file already exists.";
		}
	}
	
	return return_value;
	
}//validateFileUploadForm()

function checkDuplicateFile( file )
{
	//check duplicate file name
	$.ajax({
		type:'post',
		url: "ajax/halfnerd_helper.php?task=file&process=check-dup-file-name",
		data: { file_path_and_name: file },
		success: function( reply ) {
			reply = $.trim( reply );
			
			if( reply != "0" )
			{
				$( "#file_is_unique" ).val( "0" );
			}
			else
			{
				$( "#file_is_unique" ).val( "1" );
				alert( "file IS unique" );
			}
			
			return "hello world";
		}
	});
}//checkDuplicateFile()

function initDatepickers()
{
	
	$( ".datepicker_input" ).datepicker();
	
}//initDatepickers()

function initTimepickers()
{
	
	$( ".timepicker_input" ).timepicker({
		ampm: true,
		stepMinute: 5,
		timeFormat: 'h:mm TT'
	});
	
}//initTimepickers()

function getSessionVar( key )
{
	var return_value = 
		$.ajax({
			type:'post',
			url: 'ajax/halfnerd_helper.php?task=session&process=get_var',
			data: { key: key },
			async:false,
			dataType: "jsonp"
		}).responseText;
	
	return return_value;
}//getSessionVar()

function setSessionVar( key, value )
{
	$.ajax({
		type:'post',
		url: 'ajax/halfnerd_helper.php?task=session&process=set_var',
		data:{ key: key, value: value  }
	});
}//setSessionVar()

function userHasValidLogin()
{
	return $.ajax({
		type: 'post',
		async:false,
		dataType: "jsonp",
		url: '/ajax/halfnerd_helper.php?task=authentication&process=check_current_login'
	}).responseText;
	
}//userHasValidLogin()