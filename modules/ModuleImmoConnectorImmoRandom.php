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
	protected $strTemplate = '';

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
		
		$objImmoConnector = new ImmoConnector('is24',\Config::get('gloImmoConnectorKey'),\Config::get('gloImmoConnectorSecret'));

        //User auf null setzen bzw. Username auslesen
        $objUser = \IcAuthModel::findByPk($this->gloImmoConnectorUser);
        if (is_null($objUser)) {
                throw new \Exception("Missing or invalid User selected for API-Connection", 1);

        }
        
        $objRes = $objImmoConnector->getAllUserObjects($objUser);
        
        $xpath = new DOMXPath($objRes);
        $objList = $xpath->query("//realEstateElement");
        $index = rand(0, $objList->length - 1);
        
        //Zufalls-Item aus Liste laden
        $ObjRand = $objList->item($index);
	}
}
