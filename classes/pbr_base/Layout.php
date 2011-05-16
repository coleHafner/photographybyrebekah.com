<?
/**
 * A class to handle the layout common to every page on the site.
 * @since	20100425, hafner
 */

require_once( 'pbr_base/Common.php' );
require_once( 'pbr_base/View.php' );
require_once( "pbr_base/EnvVar.php" );
require_once( "PicasaAlbum.php" );

class Layout
{
	/**
	 * Instance of the Common class.
	 * @var	Common
	 */
	protected $m_common;
	
	/**
	 * Name of the current view.
	 * @var	int
	 */
	protected $m_active_view;
	
	/**
	 * Array of possible views.
	 * @var	array
	 */
	protected $m_views;
	
	/**
	 * Details of the current page. Includes title and other details.
	 * @var	string
	 */
	protected $m_page_details;
	
	/**
	 * Constructs the Layout object.
	 * @return Layout
	 * @since	20100307, hafner
	 * @mod		20100502, hafner
	 * @param	string			$view			name of the controller	
	 */
	public function __construct( $get )
	{
		$v = ( array_key_exists( "v", $get ) ) ? $get['v'] : "";
		$view = ucfirst( $v );
		$this->m_common = new Common();
		$this->m_active_view = $this->validateView( $view );
		$this->m_page_details = $this->getPageDetails();
		
	}//Layout()
	
	/**
	 * Gets the details for this page. 
	 * @return	array
	 * @since	20100307, hafner
	 * @mod		20100307, hafner
	 */
	public function getPageDetails()
	{
		$v = new View(0);
		$return = $v->getAllRecords( FALSE );
		return $return;
		
	}//getPageDetails()
	
	/**
	 * Outputs the 'head' section of the HTML document.
	 * @return	string
	 * @since	20100323, hafner
	 * @mod		20100323, hafner
	 */
	public function getHtmlHeadSection()
	{
		return '
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml" >
		
		<head>
		
			<title>' . $this->m_page_details[$this->m_active_view]->m_alias . '</title>

			<link rel="stylesheet" href="/css/960_grid.css" type="text/css" />
			<link rel="stylesheet" href="/css/jquery-ui-1.8.1.custom.css" type="text/css" />
			<link rel="stylesheet" href="/css/colorbox.css" type="text/css" />
			<link rel="stylesheet" href="/css/imgbox.css" type="text/css" /> 
			<link rel="stylesheet" href="/css/nivo-slider.css" type="text/css" />
			<link rel="stylesheet" href="/css/common.css" type="text/css" />
			
			<script type="text/javascript" src="/js/jquery-1.4.2.js"></script>
			<script type="text/javascript" src="/js/jquery-ui-1.8.1.custom.min.js"></script>
			<script type="text/javascript" src="/js/jquery.colorbox.js"></script>
			<script type="text/javascript" src="/js/jquery.imgbox.js"></script>
			<script type="text/javascript" src="/js/jquery.nivo.slider.js"></script>
			<script type="text/javascript" src="/js/jquery.halfnerd.js"></script>
			<script type="text/javascript" src="/js/jquery.common.js"></script>
			
			<!--
			<script type="text/javascript" src="/js/jquery.timepicker.js"></script>
			<link rel="stylesheet" href="/css/timepicker.css" type="text/css" />
			-->
			
		</head>
		';
		
	}//getHtmlHeadSection()
	
	/**
	 * Outputs the section directly above the unique content for each page.
	 * @return	string
	 * @since	20100323, hafner
	 * @mod		20100323, hafner
	 */
	public function getHtmlBodySection()
	{  
		$alternate_class = ( $this->m_active_view == "Index" ) ? 'main_content_no_opacity' : '';
		$page_bg = ( $this->m_active_view == "Index" ) ? "page_bg" : "page_bg";
		
		return '
		<body class="normal_font">
		
		<!--page-->
		<div class="page ' . $page_bg . '">
		
			<!--nav section-->
			<div class="nav" style="position:relative;">
				
				<!--nav container-->
				<div class="container_12">
				
					<!--logo-->
					<div class="grid_6" style="height:95px;">
						
						<div style="position:relative;">
							<img src="/images/logo_with_text.png"/>
						</div>
						
					</div>
					<!--/logo-->
					
					<!--nav content-->
					<div class="grid_6">
						
						<!--nav container-->
						<div class="nav_container">
							' . $this->getHtmlNav() . '
						</div>
						<!--/nav container-->
						
					</div>
					
					<div class="clear"></div>
					<!--/nav content-->
					
				</div>
				<!--/nav container--> 
				
			</div>
			<!--/nav section-->
		
		
			<!--main content section-->
			<div class="main_content" style="margin-top:10px;">
				
				<!--main content container-->
				<div id="main_content_container" class="container_12  main_content_container landscape_height ' . $alternate_class . '">
				';
		
	}//getHtmlBodySection()
	
