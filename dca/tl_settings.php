<?php

$GLOBALS['TL_DCA']['tl_settings']['fields']['gloImmoConnectorKey'] = array(
	'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['gloImmoConnectorKey'],
	'inputType'               => 'text',
	'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['gloImmoConnectorSecret'] = array(
	'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['gloImmoConnectorSecret'],
	'inputType'               => 'text',
	'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['gloImmoConnectorCacheActive'] = array(
	'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['gloImmoConnectorCacheActive'],
	'inputType'               => 'ckeckbox',
	'eval'                    => array('mandatory'=>true, 'isBoolean' => true, 'tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['gloImmoConnectorCacheTime'] = array(
	'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['gloImmoConnectorCacheTime'],
	'inputType'               => 'text',
	'eval'                    => array('mandatory'=>true, 'rgxp' => 'digit', 'tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_settings']['palettes']['default'] = str_replace('imageHeight;', 'imageHeight;{immoConnector_legend},gloImmoConnectorKey,gloImmoConnectorSecret;', $GLOBALS['TL_DCA']['tl_settings']['palettes']['default']);