<?
/**
 * Controls the content page.
 * @since	20100425, halfNerd
 */

require_once( "pbr_base/Controller.php" );
require_once( "pbr_base/View.php" );
require_once( "pbr_base/Article.php" );

require_once( "pbr_controllers/Index.php" );
require_once( "pbr_controllers/Portfolio.php" );
require_once( "pbr_controllers/Services.php" );
require_once( "pbr_controllers/Contacts.php" );

class Admin extends Controller{
	
	/**
	 * Constructs the Contact controller object.
	 * @return 	Contact
	 * @param	array			$controller_vars		array of variables for current layout.				
	 */
	public function __construct( $controller_vars )
	{
		parent::setControllerVars( $controller_vars );
	}//constructor
	
	/**
	 * @see classes/base/Controller#setContent()
	 */
	public function setContent() {
		
	}//setContent()
	
	/**
	 * Outputs the html nav.
	 * @since	20100726, hafner
	 * @return	string
	 */
	public function getNav()
	{
		$return = '
					<div class="jm_header" style="height:35px;padding-top:20px;top:-10px;">
							ADMIN
					</div>
					<div style="padding:10px;">
				';
		
		$v = new View( 0 );
		$records = $v->getAllRecords();
		
		if( is_array( $records ) && count( $records ) > 0 )
		{
			foreach( $records as $c_name => $tmp_v )
			{
				if( $tmp_v->m_show_in_nav )
				{
					$return .= '
						<div style="position:relative;margin:5px auto 0px auto;">
							' . $tmp_v->m_alias . '
							' . $this->getSubNavOptions( $tmp_v->m_controller_name ) . '
						</div>
			';	
				}
			}//loop through view records
		}
		else
		{
			$return .= '
						<div style="position:relative;margin:10px auto 10px auto;">
							There are no records available.
						</div>
			';
		}
		
		$return .= '
				</div>
		';
		
		return $return;
		
	}//getNav()
	
	public function getSubNavOptions( $view_title )
	{
		switch( strtolower( $view_title ) )
		{
			case "index":
				$links = array(
					"Edit Tagline",
					"Edit Home Article",
					"Edit Features"
				);
				break;
				
			case "productions":
				$links = array(
					"Manage Videos",
					"Manage Movie Reviews"
				);
				break;
				
			case "news":
				$links = array(
					"Manage News Articles"
				);
				break;
				
			case "jobs":
				$links = array(
					"Review Submissions",
					"Manage Casting Calls"
				);
				break;
				
			case "contacts":
				$links = array(
					"Edit Contact Address",
					"Edit Contact Email",
					"Manage Crew",
					"Manage Job Titles"
				);
				break;
				
			default:
				throw new Exception( "Error: View '" . $view_title . "' is invalid." );
				break;
		}
		
		$return = '
							<ul style="position:relative;top:-5px;">
		';
		
		foreach( $links as $title )
		{
			$url_action = $this->m_common->convertViewAlias( $title, "url" );
			
			if( $url_action != $this->m_controller_vars['id1'] )
			{
				//make link
				$link = array( 
					'v' => $this->m_controller_vars['v'], 
					'sub' => strtolower( $view_title ),
					'id1' => $url_action 
				);
				
				$url = $this->m_common->makeLink( $link );
				$option = '<a href="' . $url . '" class="menu_link">' . $title . '</a>';
			}
			else 
			{
				$option = '<span class="active_sub_nav_option">' . $title . ' > ></span>';
			}
			
			$return .= '
								<li style="margin-left:-1.5em;padding-bottom:5px;">
									' . $option . '
								</li>';
		}
		
		$return .= '
							</ul>
							';
		
		return $return;
		
	}//getSubNavOptions()
	
	/**
	 * @see classes/base/Controller#getContent()
	 */
	public function getContent() {
		return $this->m_content;
	}//getContent()
	
	/**
	 * Returns the HTML string for the admin section.
	 * @since	20100907, Hafner
	 * @return	string
	 * @param	string			$cmd			specifies what to return
	 * @param	array			$vars			array of variables
	 */
	public function getHtml( $cmd, $vars = array() )
	{
		$controller_name = ucFirst( strtolower( $this->m_controller_vars['sub'] ) );
		
		if( class_exists( $controller_name ) )
		{
			$c = new $controller_name( $this->m_controller_vars );
			$c->setAuth( $this->m_auth->m_authentication_id );
			
			$vars = ( $controller_name == "Index" && strpos( $this->m_controller_vars['id1'], "feature" ) !== FALSE ) ? array( 'feature_num' => "1" ) : array();
			$content = $c->getAdminHtml( $this->m_controller_vars['id1'], $vars );
			
			$title = $content['title'];
			$body = $content['body'];
		}
		else
		{
			
			$title = 'Welcome to the Administration Section';
			$body = '
			<div style="position:relative;margin-top:150px;text-align:center;">
				<p>
					From here you can manage all the content on the site. 
				</p>
				
				<p>
					Choose from the options on the left.
				</p>
				
				<p>
					Have fun!!!!
				</p>
			</div>
			';
		}
		
		return array(
			'title' => $title,
			'body' => $body
		);
		
	}//getHtml()
	
}//class Admin
?>