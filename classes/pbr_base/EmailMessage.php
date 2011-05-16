<?
/**
 * A class to handle the email functionality.
 * @since	20100722, hafner
 */

require_once( "pbr_base/Captcha.php" );
require_once( "pbr_base/Common.php" ); 
require_once( "pbr_base/FormHandler.php" );
require_once( "phpmailer/class.phpmailer.php" );

class EmailMessage extends PHPMailer
{
	/**
	 * Instance of the Common object.
	 * @var Common
	 */
	protected $m_common;
	
	/**
	 * Instance of the FormHandler object.
	 * @var FormHandler
	 */
	protected $m_form;
	
	/**
	 * Constructs the email object.
	 * @since	20100722, hafner
	 * @return	Email object.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->m_common = new Common();
		$this->m_form = new FormHandler( 1 );	
	}//__construct()
	
	/**
	 * Validates the input from the email form on the contact page.
	 * Returns a "^" delimited string success boolean^message^( "_" delimited field names string ) 
	 * @since	2010722, hafner
	 * @return 	string
	 */
	public function validateEmailForm( $input )
	{
		$fields = array();
		
		if( strlen( trim( $input['contact_email'] ) ) == 0 || 
			strtolower( trim( $input['contact_email'] ) ) == "your email" )
		{
			$this->m_form->m_error ="You must provide an email address.";
		}
		
		if( !$this->m_form->m_error )
		{
			if( !isset( $input['contact_message'] ) || 
				strlen( $input['contact_message'] ) == 0 ||
				strtolower( trim( $input['contact_message'] ) ) == "a love note." )
			{
				$this->m_form->m_error = "Please send some unique love.";
			}
		}
		
		$this->validateEmailAddress( $input['contact_email'] );
		
		return $this->m_form->m_error;
		
	}//validateEmailForm()
	
	/**
	 * Validates the authenticity of an email address.
	 * Returns TRUE if valid, FALSE otherwise.
	 * @since	20100909, Hafner
	 * @return	boolean
	 * @param 	string			$email			email address to validate
	 */
	public function validateEmailAddress( $email )
	{
		if( !$this->m_form->m_error )
		{
			$email = strtolower( trim( $email ) );
			
			if( strpos( $email, "@" ) === FALSE || 
				strpos( $email, "." ) === FALSE ||
				strpos( $email, " " ) !== FALSE ||
				strpos( $email, "," ) !== FALSE )
			{
				$this->m_form->m_error = "You must provide a valid email address.";
			}
		}
		
		return $this->m_form->m_error;
		
	}//validateEmailAddress()
	
	/**
	 * Updates the mail to address for the current server.
	 * Returns TRUE always.
	 * @since	20100909, Hafner
	 * @return	boolean
	 * @param 	string			$email			email address
	 */
	public function modifyMailTo( $email )
	{
		$sql = "
		UPDATE common_EnvVars
		SET content = '" . $email . "'
		WHERE title = '" . strtolower( $this->m_common->m_env ) . "_mail_to'";
		
		$this->m_common->m_db->query( $sql, __FILE__, __LINE__ );
		
		return TRUE;
		
	}//modifyMailTo()
	
	
	/**
	 * Sends out an email from the contact page.
	 * @since	20100722, hafner
	 * @return	boolean
	 * @param	array		$input			array of subject, body and from address
	 */
	public function sendMail( $input )
	{
		$this->From = $input['contact_email'];
		$this->Sender = $input['contact_email'];
		$this->FromName = $input['contact_name'];
		$this->Subject = "Photographybyrebekah.com - Message";
		$this->Body = $input['contact_message'];
		$this->AddAddress( "colehafner@gmail.com", "cole hafner" );
		
		//send email
		if( !$this->Send() )
		{
			throw new Exception( "Error: Email did not send" );
		}
		
		/*
		$boundary = date( "YmdHis" );

		//headers
		$headers = "From: " . $input['contact_email'] . "<" . $input['contact_email'] . ">\n";
		$headers .= "MIME-Version: 1.0\n";
		//tell mail program it's multipart/mixed
		$headers .= "Content-Type: multipart/alternative; ";
		//tell mail program what boundary looks like
		$headers .= "boundary=\"" . $boundary . "\"";
		
		//message
		$message = '
		--' . $boundary . '
		Content-Type: text/plain; charset="iso-8859-1"
		Content-Transfer-Encoding: 7bit
		
		' . strip_tags( $input['body'] ) . '
		--' . $boundary . '
		Content-Type: multipart/related; boundary="' . $boundary . '2"
		--' . $boundary . '2
		Content-Type: text/html; charset="iso-8859-1"
		Content-Transfer-Encoding: 7bit
		' . $input['contact_message'] . '
		
		
		From: ' . $input['contact_name'];
		
		$message .= '		
		--' . $boundary . '2--
		--' . $boundary . '--';
				
		//send email
		mail( $this->getMailTo(), "Photography By Rebekah Message", $message, $headers, "-f" . $input['contact_email'] );
		return TRUE;
		*/
		
	}//sendMail()
	
	public function getMailTo()
	{
		return "colehafner@gmail.com";
		
		$sql = "
		SELECT
			content AS content
		FROM 
			common_EnvVars
		WHERE
			active = 1 AND
			LOWER( title ) = '" . strtolower( $this->m_common->m_env ) . "_mail_to'";
				
		$records = $this->m_common->m_db->doQuery( $sql );
		
		if( !is_array( $records ) )
		{
			throw new exception( "Error: could not find '" . strtolower( $this->m_common->m_env ) . "_mail_to' in common_EnvVars" );
		}
		
		return $records[0]['content'];
		
	}//getMailTo()
	
	public function getHtml( $cmd, $vars = array() )
	{
		switch( strtolower( $cmd ) )
		{
			case "edit_mail_to_form":
				$return = array(
					'title' => '',
					'body' => '
					<div style="margin:auto;" id="result" class="result" style="margin-top:30px;"></div>
					
					<p style="text-align:center;">
						Current Address:
						&nbsp;
						<input type="text" name="mail_to" id="mail_to" value="' . $this->getMailTo() . '" class="text_input">
						<br/><br/>
						<a href="#" id="alter_mail_to">
							<img src="/images/btn_save.gif"/>
						</a>
					</p>'
				);
				break;
				
			default:
				throw new Exception( "Error: Command '" . $cmd . "' is invalid." );
				break;
		}
		
		return $return;
		
	}//getHtml()
	
}//class EmailMessage
?>