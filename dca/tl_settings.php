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

$GLOBALS['TL_DCA']['tl_settings']['fields']['gloImmoConnectorUsername'] = array(
	'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['gloImmoConnectorUsername'],
	'inputType'               => 'text',
	'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_settings']['palettes']['default'] = str_replace('imageHeight;', 'imageHeight;{immoConnector_legend},gloImmoConnectorKey,gloImmoConnectorSecret,gloImmoConnectorUsername;', $GLOBALS['TL_DCA']['tl_settings']['palettes']['default']);