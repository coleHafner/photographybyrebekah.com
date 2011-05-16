<?

//start session
session_start();

//require classes;
require_once( "pbr_base/Authentication.php" );
require_once( "pbr_base/Common.php" );
require_once( 'PicasaAlbum.php' );

$common = new Common();
$auth = new Authentication( Authentication::getAuthId() );

$task = strtolower( trim( $_GET['task'] ) );
$process = strtolower( trim( $_GET['process'] ) );
$echo_content = FALSE;
$send_reply = FALSE;

//determine action
switch( $task )
{
	case "picasa":
		
		$pa = new PicasaAlbum();
		
		switch( $process )
		{
			case "photo_feed":
				$send_reply = TRUE;
				$feed = $pa->getAlbum( $_POST['album_name'] );
				$photo_feed = $pa->getAlbumPhotoUrlSummary( $feed );
				$return = implode( "^", $photo_feed );
				break;
				
			case "album_list":
				$send_reply = TRUE;
				$album_list = $pa->getAlbumList();
				$return = implode( "^", $album_list );
				break;
				
			case "all_pics_feed":
				$all_pics = $pa->getAllPics();
				echo implode( "^", $all_pics );
				break;
		}
		break;
		
	case "file":
		
		switch( $process )
		{
			case "site_images_feed":
				echo implode( "^", $common->getAllSiteImages() );
				break;
		}
		break;
}

//send json headers
if( $send_reply )
{
	//send results
	header( 'Content-type: application/x-json' );
	echo json_encode( $return );
}