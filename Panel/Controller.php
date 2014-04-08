<?php

/**
 *
 * @author gWilli
 *
 */
class Panel_Controller {

	protected $_model;

	public function __construct( $params ){
		$this->params = $params;
		$this->_model = new Panel_Model();
		$this->view = new Panel_View();
	}

	public function indexAction(){

		$this->view->aOrders = $this->_model->getProcessLogView();
		$this->view->show(__FUNCTION__);
	}
	
	public function orderqueueAction(){
	
		$this->view->aOrders = $this->_model->getOrderQueueView();
		$this->view->show(__FUNCTION__);
	}

	public function nstestAction( $aRecord = null ){
			
		require_once( '../Map.php' );
		$bIsCurrentCustomer = false;

		if( $aRecord == null ){
			require_once( '../SampleOrder.php' );
		} else {
			$aSalesOrder = json_decode($aRecord[0]['order_json'], true);
			$aCustomer = json_decode($aRecord[0]['customer_json'], true);
				
			if( !is_array( $aCustomer ) ){
				$bIsCurrentCustomer = true;
			}
				
			
			$aItems = $aSalesOrder['item'];
			unset( $aSalesOrder['item'] );
			$aOrder = $aSalesOrder;
			var_dump($aOrder);
			$aAddressBook = $aSalesOrder['addressbook'];
		}


		$dom = new DomDocument();
		$dom->formatOutput = true;

		$resultsDiv = $dom->createElement( 'div');
		$resultsDiv->setAttribute( 'class', 'results' );

		$success = $dom->createElement( 'div', 'Success');
		$success->setAttribute( 'name', 'success' );
		$success->setAttribute( 'class', 'success result_div' );


		$jsonDiv = $dom->createElement( 'div');
		$jsonDiv->setAttribute( 'class', 'result_div' );
		$jsonDiv->setAttribute( 'name', 'json' );

		$resultsDiv->appendChild( $success );
		$resultsDiv->appendChild( $jsonDiv );

		$warn = $dom->createElement( 'div');
		$warn->setAttribute( 'name', 'warn' );
		$warn->setAttribute( 'class', 'warn result_div' );
		$resultsDiv->appendChild( $warn );

		$error = $dom->createElement( 'div');
		$error->setAttribute( 'name', 'error' );
		$error->setAttribute( 'class', 'error result_div' );
		$resultsDiv->appendChild( $error );

		$systemError = clone $error;
		$systemError->setAttribute('id', 'system_errors');
		$dom->appendChild( $systemError );

		$customer = $dom->createElement( 'div');
		$customer->setAttribute( 'id', 'customer' );
		$customer->setAttribute( 'name', 'customer' );
		$customer->setAttribute( 'class', 'wrapper' );

		// Activa Divs
		$h1 = $dom->createElement('h2', 'Activa Customer / Contact');
		$customer->appendChild( $h1 );
		$collapse = $dom->createElement('a');
		$collapse->setAttribute('class', 'collapse_link right');
		$img = $dom->createElement('img');
		$img->setAttribute( 'src', '/Threaded/Panel/public/images/toggle.png' );
		$collapse->appendChild($img);
		$customer->appendChild( $collapse );
		$customer->appendChild( $resultsDiv );

		$order = $dom->createElement( 'div');
		$order->setAttribute( 'id', 'order' );
		$order->setAttribute( 'name', 'order' );
		$order->setAttribute( 'class', 'wrapper' );
		$h1 = $dom->createElement('h2', 'Activa Order');
		$order->appendChild( $h1 );
		$order->appendChild( clone $resultsDiv );

		$addr = $dom->createElement( 'div');
		$addr->setAttribute( 'id', 'addressbook' );
		$addr->setAttribute( 'name', 'addressbook' );
		$addr->setAttribute( 'class', 'wrapper' );

		$item = $dom->createElement( 'div');
		$item->setAttribute( 'id', 'items' );
		$item->setAttribute( 'name', 'items' );
		$item->setAttribute( 'class', 'wrapper' );

		// Build Order and Customer
		foreach( $aMap as $key=>$value ) {

			switch( true ){

				case( in_array( $key, $aCustomerMap ) ):
					$this->showElement( $dom, $customer, $aCustomer, $key, $value );
					break;

				case( in_array($key,$aOrderMap) ):
					$this->showElement( $dom, $order, $aOrder, $key, $value );
					break;

				default:
					continue;
					break;

			}
		}

		// Build Address Book
		if( !$bIsCurrentCustomer ){
			foreach( $aAddressBook as $sKey=>$value ) {

				$addressDiv = $dom->createElement('div');
				$addressDiv->setAttribute( 'class', 'wrapper' );
				$addressDiv->setAttribute( 'name', 'address' );
				$addressDiv->appendChild($dom->createElement('h4', ucfirst($sKey) ) );

				foreach( $value as $key2=>$value2 ) {
					foreach( array_keys($aMap2, $key2) as $sHeading ){
						if( strripos( $sHeading, $sKey ) !== false ) {
							$this->showElement( $dom, $addressDiv, $aAddressBook[$sKey], $sHeading, $key2, $sKey );
						}
					}
				}
				$addr->appendChild($addressDiv);
			}
		}

		// Build Item List
		foreach( $aItems as $iKey=>$aItem ) {
			$ns = 'x'. rand();

			$itemDiv = $dom->createElement('div');
			$itemDiv->setAttribute( 'class', 'item_wrapper' );
			$itemDiv->setAttribute( 'name', 'item' );

			$itemDiv->appendChild($dom->createElement('h4', 'Item: ' . ($iKey+1 ) ));

			foreach( $aItem as $sParam=>$mValue ) {

				$sHeading = ( strlen(array_search($sParam, $aMap3 ) ) < 1  )? $sParam: array_search($sParam, $aMap3);

				$this->showElement( $dom, $itemDiv, $aItem, $sHeading, $sParam, $ns );
			}

			$anchor = $dom->createElement('a', 'REMOVE ITEM');
			$anchor->setAttribute('class', 'remove_item');
			$anchor->setAttribute('href', '#');
			$itemDiv->appendChild( $anchor );

			$item->appendChild($itemDiv);

		}


		$outer = $dom->createElement('div');
		$outer->setAttribute('class', 'outer_wrapper');

		if( $bIsCurrentCustomer ){
			$customer = $dom->createElement( 'div');
			$customer->setAttribute( 'id', 'customer' );
			$customer->setAttribute( 'name', 'customer' );
			$customer->setAttribute( 'class', 'wrapper' );
			$h1 = $dom->createElement('h2', 'Activa Customer / Contact');
			$customer->appendChild( $h1 );
			$clear = $dom->createElement( 'div');
			//$clear->setAttribute('class', 'clear');
			$customer->appendChild( $clear );
			$text = $dom->createTextNode($aRecord[0]['customer_json']);
			$customer->appendChild( $text );
			$outer->appendChild( $customer );
			
			
		}else{
			$outer->appendChild( $customer );
			$outer->appendChild( $addr );
		}
		$dom->appendChild( $outer);

		$outer = $dom->createElement('div');
		$outer->setAttribute('class', 'outer_wrapper');
		$outer->appendChild( $order );
		$outer->appendChild( $item );
		$dom->appendChild( $outer);

		$button = $dom->createElement( 'button','Submit Sales Order' );
		$button->setAttribute( 'id', 'submit_order' );



		$clear = $dom->createElement( 'div');
		$clear->setAttribute('class', 'clear');

		$label = $dom->createElement( 'label', 'Send to Netsuite');
		$label->setAttribute( 'for', 'send_netsuite' );
		$label->setAttribute( 'style', 'display:inline' );
		$cbox = $dom->createElement('input');
		$cbox->setAttribute('id', 'send_netsuite');
		$cbox->setAttribute('name', 'send_netsuite');
		$cbox->setAttribute('type', 'checkbox');

		$clear->appendChild($label);
		$clear->appendChild($cbox);

		$clear->appendChild($button);



		$button = $dom->createElement( 'button','Add New Item' );
		$button->setAttribute( 'id', 'add_item' );
		$button->setAttribute( 'style', 'clear:both' );
		$clear->appendChild($button);

		$button = $dom->createElement( 'button','Show JSON' );
		$button->setAttribute( 'name', 'show_json' );
		$clear->appendChild( $button );

		$threadStatus = $dom->createElement( 'div', 'NETSUITE SERVER STATUS: ');
		$threadStatus->setAttribute( 'id', 'thread_staus' );
		$span = $dom->createElement( 'span' );
		$span->setAttribute( 'id', 'thread_time' );
		//$span->setAttribute( 'style', 'float:right' );
		$threadStatus->appendChild( $span );


		$button = $dom->createElement( 'button','Server Status' );
		$button->setAttribute( 'id', 'server_status_button' );
		$threadStatus->appendChild( $button );
		$clear->appendChild( $threadStatus );

		$form = $dom->createElement('form');
		$form->setAttribute('id', 'csv_upload');
		$form->setAttribute('method', 'post');
		$form->setAttribute('enctype', 'multipart/form-data');
		$form->setAttribute('action', '/Threaded/Panel/postcsv');
		$label = $dom->createElement('label', 'Filename:');
		$label->setAttribute('for', 'file');
		$form->appendChild( $label );
		$file = $dom->createElement('input');
		$file->setAttribute('type', 'file');
		$file->setAttribute('name', 'file');
		$file->setAttribute('id', 'file');
		$file->setAttribute('accept', '.csv,text/csv');
		$form->appendChild( $file );
		$button = $dom->createElement( 'button','Upload File' );
		$button->setAttribute( 'id', 'order_file_submit' );
		$form->appendChild( $button );
		$clear->appendChild( $form );

		$error = $dom->createElement( 'div');
		$error->setAttribute( 'id', 'system_error' );
		$error->setAttribute( 'style', 'display:none' );
		$error->setAttribute( 'class', 'system_error' );
		$clear->appendChild( $error );

		$dom->appendChild( $clear );

		$this->view->html = $dom->saveHTML();
		$this->view->show(__FUNCTION__);
	}


