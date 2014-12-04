<?php 

class LivePos_Maps_Map {

	protected $_mappedData = array();
	protected $_errors = false;
	protected $_aMapped = array();
	protected $_aData;

	public function __construct() {

	}

	public function hasErrors(){

		$bHasErrors = ( $this->_errors !== false )? true: false;
		return( $bHasErrors );
	}

	public function getErrors(){
		return( $this->_errors );
	}

	protected function _map( array $aRawData = null, array $aMapArray = null ){

		$aData = ( $aRawData == null )? $this->_aData: $aRawData;
		$aReturn = array();
		$iCounter = 0;
			
		foreach( $aData as $sKey=>$mValue ){
				
			switch( true ){

				case( is_array( $mValue && empty( $mValue ) ) ):
				case( $mValue == null ):
					continue;
					break;

				case( is_array( $aData[$sKey] ) ):
					$this->_map( $aData[$sKey], $aMapArray );
					break;

				case( $aMapArray != null && $aMapArray[$sKey] != null ):
					$sParam = $aMapArray[$sKey];
					$aReturn[ $iCounter ][ $sParam ] = $mValue;
					break;

				case( property_exists( $this, $this->_mapArray[$sKey] ) ):
					$sParam = $this->_mapArray[$sKey];
					$this->$sParam = $mValue;
					break;
			}
		}
		$iCounter++;

		return( $aReturn );
	}


	public function getPublicVars( $bFilter = true ){

		$publicVars = create_function('$obj', 'return get_object_vars($obj);');
		$aReturn = ( $bFilter )? array_filter( $publicVars( $this ) ): $publicVars( $this );
		return $aReturn;
	}

	public function getJson(){

		switch( get_class($this) ){

			case('LivePos_Maps_Order'):
				return( json_encode( array('order' => $this->getPublicVars() ) ) );
				break;

			case('LivePos_Maps_Customer'):
				return( json_encode( array('customer' => $this->getPublicVars() ) ) );
				break;

			case('LivePos_Maps_Refund'):
				return( json_encode( array('refund' => $this->getPublicVars() ) ) );
				break;

			default:
				return( json_encode( $this->getPublicVars() ) );
				break;
		}
			
	}
}
