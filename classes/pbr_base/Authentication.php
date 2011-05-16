<?
/**
 * A class to handle the site authentication.
 * @since	20100911, Hafner
 */

require_once( "pbr_base/Common.php" );
require_once( "pbr_base/FormHandler.php" );
require_once( "pbr_base/Contact.php" );
require_once( "pbr_base/Session.php" );
require_once( "pbr_base/Contact.php" );

class Authentication
{
	/**
	 * Instance of the Common class.
	 * @var	Common
	 */
	protected $m_common;
	
	/**
	 * Instance of the FormHandler class.
	 * @var	Form
	 */
	protected $m_form;
	
	/**
	 * PK of the Authentication Record.
	 * @var	int
	 */
	protected $m_authentication_id;
	
	/**
	 * Id of the contact linked to this auth record.
	 * @var	int
	 */
	protected $m_contact_id;
	
	/**
	 * Email address.
	 * @var	string
	 */
	protected $m_username;
	
	/**
	 * Password for the user.
	 * @var	string
	 */
	protected $m_password;
	
	/**
	 * Active flag.
	 * @var	boolean
	 */
	protected $m_active;
	
	/**
	 * Array of linked objects.
	 * @var	array
	 */
	protected $m_linked_objects;
	
	/**
	 * Array of permissions aliases for this auth user.
	 * @var	array
	 */
	protected $m_permissions;
	
	/**
	 * Constructs the object.
	 * @since	20100618, hafner
	 * @return	State
	 * @param	int				$auth_id			id of the current user
	 */
	public function __construct( $auth_id, $objects = FALSE )
	{
		$this->m_common = new Common();
		$this->m_form = new FormHandler( 1 );
		$this->m_authentication_id = ( is_numeric( $auth_id ) ) ? $auth_id : 0;
		$this->setMemberVars( $objects );
		
	}//constructor
	
	/**
	 * Sets the member variables for this class.
	 * Returns TRUE, always.
	 * @since	20100618, hafner
	 * @return	boolean
	 */
	public function setMemberVars( $objects )
	{
		//get member vars
		$sql = "
		SELECT 
			a.authentication_id,
			a.username,
			a.password,
			a.active,
			c.contact_id
			
		FROM 
			common_Authentication a
			
		LEFT JOIN common_Contacts c ON
			c.authentication_id = a.authentication_id	
			
		WHERE 
			a.authentication_id = " . $this->m_authentication_id;
		
		$result = $this->m_common->m_db->query( $sql, __FILE__, __LINE__ );
		$row = ( $this->m_common->m_db->numRows( $result ) > 0 ) ? $this->m_common->m_db->fetchAssoc( $result ) : array();
		
		//set member vars
		$this->m_authentication_id = $row['authentication_id'];
		$this->m_contact_id = $row['contact_id'];
		$this->m_username = $row['username'];
		$this->m_password = $row['password'];
		$this->m_active = $this->m_common->m_db->fixBoolean( $row['active'] );
		$this->m_permissions = $this->getPermissions();
		$this->m_linked_objects = ( $objects ) ? $this->setLinkedObjects() : array(); 
		
		return TRUE;
		
	}//setMemberVars()
	
	/**
	* Get an array of data suitable to use in modify
	* @since 	20100618, hafner
	* @return 	array
	* @param 	boolean 		$fix_clob		whether or not to file member variables of CLOB type
	*/
	public function getDataArray( $fix_clob = TRUE ) 
	{
		return array(
			'authentication_id' => $this->m_authentication_id,
			'contact_id' => $this->m_contact_id,
			'username' => $this->m_username,
			'password' => $this->m_password,
			'active' => $this->m_active
		);
		
	}//getDataArray()
	
	/**
	* Save with the current values of the instance variables
	* This is a wrapper to modify() to ease some methods of coding
	* @since 	20100618, hafner
	* @return	mixed
	*/
	public function save()
	{
		$input = $this->getDataArray();
		return $this->modify( $input, FALSE );
	}//save()
	
