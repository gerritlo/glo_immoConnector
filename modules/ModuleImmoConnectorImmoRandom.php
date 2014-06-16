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
 * Class ModuleImmoConnectorCategoryList
 *
 * @copyright  Gerrit Lober 2014
 * @author     Gerrit Lober
 * @package    Devtools
 */
class ModuleImmoConnectorImmoRandom extends \Module
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_immoConnectorRandom';
        
        const PICTURE_SIZE_FULL = '252x170';
        

        public function generate()
            {
            if (TL_MODE == 'BE')
            {
                $objTemplate = new \BackendTemplate('be_wildcard');

                $objTemplate->wildcard = '### ' . utf8_strtoupper($GLOBALS['TL_LANG']['FMD']['immoConnectorImmoRandom'][0]) . ' ###';
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

            $objImmoConnector = new ImmoConnector('is24',\Config::get('gloImmoConnectorKey'),\Config::get('gloImmoConnectorSecret'));

            //User auf null setzen bzw. Username auslesen
            $objUser = \IcAuthModel::findByPk($this->gloImmoConnectorUser);
            if (is_null($objUser)) {
                    throw new \Exception("Missing or invalid User selected for API-Connection", 1);

            }
            
            //Get Expose Page
            if ($this->gloImmoConnectorjumpTo && ($objTarget = $this->objModel->getRelated('gloImmoConnectorjumpTo')) !== null)
            {
                $this->_objTarget = $objTarget;
            }

            $objRes = $objImmoConnector->getAllUserObjects($objUser);

            $xpath = new \DOMXPath($objRes);
            $objList = $xpath->query("//realEstateElement");
            
            if($objList->length > 0) {
                $index = rand(0, $objList->length - 1);
                //Zufalls-Item aus Liste laden
                $objRand = simplexml_import_dom($objList->item($index));

                $this->Template->title = ($this->gloImmoConnectorRemoveTitleText != '') ? str_replace($this->gloImmoConnectorRemoveTitleText, '', $objRand->title) : (String)$objRand->title;
                if($objRand->titlePicture) {
                    foreach ($objRand->titlePicture->urls->url as $url) {
                        if($url['scale'] == 'SCALE_AND_CROP') {
                            $this->Template->picture = array(
                                'url' => str_replace("%WIDTH%x%HEIGHT%", self::PICTURE_SIZE_FULL, $url['href']),
                                'title' => (String)$objRand->titlePicture->title,
                            );
                        }
                    }
                }
		$this->Template->zipcode = (String)$objRand->address->postcode;
		$this->Template->city = (String)$objRand->address->city;
                $this->Template->exposeHref = $this->generateFrontendUrl($this->_objTarget->row(), '/object/'.$objRand['id']);
                $this->Template->objectType = $GLOBALS['TL_LANG']['FMD']['immoConnector'][$this->getObjectType($objRand)];
                $this->Template->priceValue = (float) $objRand->price->value;
                $this->Template->priceCurrency = (String) $objRand->price->currency;
                
                switch($this->getObjectType($objRand)) {
                	case "houseBuy":
                	case "apartmentBuy":
                	case "investment":
                	case "livingBuySite":
                		$this->Template->priceTitle = $GLOBALS['TL_LANG']['FMD']['immoConnector']['buyPrice'];
                      		break;
                	case "houseRent":
                	case "apartmentRent":
                		$this->Template->priceTitle = $GLOBALS['TL_LANG']['FMD']['immoConnector']['rentPrice'];
                		break;
                }
            } else {
                $this->Template->noObjectFound = $GLOBALS['TL_LANG']['FMD']['immoConnector']['noObjectFound'];
            }
	}
        
        protected function getObjectType($objExpose) {
            $parent = $objExpose->xpath('..');
            return (String)$parent[0]['ic_type'];
	}
}
