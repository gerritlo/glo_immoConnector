<?php

/**
 * Table tl_calendar
 */
$GLOBALS['TL_DCA']['tl_ic_auth'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'switchToEdit'                => true,
		'enableVersioning'            => true,
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary'
			)
		)
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 1,
			'fields'                  => array('ic_username'),
			'flag'                    => 11,
			'panelLayout'             => 'filter'
		),
		'label' => array
		(
			'fields'                  => array('ic_username'),
			'format'                  => '%s'
		),
		'global_operations' => array
		(
			'all' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset()" accesskey="e"'
			)
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_ic_auth']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_ic_auth']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.gif',
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_ic_auth']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"',
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_ic_auth']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'__selector__'                => array(),
		'default'                     => '{title_legend},ic_desc,ic_username,ic_key,ic_secret,ic_expire'
	),

	// Subpalettes
	'subpalettes' => array
	(),

	// Fields
	'fields' => array
	(
		'id' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		),
		'tstamp' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'ic_desc' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_ic_auth']['ic_desc'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>32),
			'sql'                     => "varchar(32) NOT NULL default ''"
		),
		'ic_key' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_ic_auth']['ic_key'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>128),
			'sql'                     => "varchar(128) NOT NULL default ''",
		),
		'ic_secret' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_ic_auth']['ic_secret'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>128),
			'sql'                     => "varchar(128) NOT NULL default ''"
		),
		'ic_expire' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_ic_auth']['ic_expire'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>false),
			'sql'                     => "datetime NOT NULL",

		),
		'ic_username' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_ic_auth']['ic_username'],
			'exclude'                 => true,
			'search'                  => true,
			'filter'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>60),
			'sql'                     => "varchar(60) NOT NULL default ''"
		),
	)
);