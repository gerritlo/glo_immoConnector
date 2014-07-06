<?php

$GLOBALS['TL_DCA']['tl_module']['fields']['gloImmoConnectorUser'] = array(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['gloImmoConnectorUser'],
	'inputType'               => 'select',
	'foreignKey'              => 'tl_ic_auth.ic_title',
	'sql'                     => "int(10) unsigned NOT NULL default '0'",
	'eval'                    => array('mandatory'=>true)
);
$GLOBALS['TL_DCA']['tl_module']['fields']['gloImmoConnectorShowSummary'] = array(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['gloImmoConnectorShowSummary'],
	'inputType'               => 'checkbox',
	'eval'                    => array('isBoolean' => true),
	'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['gloImmoConnectorRemoveTitleText'] = array(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['gloImmoConnectorRemoveTitleText'],
	'inputType'               => 'text',
	'eval'                    => array('isBoolean' => true),
	'sql'                     => "varchar(255) NOT NULL default ''"
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

$GLOBALS['TL_DCA']['tl_module']['fields']['gloImmoConnectorTypeSelector'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['gloImmoConnectorTypeSelector'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'options_callback'        => array('tl_module_immoConnector', 'getObjectTypes'),
	'eval'                    => array('multiple'=>true),
	'sql'                     => "blob NULL"
);

$GLOBALS['TL_DCA']['tl_module']['palettes']['immoConnectorImmoList'] = '{title_legend},name,headline,type;{config_legend},gloImmoConnectorShowSummary,gloImmoConnectorUser,gloImmoConnectorRemoveTitleText,gloImmoConnectorTypeSelector;{redirect_legend},jumpTo';

$GLOBALS['TL_DCA']['tl_module']['palettes']['immoConnectorImmoSearch'] = '{title_legend},name,headline,type;{config_legend},gloImmoConnectorUser;{redirect_legend},gloImmoConnectorjumpTo';

$GLOBALS['TL_DCA']['tl_module']['palettes']['immoConnectorImmoRandom'] = '{title_legend},name,headline,type;{config_legend},gloImmoConnectorUser,gloImmoConnectorRemoveTitleText;{redirect_legend},gloImmoConnectorjumpTo';

$GLOBALS['TL_DCA']['tl_module']['palettes']['immoConnectorImmoDetail'] = '{title_legend},name,headline,type;{config_legend},gloImmoConnectorUser,gloImmoConnectorRemoveTitleText;{redirect_legend},jumpTo';

class tl_module_immoConnector extends \Backend {
    
    public function getObjectTypes() {
        $this->loadLanguageFile('default');
        $arrTypes = ImmoConnector::getRealestateTypes();
        $arrOptions = array();
        foreach ($arrTypes as $strType) {
            $arrOptions[$strType] = $GLOBALS['TL_LANG']['immoConnector'][$strType] ? : $strType;
        }
        return $arrOptions;
        
    }
}