	public function viewrecordAction(){

		//$this->view->aOrder = $this->_model->getOrderInfo( $this->params['q']);
		$this->nstestAction( $this->_model->getOrderInfo( $this->params['q']) );
		//$this->view->show(__FUNCTION__);
	}

	public function postcsvformAction(){
		$this->view->show(__FUNCTION__);
	}

	public function postorderAction(){

		$aSalesOrder = $_POST['data'];
		//var_dump($aSalesOrder);

		$aJsonReturn = array(
				'system' => array( 'error' => null),
				'order' => array('netsuite' => array( 'error' => null )),
				'customer' => array('netsuite' => array( 'error' => null ))
		);

		//var_dump($aSalesOrder);
		$this->_replaceBool($aSalesOrder);
		//var_dump($aSalesOrder);
		//die();

		$aSalesOrder['customer']['_source'] = $aSalesOrder['order']['_source'];

		echo( json_encode($aSalesOrder));

		//$this->_dbInsert(  $aSalesOrder['customer']['custentity_customer_source_id'], $this->_encrypt( json_encode( $aSalesOrder ) ) );
	}

	public function postcsvAction(){

		if ($_FILES["file"]["error"] > 0)
		{
			echo "Error: " . $_FILES["file"]["error"] . "<br>";
			die();
		}
		// Universal Mapping of Arrays
		require_once( '../Map.php' );

		try{

			$aSalesOrder = array();
			$iItem = 0;
			$bFirstRecord = false;
			$sCurrentOrder = null;

			$row = 1;
			if (($handle = fopen( $_FILES["file"]["tmp_name"], "r")) !== FALSE) {
				while (($aRecord = fgetcsv($handle, 0, "\t")) !== FALSE) {

					if( $row == 1 ){
						$aHeadings = $aRecord;
						$row++;
						continue;
					}

					if( $aRecord[1] != $sCurrentOrder ){
						$bFirstRecord = true;
						$sCurrentOrder = $aRecord[1];
							
					} else {
						$bFirstRecord = false;
						$iItem += 1;
					}

					// Replace Yes and Nos with True / False
					foreach( $aRecord as $iKey => $sColumn ){

						$sHeader = str_replace(' ', '', $aHeadings[$iKey]);
							
						switch( true ){
							case( $sColumn == 'No' ):
								$sColumn = false;
								break;
							case( $sColumn == 'Yes' ):
								$sColumn = true;
								break;
							case( is_numeric( $sColumn ) ):
								$sColumn = floatval( $sColumn );
									
								break;
						}

						// If no match in mapping, skip
						if( !isset( $aMap[$sHeader] ) || $sColumn === '' ){
							//echo( $aHeadings[$iKey] . " has no Mapping\n" );
							continue;
						}
							
						switch ( true ){

							case( in_array($sHeader, $aItemMap ) ):
									
								$aSalesOrder['order']['item'][$iItem][ $aMap[$sHeader] ] = $sColumn;
								break;
									
							case( in_array($sHeader,  $aAddressMap ) ):
								if( $bFirstRecord ){
									$sType = ( stripos( $sHeader, 'Shipping' ) === false )? 'billing': 'shipping' ;
									$aSalesOrder['customer']['addressbook'][$sType][ $aMap[$sHeader] ] = $sColumn;
								}
								break;
									
							case( in_array($sHeader,  $aCustomerMap ) ):
								if( $bFirstRecord ){
									if($aMap[$sHeader] == 'isperson'){
										$sColumn = ( $sColumn == 'business' )? false: true;
									}
									$aSalesOrder['customer'][ $aMap[$sHeader] ] = $sColumn;
								}
								break;
									
							case( in_array($sHeader,  $aOrderMap ) ):
								$aSalesOrder['order'][ $aMap[$sHeader] ] = $sColumn;
								break;
						}
					}
				}
					
			}
			// Set Some Last Minute Things
			$aSalesOrder['customer']['_source'] =  $aSalesOrder['order']['_source'];
			$aSalesOrder['order']['ccnumber'] = str_replace("'", '', $aSalesOrder['order']['ccnumber'] );
			$aSalesOrder['order']['pnrefnum'] = str_replace("'", '', $aSalesOrder['order']['pnrefnum'] );

			//$oCustomer = new Netsuite_Record_Customer($aSalesOrder['customer']);
			//$oOrder = new Netsuite_Record_SalesOrder($aSalesOrder['order'], $oCustomer );

			$this->_replaceBool($aSalesOrder);
			echo( json_encode( $aSalesOrder ) );


		} catch( Exception $e ){
			var_dump($e);
		}
			
	}

