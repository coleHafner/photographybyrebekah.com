<?
/**
 * Abstract class for all controllers.
 * @since	20100425, halfNerd
 */

require_once( "pbr_base/Common.php" );
require_once( "pbr_base/View.php" );
require_once( "pbr_base/Authentication.php" );

abstract class Controller{
	
	/**
	 * Array of variables for the current controller.
	 * @var	array
	 */
	protected $m_controller_vars;
	
	/**
	 * HTML Content.
	 * @var	string
	 */
	protected $m_content;
	
	/**
	 * Instance of the common object.
	 */
	protected $m_common;
	
	/**
	 * Id of the view associated with this controller class.
	 * @var	int
	 */
	protected $m_view_id;
	
	/**
	 * Collection of objects linked to this controller class.
	 * @var	array
	 */
	protected $m_linked_objects;
	
	/**
	 * Instance of the authentication user currently logged in.
	 * @var	int
	 */
	protected $m_auth;
	
	/**
	 * A function to set the member vars.
	 * Always returns TRUE.
	 * @return	boolean
	 * @param 	array		$controller_vars	array of variables for the current controller
	 */
	public function setControllerVars( $controller_vars, $objects = TRUE ) 
	{
		$this->m_common = new Common();
		$this->m_controller_vars = ( is_array( $controller_vars ) ) ? $controller_vars : array();
		$this->m_view_id = $this->setViewId();
		$this->m_linked_objects = ( $objects ) ? $this->setLinkedObjects() : array();
		$this->m_auth = FALSE;
		
		return TRUE;
		
	}//setControllerVars()
	
	/**
	 * Sets the linked objects for this View object.
	 * Returns array of linked objects.
	 * @since	20100907, Hafner
	 * @return	array
	 */
	public function setLinkedObjects()
	{
		return array(
			'view' => new View( $this->m_view_id, TRUE )
		);
	}//setLinkedObjects()
	
	public function getAuthStatus() 
	{ 
		return $this->m_linked_objects['view']->m_requires_auth;
		 
	}//getAuthStatus()
	
	public function setViewId()
	{
		$v = array_key_exists( "v", $this->m_controller_vars ) ? $this->m_controller_vars['v'] : "";
		
		$sql = "
		SELECT view_id
		FROM common_Views
		WHERE LOWER( controller_name ) = '" . strtolower( $v ) . "'";
		
		$result = $this->m_common->m_db->query( $sql, __FILE__, __LINE__ );
		$row = $this->m_common->m_db->fetchRow( $result );
		
		return $row[0];
		
	}//setViewId()
	
	public function setAuth( $auth_id )
	{
		$this->m_auth = new Authentication( $auth_id, TRUE );
		
	}//setAuth()
	
	public function hasValidAuthLogin()
	{
		$return = FALSE;
		
		if( is_object( $this->m_auth ) &&
			$this->m_auth->m_authentication_id > 0 )
		{
			$return = TRUE;
		}
		
		return $return;
		
	}//hasValidAuthLogin()
	
	public function getLoginString()
	{
		return $this->m_auth->getHtml( "login-string", array() );
	}//getHtml();
	
	/**
	 * Sets the content for the current controller
	 * Always returns TRUE
	 * @return	boolean
	 */
	abstract function setContent();
	
	/**
	 * Returns this->m_content
	 * Always returns TRUE
	 * @return	boolean
	 */
	abstract function getContent();
	
	/**
	 * Returns HTML content.
	 * @since	20100907, Hafner
	 * @return	string
	 * @param	string			$cmd		determines what to return
	 * @param	array			$vars		array of variables
	 */
	abstract function getHtml( $cmd, $vars = array() );
	
}//abstract class Controller
?>