<?
/**
 * Controls the home page content.
 * @since	20100425, halfNerd
 */

require_once( "pbr_base/Controller.php" );
require_once( "pbr_base/Article.php" );
require_once( "pbr_base/File.php" );
require_once( "PicasaAlbum.php" );

class Index extends Controller{
	
	/**
	 * Constructs the Index controller object.
	 * @return 	Index
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
		
		//get featured feed
		$slideshow_html = '';
		$pa = new PicasaAlbum();
		$album = $pa->getAlbum( "title", "featured" );
		$feed = $pa->getAlbumSummary( $album, array( "thumb_key" => 0 ) );
		
		//generate slideshow html body
		foreach( $feed as $i => $info )
		{
			$slideshow_html .= '
			<img src="' . $info['url_full'] . '" />
			';
		}
		
		//grab home article
		$this->m_content = '
		<div class="grid_12 center">
			<div class="slider_container">
				<div id="slider">
					' . $slideshow_html . '
				</div>
			</div>
		</div>
		<div class="clear"></div>
		';
		
		/*
		$height = '450';
		$album_paginator = '';
		$html_grid = $pa->getHtml( "featured_grid", array( 'feed' => $feed, 'items_per_row' => 1 ) );
		
		if( $html_grid['show_paginator'] )
		{ 
			$paginator_html = $this->m_common->getHtml( 'album_paginator', array( 'feed' => $feed, 'photos_per_page' => 3, 'page_height' => "430" ) );
			$height = $paginator_html['height'];
			$album_paginator = '
			<div class="paginator_holder paginator_style">
				' . $paginator_html['body'] . '
			</div>
			';
		}
		
		<div class="grid_4">
			<div class="padder">
				<div class="thumb_menu_container dashed_left" style="height:auto;">
					<div class="featured_header">
						<span class="header">Featured Photos</span>
						' . $album_paginator . '
					</div>
					
					<div class="thumb_menu" style="height:420px;">
						<div id="thumb_menu_inner" style="height:' . $height . 'px;">
							' . $html_grid['body'] . '
						</div>
					</div>
				</div>	
			</div>
		</div>
		*/
		
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
	
}//class Index
?>
