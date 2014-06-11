<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2014 Leo Feyer
 *
 * @package   GloImmoConnector
 * @author    Gerrit Lober
 * @license   -
 * @copyright Gerrit Lober 2014
 */


/**
 * Namespace
 */
namespace GloImmoConnector;


/**
 * Class ModuleImmoConnectorImmoDetail
 *
 * @copyright  Gerrit Lober 2014
 * @author     Gerrit Lober
 * @package    Devtools
 */
class ModuleImmoConnectorImmoDetail extends \Module
{

	protected static $_arrTypeFields = array(
		'houseBuy' => array(),
		'houseRent' => array(),
		'appartmentRent' => array('title', 'street', 'houseNumber', 'postcode', 'city', 'descriptionNote', 'furnishingNote', 'locationNote', 'otherNote', 'showAddress', 'floor', 'apartmentType', 'lift', 'cellar', 'handicappedAccessible', 'numberOfParkingSpaces', 'condition', 'lastRefurbishment', 'constructionYear', 'interiorQuality', 'freeFrom', 'numberOfFloors', 'usableFloorSpace', 'numberOfBedRooms','numberOfBathRooms', 'guestToilet', 'parkingSpaceType', 'baseRent', 'totalRent', 'serviceCharge', 'deposit', 'livingSpace', 'numberOfRooms', 'balcony', 'garden', 'hasCourtage', 'courtage', 'courtageNote'),
		'appartmentBuy' => array(),
		'investment' => array(),
		'livingBuySide' => array()
	);

	/**
	 * Template
	 * @var string
	 */
    protected $strTemplate = 'mod_realestatedetail';

	public function generate()
	{
            if (TL_MODE == 'BE')
            {
                $objTemplate = new \BackendTemplate('be_wildcard');

                $objTemplate->wildcard = '### ' . utf8_strtoupper($GLOBALS['TL_LANG']['FMD']['immoConnectorImmoDetail'][0]) . ' ###';
                $objTemplate->title = $this->headline;
                $objTemplate->id = $this->id;
                $objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

                return $objTemplate->parse();
            }

            return parent::generate();
        }


	/**
	 * Generate the module
	 */
	protected function compile()
	{
		global $objPage;
		
		//Prüfen ob eine numerische ExposeId angegeben wurde
		$exposeId = trim(\Input::get("exposeId"));
		if($exposeId == '' || !preg_match('/^\d+$/', $exposeId)) {
			$this->redirectToNotFound($objPage);
		}
		
		
		$objImmoConnector = new ImmoConnector('is24',\Config::get('gloImmoConnectorKey'),\Config::get('gloImmoConnectorSecret'));

        //User auf null setzen bzw. Username auslesen
        $objUser = \IcAuthModel::findByPk($this->gloImmoConnectorUser);
        if (is_null($objUser)) {
                throw new \Exception("Missing or invalid User selected for API-Connection", 1);

        }
        
        //Expose laden
        $objExpose = $objImmoConnector->getExpose($exposeId, $objUser);
        
        //Typ der Immobilie bestimmen
        $strType = $this->getObjectType($objDocument);
	
		//XML-Daten für Objekttyp aufbereiten
		$arrData = $this->getDataForType($strType, $objDocument);
		
		//Objektdaten dem Template zuweisen
		$this->Template = new \FrontendTemplate($this->generateTemplateName($strType));
	}
	
	protected function redirectToNotFound($objPage) {
		$objHandler = new $GLOBALS['TL_PTY']['error_404']();
		$objHandler->generate($objPage->id, null, null, true);
	}
	
	protected function getObjectType($objExpose) {
		//Typ der Immobilie aus dem Tagname des Root-Knotens ermitteln
		list( , $strType) = explode(":", $objExpose->documentElement->tagName);
		return $strType;
	}
	
	protected function getDataForType($strType, $objDocument) {
	
		$arrData = array('type' => $strType);
		$xpath = new DOMXPath($objDocument);
		
		foreach(self::$_arrTypeFields[$strType] as $field) {
		
			//Knoten aus dem DOM laden
			$objResult = $xpath->query("//".$field);
			
			switch($field) {
				case "floor":
					$arrData[$field] = (int)($objResult->length > 0) ? $objResult->item(0)->textContent : null;
					break;
				case "showAddress", "lift", "balcony", "garden":
					$arrData[$field] = ($objResult->length > 0 && $objResult->item(0)->textContent == "true") ? true : false;
					break;
				default:
					$arrData[$field] = ($objResult->length > 0) ? $objResult->item(0)->textContent : null;
			}
		}
	}
	
	protected function generateTemplateName($strType) {
		return "glo_" . $strType . "Detail";
	}
}
