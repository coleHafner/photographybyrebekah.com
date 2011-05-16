<?
/**
 * A class to handle a File record.
 * @since	20100618, hafner
 */

require_once( "pbr_base/Common.php" );
require_once( "pbr_base/FormHandler.php" );
require_once( "pbr_base/File.php" );

class View
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
	protected $m_view_id;
	
	/**
	 * ID of the parent view of the current view.
	 * @var	int
	 */
	protected $m_parent_view_id;
	
	/**
	 * Array of Sub View Ids.
	 * @var	array
	 */
	protected $m_sub_view_ids;
	
	/**
	 * Id of the file_type related to this record.
	 * @var	int
	 */
	protected $m_controller_name;
	
	/**
	 * Id of the image for the nav.
	 * @references	common_Files( file_id )
	 * @var	int
	 */
	protected $m_nav_image_id;
	
	/**
	 * Whether or not to show this view in the master nav.
	 * @var	boolean
	 */
	protected $m_show_in_nav;
	
	/**
	 * Alias of this view.
	 * @var	string
	 */
	protected $m_alias;
	
	/**
	 * External link.
	 * @var	string
	 */
	protected $m_external_link;
	
	/**
	 * Priority of this view in the master nav.
	 * @var	int
	 */
	protected $m_nav_priority;
	
	/**
	 * Whether or not this view need to be authenticated.
	 * @var	boolean
	 */
	protected $m_requires_auth;
	
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
	 * @param	int				$view_id			id of the current record
	 */
	public function __construct( $view_id, $objects = FALSE )
	{
		$this->m_common = new Common();
		$this->m_form = new FormHandler( 1 );
		$this->m_view_id = ( is_numeric( $view_id ) ) ? $view_id : 0; 
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
			view_id,
			parent_view_id,
			controller_name,
			alias,
			external_link,
			nav_image_id,
			show_in_nav,
			requires_auth,
			nav_priority,
			active
		FROM 
			common_Views
		WHERE 
			view_id = " . $this->m_view_id;
		
		$result = $this->m_common->m_db->query( $sql, __FILE__, __LINE__ );
		$row = ( $this->m_common->m_db->numRows( $result ) > 0 ) ? $this->m_common->m_db->fetchAssoc( $result ) : array();
		$row = array_change_key_case( $row, CASE_LOWER );
		
		//set member vars
		$this->m_view_id = $row['view_id'];
		$this->m_parent_view_id = $row['parent_view_id'];
		$this->m_controller_name = stripslashes( $row['controller_name'] );
		$this->m_alias = stripslashes( $row['alias'] );
		$this->m_external_link = strtolower( $row['external_link'] );
		$this->m_nav_priority = ( !is_null( $row['nav_priority'] ) ) ? $row['nav_priority'] : 0;
		$this->m_nav_image_id = ( !is_null( $row['nav_image_id'] ) ) ? $row['nav_image_id'] : 0;
		$this->m_show_in_nav = $this->m_common->m_db->fixBoolean( $row['show_in_nav'] );
		$this->m_requires_auth = $this->m_common->m_db->fixBoolean( $row['requires_auth'] );
		$this->m_active = $this->m_common->m_db->fixBoolean( $row['active'] );
		$this->m_sub_view_ids = $this->setSubViewIds();
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
			'view_id' => $this->m_view_id,
			'parent_view_id' => $this->m_parent_view_id,
			'controller_name' => $this->m_controller_name,
			'alias' => $this->m_alias,
			'external_link' => $this->m_external_link,
			'nav_priority' => $this->m_nav_priority,
			'nav_image_id' => $this->m_nav_image_id,
			'show_in_nav' => $this->m_show_in_nav,
			'requires_auth' => $this->m_requires_auth,
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
			$req_fields = array( 'parent_view_id' => 0 );
			$input['view_id'] = $this->m_common->m_db->insertBlank( 'common_Views', 'view_id', $req_fields );
			$this->m_view_id = (int) $input['view_id'];
			$return = $this->m_view_id;
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
				common_Views
			SET 
				controller_name = '" . $this->m_common->m_db->escapeString( $input['controller_name'] ) . "',
				alias = '" . $this->m_common->m_db->escapeString( $input['alias'] ) . "',
				nav_priority = " . $input['nav_priority'] . ",
				show_in_nav = " . $input['show_in_nav'] . ",
				requires_auth = " . $input['requires_auth'] . "
			WHERE 
				view_id = " . $this->m_view_id;
				
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
			UPDATE common_Views
			SET active = 0
			WHERE view_id = " . $this->m_view_id;
			$this->m_common->m_db->query( $sql, __FILE__, __LINE__ );
		}
		else
		{
			$sql = "
			DELETE
			FROM common_ArticleToSection
			WHERE article_to_view_id IN ( 
				SELECT view_id
				FROM common_ArticleToView
				WHERE view_id = " . $this->m_view_id . "
			)";
			$this->m_common->m_db->query( $sql, __FILE__, __LINE__ );
			
			$sql = "
			DELETE
			FROM common_ArticleToView
			WHERE view_id = " . $this->m_view_id;
			$this->m_common->m_db->query( $sql, __FILE__, __LINE__ );
			
			$sql = "
			DELETE
			FROM common_Views
			WHERE view_id = " . $this->m_view_id;
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
		if( !array_key_exists( "controller_name", $input ) || strlen( trim( $input['controller_name'] ) ) == 0 )
		{
			$this->m_form->m_error = "You must select a controller name.";
		} 
		
		//check duplicate title
		if( !$this->m_form->m_error )
		{
			$dup_check = array( 
				'table_name' => "common_Views",
				'pk_name' => "view_id",
				'check_values' => array( 'controller_name' => strtolower( $input['controller_name'] ) )
			);
			
			if( is_numeric( $this->m_common->m_db->checkDuplicate( $dup_check ) ) )
			{
				$this->m_form->m_error = "That controller name already exists";
			}
		}
		
		//check missing alias
		if( !$this->m_form->m_error )
		{
			if( !array_key_exists( "alias", $input ) || strlen( trim( $input['alias'] ) ) == 0 )
			{
				$this->m_form->m_error = "You must select an alias.";
			} 
		}
		
		//check duplicate alias
		if( !$this->m_form->m_error )
		{
			$dup_check = array( 
				'table_name' => "common_Views",
				'pk_name' => "view_id",
				'check_values' => array( 'alias' => strtolower( $input['alias'] ) )
			);
			
			if( is_numeric( $this->m_common->m_db->checkDuplicate( $dup_check ) ) )
			{
				$this->m_form->m_error = "That alias already exists. Please choose a unique alias.";
			}
		}
		
		//check requires_auth
		if( !$this->m_form->m_error )
		{
			if( !array_key_exists( "requires_auth", $input ) || strlen( trim( $input['requires_auth'] ) ) == 0 )
			{
				$this->m_form->m_error = "You must specify this view's auth status.";
			} 
		}
		
		//check show_in_nav
		if( !$this->m_form->m_error )
		{
			if( !array_key_exists( "show_in_nav", $input ) || strlen( trim( $input['show_in_nav'] ) ) == 0 )
			{
				$this->m_form->m_error = "You must specify this view's nav status.";
			} 
		}
		
		return $this->m_form->m_error;
		
	}//checkInput()
	
	/**
	 * Sets the linked objects for this View object.
	 * Returns array of linked objects.
	 * @since	20100907, Hafner
	 * @return	array
	 */
	public function setLinkedObjects()
	{
		$class = get_class( $this ); 
		$return = array( 'file' => new File( $this->m_nav_image_id ), 'sub_views' => array() );
		
		foreach( $this->m_sub_view_ids as $i => $info )
		{
			$return['sub_views'][] = new $class( $info['view_id'] );
		}
		
		return $return;
		
	}//setLinkedObjects()
	
	public function setSubViewIds()
	{
		$sql = "
		SELECT view_id
		FROM common_Views
		WHERE parent_view_id = " . $this->m_view_id . " AND
		active = 1";
		
		$return = $this->m_common->m_db->doQuery( $sql, TRUE );
		
		if( !is_array( $return ) )
		{
			$return = array();
		}
		
		return $return;
		
	}//getSubViewIds()
	
	/**
	 * Adds an file to this view record. 
	 * Returns TRUE if nav_image_id is valid, FALSE if not.
	 * @since	20100915, Hafner
	 * @return	boolean
	 * @param 	int 		$nav_image_id		image id to be added ( should be an existing file_id @ 'common_Files' )
	 */
	public function addNavImageId( $nav_image_id )
	{
		$return = TRUE;
		$constraints = array( 
			'table_name' => "common_Files",
			'pk_name' => "file_id",
			'pk_value' => $nav_image_id 
		);
		
		if( !is_numeric( $nav_image_id ) || 
			!$this->m_common->m_db->keyExists( $constraints ) )
		{
			$return = FALSE;
		}
		else
		{
			$sql = "
			UPDATE common_Views
			SET nav_image_id = " . $nav_image_id . "
			WHERE view_id = " . $this->m_view_id;
			
			$this->m_common->m_db->query( $sql, __FILE__, __LINE__ );
		}
		
		return $return;
		
	}//addNavImageId()
	
	public function addParentViewId( $parent_view_id )
	{
		//validate parent view id exists
		$constraints = array( 
			'table_name' => "common_Views", 
			'pk_name' => "view_id", 
			'pk_value' => $parent_view_id );
		
		if( $parent_view_id > 0 &&
			$this->m_common->m_db->keyExists( $constraints ) )
		{
			$sql = "
			UPDATE common_Views
			SET parent_view_id = " . $parent_view_id . "
			WHERE view_id = " . $this->m_view_id;
			
			$this->m_common->m_db->query( $sql, __FILE__, __LINE__ );
		}
		else
		{
			throw new exception( "Error: Parent View ID '" . $parent_view_id . "' is invalid. ( is zero or does not exist @ table '" . $constraints['table_name'] . " )." );
		}
		
		return TRUE;
		
	}//addParentViewId()
	
	/**
	 * Gets all views.
	 * Returns an array of view objects.
	 * @since	20100907, Hafner
	 * @return	array
	 * @param	boolean			$nav_only		if TRUE, constrains query to only views that 'show_in_nav' == 1
	 */
	public function getAllRecords( $nav_only = FALSE )
	{
		$class = get_class( $this );
		$constraint = '';
		$return = FALSE;
		
		if( $nav_only )
		{
			$constraint = "AND show_in_nav = 1";
		}
		
		$sql = "
		SELECT 
			view_id AS view_id,
			controller_name AS controller_name
		FROM 
			common_Views
		WHERE
			active =1 AND
			view_id != 0 AND 
			parent_view_id = 0
			" . $constraint . "
		ORDER BY 
			nav_priority ASC";
		
		
		$records = $this->m_common->m_db->doQuery( $sql );
		
		if( is_array( $records ) )
		{
			foreach( $records as $i => $info )
			{
				$return[$info['controller_name']] = new $class( $info['view_id'], TRUE );
			}
		}
				
		return $return;
		
	}//getAllRecords()
	
	/**
	 * Updates this view's external link.
	 * @author	20101129, Hafner
	 * @return	boolean
	 * @param	string		$external_link		external link for this view
	 */
	public function updateExternalLink( $external_link )
	{
		if( $this->m_view_id == 0 )
		{
			throw new Exception( "Error: View id must be > 0." );
		}
		
		$sql = "
		UPDATE common_Views
		SET external_link = '" . $external_link . "'
		WHERE view_id = " . $this->m_view_id;
		$this->m_common->m_db->query( $sql, __FILE__, __LINE__ );
		
		return TRUE;
		
	}//updateExternalLink()
	
	
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
		$exclusions = array( 'm_view_id' );

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