<?php

class OrderJSON {
	public static function convert( array $aOutput ) {
		require_once( APPLICATION_DIR . 'Map.php' );

		try{

			$aHeadings = explode( "\t", $aOutput[0] );
			unset( $aOutput[0] );

			$aSalesOrder = array();
			$iItem = 0;
			$bFirstRecord = false;
			$sCurrentOrder = null;

			foreach( $aOutput as $iRecordId => $sRecord ){

				$aRecord = explode( "\t",  $sRecord );

				if( $aRecord[1] != $sCurrentOrder ){
					$bFirstRecord = true;
					$sCurrentOrder = $aRecord[1];

				} else {
					$bFirstRecord = false;
					$iItem += 1;
				}

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


					if( !isset( $aMap[$sHeader] ) || $sColumn === '' ){

						//echo( $aHeadings[$iKey] . " has no Mapping\n" );
						continue;
					}


					switch ( true ){

						case( in_array($sHeader, $aItemMap  ) ):

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

			// Set Some Last Minute Things

			$aSalesOrder['customer']['_source'] =  $aSalesOrder['order']['_source'];
			$aSalesOrder['order']['ccnumber'] = substr($aSalesOrder['order']['ccnumber'], 1);
			$aSalesOrder['order']['pnrefnum'] = substr($aSalesOrder['order']['pnrefnum'], 1);

			return( json_encode( $aSalesOrder ) );

		} catch( Exception $e ){
			var_dump($e);
		}
	}

}