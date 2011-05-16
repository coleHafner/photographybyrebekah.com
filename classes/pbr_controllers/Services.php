<?
/**
 * Controls the About page.
 * @since	20100425, halfNerd
 */

require_once( "pbr_base/Controller.php" );
require_once( "pbr_base/Article.php" );
require_once( "pbr_base/File.php" );

class Services extends Controller{
	
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
		
		$a = new Article( 0 );
		
		$s1_list = $a->getArticle( "services", "service_1" );
		$s1 = $s1_list[0];
		$s1_file = new File( $s1->m_file_ids[0] );
		
		$s2_list = $a->getArticle( "services", "service_2" );
		$s2 = $s2_list[0];
		$s2_file = new File( $s2->m_file_ids[0] );
		
		$s3_list = $a->getArticle( "services", "service_3" );
		$s3 = $s3_list[0];
		$s3_file = new File( $s3->m_file_ids[0] );
		
		$paths = $this->m_common->getPathInfo();
		
		$this->m_content = '
		<div class="grid_4">
			<div class="service padder dashed_right">
				
				<div class="service_header_container">
					<table>
						<tr>
							<td>
								<div class="home_pic service_pic file_edit" file_id="' . $s1_file->m_file_id . '" id="file_' . $s1_file->m_file_id . '" article_id="' . $s1->m_article_id . '">
									<img src="' . $paths[$this->m_common->m_env]['images'] . '/' . $s1_file->m_file_name . '" />
								</div>
							</td>
							<td class="middle">
								<div class="header color_accent article_title" id="article_title_' . $s1->m_article_id . '">
									' . $s1->m_title . '
								</div>
								' . $this->m_common->getHtml( "article_control", array( 'article_id' => $s1->m_article_id, 'article_type' => "title" ) ) . '
							</td>
						</tr>
					</table>
				</div>
				
				<div class="article_body" id="article_body_' . $s1->m_article_id . '">
					' . $this->m_common->formatText( $s1->m_body ) . '
				</div>
				' . $this->m_common->getHtml( "article_control", array( 'article_id' => $s1->m_article_id, 'article_type' => "body" ) ) . '
			</div>
		</div>
		
		<div class="grid_4">
			<div class="service padder dashed_right">
			
				<div class="service_header_container">
					<table>
						<tr>
							<td>
								<div class="home_pic service_pic file_edit" file_id="' . $s2_file->m_file_id . '" id="file_' . $s2_file->m_file_id . '" article_id="' . $s2->m_article_id . '">
									<img src="' . $paths[$this->m_common->m_env]['images'] . '/' . $s2_file->m_file_name . '" />
								</div>
							</td>
							<td class="middle">
								<div class="header color_accent article_title" id="article_title_' . $s2->m_article_id . '">
								' . $s2->m_title . '
								</div>
								' . $this->m_common->getHtml( "article_control", array( 'article_id' => $s2->m_article_id, 'article_type' => "title" ) ) . '
							</td>
						</tr>
					</table>
				</div>
				
				<div class="article_body" id="article_body_' . $s2->m_article_id . '">
					' . $this->m_common->formatText( $s2->m_body ) . '
				</div>
				' . $this->m_common->getHtml( "article_control", array( 'article_id' => $s2->m_article_id, 'article_type' => "body" ) ) . '
				
			</div>
		</div>
		
		<div class="grid_4">
			<div class="service padder">
			
				<div class="service_header_container">
					<table>
						<tr>
							<td>		
								<div class="home_pic service_pic file_edit" file_id="' . $s3_file->m_file_id . '" id="file_' . $s3_file->m_file_id . '" article_id="' . $s3->m_article_id . '" >
									<img src="' . $paths[$this->m_common->m_env]['images'] . '/' . $s3_file->m_file_name . '" />
								</div>
							</td>
							<td class="middle">
								<div class="header color_accent article_title" id="article_title_' . $s3->m_article_id . '">
								' . $s3->m_title . '
								</div>
								' . $this->m_common->getHtml( "article_control", array( 'article_id' => $s3->m_article_id, 'article_type' => "title" ) ) . '
							</td>
						</tr>
					</table>
				</div>
				
				<div class="article_body" id="article_body_' . $s3->m_article_id . '">
					' . $this->m_common->formatText( $s3->m_body ) . '
				</div>
				' . $this->m_common->getHtml( "article_control", array( 'article_id' => $s3->m_article_id, 'article_type' => "body" ) ) . '
			</div>
		</div>
		
		<div class="clear"></div>
		';
		
	}//setContent()
	
	/**
	 * @see classes/base/Controller#getContent()
	 */
	public function getContent() {
		return $this->m_content;
	}//getContent()
	
	public function getHtml( $cmd, $vars = array() )
	{
		switch( strtolower( trim( $cmd ) ) )
		{
			default:
				break;
		} 
		
		return $return;
	}//getHtml()
	
}//class Services
?>