	/**
	 * Adds a new record.
	 * Returns ( int ) Id of record if form data is valid, ( string ) form error otherwise.
	 * @since	20100618,hafner
	 * @return	mixed
	 * @param	array				$input				array of input data
	 */
	public function add( $input )
	{
		$this->checkInput( $input, TRUE );
		
		if( !$this->m_form->m_error )
		{
			//only set upload_timestamp on add
			$input['authentication_id'] = $this->m_common->m_db->insertBlank( 'common_Authentication', 'authentication_id' );
			$this->m_authentication_id = (int) $input['authentication_id'];
			$return = $this->m_authentication_id;
			$this->modify( $input, TRUE );
		}
		else
		{
			$return = $this->m_form->m_error;
		}
		
		return $return;
		
	}//add()
	
	/**
	 * Modifies a record.
	 * Returns ( int ) Id of record if form data is valid, ( string ) form error otherwise. 
	 * @since	20100618, hafner
	 * @return	mixed
	 * @param	array				$input				array of input data
	 * @param	boolean				$from_add			if we are adding a new record, from_add = TRUE, FALSE otherwise.
	 */
	public function modify( $input, $from_add )
	{
		if( !$from_add )
		{
			$this->checkInput( $input, FALSE );
		}

		if( !$this->m_form->m_error )
		{
			$sql = "
			UPDATE common_Authentication
			SET username = '" . $input['username'] . "',
				password = '" .  $input['password'] . "'
			WHERE authentication_id = " . $this->m_authentication_id;
			
			$this->m_common->m_db->query( $sql, __FILE__, __LINE__ );
			$return = $this->m_authentication_id;
			
			//update permissions
			$this->updatePermissions( $input, $from_add );
		}
		else
		{
			$return = $this->m_form->m_error;
		}
		
		return $return;
		
	}//modify()
	
	/**
	 * Modifies a record.
	 * Returns TRUE, always. 
	 * @since	20100618, hafner
	 * @return	mixed
	 * @param	array				$input				array of input data 
	 */
	public function delete( $deactivate = TRUE )
	{
		//setup vars
		$articles = $this->getArticles();
		
		if( $deactivate )
		{
			foreach( $articles as $i => $article_id )
			{
				$a = new Article( $article_id );
				$a->delete( TRUE );
			}
			
			$sql = "
			UPDATE common_Authentication
			SET active = 0
			WHERE authentication_id = " . $this->m_authentication_id;
			$this->m_common->m_db->query( $sql, __FILE__, __LINE__ );	
		}
		else
		{
			$sql = "
			DELETE
			FROM common_AuthenticationToPermission
			WHERE authentication_id = " . $this->m_authentication_id;
			$this->m_common->m_db->query( $sql, __FILE__, __LINE__ );
			
			foreach( $articles as $i => $article_id )
			{
				$a = new Article( $article_id );
				$a->delete( FALSE );
			}
			
			$sql = "
			DELETE
			FROM common_Authentication
			WHERE authentication_id = " . $this->m_authentication_id;
			$this->m_common->m_db->query( $sql, __FILE__, __LINE__ );
		}
		
		return TRUE;
		
	}//delete()
	
	public function getArticles()
	{
		$return = array();
		
		//grab articles
		$sql = "
		SELECT article_id
		FROM common_Articles
		WHERE authentication_id = " . $this->m_authentication_id;
		$result = $this->m_common->m_db->query( $sql, __FILE__, __LINE__ );
		
		while( $row = $this->m_common->m_db->fetchAssoc( $result ) )
		{
			$return[] = $row['article_id'];	
		}
		
		return $return;
		
	}//getArticles()
	
	public function updatePermissions( $input, $from_add )
	{
		if( !$from_add )
		{
			//delete all permissions for this user
			$sql = "
			DELETE
			FROM common_AuthenticationToPermission
			WHERE authentication_id = " . $this->m_authentication_id;
			$this->m_common->m_db->query( $sql, __FILE__, __LINE__ );
		}
			
		if( array_key_exists( "permissions", $input ) )
		{
			//add permissions
			foreach( $input['permissions'] as $i => $alias )
			{
				$sql = "
				INSERT INTO common_AuthenticationToPermission( authentication_id, permission_id )
				VALUES( " . $this->m_authentication_id . ", ( SELECT permission_id FROM common_Permissions WHERE LOWER( alias ) = '" . $alias . "'  ) )
				";
				
				$this->m_common->m_db->query( $sql, __FILE__, __LINE__ );
			}
		}
		
		return TRUE;
		
	}//updatePermissions()
	
