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

	/**
	 * Template
	 * @var string
	 */
        protected $strTemplate = 'mod_realestatedetail';
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
		global $objPage;
		
		//Prüfen ob eine numerische ExposeId angegeben wurde
		$exposeId = trim(\Input::get("exposeId"));
		if($exposeId == '' || !preg_match('/^\d+$/', $exposeId)) {
			$this->redirectToNotFound($objPage);
		}
	}
	
	protected function redirectToNotFound($objPage) {
		$objHandler = new $GLOBALS['TL_PTY']['error_404']();
		$objHandler->generate($objPage->id, null, null, true);
	}
}
