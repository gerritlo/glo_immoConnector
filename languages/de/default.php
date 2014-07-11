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

/* BE-Texte */
$GLOBALS['TL_LANG']['immoConnector']['registerApplication'] = 'Anwendung zertifizieren';

/* ImmobilienScout-Typen */
$GLOBALS['TL_LANG']['immoConnector']['all'] = 'Alle';
$GLOBALS['TL_LANG']['immoConnector']['apartmentBuy'] = 'Wohnung zum Kauf';
$GLOBALS['TL_LANG']['immoConnector']['apartmentRent'] = 'Wohnung zur Miete';
$GLOBALS['TL_LANG']['immoConnector']['assistedLiving'] = 'Betreutes Wohnen';
$GLOBALS['TL_LANG']['immoConnector']['compulsoryAuction'] = 'Zwangsversteigerung';
$GLOBALS['TL_LANG']['immoConnector']['garageBuy'] = 'Garage zum Kauf';
$GLOBALS['TL_LANG']['immoConnector']['garageRent'] = 'Garage zur Miete';
$GLOBALS['TL_LANG']['immoConnector']['gastronomy'] = 'Gastronomie und Hotel';
$GLOBALS['TL_LANG']['immoConnector']['houseBuy'] = 'Haus zum Kauf';
$GLOBALS['TL_LANG']['immoConnector']['houseRent'] = 'Haus zur Miete';
$GLOBALS['TL_LANG']['immoConnector']['houseType'] = 'Fertig- und Typenhaus';
$GLOBALS['TL_LANG']['immoConnector']['industry'] = 'Gewerbeobjekt';
$GLOBALS['TL_LANG']['immoConnector']['investment'] = 'Anlageimmobilie';
$GLOBALS['TL_LANG']['immoConnector']['livingBuySite'] = 'Wohngrundstück zum Kauf';
$GLOBALS['TL_LANG']['immoConnector']['livingRentSite'] = 'Wohngrundstück zur Miete';
$GLOBALS['TL_LANG']['immoConnector']['office'] = 'Büro und Praxis';
$GLOBALS['TL_LANG']['immoConnector']['seniorCare'] = 'Altenpflege';
$GLOBALS['TL_LANG']['immoConnector']['shortTermAccommodation'] = 'Ferienimmobilie';
$GLOBALS['TL_LANG']['immoConnector']['specialPurpose'] = 'Spezialgewerbe';
$GLOBALS['TL_LANG']['immoConnector']['store'] = 'Einzelhandel';
$GLOBALS['TL_LANG']['immoConnector']['tradeSite'] = 'Gewerbegrundstück';

$GLOBALS['TL_LANG']['immoConnector']['objectType'] = 'Objekt-Art';
$GLOBALS['TL_LANG']['immoConnector']['zipCode'] = 'PLZ';
$GLOBALS['TL_LANG']['immoConnector']['city'] = 'Ort';
$GLOBALS['TL_LANG']['immoConnector']['keyword'] = 'Stichwort';
$GLOBALS['TL_LANG']['immoConnector']['search'] = 'Suchen';
$GLOBALS['TL_LANG']['immoConnector']['noObjects'] = 'Leider wurden keine Objekte gefunden.';
$GLOBALS['TL_LANG']['immoConnector']['sendRequestForm'] = 'Immobilienanfrage senden';
$GLOBALS['TL_LANG']['immoConnector']['noObjectFound'] = "Es wurde keine Immobilie gefunden.";

$GLOBALS['TL_LANG']['immoConnector']['plotArea'] = 'Grundstück';
$GLOBALS['TL_LANG']['immoConnector']['livingSpace'] = 'Wohnfläche';
$GLOBALS['TL_LANG']['immoConnector']['numberOfRooms'] = 'Anzahl Zimmer';
$GLOBALS['TL_LANG']['immoConnector']['buyPrice'] = 'Kaufpreis';
$GLOBALS['TL_LANG']['immoConnector']['EUR'] = '€';
$GLOBALS['TL_LANG']['immoConnector']['rentPrice'] = 'Kaltmiete';
$GLOBALS['TL_LANG']['immoConnector']['builtInKitchen'] = 'Einbauküche';
$GLOBALS['TL_LANG']['immoConnector']['yes'] = 'Ja';
$GLOBALS['TL_LANG']['immoConnector']['no'] = 'Nein';
$GLOBALS['TL_LANG']['immoConnector']['netFloorSpace'] = 'Nettofläche';

