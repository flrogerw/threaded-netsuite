<?php
set_include_path(get_include_path() . PATH_SEPARATOR . '/usr/share/pear/');
include 'Mail.php';
include 'Mail/mime.php' ;



final class Utils_Email{
	
	public static function sendMergeEmail( $sActivaId, $sPosId, array $aEmailData ){
		
		$model = new Utils_Model();
		$sSubject = "Merge Errors for $sActivaId / $sPosId";
		$sReceipients = implode(",", $model->getEmailNotifications( array('admin') ) ); 
		$sFrom = 'MergeError@polaroidfotobar.com';
		$sBody = 'hhhhhhh';
		
		self::sendEmail($sSubject, $sReceipients, $sFrom, $sBody)
	}

	public function sendEmail( $sSubject, $sReceipients, $sFrom, $sBody, $sAttachmentPath = null ){

		$text = strip_tags( $sBody );
		$html = $sBody;

		if( $sAttachmentPath != null ){
			$file = $sAttachmentPath;
		}

		$crlf = "\n";
		$hdrs = array(
				'From'    => $sFrom,
				'Subject' => $sSubject
		);

		$mime = new Mail_mime(array('eol' => $crlf));

		$mime->setTXTBody($text);
		$mime->setHTMLBody($html);
		$mime->addAttachment($file, 'text/plain');

		$body = $mime->get();
		$hdrs = $mime->headers($hdrs);

		$mail =& Mail::factory('mail');
		$mail->send( $sReceipients, $hdrs, $body );
	}
}