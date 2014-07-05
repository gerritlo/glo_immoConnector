<?php

namespace GloImmoConnector;

class ImmoConnector extends \Backend {

    const ALL_USER_OBJECTS = 'ALL_USER_OBJECTS';
    const EXPOSE = 'EXPOSE';
    const ATTACHMENT = 'ATTACHMENT';
    const CACHE_DIRECTORY = 'system/cache/immoConnector/';

    protected $_offerListTypes = array(
            'offerlistelement:OfferHouseBuy' => 'houseBuy',
            'offerlistelement:OfferHouseRent' => 'houseRent',
            'offerlistelement:OfferApartmentRent' => 'apartmentRent',
            'offerlistelement:OfferApartmentBuy' => 'apartmentBuy',
            'offerlistelement:OfferInvestment' => 'investment',
            'offerlistelement:OfferLivingBuySite' => 'livingBuySite'
    );

    protected static $_realEstateTypes = array(
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
    
    public function getImmocaster() {
        return $this->_objImmocaster;
    }
    
    public function getExpose($id, $objUser) {
    
    	$strUser = $objUser->ic_username;
    	
    	$strDocument = self::EXPOSE . '_' . $id;
    	
    	//Check for cache
    	if ($this->isDocumentCached($strDocument) && \Config::get('gloImmoConnectorCacheActive') == '1') {
            //Lade den Cache in das Expose
            $objExpose = $this->getCachedXmlDocument($strDocument);
            $this->log("ImmoConnector: Cache-File '" . $strDocument . "' loaded", __METHOD__, TL_FILES);
        } else {
            $aParameter = array('exposeid' => $id, 'username' => $strUser);
            $objExpose = new \DOMDocument();
            $objExpose->loadXml($this->_objImmocaster->getUserExpose($aParameter));
            $this->log("ImmoConnector: API was requested for Expose '" . $id . "'", __METHOD__, TL_FILES);

            //Ggf. Error ausgeben, wenn kein Expose geladen werden konnte.
			
            //Geladene Daten in den Cache schreiben
            $this->cacheXmlDocument($objExpose, $strDocument);
        }
        
    	return $objExpose;
    }
    
    public function getAttachment($id) {
    
   	$strDocument = self::ATTACHMENT . '_' . $id;
    	
    	//Check for cache
    	if ($this->isDocumentCached($strDocument) && \Config::get('gloImmoConnectorCacheActive') == '1') {
            //Lade den Cache in das Expose
            $objExpose = $this->getCachedXmlDocument($strDocument);
            $this->log("ImmoConnector: Cache-File '" . $strDocument . "' loaded", __METHOD__, TL_FILES);
        } else {
            $aParameter = array('exposeid' => $id);
            $objExpose = new \DOMDocument();
            $objExpose->loadXml($this->_objImmocaster->getAttachment($aParameter));
            $this->log("ImmoConnector: API was requested for Expose '" . $id . "'", __METHOD__, TL_FILES);

            //Ggf. Error ausgeben, wenn kein Expose geladen werden konnte.
			
            //Geladene Daten in den Cache schreiben
            $this->cacheXmlDocument($objExpose, $strDocument);
        }
        
    	return $objExpose;
    }

    public function getAllUserObjects($objUser, $filter = null) {

        $strUser = $objUser->ic_username;
                
        $objFirstPage = null;
        $intMaxPage = 0;
        $strDocument = self::ALL_USER_OBJECTS . '_' . $strUser;

        //Prüfe, ob das benötigte XML-Dokument im Cache vorliegt
        if ($this->isDocumentCached($strDocument) && \Config::get('gloImmoConnectorCacheActive') == '1') {
        	//Lade den Cache in die FirstPage
        	$objFirstPage = $this->getCachedXmlDocument($strDocument);
                $this->log("ImmoConnector: Cache-File '" . $strDocument . "' loaded", __METHOD__, TL_FILES);
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

        //Anwenden von Filtern auf das Resultat
        if($filter) {
	     	$this->filterDocResult($objFirstPage, $filter);   
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
    	//$objHelper->purgeExpiredCacheFiles(); Performance sparen und nur täglich löschen

    	$strFullFilename = $this->buildCacheFileName($strDocument);
    	
    	//Prüfen, ob die Datei existiert/gültig ist bzw. der Cache aktiv ist.
       $file = new \File($strFullFilename, true);
    	if(($file->exists()) && ImmoConnectorHelper::isCacheFileValid($file)) {
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
    	return self::CACHE_DIRECTORY . $strDocument . '.xml';
    }

    protected function orderDomDocumentByObjectType(&$objDocument) {
    	//Objekte des Dokuments auslesen
        
        $xpath = new \DOMXPath($objDocument);
        
        //Lösche Inaktive Objekte
        $inactiveObjects = $xpath->query('//realEstateElement[./realEstateState="INACTIVE"]');
        
        foreach ($inactiveObjects as $inactiveObject) {
            $parent = $inactiveObject->parentNode;
            $parent->removeChild($inactiveObject);
        }
    	$nodeList = $xpath->query('//realEstateElement');
        $typeLists = array();
        
        //Sortieren der Knoten zu Typen
        for($i=0; $i < $nodeList->length; $i++) {
            $node = $nodeList->item($i);
            $strType = $this->getObjectType($node);
            $typeLists[$strType][] = $node;
        }
        
        //Durchlaufen aller TypeLists
        foreach ($typeLists as $type => $nodes) {
            //TypeList erstellen
            $objTypeElement = $this->createNewTypeElement($objDocument, $type);
            
            //Knoten des Typs zur TypeList hinzufügen
            foreach ($nodes as $node) {
                $objTypeElement->appendChild($node);
            }
        }        

        return $objDocument;
    }

    protected function createNewTypeElement(&$objDocument, $strType) {
        //Neuen Typ-Knoten anlegen
        $objNewTypeElement = $objDocument->createElement('typeList');
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
        if(array_key_exists($strNodeType, $this->_offerListTypes)) {
                $strType = $this->_offerListTypes[$strNodeType];
        } else {
                //throw new \Exception("OfferListType not found", 1);
                list( ,$strType) = explode(":Offer", $strNodeType);
                $this->log("ImmoConnector: Object-Type not found '" . $strNodeType . "'", __METHOD__, TL_ERROR);
                $strType = lcfirst($strType);
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

    protected function filterDocResult(&$document, $arrFilter) {
        $xpath = new \DOMXPath($document);

        //Filtern nachn
        if($arrFilter['objectType'] && $arrFilter['objectType']!= '') {
            foreach($xpath->query("//typeList[@ic_type!='" . $arrFilter['objectType'] . "']") as $tlNode) {
                $parent = $tlNode->parentNode;
                $parent->removeChild($tlNode);
            }
        }
        
        if($arrFilter['zipcode'] && $arrFilter['zipcode'] != '') {
            $query = '//realEstateElement/address/postcode';
            foreach($xpath->query($query) as $tlNode) {
                if(preg_match("#^" . preg_quote($arrFilter['zipcode']) . "#", $tlNode->textContent) < 1) {
                    $realEstateElement = $tlNode->parentNode->parentNode;
                    $typeList = $realEstateElement->parentNode;
                    $typeList->removeChild($realEstateElement);
                }
            }
        }
        
        if($arrFilter['city'] && $arrFilter['city'] != '') {
            $query = '//realEstateElement/address/city';
            foreach($xpath->query($query) as $tlNode) {
                if(preg_match("#" . preg_quote($arrFilter['city']) . "#i", $tlNode->textContent) < 1) {
                    $realEstateElement = $tlNode->parentNode->parentNode;
                    $typeList = $realEstateElement->parentNode;
                    $typeList->removeChild($realEstateElement);
                }
            }
        }
        
        if($arrFilter['keyword'] && $arrFilter['keyword'] != '') {
            $query = '//realEstateElement/title';
            foreach($xpath->query($query) as $tlNode) {
                if(preg_match("#" . preg_quote($arrFilter['keyword']) . "#i", $tlNode->textContent) < 1) {
                    $realEstateElement = $tlNode->parentNode;
                    $typeList = $realEstateElement->parentNode;
                    $typeList->removeChild($realEstateElement);
                }
            }
        }
        
        //Remove empty nodes
        $emptyNodes = $xpath->query("//typeList[count(./*) < 1]");
        foreach($emptyNodes as $node) {
        	$realEstateList = $node->parentNode;
        	$realEstateList->removeChild($node);
        }
    }
    
    public static function getRealEstateTypes() {
        return self::$_realEstateTypes;
    }
}
