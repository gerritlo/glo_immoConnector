<?php

$GLOBALS['TL_DCA']['tl_module']['fields']['gloImmoConnectorUser'] = array(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['gloImmoConnectorUser'],
	'inputType'               => 'select',
	'foreignKey'              => 'tl_ic_auth.ic_title',
	'sql'                     => "int(10) unsigned NOT NULL default '0'",
	'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50')
);
$GLOBALS['TL_DCA']['tl_module']['fields']['gloImmoConnectorShowSummary'] = array(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['gloImmoConnectorShowSummary'],
	'inputType'               => 'checkbox',
	'eval'                    => array('isBoolean' => true, 'tl_class'=>'w50'),
	'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['gloImmoConnectorjumpTo'] = array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_module']['gloImmoConnectorjumpTo'],
			'exclude'                 => true,
			'inputType'               => 'pageTree',
			'foreignKey'              => 'tl_page.title',
			'eval'                    => array('fieldType'=>'radio', 'mandatory' => true),
			'sql'                     => "int(10) unsigned NOT NULL default '0'",
			'relation'                => array('type'=>'hasOne', 'load'=>'eager')
		);

$GLOBALS['TL_DCA']['tl_module']['palettes']['immoConnectorImmoList'] = '{title_legend},name,headline,type;{config_legend},gloImmoConnectorUser,gloImmoConnectorShowSummary';

$GLOBALS['TL_DCA']['tl_module']['palettes']['immoConnectorImmoSearch'] = '{title_legend},name,headline,type;{config_legend},gloImmoConnectorjumpTo';