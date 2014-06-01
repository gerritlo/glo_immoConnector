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

		$objRes = new \SimpleXMLElement($this->_objImmocaster->fullUserSearch(array('username' => $strUser)));

		return $objRes;
	}
}