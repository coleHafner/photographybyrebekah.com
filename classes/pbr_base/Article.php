<?
/**
 * A class to handle a File record.
 * @since	20100618, hafner
 */

require_once( "pbr_base/Common.php" );
require_once( "pbr_base/FormHandler.php" );

class Article
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
	 * PK of the File Record.
	 * @var	int
	 */
	protected $m_article_id;
	
	/**
	 * Id of the person who wrote this article.
	 * @var	int
	 */
	protected $m_authentication_id;
	
	/**
	 * Collection of file ids related to this article.
	 * @var	array
	 */
	protected $m_file_ids;
	
	/**
	 * Tile of the record.
	 * @var	string
	 */
	protected $m_title;
	
	/**
	 * Body of the record.
	 * @var	string
	 */
	protected $m_body;
	
	/**
	 * Post timestamp of the record.
	 * @var	string
	 */
	protected $m_post_timestamp;
	
	/**
	 * Timestamp Raw.
	 * @var	int
	 */
	protected $m_post_timestamp_raw;
	
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
	 * Constructs the object.
	 * @since	20100618, hafner
	 * @return	State
	 * @param	int				$article_id			id of the current record
	 */
	public function __construct( $article_id, $objects = FALSE )
	{
		$this->m_common = new Common();
		$this->m_form = new FormHandler( 1 );
		$this->setMemberVars( $article_id, $objects );
	}//constructor
	
	/**
	 * Sets the member variables for this class.
	 * Returns TRUE, always.
	 * @since	20100618, hafner
	 * @return	boolean
	 */
	public function setMemberVars( $article_id, $objects )
	{
		$chosen_id = ( $article_id > 0 ) ? $article_id : 0;
		
		//get member vars
		$sql = "
		SELECT 
			article_id,
			authentication_id,
			title,
			body,
			post_timestamp,
			active
		FROM 
			common_Articles
		WHERE 
			article_id = " . $chosen_id;
		
		$result = $this->m_common->m_db->query( $sql, __FILE__, __LINE__ );
		$row = ( $this->m_common->m_db->numRows( $result ) > 0 ) ? $this->m_common->m_db->fetchAssoc( $result ) : array();
		
		//set member vars
		$this->m_article_id = $row['article_id'];
		$this->m_authentication_id = $row['authentication_id'];
		$this->m_file_ids = $this->getFiles();
		$this->m_title = stripslashes( $row['title'] );
		$this->m_body = stripslashes( $row['body'] );
		$this->m_post_timestamp =  ( $this->m_article_id > 0 ) ? $this->m_common->convertTimestamp( $row['post_timestamp'], TRUE ) : "";
		$this->m_post_timestamp_diff = $row['post_timestamp'];
		$this->m_active = $this->m_common->m_db->fixBoolean( $row['active'] );
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
			'article_id' => $this->m_article_id,
			'authentication_id' => $this->m_authentication_id,
			'title' => $this->m_title,
			'body' => $this->m_body,
			'post_timestamp' => $this->m_post_timestamp,
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
			$req_fields = array( 'post_timestamp' => strtotime( date( "Y-m-d h:i:s" ) ), 'authentication_id' => 0 );
			$input['article_id'] = $this->m_common->m_db->insertBlank( 'common_Articles', 'article_id', $req_fields );
			
			$this->m_article_id = $input['article_id'];
			$return = $this->m_article_id;
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
			UPDATE 
				common_Articles
			SET 
				title = '" . $this->m_common->m_db->escapeString( $input['title'] ) . "',
				body = '" .  $this->m_common->m_db->escapeString( $input['body'] ) . "',
				authentication_id = " . $input['authentication_id'] . "
			WHERE 
				article_id = " . $this->m_article_id;
			$this->m_common->m_db->query( $sql, __FILE__, __LINE__ );
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
		if( $deactivate )
		{
			$sql = "
			UPDATE common_Articles
			SET active = 0
			WHERE article_id = " . $this->m_article_id;
			$this->m_common->m_db->query( $sql, __FILE__, __LINE__ );
		}
		else
		{
			$sql = "
			DELETE
			FROM common_ArticleToSection
			WHERE article_to_view_id IN ( 
				SELECT article_to_view_id
				FROM common_ArticleToView
				WHERE article_id = " . $this->m_article_id . "
			)";
			$this->m_common->m_db->query( $sql, __FILE__, __LINE__ );
			
			$sql = "
			DELETE
			FROM common_ArticleToView
			WHERE article_id = " . $this->m_article_id;
			$this->m_common->m_db->query( $sql, __FILE__, __LINE__ );
			
			$sql = "
			DELETE
			FROM common_Articles
			WHERE article_id = " . $this->m_article_id;
			$this->m_common->m_db->query( $sql, __FILE__, __LINE__ );	
		}
		
		return TRUE;
		
	}//delete()
	
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
		//check missing title
		if( !array_key_exists( "title", $input ) || 
			strlen( trim( $input['title'] ) ) == 0 )
		{
			$this->m_form->m_error = "You must select a title.";
		}

		//check duplicate title
		if( $is_addition )
		{
			if( !$this->m_form->m_error )
			{
				$dup_check = array( 
					'table_name' => "common_Articles",
					'pk_name' => "article_id",
					'check_values' => array( 'title' => strtolower( $input['title'] ) )
				);
				
				if( is_numeric( $this->m_common->m_db->checkDuplicate( $dup_check ) ) )
				{
					$this->m_form->m_error = "That Title already exists";
				}
			}
			
		}//check duplicate title
		
		//check missing body
		if( !$this->m_form->m_error )
		{
			if( !array_key_exists( "body", $input ) || strlen( trim( $input['body'] ) ) == 0 )
			{
				$this->m_form->m_error = "You must fill in the body.";
			}
		}
		
		//check existing auth_id
		if( !$this->m_form->m_error )
		{
			if( !array_key_exists( 'authentication_id', $input ) || 
				!is_numeric( $input['authentication_id'] ) )
			{
				$this->m_form->m_error = "You must provide an authentication id.";
			}
		}
		
		//check valid auth_id
		if( !$this->m_form->m_error )
		{
			$vars = array( 'table_name' => "common_Authentication", 'check_values' => array( 'authentication_id' => $input['authentication_id'] ) );
			$error = $this->m_form->checkKeyExists( TRUE, $vars );

			if( is_string( $error ) )
			{
				$this->m_form->m_error = $error;
			}
		}
		
		return $this->m_form->m_error;
		
	}//checkInput()
	
	public function setLinkedObjects()
	{
		$a = new Authentication( $this->m_authentication_id );
		return array( 'authentication' => $a );
	}//setLinkedObjects()
	
	/**
	 * Adds a view to this article.
	 * Returns article_to_view id.
	 * @since	20100718, hafner
	 * @return	int
	 * @param	int				$view_id			id of the view record
	 */
	public function addView( $view_id )
	{
		$sql = "
		SELECT article_id
		FROM common_ArticleToView
		WHERE article_id = " . $this->m_article_id . " AND
		view_id = " . $view_id;
		$result = $this->m_common->m_db->query( $sql, __FILE__, __LINE__ );
		
		if( $this->m_common->m_db->numRows( $result ) == 0 )
		{
			//validate view id
			$vars = array( 'table_name' => "common_Views", 'check_values' => array( 'view_id' => $view_id ) );
			$view_id_valid = $this->m_form->checkKeyExists( FALSE, $vars );
			
			if( is_string( $view_id_valid ) )
			{
				throw new exception( "Error: View ID '" . $view_id . "' is invalid. FormHandler said '" . $view_id_valid . "'" );
			}
			
			$sql = "
			INSERT INTO common_ArticleToView( article_id, view_id )
			VALUES( " . $this->m_article_id . ", " . $view_id . " )";
			$this->m_common->m_db->query( $sql, __FILE__, __LINE__ );
			
			//get id
			$sql = "
			SELECT article_to_view_id
			FROM common_ArticleToView
			ORDER BY article_to_view_id DESC
			LIMIT 1";
			$result = $this->m_common->m_db->query( $sql, __FILE__, __LINE__ );
			$row = $this->m_common->m_db->fetchRow( $result );
		}
		else
		{
			$row = $this->m_common->m_db->fetchRow( $result );
		}
		
		return $row[0];
		
	}//addView()
	
	/**
	 * Adds a section to this article.
	 * @since	20100718, hafner
	 * @return	boolean
	 * @param	int				$article_to_view_id			id of the article to view relationship
	 * @param	int				$section_id					id of the section
	 */
	public function addSection( $article_to_view_id, $section_id )
	{
		//validate article_to_view id
		$vars = array( 'table_name' => "common_ArticleToView", 'check_values' => array( 'article_to_view_id' => $article_to_view_id ) );
		$a2v_id_valid = $this->m_form->checkKeyExists( FALSE, $vars );
		
		if( is_string( $a2v_valid ) )
		{
			throw new exception( "Error: Article To View ID '" . $article_to_view_id . "' is invalid. FormHandler said '" . $a2v_id_valid . "'" );
		}
		
		//validate view id
		$vars = array( 'table_name' => "common_Sections", 'check_values' => array( 'section_id' => $section_id ) );
		$section_id_valid = $this->m_form->checkKeyExists( FALSE, $vars );
		
		if( is_string( $section_id_valid ) )
		{
			throw new exception( "Error: Section ID '" . $section_id . "' is invalid. FormHandler said '" . $section_id_valid . "'" );
		}
		
		$sql = "
		INSERT INTO common_ArticleToSection( article_to_view_id, section_id )
		VALUES( " . $article_to_view_id . ", " . $section_id . " )";
		
		$this->m_common->m_db->query( $sql, __FILE__, __LINE__ );
		
		return TRUE;
	}//addSection()
	
	/**
	 * Gets an article based on the view title and the section title.
	 * Returns Article Object on success, FALSE otherwise.
	 * @since	20100728, hafner
	 * @return	Mixed
	 * @param	string				$article_title			id of the article to view relationship
	 * @param	string				$section_title			id of the section
	 */
	public function getArticle( $view_title, $section_title, $use_alias = FALSE )
	{
		$return = FALSE;
		$view_field = ( $use_alias ) ? "alias" : "controller_name";
		$view_id = $this->m_common->m_db->getIdFromTitle( $view_title, array(  'pk_name' => "view_id", 'table' => "common_Views", 'title_field' => $view_field ) );
		$section_id = $this->m_common->m_db->getIdFromTitle( $section_title, array(  'pk_name' => "section_id", 'table' => "common_Sections", 'title_field' => "title" ) );
		
		if( $view_id > 0 && $section_id > 0 )
		{
			$sql = "
			SELECT 
				a.article_id,
				a.post_timestamp
			FROM 
				common_Articles a
			JOIN common_ArticleToView a2v ON 
				a2v.article_id = a.article_id AND 
				a2v.view_id = " . $view_id . "
			JOIN common_ArticleToSection a2s ON
				a2s.article_to_view_id = a2v.article_to_view_id AND
				a2s.section_id = " . $section_id . " 
			WHERE
				a.active = 1
			GROUP BY
				a.article_id,
				a.post_timestamp
			ORDER BY 
				a.post_timestamp DESC";
			
			$result = $this->m_common->m_db->query( $sql, __FILE__, __LINE__ );
			
			while( $row = $this->m_common->m_db->fetchRow( $result ) )
			{
				$return[] = new Article( $row[0], TRUE ); 	
			}
			
		}
		
		return $return;
		
	}//getArticle()
	
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
			case "get_edit_form":
				
				$view_id = 0;
				$section_id = 0;
				$title_type = "text";
				$title_label = "Title:";
				$trigger = ' id="alter_article" ';
				
				if( array_key_exists( "section_title", $vars ) &&
					strlen( $vars['section_title'] ) > 0 )
				{
					$table_info = array( 
						'pk_name' => "section_id",
						'table' => "common_Sections",
						'title_field' => "title" 
					);
					$section_id = $this->m_common->m_db->getIdFromTitle( $vars['section_title'], $table_info );
				}
				
				if( array_key_exists( "view_title", $vars ) &&
					strlen( $vars['view_title'] ) > 0 )
				{
					$title_field = ( array_key_exists( "use_view_alias", $vars ) ) ? "alias" : "controller_name";
					
					$table_info = array( 
						'pk_name' => "view_id",
						'table' => "common_Views",
						'title_field' => $title_field 
					);
					$view_id = $this->m_common->m_db->getIdFromTitle( $vars['view_title'], $table_info );
				}
				
				if( array_key_exists( "show_title", $vars ) &&
					!$vars['show_title'] )
				{
					$title_type = "hidden";
					$title_label = "";
				}
				
				//check for alternate trigger
				if( array_key_exists( "alternate_trigger", $vars ) && 
					strlen( $vars['alternate_trigger'] ) > 0 )
				{
					switch( strtolower( $vars['alternate_trigger'] ) )
					{
						case "movie_review":
							$trigger = ' id="' . $vars['alternate_trigger'] . '" video_id="' . $vars['video_id'] . '" watch_id="' . $vars['watch_id'] . '"';
							break;
					}
				}
				
				//get auth id
				$auth_id = ( $vars['active_article']->m_article_id > 0 ) ? $vars['active_article']->m_authentication_id : $vars['authentication_id'];
				
				$body = '
				<form id="article_form">
					<table class="contact_table">
						<tr>
							<td>
								&nbsp;
							</td>
							<td colspan="4" id="result" class="result">
							
							</td>
						</tr>
						<tr>
							<td align="right" style="color:#FF0000;">
								' . $title_label . '
							</td>
							<td>
								<input type="' . $title_type . '" name="title" id="title" value="' . $vars['active_article']->m_title  . '" style="width:490px;" class="text_input">
							</td>
						</tr>
						<tr>
							<td>
								<br/>
							</td>
						</tr>
						<tr>
							<td align="right" valign="top" style="color:#FF0000;">
								Body: 
							</td>
							<td colspan="4">
								<textarea name="body" id="body" class="text_input" style="height:200px;width:490px;" clear_if="">' . $vars['active_article']->m_body .'</textarea>
							</td>
						</tr>
						<tr>
							<td>
								&nbsp;
							</td>
							<td align="center">
								<br/>
								<a href="#"' . $trigger . 'action="' . $vars['action'] . '" article_id="' . $vars['active_article']->m_article_id . '" section_id="' . $section_id . '" view_id="' . $view_id . '">
									<img src="/images/btn_save.gif"/>
								</a>
							</td>
						</tr>
					</table>
					
					<input type="hidden" name="authentication_id" value="' . $auth_id . '"/>
					<input type="hidden" name="section_id" value="' . $section_id . '"/>
					<input type="hidden" name="view_id" value="' . $view_id . '"/>
					
				</form>
				';
				
				$return = array(
					'title' => '',
					'body' => $body
				);
				break;
				
			case "get_delete_form":
				$return = array(
					'title' => '',
					'body' => '
						<div class="delete_container">
							Really Delete Article "' . $vars['active_article']->m_title . '"?
							<p style="text-align:center;margin:0px;padding:0px;margin-top:20px;">
								<a href="#" id="alter_article" action="delete" article_id="' . $vars['active_article']->m_article_id . '" video_id="' . $vars['video_id'] . '">
									<img src="/images/btn_delete.gif"/>
								</a>
								&nbsp;
								<a href="#" id="close_colorbox">
									<img src="/images/btn_cancel.gif"/>
								</a>
								
							</p>
						</div>'
				);
				break;
				
			case "article-bubble":
				
				$admin_vars = "";
				$rating = "";
				$a = $vars['active_article'];
				
				//get rating
				if( array_key_exists( "rating", $vars ) )
				{
					$rating_html = $this->m_common->getHtml( "rating-html", array( 'rating' => $vars['rating'], 'style' => "stars" ) );
					$rating = $rating_html['body'];
				}
				
				//get contact
				$sql = "
				SELECT contact_id
				FROM common_Contacts
				WHERE authentication_id = " . $a->m_authentication_id;
				
				$result = $this->m_common->m_db->query( $sql, __FILE__, __LINE__ );
				$row = $this->m_common->m_db->fetchRow( $result );
				$c = new Contact( $row[0], TRUE );
				
				//display admin vars
				if( array_key_exists( "auth", $vars ) &&
					is_object( $vars['auth'] ) &&
					$vars['auth']->m_authentication_id > 0 )
				{
					if( $vars['auth']->m_authentication_id == $a->m_authentication_id ||
						in_array( "ADM", $vars['auth']->m_permissions ) )
					{
						$mod_link = '<a href="#" id="alter_article" action="show_modify" article_id="' . $a->m_article_id . '" >';
						$delete_link = '<a href="#" id="alter_article" action="show_delete" article_id="' . $a->m_article_id . '" ' . $video_id . '>';
						
						if( array_key_exists( "video_id", $vars ) )
						{
							$mod_link = '<a href="#" id="movie_review" action="show-mod-review" article_id="' . $a->m_article_id . '" video_id="' . $vars['video_id'] . '" watch_id="null" >';
							$delete_link = '<a href="#" id="alter_article" action="show_delete" article_id="' . $a->m_article_id . '" video_id="' . $vars['video_id'] . '" watch_id="null">';
						}
						
						$admin_vars = '
						' . $mod_link . '
							Edit
						</a>
						&nbsp;|&nbsp;
						' . $delete_link . '
							Delete
						</a>
						&nbsp;|&nbsp;
						';
					}
				}
				
				$return = array( 'body' => '
				<div class="news_feed_bubble" ' . $vars['extra-style'] . '>
						
					<div style="color:#FF0000;">
						<table style="width:100%;">
							<tr>
								<td style="width:100px;text-align:center;">
									<img style="width:75px;" src="' . $c->m_objects_collection['thumb_file']->m_relative_path . '/' . $c->m_objects_collection['thumb_file']->m_file_name . '"/>
								</td>
								<td style="vertical-align:top;">
									<span style="font-weight:bold;color:#FFF;display:block;">
										' . $a->m_title . '
									</span>
									' . $rating .'
									' . $this->m_common->formatText( $a->m_body ) . '
					 			</td>
					 		</tr>
					 	</table>
					</div>
					
					<div class="tiny_red_text right_align" style="color:#FFF;">
						 ' . $admin_vars . ' Posted ' . $a->m_post_timestamp . '
					</div>
					
				</div>'
				);
				break;
				
			case "get_edit_form_feature":
				
				$view_id = 0;
				$section_id = 0;
				
				if( array_key_exists( "section_title", $vars ) &&
					strlen( $vars['section_title'] ) > 0 )
				{
					$table_info = array( 
						'pk_name' => "section_id",
						'table' => "common_Sections",
						'title_field' => "title" 
					);
					$section_id = $this->m_common->m_db->getIdFromTitle( $vars['section_title'], $table_info );
				}
				
				if( array_key_exists( "view_title", $vars ) &&
					strlen( $vars['view_title'] ) > 0 )
				{
					$title_field = ( array_key_exists( "use_view_alias", $vars ) ) ? "alias" : "controller_name";
					
					$table_info = array( 
						'pk_name' => "view_id",
						'table' => "common_Views",
						'title_field' => $title_field 
					);
					$view_id = $this->m_common->m_db->getIdFromTitle( $vars['view_title'], $table_info );
				}
				
				//get auth id
				$auth_id = ( $vars['active_article']->m_article_id > 0 ) ? $vars['active_article']->m_authentication_id : $vars['authentication_id'];
				
				//vars
				$title_data = ( $vars['active_article']->m_article_id > 0 ) ? $vars['active_article']->m_title : "Title";
				$body_data = ( $vars['active_article']->m_article_id > 0 ) ? $vars['active_article']->m_body : "Feature Summary";
				
				$body = '
				<form id="article_form">
					<table class="contact_table">
						<tr>
							<td colspan="4" id="result" class="result">
							
							</td>
						</tr>
						<tr>
							<td>
								<input type="text" name="title" id="title" value="' . $title_data  . '" style="width:200px;" class="text_input" clear_if="Title">
							</td>
						</tr>
						<tr>
							<td>
								<br/>
							</td>
						</tr>
						<tr>
							<td colspan="4">
								<textarea name="body" id="body" class="text_input" style="height:100px;width:200px;" clear_if="Feature Summary">' . $body_data . '</textarea>
							</td>
						</tr>
						<tr>
							<td style="text-align:center;">
								<br/>
								<a href="#" id="alter_article" action="modify" article_id="' . $vars['active_article']->m_article_id . '" section_id="' . $section_id . '" view_id="' . $view_id . '">
									<img src="/images/btn_save.gif"/>
								</a>
							</td>
						</tr>
					</table>
					
					<input type="hidden" name="authentication_id" value="' . $auth_id . '"/>
					<input type="hidden" name="section_id" value="' . $section_id . '"/>
					<input type="hidden" name="view_id" value="' . $view_id . '"/>
					
				</form>
				';
				
				$return = array(
					'title' => '',
					'body' => $body
				);
				break;
				
			default:
				throw new Exception( "Error: Command '" . $cmd . "' is invalid." );
				break;
		}
		
		return $return;
		
	}//getHtml()
	
	public function getFiles()
	{
		$return = array();
		
		$sql = "
		SELECT file_id
		FROM common_ArticleToFile
		WHERE article_id = " . $this->m_article_id;
		
		$result = $this->m_common->m_db->query( $sql, __FILE__, __LINE__ );
		while( $row = $this->m_common->m_db->fetchRow( $result ) )
		{
			$return[] = $row[0];
		}
		
		return $return;
		
	}//getFiles()
	
	public function updateFile( $file_id )
	{
		$sql = "
		UPDATE common_ArticleToFile
		SET file_id = " . $file_id . "
		WHERE article_id = " . $this->m_article_id;
		
		$this->m_common->m_db->query( $sql, __FILE__, __LINE__ );
		
		return TRUE;
		
	}//updateFile()
	
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