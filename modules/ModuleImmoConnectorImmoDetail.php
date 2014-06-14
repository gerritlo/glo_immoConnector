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

    const PICTURE_SIZE_DEFAULT_TITLE = "600x350";
    const PICTURE_SIZE_DEFAULT = "192x110";
    const PICTURE_SIZE_FULL = "800x800";

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
            $exposeId = \Input::get("object");
            if($exposeId == '' || !preg_match('/^\d+$/', $exposeId)) {
                $this->redirectToNotFound($objPage);
            }
            
            //Get Object request Page
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

            //Expose laden
            $objExpose = $objImmoConnector->getExpose($exposeId, $objUser);
            $objAttachment = $objImmoConnector->getAttachment($exposeId);

            //Typ der Immobilie bestimmen
            $strType = $this->getObjectType($objExpose);
            $strId = $this->getObjectId($objExpose);
	
            //XML-Daten für Objekttyp aufbereiten
            //$arrData = $this->getDataForType($strType, $objExpose);

            //Objektdaten dem Template zuweisen
            $this->Template = new \FrontendTemplate($this->generateTemplateName($strType));
            $this->Template->gloImmoConnectorRemoveTitleText = $this->gloImmoConnectorRemoveTitleText;
            $this->Template->expose = simplexml_import_dom($objExpose);
            $this->Template->attachment = $this->getAttachments($objAttachment);
            $this->Template->objectRequestUrl = $this->generateFrontendUrl($this->_objTarget->row(), '/object/'.$strId);
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
        
        protected function getObjectId($objExpose) {
		//Typ der Immobilie aus dem Tagname des Root-Knotens ermitteln
                $strId = $objExpose->documentElement->getAttribute('id');
		return $strId;
	}
	
	/*protected function getDataForType($strType, $objDocument) {
	
		$arrData = array(
                    'type' => $strType);
                
		$xpath = new \DOMXPath($objDocument);
		
		foreach(self::$_arrTypeFields[$strType] as $field) {
                    //Knoten aus dem DOM laden
                    $objResult = $xpath->query("//".$field);

                    switch($field) {
                        case "floor":
                                $arrData[$field] = (int)($objResult->length > 0) ? $objResult->item(0)->textContent : null;
                                break;
                        case "showAddress":
                        case "lift":
                        case "balcony":
                        case "garden":
                                $arrData[$field] = ($objResult->length > 0 && $objResult->item(0)->textContent == "true") ? true : false;
                                break;
                        default:
                                $arrData[$field] = ($objResult->length > 0) ? $objResult->item(0)->textContent : null;
                    }
		}
                
                return $arrData;
	}*/
	
	protected function generateTemplateName($strType) {
		return "glo_" . $strType . "Detail";
	}
        
        protected function getAttachments($objAttachments) {
            $objAttachments = simplexml_import_dom($objAttachments);
            $arrResult = array('pictures' => array());
            
            for($i=0; $i < $objAttachments->attachment->count(); $i++) {
                $att = $objAttachments->attachment[$i];
                $nsXsi = $att->getNamespaces()['xsi'];
                $attributesXsi = $att->attributes($nsXsi);
                preg_match("@:.+$@", $attributesXsi['type'], $matches);
                if(substr($matches[0], 1) != 'Picture')
                    continue;
                
                if($att->titlePicture == 'true') {
                    $arrResult['titlePicture'] = array(
                        'title' => (String)$att->title,
                        'floorPlan' => ($att->floorPlan == 'true') ? true : false,
                        'lb' => 'lb_' . $att['id'],
                    );
                    
                    foreach ($att->urls->url as $url) {
                        if($url['scale'] == 'SCALE_AND_CROP') {
                            $arrResult['titlePicture']['defaultUrl'] = str_replace("%WIDTH%x%HEIGHT%", self::PICTURE_SIZE_DEFAULT_TITLE, $url['href']);
                        }
                        elseif($url['scale'] == 'SCALE') {
                            $arrResult['titlePicture']['fullUrl'] = str_replace("%WIDTH%x%HEIGHT%", self::PICTURE_SIZE_FULL, $url['href']);
                        }
                    }
                }
                
                if($att->titlePicture != 'true') {                                        
                    foreach ($att->urls->url as $url) {
                        if($url['scale'] == 'SCALE_AND_CROP') {
                            $defaultUrl = str_replace("%WIDTH%x%HEIGHT%", self::PICTURE_SIZE_DEFAULT, $url['href']);
                        }
                        elseif($url['scale'] == 'SCALE') {
                            $fullUrl = str_replace("%WIDTH%x%HEIGHT%", self::PICTURE_SIZE_FULL, $url['href']);
                        }
                    }
                    
                    $arrTmp = array(
                        'title' => (String)$att->title,
                        'floorPlan' => ($att->floorPlan == 'true') ? true : false,
                        'defaultUrl' => $defaultUrl,
                        'fullUrl' => $fullUrl,
                        'lb' => 'lb_' . $att['id'],
                    );
                    
                    $arrResult['pictures'][] = $arrTmp;
                }
            }
            
            return $arrResult;
        }
}
