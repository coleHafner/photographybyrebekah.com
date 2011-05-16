<?

/**
 * A class to handle common functions.
 * @since 20100508, hafner
 */

require_once( "pbr_base/Database.php" );

class Common {
	
	/**
	 * Instance of the Database class.
	 * @var Database
	 */
	protected $m_db;
	
	/**
	 * Sets the environment( local, dev, live )
	 * @return string
	 */
	protected $m_env;
	
	public function __construct() {
		
		//set relative path
		$this->m_env = $this->determineEnv();
		
		$all_paths = $this->getPathInfo();
		$cur_paths = $all_paths[$this->m_env];
		
		//setup db connection
		$this->m_db = new Database( $cur_paths );
		
	}//constructor()
	
	/**
	 * Generates a link.
	 * @since	20100620, hafner
	 * @return	string
	 * @param 	array		$get		variables collected by the current controller + additional variables
	 */
	public function makeLink( $get )
	{
		$return = "";
		$counter = 0;
		$valid_fields = array( "v", "sub", "id1", "id2", "show_tip" );
			
		foreach( $get as $field => $val )
		{
			$field = strtolower( $field );
			
			if( in_array( $field, $valid_fields ) )
			{
				$delim = ( $counter == 0 ) ? "/?" : "&"; 
				$return .= $delim . $field . "=" . strtolower( $val );
				$counter++;
			}
		}//loop through controller vars
		
		$paths = $this->getPathInfo();
		$return = ( strtolower( trim( $this->m_env ) ) == "live" ) ? str_replace( "/?", "/" . $paths[$this->m_env]['web'] . "?", $return ) : $return;
				
		return $return;
		 	
	}//makeLink()
	
	public function makeFilePath()
	{
		$return = "/";
		switch( strtolower( trim( $this->m_env ) ) )
		{
			case "live":
				$paths = $this->getPathInfo();
				$return = "/" . $paths[$this->m_env]['web'] . "/";
				break;
		}
		
		return $return;
		
	}//makeFilePath()
	
	public function getPathInfo() 
	{
		return array(
			'local' => array(
				'absolute' => "/usr/local/www/photographybyrebekah.com",
				'web' => "www",
				'images' => "/images",
				'db_host' => "localhost",
				'db_name' => "pbr",
				'db_user' => "pbr_user",
				'db_pass' => "passwd1000!",
			),
			
			//fatcow.com
			'dev' => array(
				'absolute' => "/home/users/web/b937/moo.halfnerdcom",
				'web' => "pbr/www",
				'images' => "/images",
				'db_host' => "halfnerdcom.fatcowmysql.com",
				'db_name' => "pbr",
				'db_user' => "pbr_user",
				'db_pass' => "passwd1000!",
				'blog_link' => "http://pbrblog.halfnerddesigns.com"
			),
			
			//godaddy.com
			'live' => array(
				'absolute' => "",
				'web' => "",
				'images' => "",
				'db_host' => "",
				'db_name' => '',
				'db_user' => "",
				'db_pass' => ""
			)
		);
		
	}//getPathInfo()
	
	/**
	 * Turns an array of sql constraints into a string.
	 * @since	20100620, hafner
	 * @return string
	 * @param	array			$constraints		array( '[field_name1]' => '[value1]', '[field_name2]' => '[value2]' etc. . . ) )
	 * @param	array			$operators			if TRUE $constraints = array( [0] => array( '[field_name1]' => '[value1]', ['operator'] => "<= || >= || =" ), [1]  => array( '[field_name2]' => '[value2]', ['operator'] => "<= || >= || =" ) etc. . . ) )
	 */
	public function compileSqlConstraints( $constraints )
	{
		if( is_array( $constraints ) && count( $constraints ) > 0 )
		{	
			$counter = 1;
			$return = " WHERE ";
			$total_vals = count( $constraints );
			
			foreach( $constraints as $field => $val )
			{
				$joiner = ( $counter != $total_vals ) ? " AND" : "";
				$l = ( !is_numeric( $val ) ) ? "'" : "";
				$r = ( !is_numeric( $val ) ) ? "'" : "";
				
				$return .= "
				LOWER( TRIM( " . $field . " ) ) = " . $l .  strtolower( trim( $val ) ) . $r . $joiner;  
				$counter++;
			}
		}
		else
		{
			print_r( $dup_check );
			throw new exception( "Error: Invalid input for Common->compileSqlConstraints()" );
		}
		
		return $return;
	
	}//compileSqlConstraints()
	
	/**
	 * Determines the environment.
	 * @since	20100621, hafner
	 * @return	string
	 */
	public function determineEnv()
	{
		$return = "local";
		$paths = $this->getPathInfo();
		
		$dev_path = $paths['dev']['absolute'] . "/" . $paths['dev']['web'];
		$live_path = $paths['live']['absolute'] . "/" . $paths['live']['web'];
		
		if( file_exists( $dev_path . "/is_dev.txt" ) )
		{
			$return = "dev";	
		}
		else if( file_exists( $live_path . "/is_live.txt" ) )
		{
			$return = "live";	
		}
		
		return $return;
		
	}//determineEnv()
	