	private function _replaceBool( &$aArray ){

		$aIsBoolean = array(
				'isperson',
				'custcol_produce_in_store',
				'custcol_store_pickup',
				'ismultiship',
				'_netsuite',
				'istaxable'
		);

		foreach( $aArray as $key=> &$data ){
			if( is_array( $data ) ){
				$this->_replaceBool($data);
			}else{

				if( in_array( $key, $aIsBoolean ) ){
					$aArray[$key] = ( $data == 'Yes' || $data == 'true' )? 1: 0;
				}
			}

		}
	}

	private function _dbInsert( $sActivaId, $sJson ){

		try {

			$dsn = sprintf('mysql:host=%s;dbname=%s', SYSTEM_DB_HOST, SYSTEM_DB_DATABASE);
			$pdo = new PDO( $dsn, SYSTEM_DB_USER, SYSTEM_DB_PASS);
			//$pdo = new PDO('mysql:host=fotobar.c8nypmct6r9k.us-east-1.rds.amazonaws.com;dbname=netsuite_xref', 'fotobar', 'd7sWxtrd3xTyxGa6' );
			$stmt = $pdo->prepare('INSERT INTO fotobar_order_queue (customer_activa_id, order_json) VALUES(:customer_activa_id,:order_json)');
			$stmt->execute( array( ':customer_activa_id' => $sActivaId, ':order_json' => $sJson ) );

		} catch(PDOException $e) {
			echo 'Error: ' . $e->getMessage();
		}
	}

