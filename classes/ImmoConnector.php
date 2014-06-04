<?php

namespace GloImmoConnector;

class ImmoConnector extends \Backend {

    const ALL_USER_OBJECTS = 'allUserObjects';
    const CACHE_DIRECTORY = 'system/cache/immoConnector/';

    const OFFER_LIST_TYPES = array(
            'offerlistelement:OfferHouseBuy' => 'houseBuy',
            'offerlistelement:OfferHouseRent' => 'houseRent',
            'offerlistelement:OfferApartmentRent' => 'apartmentRent',
            'offerlistelement:OfferApartmentBuy' => 'apartmentBuy',
            'offerlistelement:OfferInvestment' => 'investment',
            'offerlistelement:OfferLivingBuySite' => 'livingBuySite'
    );

    const REALESTATE_TYPES = array(
    		'houseBuy',
            'houseRent',
            'apartmentRent',
            'apartmentBuy',
            'livingBuySite',
            'investment'
    	);

    protected $_objImmocaster = null;

    public function __construct($strInstance, $strKey, $strSecret, $strReqquestUrl = 'live', $strReadingType = 'curl') {
            $immocaster = \Immocaster_Sdk::getInstance($strInstance, $strKey, $strSecret);
            $immocaster->setRequestUrl($strReqquestUrl);
            $immocaster->setReadingType($strReadingType);
            //$immocaster->setContentResultType('json');
            $immocaster->setDataStorage(
                    array(
                            'mysql', //\Config::get('dbDriver'),
                            \Config::get('dbHost'),
                            \Config::get('dbUser'),
                            \Config::get('dbPass'),
                            \Config::get('dbDatabase'),
                    ),
                    'Immocaster',
                    'tl_ic_auth'
            );

            $this->_objImmocaster = $immocaster;
    }

    public function getAllUserObjects($objUser) {

        $strUser = $objUser->ic_username;
                
        $objFirstPage = null;
        $intMaxPage = 0;
        $strDocument = ALL_USER_OBJECTS . '_' . $strUser;

        //Prüfe, ob das benötigte XML-Dokument im Cache vorliegt
        if ($this->isDocumentCached($strDocument) && \Config::get('gloImmoConnectorCacheActive') == '1') {
        	//Lade den Cache in die FirstPage
        	$objFirstPage = $this->getCachedXmlDocument($strDocument);
                $this->log("ImmoConnector: Cache-File loaded", __METHOD__, TL_FILES);
        } else {
        	$intPage = 1;

        	//Dokument von API laden
        	do {
                    //XML-Request an Server senden
                    $objPage = $this->requestAllUserObjects($intPage, $strUser);

                    //Maximale Anzahl an Seiten laden
                    if ($intMaxPage <= 0) {
                        $intMaxPage = $objPage->getElementsByTagName('numberOfPages')->item(0)->firstChild->nodeValue;
                    }

                    //Wenn erste Seite, als Basis ablegen, sonst Elemente hinzufügen
                    if (is_null($objFirstPage)) {
                         $objFirstPage = $this->orderDomDocumentByObjectType($objPage);
                    } else {
                        $this->mergeXmlPages($objFirstPage, $objPage);
                    }

                } while ($intMaxPage > $intPage++);
                
                $this->log("ImmoConnector: API was requested", __METHOD__, TL_FILES);

                //Geladene Daten in den Cache schreiben
                $this->cacheXmlDocument($objFirstPage, $strDocument);
        }
        
        //Kombinierte XML zurückgeben
		return $objFirstPage;
	}
        
    protected function requestAllUserObjects($intPage, $strUser) {
        $objRes = new \DOMDocument();
        $objRes->loadXml($this->_objImmocaster->fullUserSearch(array('username' => $strUser, 'pagenumber' => $intPage, 'pagesize' => 100)));
        
        return $objRes;
    }

    protected function mergeXmlPages(&$objFirstPage, &$objPage) {
    	//Fügt die realEstateElement-Knoten der FirstPage hinzu

    	$objNodeList = $objPage->getElementsByTagName('realEstateElement');

    	foreach ($objNodeList as $objNode) {
    		$strType = $this->getObjectType($objNode);
    		$objTypeElement = $objFirstPage->getElementById('tl_' . $strType);
    		if($objTypeElement == null) {
    			$objTypeElement = $this->createNewTypeElement($objFirstPage, $strType);
    		}
            $objNewNode = $objFirstPage->importNode($objNode, true);
            $objTypeElement->appendChild($objNewNode);
    	}
    }