	/**
	 * Used primarily in the mdp_helper.php file.
	 * @since	20100628, hafner
	 * @return	mixed
	 * @param	boolean			$return			whether or not the action was a success
	 * @param	string			$message		success/failure message
	 */
	function sendJsonResponse( $return, $message )
	{
		//send JSON header and response
		header( 'Content-type: application/x-json' );
		echo json_encode( $return );
		
	}//sendJsonResponse()
	
	public function convertTimestamp( $ts, $include_time = TRUE )
	{
		$format = ( $include_time ) ? "F j \@ g:i a" : "F d";
		return date( $format, $ts );
	}//convertTimestamp()
	
	public function compileHiddenFields( $array )
	{
		$return = '';
		
		foreach( $array as $k => $v )
		{
			if( $k != "task" && 
				$k != "process" )
			{
				$return .= '
				<input type="hidden" name="' . $k . '" id="' . $k . '" value="' . $v . '"/>
				';
			}
		}
		
		return $return;
		
	}//compileHiddenFields()
	
	public function formatText( $text, $class = "" )
	{
		if( strlen( $class ) > 0 )
		{
			$class = 'class="' . $class . '"';
		}
		
		$text = str_replace( "\\n", "\n", $text );
		
		$return ='<p ' . $class . '>' . $this->convertLinks( $text ) . '</p>';
		
		if( strlen( $text ) > 0 &&
			strpos( $text, "\n" ) )
		{
			$return = '';
			$body_split = explode( "\n", $text );
			
			foreach( $body_split as $p )
			{
				$return .= '<p ' . $class . '>' . $this->convertLinks( $p ) . '</p>'; 
			}
		}
		
		return $return;
		
	}//formatText()
	
	public function convertLinks( $str )
	{
		return ereg_replace("[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]","<a target='_blank' href=\"\\0\">\\0</a>", $str );
		
	}//convertLinks()
	
	/**
	 * Validates the authenticity of an email address.
	 * Returns TRUE if valid, FALSE otherwise.
	 * @since	20100909, Hafner
	 * @return	boolean
	 * @param 	string			$email			email address to validate
	 */
	public function validateEmailAddress( $email )
	{
		$return = FALSE;
		$email = strtolower( trim( $email ) );
		
		if( !$return )
		{
			if( strlen( $email ) == 0 )
			{
				$return ="You must provide an email address.";
			}
		}
		
		if( !$return )
		{
			if( strpos( $email, "@" ) === FALSE || 
				strpos( $email, "." ) === FALSE ||
				strpos( $email, " " ) !== FALSE )
			{
				$return = "You must provide a valid email address";
			}
		}
		
		return $return;
		
	}//validateEmailAddress()
	
	public function convertViewAlias( $alias, $type )
	{
		switch( strtolower( $type ) )
		{
			case "url":
				$return = strtolower( str_replace( " ", "-", $alias ) );
				break;
				
			case "interface":
				$return = ucfirst( strtolower( str_replace( "-", " ", $alias ) ) );
				break;
				
			default:
				throw new Exception( "Error: Type '" . $type . "' is invalid." );
				break;
		}
		
		return $return;
		
	}//convertViewAlias()
	
