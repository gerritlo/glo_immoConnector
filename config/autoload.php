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
	'block_realestateattachment'    => 'system/modules/glo_immoConnector/templates/detail',
	'block_realestatedetail'        => 'system/modules/glo_immoConnector/templates/detail',
	'block_realestateobjectrequest' => 'system/modules/glo_immoConnector/templates/detail',
	'glo_defaultDetail'        	=> 'system/modules/glo_immoConnector/templates/detail',
	'glo_defaultShort'         	=> 'system/modules/glo_immoConnector/templates/list',
	'mod_realestatelist'            => 'system/modules/glo_immoConnector/templates/list',
	'mod_immoConnectorRandom'       => 'system/modules/glo_immoConnector/templates/random',
	'mod_realestatesearch'          => 'system/modules/glo_immoConnector/templates/search',
	'be_registrationForm'          	=> 'system/modules/glo_immoConnector/templates/backend',
));
