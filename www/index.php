<?
//start session
session_start();

//include files
require_once( 'pbr_base/Layout.php' );
require_once( 'pbr_base/Authentication.php' );

//setup layout class
$layout = new Layout( $_GET );
$auth = new Authentication( 0 );

//setup controller view
$_GET['session'] = $_SESSION;
require_once( "pbr_controllers/" . $layout->m_active_view . ".php" );
$controller = new $layout->m_active_view( $_GET );
$login_html = '';

//show page
echo $layout->getHtmlHeadSection();
echo $layout->getHtmlBodySection();
echo $auth->controlPageAccess( $controller );

//get login string
if( $controller->hasValidAuthLogin() )
{
	$login_string_html = $controller->getLoginString();
	$login_html = $login_string_html['body'];
}

//close page
echo $layout->getHtmlFooterSection( $login_html );
echo $layout->getClosingTags();
?>