<?
/**
 * A class to handle a File record.
 * @since	20100618, hafner
 */

require_once( "pbr_base/Common.php" );
require_once( "pbr_base/FormHandler.php" );

class Section
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
	protected $m_section_id;
	
	/**
	 * Id of the file_type related to this record.
	 * @var	int
	 */
	protected $m_title;
	
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
	 * @param	int				$section_id			id of the current record
	 */
	public function __construct( $section_id, $objects = FALSE )
	{
		$this->m_common = new Common();
		$this->m_form = new FormHandler( 1 );
		$this->setMemberVars( $section_id, $objects );
	}//constructor
	
	/**
	 * Sets the member variables for this class.
	 * Returns TRUE, always.
	 * @since	20100618, hafner
	 * @return	boolean
	 */
	public function setMemberVars( $section_id, $objects )
	{
		$chosen_id = ( is_numeric( $section_id ) ) ? $section_id : 0;
		
		//get member vars
		$sql = "
		SELECT 
			section_id,
			title,
			active
		FROM 
			common_Sections
		WHERE 
			section_id = " . $chosen_id;
		$result = $this->m_common->m_db->query( $sql, __FILE__, __LINE__ );
		$row = ( $this->m_common->m_db->numRows( $result ) > 0 ) ? $this->m_common->m_db->fetchAssoc( $result ) : array();
		
		//set member vars
		$this->m_section_id = $row['section_id'];
		$this->m_title = stripslashes( $row['title'] );
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
			'section_id' => $this->m_section_id,
			'title' => $this->m_title,
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
			$input['section_id'] = $this->m_common->m_db->insertBlank( 'common_Sections', 'section_id' );
			$this->m_section_id = (int) $input['section_id'];
			$return = $this->m_section_id;
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
				common_Sections
			SET 
				title = '" . $this->m_common->m_db->escapeString( $input['title'] ) . "' 
			WHERE 
				section_id = " . $this->m_section_id;
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
			UPDATE common_Sections
			SET active = 0
			WHERE section_id = " . $this->m_section_id;
			$this->m_common->m_db->query( $sql, __FILE__, __LINE__ );
		}
		else
		{
			$sql = "
			DELETE
			FROM common_ArticleToSection
			WHERE article_to_section_id IN ( 
				SELECT section_id
				FROM common_ArticleToView
				WHERE section_id = " . $this->m_section_id . "
			)";
			$this->m_common->m_db->query( $sql, __FILE__, __LINE__ );
			
			
			$sql = "
			DELETE
			FROM common_Sections
			WHERE section_id = " . $this->m_section_id;
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
		if( !array_key_exists( "title", $input ) || strlen( trim( $input['title'] ) ) == 0 )
		{
			$this->m_form->m_error = "You must select a title.";
		} 
		
		//check duplicate title
		if( !$this->m_form->m_error )
		{
			$dup_check = array( 
				'table_name' => "common_Sections",
				'pk_name' => "section_id",
				'check_values' => array( 'title' => strtolower( $input['title'] ) )
			);
			
			if( is_numeric( $this->m_common->m_db->checkDuplicate( $dup_check ) ) )
			{
				$this->m_form->m_error = "That Title already exists";
			}
		}
		
		return $this->m_form->m_error;
		
	}//checkInput()
	
	/**
	 * Sets linked objects.
	 * @since	20100718, hafner
	 * @return	array
	 */
	public function setLinkedObjects()
	{
		return array();	
	}//setLinkedObjects()
	
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
		$exclusions = array( 'm_section_id' );

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
}//class Section
?>