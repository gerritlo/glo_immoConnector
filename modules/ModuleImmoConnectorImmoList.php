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
 * Class ModuleImmoConnectorImmoList
 *
 * @copyright  Gerrit Lober 2014
 * @author     Gerrit Lober
 * @package    Devtools
 */
class ModuleImmoConnectorImmoList extends \Module
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_realestatelist';
	protected $strTemplateShort = 'glo_defaultShort';
        protected $_searchFormId = 'tl_immoConnectorImmoSearch';
	protected $intObjectPageCount = 20;

	public function generate()
	{
            if (TL_MODE == 'BE')
            {
                $objTemplate = new \BackendTemplate('be_wildcard');

                $objTemplate->wildcard = '### ' . utf8_strtoupper($GLOBALS['TL_LANG']['FMD']['immoConnectorImmoList'][0]) . ' ###';
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
            //Categories selected in List-Module-Options
            $arrCategoriesToShow = deserialize($this->gloImmoConnectorTypeSelector);
            
            $filter = null;
            if(\Input::post('FORM_SUBMIT') == $this->_searchFormId) {
                $filter = array(
                    'objectType' => htmlspecialchars(\Input::post('objectType')),
                    'zipcode' => htmlspecialchars(\Input::post('zipcode')),
                    'city'  => htmlspecialchars(\Input::post('city')),
                    'keyword'  => htmlspecialchars(\Input::post('keyword')),
                );
            }
            
            //Get Expose Page
            if ($this->jumpTo && ($objTarget = $this->objModel->getRelated('jumpTo')) !== null)
            {
                $this->_objTarget = $objTarget;
            }

            $objImmoConnector = new ImmoConnector('is24',\Config::get('gloImmoConnectorKey'),\Config::get('gloImmoConnectorSecret'));

            //User auf null setzen bzw. Username auslesen
            $objUser = \IcAuthModel::findByPk($this->gloImmoConnectorUser);
            if (is_null($objUser)) {
            	throw new \Exception("Missing or invalid User selected for API-Connection", 1);
            }

            $objRes = $objImmoConnector->getAllUserObjects($objUser, $filter);
            $arrRes = $this->orderObjects(simplexml_import_dom($objRes));
            unset($objXml);
            $arrTypes = array_keys($arrRes);
            
            //Rendern der Objekt-Daten
            $arrRendered = array();
            foreach ($arrRes as $strType => $objList) {
                    $arrRendered[$strType] = $this->renderObjectTypeGroup($strType, $objList);
            }
            unset($arrRes);

            $this->Template->realEstateObjects =  $arrRendered;
	}

	protected function renderObjectTypeGroup($strType, $arrTypeObjects) {
		$arrObjectTemplates = array();

		foreach ($arrTypeObjects as $arrObject) {
			
			$objTemplate = new \FrontendTemplate($this->strTemplateShort);
			$objTemplate->data = $arrObject;
			$arrObjectTemplates[] = $objTemplate->parse();
		}

		return $arrObjectTemplates;
	}
	
	protected function orderObjects($objObjects) {
            $arrRes = array();

            foreach ($objObjects->realEstateList->typeList as $objList) {
                $strType = (String) $objList['ic_type'];

                $arrRes[$strType] = $this->addObjects($objList, $strType);
            }
            return $arrRes;
	}
	
	protected function addObjects($objList, $strType) {
            $arrRes = array();

            foreach($objList->realEstateElement as $objElement) {
                $arrData = array(
                    'title' => $this->gloImmoConnectorRemoveTitleText ? str_replace($this->gloImmoConnectorRemoveTitleText, '', (String)$objElement->title) : (String)$objElement->title, 
                    'titlePicture' => (boolean) $objElement->titlePicture,
                    'titlePictureUrl' => ($objElement->titlePicture) ? (String) $objElement->titlePicture->urls->url[1]['href'] : null,
                    'exposeUrl' => $this->generateFrontendUrl($this->_objTarget->row(), '/object/'.$objElement['id']),
                    'zipcode' => (String) $objElement->address->postcode,
                    'city' => (String) $objElement->address->city,
                    'plotArea' => (int) $objElement->livingSpace,
                    'numberOfRooms' => (int) $objElement->numberOfRooms,
                    'livingSpace' => (float)$objElement->livingSpace,
                    'plotArea' => (float)$objElement->plotArea,
                    'priceValue' => (float) $objElement->price->value,
                    'priceCurrency' => (String) $objElement->price->currency,
                );
                
                switch($strType) {
                	case "houseBuy":
                	case "apartmentBuy":
                	case "investment":
                	case "livingBuySite":
                		$arrData['priceTitle'] = $GLOBALS['TL_LANG']['FMD']['immoConnector']['buyPrice'];
                      		break;
                	case "houseRent":
                	case "apartmentRent":
                		$arrData['priceTitle'] = $GLOBALS['TL_LANG']['FMD']['immoConnector']['rentPrice'];
                		break;
                }
                
                $arrRes[] = $arrData;
            }

            return $arrRes;
	}
}
