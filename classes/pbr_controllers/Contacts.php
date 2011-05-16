<?
/**
 * Controls the About page.
 * @since	20100425, halfNerd
 */

require_once( "pbr_base/Article.php" );
require_once( "pbr_base/Controller.php" );
require_once( "pbr_base/File.php" );

class Contacts extends Controller{
	
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
		$a_list = $a->getArticle( "index", "main" );
		$home_article = $a_list[0];
		
		//grab image
		$file = new File( $home_article->m_file_ids[0] );
		$paths = $this->m_common->getPathInfo();
		
		$this->m_content = '
		<div class="grid_8">
		
			<div class="padder">
				
				<div class="service_header_container" style="height:150px;">
					<table>
						<tr>
							<td>
								<div class="home_pic file_edit" file_id="' . $file->m_file_id . '" id="file_' . $file->m_file_id . '" article_id="' . $home_article->m_article_id . '">
									<img src="' . $paths[$this->m_common->m_env]['images'] . '/' . $file->m_file_name . '" />
								</div>
							</td>
							<td class="middle">
								<div class="header_mega color_accent article_title" id="article_title_' . $home_article->m_article_id . '">
									' . $home_article->m_title . '
								</div>
								' . $this->m_common->getHtml( "article_control", array( 'article_id' => $home_article->m_article_id, 'article_type' => "title" ) ) . '
							</td>
						</tr>
					</table>
				</div>
				
				<div class="article_body" id="article_body_' . $home_article->m_article_id . '">
					' . $this->m_common->formatText( $home_article->m_body ) . '
				</div>
				' . $this->m_common->getHtml( "article_control", array( 'article_id' => $home_article->m_article_id, 'article_type' => "body" ) ) . '
				
			</div>
			
		</div>
		
		<div class="grid_4">
		
			<div class="contact_container dashed_left padder">
				
				<div class="contact_studio dashed_bottom">
					
					<div class="header color_accent">
						Studio
					</div>
					
					<p class="home_p padder" style="padding-top:0px;">
						Rebekah Hill<br/>
						123 Main St.<br/>
						Redmond, OR 97333
					</p>
					
				</div>
				
				<div class="contact_email">
				
					<div class="header color_accent">
						Message
					</div>
					
					<div class="result" id="result">
					</div>
					
					<form id="message_form">
						
						<div class="padder no_top">
							<input type="text" name="contact_name" value="Your Name" class="input text_input input_clear normal_font text_longer" clear_if="Your Name"  />
						</div>
						
						<div class="padder">
							<input type="text" name="contact_email" value="Your Email" class="input text_input input_clear normal_font text_longer" clear_if="Your Email"  />
						</div>
						
						<div class="padder no_top">
							<textarea name="contact_message" class="normal_font input text_longer input_clear" style="height:195px;" clear_if="A love note.">A love note.</textarea>
						</div>
						
						<a href="#" id="send_message">
							<div class="button center">
								Send
							</div>
						</a>
					</form>
				</div>
				
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
	
}//class Contacts
?>
