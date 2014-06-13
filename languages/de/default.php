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
 * Miscellaneous
 */
$GLOBALS['TL_LANG']['MSC'][''] = '';

$GLOBALS['TL_LANG']['FMD']['immoConnector']['objectType'] = 'Objekt-Art';
$GLOBALS['TL_LANG']['FMD']['immoConnector']['zipCode'] = 'PLZ';
$GLOBALS['TL_LANG']['FMD']['immoConnector']['city'] = 'Ort';
$GLOBALS['TL_LANG']['FMD']['immoConnector']['keyword'] = 'Stichwort';
$GLOBALS['TL_LANG']['FMD']['immoConnector']['search'] = 'Suchen';
$GLOBALS['TL_LANG']['FMD']['immoConnector']['noObjects'] = 'Leider wurden keine Objekte gefunden.';

$GLOBALS['TL_LANG']['FMD']['immoConnector']['all'] = 'Alle';
$GLOBALS['TL_LANG']['FMD']['immoConnector']['houseRent'] = 'Haus zur Miete';
$GLOBALS['TL_LANG']['FMD']['immoConnector']['houseBuy'] = 'Haus zum Kauf';
$GLOBALS['TL_LANG']['FMD']['immoConnector']['apartmentRent'] = 'Wohnung zur Miete';
$GLOBALS['TL_LANG']['FMD']['immoConnector']['apartmentBuy'] = 'Wohnung zum Kauf';
$GLOBALS['TL_LANG']['FMD']['immoConnector']['investment'] = 'Investitionsobjekt';
$GLOBALS['TL_LANG']['FMD']['immoConnector']['livingBuySite'] = 'Grundstück zum Kauf';

$GLOBALS['TL_LANG']['FMD']['immoConnector']['plotArea'] = 'Grundstück';
$GLOBALS['TL_LANG']['FMD']['immoConnector']['livingSpace'] = 'Wohnfläche';
$GLOBALS['TL_LANG']['FMD']['immoConnector']['numberOfRooms'] = 'Anzahl Zimmer';
$GLOBALS['TL_LANG']['FMD']['immoConnector']['buyPrice'] = 'Kaufpreis';
$GLOBALS['TL_LANG']['FMD']['immoConnector']['EUR'] = '€';
$GLOBALS['TL_LANG']['FMD']['immoConnector']['rentPrice'] = 'Kaltmiete';
$GLOBALS['TL_LANG']['FMD']['immoConnector']['builtInKitchen'] = 'Einbauküche';
$GLOBALS['TL_LANG']['FMD']['immoConnector']['yes'] = 'Ja';
$GLOBALS['TL_LANG']['FMD']['immoConnector']['no'] = 'Nein';
$GLOBALS['TL_LANG']['FMD']['immoConnector']['netFloorSpace'] = 'Nettofläche';

