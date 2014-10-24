<?php 

class LivePos_Maps_Map {

	protected $_mappedData;
	protected $_errors = false;
	protected $_aMapped = array();

	public function __construct() {

	}

	public function hasErrors(){

		$bHasErrors = ( $this->_errors !== false )? true: false;
		return( $bHasErrors );
	}

	public function getErrors(){
		return( $this->_errors );
	}

	protected function _map( array $aRawData = null ){

		$aRawData = ( $aRawData == null )? $this->_aData: $aRawData;

		foreach( $aRawData as $aData ){

			$aMap = array();

			foreach( $aData as $sKey=>$mValue ){
					
				//echo( "KEY: $sKey => $mValue\n" );
				switch( true ){

					case( is_array( $mValue && empty( $mValue ) ) ):
					case( $mValue == null ):
						continue;
						break;

					case( is_array( $aData[$sKey] ) ):
						$this->_map( $aData[$sKey] );
						break;

					case( property_exists( $this, $this->_mapArray[$sKey] ) ):
						$sParam = $this->_mapArray[$sKey];
						$this->$sParam = $mValue;
						break;
				}
			}
		}
	}
	
	
	public function getPublicVars(){

		$publicVars = create_function('$obj', 'return get_object_vars($obj);');
		return array_filter($publicVars($this));
		//return ($publicVars($this));
	}

	public function getJson(){

		switch( get_class($this) ){

			case('LivePos_Maps_Order'):
				return( json_encode( array('order' => $this->getPublicVars() ) ) );
				break;

			case('LivePos_Maps_Customer'):
				return( json_encode( array('customer' => $this->getPublicVars() ) ) );
				break;

			default:
				return( json_encode( $this->getPublicVars() ) );
				break;
		}
			
	}
}
