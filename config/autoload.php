<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2014 Leo Feyer
 *
 * @package Glo_immoConnector
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'GloImmoConnector',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Classes
	'GloImmoConnector\ImmoConnector'                 => 'system/modules/glo_immoConnector/classes/ImmoConnector.php',
	'GloImmoConnector\ImmoConnectorHelper'           => 'system/modules/glo_immoConnector/classes/ImmoConnectorHelper.php',

	// Models
	'GloImmoConnector\IcAuthModel'                   => 'system/modules/glo_immoConnector/models/IcAuthModel.php',

	// Modules
	'GloImmoConnector\ModuleImmoConnectorImmoDetail' => 'system/modules/glo_immoConnector/modules/ModuleImmoConnectorImmoDetail.php',
	'GloImmoConnector\ModuleImmoConnectorImmoList'   => 'system/modules/glo_immoConnector/modules/ModuleImmoConnectorImmoList.php',
	'GloImmoConnector\ModuleImmoConnectorImmoRandom' => 'system/modules/glo_immoConnector/modules/ModuleImmoConnectorImmoRandom.php',
	'GloImmoConnector\ModuleImmoConnectorImmoSearch' => 'system/modules/glo_immoConnector/modules/ModuleImmoConnectorImmoSearch.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'glo_houseBuyDetail'      => 'system/modules/glo_immoConnector/templates/detail',
	'glo_apartmentBuyShort'   => 'system/modules/glo_immoConnector/templates/list',
	'glo_apartmentRentShort'  => 'system/modules/glo_immoConnector/templates/list',
	'glo_houseBuyShort'       => 'system/modules/glo_immoConnector/templates/list',
	'glo_houseRentShort'      => 'system/modules/glo_immoConnector/templates/list',
	'glo_investmentShort'     => 'system/modules/glo_immoConnector/templates/list',
	'glo_livingBuySiteShort'  => 'system/modules/glo_immoConnector/templates/list',
	'mod_realestatelist'      => 'system/modules/glo_immoConnector/templates/list',
	'mod_immoConnectorRandom' => 'system/modules/glo_immoConnector/templates/random',
	'mod_realestatesearch'    => 'system/modules/glo_immoConnector/templates/search',
));