	private function _encrypt( $sData ){

		$td = mcrypt_module_open('rijndael-128', '', 'ecb', '');
		$iv = mcrypt_create_iv( mcrypt_enc_get_iv_size( $td ), MCRYPT_RAND );
		$ks = mcrypt_enc_get_key_size( $td );
		$key = substr( md5( SECRET_KEY ), 0, $ks );
		mcrypt_generic_init( $td, $key, $iv );
		$encrypted = mcrypt_generic( $td, $sData );
		mcrypt_generic_deinit( $td );
		mcrypt_module_close( $td );

		return( base64_encode( $encrypted ) );
	}

	function showElement($dom, $currentDiv, $sMapArray, $key, $value, $ns = null ) {

		$firstOption = $dom->createElement( 'option', 'Select One' );
		$firstOption->setAttribute( 'value', '' );

		$aSpecialOptions = array(
				'_paymentmethod_flag' => array(
						'creditcard' => 'creditcard',
						'pos' => 'pos',
						//'cash' => 'cash',
						//'wire' => 'wire',
						//'check' => 'check'
				),
				'isperson' => array( 'company' => 0, 'individual' => 1 ),
				'shipmethod' => array(
						'CPU' => 'CPU',
						'U2A' => 'U2A',
						'UGC' => 'UGC',
						'UGR' => 'UGR',
						'UPS' => 'UPS',
						'UNS' => 'UNS',
						'STR' => 'STR',
						'FAH' => 'FAH',
						'AIR' => 'AIR'));

		// Elements looked up in the Xref Table
		$aXref = array(
				'paymentmethod' => 'PaymentMethod',
				'shipmethod' => 'ShippingMethod'
				//'item' => 'Item'

		);

		$div = $dom->createElement( 'div' );
		$div->setAttribute( 'class', 'element_div left' );


		$label = $dom->createElement( 'label', $key . ': ' );
		$label->setAttribute( 'for', $value );

		$sTitle = ( $value[0] != '_')?'internal_id: ': 'system_id: ';
		$label->setAttribute( 'title', $sTitle . $value );

		$div->appendChild( $label );


		switch( true ){

			case( $value == 'item'):

				$input = $dom->createElement( 'select' );
				$input->setAttribute( 'id', $value );
				$input->setAttribute( 'name', $value );
				$input->setAttribute( 'ns', 'order' );
				$input->appendChild( clone $firstOption );

				foreach( $this->_model->getProducts() as $aRow) {
					$option = $dom->createElement( 'option', $aRow['activa_id'] );
					$option->setAttribute( 'value', $aRow['activa_id'] );
					$option->setAttribute( 'price', $aRow['price'] );
					$option->setAttribute( 'description', $aRow['description'] );

					if( strtolower($aRow['activa_id']) ==  strtolower( $sMapArray[ $value ] ) ){
						$option->setAttribute( 'selected', '' );
					}

					$input->appendChild($option);
				}

				break;


			case( $value == '_source'):

				$input = $dom->createElement( 'select' );
				$input->setAttribute( 'id', $value );
				$input->setAttribute( 'name', $value );
				$input->setAttribute( 'ns', 'order' );
				$input->appendChild( clone $firstOption );

				foreach( $this->_model->getActivaSources() as $aRow) {
					$option = $dom->createElement( 'option', $aRow['activa_source'] );
					$option->setAttribute( 'value', $aRow['activa_source'] );

					if( strtolower($aRow['activa_source']) ==  strtolower( $sMapArray[ $value ] ) ){
						$option->setAttribute( 'selected', '' );
					}

					$input->appendChild($option);
				}

				break;

			case( in_array(  $value, array_keys( $aSpecialOptions ), true ) ):

				$input = $dom->createElement( 'select' );
				$input->setAttribute( 'id', $value );
				$input->setAttribute( 'name', $value );
				$input->setAttribute( 'ns', $ns );
				$input->appendChild( clone $firstOption );

				foreach( $aSpecialOptions[$value] as $sDisplayName => $sOptionValue ){
					$option = $dom->createElement( 'option', $sDisplayName );
					$option->setAttribute( 'value', $sOptionValue );

					if( $sOptionValue == $sMapArray[ $value ] ){
						$option->setAttribute( 'selected', '' );
					}
					$input->appendChild($option);
				}


				break;

			case( is_bool( $sMapArray[ $value ]  ) ):
				$input = $dom->createElement( 'select' );
				$input->setAttribute( 'id', $value );
				$input->setAttribute( 'name', $value );
				$input->setAttribute( 'ns', $ns );
				$input->appendChild( clone $firstOption );

				$true = $dom->createElement( 'option', 'true' );
				$true->setAttribute( 'value', 1 );

				$false = $dom->createElement( 'option', 'false' );
				$false->setAttribute( 'value', 0 );

				if( $sMapArray[ $value ] === true ){
					$true->setAttribute( 'selected', '' );
				} else {
					$false->setAttribute( 'selected', '');
				}
				$input->appendChild($false);
				$input->appendChild($true);

				break;

			case( in_array(  $value, array_keys( $aXref ) ) ):

				$input = $dom->createElement( 'select' );
				$input->setAttribute( 'id', $value );
				$input->setAttribute( 'name', $value );
				$input->setAttribute( 'ns', $ns );
				$input->appendChild( clone $firstOption );

				foreach( $this->_model->getAll( $aXref[ $value ] ) as $aRow ) {
					$option = $dom->createElement( 'option', $aRow['XrefValue'] );
					$option->setAttribute( 'value', $aRow['XrefValue'] );

					if( strtolower($aRow['XrefValue']) == strtolower($sMapArray[ $value ])  ) {
						$option->setAttribute( 'selected', '' );
					}
					$input->appendChild($option);
				}
				break;

			default:
				$input = $dom->createElement( 'input' );
				$input->setAttribute( 'type', 'text' );
				$input->setAttribute( 'id', $value );
				$input->setAttribute( 'name', $value );
				$input->setAttribute( 'ns', $ns );
				$input->setAttribute( 'value', $sMapArray[ $value ] );
				break;
		}
		$div->appendChild( $input );
		$currentDiv->appendChild( $div );

	}

}

