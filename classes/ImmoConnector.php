<?php

namespace GloImmoConnector;

class ImmoConnector extends \Backend {

    protected $_objImmocaster = null;

    const ALL_USER_OBJECTS = 'allUserObjects';
    const CACHE_DIRECTORY = 'system/cache/immoConnector/';

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
                        $objFirstPage = $objPage;
                    } else {
                        $this->mergeXmlPages($objFirstPage, $objPage);
                    }

                } while ($intMaxPage > $intPage++);
                
                $this->log("ImmoConnector: API was requested", __METHOD__, TL_FILES);

                //Geladene Daten in den Cache schreiben
                $this->cacheXmlDocument($objFirstPage, $strDocument);
        }
        
        //Kombinierte XML zurückgeben
		return simplexml_import_dom($objFirstPage);
	}
        
    protected function requestAllUserObjects($intPage, $strUser) {
        $objRes = new \DOMDocument();
        $objRes->loadXml($this->_objImmocaster->fullUserSearch(array('username' => $strUser, 'pagenumber' => $intPage, 'pagesize' => 100)));
        
        return $objRes;
    }

    protected function mergeXmlPages(&$objFirstPage, $objPage) {
    	//Fügt die realEstateElement-Knoten der FirstPage hinzu

    	$objNodeList = $objPage->getElementsByTagName('realEstateElement');
    	$objRealEstateList = $objFirstPage->getElementsByTagName('realEstateList')->item(0);

    	foreach ($objNodeList as $objNode) {
            $objNewNode = $objFirstPage->importNode($objNode, true);
            $objRealEstateList->appendChild($objNewNode);
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
        $this->log("Cache-File '" . $strFilename . "' created successful", __METHOD__, TL_FILES);
    	$objXml->save($strFilename);
    }

    private function buildCacheFileName($strDocument) {
    	//$strDocument = md5($strDocument);
    	return  TL_ROOT . '/' . self::CACHE_DIRECTORY . $strDocument . '.xml';
    }


}