	public function checkLoginForm( $input )
	{
		//check missing username
		if( !array_key_exists( "username", $input ) || strlen( trim( $input['username'] ) ) == 0 )
		{
			$this->m_form->m_error = "You must choose a username.";
		}
		
		//check missing password
		if( !$this->m_form->m_error )
		{
			if( !array_key_exists( "password", $input ) || strlen( trim( $input['password'] ) ) == 0 )
			{
				$this->m_form->m_error = "You must choose a password.";
			}
		}
		
		return $this->m_form->m_error;
		
	}//checkLoginForm()
	
	/**
	 * Validates the form input for creating/modifying a new File record.
	 * Returns FALSE on success, error message string otherwise.
	 * @since	20100618, hafner
	 * @return	mixed
	 * @param	array			$input			array of data
	 * @param	boolean			$is_addition	if we are adding a new record, is_addition = TRUE, FALSE otherwise.			 
	 */
	public function checkInput( $input, $is_addition )
	{
		//check missing username
		if( !$this->m_form->m_error )
		{
			if( !array_key_exists( "username", $input ) || strlen( trim( $input['username'] ) ) == 0 )
			{
				$this->m_form->m_error = "You must choose a username.";
			}
		}
		
		//check missing password
		if( !$this->m_form->m_error )
		{
			if( !array_key_exists( "password", $input ) || strlen( trim( $input['password'] ) ) == 0 )
			{
				$this->m_form->m_error = "You must choose a password.";
			}
		}
		
		//check valid email/username
		if( !$this->m_form->m_error )
		{
			$this->m_form->m_error = $this->m_common->validateEmailAddress( $input['username'] );
		}
			
		//check valid password
		if( !$this->m_form->m_error )
		{
			if( !$this->validatePassword( $password ) )
			{
				$this->m_form->m_error = "Password is invalid. It may not contain any of the following characters: semicolons (;), single quotes ('), double quotes (\"), or spaces.";
			}
		}
		
		//check duplicate username
		if( $is_addition )
		{
			if( !$this->m_form->m_error )
			{
				$dup_check = array( 
					'table_name' => "common_Authentication",
					'pk_name' => "authentication_id",
					'check_values' => array( 'username' => strtolower( $input['username'] ) )
				);
				
				if( is_numeric( $this->m_common->m_db->checkDuplicate( $dup_check ) ) )
				{
					$this->m_form->m_error = "That email already exists. You must choose a unique email address.";
				}
			}
		}
			
		return $this->m_form->m_error;
		
	}//checkInput()
	
	public function setLinkedObjects()
	{
		return array( 'contact' => new Contact( $this->m_contact_id, FALSE ) );
	}//setLinkedObjects()
	
	/**
	* Adds a permission to this auth record. 
	* @return	boolean
	* @since	20101018, hafner
	* @param	int			$permission_id		pk of common_Permissions
	*/
	public function addPermission( $permission_id )
	{
		$sql = "
		INSERT INTO common_AuthenticationToPermission( authentication_id, permission_id )
		VALUES( " . $this->m_authentication_id . ", " . $permission_id . " )";
		
		$this->m_common->m_db->query( $sql, __FILE__, __LINE__ );

		return TRUE;
		
	}//addPermission()
	