/* Immobilien-ENUMS */
$GLOBALS['TL_LANG']['FMD']['immoConnector']['lodgerFlat'] = array('YES' => 'Ja', 'NOT_APPLICABLE' => 'Keine Angabe');
$GLOBALS['TL_LANG']['FMD']['immoConnector']['constructionPhase'] = array('PROJECTED' => 'Haus in Planung', 'UNDER_CONSTRUCTION' => 'Haus im Bau', 'COMPLETED ' => 'Fertiggestellt', 'NO_INFORMATION' => 'Keine Angabe');
$GLOBALS['TL_LANG']['FMD']['immoConnector']['buildingType'] = array('SINGLE_FAMILY_HOUSE ' => 'Einfamilienhaus', 'MID_TERRACE_HOUSE' => 'Reihenmittelhaus', 'END_TERRACE_HOUSE' => 'Reiheneckhaus', 'NO_INFORMATION ' => 'Keine Angabe', 'MULTI_FAMILY_HOUSE' => 'Mehrfamilienhaus', 'BUNGALOW' => 'Bungalow', 'FARMHOUSE' => 'Bauernhaus', 'SEMIDETACHED_HOUSE' =>'Doppelhaushaelfte', 'VILLA' => 'Villa', 'CASTLE_MANOR_HOUSE' => 'Burg / Schloss', 'SPECIAL_REAL_ESTATE' => 'Besondere Immobilie', 'OTHER' => 'Andere');
$GLOBALS['TL_LANG']['FMD']['immoConnector']['cellar'] = array('YES' => 'Ja', 'NOT_APPLICABLE' => 'Keine Angabe');
$GLOBALS['TL_LANG']['FMD']['immoConnector']['handicappedAccessible'] = array('YES' => 'Ja', 'NOT_APPLICABLE' => 'Keine Angabe');
$GLOBALS['TL_LANG']['FMD']['immoConnector']['condition'] = array('FIRST_TIME_USE' => 'Erstbezug', 'NO_INFORMATION' => 'Keine Angabe', 'FIRST_TIME_USE_AFTER_REFURBISHMENT' => 'Erstbezug nach Sanierung', 'MINT_CONDITION ' => 'Neuwertig', 'REFURBISHED' => 'Saniert', 'MODERNIZED' => 'Modernisiert', 'FULLY_RENOVATED ' => 'Vollständig Reonviert', 'WELL_KEPT' => 'Gepflegt', 'NEED_OF_RENOVATION' => 'Renovierungsbedürftig', 'NEGOTIABLE' => 'Nach Vereinbarung', 'RIPE_FOR_DEMOLITION' => 'Abbruchreif');
$GLOBALS['TL_LANG']['FMD']['immoConnector']['interiorQuality'] = array('LUXURY' => 'Luxus', 'NO_INFORMATION' => 'Keine Angabe', 'NORMAL' => 'Normal', 'SOPHISTICATED' => 'Gehoben', 'SIMPLE' => 'Einfach');
$GLOBALS['TL_LANG']['FMD']['immoConnector']['heatingType'] = array('SELF_CONTAINED_CENTRAL_HEATING' => 'Etagenheizung', 'NO_INFORMATION' => 'Keine Angabe', 'STOVE_HEATING' => 'Ofenheizung', 'CENTRAL_HEATING' => 'Zentralheizung');
$GLOBALS['TL_LANG']['FMD']['immoConnector']['firingTypes'] = array('GEOTHERMAL' => 'Erdwärme', 'NO_INFORMATION' => 'Keine Angabe', 'SOLAR_HEATING' => 'Solarheizung', 'PELLET_HEATING' => 'Pelletheizung', 'GAS' => 'Gas', 'OIL' => 'Öl', 'DISTRICT_HEATING' => 'Fernwaerme', 'ELECTRICITY' => 'Strom', 'COAL' => 'Kohle');
$GLOBALS['TL_LANG']['FMD']['immoConnector']['handicappedAccessible'] = array('ENERGY_REQUIRED' => 'Bedarfsausweis', 'NO_INFORMATION' => 'Keine Angabe', 'ENERGY_CONSUMPTION' => 'Verbrauchsausweis');
$GLOBALS['TL_LANG']['FMD']['immoConnector']['energyConsumptionContainsWarmWater'] = array('YES' => 'Ja', 'NOT_APPLICABLE' => 'Keine Angabe');
$GLOBALS['TL_LANG']['FMD']['immoConnector']['parkingSpaceType'] = array('GARAGE, OUTSIDE' => 'Außenstellplatz', 'NO_INFORMATION' => 'Keine Angabe', 'CARPORT' => 'Carport', 'UNDERGROUND_GARAGE' => 'Tiefgarage', 'CAR_PARK' => 'Parkhaus');
$GLOBALS['TL_LANG']['FMD']['immoConnector']['rented'] = array('YES' => 'Ja', 'NOT_APPLICABLE' => 'Keine Angabe');
$GLOBALS['TL_LANG']['FMD']['immoConnector']['listed'] = array('YES' => 'Ja', 'NOT_APPLICABLE' => 'Keine Angabe');
$GLOBALS['TL_LANG']['FMD']['immoConnector']['summerResidencePractical'] = array('YES' => 'Ja', 'NOT_APPLICABLE' => 'Keine Angabe');
$GLOBALS['TL_LANG']['FMD']['immoConnector']['hasCourtage'] = array('NO' => 'Nein', 'YES' => 'Ja', 'NOT_APPLICABLE' => 'Keine Angabe');
$GLOBALS['TL_LANG']['FMD']['immoConnector']['guestToilet'] = array('YES' => 'Ja', 'NOT_APPLICABLE' => 'Keine Angabe');
$GLOBALS['TL_LANG']['FMD']['immoConnector']['buildingEnergyRatingType'] = array('NO_INFORMATION' => 'Keine Angabe', 'ENERGY_REQUIRED' => 'Bedarfsausweis', 'ENERGY_CONSUMPTION' => 'Verbrauchsausweis');
$GLOBALS['TL_LANG']['FMD']['immoConnector']['energyPerformanceCertificate'] = array('true' => 'Vorhanden', 'false' => 'Nein');