/* Immobilien-ENUMS */
$GLOBALS['TL_LANG']['immoConnector']['lodgerFlat'] = array('YES' => 'Ja', 'NOT_APPLICABLE' => 'Keine Angabe');
$GLOBALS['TL_LANG']['immoConnector']['constructionPhase'] = array('PROJECTED' => 'Haus in Planung', 'UNDER_CONSTRUCTION' => 'Haus im Bau', 'COMPLETED ' => 'Fertiggestellt', 'NO_INFORMATION' => 'Keine Angabe');
$GLOBALS['TL_LANG']['immoConnector']['buildingType'] = array('SINGLE_FAMILY_HOUSE ' => 'Einfamilienhaus', 'MID_TERRACE_HOUSE' => 'Reihenmittelhaus', 'END_TERRACE_HOUSE' => 'Reiheneckhaus', 'NO_INFORMATION ' => 'Keine Angabe', 'MULTI_FAMILY_HOUSE' => 'Mehrfamilienhaus', 'BUNGALOW' => 'Bungalow', 'FARMHOUSE' => 'Bauernhaus', 'SEMIDETACHED_HOUSE' =>'Doppelhaushaelfte', 'VILLA' => 'Villa', 'CASTLE_MANOR_HOUSE' => 'Burg / Schloss', 'SPECIAL_REAL_ESTATE' => 'Besondere Immobilie', 'OTHER' => 'Andere');
$GLOBALS['TL_LANG']['immoConnector']['cellar'] = array('YES' => 'Ja', 'NOT_APPLICABLE' => 'Keine Angabe');
$GLOBALS['TL_LANG']['immoConnector']['handicappedAccessible'] = array('YES' => 'Ja', 'NOT_APPLICABLE' => 'Keine Angabe');
$GLOBALS['TL_LANG']['immoConnector']['condition'] = array('FIRST_TIME_USE' => 'Erstbezug', 'NO_INFORMATION' => 'Keine Angabe', 'FIRST_TIME_USE_AFTER_REFURBISHMENT' => 'Erstbezug nach Sanierung', 'MINT_CONDITION ' => 'Neuwertig', 'REFURBISHED' => 'Saniert', 'MODERNIZED' => 'Modernisiert', 'FULLY_RENOVATED ' => 'Vollständig Reonviert', 'WELL_KEPT' => 'Gepflegt', 'NEED_OF_RENOVATION' => 'Renovierungsbedürftig', 'NEGOTIABLE' => 'Nach Vereinbarung', 'RIPE_FOR_DEMOLITION' => 'Abbruchreif');
$GLOBALS['TL_LANG']['immoConnector']['interiorQuality'] = array('LUXURY' => 'Luxus', 'NO_INFORMATION' => 'Keine Angabe', 'NORMAL' => 'Normal', 'SOPHISTICATED' => 'Gehoben', 'SIMPLE' => 'Einfach');
$GLOBALS['TL_LANG']['immoConnector']['heatingType'] = array('SELF_CONTAINED_CENTRAL_HEATING' => 'Etagenheizung', 'NO_INFORMATION' => 'Keine Angabe', 'STOVE_HEATING' => 'Ofenheizung', 'CENTRAL_HEATING' => 'Zentralheizung');
$GLOBALS['TL_LANG']['immoConnector']['firingTypes'] = array('GEOTHERMAL' => 'Erdwärme', 'NO_INFORMATION' => 'Keine Angabe', 'SOLAR_HEATING' => 'Solarheizung', 'PELLET_HEATING' => 'Pelletheizung', 'GAS' => 'Gas', 'OIL' => 'Öl', 'DISTRICT_HEATING' => 'Fernwaerme', 'ELECTRICITY' => 'Strom', 'COAL' => 'Kohle');
$GLOBALS['TL_LANG']['immoConnector']['handicappedAccessible'] = array('ENERGY_REQUIRED' => 'Bedarfsausweis', 'NO_INFORMATION' => 'Keine Angabe', 'ENERGY_CONSUMPTION' => 'Verbrauchsausweis');
$GLOBALS['TL_LANG']['immoConnector']['energyConsumptionContainsWarmWater'] = array('YES' => 'Ja', 'NOT_APPLICABLE' => 'Keine Angabe');
$GLOBALS['TL_LANG']['immoConnector']['parkingSpaceType'] = array('GARAGE, OUTSIDE' => 'Außenstellplatz', 'NO_INFORMATION' => 'Keine Angabe', 'CARPORT' => 'Carport', 'UNDERGROUND_GARAGE' => 'Tiefgarage', 'CAR_PARK' => 'Parkhaus');
$GLOBALS['TL_LANG']['immoConnector']['rented'] = array('YES' => 'Ja', 'NOT_APPLICABLE' => 'Keine Angabe');
$GLOBALS['TL_LANG']['immoConnector']['listed'] = array('YES' => 'Ja', 'NOT_APPLICABLE' => 'Keine Angabe');
$GLOBALS['TL_LANG']['immoConnector']['summerResidencePractical'] = array('YES' => 'Ja', 'NOT_APPLICABLE' => 'Keine Angabe');
$GLOBALS['TL_LANG']['immoConnector']['hasCourtage'] = array('NO' => 'Nein', 'YES' => 'Ja', 'NOT_APPLICABLE' => 'Keine Angabe');
$GLOBALS['TL_LANG']['immoConnector']['guestToilet'] = array('YES' => 'Ja', 'NOT_APPLICABLE' => 'Keine Angabe');
$GLOBALS['TL_LANG']['immoConnector']['buildingEnergyRatingType'] = array('NO_INFORMATION' => 'Keine Angabe', 'ENERGY_REQUIRED' => 'Bedarfsausweis', 'ENERGY_CONSUMPTION' => 'Verbrauchsausweis');
$GLOBALS['TL_LANG']['immoConnector']['energyPerformanceCertificate'] = array('true' => 'Vorhanden', 'false' => 'Nein');
$GLOBALS['TL_LANG']['immoConnector']['shortTermConstructible'] = array('true' => 'Ja', 'false' => 'Nein');
$GLOBALS['TL_LANG']['immoConnector']['buildingPermission'] = array('true' => 'Vorhanden', 'false' => 'Nicht vorhanden');
$GLOBALS['TL_LANG']['immoConnector']['demolition'] = array('true' => 'Erforderlich', 'false' => 'Nicht erforderlich');
$GLOBALS['TL_LANG']['immoConnector']['siteDevelopmentType'] = array('DEVELOPED' => 'Erschlossen', 'DEVELOPED_PARTIALLY' => 'Teilerschlossen', 'NOT_DEVELOPED' => 'Unerschlossen');
$GLOBALS['TL_LANG']['immoConnector']['siteConstructibleType'] = array('CONSTRUCTIONPLAN' => 'Bebauung nach Bebauungsplan', 'NEIGHBOURCONSTRUCTION' => 'Nachbarbebauung', 'EXTERNALAREA' => 'Aussengebiet');
$GLOBALS['TL_LANG']['immoConnector']['heatingCostsInServiceCharge'] = array('YES' => 'Ja', 'NOT_APPLICABLE' => 'Keine Angabe', 'NO' => 'Nein');
$GLOBALS['TL_LANG']['immoConnector']['petsAllowed'] = array('YES' => 'Ja', 'NOT_INFORMATION' => 'Keine Angabe', 'NO' => 'Nein', 'NEGOTIABLE' => 'Verhandelbar');
$GLOBALS['TL_LANG']['immoConnector']['builtInKitchen'] = array('true' => 'Vorhanden', 'false' => 'Nicht vorhanden');
$GLOBALS['TL_LANG']['immoConnector']['apartmentType'] = array('NO_INFORMATION' => 'Kein Angabe', 'ROOF_STOREY' => 'Dachgeschoss', 'LOFT' => 'Loft', 'MAISONETTE' => 'Maisonette', 'PENTHOUSE' => 'Penthouse', 'TERRACED_FLAT' => 'Terrassenwohnung', 'GROUND_FLOOR', 'Erdgeschosswohnung', 'APARTMENT' => 'Etagenwohnung', 'RAISED_GROUND_FLOOR' => 'Hochparterre', 'HALF_BASEMENT' => 'Souterrain', 'OTHER' => 'Sonstige');
$GLOBALS['TL_LANG']['immoConnector']['lift'] = array('true' => 'Ja', 'false' => 'Nein');
$GLOBALS['TL_LANG']['immoConnector']['balcony'] = array('true' => 'Ja', 'false' => 'Nein');
$GLOBALS['TL_LANG']['immoConnector']['garden'] = array('true' => 'Ja', 'false' => 'Nein');
$GLOBALS['TL_LANG']['immoConnector']['certificateOfEligibilityNeeded'] = array('true' => 'Ja', 'false' => 'Nein');
$GLOBALS['TL_LANG']['immoConnector']['investmentType'] = array('SINGLE_FAMILY_HOUSE' => 'Einfamilienhaus', 'MULTI_FAMILY_HOUSE' => 'Mehrfamilienhaus', 'FREEHOLD_FLAT' => 'Eigentumswohnung', 'SHOPPING_CENTRE' => 'Einkaufszentrum', 'RESTAURANT' => 'Restaurant', 'HOTEL' => 'Hotel', 'LEISURE_FACILITY' => 'Freizeitanlage', 'COMMERCIAL_UNIT' => 'Gewerbeeinheit', 'OFFICE_BUILDING' => 'Bürogebäude', 'COMMERCIAL_BUILDING' => 'Gewerbeimmobilie', 'COMMERCIAL_PROPERTY' => 'Gewerbegrundstück', 'HALL_STORAGE' => 'Halle/Lager', 'INDUSTRIAL_PROPERTY' => 'Industrieanwesen', 'SHOP_SALES_FLOOR' => 'Laden/Verkaufsfläche', 'SERVICE_CENTRE' => 'Servicecenter', 'OTHER' => 'Sonstige', 'SUPERMARKET' => 'Supermarkt', 'LIVING_BUSINESS_HOUSE' => 'Wohn/Geschäftshaus', 'HOUSING_ESTATE' => 'Wohnanlage');