	/**
	* Returns HTML
	* @author	20100908, Hafner
	* @return	array
	* @param	string		$cmd		determines which HTML snippet to return
	* @param	array		$vars		array of variables for the html
	*/
	public function getHtml( $cmd, $vars = array() )
	{
		switch( strtolower( $cmd ) )
		{
			case "show_login_form":
				
				$divs = $this->m_common->getHtml( "full-div", array() );
				
				$return = array( 'body' => '
					<form id="auth_login_form">
						
						<div class="center header">
							Login to manage the site\'s content.
						</div>
						
						<div id="result" class="result"></div>
						
						<div class="center bottom_spacer">
							<input type="text" class="input text_input text_long normal_font input_clear" name="username" value="Username or Email" clear_if="Username or Email" />
						</div>
						
						<div class="center bottom_spacer">
							<input type="password" class="input text_input text_long normal_font input_clear" name="password" value="passwd" clear_if="passwd" />
						</div>
						
						<div class="center bottom_spacer">
							<a href="#" id="auth_login">
								<div class="button">
									Login
								</div>
							</a>
						</div>
						
					</form>
					'
				);
				break;
				
			case "get_access_restricted_message":
				$return = array(
					'body' =>
						'<div style="position:relative;margin-top:50px;text-align:center;color:#FF0000;font-weight:bold;line-height:1.8em;">
							You do not have access to this section <br/>
							Please contact your administrator.
						</div>
						'
				);
				break;
				
			case "login-string":
				
				$admin_link = $this->m_common->makeLink( array( 'v' => 'admin' ) );
				
				$body = '
				<div class="main_content_container login_string">
					<div>
						Hi, ' . ucwords( $this->m_username ) . '
						&nbsp;|&nbsp
						<a href="#" class="selected" id="colorbox_change_pass">Change Password</a>
						&nbsp;|&nbsp
						<a href="#" class="selected" id="kill_login">Logout</a>
					</div>
				</div>
				';
				$return = array( 'body' => $body );
				break;
				
			case "auth-add-mod-form":
				
				$adm_checked = ( is_array( $vars['active_auth']->m_permissions ) && in_array( 'ADM', $vars['active_auth']->m_permissions ) ) ? 'checked="checked"' : "";
				$mov_checked = ( is_array( $vars['active_auth']->m_permissions ) && in_array( 'MOV', $vars['active_auth']->m_permissions ) ) ? 'checked="checked"' : "";
				$action = ( $vars['active_auth']->m_authentication_id > 0 ) ? "modify" : "add";
				
				$body = '
				<div class="cc_main_content" style="text-align:center;height:230px;">
					
					<div class="result" id="result">
					</div>
				
					<div style="font-weight:bold;margin-bottom:10px;">
						To allow this user to login and manage the site\'s content, you must create a login.
					</div>
					
					<form id="auth_add_mod_form">
						<table cellspacing="10" style="margin:auto;">
							
							<tr>
								<td style="color:#FF0000;text-align:right;">
									Email Address:
								</td>
								<td>
									<input type="text" class="text_input" name="username" value="' . $vars['active_auth']->m_username . '" style="width:225px;" clear_if=""/>
								</td>
							</tr>
							
							<tr>
								<td style="color:#FF0000;text-align:right;">
									Password:
								</td>
								<td>
									<input type="password" class="text_input" name="password" value="' . $vars['active_auth']->m_password . '" style="width:225px;" clear_if=""/>
								</td>
							</tr>
							
							<tr>
								<td style="text-align:right;">
									<input type="checkbox" name="permissions[]" value="adm" ' . $adm_checked . '/>
								</td>
								<td style="color:#FF0000;text-align:left;">
									User can manage login permissions.
								</td>
							</tr>
							
							<tr>
								<td style="text-align:right;">
									<input type="checkbox" name="permissions[]" value="mov" ' . $mov_checked . '/>
								</td>
								<td style="color:#FF0000;text-align:left;">
									User can add new movies
								</td>
							</tr>
							
						</table>
						
					</form>
					
					<div>
						<img src="/images/btn_save.gif" id="authentication" action="' . $action . '" contact_id="' . $vars['active_contact']->m_contact_id . '" authentication_id="' . $vars['active_auth']->m_authentication_id . '"/>
					</div>							
					 	
				</div>
				';
				
				$return = array(
					'title' => "Add User Login",
					'body' => $body
				);
				break;
				
			case "show_password_form":
				$body = '
				<div class="center header">
					Change Password
				</div>
				
				<div id="result" class="result"></div>
				<form id="auth_password_form">
					<table class="bottom_spacer">
						<tr>
							<td class="right">
								Current Password:
							</td>
							<td>
								<input type="password" class="input text_input text_long normal_font form_input" name="cur_pass" value="" />
							</td>
						</tr>
						
						<tr>
							<td class="right">
								New Password:
							</td>
							<td>
								<input type="password" class="input text_input text_long normal_font form_input" name="new_pass" value="" />
							</td>
						</tr>
						
						<tr>
							<td class="right">
								Re-type New Password:
							</td>
							<td>
								<input type="password" class="input text_input text_long normal_font form_input" name="new_pass_copy" value="" />
							</td>
						</tr>
					</table>
				</form>
				
				<div class="center bottom_spacer">
					<a href="#" id="auth_change_pass">
						<div class="button">
							Save
						</div>
					</a>
				</div>
				';
				
				$return = array( 'body' => $body );
				break;
				
			default:
				throw new Exception( "Error: Command '" . $cmd . "' is invalid." );
				break;
		}
		
		return $return;
		
	}//getHtml()
	
