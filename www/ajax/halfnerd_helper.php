<?

//start session
session_start();

//require classes
require_once( "pbr_base/Article.php" );
require_once( "pbr_base/Authentication.php" );
require_once( "pbr_base/Common.php" );
require_once( "pbr_base/EmailMessage.php" );
require_once( "pbr_base/EnvVar.php" );
require_once( "pbr_base/Session.php" );

$common = new Common();
$auth = new Authentication( Authentication::getAuthId() );

$task = strtolower( trim( $_GET['task'] ) );
$process = strtolower( trim( $_GET['process'] ) );
$echo_content = FALSE;

//determine action
switch( $task )
{
	case "session":
		switch( $process )
		{
			case "toggle_alert":
				$_SESSION['alert'] = $_POST['alert_status'];
				break;
				
			case "kill":
				//set end timestamp for current session
				$s = new Session( $_SESSION['sid'], TRUE );
				$s->delete( TRUE );
				
				//kill session
				session_destroy();
				break;
				
			case "store_login":
				
				//get auth id
				$sql = "
				SELECT authentication_id
				FROM common_Authentication
				WHERE ( LOWER( username ) = '" . $_POST['username'] . "' OR LOWER( email ) = '" . strtolower( $_POST['username'] ) . "' ) AND
				password = '" . $_POST['password'] . "' AND
				active = 1";
				
				$result = $common->m_db->query( $sql, __FILE__, __LINE__ );
				$row = $common->m_db->fetchAssoc( $result );
				$auth_id = $row['authentication_id'];
				
				$input = array( 'authentication_id' => $auth_id );
				$s = new Session( 0 );
				$sid = $s->add( $input );
				$s->setMemberVars(FALSE );
				$_SESSION['sid'] = $sid;
				break;
				
			case "validate_login":
				$auth = new Authentication( 0 );
				$form_result = $auth->checkLoginForm( $_POST );
				
				if( !$form_result )
				{
					$form_result = $auth->getLoginMessage( $_POST['username'], $_POST['password'] );
				}
				
				$result = ( !$form_result ) ? 1:0;
				$message =   ( !$form_result ) ? "Authenticated Successfully. Redirecting. . ." : $form_result;
				
				echo $result . "^" . $message;
				break;
				
			case "get_var":
				$value = 0;
				if( isset( $_SESSION ) &&
					strtolower( trim ( $_POST['key'] ) ) != "sid" &&
					array_key_exists( $_POST['key'], $_SESSION ) )
				{
					$value = $_SESSION[$_POST['key']];
				}
				
				//send results
				header( 'Content-type: application/x-json' );
				echo json_encode( $value );
				
				break;
				
			case "set_var":
				if( isset( $_SESSION ) &&
					strtolower( trim ( $_POST['key'] ) ) != "sid" )
				{
					$_SESSION[$_POST['key']] = $_POST['value'];
				}
				break;
				
			case "kill_login":
				$s = new Session( $_SESSION['sid'] );
				$s->delete( TRUE );
				$_SESSION['sid'] = "";
				unset( $_SESSION['sid'] );
				break;
		}
		break;
		
	case "authentication":
		
		$a = new Authentication( $_GET['authentication_id'] );
		
		switch( $process )
		{
			case "validate":
				$form_result = $a->checkInput( $_POST, $a->m_common->m_db->fixBoolean( $_GET['from_add'] ) );
				$result = ( !$form_result ) ? 1:0;
				$message =   ( !$form_result ) ? "Crew member updated." : $form_result;
				echo $result . "^" . $message;
				break;
				
			case "add":
				echo $a->add( $_POST );
				break;
				
			case "modify":
				echo $a->modify( $_POST, $a->m_common->m_db->fixBoolean( $_GET['from_add'] ) );
				break;
				
			case "delete":
				echo $a->delete( TRUE );
				break;
				
			case "check_current_login":
				echo ( $auth->validateCurrentLogin() ) ? 1 : 0;
				break;
				
			case "show_login_form":
				$login_form = $auth->getHtml( "show_login_form", array() );
				echo '
				<div class="colorbox_login_container">
					' . $login_form['body'] . '
				</div>
				';
				break;
				
			case "show_password_form":
				$pass_form = $auth->getHtml( "show_password_form", array() );
				
				echo '
				<div class="colorbox_login_container" style="width:auto;">
					' . $pass_form['body'] . '
				</div>
				';
				break;
				
			case "validate_change_password":
				$form_result = $auth->validatePasswordChange( $_POST );
				
				$result = ( !$form_result ) ? 1:0;
				$message =   ( !$form_result ) ? "Password changed successfully. Logging out..." : $form_result;
				
				echo $result . "^" . $message;
				break;
				
			case "change_password":
				$auth->updatePassword( $_POST['new_pass'] );
				break;
		}
		break;
		
	case "article":
		
		switch( $process )
		{
			case "validate":
				//set vars
				$art = new Article( 0 );
				$_POST['authentication_id'] = $auth->m_authentication_id;
				$form_result = $art->checkInput( $_POST, $art->m_common->m_db->fixBoolean( $_GET['from_add'] ) );
				
				$result = ( !$form_result ) ? 1:0;
				$message =   ( !$form_result ) ? "Article Saved" : $form_result;
				
				echo $result . "^" . $message; 
				break;
				
			case "add":
				$art = new Article( 0 );
				$_POST['authentication_id'] = $auth->m_authentication_id;
				$article_id = $art->add( $_POST );
				
				$art_to_view_id = $art->addView( $_POST['view_id'] );
				$art->addSection( $art_to_view_id, $_POST['section_id'] );
				
				echo trim( $article_id );
				break;
				
			case "modify":
				$art = new Article( $_GET['article_id'] );
				echo trim( $art->modify( $_POST, FALSE ) );
				break;
				
			case "delete":
				$art = new Article( $_GET['article_id'] );
				$art->delete( TRUE );
				
				//update video
				if( array_key_exists( "video_id", $_GET ) &&
					$_GET['video_id'] > 0 )
				{
					$v = new Video( $_GET['video_id'] );
					$v->deleteReview( $art->m_article_id, TRUE );
				}
				break;
				
			case "show_add":
				
				$echo_content = TRUE;
				
				$art = new Article( 0 );
				$art_html = $art->getHtml( "get_edit_form", array( 'active_article' => $art, 'section_title' => $_GET['section_title'], 'view_title' => $_GET['view_title'], 'action' => "add" ) );
				
				$body = '
				<div style="position:relative;width:550px;margin:auto 50px auto 20px;">
					' .  $art_html['body'] . '
				</div>
				';
				
				$html = array(
					'title' => 'Add News Article',
					'body' => $body
				);
				break;
				
			case "show_modify":
				
				$echo_content = TRUE;
				$title = "Modify News Article";
				$art = new Article( $_GET['article_id'] );
				$art_html = $art->getHtml( "get_edit_form", array( 'active_article' => $art, 'section_title' => $_GET['section_title'], 'view_title' => $_GET['view_title'], 'action' => "modify") );
				
				$body = '
				<div style="position:relative;width:550px;margin:auto 50px auto 20px;">
					' .  $art_html['body'] . '
				</div>
				';
				
				$html = array(
					'title' => $title,
					'body' => $body
				);
				break;
				
			case "show_delete":
				
				$art = new Article( $_GET['article_id'] );
				$video_id = ( array_key_exists( "video_id", $_GET ) ) ? $_GET['video_id'] : 0;
				$art_html = $art->getHtml( "get_delete_form", array( 'active_article' => $art, 'section_title' => $_GET['section_title'], 'view_title' => $_GET['view_title'], 'action' => "delete", 'video_id' => $video_id ) );
				
				$html = array(
					'title' => 'Delete News Article',
					'body' => $art_html['body'] 
				);
				
				echo '
				<div class="admin_title_bar">
					' .  $html['title'] . '
				</div>
				' . $html['body'] . '
				
				';
				break;
				
			case "get_edit_form_feature":
				$a = new Article( $_GET['article_id'] );
				$vars = array(
					'active_article' => $a,
					'view_title' => "index",
					'section_title' => "feature-" . $_POST['feature_num']
				);
				
				$html = $a->getHtml( "get_edit_form_feature", $vars );
				echo $html['body']; 
				break;
				
			case "format_body":
				$a = new Article( $_GET['article_id'] );
				echo $a->m_common->formatText( $a->m_body );
				break;
				
			case "save_title":
				
				$a = new Article( $_GET['article_id'] );
				
				if( strlen( trim( $_POST['title'] ) ) > 0 )
				{
					$input = $a->getDataArray();
					$input['title'] = $_POST['title'];
					$a->modify( $input, FALSE );
					$a->setMemberVars( $a->m_article_id, FALSE );
					$title = $a->m_title;
				}
				else 
				{
					$title = $a->m_title;
				}
				
				echo $title;
				break;
				
			case "save_body":
				
				$a = new Article( $_GET['article_id'] );
				
				if( strlen( trim( $_POST['body'] ) ) > 0 )
				{
					$input = $a->getDataArray();
					$input['body'] = $_POST['body'];
					
					$a->modify( $input, FALSE );
					$a->setMemberVars( $a->m_article_id, FALSE );
				}
				break;
				
			case "format_body_for_text_box":
				$a = new Article( $_GET['article_id'] );
				echo $a->m_body;
				break;
				
			case "get_title":
				$a = new Article( $_GET['article_id'] );
				echo $a->m_title;
				break;
				
			case "update_file":
				$a = new Article( $_GET['article_id'] );
				$a->updateFile( $_POST['file_id'] );
				break;
		}
		break;
		
	case "file":
		
		$file = new File( 0 );
		
		switch( $process )
		{
			case "upload_file":
				
				foreach( $_FILES as $input_name => $file_info )
				{
					$file->doFileUpload( $_POST, $file_info );
				}
				break;
				
			case "validate":
				$return = "0";
				if( strlen($_POST['file_path_and_name'] ) > 0 )
				{
					//extract file name
					$file_split = explode( "\\\\", $_POST['file_path_and_name'] );
					$file_name = trim( $file_split[ count( $file_split ) - 1 ] );
					
					if( is_string( $file->checkDuplicateFile( $file_name ) ) )
					{
						$return = "That file name is already taken.";
					}
					
					if( $_POST['is_image'] == "1" )
					{
						if( $return == "0" )
						{
							$valid_extensions = array( "png", "jpg", "jpeg", "gif", "bmp" );
							$file_name_split =  explode( ".", $file_name );
							$ex = strtolower( trim( $file_name_split[ count( $file_name_split ) - 1 ] ) );
							
							if( !in_array( $ex, $valid_extensions) )
							{
								$return = "File must be an image.";
							}
						}
					}
				}
				else
				{
					$return = "You must select a file.";
				}
				
				echo $return;
				break;
				
			case "show_file_edit":
				$file = new File( $_GET['file_id'] );
				$file_html = $file->getHtml( "get_file_upload_form", $_GET );
				$lib_html = $file->getHtml( "get_image_library", $_GET );
				
				echo '
				<div class="colorbox_login_container">
					' . $file_html['body'] . ' 
					' . $lib_html['body'] . '
				</div>
				';
				break;
				
			case "check-dup-file-name":
				break;
		}
		break;
		
	case "env_var":
		
		switch( $process )
		{
			case "validate":
				//set vars
				$env_var = new EnvVar( 0 );
				$form_result = $env_var->checkInput( $_POST, $env_var->m_common->m_db->fixBoolean( $_GET['from_add'] ) );
				
				$result = ( !$form_result ) ? 1:0;
				$message =   ( !$form_result ) ? "Value Saved" : $form_result;
				
				echo $result . "^" . $message; 
				break;
				
			case "modify":
				$env_var = new EnvVar( $_GET['env_var_id'] );
				$env_var->modify( $_POST, FALSE );
				break;
				
			case "show_mod_form":
				$title = ( $_GET['env_var_title'] == "mail_to" ) ? $common->m_env . "_mail_to" : $_GET['env_var_title'];
				$env_var_id = $common->m_db->getIdFromTitle( $title, array( 'table' => "common_EnvVars", 'pk_name' => "env_var_id", 'title_field' => "title"  ) );
				
				$env_var = new EnvVar( $env_var_id );
				$html = $env_var->getHtml( "get_add_mod_form", array( 'active_env_var' => &$env_var, 'action' => "modify" ) );
				
				echo '
				<div class="colorbox_login_container">
					' . $html['body'] . '
				</div>
				'; 
				break;
		}
		break;
		
	case "mail":
		switch( $process )
		{
			case "validate":
				//set vars
				$email = new EmailMessage();
				$form_result = $email->validateEmailForm( $_POST );
				$result = ( !$form_result ) ? 1:0;
				$message =   ( !$form_result ) ? "Message Sent" : $form_result;
				
				echo $result . "^" . $message; 
				break;
				
			case "send":
				$email = new EmailMessage();
				$email->sendMail( $_POST );
				break;
		}
		break;
		
	case "contact":
		$c = new Contact( $_GET['contact_id'], TRUE );
		
		switch( $process )
		{
			case "validate":
				$form_result = $c->checkInput( $_POST, $c->m_common->m_db->fixBoolean( $_GET['from_add'] ) );
				
				$result = ( !$form_result ) ? 1:0;
				$message =   ( !$form_result ) ? "Contact saved." : $form_result;
				
				echo $result . "^" . $message;
				break;
				
			case "add":
				echo $c->add( $_POST );
				break;
				
			case "modify":
				echo $c->modify( $_POST, FALSE );
				break;
				
			case "delete":
				$c->delete( TRUE );
				break;
				
			case "show-add-mod":
				//setup vars
				$echo_content = TRUE;
				$action = ( $c->m_contact_id > 0 ) ? "modify" : "add";
				
				//compile params
				$details_vars = array( 'active_contact' => $c, 'action' => $action, 'authentication_id' => $auth->m_authentication_id );
				$step_vars = array( 'current_step' => 1, 'total_steps' => 3 );
				
				//grab html
				$step_meter_html = $c->getHtml( "get-step-meter", $step_vars );
				$step_nav_html = $c->getHtml( "get-step-nav", $step_vars );
				$details_form_html = $c->getHtml( "get-contact-details-form",  $details_vars );
				
				//compile body
				$body = '
				<div id="step-meter">
					' .  $step_meter_html['body'] . '
				</div>
				
				<div id="main-content" class="cc_main_content">
					' . $details_form_html['body'] . '
				</div>
				
				<div id="step-nav">
					' . $step_nav_html['body'] . '
				</div>
				
				<input type="hidden" id="current-step" value="' . $step_vars['current_step'] . '"/>
				<input type="hidden" id="total-steps" value="' . $step_vars['total_steps'] . '"/>
				
				<input type="hidden" id="active-contact-id" value="' . $c->m_contact_id . '"/>
				<input type="hidden" id="active-thumb-id" value="' . $c->m_objects_collection['thumb_file']->m_file_id . '"/>
				<input type="hidden" id="active-full-img-id" value="' . $c->m_objects_collection['full_img_file']->m_file_id . '"/>
				
				<input type="hidden" id="link-trigger-id" value="contact-step"/>
				<input type="hidden" id="step-is-complete" value="0"/>
				';
				
				$html = array(
					'title' => ucfirst( $action ) . ' Crew Member',
					'body' => $body
				);
				break;
				
			case "show-auth-set":
				
				$echo_content = TRUE;
				$auth = $c->m_objects_collection['authentication'];
				$action = ( $auth->m_authentication_id > 0 ) ? "modify" : "add"; 
				
				$auth_vars = array( 'active_contact' => $c, 'action' => $action, 'active_auth' => $auth );
				$html = $c->m_objects_collection['authentication']->getHtml( "auth-add-mod-form", $auth_vars );
				break;
				
			case "link_auth":  
				echo $c->addAuth( $_POST['authentication_id'] );
				break;
				
			case "show_crew_member":
				$echo_content = TRUE;
				$html = $c->getHtml( "show_crew_member", array( 'active_contact' => &$c ) );
				break;
				
			case "show-delete":
				$echo_content = TRUE;
				$html = $c->getHtml( "show-delete", array( 'active_contact' => $c ) ); 
				break;
		}
		break;
		
	case "contact_type":
		
		$ct = new ContactType( $_GET['contact_type_id'], TRUE );
		
		switch( $process )
		{
			case "validate":
				$form_result = $ct->checkInput( $_POST, $ct->m_common->m_db->fixBoolean( $_GET['from_add'] ) );
				
				$result = ( !$form_result ) ? 1:0;
				$message =   ( !$form_result ) ? "Job Title Saved." : $form_result;
				
				echo $result . "^" . $message;
				break;
				
			case "add":
				echo $ct->add( $_POST );
				break;
				
			case "modify":
				echo $ct->modify( $_POST, FALSE );
				break;
				
			case "delete":
				$ct->delete( TRUE );
				break;
			
			case "show-add":
				$ct_vars['active_ct'] = $ct;
				$html = $ct->getHtml( "show-add", $ct_vars );

				echo '
				<div class="admin_title_bar">
					' .  $html['title'] . '
				</div>
				' . $html['body'];
				break;
				
			case "show-mod":
				
				$ct_vars['active_ct'] = $ct;
				$html = $ct->getHtml( "show-mod", $ct_vars );
				
				echo $html['mod_form'] . "^" . $html['save_buttons'];
				break;	
				
			case "hide-mod":
				
				$ct_vars['active_ct'] = $ct;
				$html = $ct->getHtml( "hide-mod", $ct_vars );
				
				echo $html['mod_form'] . "^" . $html['save_buttons'];
				break;
				
			case "get-count":
				$records = $ct->getAllRecords( array() );
				echo ( !is_array( $records ) ) ? "0" : "1";
				break;
		}
		break;
		
	default:
		echo "Error: Task '" . $task . "' is invalid.";
		break;
}

//echo html for colorbox
if( $echo_content )
{
	echo '
	<div class="admin_title_bar">
		' .  $html['title'] . '
	</div>
	<br/>
	' . $html['body'] . '
	';
}