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
 * Class ModuleImmoConnectorImmoSearch
 *
 * @copyright  Gerrit Lober 2014
 * @author     Gerrit Lober
 * @package    Devtools
 */
class ModuleImmoConnectorImmoSearch extends \Module
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_realestatesearch';
	protected $strFormId = 'tl_immoConnectorImmoSearch';

	/**
	 * Display a wildcard in the back end
	 * @return string
	 */
	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objTemplate = new \BackendTemplate('be_wildcard');

			$objTemplate->wildcard = '### ' . utf8_strtoupper($GLOBALS['TL_LANG']['FMD']['gloImmoConnectorImmoSearch'][0]) . ' ###';
			$objTemplate->title = $this->headline;
			$objTemplate->id = $this->id;
			$objTemplate->link = $this->name;
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
		//Daten laden, sofern das Formular bereits gesendet wurde
		if(\Input::post('FORM_SUBMIT') == $this->strFormId) {
			$this->Template->defaultObjectType = \Input::post('objectType');
			$this->Template->defaultZipcode = \Input::post('zipcode');
			$this->Template->defaultCity = \Input::post('city');
                        $this->Template->defaultKeywoed = \Input::post('keyword');
		}
		

		// Get the current "jumpTo" page
		$objTarget = $this->objModel->getRelated('gloImmoConnectorjumpTo');
		$this->Template->action = $this->generateFrontendUrl($objTarget->row());

		$this->Template->formId = $this->strFormId;
		$this->Template->objectTypeLabel = $GLOBALS['TL_LANG']['FMD']['immoConnector']['objectType'];
		$this->Template->zipCodeLabel = $GLOBALS['TL_LANG']['FMD']['immoConnector']['zipCode'];
		$this->Template->cityLabel = $GLOBALS['TL_LANG']['FMD']['immoConnector']['city'];
		$this->Template->submitLabel =$GLOBALS['TL_LANG']['FMD']['immoConnector']['search'];
                $this->Template->keywordLabel =$GLOBALS['TL_LANG']['FMD']['immoConnector']['keyword'];
		$this->Template->objectTypes = $this->getObjectTypes();
	}

	
	protected function getObjectTypes() {
		$arrTypes = array('' => $GLOBALS['TL_LANG']['FMD']['immoConnector']['all']);

		foreach (ImmoConnector::$realEstateTypes as $strType) {
			$arrTypes[$strType] = isset($GLOBALS['TL_LANG']['FMD']['immoConnector'][$strType]) ? $GLOBALS['TL_LANG']['FMD']['immoConnector'][$strType] : $strType;
		}

		return $arrTypes;
	}
}