	/**
	 * Gets HTML
	 * @since	20101007
	 * @author	20101007, hafner
	 * @param	string			$cmd			command html to get
	 * @param	boolean			$is_addition	if we are adding a new record, is_addition = TRUE, FALSE otherwise.			 
	 */
	public function getHtml( $cmd, $vars = array() )
	{
		switch( strtolower( $cmd ) )
		{
			case "get-step-meter":
				
				$num_steps = count( $vars['steps'] );
				
				$body = '
				<table class="event_progress_meter">
					<tr>
					';
					
				foreach( $vars['steps'] as $i => $step_title )
				{
					$body .= '
						<td class="progress_option">
							 ' . $step_title . '
						</td>
						';
						
					if( $i != $num_steps )
					{
						$body .= '
						<td class="spacer">
							&nbsp;
						</td>
						';
					}
						
				}	
							
				$body .= '		
					</tr>
					<tr>
					';
					
				foreach( $vars['steps'] as $i => $step_title )
				{
					$step_indicator = ( $i == 1 ) ? "&#9650;" : "";
						
					$body .= '
						<td id="step_' . $i . '" class="event_selector">
							' . $step_indicator . '
						</td>
						';
						
					if( $i != $num_steps )
					{
						$body .= '
						<td class="spacer">
							&nbsp;
						</td>
						';
					}
				}
						
				$body .= '
					</tr>
				</table>
				';
				
				$return = array( 'body' => $body );
				break;
				
			case "get-step-nav":
				
				$next_step = $vars['current_step'] + 1;
				$prev_step = $vars['current_step'] - 1;
				
				$prev = '
				<a href="#" id="' . $vars['link_trigger_id'] . '" go-to="' . $prev_step . '">
					<< Prev
				</a>';
				
				$next = '
				<a href="#" id="' . $vars['link_trigger_id'] . '" go-to="' . $next_step . '">
					Next >>
				</a>';
				
				if( $vars['current_step'] == $vars['total_steps'] )
				{
					$next = '
					<a href="#" id="' . $vars['link_trigger_id'] . '" go-to="finish">
						Finish
					</a>';
				}  
				
				if( $vars['current_step'] == 1 )
				{
					$prev = '';
				}
				
				$return = array(  'body' => '
					<table class="selector_table">
						<tr>
							<td class="selector_option">
								' . $prev . ' 
							</td>
							<td class="selector_option" align="right">
								' . $next . '
							</td>
						</tr>
					</table>
				' 
				);
				break;
				
			case "under-construction":
				$return = array( 
					'body' => '
					<div class="under_construction_container">
						This section is  under construction...
					</div>
					' 
				);
				break;
				
			case "full-div":
				$return = array(
					'out' => '<div class="grid_12 rounded_corners"> ',
					'in' => '<div class="padder">' 
				);
				break;
				
			case "rating-html":
				
				if( $vars['style'] == "stars" )
				{
					$full_star = '<img src="/images/star_full_111.gif"/>';
					$half_star = '<img src="/images/star_half_111.gif"/>';
					
					$rating_num = (float)$vars['rating'];
					$rating_split = explode( ".", $rating_num );
					
					for( $i = 1; $i <= $rating_split[0]; $i++ )
					{
						$rating .= $full_star;	
					}
					
					//add half star
					if( $rating_split[1] != 0 )
					{
						$rating .= $half_star;
					}
					
					//wrap rating
					$rating = '
					<div style="margin-top:10px;">
						' . $rating . '
					</div>
					';
				}
				else if( $vars['style'] == "select list" )
				{
					$rating = ' 
					<select id="rating">
					';
					
					for( $i = 1; $i <= 5; $i += .5 )
					{
						$selected = ( $i == $vars['selected_value'] ) ? ' selected="selected" ' : "";
						
						$rating .= '
						<option value="' . $i . '"' . $selected . '>
							' . $i . '
						</option>
						';
					}
					
					$rating .= '
					</select>
					';
				}
					
				$return = array( 'body' => $rating );
				break;
				
			case "album_paginator":
				
				$num_pages = ceil( count( $vars['feed'] )/$vars['photos_per_page'] );
				$height = $num_pages * $vars['page_height'];
				$body = '';
				
				//paginator
				if( $num_pages > 1 )
				{
					$body = '
					<input type="hidden" id="current_page" value="1"/>
					<input type="hidden" id="page_height" value="' . $vars['page_height'] . '"/>
					
					Page ';
					for( $i = 1; $i <= $num_pages; $i++ )
					{
						$extra_class = ( $i == 1 ) ? 'selected' : ''; 
						$body .= '
						<a href="#" class="album_paginator ' . $extra_class . '" page_num="' . $i . '" >
							' . $i . ' 
						</a>
						';
					}
				}
				
				$return = array( 'body' => $body, 'height' => $height );
				break;
				
			case "article_control":
				$return = '
				<div class="article_control" id="' . $vars['article_type'] . '_control_' . $vars['article_id'] . '">
					<a href="#" class="font_normal article_' . $vars['article_type'] . '_save" article_id="' . $vars['article_id'] . '">Save</a>
					<span class="color_accent">|</span>
					<a href="#" class="font_normal article_' . $vars['article_type'] . '_cancel" article_id="' . $vars['article_id'] . '">Cancel</a>
				</div>
				';
				break;
		}
		
		return $return;
		
	}//getHtml()
	
	public function truncateVidTitle( $title )
	{
		return ( strlen( $title ) > 48 ) ? substr( $title, 0, 46 ) . "..." : $title; 
	}//truncateVidTitle()
	
	public function getAllSiteImages()
	{
		$return = array();
		$paths = $this->getPathInfo();
		
		$sql = "
		SELECT file_name
		FROM common_Files
		WHERE file_type_id = (
			SELECT file_type_id
			FROM common_FileTypes
			WHERE LOWER( title ) = 'image' ) AND
		file_id IN (
			SELECT file_id
			FROM common_ArticleToFile )";
		
		$result = $this->m_db->query( $sql, __FILE__, __LINE__ );
		
		while( $row = $this->m_db->fetchRow( $result ) )
		{
			$return[] = $paths[$this->m_env]['images'] . '/' . $row[0];
		}
		
		return $return;
		
	}//getAllSiteImages()
	
	/**
	 * Allows access to this classes member variables.
	 * Returns the requested member variable if not in exceptions array.
	 * @return 	mixed
	 */
	public function __get( $var_name )
	{
		$exclusions = array();
		
		if( !in_array( $var_name, $exclusions ) ) {
			$return = $this->$var_name;
		} else {
			throw new Exception( "Error: Access to member variable '" . $var_name . "' denied." );
		}
		
		return $return;
	}//get()
	
}//class Common
?>