	/**
	 * Viadates the auth login.
	 * Returns TRUE if login username/password is valid, FALSE otherwise.
	 * @since	20100912, Hafner
	 * @return	boolean
	 * @param	string		$username		username (email address)
	 * @param	string		$password		password
	 */
	public function validateLogin( $username, $password )
	{
		$return = FALSE;
		
		if( strlen( trim( $username ) ) > 0 &&
			strlen( trim( $password ) ) > 0 )
		{
			$sql = "
			SELECT authentication_id
			FROM common_Authentication
			WHERE ( LOWER( username ) = '" . strtolower( $username ) . "' OR LOWER( email ) = '" . strtolower( $username ) . "' ) AND 
			password = '" . $password . "' AND 
			active = 1";
			
			$result = $this->m_common->m_db->query( $sql, __FILE__, __LINE__ );
			
			if( $this->m_common->m_db->numRows( $result ) == 1 )
			{
				$return = TRUE;
			}
		}
		
		return $return;
		
	}//validateLogin()
	
	/**
	 * Validates a password string.
	 * Returns TRUE if password is valid, FALSE otherwise.
	 * @since	20100912, Hafner
	 * @return	boolean
	 * @param 	string 		$password		password string
	 */
	public function validatePassword( $password )
	{
		$return = TRUE;
		
		if( strpos( $password, "'" ) !== FALSE || 
			strpos( $password, '"' ) !== FALSE ||
			strpos( $password, " " ) !== FALSE ||
			strpos( $password, ";" ) !== FALSE )
		{
			$return = FALSE;
		}
		
		return $return;
		
	}//validatePassword()
	
	/**
	 * Determines if the current login is valid or if there is a current login. 
	 * Returns TRUE if there is a current login and it's valid, FALSE otherwise.
	 * @since	20100912, Hafner
	 * @return	boolean
	 */
	public function validateCurrentLogin()
	{
		$return = FALSE;
		
		if( array_key_exists( "sid", $_SESSION ) &&
			Session::validateSessionId( $_SESSION['sid'] ) )
		{
			$return = TRUE;
		}
		
		return $return;
		
	}//validateCurrentLogin()
	
	/**
	 * Controls the page access. 
	 * Returns HTML string.
	 * @since	20100912, Hafner
	 * @return	string
	 * @param 	object		$controller		instance of the current controller
	 */
	public function controlPageAccess( $controller )
	{
		$show_page_content = TRUE;
		
		if( $controller->getAuthStatus() )
		{
			if( !$this->validateCurrentLogin() )	
			{
				$show_page_content = FALSE;
			}
		}
		
		if( $show_page_content )
		{
			//if we have a current login, set the auth object.
			if( $this->validateCurrentLogin() )
			{
				$auth_id = self::getAuthId();
				$controller->setAuth( $auth_id );
			}
			
			$controller->setContent();
			$return = $controller->getContent();
		}
		else
		{
			$html = $this->getHtml( "show_login_form", array() );
			$return = $html['body'];
		}
		
		return $return;
		
	}//controlPageAccess()
	
   /**
	* Gets a string message if login is invalid.
	* Returns FALSE if login is valid, string error message otherwise.
	* @author	Version 20100912, Hafner
	* @return	mixed
	* @param	string		$username		username
	* @param	string		$password		password
	*/
	public function getLoginMessage( $username, $password )
	{
		$return = FALSE;
		
		if( !$this->validateLogin( $username, $password ) )
		{
			$return = "Login invalid. Please try again.";
		}
		
		return $return;
		
	}//getLoginMessage()
	
