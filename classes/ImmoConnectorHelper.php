<?php

namespace GloImmoConnector;

class ImmoConnectorHelper extends \Backend {

	protected static $_arrOfferlistType = array(
		'offerlistelement:OfferHouseBuy' => 'houseBuy',
		'offerlistelement:OfferHouseRent' => 'houseRent',
		'offerlistelement:OfferApartmentRent' => 'apartmentRent',
		'offerlistelement:OfferApartmentBuy' => 'apartmentBuy',
		'offerlistelement:OfferInvestment' => 'investment',
		'offerlistelement:OfferLivingBuySite' => 'livingBuySite'
	);

	public static function getObjectType($objElement) {
		
		$arrNamespaces = $objElement->getNamespaces();

		if (array_key_exists('xsi', $arrNamespaces)) {
			$arrAttributes = $objElement->attributes($arrNamespaces['xsi']);
			$strType = (string)$arrAttributes['type'];

			//Prüfen, ob der Typ aus dem API-Result in den Stammdaten vorkommt, wenn nicht -> schreibe ins Log
			if (array_key_exists($strType, self::$_arrOfferlistType)) {
				return self::$_arrOfferlistType[$strType];
			} else {
				\System::log(sprintf("Missing OfferListType '%s'", $strType), 'ImmoConnectorHelper getObjectType()', TL_ERROR);
			}
		}
		return null;
	}

	public function orderObjectsByType($objObjects) {
		$arrObjects = array();

		foreach($objObjects as $objObject) {
			$strType = self::getObjectType($objObject);

			$arrObjects[$strType][] = $objObject;
		}

		return $arrObjects;
	}

	public function purgeExpiredCacheFiles() {

    	//Durchlaufen des Cache-Verzeichnisses
    	foreach (scan(TL_ROOT . ImmoConnector::CACHE_DIRECTORY) as $strFile) {
    		if(is_file($strFile)) {
    			$objFile = new \File($strFile);
    			if(($objFile->ctime + \Config::get('gloImmoConnectorCacheTime') * 100) <= time()) {
    				$objFile->delete();
    				$this->log("Cache-File '" . $strFile . "' was deleted.", __METHOD__, TL_FILES);
    			}
    		}
    	}
    }

    public function purgeCacheFiles() {
    	$objFolder = new \Folder(TL_ROOT . ImmoConnector::CACHE_DIRECTORY);
    	$objFolder->purge();

    	$this->log("Cache-File were deleted.", __METHOD__, TL_FILES);
    }
}