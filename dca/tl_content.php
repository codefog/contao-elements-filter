<?php

/**
 * Global callbacks
 */
$GLOBALS['TL_DCA']['tl_content']['config']['onload_callback'][] = [
    'ElementsFilter\EventListener\ContentDataContainer',
    'adjustPalettes',
];

/**
 * Add fields
 */
$GLOBALS['TL_DCA']['tl_content']['fields']['elementsFilter_filter'] = [
    'label'            => &$GLOBALS['TL_LANG']['tl_content']['elementsFilter_filter'],
    'exclude'          => true,
    'inputType'        => 'select',
    'options_callback' => ['ElementsFilter\EventListener\ContentDataContainer', 'getFilters'],
    'eval'             => ['includeBlankOption' => true, 'tl_class' => 'clr'],
    'sql'              => "varchar(255) NOT NULL default ''",
];