	/**
	 * Collects array of permissions for this user.
	 * Returns array of permission aliases.
	 * @return	array
	 * @since	20101020, hafner
	 */
	public function getPermissions()
	{
		$return = FALSE;
		//$auth_id = ( ( $this->m_authentication_id ) > 0 ) ? $this->m_authentication_id : 0;
		
		$sql = "
		SELECT 
			p.alias AS alias
		FROM 
			common_AuthenticationToPermission a2p
		JOIN common_Permissions p ON
			p.permission_id = a2p.permission_id  
		WHERE 
			a2p.authentication_id = " . $this->m_authentication_id;
		
		$result = $this->m_common->m_db->query( $sql, __FILE__, __LINE__ );
		
		if( $this->m_common->m_db->numRows( $result ) > 0 )
		{
			$return = array();
			while( $row = $this->m_common->m_db->fetchAssoc( $result ) )
			{
				$return[] = $row['alias'];
			}
		}
		
		return $return;
		
	}//getPermissions()
	
	/**
	 * Validates the current session.
	 * Returns authentication_id ( int ) if session is valid, FALSE otherwise.
	 * @since	20100922, Hafner
	 * @return 	mixed
	 */
	public static function getAuthId()
	{
		$return = FALSE;
		$common = new Common();
		
		//get auth id
		$sql = "
		SELECT authentication_id
		FROM common_Sessions
		WHERE session_id = '" . $_SESSION['sid'] . "' AND
		end_timestamp IS NULL";
		
		$result = $common->m_db->query( $sql, __FILE__, __LINE__ );
		
		if( $common->m_db->numRows( $result ) > 0 )
		{
			$row = $common->m_db->fetchRow( $result );
			$return = $row[0];
		}
		
		return $return;
		
	}//getAuthId()
	
	public function validatePasswordChange( $post )
	{
		$return = FALSE;
		
		if( strlen( $post['cur_pass'] ) == 0 || 
			strlen( $post['new_pass'] ) == 0 ||
			strlen( $post['new_pass_copy'] ) == 0 )
		{
			$return = "You must fill in all fields.";	
		}
		
		if( $return === FALSE )
		{
			if( $post['cur_pass'] != $this->m_password )
			{
				$return = "Invalid current password.";	
			}
		}
		
		if( $return === FALSE )
		{
			if( $post['new_pass'] != $post['new_pass_copy'] )
			{
				$return = "New passwords do not match";
			}
		}
		
		if( $return === FALSE )
		{
			if( strlen( $post['new_pass'] ) < 7 )
			{
				$return = "New password must be at least 7 characters.";
			}
		}
		
		if( $return === FALSE )
		{
			if( strpos( $post['new_pass'], " " ) !== FALSE )
			{
				$return = "New password cannot contain spaces.";
			}
		}
		
		return $return;
		
	}//validatePasswordChange()
	
	public function updatePassword( $new_pass )
	{
		$sql = "
		UPDATE common_Authentication 
		SET password = '" . $new_pass . "'
		WHERE authentication_id = " . $this->m_authentication_id;
		
		$this->m_common->m_db->query( $sql, __FILE__, __LINE__ );
		
		return TRUE;
	}//updatePassword()
	
   /**
	* Get a member variable's value
	* @author	Version 20100618, hafner
	* @return	mixed
	* @param	string		$var_name		Variable name to get
	*/
	public function __get( $var_name )
	{
		$exclusions = array();

		if( !in_array( $var_name, $exclusions ) )
		{
			return $this->$var_name;
		}
		else
		{
			throw new exception( "Error: Access to member variable '" . $var_name . "' for class '" . get_class( $this ) . "' is denied" );
		}
	}//__get()
	
	/**
	* Set a member variable's value
	* @since	20100618, hafner
	* @return	mixed
	* @param	string		$var_name		Variable name to set
	* @param	string		$var_value		Value to set
	*/
	public function __set( $var_name, $var_value )
	{
		$exclusions = array( 'm_article_id' );

		if( !in_array( $var_name, $exclusions ) )
		{
			$this->$var_name = $var_value;
			return TRUE;
		}
		else
		{
			throw new exception( "Error: Access to member variable '" . $var_name . "' for class '" . get_class( $this ) . "' is denied" );
		}
	}//__set()
	
}//class View
?>