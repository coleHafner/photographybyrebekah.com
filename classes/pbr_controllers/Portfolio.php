<?
/**
 * Controls the About page.
 * @since	20100425, halfNerd
 */

require_once( "pbr_base/Controller.php" );

class Portfolio extends Controller{
	
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
		
		$pa = new PicasaAlbum();
		
		switch( strtolower( $this->m_controller_vars['sub'] ) )
		{
			case "album":
				$album_feed = $pa->getAlbum( "title", $this->m_controller_vars['id1'] );
				$photo_feed = $pa->getAlbumSummary( $album_feed );
				$grid_html = $pa->getHtml( 'grid', array( 'feed' => $photo_feed, 'items_per_row' => 5, 'album_name' => $this->m_controller_vars['id1'] ) );
				
				$message = 'Click on a thumbnail to see full size. <br/><br/> <span class="normal_font color_accent">We\'re you linked to a photo? Try reloading.</span>';
				$paginator_html = $this->m_common->getHtml( "album_paginator", array( 'feed' => $photo_feed, 'photos_per_page' => 40, 'page_height' => "450" ) );
				$album_paginator = ( strlen( $paginator_html['body'] ) > 0 ) ? '<div class="paginator_style">' . $paginator_html['body'] . '</div>' : "";
				$height = $paginator_html['height'];
				
				$nav = '
				<div class="thumb_menu_nav_bar menu_nav_offset">
					<table style="width:100%;">
						<tr>
							<td>
								<div class="album_title" style="margin-left:0px;margin-right:5px;width:110px;">
									<a class="album_link" album_num="0" href="' . $this->m_common->makeLink( array( 'v' => "portfolio" ) ) . '" > 
										< < View All Albums 
									</a>
								</div>
								<div class="album_loader" id="album_loader_0">
								</div>
							</td>
							<td style="text-align:right;">
								' . $album_paginator . '
							</td>
						</tr>
					</table>
				</div>
				
				<div class="thumb_menu">
					<div id="thumb_menu_inner" style="height:' . $height . 'px;">
						' .  $grid_html['body'] . '
					</div>
				</div>
				';
				
				$content = '
				<div class="full_img_message">
					<span class="header">' . $message . '</span>
				</div>
				';
				
				
				if( is_array( $this->m_controller_vars['session'] ) &&
					array_key_exists( "anchor", $this->m_controller_vars['session'] ) )
				{
					$anchor_split = explode( "-", $this->m_controller_vars['session']['anchor'] );
					
					if( $this->m_controller_vars['id1'] == $anchor_split[0] )
					{
						$pe = $pa->getPhoto( $anchor_split[0], $anchor_split[1] );
						$photo_data = $pa->getPhotoSummary( $pe );
						$content = '<img src="' . $photo_data['url_full'] . '"/>';
					}
				}
				
				break;
				
			default:
				
				
				$html = $pa->getHtml( "album_list", array() );
				$message = "Choose an album from the left menu";
				
				$nav = '
				<div class="thumb_menu_nav_bar menu_title_offset">
					<span class="header color_accent">Choose An Album</span>
				</div>
				
				<div class="thumb_menu" style="padding:10px 0px 0px 10px;">
					' .  $html['body'] . '
				</div>
				';
				
				$content = '
				<div class="full_img_message">
					<span class="header">' . $message . '</span>
				</div>
				';
				break;
		}
	
		$this->m_content = '
		<div class="grid_4">
		
			<div class="thumb_menu_container dashed_right border_white">
				' . $nav . '
			</div>
			
		</div>
		
		<div class="grid_8">
		
			<div class="full_img">
				' . $content . '
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
	
}//class Portfolio
?>
