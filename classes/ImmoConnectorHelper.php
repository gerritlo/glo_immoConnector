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

    public static function orderObjectsByType($objObjects) {
            $arrObjects = array();

            foreach($objObjects as $objObject) {
                    $strType = self::getObjectType($objObject);

                    $arrObjects[$strType][] = $objObject;
            }

            return $arrObjects;
    }

    public function purgeExpiredCacheFiles() {
        $strFolder = TL_ROOT . '/' . ImmoConnector::CACHE_DIRECTORY;
        
        //Ist der Ordner nicht vorhanden, gibt es nichts zu löschen
        if(!is_dir($strFolder)) {
            return true;
        }

    	//Durchlaufen des Cache-Verzeichnisses
    	foreach(scan($strFolder) as $strFile) {
                if(is_file($strFolder.$strFile)) {
                    $objFile = new \File(ImmoConnector::CACHE_DIRECTORY . $strFile);
                    
                    if(($objFile->ctime + \Config::get('gloImmoConnectorCacheTime')) < time()) {
                        $objFile->delete();
                        $this->log("Cache-File '" . $strFile . "' was deleted.", __METHOD__, TL_FILES);
                    } 
                }else {
                        var_dump($strFile);
                    }
    		
                
    	}
    }

    public function purgeCacheFiles() {
    	$objFolder = new \Folder(TL_ROOT . ImmoConnector::CACHE_DIRECTORY);
    	$objFolder->purge();

    	$this->log("Cache-File were deleted.", __METHOD__, TL_FILES);
    }
}