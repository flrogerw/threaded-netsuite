<?php
set_include_path(get_include_path() . PATH_SEPARATOR . '/usr/share/pear/');
include 'Mail.php';
include 'Mail/mime.php' ;



final class Utils_Email{
	
	public static function sendMergeEmail( $sActivaId, $sPosId, array $aEmailData ){
		
		$model = new Utils_Model();
		$sSubject = "Merge Errors for $sActivaId / $sPosId";
		$sReceipients = implode(",", $model->getEmailNotifications( array('admin', 'customer_service') ) ); 
		$sFrom = 'MergeError@polaroidfotobar.com';
		$aSkus = $model->nsIdToSku( $aEmailData );
		$sBody = 'The Following Items Were NOT in the LivePOS Receipt: ' . implode(',', $aSkus );
		
		self::sendEmail($sSubject, $sReceipients, $sFrom, $sBody);
	}
	
	
	public static function sendInventoryEmail( array $aEmailData ){
	
		$model = new Utils_Model();
		$sSubject = "Inventory Update Success";
		$sReceipients = implode(",", $model->getEmailNotifications( array('admin') ) );
		$sFrom = 'InventorySuccess@polaroidfotobar.com';
		$sBody = '';
		
		foreach( $aEmailData as $iLocationId => $aLocationData ){
			$sBody .= "Location: " . $iLocationId . ' / ' . $aLocationData['location_name'] . "<br>";
			$sBody .= "Items Updated: " . $aLocationData['item_count'] . "<br>";
			$sBody .= "Zero Priced Items Skipped: " . implode(', ', $aLocationData['zero_price_items']) . "<br><br>";
		}
	
		self::sendEmail($sSubject, $sReceipients, $sFrom, $sBody);
	}
	
	
	public static function sendInventoryErrorEmail( $sEmailData ){
	
		$model = new Utils_Model();
		$sSubject = "Inventory Update Error";
		$sReceipients = implode(",", $model->getEmailNotifications( array('admin') ) );
		$sFrom = 'InventoryError@polaroidfotobar.com';
		$sBody = $sEmailData;
	
		self::sendEmail($sSubject, $sReceipients, $sFrom, $sBody);
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