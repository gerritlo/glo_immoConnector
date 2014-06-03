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
	protected $intObjectPageCount = 20;

	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objTemplate = new \BackendTemplate('be_wildcard');

			$objTemplate->wildcard = '### ' . utf8_strtoupper($GLOBALS['TL_LANG']['FMD']['immoConnectorImmoList'][0]) . ' ###';
			//$objTemplate->title = $this->headline;
			//$objTemplate->id = $this->id;
			//$objTemplate->link = $this->name;
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

		$currPage = \Input::get('page');
		$currPage = is_null($currPage) ? 1 : $currPage;
		
		$objImmoConnector = new ImmoConnector('is24',$GLOBALS['TL_CONFIG']['gloImmoConnectorKey'],$GLOBALS['TL_CONFIG']['gloImmoConnectorSecret']);

		//User auf null setzen bzw. Username auslesen
		$strUser = null;
		if ($this->gloImmoConnectorUser > 0) {
			$strUser = \IcAuthModel::findByPk($this->gloImmoConnectorUser)->ic_username;
		}
		

		$objRes = $objImmoConnector->getAllUserObjects($strUser);

		$arrObjectsSorted = ImmoConnectorHelper::orderObjectsByType($objRes->realEstateList->realEstateElement);
		$arrRenderedObjects = array();

		foreach ($arrObjectsSorted as $strType => $arrTypeObjects) {
			$arrRenderedObjects[$strType] = $this->renderObjectTypeGroup($strType, $arrTypeObjects);
		}
		unset($arrObjectsSorted);

		$this->Template->realEstateObjects =  $arrRenderedObjects;
		$this->Template->showSummary =  ($this->gloImmoConnectorShowSummary == '1');

		/*
		$sCertifyURL = 'http://localhost/spielberg/index.php/objekte.html'; // Komplette URL inkl. Parameter auf der das Script eingebunden wird
		if(isset($_GET['main_registration'])||isset($_GET['state']))
		{
		    if(isset($_POST['user'])){ $sUser=$_POST['user']; }
		    if(isset($_GET['user'])){ $sUser=$_GET['user']; }
		    $aParameter = array('callback_url'=>$sCertifyURL.'?user='.$sUser,'verifyApplication'=>true);
		    // Benutzer neu zertifizieren
		    if($immocaster->getAccess($aParameter))
		    {
		        print_r($immocaster->getAccess($aParameter));
		        echo '<div id="appVerifyInfo">Zertifizierung war erfolgreich.</div>';
		    }
		    else
		    {
		        // Test ob Benutzer schon zertifiziert ist
		        if($immocaster->getApplicationTokenAndSecret($sUser))
		        {
		            echo '<div id="appVerifyInfo">Dieser Benutzer ist bereits zertifiziert.</div>';
		        }
		    }
		}
		echo '<form action="'.$sCertifyURL.'?main_registration=1" method="post"><div id="appVerifyButton"><strong>Hinweis: Unter IE9 kann es zu Problemen mit der Zertifizierung kommen.</strong><br />Benutzername: <input type="text" name="user" value="'.$GLOBALS['TL_CONFIG']['gloImmoConnectorUsername'].'"/><br /><em>Der Benutzername sollte nach Möglichkeit gesetzt werden. Standardmäßig wird ansonsten "me" genommen. Somit können aber nicht mehrere User parallel in der Datenbank abgelegt werden. Der gewählte Benutzernamen muss der gleiche wie im Formular auf der nächsten Seite sein, damit der Token richtig zugewiesen werden kann.</em><br /><input type="submit" value="Jetzt zertifizieren" /></div><input type="hidden" name="REQUEST_TOKEN" value="'.REQUEST_TOKEN.'"></form>';
		*/
	}

	protected function renderObjectTypeGroup($strType, $arrTypeObjects) {
		$arrObjectTemplates = array();

		foreach ($arrTypeObjects as $objObject) {
			$strTenplateName = "glo_".$strType.'Short';
			$objTemplate = new \FrontendTemplate($strTenplateName);
			$objTemplate->objRealEstate = $objObject;
			$arrObjectTemplates[] = $objTemplate->parse();
		}

		return $arrObjectTemplates;
	}
}