	/**
	 * Closes the main HTML tags.
	 * @return	string
	 * @since	20100323, hafner
	 * @mod		20100323, hafner
	 */
	public function getHtmlFooterSection( $login_html )
	{
		$return = ( strlen( $login_html ) > 0 ) ? $login_html : '';
		
		$return .= '
				</div>
				<!--/main content container-->	
			</div>
			<!--/main content section-->
			
			<!--footer section-->
			<div class="footer">
				<div class="container_12" style="margin-top:5px;">
					<div class="grid_12 center">
					
						Optimized for use with Firefox, Safari, and Chrome
						&nbsp;&nbsp; 
						<span class="color_accent">|</span>
						&nbsp;&nbsp;
						
						Design by Halfnerd
						&nbsp;&nbsp; 
						<span class="color_accent">|</span>
						&nbsp;&nbsp;
						
						&copy; Rebekah Hill 2010
						&nbsp;&nbsp;
						<span class="color_accent">|</span>
						&nbsp;&nbsp;
						
						<a href="#" id="colorbox_login">
							CMS Login
						</a>
						
					</div>
				</div> 
			</div>
			<!--/footer section-->
			
			<iframe class="input text_input" style="height:200px;width:300px;display:none;" id="hidden_frame" name="hidden_frame" ></iframe>
			
		</div>
		<!/--page-->
		
		<!--loader-->
		<div id="loader">
			<div class="loader_message">
				<img src="/images/loader_big.gif"/>
				<div id="loader_message" style="margin-top:10px;"></div>
			</div>
		</div>
		<!--/loader-->
		
		<!--pre loader-->
		<div id="preloader"></div>
		<!--/pre loader-->
		';
		
		return $return;
		
	}//getHtmlFooterSection()
	
	/**
	 * Outputs the section directly below the unique content for each page.
	 * @return	string
	 * @since	20100323, hafner
	 * @mod		20100323, hafner
	 */
	public function getFooterContent()
	{	
		$admin_url = $this->m_common->makeLink( array( 'v' => "admin" ) );
		return '
					&copy; 2010 Rebekah Hill Photography 
					<span style="color:#FF0000;">|</span> 
					Designed by HalfNerd 
					<span style="color:#FF0000;">|</span>
					<a href="' . $admin_url . '">CMS Login</a>
			';
	}//getFooterContent()
	
	public function getClosingTags()
	{
		return '
		</body>
		
		</html>
		';
	}//getClosingTags()
	
