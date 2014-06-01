<?php

namespace GloImmoConnector;

class ImmoConnectorHelper {

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

	public static function orderObjectsByType($objObjects) {
		$arrObjects = array();

		foreach($objObjects as $objObject) {
			$strType = self::getObjectType($objObject);

			$arrObjects[$strType][] = $objObject;
		}

		return $arrObjects;
	}
}