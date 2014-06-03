<?php

$GLOBALS['TL_DCA']['tl_module']['fields']['gloImmoConnectorUsername'] = array(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['gloImmoConnectorUsername'],
	'inputType'               => 'select',
	'foreignKey'			  => 'tl_ic_auth.ic_username',
	'sql'                     => "int(10) unsigned NOT NULL default '0'",
	'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50')
);
$GLOBALS['TL_DCA']['tl_module']['fields']['gloImmoConnectorShowSummary'] = array(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['gloImmoConnectorShowSummary'],
	'inputType'               => 'ckeckbox',
	'eval'                    => array('mandatory'=>true, 'isBoolean' => true, 'tl_class'=>'w50'),
	'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['palettes']['immoConnectorImmoList'] = '{title_legend},headline,gloImmoConnectorUsername,gloImmoConnectorShowSummary';