	/**
	 * Outputs the primary navigation.
	 * @return	string
	 * @since	20100323, hafner
	 * @mod		20100403, hafner
	 */
	public function getHtmlNav()
	{
		$return = array(
			'<div class="nav_item social_icons">
				<a href="http://photos.google.com/photonorthwest" target="_blank">
					<img src="/images/icon_picasa.png" />
				</a>
				
				&nbsp;&nbsp;
				
				<a href="http://facebook.com/photonorthwest" target="_blank">
					<img src="/images/icon_facebook.png" />
				</a>
			</div>
			'
		);
		
		foreach( $this->m_page_details as $c_name => $view ) 
		{
			
			if( $view->m_show_in_nav )
			{
				//determine active selector
				$sub = "";
				$fixed_width = "";
				$link = ( strlen( $view->m_external_link ) > 0 ) ? $view->m_external_link : $this->m_common->makeLink( array( 'v' => $c_name ) );
				$link_style = ( strlen( $view->m_external_link ) > 0 ) ? 'target="_blank"' : "";
				$selected = ( $c_name == $this->m_active_view ) ? 'class="selected"': "";
				
				//sub nav
				if( strtolower( $c_name ) == "portfolio" )
				{
					$pa = new PicasaAlbum();
					$albums = $pa->getAlbumList();
					$fixed_width = 'style="width:95px;"';
					
					$sub = '
					<div class="nav_sub">
						<ul class="nav_sub_list">
						';
					
					//filter to just title
					foreach( $albums as $i => $info )
					{
						$title = ( strlen( $info['title'] ) > 9 ) ? substr( $info['title'], 0, 10 ) . "..." : $info['title']; 
						$sub_link = $this->m_common->makeLink( array( 'v' => $c_name, 'sub' =>  "album", 'id1' => PicasaAlbum::convertAlbumName( $info['title'] ) ) );
						
						$sub .= '
							<li>
								<a href="' . $sub_link . '">
									' . $title . '
								</a>
							</li>
							';
					}
					
					$sub .= '
						</ul>
					</div>
					';
				}
				
				//compile html
				$return[] = '
				<div class="nav_item" ' . $fixed_width . '>
					<a href="' . $link . '" ' . $selected . ' ' . $link_style . '>
						' . $view->m_alias . '
					</a>
					' . $sub . '
				</div>
				';
			}		
		}
		
		//compile html in reverse
		$new_order = array_reverse( $return );
		$return = '';
		foreach( $new_order as $html )
		{
			$return .= $html . '
			';
		}
		    
		return $return;
		
	}//getHtmlNav()
	
	/**
	 * Returns an HTML string that contains the elements referenced in a table. 
	 * @since	20100603, hafner
	 * @return	string
	 * @param 	array			$data			array of data
	 * @param 	array 			$style			array( 'table_style'  => "id or class of table", 'elements_per_row'  => integer )
	 */
	public function getTableGrid( $data, $style )
	{
		//calc vars
		$num_rows = ceil( count( $data )/$style['elements_per_row'] );
		$return = '
		<table ' . $style['table_style'] . '>
		';
		
		for( $i = 0; $i < $num_rows; $i++ ) 
		{
			$return .= '
			<tr>';
			
			$start = ( $i == 0 ) ? 0 : ( $style['elements_per_row'] * $i );
			$stop = ( $i == 0 ) ? ( $style['elements_per_row'] - 1 ) : ( $style['elements_per_row'] * $i ) + ( $style['elements_per_row'] - 1 );
			
			for( $j = $start; $j < $stop; $j++ )
			{
				$return .= '
				<td>
					' . $data[$j] . '
				</td>
				';
				
				if( $j == count( $data ) - 1 ) break;
			}
			
			$return .= '
			</tr>';
		}
		
		$return .= '
		</table>';
		
		return $return;
		 
	}//getTableGrid()
	
	/**
	 * Validates the current view.
	 * Returns the name of the view.
	 * @since	20100323, hafner
	 * @return	string
	 * @param	string		$view		view from the url
	 */
	public function validateView( $view )
	{
		$sql = "
		SELECT count(*)
		FROM common_Views
		WHERE LOWER( TRIM( controller_name ) ) = '" . strtolower( trim( $view ) ) . "'
		AND parent_view_id = 0";
		
		$result = $this->m_common->m_db->query( $sql, __FILE__, __LINE__ );
		$row = $this->m_common->m_db->fetchRow( $result );
		
		return ( $row[0] == 1 ) ? ucfirst( strtolower( $view ) ) : "Index";
		
	}//validateView()
	
	/**
	* Get a member variable's value
	* @return	mixed
	* @param	string		$var_name		Variable name to get
	* @since 	20100403, hafner
	* @mod		20100403, hafner
	*/
	public function __get( $var_name )
	{
		$exclusions = array( 'm_common' );
		if( !in_array( $var_name, $exclusions ) ) {
			$return = $this->$var_name;
		}else {
			if( $this->m_common->m_in_production ) {
				echo "<h3>Access to get member " . get_class( $this ) . "::" . $var_name . " denied.</h3><br/>\n";
				$return = FALSE;
			}else {
				$return = FALSE;
			}
		}
		return $return;
	}//__get()
	
}//class Layout
?>