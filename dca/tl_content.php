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
$GLOBALS['TL_DCA']['tl_content']['fields']['elementsFilter_filters'] = [
    'label'            => &$GLOBALS['TL_LANG']['tl_content']['elementsFilter_filters'],
    'exclude'          => true,
    'inputType'        => 'checkbox',
    'options_callback' => ['Codefog\ElementsFilter\EventListener\ContentDataContainer', 'getFilters'],
    'eval'             => ['multiple' => true, 'tl_class' => 'clr'],
    'sql'              => "blob NULL",
];
