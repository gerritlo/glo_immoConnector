<?php

namespace GloImmoConnector;

class ImmoConnector {

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

	public function getAllUserObjects($strUser = null) {
		if (is_null($strUser)) {
			$strUser = $GLOBALS['TL_CONFIG']['gloImmoConnectorUsername'];
		}
                
                $intPage = 1;
                
                $objXmlPages = new \SimpleXMLElement('<realEstateList></realEstateList>');
                
                do {
                    $objPage = $this->requestAllUserObjects($intPage, $strUser);
                    foreach ($objPage->realEstateList->realEstateElement as $objElement) {
                        $objXmlPages->addChild('realEstateObject', $objElement->asXml());
                    }
                    
                } while ($objPage->Paging->numberOfPages > $intPage++);
                
                var_dump($objXmlPages->asXML());
                
		return $objXmlPages;
	}
        
        protected function requestAllUserObjects($intPage, $strUser) {
            $objRes = new \SimpleXMLElement($this->_objImmocaster->fullUserSearch(array('username' => $strUser, 'pagenumber' => $intPage )));
            
            return $objRes;
        }
}