    protected function getCachedXmlDocument($strDocument) {

    	$strFullPath = $this->buildCacheFileName($strDocument);
    	if(file_exists($strFullPath)) {
            $objDocument = new \DOMDocument();
            $objDocument->load($strFullPath);
            return $objDocument;
    	}
    	
    	return null;
    }

    protected function isDocumentCached($strDocument) {

    	//Delete old Cache-Files
        $objHelper = new ImmoConnectorHelper();
    	$objHelper->purgeExpiredCacheFiles();

    	$strFullFilename = $this->buildCacheFileName($strDocument);
    	
    	//Prüfen, ob die Datei existiert/gültig ist bzw. der Cache aktiv ist.
    	if((file_exists($strFullFilename))) {
    		return true;
    	}
    	return false;
    }

    protected function cacheXmlDocument($objXml, $strDocument) {
        $strFilename = $this->buildCacheFileName($strDocument);
        if(!is_dir(dirname($strFilename))) {
            $objFolder = new \Folder(self::CACHE_DIRECTORY);
        }
        $this->log("Cache-File '" . $strDocument . "' created successful", __METHOD__, TL_FILES);
    	$objXml->save($strFilename);
    }

    private function buildCacheFileName($strDocument) {
    	//$strDocument = md5($strDocument);
    	return  TL_ROOT . '/' . self::CACHE_DIRECTORY . $strDocument . '.xml';
    }

    protected function orderDomDocumentByObjectType(&$objDocument) {
    	//Objekte des Dokuments auslesen
    	$objNodeList = $objDocument->getElementsByTagName('realEstateElement');

    	//Objekte zur neuen Zuordnung durchlaufen
 		foreach ($objNodeList as $objNode) {

 			$strType = $this->getObjectType($objNode);

 			$objTypeElement = $objDocument->getElementById('tl_' . $strType);
 			//Prüfen, ob bereits ein Node für den Typ vorhanden ist
 			if($objTypeElement == null) {
				//Tyo-Element nicht vorhanden, daher neu anlegen 
 				$objTypeElement = $this->createNewTypeElement($objDocument, $strType);
 			}
 			//Alten Element-Knoten löschen
 			$objNode->parentNode->removeChild($objNode);
 			//Element-Knoten in Type-Knoten einfügen
 			$objTypeElement->appendChild($objNode);
 		}

 		return $objDocument;
    }

    protected function createNewTypeElement(&$objDocument, $strType) {
		//Neuen Typ-Knoten anlegen
		$objNewTypeElement = $objDocument->createElement('typeList');
		$objNewTypeElement->setAttribute('id', 'tl_' . $strType);
		$objNewTypeElement->setAttribute('ic_type', $strType);
		$objListElement = $objDocument->getElementsByTagName('realEstateList')->item(0);
		//Typ-Knoten in die Liste aufnehmen
		return $objListElement->appendChild($objNewTypeElement);
    }

    protected function getObjectType(&$objObjectElement) {
    	//Namespace und Typ aus RealEstateElement auslesen
		$strXsiNamespaceUri = $objObjectElement->lookupNamespaceURI('xsi');
		$strNodeType = $objObjectElement->getAttributeNS($strXsiNamespaceUri, 'type');

    	//Prüfen, ob der XML-Typ gemapped werden kann
		if(array_key_exists($strNodeType, self::OFFER_LIST_TYPES)) {
			$strType = self::OFFER_LIST_TYPES[$strNodeType];
		} else {
			throw new Exception("OfferListType not found", 1);
		}

		return $strType;
    }

    public function getObjectTypes(&$objDocument) {
    	$arrResult = array();
    	$objNodeList = $objDocument->getElementsByTagName('typeList');

    	foreach ($objNodeList as $objTypeNode) {
    		$arrResult[] = $objTypeNode->getAttribute('ic_type');
    	}

    	return $arrResult;
    }
}
