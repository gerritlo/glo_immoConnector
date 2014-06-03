<?php

namespace GloImmoConnector;

class ImmoConnector extends \Backend {

	protected $_objImmocaster = null;

	protected static const ALL_USER_OBJECTS = 'allUserObjects';
	protected static const CACHE_DIRECTORY = 'system/cache/immoConnector/';

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

	public function getAllUserObjects($strUser = null) {
		if (is_null($strUser)) {
			$strUser = $GLOBALS['TL_CONFIG']['gloImmoConnectorUsername'];
		}
                
        $objFirstPage = null;
        $intMaxPage = 0;
        $strDocument = ALL_USER_OBJECTS . '_' . $strUser;

        //Prüfe, ob das benötigte XML-Dokument im Cache vorliegt
        if ($this->isDocumentCached($strDocument)) {
        	//Lade den Cache in die FirstPage
        	$objFirstPage = $this->getCachedXmlDocument($strDocument);
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
	            	$objFirstPage = $objPage;
	            } else {
	            	$this->mergeXmlPages(&$objFirstPage, $objPage);
	            }
	            
	        } while ($intMaxPage > $intPage++);

	        //Geladene Daten in den Cache schreiben
	        $this->cacheXmlDocument($objFirstPage);
        }
        
        //Kombinierte XML zurückgeben
		return simplexml_import_dom($objFirstPage);
	}
        
    protected function requestAllUserObjects($intPage, $strUser) {
        $objRes = \DOMDocument::loadXml($this->_objImmocaster->fullUserSearch(array('username' => $strUser, 'pagenumber' => $intPage, 'pagesize' => 100)));
        
        return $objRes;
    }

    protected function mergeXmlPages($objFirstPage, $objPage) {
    	//Fügt die realEstateElement-Knoten der FirstPage hinzu

    	$objNodeList = $objPage->getElementsByTagName('realEstateElement');
    	$objRealEstateList = 

    	foreach ($objNodeList as $objNode) {
    		$objNewNode = $objFirstPage->importNode($objNode, true);
    		$objRealEstateList->appendChild($objNewNode);
    	}
    }

    protected function getCachedXmlDocument($strDocument) {

    	$strFullPath = $this->buildCacheFileName($strDocument)
    	if(file_exists($strFullPath) {
    		return DOMDocument::load($strFullPath);
    	}
    	
    	return null;
    }

    protected function isDocumentCached($strDocument) {

    	//Delete old Cache-Files
    	$this->purgeExpiredCacheFiles();

    	$strFullFilename = $this->buildCacheFileName($strDocument);
    	
    	//Prüfen, ob die Datei existiert/gültig ist bzw. der Cache aktiv ist.
    	if((file_exists($strFullFilename)) && (\Cache::get('gloImmoConnectorCacheActive'))) {
    		return true;
    	}
    	return false;
    }

    protected function cacheXmlDocument($objXml, $strDocument) {
    	$objFile = new \File(, true);
    	$objXml->save($this->buildCacheFileName($strDocument));
    }

    private function buildCacheFileName($strDocument) {
    	//$strDocument = md5($strDocument);
    	return  TL_ROOT . CACHE_DIRECTORY . $strDocument . '.xml';
    }


}